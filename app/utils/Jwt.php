<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTToken {
    private $secret_key = '';
    private $issued_at, $expiration_time, $issuer;

    function __construct()
    {
        global $jwt_config;
        $this -> issuer = __URL_ORIGIN__;
        $this -> secret_key = $jwt_config['secret_key'];
        $this -> issued_at = time();
        $this -> expiration_time = $this -> issued_at + $jwt_config['exp_time'];
    }

    public function generateToken($data = []) {
        $payload = array_merge($data, [
            'iss' => $this -> issuer,
            'iat' => $this -> issued_at,
            'exp' => $this -> expiration_time
        ]);
        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    public function decodeToken($jwt) {
        try {
            return JWT::decode($jwt, new Key($this -> secret_key, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }
}
