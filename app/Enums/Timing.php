<?php

namespace App\Enums;

enum Timing: string
{
    case SINGLE = 'single';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case CUSTOM = 'custom';
}
