<?php
namespace Repository;

use Config\Constants;
use Exception;
use Model\User;

class LocalFileUserRepository implements UserRepositoryInterface
{
    public function getDataFromSource() {
        return json_decode(file_get_contents(Constants::DATA_SOURCE_LOCAL_FILE), true);
    }

    /**
     * @return User[]
     */
    public function getAllUsers(): array
    {
        $data = $this->getDataFromSource();

        return array_map(function ($user) {
            return new User(
                $user['name'],
                $user['email'] ?? '',
                $user['role'] ?? '',
            );
        }, $data['users']);
    }

    /**
     * @param int $courseId
     * @return User[]
     */
    public function getAllUsersByCourseId(int $courseId): array
    {
        $data = $this->getDataFromSource();

        $usersEnrolled = array_filter($data['users'], function ($user) use ($courseId) {
            $enrolledClasses = array_map(function($class) {
                return $class['id'];
            }, $user['classes'] ?? []);

            return in_array($courseId, $enrolledClasses);
        });

        return array_map(function ($user) {
            return new User(
                $user['name'],
                $user['email'] ?? '',
                $user['role'] ?? '',
            );
        }, $usersEnrolled);
    }

    /**
     * @param string $name
     * @return User
     * @throws Exception
     */
    public function findUserByName(string $name): User
    {
        $data = $this->getDataFromSource();

        $filteredUsers = array_filter($data['users'], function ($user) use ($name) {
            return $user['name'] === $name;
        });

        if (empty($filteredUsers)) {
            throw new Exception('No user found with name ' . $name);
        }

        $user = reset($filteredUsers);

        return new User(
            $user['name'],
            $user['email'] ?? '',
            $user['role'] ?? '',
        );
    }

    /**
     * @param User $user
     * @return User
     */
    public function saveUser(User $user): User
    {
        // TODO save into data source, here only returns the updated resource
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function deleteUser(User $user): User
    {
        // TODO delete from the data source, here only returns the deleted instance
        return $user;
    }
}