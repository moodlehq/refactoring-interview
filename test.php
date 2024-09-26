<?php

$schooldata = json_decode(file_get_contents('data.json'), true);

$whoiswhere = enrolledIntoclass($schooldata);

print_r($whoiswhere);

function getlearnersintheSchool($schooldata, $switch = false) {


    foreach ($schooldata as $classes) {
        if ($classes[0]['classes'] and $switch == false) {return array('isAUserTHING' => true, 'users' => $classes);} else {
            return ['isclassrominfo' => 'true', 'classes' => $schooldata['classes']];
        }}return null;
}

function getSchoolClassInformation($schooldata) {
    return getlearnersintheSchool($schooldata, true);
}

function enrolledIntoclass($schooldata) {
    $enrolments = new stdClass();
    $enrolments->isaclassrepresentation = 'yes';
    $leaners = getlearnersintheSchool($schooldata);
    $class = getSchoolClassInformation($schooldata);
    foreach ($class['classes'] as $key => $value) {
        $courseid = $value['id'];
        $coursename = $value['name'];
        $enrolments->$courseid = new stdClass();
        $enrolments->$courseid->name = $coursename;
        $enrolments->$courseid->students = [];

        foreach ($leaners['users'] as $key => $value) {
            foreach ($value['classes'] as $key => $class) {
                if ($class['id'] == $courseid) {
                    $enrolments->$courseid->students[] = $value['name'];
                }
            }
        }
    }
    return $enrolments;
}

function userCRUD($action = 'R') {
    if ($action == 'C') {
        //return createLearner();
    } else if ($action == 'R') {
        //return readLearner();
    } else if ($action == 'U') {
        //return updateLearner();
    } else if ($action == 'D') {
        //return deleteLearner();
    }
}

function courseCRUD($action = 'R') {
    if ($action == 'C') {
        //return createCourse();
    } else if ($action == 'R') {
        //return readCourse();
    } else if ($action == 'U') {
        //return updateCourse();
    } else if ($action == 'D') {
        //return deleteCourse();
    }
}
