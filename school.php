<?php

require_once 'lib.php';

includeAutoLoad();


$help = "Allows you to print out the entire school dataset currently in memory

Options:
-a, --all       Print out the entire school dataset
-h, --help      Print out this help

Example:
\$ php school.php -a";

print_r(printSchoolData());