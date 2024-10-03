<?php

use PHPUnit\Framework\TestCase;

require_once('./Repository/userRepository.php');
require_once 'commandHandler.php';

/**
 * Unit Tests for the CommandHandler class.
 */
class CommandHandlerTest extends TestCase { 
    private $userRepository;
    private $mockLibrary;
    /**
     * Set up the test environment before each test method is run.
     * This method is called before each test method in the class.
     */
    protected function setUp(): void {
        $this->mockLibrary = $this->createMock(Library::class);
        $this->userRepository = new UserRepository($this->mockLibrary);
    }

    /**
     * Testing `handle` method with valid commands
     * 
     */
    public function testHandleValidCommand() {
        // Simulate command line options for creating a user
        $options = ['c' => '-n'];
        $mockedArgv = [
            'users.php',
            '-c',
            '-n',
            'Pearl'
        ];

        $mockArgs = ['-n', 'Pearl'];
        $mockLibrary = $this->createMock(Library::class);
        // Mock the UserRepository with the expectation that 'create' is called once with $mockArgs
        $userRepositoryMockSingleMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$mockLibrary])
            ->onlyMethods(['create'])
            ->getMock();

        // Expect 'create' to be called once with $mockArgs
        $userRepositoryMockSingleMethod->expects($this->once())
            ->method('create')
            ->with($mockArgs);

        // Mock the CommandHandler and mock 'extractArgs' to return $mockArgs
        $commandHandlerMock = $this->getMockBuilder(CommandHandler::class)
            ->setConstructorArgs([$userRepositoryMockSingleMethod])
            ->onlyMethods(['extractArgs'])
            ->getMock();

        // Expect 'extractArgs' to be called once and return $mockArgs
        $commandHandlerMock->expects($this->once())
            ->method('extractArgs')
            ->with($options, $mockedArgv)
            ->willReturn($mockArgs);

        $commandHandlerMock->handle($options, $mockedArgv);
    }

    /**
     * Testing `handle` method with missing commands
     * 
     */
    public function testHandleMissingCommand() {
        $options = ['c' => '-n'];
        // Missing 'Pearl' (name) argument
        $mockedArgv = [
            'users.php',
            '-c',
            '-n'
        ];
        $commandHandler = new CommandHandler($this->userRepository);
        // Expect an exception instead of output
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Error: Name is mandatory for creating a user.");
        // Call handle() and the exception should be thrown
        $commandHandler->handle($options, $mockedArgv);
    }

    /**
     * Testing `extractArgs` method called by valid functions
     * such as update and create
     */
    public function testExtractArgsRightFunction() {
        // Simulate command line options for creating a user
        $options = ['u' => '1'];
        $mockedArgv = [
            'users.php',
            '-u',
            '1',
            '-n',
            'Gold'
        ];

        $mockArgs = [1,'-n', 'Gold'];
        $mockArgsPassToUpdate = ['-n', 'Gold'];
        $mockId = 1;
        // Mock the UserRepository with the expectation that 'create' is called once with $mockArgs
        $mockLibrary = $this->createMock(Library::class);
        $userRepositoryMockSingleMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$mockLibrary])
            ->onlyMethods(['update'])
            ->getMock();

        // Expect 'create' to be called once with $mockArgs
        $userRepositoryMockSingleMethod->expects($this->once())
            ->method('update')
            ->with($mockId, $mockArgsPassToUpdate);

        // Mock the CommandHandler and mock 'extractArgs' to return $mockArgs
        $commandHandlerMock = $this->getMockBuilder(CommandHandler::class)
            ->setConstructorArgs([$userRepositoryMockSingleMethod])
            ->onlyMethods(['extractArgs'])
            ->getMock();

        // Expect 'extractArgs' to be called once and return $mockArgs
        $commandHandlerMock->expects($this->once())
            ->method('extractArgs')
            ->with($options, $mockedArgv)
            ->willReturn($mockArgs);

        $commandHandlerMock->handle($options, $mockedArgv);
    }

    /**
     * Testing `extractArgs` method called by functions
     * that are not supposed to call extractArgs ,such as help
     */
    public function testExtractArgsWrongFunction() {
        // Simulate command line options for creating a user
        $options = ['h' => false];
        $mockedArgv = [
            'users.php',
            '-h'
        ];

        // Mock the UserRepository with the expectation that 'create' is called once with $mockArgs
        $mockLibrary = $this->createMock(Library::class);
        $userRepositoryMockSingleMethod = $this->getMockBuilder(UserRepository::class)
            ->setConstructorArgs([$mockLibrary])
            ->onlyMethods(['printHelp'])
            ->getMock();

        // Expect 'create' to be called once 
        $userRepositoryMockSingleMethod->expects($this->once())
            ->method('printHelp');

        // Mock the CommandHandler and mock 'extractArgs' to return $mockArgs
        $commandHandlerMock = $this->getMockBuilder(CommandHandler::class)
            ->setConstructorArgs([$userRepositoryMockSingleMethod])
            ->onlyMethods(['extractArgs'])
            ->getMock();

        // Expect 'extractArgs' to be called never
        $commandHandlerMock->expects($this->never())
            ->method('extractArgs')
            ->with($options, $mockedArgv);

        $commandHandlerMock->handle($options, $mockedArgv);
    }
}
