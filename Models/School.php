<?php
namespace Model;

class School implements SchoolComponent
{
    /** @var Course[] */
    private array $courses = [];

    /**
     * @return Course[]
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    /**
     * @param array $courses
     * @return $this
     */
    public function setCourses(array $courses): self
    {
        $this->courses = $courses;
        return $this;
    }

    public function addCourse(Course $course): self
    {
        $this->courses[$course->getId()] = $course;
        return $this;
    }

    /**
     * @return array
     */
    public function formatForPrint(): array
    {
        return array_map(function ($course) {
            $students = array_map(function ($student) {
                return $student->toString();
            }, $course->getStudents());

            $teachers = array_map(function ($student) {
                return $student->toString();
            }, $course->getTeachers());

            return [
                'name' => $course->getName(),
                'students' => $students,
                'teachers' => $teachers,
            ];
        }, $this->courses);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        // TODO: Implement toString() method.
    }
}