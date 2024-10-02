<?php

namespace Service;

use Model\Course;
use Ramsey\Uuid\Uuid;
use Repository\CourseRepositoryInterface;

class CourseService
{
    private CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @return Course[]
     */
    public function getAllCourses(): array
    {
        return $this->courseRepository->getAllCourses();
    }

    /**
     * @param string $name
     * @param string $location
     * @return Course
     */
    public function addCourse(string $name, string $location = ''): Course
    {
        return $this->courseRepository->saveCourse(
            new Course(
                Uuid::uuid4()->toString(),
                $name,
                $location
            )
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $location
     * @return Course
     */
    public function updateCourse(string $id, string $name = '', string $location = ''): Course
    {
        $course = $this->courseRepository->findCourseById($id);

        if (!empty($name)) {
            $course->setName($name);
        }

        if (!empty($location)) {
            $course->setLocation($location);
        }

        return $this->courseRepository->saveCourse($course);
    }

    /**
     * @param string $id
     * @return Course
     */
    public function deleteCourse(string $id): Course
    {
        $course = $this->courseRepository->findCourseById($id);

        return $this->courseRepository->deleteCourse($course);
    }

}