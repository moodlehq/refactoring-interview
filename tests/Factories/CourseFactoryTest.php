<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\CourseFactory;
use MyApp\Models\Course\Course;
use MyApp\Models\Location\Location;

class CourseFactoryTest extends TestCase
{
    /**
     * Test that a valid course is created from the data array.
     */
    public function testCreateCourseWithValidData()
    {
        // Arrange
        $courseData = [
            'id' => 1,
            'name' => 'Mathematics',
            'location' => 'Room 101',
        ];

        // Act
        $course = CourseFactory::createCourse($courseData);

        // Assert
        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals(1, $course->getCourseId());
        $this->assertEquals('Mathematics', $course->getCourseName());
        $this->assertInstanceOf(Location::class, $course->getCourseLocation());
        $this->assertEquals('Room 101', $course->getCourseLocation()->getName());
    }

    /**
     * Test that a course is created with an empty location if location is missing in the data array.
     */
    public function testCreateCourseWithMissingLocation()
    {
        // Arrange
        $courseData = [
            'id' => 2,
            'name' => 'Physics',
            // No 'location' provided
        ];

        // Act
        $course = CourseFactory::createCourse($courseData);

        // Assert
        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals(2, $course->getCourseId());
        $this->assertEquals('Physics', $course->getCourseName());
        $this->assertInstanceOf(Location::class, $course->getCourseLocation());
        $this->assertEquals('', $course->getCourseLocation()->getName());  // Default empty string
    }

    /**
     * Test that the factory handles an empty course data array.
     */
    public function testCreateCourseWithEmptyData()
    {
        // Arrange
        $courseData = [];

        // Act
        $course = CourseFactory::createCourse($courseData);

        // Assert
        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals(0, $course->getCourseId()); // Default value for integer
        $this->assertEquals('', $course->getCourseName()); // Default value for string
        $this->assertInstanceOf(Location::class, $course->getCourseLocation());
        $this->assertEquals('', $course->getCourseLocation()->getName()); // Default empty string for location
    }
}
