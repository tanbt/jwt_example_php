<?php
require dirname(__DIR__) . "/vendor/autoload.php";

use \Firebase\JWT\JWT;

class JwtUtil
{
    const JWT_KEY = "AASDF@#$%@Sqfaf.214t!$#4afa\sdf";

    public static function encrypt($data, $alg = "HS256"){
        return JWT::encode($data, self::JWT_KEY, $alg);
    }

    public static function decrypt($data, $alg = "HS256") {
        return JWT::decode($data, self::JWT_KEY, $alg);
    }
}