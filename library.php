<?php

class Library {
    // Fetches data from a mock JSON source
    public function getJsonData(): array {
        $filePath = 'data.json';  // TODOK: store as a class property after deciding DP
        $jsonData = file_get_contents($filePath);
        if ($jsonData === false) {
            // Added to handle errors in reading the file
            throw new Exception("Unable to read the file: {$filePath}");
        }
        $decodedData = json_decode($jsonData, true);
        // Added to check for JSON errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON decode error: ' . json_last_error_msg());
        }
        if (!is_array($decodedData)) {
            throw new Exception('JSON data is not an array or object');
        }
        return $decodedData;
    }

    // Retrieves users in the school based on the flag and optional override
    // Changed getUsersFromSchool to getUsersFromSchool
    // May need to improve $isUser if there'll be more options in the future in addition to users and classes 
    public function getUsersFromSchool($isUser, $dataOverride = null): array {
        // Shortened the if-else block by using the null coalescing operator (??).
        $schoolData = $dataOverride ?? $this->getJsonData();

        foreach ($schoolData as $classes) {
            // Replaced 'and' with '&&' for better precedence and consistency.
            if ($classes[0]['classes'] && $isUser === true) {
                // Changed “isAUserTHING” to “isUserInfo” for better clarity.
                return ['isUserInfo' => true, 'users' => $classes];
            } else {
                return ['isClassroomInfo' => true, 'classes' => $schoolData['classes']];
            }
        }

        return [];
    }
    // Changed the name of the original method "enrolledIntoClass" to "getEnrollments" for better clarity
    public function getEnrollments($dataOverride = null): stdClass {
        $schoolData = $dataOverride ?? $this->getJsonData();
        $learners = $this->getUsersFromSchool(true, $schoolData);
        $classes = $this->getUsersFromSchool(false, $schoolData);

        $enrolments = $this->initializeEnrolments();

        foreach ($classes['classes'] as $class) {
            $courseId = $class['id'];
            $enrolments->$courseId = $this->initializeCourse($class['name']);
            $this->populateCourseEnrolments($enrolments->$courseId, $learners['users'], $courseId);
        }

        return $enrolments;
    }

    private function initializeEnrolments(): stdClass {
        $enrolments = new stdClass();
        $enrolments->isClassRepresentation = 'yes';
        return $enrolments;
    }

    private function initializeCourse($courseName): stdClass {
        $course = new stdClass();
        $course->name = $courseName;
        $course->students = [];
        $course->teachers = [];
        return $course;
    }

    private function populateCourseEnrolments($course, $users, $courseId): void {
        foreach ($users as $user) {
            if (!$this->isUserEnrolledInCourse($user, $courseId)) {
                continue;
            }

            $userInfo = $this->formatUserInfo($user);
            if ($this->isTeacher($user)) {
                $course->teachers[] = $userInfo;
            } else {
                $course->students[] = $userInfo;
            }
        }
    }

    private function isUserEnrolledInCourse(array $user, int $courseId): bool {
        return in_array($courseId, array_column($user['classes'], 'id'));
    }

    private function formatUserInfo(array $user): string {
        return isset($user['email']) ? "{$user['name']}: {$user['email']}" : $user['name'];
    }

    private function isTeacher(array $user): bool {
        return isset($user['role']) && $user['role'] === 'Teacher';
    }

    // This function will be moved to SchoolRepository after normalizing and 
    // having a solid structure for schools
    public function printSchoolData(): void {
        $info = $this->getEnrollments();
        if (is_object($info) && property_exists($info, 'isClassRepresentation')) {
            unset($info->isClassRepresentation);
        }
        print_r($info);
    }
}
