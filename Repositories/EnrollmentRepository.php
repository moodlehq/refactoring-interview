<?php

namespace MyApp\Repositories;

use MyApp\Storage\StorageInterface;
use MyApp\Models\Enrollment\Enrollment;
use MyApp\Factories\EnrollmentFactory;
use MyApp\Factories\CourseFactory;
use MyApp\Factories\StudentFactory;
// use MyApp\Repositories\CourseFactory;
use MyApp\Repositories\UserRepository;

/**
 * Class EnrollmentRepository
 *
 * Responsible for handling enrollment-related data storage and retrieval operations.
 */
class EnrollmentRepository {

    /**
     * @var StorageInterface The storage mechanism used for persisting and retrieving enrollment data.
     */
    private StorageInterface $storage;

    /**
     * EnrollmentRepository constructor.
     *
     * @param StorageInterface $storage The storage interface to be used for managing enrollment data.
     */
    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }

    /**
     * Save a Enrollment object to the storage.
     *
     * @param Enrollment $Enrollment The Enrollment object to be saved.
     */
    public function save(Enrollment $enrollment) {
        $this->storage->save($enrollment);
    }

    /**
     * Find a enrollment by its ID.
     *
     * @param int $id The ID of the enrollment to be found.
     * @return Enrollment|null Returns the enrollment object if found, or null if not found.
     */
    public function findById(int $id): ?Enrollment {
        $enrollment = $this->storage->read($id, Enrollment::class);

        if ($enrollment instanceof Enrollment) {
            return $enrollment;
        }
        
        if (is_array($enrollment)) {
            $student = StudentFactory::createStudent([
                'id' => $enrollment['student_id'],
                'name' => $enrollment['student_name']
            ]);

            $course = CourseFactory::createCourse([
                'id' => $enrollment['course_id'],
                'name' => $enrollment['course_name']
            ]);

            return EnrollmentFactory::createEnrollment($student, $course);
        }

        return null;
    }

    /**
     * Get all enrollments.
     *
     * @return array array of all the enrollments
     */
    public function getAll(): array {
        return $this->storage->readAll();
    }
}