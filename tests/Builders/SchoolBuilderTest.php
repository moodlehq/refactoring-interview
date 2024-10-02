<?php

namespace Test\Builder;

use Builder\SchoolBuilder;
use PHPUnit\Framework\TestCase;

class SchoolBuilderTest extends TestCase
{
    private const MOCK_DATA = [
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
                "email" => "bob@email.com",
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

    protected function setUp(): void {
        $this->schoolBuilder = new SchoolBuilder();
    }

    public function testBuildSchool() {
        $this->schoolBuilder->addCoursesFromData(self::MOCK_DATA);
        $this->schoolBuilder->addUsersFromData(self::MOCK_DATA);
        $school = $this->schoolBuilder->build();
        $this->assertEquals([
           1 => [
               'name' => 'Maths',
               'students' => [
                   'Bill: ',
               ],
               'teachers' => [
                   'Bob: bob@email.com'
               ]
           ],
           2 => [
               'name' => 'English',
               'students' => [
                   'Bill: ',
               ],
               'teachers' => [
               ]
           ]
        ], $school->formatForPrint());
    }

    public function testBuildEmptySchool() {
        $school = $this->schoolBuilder->build();
        $this->assertEmpty($school->getCourses());
    }

    public function testBuildSchoolOnEmptyCourses() {
        $this->schoolBuilder->addUsersFromData(self::MOCK_DATA);
        $school = $this->schoolBuilder->build();
        $this->assertEmpty($school->getCourses());
    }
}
