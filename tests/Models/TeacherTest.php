<?php

use PHPUnit\Framework\TestCase;
use MyApp\Models\User\Teacher;
use MyApp\Models\Role\Role;
use MyApp\Models\Course\Course;

class TeacherTest extends TestCase
{
    private Teacher $teacher;

    protected function setUp(): void
    {
        // Initialize a Teacher object for testing
        $this->teacher = new Teacher('Jane Smith', 'jane@example.com', 1001);
    }

    // Test the constructor and getter methods
    public function testTeacherCreation()
    {
        // Assert that the name is set correctly
        $this->assertEquals('Jane Smith', $this->teacher->getName());

        // Assert that the email is set correctly
        $this->assertEquals('jane@example.com', $this->teacher->getEmail());

        // Assert that the employee ID is set correctly
        $this->assertEquals(1001, $this->teacher->getEmployeeId());

        // Assert that the role is set correctly
        $this->assertEquals(['Teacher'], $this->teacher->getRoles());
    }

    // Test assigning and retrieving courses
    public function testAssignCourse()
    {
        $course = new Course(1, 'Science', null);
        $this->teacher->assignCourse($course);

        // Assert that the assigned course is added correctly
        $this->assertCount(1, $this->teacher->getCourses());
        $this->assertEquals($course, $this->teacher->getCourses()[0]);
    }

    // Test toArray method
    public function testToArray()
    {
        $expectedArray = [
            'id' => 1001,
            'email' => 'jane@example.com',
            'name' => 'Jane Smith',
            'role' => ['Teacher']
        ];

        // Assert that toArray method returns the expected array
        $this->assertEquals($expectedArray, $this->teacher->toArray());
    }

    // Test __toString method
    public function testToString()
    {
        // Assert that the string representation of the teacher is correct
        $this->assertEquals('Jane Smith (Teacher) | Employee ID: 1001', (string)$this->teacher);
    }
}
