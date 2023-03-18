<?php

namespace Pampapay\PhpSaga\Saga;

use Pampapay\PhpSaga\Exception\SagaCompensationFailed;
use Pampapay\PhpSaga\Exception\SagaExecutionFailed;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class Saga
{
    private string $state;

    private \Exception $invokeError;

    private \Exception $compensationError;


    public function getState(): string
    {
        return $this->state;
    }

    public function getInvokeError(): \Exception
    {
        return $this->invokeError;
    }

    public function getCompensationError(): \Exception
    {
        return $this->compensationError;
    }

    public function __construct(private readonly SagaFlow $sagaFlow)
    {
        $this->state = 'new';
    }

    public function execute(CommandParamsInterface $params)
    {
        $this->state = SagaStatesEnum::IN_PROGRESS;

        try {
            $this->sagaFlow->invoke($params);
            $this->state = SagaStatesEnum::COMPLETE;

            return $params;
        } catch (\Exception $e) {
            $this->state = SagaStatesEnum::IN_COMPENSATION;
            $this->invokeError = $e;

            $this->runCompensationFlow($params);

            throw new SagaExecutionFailed(
                sprintf(
                    'Error executing saga on step \'%s\'. Saga result: %s',
                    $this->sagaFlow->getCurrenStep()->getName(),
                    $this->getState()
                ),
                0,
                $e
            );
        }
    }

    private function runCompensationFlow(CommandParamsInterface $params): void
    {
        try {
            $this->sagaFlow->compensate($params);

            $this->state = SagaStatesEnum::COMPENSATION_COMPLETE;
        } catch (\Exception $e) {
            $this->state = SagaStatesEnum::COMPENSATION_ERROR;
            $this->compensationError = $e;

            throw new SagaCompensationFailed(
                'Error executing compensation',
                0,
                $e
            );
        }
    }
}