<?php

require_once('Repository/userRepository.php');
require_once('CommandHandler.php');
require_once('library.php');
$shortOptions = "a::l::t::c:u:d:h::";
$longOptions = ["all:", "learners:", "teachers:", "create:", "update:", "delete:", "help"];
$options = getopt($shortOptions, $longOptions);
$lib = new Library();
$userRepo = new UserRepository($lib);
// Pass the repository to the handler
$commandHandler = new CommandHandler($userRepo); 
// Handle the options & extra options
$commandHandler->handle($options, $argv); 
