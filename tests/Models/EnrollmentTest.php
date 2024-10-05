<?php

namespace MyApp\Tests\Models\Enrollment;

use MyApp\Models\Course\Course;
use MyApp\Models\User\Student;
use MyApp\Models\Enrollment\Enrollment;
use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase
{
    private Course $course;
    private Student $student;
    private Enrollment $enrollment;

    protected function setUp(): void
    {
        // Create a Course object for testing
        $this->course = new Course("Test Course", 101); // assuming Course has a constructor taking name and id

        // Create a Student object for testing
        $this->student = new Student("John Doe", "john.doe@example.com", 1);

        // Create an Enrollment object using the Course and Student
        $this->enrollment = new Enrollment($this->course, $this->student);
    }

    public function testGetCourse(): void
    {
        $this->assertSame($this->course, $this->enrollment->getCourse());
    }

    public function testGetStudent(): void
    {
        $this->assertSame($this->student, $this->enrollment->getStudent());
    }

    public function testToArray(): void
    {
        $expectedArray = [
            'student_id' => 1,
            'student_name' => 'John Doe',
            'course_name' => 'Test Course',
            'course_id' => 101,
        ];

        $this->assertSame($expectedArray, $this->enrollment->toArray());
    }
}
