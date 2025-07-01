<?php

namespace App\Enums;

enum Role: string
{
    case SUPERADMIN = 'superadmin';
    case ORGANIZER = 'organizer';
    case USER = 'user';
}
