<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionGroup: string
{
    use EnumToArray;

    case UserManagement = 'User Management';
    case EmployeeManagement = 'Employee Management';
    case CustomerManagement = 'CustomerManagement';
    case TicketCategories = 'TicketCategories';
    case EmailTemplate = 'Email Templates';
}
