<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\StudentFactory;
use MyApp\Models\User\Student;
use MyApp\Models\Course\Course;

class StudentFactoryTest extends TestCase
{
    /**
     * Test creating a Student object from valid data.
     */
    public function testCreateStudentWithValidData()
    {
        // Arrange
        $studentData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'id' => 101,
            'courses' => [
                ['id' => 201, 'name' => 'Math 101', 'location' => 'Room 1'],
                ['id' => 202, 'name' => 'Science 101', 'location' => 'Room 2']
            ]
        ];

        // Act
        $student = StudentFactory::createStudent($studentData);

        // Assert
        $this->assertInstanceOf(Student::class, $student);
        $this->assertEquals('Jane Doe', $student->getName());
        $this->assertEquals('jane@example.com', $student->getEmail());
        $this->assertCount(2, $student->getCourses());
    }

    /**
     * Test creating a Student object with missing email.
     */
    public function testCreateStudentWithNoEmail()
    {
        // Arrange
        $studentData = [
            'name' => 'Jane Doe',
            'id' => 101,
            'courses' => []
        ];

        // Act
        $student = StudentFactory::createStudent($studentData);

        // Assert
        $this->assertInstanceOf(Student::class, $student);
        $this->assertNull($student->getEmail());
        $this->assertCount(0, $student->getCourses());
    }

    /**
     * Test creating a Student object with no courses.
     */
    public function testCreateStudentWithNoCourses()
    {
        // Arrange
        $studentData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'id' => 101,
            'courses' => []
        ];

        // Act
        $student = StudentFactory::createStudent($studentData);

        // Assert
        $this->assertInstanceOf(Student::class, $student);
        $this->assertCount(0, $student->getCourses());
    }
}
