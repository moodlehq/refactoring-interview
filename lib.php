<?php

require_once 'SchoolDataManager.php';

function returnData() {
    return json_decode(file_get_contents('data.json'), true);
}

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

function getSchoolClassInformation($dataoverride = null) {
    if (!$dataoverride) {
        $schooldata = returnData();
    } else {
        $schooldata = $dataoverride;
    }
    return getlearnersintheSchool($schooldata,true);
}

function enrolledIntoclass($dataoverride = null) {
    if (!$dataoverride) {
        $schooldata = returnData();
    } else {
        $schooldata = $dataoverride;
    }
    $enrolments = new stdClass();
    $enrolments->isaclassrepresentation = 'yes';
    $leaners = getlearnersintheSchool($schooldata, false);
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
                    if (array_key_exists('role', $value) and $value['role'] == 'Teacher' and isset($value['email'])) {
                        $enrolments->$courseid->teachers = $value['name'] . ': ' . $value['email'];
                    } else {
                        if (isset($value['email'])) {
                            $enrolments->$courseid->students[] = $value['name'] . ': ' . $value['email'];
                        }
                    }
                }
            }
        }
    }
    return $enrolments;
}

function printSchoolData() {
    
    $schoolData = returnData();

    $schoolDataManager = new SchoolDataManager($schoolData);
    $enrollments = $schoolDataManager->getEnrollments();

    return $enrollments;
}
