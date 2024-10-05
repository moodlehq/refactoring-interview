<?php

namespace MyApp\Repositories;

use MyApp\Storage\StorageInterface;
use MyApp\Models\Course\Course;
use MyApp\Factories\CourseFactory;

/**
 * Class CourseRepository
 *
 * Responsible for handling course-related data storage and retrieval operations.
 */
class CourseRepository {

    /**
     * @var StorageInterface The storage mechanism used for persisting and retrieving course data.
     */
    private StorageInterface $storage;

    /**
     * CourseRepository constructor.
     *
     * @param StorageInterface $storage The storage interface to be used for managing course data.
     */
    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }

    /**
     * Save a Course object to the storage.
     *
     * @param Course $course The Course object to be saved.
     */
    public function save(Course $course) {
        $this->storage->save($course);
    }

    /**
     * Find a course by its ID.
     *
     * @param int $id The ID of the course to be found.
     * @return Course|null Returns the Course object if found, or null if not found.
     */
    public function findById(int $id): ?Course {
        $course = $this->storage->read($id, Course::class);

        if ($course instanceof Course) {
            return $course;
        }
        
        if (is_array($course)) {
            return CourseFactory::createCourse($course);
        }

        return null;
    }

    /**
     * Get all courses.
     *
     * @return array array of all the courses
     */
    public function getAll(): array {
        return $this->storage->readAll();
    }
}