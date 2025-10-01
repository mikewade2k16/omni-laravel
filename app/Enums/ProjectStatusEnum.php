<?php

namespace App\Enums;

enum ProjectStatusEnum: string
{
    case NOT_STARTED = 'not_started';
    case RAW = 'raw';
    case STARTED = 'started';
    case IN_PROGRESS = 'in_progress';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case COMPLETED = 'completed';
    case POSTPONED = 'postponed';
    case CANCELED = 'canceled';
}