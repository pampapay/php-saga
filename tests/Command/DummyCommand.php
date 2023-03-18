<?php

namespace Pampapay\PhpSaga\Tests\Command;

use Pampapay\PhpSaga\Command\CommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;
use Pampapay\PhpSaga\Tests\Dto\TestParamsDto;

class DummyCommand implements CommandInterface
{
    public function __invoke(CommandParamsInterface $params)
    {
        /** @var TestParamsDto $params */
        $params->increaseCounter();
    }
}