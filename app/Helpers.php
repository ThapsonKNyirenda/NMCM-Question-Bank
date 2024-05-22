<?php

use App\Services\ActivityLogService;
use Illuminate\Support\Str;

function get_user_management_permissions(): array
{
    return  [
        'Assign permissions',
        'Assign roles',
        'Manage roles',
        'Manage users'
    ];
}

function get_customer_management_permissions(): array
{
    return  [
        'Add contacts',
        'Update contacts',
        'Views contacts',
        'Delete contacts',
        'Add customers',
        'Update customers',
        'Views customers',
        'Delete customers',
    ];
}


if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogService
    {
        $defaultLogName = 'default';

        return app(ActivityLogService::class)
            ->useLog($logName ?? $defaultLogName);
    }
}

function str_acronym(?string $str, $delimiter = ''): string
{
    if (empty($str)) {
        return '';
    }

    $acronym = '';
    foreach (preg_split('/[^\p{L}]+/u', $str) as $word) {
        if(!empty($word) && Str::length($word) > 2){
                $first_letter = mb_substr($word, 0, 1);
                $acronym .= $first_letter . $delimiter;
        }
    }

    return $acronym;
}
