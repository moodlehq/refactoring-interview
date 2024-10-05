<?php

namespace MyApp\Models\User;

use MyApp\Models\Course\Course;
use MyApp\Models\Role\Role;

/**
 * Class Teacher
 *
 * Encapsulates a specific user type Teacher
 */
class Teacher extends User {

    /**
     * @var null|int teacher's employee id.
     */
    private null|int $employeeId;

    /**
     * @var int teacher's assigned courses.
     */
    private array $assignedCourses = [];

    /**
     * Teacher constructor.
     *
     * @param string $name teacher's name.
     * @param string $email teacher's email.
     * @param int $employeeId teacher employee id.
     */
    public function __construct(
        string $name, 
        ?string $email, 
        ?int $employeeId
    ) {
        $roles = [new Role("Teacher")];
        parent::__construct($name, $roles, $email);
        $this->employeeId = $employeeId;
    }

    /**
     * Get teacher id.
     *
     * @return int get the teacher employee id.
     */
    public function getEmployeeId(): ?int {
        return $this->employeeId;
    }

    /**
     * Get Assign a course to the teacher.
     *
     * @return void
     */
    public function assignCourse(Course $course): void {
        $this->assignedCourses[] = $course;
    }

    /**
     * Get teacher courses.
     *
     * @return array list of teacher's assigned courses.
     */
    public function getCourses(): array {
        return $this->assignedCourses;
    }

    /**
     * Convert to array.
     *
     * @return array Convert to array.
     */
    public function toArray(): array {
        return [
            'id' => $this->getEmployeeId(),
            'email' => parent::getEmail(),
            'name' => parent::getName(),
            'role' => parent::getRoles()
        ];
    }

    /**
     * Student details as a string.
     *
     * @param string teacher details - name(role) | Employee ID.
     */
    public function __toString(): string {
        return parent::__toString() . " | Employee ID: " . $this->employeeId;
    }
}
