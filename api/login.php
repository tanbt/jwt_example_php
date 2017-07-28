<?php
require __DIR__ . "/UsersDao.php";
require __DIR__ . "/JwtUtil.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $userDao = new UsersDao();
    $user = $userDao->getUser($name, $pass);
    if(!empty($user)) {

        $token = JwtUtil::encrypt([
            "id" => $user['id'],
            "username" => $user['username']
            ]);
        echo $token;
    } else {
        echo "Login failed";
    }
}