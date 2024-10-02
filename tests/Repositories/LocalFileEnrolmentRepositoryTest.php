<?php

namespace Test\Repository;

use Model\Course;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\LocalFileEnrolmentRepository;
use Prophecy\PhpUnit\ProphecyTrait;

class LocalFileEnrolmentRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private LocalFileEnrolmentRepository $partialMockLocalFileEnrolmentRepository;

    protected function setUp(): void {
        $this->partialMockLocalFileEnrolmentRepository = $this->getMockBuilder(LocalFileEnrolmentRepository::class)
            ->onlyMethods(['getDataFromSource'])
            ->getMock();

        $this->partialMockLocalFileEnrolmentRepository->expects($this->any())
            ->method('getDataFromSource')
            ->willReturn([
                "users" => [
                    [
                        "name" => "Bill",
                        "classes" => [
                            [
                                "id" => 1
                            ],
                            [
                                "id" => 2
                            ]
                        ]
                    ],
                    [
                        "name" => "Bob",
                        "role" => "Teacher",
                        "classes" => [
                            [
                                "id" => 1
                            ]
                        ]
                    ],
                    [
                        "name" => "James",
                        "classes" => []
                    ],
                ],
                "classes" => [
                    [
                        "id" => 1,
                        "name" => "Maths"
                    ],
                    [
                        "id" => 2,
                        "name" => "English"
                    ]
                ]
            ]);
    }

    public function testGetClassIdsByUserName() {
        $classIds = $this->partialMockLocalFileEnrolmentRepository->getClassIdsByUserName('Bill');
        $this->assertEquals([1,2], $classIds);
    }

    public function testEnrollUserToCourse() {
        $user = new User('John');
        $course = new Course(1, 'Biology');

        $outputUser = $this->partialMockLocalFileEnrolmentRepository->enrollUserToCourse($user, $course);

        $userWithEnrolment = $user->addEnrolment($course);

        $this->assertEquals($userWithEnrolment, $outputUser);
    }

    public function testUnEnrollUserToCourse() {
        $course = new Course(1, 'Biology');

        $userWithEnrolment = new User('John');
        $userWithEnrolment->addEnrolment($course);

        $outputUser = $this->partialMockLocalFileEnrolmentRepository->unEnrollUserFromCourse($userWithEnrolment, $course);

        $userWithoutEnrolment = $userWithEnrolment->removeEnrolment($course);

        $this->assertEquals($userWithoutEnrolment, $outputUser);
    }
}
