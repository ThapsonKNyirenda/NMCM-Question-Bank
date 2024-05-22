<?php

namespace App\Exceptions;

use InvalidArgumentException;

class PermissionDoesNotExist extends InvalidArgumentException
{
    public static function create(string $permissionName): PermissionDoesNotExist
    {
        return new static("There is no permission named '{$permissionName}'.");
    }

    public static function withId(int $permissionId): PermissionDoesNotExist
    {
        return new static("There is no [permission] with id '{$permissionId}'.");
    }
}
