<?php

/**
 * Add 0, false, 'false'
 * mock some weird mapping function.
 */

$schooldata = json_decode(file_get_contents('data.json'), true);

$whoiswhere = enrolledIntoclass($schooldata);
//print_r($whoiswhere);

function getlearnersintheSchool($schooldata, $switch = false) {


    foreach ($schooldata as $classes) {
        if ($classes[0]['classes'] and $switch == false) {return array('isAUserTHING' => true, 'users' => $classes);} else {
            return ['isclassrominfo' => 'true', 'classes' => $classes];
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
    foreach ($leaners['users'] as $key => $value) {
        print_r($value);
        foreach ($value['classes'] as $key => $class) {
            //$enrolments->class = $class;
            print_r($class);
        }
    }
    return $enrolments;
}
