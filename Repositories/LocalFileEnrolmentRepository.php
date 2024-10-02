<?php
namespace Repository;

use Config\Constants;
use Model\Course;
use Model\User;

class LocalFileEnrolmentRepository implements EnrolmentRepositoryInterface
{
    public function getDataFromSource() {
        return json_decode(file_get_contents(Constants::DATA_SOURCE_LOCAL_FILE), true);
    }

    /**
     * @param string $name
     * @return int[]
     */
    public function getClassIdsByUserName(string $name): array
    {
        $data = $this->getDataFromSource();

        $filteredUsers = array_filter($data['users'], function ($user) use ($name) {
            return $user['name'] === $name;
        });

        return array_map(function($class) {
            return $class['id'];
        }, reset($filteredUsers)['classes'] ?? []);
    }

    /**
     * @param User $user
     * @param Course $course
     * @return User
     */
    public function enrollUserToCourse(User $user, Course $course): User
    {
        // TODO save into data source, here only returns the updated resource
        $user->addEnrolment($course);
        return $user;
    }

    /**
     * @param User $user
     * @param Course $course
     * @return User
     */
    public function unEnrollUserFromCourse(User $user, Course $course): User
    {
        // TODO delete from the data source, here only returns the deleted instance
        $user->removeEnrolment($course);
        return $user;
    }
}