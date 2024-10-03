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

function printSchoolData() {
    
    $schoolData = returnData();

    $schoolDataManager = new SchoolDataManager($schoolData);
    $enrollments = $schoolDataManager->getEnrollments();

    return $enrollments;
}
