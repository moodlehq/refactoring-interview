<?php

use PHPUnit\Framework\TestCase;
use MyApp\Models\User\Student;
use MyApp\Models\Role\Role;
use MyApp\Models\Course\Course;

class StudentTest extends TestCase
{
    private Student $student;

    protected function setUp(): void
    {
        // Initialize a Student object for testing
        $this->student = new Student('Mark Johnson', 'mark@example.com', 2001);
    }

    // Test the constructor and getter methods
    public function testStudentCreation()
    {
        // Assert that the name is set correctly
        $this->assertEquals('Mark Johnson', $this->student->getName());

        // Assert that the email is set correctly
        $this->assertEquals('mark@example.com', $this->student->getEmail());

        // Assert that the student ID is set correctly
        $this->assertEquals(2001, $this->student->getStudentId());

        // Assert that the role is set correctly
        $this->assertEquals(['Student'], $this->student->getRoles());
    }

    // Test enrolling and retrieving courses
    public function testEnrollInCourse()
    {
        $course = new Course(1, 'History', null);
        $this->student->enrollInCourse($course);

        // Assert that the enrolled course is added correctly
        $this->assertCount(1, $this->student->getCourses());
        $this->assertEquals($course, $this->student->getCourses()[0]);
    }

    // Test toArray method
    public function testToArray()
    {
        $expectedArray = [
            'id' => 2001,
            'email' => 'mark@example.com',
            'name' => 'Mark Johnson',
            'role' => ['Student']
        ];

        // Assert that toArray method returns the expected array
        $this->assertEquals($expectedArray, $this->student->toArray());
    }

    // Test __toString method
    public function testToString()
    {
        // Assert that the string representation of the student is correct
        $this->assertEquals('Mark Johnson (Student) | Student ID: 2001', (string)$this->student);
    }
}
