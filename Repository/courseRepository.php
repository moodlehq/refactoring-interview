<?php

require_once('./library.php');
require_once('repositoryInterface.php');

class CourseRepository implements RepositoryInterface {

    private $courses;
    private $config;
    private $library;

    public function __construct(Library $library) {
        // Use Library class to get data
        $this->library = $library;
        $this->courses = $library->getJsonData();
        $this->config = require 'config.php';
    }

    public function printHelp(): void {
        echo $this->config['COURSE_HELP_TEXT'] . PHP_EOL;
    }

    public function printAll(): void {
        $classInfo = $this->library->getUsersFromSchool(false, null);
        print_r($this->getFormattedCourses($classInfo));
    }

    // Handle custom options specific to this Repo only
    public function handleCustomOption($options, $argv = null): void {
        if (isset($options['p']) || isset($options['participants'])) {
            $this->printParticipants($argv);
        } elseif (isset($options['t']) || isset($options['teachers'])) {
            $this->printTeachers();
        } elseif (isset($options['e']) || isset($options['enroll'])) {
            echo "Should be implemented after normalizing the data store structure";
            // $this->enroll($options, $args);
        } elseif (isset($options['ue']) || isset($options['unenroll'])) {
            echo "Should be implemented after normalizing the data store structure";
            // $this->unenroll($options, $args);
        } else {
            throw new InvalidArgumentException("The option provided is not supported or missing parameters!");
        }
    }

    // return the users expected in the output 
    public function getFormattedCourses($courses): array {
        if (
            array_key_exists('isClassroomInfo', $courses) &&
            ($courses['isClassroomInfo'] === 1 || $courses['isClassroomInfo'] === true)
        ) {
            unset($courses['isClassroomInfo']);
            $courses = $courses['classes'];
        }
        return $courses;
    }

    public function create($args): void {
        $parsedArgs = $this->parseArgs($args);
        if (!$parsedArgs['name']) {
            throw new InvalidArgumentException("Error: Name is mandatory for creating a user.");
        }
        $newCourse = [];
        $newCourse['id'] = count($this->courses['classes']) + 1;
        $newCourse['name'] = $parsedArgs['name'];
        if ($parsedArgs['location'])
            $newCourse['location'] = $parsedArgs['location'];

        $this->courses['classes'][] = $newCourse;
        echo "Course created successfully: " . PHP_EOL;
        print_r($newCourse);

        // Optionally, print the updated courses array
        echo "Courses after creating a new record: " . PHP_EOL;
        print_r($this->courses['classes']);
    }

    private function parseArgs($args): array {
        $parsed = ['name' => null,  'location' => null];
        for ($i = 0; $i < count($args); $i += 2) {
            switch ($args[$i]) {
                case '-n':
                    $parsed['name'] = $args[$i + 1] ?? null;
                    break;
                case '-l':
                    $parsed['location'] = $args[$i + 1] ?? null;
                    break;
            }
        }
        return $parsed;
    }

    public function update($courseId, $args): void {
        $parsedArgs = $this->parseArgs($args);
        $recordToUpdate = array_filter($this->courses['classes'], function ($class) use ($courseId) {
            return $class['id'] === $courseId;
        });
        if (!count($recordToUpdate)) {
            throw new OutOfRangeException("Error: No course found with ID $courseId.");
        }
        if ($parsedArgs['name']) $recordToUpdate[0]['name'] = $parsedArgs['name'];
        if ($parsedArgs['location']) $recordToUpdate[0]['location'] = $parsedArgs['location'];
        echo "Course updated successfully: " . PHP_EOL;
        print_r($recordToUpdate[0]);
    }

    public function delete($courseId): void {
        $courseFound = false;
        foreach ($this->courses['classes'] as $key => $class) {
            if ($class['id'] === $courseId) {
                $courseFound = true;
                unset($this->courses['classes'][$key]);
            }
        }
        if (!$courseFound) {
            throw new OutOfRangeException("Error: No course found with ID $courseId.");
        }
        // Reindex the array to maintain sequential keys (optional)
        $courses = array_values($this->courses['classes']);
        echo "Course with ID $courseId was deleted successfully." . PHP_EOL;
        print_r($courses);
    }

    public function printTeachers(): void {
        echo 'Teachers:' . PHP_EOL;
        $users = $this->library->getUsersFromSchool(true, null);
        foreach ($users['users'] as $user) {
            if (array_key_exists('role', $user) && $user['role'] == $this->config['ROLE_TEACHER']) {
                echo $user['name'] . PHP_EOL;
            }
        }
    }

    public function printParticipants($argv): void {
        if (count($argv) !== 2 || $argv[0] !== '-p' || !is_numeric($argv[1])) {
            throw new InvalidArgumentException("Invalid arguments. Usage: -p <courseId>");
        }
        $courseId = (int)$argv[1];
        $course = $this->getCourseById($courseId);
        if (!$course) {
            throw new OutOfRangeException("Course with ID {$courseId} not found.");
        }
        echo "Participants for {$course['name']}:" . PHP_EOL;
        foreach ($this->courses['users'] as $user) {
            if (
                $this->isUserEnrolledInCourse($user, $courseId) &&
                (!array_key_exists('role', $user) || $user['role'] === $this->config['ROLE_LEARNER'])
            ) {
                echo $user['name'] . PHP_EOL;
            }
        }
    }

    private function getCourseById($courseId): ?array {
        foreach ($this->courses['classes'] as $course) {
            if ($course['id'] === $courseId) {
                return $course;
            }
        }
        return null;
    }

    private function isUserEnrolledInCourse($user, $courseId): bool {
        return isset($user['classes']) && in_array($courseId, array_column($user['classes'], 'id'));
    }
}
