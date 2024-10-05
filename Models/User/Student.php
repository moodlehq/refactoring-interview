<?php

namespace MyApp\Models\User;

use MyApp\Models\Course\Course;
use MyApp\Models\Role\Role;

/**
 * Class Student
 *
 * Encapsulates a specific  user type student
 */
class Student extends User {

    /**
     * @var int student's id.
     */
    private $studentId;

    /**
     * @var array student's courses.
     */
    private array $courses = [];

    /**
     * User constructor.
     *
     * @param string $name students' name.
     * @param string $email students' email.
     * @param int $studentId students' id.
     */
    public function __construct(
        string $name, 
        ?string $email, 
        ?int $studentId
    ) {
        $roles = [new Role("Student")];
        parent::__construct($name, $roles, $email);
        $this->studentId = $studentId;
    }

    /**
     * Enroll in course.
     *
     * @return void
     */
    public function enrollInCourse(Course $course): void {
        $this->courses[] = $course;
    }

    /**
     * Get student id.
     *
     * @return int get the student id.
     */
    public function getStudentId(): ?int {
        return $this->studentId;
    }

    /**
     * Convert to array.
     *
     * @return array Convert to array.
     */
    public function toArray(): array {
        return [
            'id' => $this->getStudentId(),
            'email' => parent::getEmail(),
            'name' => parent::getName(),
            'role' => parent::getRoles()
        ];
    }

    /**
     * Student details as a string.
     *
     * @param string student details - name(role) | id.
     */
    public function __toString(): string {
        return parent::__toString() . " | Student ID: " . $this->studentId;
    }
}
