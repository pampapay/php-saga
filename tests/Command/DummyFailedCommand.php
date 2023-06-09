<?php

namespace Pampapay\PhpSaga\Tests\Command;

use Pampapay\PhpSaga\Command\CommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class DummyFailedCommand implements CommandInterface
{

    public function __invoke(CommandParamsInterface $params)
    {
        throw new \LogicException('Simulating error');
    }
}