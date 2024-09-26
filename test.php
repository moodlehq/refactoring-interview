<?php

/**
 * Add 0, false, 'false'
 * Create a learner
 * Create a course
 * Read course information
 * Read learner information
 * Update course enrollments
 * Update learner information
 * Delete a course
 * Delete a learner
 */

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
