<?php

require_once realpath(__DIR__ . '/../SchoolDataManager.php');

use PHPUnit\Framework\TestCase;

class SchoolDataManagerTest extends TestCase {

    private $schoolData;

    protected function setUp(): void {
        $this->schoolData = [
            'users' => [
                [
                    'name' => 'John Doe',
                    'role' => 'Teacher',
                    'email' => 'john@example.com',
                    'classes' => [['id' => 1, 'name' => 'Math 101']]
                ],
                [
                    'name' => 'Jane Smith',
                    'role' => 'Student',
                    'email' => 'jane@example.com',
                    'classes' => [['id' => 1, 'name' => 'Math 101']]
                ]
            ],
            'classes' => [
                ['id' => 1, 'name' => 'Math 101']
            ]
        ];
    }

    public function testGetUsers() {
        $manager = new SchoolDataManager($this->schoolData);
        $users = $manager->getUsers();

        $this->assertCount(2, $users);
        $this->assertEquals("John Doe", $users[0]->getName());
        $this->assertEquals("Jane Smith", $users[1]->getName());
    }

    public function testGetEnrollments() {
        $manager = new SchoolDataManager($this->schoolData);
        $enrollments = $manager->getEnrollments();

        $this->assertCount(1, $enrollments);
        $this->assertEquals(1, $enrollments[0]->getCourseId());
        $this->assertEquals("Math 101", $enrollments[0]->getCourseName());
        $this->assertCount(1, $enrollments[0]->getTeachers());
        $this->assertCount(1, $enrollments[0]->getStudents());
    }

    public function testFindEnrollmentByCourseId() {
        $manager = new SchoolDataManager($this->schoolData);
        $enrollment = $manager->findEnrollmentByCourseId(1);

        $this->assertNotNull($enrollment);
        $this->assertEquals(1, $enrollment->getCourseId());
        $this->assertEquals("Math 101", $enrollment->getCourseName());
    }

    public function testFindEnrollmentByInvalidCourseId() {
        $manager = new SchoolDataManager($this->schoolData);
        $enrollment = $manager->findEnrollmentByCourseId(999);

        $this->assertNull($enrollment);  // Expecting null for an invalid course ID
    }
}
