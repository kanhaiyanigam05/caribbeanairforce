<?php

namespace App\Enums;

enum Proof: string
{
    case UTILITY = 'utility_bill';
    case BANK = 'bank_statement';
    case PASSPORT = 'passport';
}
