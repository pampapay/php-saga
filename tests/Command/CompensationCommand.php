<?php

namespace Pampapay\PhpSaga\Tests\Command;

use Pampapay\PhpSaga\Command\CompensationCommandInterface;
use Pampapay\PhpSaga\Parameters\CommandParamsInterface;
use Pampapay\PhpSaga\Tests\Dto\TestParamsDto;

class CompensationCommand implements CompensationCommandInterface
{

    public function __invoke(CommandParamsInterface $params)
    {
        /** @var TestParamsDto $params */

        $params->increaseErrorCount();
    }
}