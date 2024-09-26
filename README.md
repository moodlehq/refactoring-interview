# Moodle refactoring interview 

A small widget provided to potential candidates to refactor and improve.

```composer install```
```./vendor/bin/phpunit tests/ for test. ```

---

### explanation of the current state
It is legacy code that was inherited that caught the eye of an interested manager that wants it updated and ready for production.
Given the manager wants this asap any changes shouldn't take more than half a day to complete.

The structure consists of ...

---
# Main task:
## Example `data.json` file

```
{"user":"wow","enrolments":"yes"}

```

## Running the code

Assuming PHP code is in `test.php`, you could run it by this command:
```
> php test.php 
stdClass Object
(
    [isaclassrepresentation] => yes
    [1] => stdClass Object
        (
            [name] => Biology
            [students] => Array
                (
                    [0] => Abed Nadir
                    [1] => Lex Williams
                    [2] => Walter White
                )

        )

    [2] => stdClass Object
        (
            [name] => Chemistry
            [students] => Array
                (
                    [0] => Abed Nadir
                    [1] => Jessie Pinkman
                    [2] => Walter White
                )

        )

)

```

# Notes about this code

1. Backwards compatibility is not an issue so functions can be removed and updated as desired

# Requirements for your code

1. Improve the code hygiene of the widget and provide your insight on any areas of concern
1. Refactor the test.php file to have clearer representations of the functionality. This can take the shape of implementing a design pattern in new files
1. Implement a function that can create a new course
1. Implement a function can enroll a student to a given course
