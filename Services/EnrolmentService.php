<?php

namespace Service;

use Model\User;
use Repository\CourseRepositoryInterface;
use Repository\EnrolmentRepositoryInterface;
use Repository\UserRepositoryInterface;

class EnrolmentService
{
    private EnrolmentRepositoryInterface $enrolmentRepository;
    private UserRepositoryInterface $userRepository;
    private CourseRepositoryInterface $courseRepository;

    public function __construct(
        EnrolmentRepositoryInterface $enrolmentRepository,
        UserRepositoryInterface $userRepository,
        CourseRepositoryInterface $courseRepository

    ) {
        $this->enrolmentRepository = $enrolmentRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param User $user
     * @return User
     */
    public function loadEnrolmentsForUser(User $user): User
    {
        $classIds = $this->enrolmentRepository->getClassIdsByUserName($user->getName());

        foreach ($classIds as $classId) {
            $course = $this->courseRepository->findCourseById($classId);
            $user->addEnrolment($course);
        }

        return $user;
    }

    /**
     * @param string $userName
     * @param int $courseId
     * @return User
     */
    public function enrollUserToCourse(string $userName, int $courseId): User
    {
        $user = $this->userRepository->findUserByName($userName);

        $user = $this->loadEnrolmentsForUser($user);

        $course = $this->courseRepository->findCourseById($courseId);

        return $this->enrolmentRepository->enrollUserToCourse($user, $course);
    }

    /**
     * @param string $userName
     * @param int $courseId
     * @return User
     */
    public function unEnrollUserFromCourse(string $userName, int $courseId): User
    {
        $user = $this->userRepository->findUserByName($userName);

        $user = $this->loadEnrolmentsForUser($user);

        $course = $this->courseRepository->findCourseById($courseId);

        return $this->enrolmentRepository->unEnrollUserFromCourse($user, $course);
    }
}