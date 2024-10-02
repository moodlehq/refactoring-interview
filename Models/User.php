<?php
namespace Model;

class User implements SchoolComponent
{
    private string $name;
    private string $email;
    private string $role;

    /** @var Course[] */
    private array $enrolments;

    /**
     * @param string $name
     * @param string $email
     * @param string $role
     */
    public function __construct(string $name, string $email = '', string $role = 'Student')
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = !empty($role) ? $role : 'Student';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param Course $course
     * @return $this
     */
    public function addEnrolment(Course $course): self
    {
        $this->enrolments[] = $course;
        return $this;
    }

    /**
     * @param Course $course
     * @return $this
     */
    public function removeEnrolment(Course $course): self
    {
        foreach ($this->enrolments as $index => $enrolment) {
            if ($enrolment->getId() === $course->getId()) {
                unset($this->enrolments[$index]);
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === 'Student';
    }

    /**
     * @return bool
     */
    public function isTeacher(): bool
    {
        return $this->role === 'Teacher';
    }

    /**
     * @return array
     */
    public function formatForPrint(): array
    {
        $output = [
            'name' => $this->name
        ];

        if ($this->email) {
            $output['email'] = $this->email;
        }

        if (!$this->isStudent()) {
            $output['role'] = $this->role;
        }

        if (!empty($this->enrolments)) {
            $output['courseinfo'] = array_map(function ($course) {
                return $course->toString();
            }, $this->enrolments);
        }

        return $output;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->getName() . ': ' . $this->getEmail();
    }
}