<?php

namespace MyApp\Services;

use MyApp\Repositories\CourseRepository;
use MyApp\Repositories\UserRepository;
use MyApp\Repositories\EnrollmentRepository;
use MyApp\Factories\TeacherFactory;
use MyApp\Factories\StudentFactory;
use MyApp\Factories\CourseFactory;
use MyApp\Factories\EnrollmentFactory;

/**
 * Class SchoolDataManager
 *
 * Manages the process of loading data from JSON and storing it in repositories.
 */
class SchoolDataManager {

    /**
     * @var JsonDataLoader Responsible for loading data from a JSON file.
     */
    private JsonDataLoader $jsonLoader;

    /**
     * @var UserRepository Responsible for saving and retrieving User objects.
     */
    private UserRepository $userRepository;

    /**
     * @var CourseRepository Responsible for saving and retrieving Course objects.
     */
    private CourseRepository $courseRepository;

    /**
     * @var EnrollmentRepository Responsible for saving and retrieving enrollment objects.
     */
    private EnrollmentRepository $enrollmentRepository;

    /**
     * SchoolDataManager constructor.
     *
     * @param JsonDataLoader $jsonLoader The data loader responsible for loading JSON data.
     * @param UserRepository $userRepository The repository responsible for managing user data.
     * @param CourseRepository $courseRepository The repository responsible for managing course data.
     */
    public function __construct(
        JsonDataLoader $jsonLoader, 
        UserRepository $userRepository, 
        CourseRepository $courseRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        $this->jsonLoader = $jsonLoader;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * Import data from the JSON file and save users and courses into their respective repositories.
     *
     * This method extracts users and courses from the loaded JSON data and saves
     * them to the corresponding repositories.
     */
    public function importData(): void {
        // Load data from the JSON file
        $data = $this->jsonLoader->loadData();
        
        // Extract courses from the data and save them
        foreach ($data['classes'] as $courseData) {
            $course = CourseFactory::createCourse($courseData);

            $this->courseRepository->save($course);
        }

        $user=null;
        // Extract users from the data and save them
        // Extract teachers and students and teachers seperately
        // Create enrollments for students
        foreach ($data['users'] as $userData) {
            if (isset($userData['role']) and $userData['role'] == 'Teacher') {
                $user = TeacherFactory::createTeacher($userData);
            } else {
                // its a student
                // create enrollments
                $user = StudentFactory::createStudent($userData);

                if (isset($userData['classes'])) {
                    foreach ($userData['classes'] as $userClass) {
                        foreach ($data['classes'] as $courseData) {
                            if ($courseData['id'] == $userClass['id']) {
                                $course = CourseFactory::createCourse($courseData);
                                $enrollment = EnrollmentFactory::createEnrollment($user, $course);
                                $this->enrollmentRepository->save($enrollment);
                            }
                        }
                    }
                }
            }

            // save the user
            $this->userRepository->save($user);
        }
    }
}