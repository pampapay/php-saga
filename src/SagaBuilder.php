<?php

namespace Pampapay\PhpSaga;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pampapay\PhpSaga\Command\CommandInterface;
use Pampapay\PhpSaga\Command\CompensationCommandInterface;
use Pampapay\PhpSaga\Saga\Saga;
use Pampapay\PhpSaga\Step\Step;

class SagaBuilder
{
    private Collection $steps;

    private ?Factory $factory;
    private Step $currentStep;

    public function __construct()
    {
        $this->factory = new Factory();
        $this->steps = new ArrayCollection();
    }

    public function build(): Saga
    {
        return $this->factory->createSaga($this->steps);
    }

    public function step(string $name): self
    {
        $this->currentStep = $this->factory->createStep($name);

        $this->steps->add($this->currentStep);

        return $this;
    }

    public function invoke(CommandInterface $command): self
    {
        $this->currentStep->setInvocation($command);

        return $this;
    }

    public function withCompensation(CompensationCommandInterface $command): self
    {
        $this->currentStep->setCompensation($command);

        return $this;
    }
}