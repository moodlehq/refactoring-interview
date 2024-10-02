<?php
namespace Model;

class Student extends User
{
    public function __construct($name, $email)
    {
        parent::__construct($name, $email);
    }
}