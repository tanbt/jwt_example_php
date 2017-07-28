<?php
require __DIR__ . "/UsersDao.php";
require __DIR__ . "/JwtUtil.php";

if ($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $userDao = new UsersDao();
    $user = $userDao->getUser($name, $pass);
    if(!empty($user)) {

        $token = JwtUtil::encrypt([$user['id'], $user['username']]);
        echo $token;
    } else {
        echo "Login failed";
    }
}