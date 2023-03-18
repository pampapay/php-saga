<?php

namespace Pampapay\PhpSaga\Tests\Dto;

use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class TestParamsDto implements CommandParamsInterface
{
    private int $counter = 0;

    private int $errorCounter = 0;

    public function increaseCounter(): self
    {
        $this->counter++;

        return $this;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function increaseErrorCount(): self
    {
        $this->errorCounter++;

        return $this;
    }

    public function getErrorCounter(): int
    {
        return $this->errorCounter;
    }
}