<?php
/*
* Currently, models are not applied in the Repository as
* the refactoring was done using the existing JSON data
*/
class Course {
    private $courseId;
    private $courseName;
    private $location;  // Optional
    private $time;      // Optional

    // Constructor with optional parameters for location and time
    public function __construct($courseId, $courseName, $location = null, $time = null) {
        $this->courseId = $courseId;
        $this->courseName = $courseName;
        $this->location = $location;
        $this->time = $time;
    }

    // Getters
    public function getCourseId() {
        return $this->courseId;
    }

    public function getCourseName() {
        return $this->courseName;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getTime() {
        return $this->time;
    }

    // Setters
    public function setLocation($location) {
        $this->location = $location;
    }

    public function setTime($time) {
        $this->time = $time;
    }
}
