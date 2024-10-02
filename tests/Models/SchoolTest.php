<?php

namespace Test\Model;

use Model\Course;
use Model\School;
use PHPUnit\Framework\TestCase;

class SchoolTest extends TestCase
{
    private School $school;

    protected function setUp(): void {
        $this->school = new School();
    }

    public function testGettersAndSetters() {
        $courses = [
            new Course(1, 'Biology 101', 'Bio Building')
        ];
        $this->school->setCourses($courses);
        $this->assertEquals($courses, $this->school->getCourses());
    }

    public function testAddCourse() {
        $course = new Course(1, 'Biology 101', 'Bio Building');
        $this->school->addCourse($course);
        $this->assertEquals([
            1 => $course
        ], $this->school->getCourses());
    }

    public function testFormatForPrint() {
        $course = new Course(1, 'Biology 101', 'Bio Building');
        $this->school->addCourse($course);

        $this->assertEquals([
            1 => [
                'name' => 'Biology 101',
                'students' => [],
                'teachers' => []
            ]
        ], $this->school->formatForPrint());
    }

}
