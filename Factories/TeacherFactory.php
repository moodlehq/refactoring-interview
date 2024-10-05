<?php

namespace MyApp\Factories;

use MyApp\Models\User\Teacher;

/**
 * Class TeacherFactory
 *
 * Responsible for creating User objects from user data arrays.
 */
class TeacherFactory {

    /**
     * Create a Teacher object from an associative array of user data.
     *
     * @param array $teacherData The array containing teacher details (e.g name, email, id)
     * @return Teacher The created Teacher object.
     */
    public static function createTeacher(array $teacherData): Teacher {
        // create a teacher object
        $teacher = new Teacher(
            $teacherData['name'], 
            $teacherData['email']??'', 
            $teacherData['id']??0
        );

        // Parse courses the Teacher is assigned to
        foreach ($teacherData['courses']??[] as $courseData) {
            $course = CourseFactory::createCourse($courseData);
            $teacher->assignCourse($course);
        }

        return $teacher;
    }
}