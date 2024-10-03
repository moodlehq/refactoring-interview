<?php
/*
* Currently, models are not applied in the Repository as
* the refactoring was done using the existing JSON data
*/
class User {
    private $id;
    private $name;
    private $email;
    private $role;      // Optional

    // Constructor with optional parameters for role 
    public function __construct($id, $name, $email, $role = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    // Setters
    public function setRole($role) {
        $this->role = $role;
    }
}
