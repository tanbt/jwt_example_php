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
    public $db_file = __DIR__ . "/db.json";

    function __construct()
    {
        $this->users = json_decode(file_get_contents($this->db_file), true);
        if (empty($this->users)) {
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
            $this->persistent();
        }
    }

    private function persistent(){
        file_put_contents($this->db_file, json_encode($this->users));
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
        $this->persistent();
        return $this->users[$id];
    }

    function  updateUserById($id, $name, $pass, $fullname) {
        $this->users[$id] = [
            "username"  => $name,
            "password"  => $pass,
            "fullname"  => $fullname,
            "modified"   => time()
        ];
        $this->persistent();
        return $this->users[$id];
    }
}