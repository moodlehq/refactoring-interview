<?php

use PHPUnit\Framework\TestCase;

require_once('./Repository/courseRepository.php');
require_once('commandHandler.php');

/**
 * Unit Tests for the CommandHandler class.
 */
class CourseRepositoryTest extends TestCase {

    private $courseRepository;
    private $mockLibrary;
    private $mockHelpString = "Allows you to manage courses within the school.

Options:
-a, --all               Print out all of the classes and its' participants
-p, --participants      Print out all participants within a given course when given an ID
-t, --teachers          Print out only the teachers information
-c, --create            Create a new course when given a name
-u, --update            Update a course when given a course ID
-d, --delete            Delete a course when given a course ID
-e, --enroll            Enroll a user into a course when given a user ID and course ID
-ue, --unenroll         Un-enroll a user from a course when given a user ID and course ID
-h, --help              Print out this help

Example:
\$ php courses.php -h
\$ php courses.php -a
\$ php courses.php -c -n 'Mathematics' -l 'Cambridge'
\$ php courses.php -u 1 -n 'Machine Learning' 
\$ php courses.php -d 1 
\$ php courses.php -p 1
\$ php courses.php -t" . PHP_EOL;

    /**
     * Set up the test environment before each test method is run.
     * This method is called before each test method in the class.
     */
    protected function setUp(): void {
        $this->mockLibrary = $this->createMock(Library::class);
        $this->courseRepository = new courseRepository($this->mockLibrary);
    }

    /**
     * Testing `printHelp' method 
     * Chec
     */
    public function testPrintHelp() {
        ob_start();
        $this->courseRepository->printHelp();
        $output = ob_get_clean();
        $this->assertEquals($this->mockHelpString, $output);
    }

    /**
     * Testing `printAll' method 
     * Checking if 'getFormattedUsers' is called 
     */
    public function testPrintAll() {
        $courseRepoMockOnlyTestMethod = $this->getMockBuilder(courseRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['getFormattedCourses'])
            ->getMock();
        $courseRepoMockOnlyTestMethod->expects($this->once())
            ->method('getFormattedCourses');
        $courseRepoMockOnlyTestMethod->printAll();
    }

    /**
     * Testing `handleCustomOption' method 
     * Checking if 'printParticipants' is called when valid option (-l) is passed
     */
    public function testHandleCustomOptionValidOption() {
        $mockOptions = ['p' => false];

        $courseRepoMockOnlyTestMethod = $this->getMockBuilder(courseRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['printParticipants'])
            ->getMock();
        $courseRepoMockOnlyTestMethod->expects($this->once())
            ->method('printParticipants');
        $courseRepoMockOnlyTestMethod->handleCustomOption($mockOptions);
    }
    /**
     * Testing `handleCustomOption' method 
     * Checking if 'printParticipants' is not called when invalid option (-w) is passed
     * and an exception is thrown with correct message
     */
    public function testHandleCustomOptionInvalidOption() {
        $mockOptions = ['w' => false];

        $courseRepoMockOnlyTestMethod = $this->getMockBuilder(courseRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['printParticipants'])
            ->getMock();
        $courseRepoMockOnlyTestMethod->expects($this->never())
            ->method('printParticipants');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The option provided is not supported or missing parameters!");
        $courseRepoMockOnlyTestMethod->handleCustomOption($mockOptions);
    }
    /**
     * Testing `printTeachers' method 
     * Checking if 'getUsersFromSchool' is called after calling 'printTeachers'
     */
    public function testPrintTeachers() {
        $mockUsers = [
            'users' => [
                ['name' => 'John Doe', 'role' => 'Teacher'],
                ['name' => 'Jane Smith', 'role' => 'Learner'],
                ['name' => 'Bob Johnson', 'role' => 'Teacher'],
            ]
        ];
        $this->mockLibrary->expects($this->once())
            ->method('getUsersFromSchool')
            ->with(true, null)
            ->willReturn($mockUsers);
        $courseRepo = new CourseRepository($this->mockLibrary);
        ob_start();
        $courseRepo->printTeachers();
        $output = ob_get_clean();
        $this->assertStringContainsString('Teachers:', $output);
        $this->assertStringContainsString('John Doe', $output);
        $this->assertStringContainsString('Bob Johnson', $output);
        $this->assertStringNotContainsString('Jane Smith', $output);
    }

    /**
     * Testing `create' method 
     * Checking if a course is created successfully with valid arguments
     */
    public function testCreate() {
        $lib = new Library();
        $courseRepository = new CourseRepository($lib);
        $args = ['-n', 'Mathematics', '-l', 'Cambridge'];
        $this->expectOutputRegex("/Course created successfully:/");
        $courseRepository->create($args); 
    }

    /**
     * Testing `create' method 
     * Checking if a course cannot be created without a name
     * and an exception is thrown with correct message
     */
    public function testCreateInvalidEmail() {
        $args = ['-l', 'Cambridge'];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Error: Name is mandatory for creating a user.');
        $this->courseRepository->create($args);
    }

    /**
     * Testing `update' method 
     * Checking if a course is created successfully with a valid id (correct id/index from classes array)
     */
    public function testUpdate() {
        $mockArgs = [1, '-n', 'Machine Learning'];
        $mockId = 1;
        $lib = new Library();
        $courseRepository = new CourseRepository($lib);
        $this->expectOutputRegex("/Course updated successfully:/");
        $courseRepository->update($mockId, $mockArgs);
    }

    /**
     * Testing `update' method 
     * Checking if a course cannot be updated with an invalid id
     * and an exception is thrown with correct message
     */
    public function testUpdateInvalidId() {
        $mockArgs = [12, '-n', 'AI'];
        $mockId = 12;
        $lib = new Library();
        $courseRepository = new CourseRepository($lib);
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage("Error: No course found with ID $mockId.");
        $courseRepository->update($mockId, $mockArgs);
    }

    /**
     * Testing `delete' method 
     * Checking if a course is deleted successfully with a valid id (correct id/index from classes array)
     */
    public function testDelete() {
        $mockId = 1;
        $lib = new Library();
        $courseRepository = new CourseRepository($lib);
        $this->expectOutputRegex("/Course with ID " . $mockId . " was deleted successfully./");
        $courseRepository->delete($mockId);
    }
    
    /**
     * Testing `delete' method 
     * Checking if a course cannot be deleted with an invalid id
     * and an exception is thrown with correct message
     */
    public function testDeleteUserInvalidId() {
        $mockId = 12;
        $lib = new Library();
        $courseRepository = new CourseRepository($lib);
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage("Error: No course found with ID $mockId.");
        $courseRepository->delete($mockId);
    }

    /**
     * Testing `getFormattedCourses' method 
     * Checking if the correct formatted courses are returned
     * when providing the correct input
     */
    public function testGetFormattedCoursesWithClassroomInfo()
    {
        $input = [
            'isClassroomInfo' => true,
            'classes' => [
                ['id' => 1, 'name' => 'Math'],
                ['id' => 2, 'name' => 'Science']
            ]
        ];

        $expected = [
            ['id' => 1, 'name' => 'Math'],
            ['id' => 2, 'name' => 'Science']
        ];

        $result = $this->courseRepository->getFormattedCourses($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Testing `getFormattedCourses' method 
     * Checking if there is an empty array returned when providing an empty input
     */
    public function testGetFormattedCoursesWithEmptyInput()
    {
        $input = [];
        $result = $this->courseRepository->getFormattedCourses($input);
        $this->assertEquals([], $result);
    }
}
