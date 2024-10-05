<?php

use MyApp\SchoolDataManager;
use MyApp\Repositories\SchoolRepository;
use MyApp\Repositories\UserRepository;
use MyApp\Repositories\CourseRepository;
use MyApp\Repositories\EnrollmentRepository;
use MyApp\Storage\JsonStorage;
use MyApp\Factories\TeacherFactory;
use MyApp\Factories\StudentFactory;

function returnData() {
    return json_decode(
        file_get_contents('data.json'),
        true
    );
}

// get users in the system if switch is set to false and users have classes
// otherwise get classes information
function getlearnersintheSchool($dataoverride = null, $switch) {

    if (!$dataoverride) {
        $schooldata = returnData();
    } else {
        $schooldata = $dataoverride;
    }

    foreach ($schooldata as $classes) {
        if ($classes[0]['classes'] and $switch == false) {return array('isAUserTHING' => true, 'users' => $classes);} else {
            return ['isclassrominfo' => 'true', 'classes' => $schooldata['classes']];
        }}return null;
}

function getShoolPupils() {
    $schoolData = returnData();
    $schoolDataManager = new SchoolDataManager($schoolData);

    $users = $schoolDataManager->getUsers();

    return $users;
}

function getSchoolCourses() {
    $schoolData = returnData();
    $schoolDataManager = new SchoolDataManager($schoolData);

    $courses = $schoolDataManager->getCourses();

    return $courses;
}

function getSchoolClassInformation($dataoverride = null) {
    if (!$dataoverride) {
        $schooldata = returnData();
    } else {
        $schooldata = $dataoverride;
    }
    return getlearnersintheSchool($schooldata,true);
}

// print all of school's data
function printSchoolData() {
    
    return [
        'users' => getAllUsers(),
        'courses' => getAllCourses(),
        'enrollments' => getAllEnrollments(),
    ];

}

// get user repository
// this can be very easily swaped over with another type of repository
function getUserReposioty() {
    $usersPath = __DIR__ . '/Data/Json/users.json';

    // Create the repositories
    $storage = new JsonStorage($usersPath); 
    return new UserRepository($storage);
}

// get courses repository
// this can be very easily swaped over with another type of repository
function getCoursesRepository() {
    $coursesPath = __DIR__ . '/Data/Json/courses.json';

    // Create the repositories
    $storage = new JsonStorage($coursesPath); 
    return new CourseRepository($storage);
}

// get enrollment repository
// this can be very easily swaped over with another type of repository
function getEnrollmentsRepository() {
    $enrollmentsPath = __DIR__ . '/Data/Json/enrollments.json';

    $storage = new JsonStorage($enrollmentsPath); 
    return new EnrollmentRepository($storage);
}

// get all users
function getAllUsers() {

    $userRepository = getUserReposioty();

    // print the users
    return ($userRepository->getAll());
}

function getTeachersInforamtion() {
    $userRepository = getUserReposioty();

    // print the users
    $users = ($userRepository->getAll());
    $teachers = [];

    foreach ($users as $user) {
        
        $roles=$user['role']??[];
        if (in_array('Teacher', $roles)) {
            $teachers[] = $user;
        }
    }

    return $teachers;
 }

 function getStudentsInforamtion() {
    $userRepository = getUserReposioty();

    // print the users
    $users = ($userRepository->getAll());
    $students = [];

    foreach ($users as $user) {
        
        $roles=$user['role']??[];
        if (in_array('Student', $roles)) {
            $students[] = $user;
        }
    }

    return $students;
 }

// get all courses
function getAllCourses() {
    
    $courseRepository = getCoursesRepository();

    return ($courseRepository->getAll());
}

// get all enrollments
function getAllEnrollments() {

    $enrollmentRepository = getEnrollmentsRepository();

    return ($enrollmentRepository->getAll());
}

// create a user
function createUser($type, $userData) {
    
    $user=null;

    // create a teacher
    if ($type == 'Teacher') {
        $user = TeacherFactory::createTeacher($userData);
    }else{
        $user = StudentFactory::createStudent($userData);
    }

    return getUserReposioty()->save($user);
}

// autoload
function includeAutoLoad() {
    if (file_exists('./vendor/autoload.php')) {
        // echo "autoload.php exists." . PHP_EOL;
        require_once './vendor/autoload.php';
        // echo "Autoload included." . PHP_EOL;
    } else {
        echo "autoload.php does not exist." . PHP_EOL;
    }
}
