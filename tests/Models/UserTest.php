<?php

use PHPUnit\Framework\TestCase;
use MyApp\Models\User\User;
use MyApp\Models\Role\Role;
use MyApp\Models\Course\Course;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        // Initialize a User object for testing
        $this->user = new User('John Doe', [new Role('Student')], 'john@example.com');
    }

    // Test the constructor and getter methods
    public function testUserCreation()
    {
        // Assert that the name is set correctly
        $this->assertEquals('John Doe', $this->user->getName());

        // Assert that the email is set correctly
        $this->assertEquals('john@example.com', $this->user->getEmail());

        // Assert that roles are set correctly
        $this->assertEquals(['Student'], $this->user->getRoles());
    }

    // Test adding and retrieving courses
    public function testAddCourse()
    {
        $course = new Course(1, 'Math', null);
        $this->user->addCourse($course);

        // Assert that the course is added correctly
        $this->assertCount(1, $this->user->getCourses());
        $this->assertEquals($course, $this->user->getCourses()[0]);
    }

    // Test toArray method
    public function testToArray()
    {
        $expectedArray = [
            'name' => 'John Doe',
            'role' => ['Student'],
            'email' => 'john@example.com',
            'courses' => []
        ];

        // Assert that toArray method returns the expected array
        $this->assertEquals($expectedArray, $this->user->toArray());
    }

    // Test __toString method
    public function testToString()
    {
        // Assert that the string representation of the user is correct
        $this->assertEquals('John Doe (Student)', (string)$this->user);
    }
}
