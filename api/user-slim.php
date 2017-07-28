<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once __DIR__ . "/JwtUtil.php";

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

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write(json_encode([$args['name'], $this->jwt]));
});

$app->run();