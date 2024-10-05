<?php

require_once 'lib.php';

includeAutoLoad();

use MyApp\Services\JsonDataLoader;
use MyApp\Services\SchoolDataManager;
use MyApp\Repositories\UserRepository;
use MyApp\Repositories\CourseRepository;
use MyApp\Repositories\EnrollmentRepository;
use MyApp\Storage\JsonStorage;

$jsonFilePath = __DIR__ . '/data.json';
$coursesPath = __DIR__ . '/Data/Json/courses.json';
$usersPath = __DIR__ . '/Data/Json/users.json';
$enrollmentsPath = __DIR__ . '/Data/Json/enrollments.json';

// Create the JsonDataLoader to load data from the file
$jsonLoader = new JsonDataLoader($jsonFilePath);

// Create the repositories
$storage = new JsonStorage($usersPath); 
$userRepository = new UserRepository($storage);

$storage = new JsonStorage($coursesPath); 
$courseRepository = new CourseRepository($storage);

$storage = new JsonStorage($enrollmentsPath); 
$enrollmentRepository = new EnrollmentRepository($storage);

// Create the SchoolDataManager with all the required dependencies
$schoolDataManager = new SchoolDataManager(
    $jsonLoader, 
    $userRepository, 
    $courseRepository,
    $enrollmentRepository
);

// Import data from the JSON file and populate repositories
$schoolDataManager->importData();