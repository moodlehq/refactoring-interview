<?php

namespace Service;

use Builder\SchoolBuilder;
use Model\School;
use Repository\SchoolRepositoryInterface;

class SchoolService
{
    private SchoolRepositoryInterface $schoolRepository;
    private SchoolBuilder $schoolBuilder;

    public function __construct(SchoolRepositoryInterface $schoolRepository, SchoolBuilder $schoolBuilder)
    {
        $this->schoolRepository = $schoolRepository;
        $this->schoolBuilder = $schoolBuilder;
    }

    public function createSchool(): School
    {
        $data = $this->schoolRepository->extractSchoolData();

        return $this->schoolBuilder
            ->addCoursesFromData($data)
            ->addUsersFromData($data)
            ->build();
    }

}