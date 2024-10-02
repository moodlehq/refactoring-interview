<?php

namespace Test\Repository;

use Exception;
use Model\User;
use PHPUnit\Framework\TestCase;
use Repository\LocalFileUserRepository;
use Prophecy\PhpUnit\ProphecyTrait;

class LocalFileUserRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private LocalFileUserRepository $partialMockLocalFileUserRepository;

    protected function setUp(): void {
        $this->partialMockLocalFileUserRepository = $this->getMockBuilder(LocalFileUserRepository::class)
            ->onlyMethods(['getDataFromSource'])
            ->getMock();

        $this->partialMockLocalFileUserRepository->expects($this->any())
            ->method('getDataFromSource')
            ->willReturn([
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
            ]);
    }

    public function testGetAllUsers() {
        $users = $this->partialMockLocalFileUserRepository->getAllUsers();
        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals('Bill', $users[0]->getName());
    }

    public function testGetAllUsersByCourseId() {
        $users = $this->partialMockLocalFileUserRepository->getAllUsersByCourseId(1);
        $this->assertInstanceOf(User::class, $users[1]);
        $this->assertEquals('Bob', $users[1]->getName());
    }

    public function testFindUserByName() {
        $user = $this->partialMockLocalFileUserRepository->findUserByName('James');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('James', $user->getName());
    }

    public function testFindUserByNameWhenNotFound() {
        $this->expectException(Exception::class);
        $this->partialMockLocalFileUserRepository->findUserByName('fake-name');
    }

    public function testSaveUser() {
        $user = new User('John');
        $outputUser = $this->partialMockLocalFileUserRepository->saveUser(new User('John'));
        $this->assertEquals($user, $outputUser);
    }

    public function testDeleteUser() {
        $user = new User('John');
        $outputUser = $this->partialMockLocalFileUserRepository->deleteUser(new User('John'));
        $this->assertEquals($user, $outputUser);
    }
}
