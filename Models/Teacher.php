<?php
namespace Model;

class Teacher extends User
{
    public function __construct($name, $email)
    {
        parent::__construct($name, $email, 'Teacher');
    }
}