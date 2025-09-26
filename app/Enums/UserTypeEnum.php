<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case CLIENT = 'client';
    case ADMIN = 'admin';
}