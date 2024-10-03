<?php

require_once('Repository/courseRepository.php');
require_once('CommandHandler.php');
require_once('library.php');
$shortOptions = "a::p::t::c:u:d:e:ue:h::";
$longOptions = ["all:", "participants:", "teachers:", "create:", "update:", "delete:", "enroll", "unenroll","help"];
$options = getopt($shortOptions, $longOptions);
$lib = new Library();
$courseRepo = new CourseRepository($lib);
// Pass the repository to the handler
$commandHandler = new CommandHandler($courseRepo); 
// Handle the options & extra options
$commandHandler->handle($options, $argv); 
