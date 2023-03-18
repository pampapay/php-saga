<?php

namespace Pampapay\PhpSaga\Tests;

use Pampapay\PhpSaga\SagaBuilder;
use Pampapay\PhpSaga\Tests\Command\CompensationCommand;
use Pampapay\PhpSaga\Tests\Command\HttpRequestCommand;
use Pampapay\PhpSaga\Tests\Command\LogCommand;
use Pampapay\PhpSaga\Tests\Dto\TestParamsDto;
use PHPUnit\Framework\TestCase;

class SagaTest extends TestCase
{
    public function testSomething(): void
    {
        $sagaBuilder = new SagaBuilder();

        $saga = $sagaBuilder
            ->step('Step 1')
                ->invoke(new HttpRequestCommand())
                ->withCompensation(new CompensationCommand())
            ->step('Step 2')
                ->invoke(new LogCommand())
            ->build();

        $saga->execute(new TestParamsDto());
    }
}
