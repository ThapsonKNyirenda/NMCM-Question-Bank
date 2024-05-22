<?php

namespace App\Exceptions;

use InvalidArgumentException;

class RoleDoesNotExist extends InvalidArgumentException
{
    /**
     * @param string $roleName
     *
     * @return RoleDoesNotExist
     */
    public static function named(string $roleName): RoleDoesNotExist
    {
        return new static("There is no role named '{$roleName}'.");
    }

    /**
     * @param int $roleId
     * @return RoleDoesNotExist
     */
    public static function withId(int $roleId): RoleDoesNotExist
    {
        return new static("There is no role with id '{$roleId}'.");
    }
}
