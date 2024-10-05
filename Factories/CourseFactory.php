<?php

namespace MyApp\Factories;

use MyApp\Models\Course\Course;
use MyApp\Models\Location\Location;

/**
 * Class CourseFactory
 *
 * Responsible for creating Course objects from course data arrays.
 */
class CourseFactory {

    /**
     * Create a Course object from an associative array of course data.
     *
     * @param array $courseData The array containing course details like name, coordinates, and id.
     * @return Course The created Course object.
     */
    public static function createCourse(array $courseData): Course {

        $location = new Location($courseData['location']??'');

        return new Course(
            $courseData['id']??0, 
            $courseData['name']??'', 
            $location, 
            
        );
    }
}
