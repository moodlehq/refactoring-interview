<?php

use PHPUnit\Framework\TestCase;

require_once 'library.php';

/**
 * Unit Tests for the Library class.
 */
class LibraryTest extends TestCase {

    /**
     * Just getting the mock data
     * 
     */
    public function getMockData() {
        return [
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
        ];
    }

    /**
     * Testing `getUsersFromSchool` 
     * if it returns the correct users and classes when the JSON is overridden
     */
    public function testgetUsersFromSchoolOverrideData() {
        $data = $this->getMockData();
        $library = new Library();
        $users = $library->getUsersFromSchool(true, $data);
        $classes = $library->getUsersFromSchool(false, $data);
        $this->assertCount(3, $users['users']);
        $this->assertCount(2, $classes['classes']);
        $this->assertEquals('Bill', $users['users'][0]['name']);
        $this->assertEquals('Teacher', $users['users'][1]['role']);
        $this->assertSame(2, $classes['classes'][1]['id']);
    }

    /**
     * Testing `getUsersFromSchool` 
     * if it returns the correct users and classes when the JSON is not overridden
     */
    public function testgetUsersFromSchoolNoOverrideData() {
        $library = new Library();
        $users = $library->getUsersFromSchool(true, null);
        $classes = $library->getUsersFromSchool(false, null);
        $this->assertCount(4, $users['users']);
        $this->assertCount(2, $classes['classes']);
        $this->assertEquals('Abed Nadir', $users['users'][0]['name']);
        $this->assertEquals('abed@greendale.edu', $users['users'][0]['email']);
        $this->assertSame('Chemistry 101', $classes['classes'][1]['name']);
    }

    /**
     * Testing `getEnrollments` returns the correct enrolments
     */
    public function testgetEnrollments() {
        $data = $this->getMockData();
        $library = new Library();
        $users = $library->getUsersFromSchool(true, $data);
        $classes = $library->getUsersFromSchool(false, $data);
        $enrolments = (array) $library->getEnrollments($data);
        $this->assertCount(3, $users['users']);
        $this->assertCount(2, $classes['classes']);
        $this->assertEquals('Bill', $enrolments[2]->students[0]);
    }
}
