<?php
require_once __DIR__ . '/vendor/autoload.php';

use Builder\SchoolBuilder;
use Repository\LocalFileCourseRepository;
use Repository\LocalFileEnrolmentRepository;
use Repository\LocalFileSchoolRepository;
use Repository\LocalFileUserRepository;
use Service\CourseService;
use Service\EnrolmentService;
use Service\SchoolService;
use Service\UserService;

function getSchoolService(): SchoolService
{
    return new SchoolService(new LocalFileSchoolRepository(), new SchoolBuilder());
}
function getCourseService(): CourseService
{
    return new CourseService(new LocalFileCourseRepository());
}

function getUserService(): UserService
{
    return new UserService(new LocalFileUserRepository(), getEnrolmentService());
}

function getEnrolmentService(): EnrolmentService
{
    return new EnrolmentService(new LocalFileEnrolmentRepository(), new LocalFileUserRepository(), new LocalFileCourseRepository());
}