# Moodle refactoring interview 

A small widget provided to potential candidates to refactor and improve.

```composer install```
```./vendor/bin/phpunit tests/* for tests. ```

---

### explanation of the current state
This is a legacy widget that you have inherited which caught the eye of an interested manager.

The interested manager wants it updated and ready for production asap so any changes shouldn't take more than half a day to complete.

The structure consists of the following files:
```
lib.php         - The functions used by the various entry points from the command line
data.json       - The provided json that the widget gets from the school as a data source
courses.php     - The entry point that allows the management of courses
users.php       - Manage and update users
school.php      - Display the entire school structure
tests/          - Directory containing the tests for the widget
    quick_test.php    - The initial developer wanted to state that their project had unit tests however, unfortunately they are not meaningful 

```

---
# Main task:
## Example `data.json` file

Users and courses are stored in a JSON file. The JSON file has the following structure:

```
{
  "users": [
    {"name": "Abed Nadir", "email": "abed@greendale.edu", "classes": [{"id": 1}, {"id": 2}]}
  ],
  "courses": [
    {"id": 1, "name": "Biology 101"}
  ]
}

```

Enrolments are currently stored in the `users` array item object. If you were to provide the school with the rational to normalise their data, they might be willing to update their processes.

The `courses`array currently contains each course with their associated ID and name. The school has indicated that they would like add class locations and times in the future.

## Running the code

Assuming PHP code is in `school.php`, you could run it by this command:

```
> php school.php 

```

Assuming PHP code is in `courses.php`, you could run it by this command:

```
> php school.php 

```

Assuming PHP code is in `users.php`, you could run it by this command:

```
> php school.php 
s
```

# Notes about this code
1. PHP 8.2 is the target version, and you can use any features from it
1. Run time changes do not need to be saved or written back to the data source 
1. Backwards compatibility is not an issue so functions can be removed and updated as desired

# Requirements for your code
1. Improve the code hygiene of the widget and provide your insight on any areas of concern
1. Refactor the test.php file to have clearer representations of the functionality. This can take the shape of implementing a design pattern
   1. Re-implement the course and user CRUD functions to be single purpose discreet functions
1. Provide unit tests for the new functions
1. Changes should be commited and a pull request should be made to this repository 
