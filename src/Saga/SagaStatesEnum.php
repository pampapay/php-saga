<?php

namespace Pampapay\PhpSaga\Saga;

enum SagaStatesEnum
{
    const NEW = 'new';

    const IN_PROGRESS = 'in_progress';

    const IN_COMPENSATION = 'in_compensation';

    const COMPLETE =  'complete';

    const COMPENSATION_COMPLETE = 'compensation_complete';

    const COMPENSATION_ERROR = 'compensation_error';
}
