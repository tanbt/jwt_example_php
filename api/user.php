<?php
require __DIR__ . "/UsersDao.php";
require __DIR__ . "/JwtUtil.php";

$token = "";
$headers = apache_request_headers();
if(isset($headers['Authorization'])){
    $token = trim( str_replace("Bearer", "", $headers['Authorization']) );
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($token)) {
    $data = (array) JwtUtil::decrypt($token);
    if (!empty($data['id'])) {
        $userDao = new UsersDao();
        $user = $userDao->getUserById($data['id']);
        unset($user['password']);
        echo json_encode($user);
    }
} else {
    echo json_encode("Authentication failed.");
}