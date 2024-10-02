<?php

namespace Test\Service;

use Model\Course;
use Model\User;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Repository\LocalFileCourseRepository;
use Repository\LocalFileEnrolmentRepository;
use Repository\LocalFileUserRepository;
use Service\EnrolmentService;
use Prophecy\PhpUnit\ProphecyTrait;

class EnrolmentServiceTest extends TestCase
{
    use ProphecyTrait;

    private EnrolmentService $enrolmentService;
    private LocalFileEnrolmentRepository|ObjectProphecy $mockEnrolmentRepository;
    private LocalFileUserRepository|ObjectProphecy $mockUserRepository;
    private LocalFileCourseRepository|ObjectProphecy $mockCourseRepository;

    protected function setUp(): void {
        $this->mockEnrolmentRepository = $this->prophesize(LocalFileEnrolmentRepository::class);
        $this->mockUserRepository = $this->prophesize(LocalFileUserRepository::class);
        $this->mockCourseRepository = $this->prophesize(LocalFileCourseRepository::class);

        $this->enrolmentService = new EnrolmentService(
            $this->mockEnrolmentRepository->reveal(),
            $this->mockUserRepository->reveal(),
            $this->mockCourseRepository->reveal(),
        );
    }

    public function testLoadEnrolmentsForUser() {
        $user = new User('John');
        $course = new Course(1, 'Biology');

        $userWithEnrolments = new User('John');
        $userWithEnrolments->addEnrolment($course);

        $this->mockEnrolmentRepository->getClassIdsByUserName('John')->willReturn([1]);
        $this->mockCourseRepository->findCourseById(1)->willReturn($course);

        $this->assertEquals($userWithEnrolments, $this->enrolmentService->loadEnrolmentsForUser($user));
    }

    public function testEnrollUserToCourse() {
        $user = new User('John');
        $course = new Course(1, 'Biology');

        $userWithEnrolments = new User('John');
        $userWithEnrolments->addEnrolment($course);

        $this->mockUserRepository->findUserByName('John')->willReturn($user);
        $this->mockCourseRepository->findCourseById(1)->willReturn($course);
        $this->mockEnrolmentRepository->getClassIdsByUserName('John')->willReturn([1]);
        $this->mockEnrolmentRepository->enrollUserToCourse($user, $course)->willReturn($userWithEnrolments);

        $this->assertEquals($userWithEnrolments, $this->enrolmentService->enrollUserToCourse('John', 1));
    }

    public function testUnEnrollUserFromCourse() {
        $user = new User('John');
        $course = new Course(1, 'Biology');

        $userWithEnrolments = new User('John');
        $userWithEnrolments->addEnrolment($course);

        $this->mockUserRepository->findUserByName('John')->willReturn($user);
        $this->mockCourseRepository->findCourseById(1)->willReturn($course);
        $this->mockEnrolmentRepository->getClassIdsByUserName('John')->willReturn([1]);
        $this->mockEnrolmentRepository->unEnrollUserFromCourse($userWithEnrolments, $course)->willReturn($user);

        $this->assertEquals($user, $this->enrolmentService->unEnrollUserFromCourse('John', 1));
    }

}
