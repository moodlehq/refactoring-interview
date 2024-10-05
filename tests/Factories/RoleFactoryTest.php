<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\RoleFactory;
use MyApp\Models\Role\Role;

class RoleFactoryTest extends TestCase
{
    /**
     * Test that a valid role is created from the data array.
     */
    public function testCreateRoleWithValidData()
    {
        // Arrange
        $roleData = [
            'roleName' => 'Administrator'
        ];

        // Act
        $role = RoleFactory::createRole($roleData);

        // Assert
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals('Administrator', $role->getRoleName());
    }

    /**
     * Test that the factory throws an error if the role name is missing.
     */
    public function testCreateRoleWithMissingRoleName()
    {
        // Arrange
        $roleData = [
            // 'roleName' is missing
        ];

        // Expect an exception to be thrown due to missing role name
        $this->expectException(\Error::class);

        // Act
        RoleFactory::createRole($roleData);
    }

    /**
     * Test that the factory handles an empty data array.
     */
    public function testCreateRoleWithEmptyData()
    {
        // Arrange
        $roleData = [];

        // Expect an exception to be thrown due to missing role name
        $this->expectException(\Error::class);

        // Act
        RoleFactory::createRole($roleData);
    }
}
