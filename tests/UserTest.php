<?php

require_once realpath(__DIR__ . '/../User.php');

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testAddCourse() {
        $user = new User("John Doe", "Student", "john@example.com");
        $user->addCourse(['id' => 1, 'name' => 'Math 101']);

        $courses = $user->getCourses();
        $this->assertCount(1, $courses);
        $this->assertEquals(['id' => 1, 'name' => 'Math 101'], $courses[0]);
    }

    public function testGetUserInfo() {
        $user = new User("John Doe", "Teacher", "john@example.com");
        $user->addCourse(['id' => 1, 'name' => 'Math 101']);

        $info = $user->getUserInfo();

        $this->assertEquals("John Doe", $info['name']);
        $this->assertEquals("Teacher", $info['role']);
        $this->assertEquals("john@example.com", $info['email']);
        $this->assertCount(1, $info['courses']);
        $this->assertEquals(['id' => 1, 'name' => 'Math 101'], $info['courses'][0]);
    }
}
