<?php

namespace MyApp\Factories;

use MyApp\Models\User\Student;

/**
 * Class StudentFactory
 *
 * Responsible for creating Student objects from Student data arrays.
 */
class StudentFactory {

    /**
     * Create a Student object from an associative array of Student data.
     *
     * @param array $StudentData The array containing Student details (e.g name, email, id)
     * @return Student The created Student object.
     */
    public static function createStudent(array $studentData): Student {
        // cerate a student object
        $student = new Student(
            $studentData['name'], 
            $studentData['email']??null, 
            $studentData['id']??null
        );

        // Parse courses the student is enrolled in
        foreach ($studentData['courses']??[] as $courseData) {
            $course = CourseFactory::createCourse($courseData);
            $student->enrollInCourse($course);
        }

        return $student;
    }
}