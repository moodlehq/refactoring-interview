## Concerns and suggestions for the structure of the data source

1. It shoud have a user id in users array. Currently, when a user needs to get deleted, it's done by array index as id.
2. Users and roles should be stored in different arrays/tables to improve maintainability.
3. For enrollments, it's better to have a separate array/table named "enrollments" that stores user_ids and course_ids.

## Refactoring and test details

1. Applied Reposity design pattern to implement user and course repositories. School was not implemented as the existing logic for schools is the same with courses.
2. The repository interface ensures that the repositories adheres to a common contract of methods.
3. Created "CommandHelper" to handle the commands like creating, updating, and deleting users. It utilizes the repository to persist data.
4. All the constants and help texts are provided in config.php.
5. Unit tests are organized in tests/ and tested the major functions.
