<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionGroup: string
{
    use EnumToArray;

    case UserManagement = 'User Management';
    case Questions = 'Questions';
    case QuestionBank = 'Question Bank';

    
}