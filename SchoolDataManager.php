<?php

require_once 'Enrollment.php';
require_once 'User.php';

/**
 * Class SchoolDataManager
 *
 * Abstracts school data extraction and 
 * transformation within the system.
 */
class SchoolDataManager {

    /**
     * @var array School data from the file.
     */
    private $schoolData;

    /**
     * SchoolDataManager constructor.
     *
     * @param array $schoolData The data for the school.
     */
    public function __construct(array $schoolData) {
        $this->schoolData = $schoolData;
    }

    /**
     * getUsers get users within the system.
     *
     * @return array Array of users within the school
     */
    public function getUsers(): array {
        return $this->extractUsers();
    }

    /**
     * getEnrollments get enrolments within the system.
     *
     * @return array Array of users enrolments
     */
    public function getEnrollments(): array {
        return $this->extractEnrollments();
    }

    /**
     * findEnrollmentByCourseId get an enrolment by course id.
     *
     * @param int $courseId The unique identifier for the course.
     * @return Enrollment Enrolment against a course id.
     */
    public function findEnrollmentByCourseId(int $courseId): ?Enrollment {
        // Extract enrollments and search for the matching course ID
        $enrollments = $this->extractEnrollments();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->getCourseId() === $courseId) {
                return $enrollment;  // Return the found enrollment
            }
        }

        return null;  // Return null if no matching course ID is found
    }

    /**
     * extractUsers Extract school users from the data.
     *
     * @return array Array of extracted users from school data
     */
    private function extractUsers(): array {
        $users = [];

        // users do not exist on school data
        if (!($this->schoolData['users']??null)) {
            return [];
        }

        foreach ($this->schoolData['users'] as $userData) {
            $user = new User(
                $userData['name'], 
                $userData['role']??null, 
                $userData['email']??null
            );

            foreach ($userData['classes'] as $class) {
                $user->addCourse($class);
            }

            $users[] = $user;
        }

        return $users;
    }

    /**
     * extractEnrollments Extract school enrolments from school data.
     *
     * @return array Array of extracted enrolments
     */
    private function extractEnrollments(): array {
        $enrollments = [];

        foreach ($this->schoolData['classes'] as $class) {
            $enrollment = new Enrollment(
                $class['id'], 
                $class['name']
            );

            foreach ($this->schoolData['users'] as $userData) {
                foreach ($userData['classes'] as $userClass) {
                    if ($userClass['id'] == $class['id']) {
                        if (isset($userData['role']) and $userData['role'] == 'Teacher' and isset($userData['email'])) {
                            $enrollment->addTeacher($userData['name'] . ': ' . $userData['email']);
                        } else {
                            $enrollment->addStudent($userData['name'] . ': ' . $userData['email']);
                        }
                    }
                }
            }

            $enrollments[] = $enrollment;
        }

        return $enrollments;
    }
}
