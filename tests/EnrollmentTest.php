<?php

require_once realpath(__DIR__ . '/../Enrollment.php');

use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase {

    public function testAddTeacher() {
        $enrollment = new Enrollment(1, "Math 101");
        $enrollment->addTeacher("John Doe: john@example.com");

        $this->assertCount(1, $enrollment->getTeachers());
        $this->assertEquals("John Doe: john@example.com", $enrollment->getTeachers()[0]);
    }

    public function testAddStudent() {
        $enrollment = new Enrollment(1, "Math 101");
        $enrollment->addStudent("Jane Smith: jane@example.com");

        $this->assertCount(1, $enrollment->getStudents());
        $this->assertEquals("Jane Smith: jane@example.com", $enrollment->getStudents()[0]);
    }

    public function testGetEnrollmentInfo() {
        $enrollment = new Enrollment(1, "Math 101");
        $enrollment->addTeacher("John Doe: john@example.com");
        $enrollment->addStudent("Jane Smith: jane@example.com");

        $info = $enrollment->getEnrollmentInfo();

        $this->assertEquals(1, $info['courseId']);
        $this->assertEquals("Math 101", $info['courseName']);
        $this->assertEquals(["John Doe: john@example.com"], $info['teachers']);
        $this->assertEquals(["Jane Smith: jane@example.com"], $info['students']);
    }
}
