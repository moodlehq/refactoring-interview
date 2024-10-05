<?php

use PHPUnit\Framework\TestCase;
use MyApp\Storage\StorageInterface;
use MyApp\Repositories\CourseRepository;
use MyApp\Models\Course\Course;
use MyApp\Models\Location\Location;
use MyApp\Storage\JsonStorage;

/**
 * Class UserRepositoryTest
 *
 * Unit tests for the UserRepository class.
 */
class CourseRepositoryTest extends TestCase
{
    private $courseRepository;

    protected function setUp(): void
    {
        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $coursesPath = $baseDir.'/tests/Data/Json/courses.json';

        // Create the repositories
        $storage = new JsonStorage($coursesPath);
        $this->courseRepository = new CourseRepository($storage);
    }

    // test if a course can be saved
    public function testSaveCourse()
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

        // Act
        $this->courseRepository->save($course);
        $courses = $this->courseRepository->getAll();

        $found = false;
        foreach ($courses as $course) {
            if ($course["name"] == 'Mathematics') {
                $found=true;
                break;
            }
        }

        // Assert that Jane Doe is found in the users
        $this->assertTrue($found, 'User "Jane Doe" should be in the user list.');
    }

    // test if user can be retreived by an id
    public function testFindByIdReturnsCourse()
    {
        // Act
        $result = $this->courseRepository->findById(1728108896);

        // Assert
        $this->assertInstanceOf(Course::class, $result);
    }

    // test the return value when user 
    // id does not exist in the system
    public function testFindByIdReturnsNullWhenCourseNotFound()
    {
        // Act
        $result = $this->courseRepository->findById(999);

        // Assert
        $this->assertNull($result);
    }
}
