<?php

use PHPUnit\Framework\TestCase;

require_once('./Repository/userRepository.php');
require_once('commandHandler.php');


/**
 * Unit Tests for the UserRepository class.
 */
class UserRepositoryTest extends TestCase {

    private $userRepository;
    private $mockLibrary;
    private $mockHelpString = "Allows you to manage users within the school.

    Options:
    -a, --all           Print out all user information
    -l, --learners      Print out only the learners information
    -t, --teacher       Print out only the teachers information
    -c, --create        Create a new user when given a name
    -u, --update        Update a user when given a user ID
    -d, --delete        Delete a user when given a user ID
    -h, --help          Print out this help
    
    Example:
    \$ php users.php -h
    \$ php users.php -a
    \$ php users.php -c -n 'John Doe' -e 'john@gmail.com' -r 'Teacher'
    \$ php users.php -u 1 -n 'Jean Doe' 
    \$ php users.php -d 1 " . PHP_EOL;

    /**
     * Set up the test environment before each test method is run.
     * This method is called before each test method in the class.
     */
    protected function setUp(): void {
        $this->mockLibrary = $this->createMock(Library::class);
        $this->userRepository = new UserRepository($this->mockLibrary);
    }

    /**
     * Testing `printHelp' method 
     * Chec
     */
    public function testPrintHelp() {
        ob_start();
        $this->userRepository->printHelp();
        $output = ob_get_clean();
        $this->assertEquals($this->mockHelpString, $output);
    }

