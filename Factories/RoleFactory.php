<?php

namespace MyApp\Factories;

use MyApp\Models\Role\Role;

/**
 * Class RoleFactory
 *
 * Responsible for creating Role objects from role data arrays.
 */
class RoleFactory {

    /**
     * Create a Role object from an associative array of role data.
     *
     * @param array $roleData The array containing role details like roleName.
     * @return Role The created Role object.
     */
    public static function createRole(array $roleData): Role {
        return new Role($roleData['roleName']);
    }
}