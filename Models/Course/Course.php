<?php

namespace MyApp\Models\Course;

use MyApp\Models\Location\Location;

/**
 * School Course
 *
 * Course in the school.
 */
class Course {
    /**
     * @var int The unique identifier for the course.
     */
    private int $courseId;

    /**
     * @var string The name for the course.
     */
    private $courseName;

    /**
     * @var Location The location for the course.
     */
    private $location;

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
        string $courseName, 
        ?Location $location, 
    ) {
        $this->courseId = $courseId;
        $this->courseName = $courseName;
        $this->location = $location;
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
     * Get the name of course.
     *
     * @return string The name for the course.
     */
    public function getCourseName(): string {
        return $this->courseName;
    }

    /**
     * Convert to array.
     *
     * @return array Convert to array.
     */
    public function toArray(): array {
        return [
            'id' => $this->getCourseId(),
            'location' => (string) $this->getCourseLocation(),
            'name' => $this->getCourseName(),
        ];
    }

    /**
     * Get the course's location.
     *
     * @return null|Location The location of the course.
     */
    public function getCourseLocation(): ?Location {
        return $this->location;
    }
}