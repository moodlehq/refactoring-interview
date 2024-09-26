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
test.php - The entry point into the program that can be run from the command line
data.json - The provided json that the widget gets from the school as a data source
tests/
      quick_test.php - The initial developer wanted to state that their project had unit tests however, unfortunately they are not meaningful 

```

---
# Main task:
## Example `data.json` file

**TODO**: Update this to match the data.json

```
{"user":"wow","enrolments":"yes"}

```

## Running the code

Assuming PHP code is in `test.php`, you could run it by this command:

**TODO**: Improve the output to CLI
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
1. PHP 8.2 is the target version, and you can use any features from it
1. Run time changes do not need to be saved or written back to the data source 
1. Backwards compatibility is not an issue so functions can be removed and updated as desired

# Requirements for your code
1. Improve the code hygiene of the widget and provide your insight on any areas of concern
1. Refactor the test.php file to have clearer representations of the functionality. This can take the shape of implementing a design pattern
   1. Re-implement the course and user CRUD functions to be single purpose discreet functions
1. Provide unit tests for the new functions
1. Changes should be commited and a pull request should be made to this repository 
