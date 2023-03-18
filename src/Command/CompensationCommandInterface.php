<?php

namespace Pampapay\PhpSaga\Command;

use Pampapay\PhpSaga\Parameters\CommandParamsInterface;

interface CompensationCommandInterface
{
    public function __invoke(CommandParamsInterface $params);
}