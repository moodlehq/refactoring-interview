<?php

namespace MyApp\Models\Role;

/**
 * User Role
 *
 * Role of a user within the system.
 */
class Role {

    /**
     * @var string name of the role.
     */
    private string $roleName = '';

    /**
     * Role constructor.
     *
     * @param string $roleName The name of the role.
     */
    public function __construct(string $roleName) {
        $this->roleName = $roleName;
    }

    /**
     * Get the name of the role as string.
     *
     * @return int Get the name of the role as string.
     */
    public function getRoleName(): string {
        return $this->roleName;
    }

    /**
     * Get the name of the role as string.
     *
     * @return string Get the name of the role as string.
     */
    public function __toString(): string {
        return $this->roleName;
    }
}
