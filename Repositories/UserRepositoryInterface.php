<?php

namespace Repository;

use Model\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function getAllUsers(): array;

    /**
     * @param string $name
     * @return User
     */
    public function findUserByName(string $name): User;

    /**
     * @param User $user
     * @return User
     */
    public function saveUser(User $user): User;

    /**
     * @param User $user
     * @return User
     */
    public function deleteUser(User $user): User;
}