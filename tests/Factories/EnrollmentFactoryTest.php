<?php

use PHPUnit\Framework\TestCase;
use MyApp\Factories\EnrollmentFactory;
use MyApp\Models\Enrollment\Enrollment;
use MyApp\Models\User\Student;
use MyApp\Models\Course\Course;
use MyApp\Models\Role\Role;

class EnrollmentFactoryTest extends TestCase
{
    /**
     * Test creating an Enrollment object from valid user and course objects.
     */
    public function testCreateEnrollmentWithValidData()
    {
        // Arrange
        $course = $this->createMock(Course::class);
        $student = $this->createMock(Student::class);

        // Act
        $enrollment = EnrollmentFactory::createEnrollment($student, $course);

        // Assert
        $this->assertInstanceOf(Enrollment::class, $enrollment);
        $this->assertSame($student, $enrollment->getStudent());
        $this->assertSame($course, $enrollment->getCourse());
    }

    /**
     * Test if Enrollment object returns the correct student.
     */
    public function testGetStudent()
    {
        // Arrange
        $course = $this->createMock(Course::class);
        $student = $this->createMock(Student::class);

        // Act
        $enrollment = EnrollmentFactory::createEnrollment($student, $course);

        // Assert
        $this->assertSame($student, $enrollment->getStudent());
    }

    /**
     * Test if Enrollment object returns the correct course.
     */
    public function testGetCourse()
    {
        // Arrange
        $course = $this->createMock(Course::class);
        $student = $this->createMock(Student::class);

        // Act
        $enrollment = EnrollmentFactory::createEnrollment($student, $course);

        // Assert
        $this->assertSame($course, $enrollment->getCourse());
    }

    /**
     * Test conversion of Enrollment object to array.
     */
    public function testToArray()
    {
        // Arrange
        $course = $this->createMock(Course::class);
        $student = $this->createMock(Student::class);

        $course->method('getCourseId')->willReturn(1);
        $course->method('getCourseName')->willReturn('Math 101');
        $student->method('getStudentId')->willReturn(123);
        $student->method('getName')->willReturn('John Doe');

        // Act
        $enrollment = EnrollmentFactory::createEnrollment($student, $course);
        $result = $enrollment->toArray();

        // Assert
        $this->assertEquals([
            'student_id' => 123,
            'student_name' => 'John Doe',
            'course_name' => 'Math 101',
            'course_id' => 1,
        ], $result);
    }
}
