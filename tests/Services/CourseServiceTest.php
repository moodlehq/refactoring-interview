<?php

namespace Test\Service;

use Model\Course;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Repository\LocalFileCourseRepository;
use Service\CourseService;
use Prophecy\PhpUnit\ProphecyTrait;

class CourseServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseService $courseService;
    private LocalFileCourseRepository|ObjectProphecy $mockCourseRepository;

    protected function setUp(): void {
        $this->mockCourseRepository = $this->prophesize(LocalFileCourseRepository::class);

        $this->courseService = new CourseService(
            $this->mockCourseRepository->reveal(),
        );
    }

    public function testGetAllCourses() {
        $course = new Course(1, 'Biology');
        $this->mockCourseRepository->getAllCourses()->willReturn([
            $course,
            $course
        ]);
        $this->assertEquals([$course, $course], $this->courseService->getAllCourses());
    }
    public function testAddCourse() {
        $course = new Course(1, 'Biology', 'Science Building');
        $this->mockCourseRepository->saveCourse(Argument::type(Course::class))->willReturn($course);
        $this->assertEquals($course, $this->courseService->addCourse('Biology', 'Science Building'));
    }

    public function testUpdateCourse() {
        $oldCourse = new Course(1, 'Math', 'Old Building');
        $newCourse = new Course(1, 'Mathematics', 'New Building');
        $this->mockCourseRepository->findCourseById(1)->willReturn($oldCourse);
        $this->mockCourseRepository->saveCourse($newCourse)->willReturn($newCourse);
        $this->assertEquals($newCourse, $this->courseService->updateCourse(1, 'Mathematics', 'New Building'));
    }

    public function testDeleteCourse() {
        $course = new Course(1, 'Physics');
        $this->mockCourseRepository->findCourseById(1)->willReturn($course);
        $this->mockCourseRepository->deleteCourse($course)->willReturn($course);
        $this->assertEquals($course, $this->courseService->deleteCourse(1));
    }

}
