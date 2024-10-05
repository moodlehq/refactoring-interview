<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\UserFactory;
use MyApp\Models\User\User;
use MyApp\Models\Role\Role;
use MyApp\Models\Course\Course;

class UserFactoryTest extends TestCase
{
    /**
     * Test creating a User object from valid data.
     */
    public function testCreateUserWithValidData()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'id' => 1,
            'roles' => [
                ['roleName' => 'Admin'],
                ['roleName' => 'Instructor']
            ],
            'courses' => [
                ['id' => 101, 'name' => 'Math 101', 'location' => 'Room 1'],
                ['id' => 102, 'name' => 'Science 101', 'location' => 'Room 2']
            ]
        ];

        // Act
        $user = UserFactory::createUser($userData);

        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertCount(2, $user->getRoles());
        $this->assertCount(2, $user->getCourses());
    }

    /**
     * Test creating a User object with missing roles.
     */
    public function testCreateUserWithNoRoles()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'id' => 1,
            'roles' => [],
            'courses' => []
        ];

        // Act
        $user = UserFactory::createUser($userData);

        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertCount(0, $user->getRoles());
        $this->assertCount(0, $user->getCourses());
    }

    /**
     * Test creating a User object with no courses.
     */
    public function testCreateUserWithNoCourses()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'id' => 1,
            'roles' => [['roleName' => 'Admin']],
            'courses' => []
        ];

        // Act
        $user = UserFactory::createUser($userData);

        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertCount(1, $user->getRoles());
        $this->assertCount(0, $user->getCourses());
    }
}
