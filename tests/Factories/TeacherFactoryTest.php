<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\TeacherFactory;
use MyApp\Models\User\Teacher;
use MyApp\Models\Course\Course;

class TeacherFactoryTest extends TestCase
{
    /**
     * Test creating a Teacher object from valid data.
     */
    public function testCreateTeacherWithValidData()
    {
        // Arrange
        $teacherData = [
            'name' => 'Mr. Smith',
            'email' => 'smith@example.com',
            'id' => 1001,
            'courses' => [
                ['id' => 301, 'name' => 'History 101', 'location' => 'Room 3'],
                ['id' => 302, 'name' => 'Geography 101', 'location' => 'Room 4']
            ]
        ];

        // Act
        $teacher = TeacherFactory::createTeacher($teacherData);

        // Assert
        $this->assertInstanceOf(Teacher::class, $teacher);
        $this->assertEquals('Mr. Smith', $teacher->getName());
        $this->assertEquals('smith@example.com', $teacher->getEmail());
        $this->assertCount(2, $teacher->getCourses());
    }

    /**
     * Test creating a Teacher object with missing email.
     */
    public function testCreateTeacherWithNoEmail()
    {
        // Arrange
        $teacherData = [
            'name' => 'Mr. Smith',
            'id' => 1001,
            'courses' => []
        ];

        // Act
        $teacher = TeacherFactory::createTeacher($teacherData);

        // Assert
        $this->assertInstanceOf(Teacher::class, $teacher);
        $this->assertNull($teacher->getEmail());
        $this->assertCount(0, $teacher->getCourses());
    }

    /**
     * Test creating a Teacher object with no courses.
     */
    public function testCreateTeacherWithNoCourses()
    {
        // Arrange
        $teacherData = [
            'name' => 'Mr. Smith',
            'email' => 'smith@example.com',
            'id' => 1001,
            'courses' => []
        ];

        // Act
        $teacher = TeacherFactory::createTeacher($teacherData);

        // Assert
        $this->assertInstanceOf(Teacher::class, $teacher);
        $this->assertCount(0, $teacher->getCourses());
    }
}
