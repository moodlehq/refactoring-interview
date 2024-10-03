<?php

/**
 * Class User
 *
 * Encapsulates user school data and 
 * function within the system.
 */
class User {

    /**
     * @var string user's name.
     */
    private $name;

    /**
     * @var string user's role.
     */
    private $role;

    /**
     * @var string user's email.
     */
    private $email;

    /**
     * @var array user's courses.
     */
    private $courses = [];

    /**
     * User constructor.
     *
     * @param string $name user's name.
     * @param string $role user's role.
     * @param string $email user's email.
     */
    public function __construct(string $name, ?string $role, ?string $email) {
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
    }

    /**
     * User constructor.
     *
     * @param string $name user's name.
     * @param string $role user's role.
     * @param string $email user's email.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * getRole get user's role.
     *
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * getEmail get user's email.
     *
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * addCourse register user into a course.
     *
     * @param string $course course details.
     * @return void $role user's role.
     */
    public function addCourse(array $course): void {
        $this->courses[] = $course;
    }

    /**
     * User constructor.
     *
     * @return array get course list
     */
    public function getCourses(): array {
        return $this->courses;
    }

    /**
     * User constructor.
     *
     * @return array get user details.
     */
    public function getUserInfo(): array {
        return [
            'name' => $this->name,
            'role' => $this->role,
            'email' => $this->email,
            'courses' => $this->courses
        ];
    }
}
