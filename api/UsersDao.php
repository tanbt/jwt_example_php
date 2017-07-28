<?php

/**
 * Created by PhpStorm.
 * User: Tan-vaadin-lap
 * Date: 7/28/2017
 * Time: 12:07 PM
 */
class UsersDao
{
    public $user = [];

    function __construct()
    {
        $this->user[] = [
            "id"        => 1,
            "username"  => "tanbt",
            "password"  => "pass123",
            "fullname"  => "Tan Bui"
        ];
        $this->user[] = [
            "id"        => 2,
            "username"  => "yourown",
            "password"  => "dfagdfag",
            "fullname"  => "Your Own"
        ];
    }

    function getUser($username, $password) {
        foreach ($this->user as $user) {
            if ($user["username"] == $username && $user["password"] == $password)
                return $user;
        }
        return [];
    }
}