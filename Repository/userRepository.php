<?php

require_once('./library.php');
require_once('repositoryInterface.php');

class UserRepository implements RepositoryInterface {

    private $users;
    private $config;
    private $library;

    public function __construct(Library $library) {
        // Use Library class to get data
        $this->library = $library;
        $this->users = $library->getJsonData();
        $this->config = require 'config.php';
    }

    public function printHelp(): void {
        echo $this->config['USER_HELP_TEXT'] . PHP_EOL;
    }

    public function printAll(): void {
        echo 'All users:' . PHP_EOL;
        print_r($this->getFormattedUsers());
    }

    // Handle custom options specific to this Repo only
    public function handleCustomOption($options, $argv = null): void {
        if (isset($options['l']) || isset($options['learners'])) {
            $this->printLearners();
        } elseif (isset($options['t']) || isset($options['teachers'])) {
            $this->printTeachers();
        } else {
            throw new InvalidArgumentException("The option provided is not supported or missing parameters!");
        }
    }

    // return the users expected in the output 
    public function getFormattedUsers(): array {
        $allUsers = $this->getAllUsers();
        $allClasses = $this->getClassInfo();

        return array_filter(array_map(function ($user) use ($allClasses) {
            $user['courseInfo'] = $this->getUserCourseInfo($user, $allClasses);
            unset($user['classes']);
            return $user;
        }, $allUsers), [$this, 'isValidUser']);
    }

    private function getAllUsers(): array {
        $allUsers = $this->library->getUsersFromSchool(true, null);
        return $allUsers['isUserInfo'] ? $allUsers['users'] : $allUsers;
    }

    private function getClassInfo(): array {
        return $this->library->getUsersFromSchool(false, null);
    }

    private function getUserCourseInfo($user, $classInfo): array {
        return array_reduce($user['classes'], function ($carry, $class) use ($classInfo) {
            foreach ($classInfo['classes'] as $value) {
                if ($value['id'] == $class['id'] && isset($value['location'])) {
                    $carry[] = "{$value['name']}: {$value['location']}";
                }
            }
            return $carry;
        }, []);
    }

    private function isValidUser($user): bool {
        return !empty($user['courseInfo']) && (isset($user['email']) || isset($user['role']));
    }

    public function create($args): void {
        $parsedArgs = $this->parseArgs($args);

        if (!$parsedArgs['name']) {
            throw new InvalidArgumentException("Error: Name is mandatory for creating a user.");
        }
        $newUser = [];
        $newUser['name'] = $parsedArgs['name'];
        if ($parsedArgs['email'] && !$this->validateEmail($parsedArgs['email'])) {
            throw new InvalidArgumentException("Error: Email is not valid.");
        }
        if ($parsedArgs['email'])
            $newUser['email'] = $parsedArgs['email'];
        if ($parsedArgs['role'])
            $newUser['role'] = $parsedArgs['role'];

        $this->users['users'][] = $newUser;
        echo "User created successfully: " . PHP_EOL;
        print_r($newUser);

        // Optionally, print the updated users array
        echo "Users after creating a new record: " . PHP_EOL;
        print_r($this->users['users']);
    }

    private function validateEmail($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function parseArgs($args): array {
        $parsed = ['name' => null, 'email' => null, 'role' => null];
        for ($i = 0; $i < count($args); $i += 2) {
            switch ($args[$i]) {
                case '-n':
                    $parsed['name'] = $args[$i + 1] ?? null;
                    break;
                case '-e':
                    $parsed['email'] = $args[$i + 1] ?? null;
                    break;
                case '-r':
                    $parsed['role'] = $args[$i + 1] ?? null;
                    break;
            }
        }
        return $parsed;
    }

    public function update($userId, $args): void {
        $parsedArgs = $this->parseArgs($args);
        if (!isset($this->users['users'][$userId])) {
            throw new OutOfRangeException("Error: No user found with ID $userId.");
        }
        // Update user attributes if provided
        if ($parsedArgs['name']) $this->users['users'][$userId]['name'] = $parsedArgs['name'];
        if ($parsedArgs['email'] && !$this->validateEmail($parsedArgs['email'])) {
            throw new InvalidArgumentException("Error: Email is not valid.");
        }
        if ($parsedArgs['email']) $this->users['users'][$userId]['email'] = $parsedArgs['email'];
        if ($parsedArgs['role']) $this->users['users'][$userId]['role'] = $parsedArgs['role'];
        echo "User updated successfully: " . PHP_EOL;
        print_r($this->users['users'][$userId]);
    }

    public function delete($userId): void {
        if (!isset($this->users['users'][$userId])) {
            throw new OutOfRangeException("Error: No user found with ID $userId.");
        }
        // Remove the user from the users array
        unset($this->users['users'][$userId]);
        // Reindex the array to maintain sequential keys (optional)
        $this->users['users'] = array_values($this->users['users']);
        // Confirm deletion
        echo "User with ID $userId was deleted successfully." . PHP_EOL;
    }

    public function printTeachers(): void {
        echo 'Teachers:' . PHP_EOL;
        $users = $this->getFormattedUsers(); 
        foreach ($users as $user) {
            if (array_key_exists('role', $user) && $user['role'] == $this->config['ROLE_TEACHER']) {
                echo $user['name'] . PHP_EOL;
            }
        }
    }

    public function printLearners(): void {
        echo 'Learners: ' . PHP_EOL;
        $users = $this->getFormattedUsers(); 
        foreach ($users as $user) { 
            if (!array_key_exists('role', $user) || $user['role'] == $this->config['ROLE_LEARNER']) {
                echo $user['name'] . PHP_EOL;
            }
        }
    }

    
}
