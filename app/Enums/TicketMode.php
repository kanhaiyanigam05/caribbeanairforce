<?php

namespace App\Enums;

enum TicketMode: string
{
    case OFFLINE = 'offline';
    case ONLINE = 'online';
}
