<?php

namespace Pampapay\PhpSaga\Tests\Command;

use Pampapay\PhpSaga\Command\CompensationCommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

class CompensationCommand implements CompensationCommandInterface
{

    public function __invoke(CommandParamsInterface $params)
    {
        echo 'Do something with the compensation';
    }
}