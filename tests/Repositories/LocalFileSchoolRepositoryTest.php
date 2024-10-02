<?php

namespace Test\Repository;

use PHPUnit\Framework\TestCase;
use Repository\LocalFileSchoolRepository;
use Prophecy\PhpUnit\ProphecyTrait;

class LocalFileSchoolRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private LocalFileSchoolRepository $localFileSchoolRepository;

    protected function setUp(): void {
        $this->localFileSchoolRepository = new LocalFileSchoolRepository();
    }

    public function testGetDataFromSource() {
        $schoolData = $this->localFileSchoolRepository->extractSchoolData();
        $this->assertArrayHasKey('users', $schoolData);
        $this->assertArrayHasKey('classes', $schoolData);
    }
}
