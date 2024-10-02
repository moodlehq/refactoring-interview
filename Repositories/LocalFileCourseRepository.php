<?php
namespace Repository;

use Config\Constants;
use Exception;
use Model\Course;

class LocalFileCourseRepository implements CourseRepositoryInterface
{
    public function getDataFromSource() {
        return json_decode(file_get_contents(Constants::DATA_SOURCE_LOCAL_FILE), true);
    }

    /**
     * @return Course[]
     */
    public function getAllCourses(): array
    {
        $data = $this->getDataFromSource();

        return array_map(function ($class) {
            return new Course(
                $class['id'],
                $class['name'],
                $class['location'] ?? ''
            );
        }, $data['classes']);
    }

    /**
     * @param string $courseId
     * @return Course
     * @throws Exception
     */
    public function findCourseById(string $courseId): Course
    {
        $data = $this->getDataFromSource();

        $filteredClasses = array_filter($data['classes'], function ($class) use ($courseId) {
            return $class['id'] == $courseId;
        });

        if (empty($filteredClasses)) {
            throw new Exception('No course found with id ' . $courseId);
        }

        $class = reset($filteredClasses);

        return new Course(
            $class['id'],
            $class['name'],
            $class['location'] ?? ''
        );
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function saveCourse(Course $course): Course
    {
        // TODO save into data source, here only returns the updated resource
        return $course;
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function deleteCourse(Course $course): Course
    {
        // TODO delete from the data source, here only returns the deleted instance
        return $course;
    }
}