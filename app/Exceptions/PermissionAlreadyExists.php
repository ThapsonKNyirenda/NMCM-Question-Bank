<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionAlreadyExists extends \InvalidArgumentException
{
    public static function create(string $permissionName): PermissionAlreadyExists
    {
        return new static("A '{$permissionName}' permission already exists.");
    }
}
