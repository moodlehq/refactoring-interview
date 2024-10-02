<?php

namespace Test\Service;

use Builder\SchoolBuilder;
use Model\School;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Repository\LocalFileSchoolRepository;
use Service\SchoolService;
use Prophecy\PhpUnit\ProphecyTrait;

class SchoolServiceTest extends TestCase
{
    use ProphecyTrait;

    private SchoolService $schoolService;
    private LocalFileSchoolRepository|ObjectProphecy $mockSchoolRepository;
    private SchoolBuilder|ObjectProphecy $mockSchoolBuilder;

    protected function setUp(): void {

        $this->mockSchoolRepository = $this->prophesize(LocalFileSchoolRepository::class);
        $this->mockSchoolBuilder = $this->prophesize(SchoolBuilder::class);

        $this->schoolService = new SchoolService(
            $this->mockSchoolRepository->reveal(),
            $this->mockSchoolBuilder->reveal()
        );
    }

    public function testCreateSchool()
    {
        $school = new School();
        $data = [
            'users' => [],
            'classes' => []
        ];

        $this->mockSchoolRepository->extractSchoolData()->willReturn($data)->shouldBeCalled();
        $this->mockSchoolBuilder->addCoursesFromData($data)->willReturn($this->mockSchoolBuilder)->shouldBeCalled();
        $this->mockSchoolBuilder->addUsersFromData($data)->willReturn($this->mockSchoolBuilder)->shouldBeCalled();
        $this->mockSchoolBuilder->build()->willReturn($school)->shouldBeCalled();

        $this->assertEquals($school, $this->schoolService->createSchool());
    }

}
