<?php

namespace MyApp\Factories;

use MyApp\Models\User\User;

/**
 * Class UserFactory
 *
 * Responsible for creating User objects from user data arrays.
 */
class UserFactory {

    /**
     * Create a User object from an associative array of user data.
     *
     * @param array $userData The array containing user details (e.g name, email, id)
     * @return User The created User object.
     */
    public static function createUser(array $userData): User {
        $user = new User($userData['name'], $userData['email'], $userData['id']);

        // Parse user roles and assign them to the user
        foreach ($userData['roles'] as $roleData) {
            $role = RoleFactory::createRole($roleData);
            $user->addRole($role);
        }

        // Parse courses the user is enrolled in and add them
        foreach ($userData['courses'] as $courseData) {
            $course = CourseFactory::createCourse($courseData);
            $user->enrollInCourse($course);
        }

        return $user;
    }
}