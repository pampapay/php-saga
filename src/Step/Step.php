<?php

namespace Pampapay\PhpSaga\Step;

use Pampapay\PhpSaga\Command\CommandInterface;
use Pampapay\PhpSaga\Command\CompensationCommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class Step
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    private ?CommandInterface $invocation = null;
    private ?CompensationCommandInterface $compensation = null;

    public function __construct(string $name = '')
    {
        $this->name = $name;
    }

    public function setInvocation(CommandInterface $command): void
    {
        $this->invocation = $command;
    }

    public function setCompensation(CompensationCommandInterface $command)
    {
        $this->compensation = $command;
    }

    public function invoke(CommandParamsInterface $params)
    {
        if(null !== $this->invocation) {
            $this->invocation->__invoke($params);
        }
    }

    public function compensate(CommandParamsInterface $params)
    {
        if(null !== $this->compensation) {
            $this->compensation->__invoke($params);
        }
    }
}