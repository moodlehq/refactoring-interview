<?php

namespace Test\Repository;

use Exception;
use Model\Course;
use PHPUnit\Framework\TestCase;
use Repository\LocalFileCourseRepository;
use Prophecy\PhpUnit\ProphecyTrait;

class LocalFileCourseRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private LocalFileCourseRepository $partialMockLocalFileCourseRepository;

    protected function setUp(): void {
        $this->partialMockLocalFileCourseRepository = $this->getMockBuilder(LocalFileCourseRepository::class)
            ->onlyMethods(['getDataFromSource'])
            ->getMock();

        $this->partialMockLocalFileCourseRepository->expects($this->any())
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

    public function testGetAllCourses() {
        $courses = $this->partialMockLocalFileCourseRepository->getAllCourses();
        $this->assertInstanceOf(Course::class, $courses[0]);
        $this->assertEquals('Maths', $courses[0]->getName());
    }

    public function testFindCourseById() {
        $course = $this->partialMockLocalFileCourseRepository->findCourseById(2);
        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals('English', $course->getName());
    }

    public function testFindCourseByIdWhenNotFound() {
        $this->expectException(Exception::class);
        $this->partialMockLocalFileCourseRepository->findCourseById(3);
    }

    public function testSaveCourse() {
        $course = new Course(1,'Biology');
        $outputCourse = $this->partialMockLocalFileCourseRepository->saveCourse(new Course(1,'Biology'));
        $this->assertEquals($course, $outputCourse);
    }

    public function testDeleteCourse() {
        $course = new Course(1,'Biology');
        $outputCourse = $this->partialMockLocalFileCourseRepository->deleteCourse(new Course(1,'Biology'));
        $this->assertEquals($course, $outputCourse);
    }
}
