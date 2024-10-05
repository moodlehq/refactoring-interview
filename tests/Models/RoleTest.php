<?php

namespace MyApp\Tests\Models\Role;

use MyApp\Models\Role\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    private Role $role;

    protected function setUp(): void
    {
        // Create a Role object for testing
        $this->role = new Role("Admin");
    }

    public function testGetRoleName(): void
    {
        $this->assertSame("Admin", $this->role->getRoleName());
    }

    public function testToString(): void
    {
        $this->assertSame("Admin", (string) $this->role);
    }
}
