<?php

namespace MyApp\Repositories;

use MyApp\Storage\StorageInterface;
use MyApp\Models\User\User;
use MyApp\Models\User\Teacher;
use MyApp\Models\User\Student;
use MyApp\Factories\TeacherFactory;
use MyApp\Factories\StudentFactory;

/**
 * Class UserRepository
 *
 * Responsible for handling user-related data storage and retrieval operations.
 */
class UserRepository {
    
    /**
     * @var StorageInterface The storage mechanism used for persisting and retrieving user data.
     */
    private StorageInterface $storage;

    /**
     * UserRepository constructor.
     *
     * @param StorageInterface $storage The storage interface to be used for managing user data.
     */
    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }

    /**
     * Save a User object to the storage.
     *
     * @param User $user The User object to be saved.
     */
    public function save(User $user) {
        $this->storage->save($user);
    }

    /**
     * Find a user by their ID.
     *
     * @param int $id The ID of the user to be found.
     * @return User|null Returns the User object if found, or null if not found.
     */
    public function findById(int $id): Teacher|Student|null {
        $user = $this->storage->read($id, User::class);

        if ($user instanceof User) {
            return $user;
        }

        if (in_array('Teacher', $user['role']??[])) {
            return TeacherFactory::createTeacher($user);
        }

        if (in_array('Student', $user['role']??[])) {
            return StudentFactory::createStudent($user);
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