<?php

namespace Builder;

use Model\Course;
use Model\School;
use Model\Student;
use Model\Teacher;

class SchoolBuilder
{
    private School $school;

    public function __construct()
    {
        $this->school = new School();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function addCoursesFromData(array $data): self
    {
        $classes = $data['classes'];

        foreach ($classes as $class) {
            $this->school->addCourse(
                new Course(
                    $class['id'],
                    $class['name'],
                    $class['location'] ?? ''
                )
            );
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function addUsersFromData(array $data): self
    {
        $users = $data['users'];
        $courses = $this->school->getCourses();

        foreach ($users as $user) {
            $role = $user['role'] ?? '';

            foreach ($user['classes'] as $classEnrolment) {
                $courseId = $classEnrolment['id'];

                if (!$courses[$courseId]) {
                    continue;
                }

                if ($role === 'Teacher') {
                    $courses[$courseId]->addTeacher(new Teacher($user['name'], $user['email'] ?? ''));
                } else {
                    $courses[$courseId]->addStudent(new Student($user['name'], $user['email'] ?? ''));
                }
            }
        }

        $this->school->setCourses($courses);
        return $this;
    }

    public function build(): School
    {
        return $this->school;
    }
}