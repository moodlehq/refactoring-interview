<?php

namespace Test\Model;

use Model\Course;
use Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void {
        $this->user = new User('John Doe', 'john@gmail.com');
    }

    public function testGettersAndSetters() {
        $this->user->setName('Mary');
        $this->user->setEmail('mary@gmail.com');

        $this->assertEquals('Mary', $this->user->getName());
        $this->assertEquals('mary@gmail.com', $this->user->getEmail());
    }

    public function testAddAndRemoveEnrolments() {
        $course = new Course(1, 'Biology');

        $this->user->addEnrolment($course);
        $this->assertNotEmpty($this->user->formatForPrint()['courseinfo']);

        $this->user->removeEnrolment($course);
        $this->assertEmpty($this->user->formatForPrint()['courseinfo']);
    }

    public function testRolesSetupAndCheck() {
        $this->assertTrue($this->user->isStudent());
        $this->assertFalse($this->user->isTeacher());

        $this->user = new User('John Doe', 'email@gmail.com', 'Teacher');
        $this->assertFalse($this->user->isStudent());
        $this->assertTrue($this->user->isTeacher());
    }

    public function testFormatForPrintStudent() {
        $this->assertEquals([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
        ], $this->user->formatForPrint());
    }

    public function testFormatForPrintTeacher() {
        $this->user = new User('John Doe', 'john@gmail.com', 'Teacher');
        $this->assertEquals([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'role' => 'Teacher'
        ], $this->user->formatForPrint());
    }

    public function testToString() {
        $this->assertEquals('John Doe: john@gmail.com', $this->user->toString());
    }

    public function testToStringWithNoEmail() {
        $this->user = new User('John Doe', '');
        $this->assertEquals('John Doe: ', $this->user->toString());
    }
}
