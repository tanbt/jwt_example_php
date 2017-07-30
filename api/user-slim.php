<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once __DIR__ . "/JwtUtil.php";
require_once  __DIR__ . "/UsersDao.php";
$userDao = new UsersDao();

$app = new \Slim\App();

$container = $app->getContainer();

$container["jwt"] = function ($container) {
    return new StdClass;
};

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure"    => false,
    "secret" => JwtUtil::JWT_KEY,
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
        if (empty($container["jwt"]->id)) {
            return false;
        }
    }
]));

/**
GET /api/user-slim.php/hello/Just+a+test HTTP/1.1
Host: dev.chooseyourfuture.fi
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJ0YW5idCJ9.sfvVcJvkxOa2fFQEyLBAF8EOHPtvhD7QEQ8j964KnTs
Cache-Control: no-cache
Postman-Token: 60c913e3-921f-f9c1-34f6-b985339962da
 */
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write(json_encode([$args['name'], $this->jwt]));
});

/**
GET /api/user-slim.php/users/2 HTTP/1.1
Host: dev.chooseyourfuture.fi
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJ0YW5idCJ9.sfvVcJvkxOa2fFQEyLBAF8EOHPtvhD7QEQ8j964KnTs
Cache-Control: no-cache
Postman-Token: 8ecac7cf-6e31-e94b-3cba-897244e3bef2
 */
$app->get('/users/{id}', function($req, $res, $args) use ($userDao) {
    return $res->write(json_encode($userDao->getUserById($args['id'])));
});

/**
GET /api/user-slim.php/users HTTP/1.1
Host: dev.chooseyourfuture.fi
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJ0YW5idCJ9.sfvVcJvkxOa2fFQEyLBAF8EOHPtvhD7QEQ8j964KnTs
Cache-Control: no-cache
Postman-Token: 65f67bba-353c-dd8d-d288-e0a7a493ef63
*/
$app->get('/users', function($req, $res, $args) use ($userDao) {
    return $res->write(json_encode($userDao->getAllUsers()));
});

/**
POST /api/user-slim.php/users HTTP/1.1
Host: dev.chooseyourfuture.fi
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJ0YW5idCJ9.sfvVcJvkxOa2fFQEyLBAF8EOHPtvhD7QEQ8j964KnTs
Content-Type: application/x-www-form-urlencoded
Cache-Control: no-cache
Postman-Token: c5b1b785-49a5-31e0-5626-b7579ff5bc52

username=newtan&password=ADF!%24%25AS.ad&fullname=New+Tan
 */
$app->post('/users', function($req, $res) use ($userDao) {
    $data = $req->getParsedBody();
    return $res->write(json_encode($userDao->addUser(
        $data['username'], $data['password'], $data['fullname']
    )));
});



$app->run();