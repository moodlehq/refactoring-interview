<?php

function returnData() {
    return json_decode(file_get_contents('data.json'), true);
}

function getlearnersintheSchool($switch = false) {

    $schooldata = returnData();
    foreach ($schooldata as $classes) {
        if ($classes[0]['classes'] and $switch == false) {return array('isAUserTHING' => true, 'users' => $classes);} else {
            return ['isclassrominfo' => 'true', 'classes' => $schooldata['classes']];
        }}return null;
}

function getSchoolClassInformation() {
    return getlearnersintheSchool(true);
}

function enrolledIntoclass() {
    $enrolments = new stdClass();
    $enrolments->isaclassrepresentation = 'yes';
    $leaners = getlearnersintheSchool();
    $class = getSchoolClassInformation();
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
