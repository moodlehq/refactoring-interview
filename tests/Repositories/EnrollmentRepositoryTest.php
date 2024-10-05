<?php

use PHPUnit\Framework\TestCase;
use MyApp\Storage\StorageInterface;
use MyApp\Repositories\EnrollmentRepository;
use MyApp\Models\Enrollment\Enrollment;
use MyApp\Models\Course\Course;
use MyApp\Models\Location\Location;
use MyApp\Models\User\Student;
// use MyApp\Models\Student\Student;
use MyApp\Storage\JsonStorage;

/**
 * Class UserRepositoryTest
 *
 * Unit tests for the EnrollmentRepository class.
 */
class EnrollmentRepositoryTest extends TestCase
{
    private $enrollmentRepository;

    protected function setUp(): void
    {
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $enrollmentsPath = $baseDir.'/tests/Data/Json/enrollments.json';

        // Create the repositories
        $storage = new JsonStorage($enrollmentsPath);
        $this->enrollmentRepository = new EnrollmentRepository($storage);
    }

    // test if an enrollment can be saved
    public function testSaveEnrollment()
    {
        $timeStamp=time();

        $location = new Location(
            'Melbourne'
        );

        // Arrange
        $course = new Course(
            time(),
            'Mathematics',
            $location
        );

        $user = new Student(
            'John Doe', 
            'john'.$timeStamp.'@example.com',
            $timeStamp
        );

        // Arrange
        $enrollment = new Enrollment(
            $course,
            $user
        );

        // Act
        $this->enrollmentRepository->save($enrollment);
        $enrollments = $this->enrollmentRepository->getAll();

        $found = false;
        foreach ($enrollments as $enrollment) {
            if ($enrollment["course_name"] == 'Mathematics' and $enrollment["student_name"] == 'John Doe') {
                $found = true;
                break;
            }
        }

        // Assert that Jane Doe is found in the users
        $this->assertTrue($found, 'User "Jane Doe" should be in the enrollments.');
    }

    // test if user can be retrieved by an id
    public function testFindByIdReturnsEnrollment()
    {
        // Act
        $result = $this->enrollmentRepository->findById(1);

        // Assert
        $this->assertInstanceOf(Enrollment::class, $result);
    }

    // // test the return value when user 
    // // id does not exist in the system
    public function testFindByIdReturnsNullWhenEnrollmentNotFound()
    {
        // Act
        $result = $this->enrollmentRepository->findById(999);

        // Assert
        $this->assertNull($result);
    }
}
