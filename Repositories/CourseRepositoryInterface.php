<?php

namespace Repository;

use Model\Course;

interface CourseRepositoryInterface
{
    /**
     * @return Course[]
     */
    public function getAllCourses(): array;

    /**
     * @param int $courseId
     * @return Course
     */
    public function findCourseById(string $courseId): Course;

    /**
     * @param Course $course
     * @return Course
     */
    public function saveCourse(Course $course): Course;

    /**
     * @param Course $course
     * @return Course
     */
    public function deleteCourse(Course $course): Course;
}