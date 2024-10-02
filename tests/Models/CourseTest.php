<?php

namespace Test\Model;

use Model\Course;
use Model\Student;
use Model\Teacher;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    private Course $course;

    protected function setUp(): void {
        $this->course = new Course(1, 'Biology 101', 'Bio Building');
    }

    public function testGettersAndSetters() {
        $this->course->setName('Chemistry 101');
        $this->course->setLocation('Science Building');

        $this->assertEquals('Chemistry 101', $this->course->getName());
        $this->assertEquals('Science Building', $this->course->getLocation());
    }

    public function testAddAndGetStudents() {
        $student = new Student('John', 'john@gmail.com');
        $this->course->addStudent($student);
        $this->assertEquals([$student], $this->course->getStudents());
    }

    public function testAddAndGetTeachers() {
        $teacher = new Teacher('Mary', 'mary@gmail.com');
        $this->course->addTeacher($teacher);
        $this->assertEquals([$teacher], $this->course->getTeachers());
    }

    public function testFormatForPrint() {
        $this->assertEquals([
            'id' => 1,
            'name' => 'Biology 101',
            'location' => 'Bio Building'
        ], $this->course->formatForPrint());
    }

    public function testToString() {
        $this->assertEquals('Biology 101: Bio Building', $this->course->toString());
    }

    public function testToStringWithoutLocation() {
        $this->course = new Course(1, 'Biology 101', '');
        $this->assertEquals('Biology 101: ', $this->course->toString());
    }
}
