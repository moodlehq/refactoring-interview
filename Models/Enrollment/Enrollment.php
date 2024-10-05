<?php

namespace MyApp\Models\Enrollment;

use MyApp\Models\Course\Course;
use MyApp\Models\User\Student;
use MyApp\Models\User\Teacher;

/**
 * Class Enrollment
 *
 * Represents an Enrollment in the system.
 */
class Enrollment {

    /**
     * @var Course Course object.
     */
    private $course;

    /**
     * @var Student The enrolled student.
     */
    private Student $student;

    /**
     * User constructor.
     *
     * @param int $courseId The unique identifier for the course.
     * @param string $courseName The name of the user.
     */
    public function __construct(
        Course $course, 
        Student $student
    ) {
        $this->course = $course;
        $this->student = $student;
    }

    /**
     * Get the course's name.
     *
     * @return string The name for the course.
     */
    public function getCourse(): Course {
        return $this->course;
    }

    /**
     * Get the Enrolled student.
     *
     * @return Student Enrolled student.
     */
    public function getStudent(): Student {
        return $this->student;
    }

    /**
     * Convert to array.
     *
     * @return array Convert to array.
     */
    public function toArray(): array {
        return [
            'student_id' => $this->student->getStudentId(),
            'student_name' => $this->student->getName(),
            'course_name' => $this->course->getCourseName(),
            'course_id' => $this->course->getCourseId(),
        ];
    }
}
