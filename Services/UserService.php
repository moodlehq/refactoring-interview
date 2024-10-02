<?php

namespace Service;

use Model\User;
use Repository\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private EnrolmentService $enrolmentService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnrolmentService $enrolmentService
    ) {
        $this->userRepository = $userRepository;
        $this->enrolmentService = $enrolmentService;
    }

    /**
     * @return User[]
     */
    public function getAllUsers(): array
    {
        $users = $this->userRepository->getAllUsers();

        return array_map(function ($user) {
            return $this->enrolmentService->loadEnrolmentsForUser($user);
        }, $users);
    }

    /**
     * @return User[]
     */
    public function getAllStudents(): array
    {
        $users = $this->userRepository->getAllUsers();

        $users = array_filter($users, function ($user) {
           return !$user->isTeacher();
        });

        return array_map(function ($user) {
            return $this->enrolmentService->loadEnrolmentsForUser($user);
        }, $users);
    }

    /**
     * @return User[]
     */
    public function getAllStudentsByCourseId(int $courseId): array
    {
        $users = $this->userRepository->getAllUsersByCourseId($courseId);

        return array_filter($users, function ($user) {
            return !$user->isTeacher();
        });
    }

    /**
     * @return User[]
     */
    public function getAllTeachers(): array
    {
        $users = $this->userRepository->getAllUsers();

        $users = array_filter($users, function ($user) {
            return $user->isTeacher();
        });

        return array_map(function ($user) {
            return $this->enrolmentService->loadEnrolmentsForUser($user);
        }, $users);
    }

    /**
     * @return User[]
     */
    public function getAllTeachersByCourseId(int $courseId): array
    {
        $users = $this->userRepository->getAllUsersByCourseId($courseId);

        return array_filter($users, function ($user) {
            return $user->isTeacher();
        });
    }


    /**
     * @param string $name
     * @param string $email
     * @return User
     */
    public function addUser(string $name, string $email = ''): User
    {
        return $this->userRepository->saveUser(
            new User(
                $name,
                $email
            )
        );
    }

    /**
     * @param string $name
     * @param string $email
     * @return User
     */
    public function updateUser(string $name, string $email = ''): User
    {
        $user = $this->userRepository->findUserByName($name);

        if (!empty($email)) {
            $user->setEmail($email);
        }

        return $this->userRepository->saveUser($user);
    }

    /**
     * @param string $name
     * @return User
     */
    public function deleteUser(string $name): User
    {
        $user = $this->userRepository->findUserByName($name);

        return $this->userRepository->deleteUser($user);
    }
}