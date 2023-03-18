<?php

namespace Pampapay\PhpSaga\Tests\Command;

use Pampapay\PhpSaga\Command\CommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class LogCommand implements CommandInterface
{

    public function __invoke(CommandParamsInterface $params)
    {
        echo 'Add log here';
    }
}