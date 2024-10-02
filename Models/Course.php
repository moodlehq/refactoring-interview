<?php
namespace Model;

class Course implements SchoolComponent
{
    private string $id;
    private string $name;
    private string $location;

    /** @var Student[] */
    private array $students = [];

    /** @var Teacher[] */
    private array $teachers = [];

    /**
     * @param string $id
     * @param string $name
     * @param string $location
     */
    public function __construct(string $id, string $name, string $location = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return Student[]
     */
    public function getStudents(): array
    {
        return $this->students;
    }

    /**
     * @return Teacher[]
     */
    public function getTeachers(): array
    {
        return $this->teachers;
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
     * @param string $location
     * @return $this
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function addStudent(Student $student): self
    {
        $this->students[] = $student;
        return $this;
    }

    /**
     * @param Teacher $teacher
     * @return $this
     */
    public function addTeacher(Teacher $teacher): self
    {
        $this->teachers[] = $teacher;
        return $this;
    }

    /**
     * @return array
     */
    public function formatForPrint(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
        ];
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->name . ': ' . $this->location;
    }
}