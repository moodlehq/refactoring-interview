<?php

/**
 * Class Enrollment
 *
 * Represents an Enrollment in the system.
 */
class Enrollment {

    /**
     * @var int The unique identifier for the course.
     */
    private $courseId;

    /**
     * @var string The name for the course.
     */
    private $courseName;

    /**
     * @var array The array for the teachers.
     */
    private $teachers = [];

    /**
     * @var array The array for the students.
     */
    private $students = [];

    /**
     * User constructor.
     *
     * @param int $courseId The unique identifier for the course.
     * @param string $courseName The name of the user.
     */
    public function __construct(
        int $courseId, 
        string $courseName
    ) {
        $this->courseId = $courseId;
        $this->courseName = $courseName;
    }

    /**
     * Get the course's ID.
     *
     * @return int The unique identifier for the course.
     */
    public function getCourseId(): int {
        return $this->courseId;
    }

    /**
     * Get the course's name.
     *
     * @return string The name for the course.
     */
    public function getCourseName(): string {
        return $this->courseName;
    }

    /**
     * Assign a teacher to the course.
     *
     * @param string The techer to add.
     * @return void.
     */
    public function addTeacher(string $teacher): void {
        $this->teachers[] = $teacher;
    }

    /**
     * Add a student to the course.
     *
     * @param string The student to add.
     * @return void.
     */
    public function addStudent(string $student): void {
        $this->students[] = $student;
    }

    /**
     * Get the teachers assigned to the course.
     *
     * @return array The teachers array.
     */
    public function getTeachers(): array {
        return $this->teachers;
    }

    /**
     * Get the students assigned to the course.
     *
     * @return array The students array.
     */
    public function getStudents(): array {
        return $this->students;
    }

    /**
     * Get detailed information on the enrolment.
     *
     * @return array The enrolment array.
     */
    public function getEnrollmentInfo(): array {
        return [
            'courseId' => $this->courseId,
            'courseName' => $this->courseName,
            'teachers' => $this->teachers,
            'students' => $this->students
        ];
    }
}
