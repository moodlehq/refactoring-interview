<?php

namespace MyApp\Factories;

use MyApp\Models\Enrollment\Enrollment;
use MyApp\Models\User\User;
use MyApp\Models\Course\Course;

/**
 * Class EnrollmentFactory
 *
 * Responsible for creating enrollment 
 * objects from user and course objects.
 */
class EnrollmentFactory {

    /**
     * Create an enrollment object.
     *
     * @param User The User object.
     * @return Course The Course object.
     */
    public static function createEnrollment(User $user, Course $course): Enrollment {
        return new Enrollment($course, $user);
    }
}