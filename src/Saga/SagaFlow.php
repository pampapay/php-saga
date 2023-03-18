<?php

namespace Pampapay\PhpSaga\Saga;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;
use Pampapay\PhpSaga\Step\Step;

class SagaFlow
{
    /** @var ArrayCollection */
    private Collection $steps;

    private Collection $compensationSteps;

    private ?Step $currenStep = null;

    public function getCurrenStep(): ?Step
    {
        return $this->currenStep;
    }

    public function __construct(Collection $steps)
    {
        $this->steps = $steps;
        $this->compensationSteps = new ArrayCollection();
    }

    public function invoke(CommandParamsInterface $params): void
    {
        /** @var Step $step */
        foreach ($this->steps->getIterator() as $step) {
            $this->compensationSteps->add($step);
            $this->currenStep = $step;

            $step->invoke($params);
        }
    }

    public function compensate(CommandParamsInterface $params)
    {
        /** @var Step $step */
        foreach(array_reverse($this->compensationSteps->toArray()) as $step) {
            $step->compensate($params);
        }
    }
}