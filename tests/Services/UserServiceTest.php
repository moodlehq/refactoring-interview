<?php

namespace Test\Service;

use Model\Course;
use Model\User;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Repository\LocalFileUserRepository;
use Service\EnrolmentService;
use Service\UserService;
use Prophecy\PhpUnit\ProphecyTrait;

class UserServiceTest extends TestCase
{
    use ProphecyTrait;

    private UserService $userService;
    private LocalFileUserRepository|ObjectProphecy $mockUserRepository;
    private EnrolmentService|ObjectProphecy $mockEnrolmentService;

    protected function setUp(): void {
        $this->mockUserRepository = $this->prophesize(LocalFileUserRepository::class);
        $this->mockEnrolmentService = $this->prophesize(EnrolmentService::class);

        $this->userService = new UserService(
            $this->mockUserRepository->reveal(),
            $this->mockEnrolmentService->reveal()
        );
    }

    public function testGetAllUsers() {
        $user = new User('John');
        $this->mockUserRepository->getAllUsers()->willReturn([
            $user,
            $user
        ]);
        $userWithEnrolment = $user->addEnrolment(new Course(1, 'Biology'));
        $this->mockEnrolmentService->loadEnrolmentsForUser(Argument::type(User::class))->willReturn($userWithEnrolment)->shouldBeCalledTimes(2);
        $this->assertEquals([$userWithEnrolment, $userWithEnrolment], $this->userService->getAllStudents());
    }

    public function testGetAllStudents() {
        $student = new User('John');
        $teacher = new User('Mary', '', 'Teacher');
        $this->mockUserRepository->getAllUsers()->willReturn([
            $student,
            $teacher
        ]);
        $studentWithEnrolment = $student->addEnrolment(new Course(1, 'Biology'));
        $this->mockEnrolmentService->loadEnrolmentsForUser(Argument::type(User::class))->willReturn($studentWithEnrolment)->shouldBeCalledTimes(1);
        $this->assertEquals([$studentWithEnrolment], $this->userService->getAllStudents());
    }

    public function testGetAllStudentsByCourseId() {
        $student = new User('John');
        $teacher = new User('Mary', '', 'Teacher');
        $this->mockUserRepository->getAllUsersByCourseId(1)->willReturn([
            $student,
            $teacher
        ]);
        $this->assertEquals([$student], $this->userService->getAllStudentsByCourseId(1));
    }

    public function testGetAllTeachers() {
        $student = new User('John');
        $teacher = new User('Mary', '', 'Teacher');
        $this->mockUserRepository->getAllUsers()->willReturn([
            $student,
            $teacher
        ]);
        $teacherWithEnrolment = $student->addEnrolment(new Course(1, 'Biology'));
        $this->mockEnrolmentService->loadEnrolmentsForUser(Argument::type(User::class))->willReturn($teacherWithEnrolment)->shouldBeCalledTimes(1);
        $this->assertEquals([$teacherWithEnrolment], $this->userService->getAllStudents());
    }

    public function testGetAllTeachersByCourseId() {
        $student = new User('John');
        $teacher = new User('Mary', '', 'Teacher');
        $this->mockUserRepository->getAllUsersByCourseId(1)->willReturn([
            $teacher,
            $student
        ]);
        $this->assertEquals([$teacher], $this->userService->getAllTeachersByCourseId(1));
    }

    public function testAddUser() {
        $user = new User('John');
        $this->mockUserRepository->saveUser($user)->willReturn($user);
        $this->assertEquals($user, $this->userService->addUser('John', ''));
    }

    public function testUpdateUser() {
        $user = new User('John');
        $this->mockUserRepository->findUserByName('John')->willReturn($user);
        $this->mockUserRepository->saveUser($user)->willReturn($user);
        $this->assertEquals($user, $this->userService->updateUser('John', ''));
    }

    public function testDeleteUser() {
        $user = new User('John');
        $this->mockUserRepository->findUserByName('John')->willReturn($user);
        $this->mockUserRepository->deleteUser($user)->willReturn($user);
        $this->assertEquals($user, $this->userService->deleteUser('John', ''));
    }

}
