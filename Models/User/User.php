<?php

namespace MyApp\Models\User;

use MyApp\Models\Role\Role;
use MyApp\Models\Course\Course;

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
     * @var string user's email.
     */
    private $email;

    /**
     * @var array user's courses.
     */
    private $courses = [];

    /**
     * @var array User roles.
     */
    private array $roles = [];

    /**
     * User constructor.
     *
     * @param string $name user's name.
     * @param array $roles user's roles.
     * @param string $email user's email.
     */
    public function __construct(
        string $name, 
        ?array $roles, 
        ?string $email
    ) {
        $this->name = $name;
        $this->roles = $roles;
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
     * @return array
     */
    public function addRole(Role $role): ?array {
        return $this->roles[]=$role;
    }

    /**
     * getRoles get user's roles.
     *
     * @return string
     */
    public function getRoles(): array {

        $rolesArray = [];
        foreach ($this->roles as $role) {
            $rolesArray[]=$role->getRoleName();
        }
        return $rolesArray;
    }

    /**
     * getEmail get user's email.
     *
     * @return string
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * addCourse register user into a course.
     *
     * @param string $course course details.
     * @return void $role user's role.
     */
    public function addCourse(Course $course): void {
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
    public function toArray(): array {
        return [
            'name' => $this->name,
            'role' => $this->roles,
            'email' => $this->email,
            'courses' => $this->courses
        ];
    }

    /**
     * User name and role as string.
     *
     * @return array get user details.
     */
    public function __toString(): string {
        $roles = '';

        $count = 0;
        foreach ($this->roles as $role) {
            $roles .= $role->getRoleName();

            if ($count < sizeof($this->roles) - 1) {
                $roles .= ',';
            }

            $count++;
        }

        return $this->name . " (" . $roles . ")";
    }
}