    /**
     * Testing `printAll' method 
     * Checking if 'getFormattedUsers' is called 
     */
    public function testPrintAll() {
        $userRepoMockOnlyTestMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['getFormattedUsers'])
            ->getMock();
        $userRepoMockOnlyTestMethod->expects($this->once())
            ->method('getFormattedUsers');
        $userRepoMockOnlyTestMethod->printAll();
    }

    /**
     * Testing `handleCustomOption' method 
     * Checking if 'printLearners' is called when valid option (-l) is passed
     */
    public function testHandleCustomOptionValidOption() {
        $mockOptions = ['l' => false];

        $userRepoMockOnlyTestMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['printLearners'])
            ->getMock();
        $userRepoMockOnlyTestMethod->expects($this->once())
            ->method('printLearners');
        $userRepoMockOnlyTestMethod->handleCustomOption($mockOptions);
    }

    /**
     * Testing `handleCustomOption' method 
     * Checking if 'printLearners' is not called when invalid option (-w) is passed
     * and an exception is thrown with correct message
     */
    public function testHandleCustomOptionInvalidOption() {
        $mockOptions = ['w' => false];

        $userRepoMockOnlyTestMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['printLearners'])
            ->getMock();
        $userRepoMockOnlyTestMethod->expects($this->never())
            ->method('printLearners');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The option provided is not supported or missing parameters!");
        $userRepoMockOnlyTestMethod->handleCustomOption($mockOptions);
    }

    /**
     * Testing `printTeachers' method 
     * Checking if 'getFormattedUsers' is called after calling 'printTeachers'
     */
    public function testPrintTeachers() {
        $userRepoMockOnlyTestMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['getFormattedUsers'])
            ->getMock();
        $userRepoMockOnlyTestMethod->expects($this->once())
            ->method('getFormattedUsers');
        $userRepoMockOnlyTestMethod->printTeachers();
    }

    /**
     * Testing `printLearners' method 
     * Checking if 'getFormattedUsers' is called after calling 'printLearners'
     */
    public function testPrintLearners() {
        $userRepoMockOnlyTestMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$this->mockLibrary])
            ->onlyMethods(['getFormattedUsers'])
            ->getMock();
        $userRepoMockOnlyTestMethod->expects($this->once())
            ->method('getFormattedUsers');
        $userRepoMockOnlyTestMethod->printLearners();
    }

    /**
     * Testing `create' method 
     * Checking if a user is created successfully with valid arguments
     */
    public function testCreate() {
        $userRepository = new UserRepository($this->mockLibrary);
        $args = ['-n', 'John Doe', '-e', 'john@example.com', '-r', 'Teacher'];
        $this->expectOutputRegex("/User created successfully:/");
        $userRepository->create($args);
    }

    /**
     * Testing `create' method 
     * Checking if a user cannot be created with an invalid email
     * and an exception is thrown with correct message
     */
    public function testCreateInvalidEmail() {
        $args = ['-n', 'John Doe', '-e', 'xyml#321', '-r', 'Teacher'];
        //$this->expectOutputString("Error: Email is not valid\n");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Error: Email is not valid.');
        $this->userRepository->create($args);
    }

    /**
     * Testing `update' method 
     * Checking if a user is created successfully with a valid id (correct id/index from users array)
     */
    public function testUpdate() {
        $mockArgs = [1, '-n', 'Gold'];
        $mockId = 1;
        $lib = new Library();
        $userRepository = new UserRepository($lib);
        $this->expectOutputRegex("/User updated successfully:/");
        $userRepository->update($mockId, $mockArgs);
    }

    /**
     * Testing `update' method 
     * Checking if a user cannot be updated with an invalid id
     * and an exception is thrown with correct message
     */
    public function testUpdateInvalidId() {
        $mockArgs = [12, '-n', 'Gold'];
        $mockId = 12;
        $lib = new Library();
        $userRepository = new UserRepository($lib);
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage("Error: No user found with ID $mockId.");
        $userRepository->update($mockId, $mockArgs);
    }

    /**
     * Testing `delete' method 
     * Checking if a user is deleted successfully with a valid id (correct id/index from users array)
     */
    public function testDelete() {
        $mockId = 1;
        $lib = new Library();
        $userRepository = new UserRepository($lib);
        $this->expectOutputRegex("/User with ID " . $mockId . " was deleted successfully./");
        $userRepository->delete($mockId);
    }

    /**
     * Testing `delete' method 
     * Checking if a user cannot be deleted with an invalid id
     * and an exception is thrown with correct message
     */
    public function testDeleteUserInvalidId() {
        $mockId = 12;
        $lib = new Library();
        $userRepository = new UserRepository($lib);
        $this->expectException(OutOfRangeException::class);
        $this->expectExceptionMessage("Error: No user found with ID $mockId.");
        $userRepository->delete($mockId);
    }

    /**
     * Testing `getFormattedUsers' method 
     * Checking if the correct formatted users are returned
     * after replacing the JSON data with a mock data
     */
    public function testGetFormattedUsers() {
        $mockUserData = [
            'isUserInfo' => true,
            'users' => [
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'role' => 'Learner',
                    'classes' => [['id' => 101], ['id' => 102]]
                ],
                [
                    'id' => 2,
                    'name' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'role' => 'Teacher',
                    'classes' => [['id' => 101]]
                ]
            ]
        ];
        $mockClassData = [
            'classes' => [
                ['id' => 101, 'name' => 'Math', 'location' => 'Room A'],
                ['id' => 102, 'name' => 'Science', 'location' => 'Lab B']
            ]
        ];
        $this->mockLibrary->expects($this->exactly(2))
            ->method('getUsersFromSchool')
            ->willReturnOnConsecutiveCalls($mockUserData, $mockClassData);
        $formattedUsers = $this->userRepository->getFormattedUsers();
        // Assertions
        $this->assertCount(2, $formattedUsers);
        // Check first user
        $this->assertEquals('John Doe', $formattedUsers[0]['name']);
        $this->assertEquals('john@example.com', $formattedUsers[0]['email']);
        $this->assertEquals('Learner', $formattedUsers[0]['role']);
        $this->assertEquals(['Math: Room A', 'Science: Lab B'], $formattedUsers[0]['courseInfo']);
        // Check second user
        $this->assertEquals('Jane Smith', $formattedUsers[1]['name']);
        $this->assertEquals('jane@example.com', $formattedUsers[1]['email']);
        $this->assertEquals('Teacher', $formattedUsers[1]['role']);
        $this->assertEquals(['Math: Room A'], $formattedUsers[1]['courseInfo']);
    }
}
