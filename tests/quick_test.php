<?php

use PHPUnit\Framework\TestCase;
include 'test.php';

class quick_test extends TestCase {

    public function getData() {
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

    public function testMainFunctions() {
        $data = $this->getData();
        // Just returns all users.
        $users = getLearnersintheSchool($data);
        // And this gets classes.
        $classes = getSchoolClassInformation($data);
        // Combination of users in classes.
        $enrolments = (array) enrolledIntoclass($data);
        $this->assertCount(3, $users['users']);
        $this->assertCount(2, $classes['classes']);
        // Check English only has Bill in it.
        $this->assertEquals('Bill', $enrolments[2]->students[0]);
    }

}
