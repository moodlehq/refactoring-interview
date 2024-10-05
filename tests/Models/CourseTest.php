<?php

use PHPUnit\Framework\TestCase;
use MyApp\Models\Course\Course;
use MyApp\Models\Location\Location;

/**
 * Class CourseTest
 *
 * Unit tests for the Course class.
 */
class CourseTest extends TestCase
{
    private Course $course;
    private Location $location;

    protected function setUp(): void
    {
        // Initialize a Location object for the course
        $this->location = new Location('New York', 40.7128, -74.0060);
        // Initialize a Course object for testing
        $this->course = new Course(1, 'Mathematics', $this->location);
    }

    // Test the constructor and getter methods
    public function testCourseCreation()
    {
        // Assert that the course ID is set correctly
        $this->assertEquals(1, $this->course->getCourseId());

        // Assert that the course name is set correctly
        $this->assertEquals('Mathematics', $this->course->getCourseName());

        // Assert that the location is set correctly
        $this->assertEquals($this->location, $this->course->getCourseLocation());
    }

    // Test the toArray method
    public function testToArray()
    {
        $expectedArray = [
            'id' => 1,
            'location' => 'New York (Lat: 40.7128, Lon: -74.006)', // String representation from Location
            'name' => 'Mathematics',
        ];

        // Assert that toArray method returns the expected array
        $this->assertEquals($expectedArray, $this->course->toArray());
    }
}
