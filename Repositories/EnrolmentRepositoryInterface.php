<?php

namespace Repository;

interface EnrolmentRepositoryInterface
{
    public function getClassIdsByUserName(string $name): array;
}