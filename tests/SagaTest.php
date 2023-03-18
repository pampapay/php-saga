<?php

namespace Pampapay\PhpSaga\Tests;

use Pampapay\PhpSaga\Exception\SagaExecutionFailed;
use Pampapay\PhpSaga\SagaBuilder;
use Pampapay\PhpSaga\Tests\Command\CompensationCommand;
use Pampapay\PhpSaga\Tests\Command\DummyCommand;
use Pampapay\PhpSaga\Tests\Command\DummyFailedCommand;
use Pampapay\PhpSaga\Tests\Dto\TestParamsDto;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Test;

class SagaTest extends TestCase
{
    public function test_three_step_without_compensation(): void
    {
        $sagaBuilder = new SagaBuilder();
        $parametersDto = new TestParamsDto();

        $saga = $sagaBuilder
            ->step('Step 1')
                ->invoke(new DummyCommand())
            ->step('Step 2')
                ->invoke(new DummyCommand())
            ->step('Step 3')
                ->invoke(new DummyCommand())
            ->build();

        $saga->execute($parametersDto);

        $this->assertEquals(3, $parametersDto->getCounter());
    }

    public function test_error_on_last_step_and_correct_execution_of_chain_of_compensations(): void
    {
        $sagaBuilder = new SagaBuilder();
        $parametersDto = new TestParamsDto();

        $saga = $sagaBuilder
            ->step('Step 1')
                ->invoke(new DummyCommand())
                ->withCompensation(new CompensationCommand())
            ->step('Step 2')
                ->invoke(new DummyCommand())
                ->withCompensation(new CompensationCommand())
            ->step('Step 3')
                ->invoke(new DummyFailedCommand())
                ->withCompensation(new CompensationCommand())
            ->build();

        try {
            $saga->execute($parametersDto);
        } catch (SagaExecutionFailed $sagaExecutionFailed) {
            $this->assertEquals(
                "Error executing saga on step 'Step 3'. Saga result: compensation_complete",
                $sagaExecutionFailed->getMessage()
            );
        }

        $this->assertEquals(2, $parametersDto->getCounter());
        $this->assertEquals(3, $parametersDto->getErrorCounter());
    }
}
