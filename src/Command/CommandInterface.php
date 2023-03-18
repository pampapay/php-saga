<?php

namespace Pampapay\PhpSaga\Command;

use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

interface CommandInterface
{
    public function __invoke(CommandParamsInterface $params);
}