<?php

namespace App\Enum\Subscription;

enum Status: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
}