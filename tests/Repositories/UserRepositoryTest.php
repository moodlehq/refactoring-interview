<?php

use PHPUnit\Framework\TestCase;
use MyApp\Storage\StorageInterface;
use MyApp\Repositories\UserRepository;
use MyApp\Models\User\User;
use MyApp\Storage\JsonStorage;

/**
 * Class UserRepositoryTest
 *
 * Unit tests for the UserRepository class.
 */
class UserRepositoryTest extends TestCase
{
    private $storageMock;
    private $userRepository;

    protected function setUp(): void
    {
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $usersPath = $baseDir.'/tests/Data/Json/users.json';

        // Create the repositories
        $storage = new JsonStorage($usersPath); 
        $this->userRepository = new UserRepository($storage);
    }

    // test if a user can be saved
    public function testSaveUser()
    {
        $timeStamp=time();
        // Arrange
        $user = new User('John Doe', [], 'john'.$timeStamp.'@example.com');

        // Act
        $this->userRepository->save($user);
        $users = $this->userRepository->getAll();
        $found = false;
        foreach ($users as $user) {
            if ($user["email"] == 'john'.$timeStamp.'@example.com') {
                $found=true;
                break;
            }
        }

        // Assert that Jane Doe is found in the users
        $this->assertTrue($found, 'User "Jane Doe" should be in the user list.');
    }

    // test if user can be retreived by an id
    public function testFindByIdReturnsUser()
    {
        // Arrange
        $user = new User('Abed Nadir', [], 'abed@greendale.edu');

        // Act
        $result = $this->userRepository->findById(1);

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    // test the return value when user 
    // id does not exist in the system
    public function testFindByIdReturnsNullWhenUserNotFound()
    {
        // Act
        $result = $this->userRepository->findById(999);

        // Assert
        $this->assertNull($result);
    }
}
