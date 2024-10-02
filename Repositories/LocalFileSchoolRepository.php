<?php
namespace Repository;

use Config\Constants;

class LocalFileSchoolRepository implements SchoolRepositoryInterface
{
    public function extractSchoolData(): array
    {
        return json_decode(file_get_contents(Constants::DATA_SOURCE_LOCAL_FILE), true);
    }
}