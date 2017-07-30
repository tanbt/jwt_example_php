<?php

/**
 * Created by PhpStorm.
 * User: Tan-vaadin-lap
 * Date: 7/28/2017
 * Time: 12:07 PM
 */
class UsersDao
{
    public $users = [];

    function __construct()
    {
        $this->users[1] = [
            "id"        => 1,
            "username"  => "tanbt",
            "password"  => "pass123",
            "fullname"  => "Tan Bui"
        ];
        $this->users[2] = [
            "id"        => 2,
            "username"  => "yourown",
            "password"  => "dfagdfag",
            "fullname"  => "Your Own"
        ];
    }

    function getUser($username, $password) {
        foreach ($this->users as $user) {
            if ($user["username"] == $username && $user["password"] == $password)
                return $user;
        }
        return [];
    }

    function getUserById($id) {
        return $this->users[$id];
    }

    function getAllUsers() {
        return $this->users;
    }

    function addUser($name, $pass, $fullname) {
        $id = count($this->users) + 1;
        $this->users[$id] = [
            "id"        => $id,
            "username"  => $name,
            "password"  => $pass,
            "fullname"  => $fullname,
            "created"   => time()
        ];
        return $this->users[$id];
    }
}