<?php

namespace Pampapay\PhpSaga;

use Doctrine\Common\Collections\Collection;
use Pampapay\PhpSaga\Saga\Saga;
use Pampapay\PhpSaga\Saga\SagaFlow;
use Pampapay\PhpSaga\Step\Step;


class Factory
{

    public function createSaga(Collection $steps): Saga
    {
        return new Saga($this->createSagaFlow($steps));
    }

    private function createSagaFlow(Collection $steps): SagaFlow
    {
        return new SagaFlow($steps);
    }

    public function createStep(string $name): Step
    {
        return new Step($name);
    }
}