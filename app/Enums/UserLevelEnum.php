<?php

namespace App\Enums;

enum UserLevelEnum: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case MARKETING = 'marketing';
    case FINANCE = 'finance';
}