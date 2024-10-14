<?php
require _DIR_ROOT . '/vendor/autoload.php';
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

    public function get_token() {
        if (isset($_COOKIE['jwtToken'])) {
            $token = $_COOKIE['jwtToken'];
            return $token;
        }
        return null;
    }

    public function get_user_role() {
        $token = $this -> get_token();
        if (isset($token)) {
            $payload = $this -> decode_token($token);
            $data = $payload['data'];
            if (!empty($data) && isset($data['user_role'])) {
                return $data['user_role'];
            }
        }
        return null;
    }

    public function generate_token($data = []) {
        $payload = [
            'iss' => $this -> issuer,
            'iat' => $this -> issued_at,
            'exp' => $this -> expiration_time,
            'data' => $data
        ];
        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    public function refresh_token($token) {
        $payload = $this -> decode_token($token);
        $data = $payload -> data;
        return $this -> generate_token($data);
    }

    public function decode_token($token) {
        try {
            return JWT::decode($token, new Key($this -> secret_key, 'HS256'));
        } catch (Exception $e) {
            $default_login_url = _WEB_ROOT . '/dang-nhap';
            http_response_code(401);
            echo json_encode(['message' => 'Invalid token']);
            setcookie('jwtToken', '', 0, '/');  // Expire the cookie
            header("Location: $default_login_url");
            exit();
        }
    }

    public function get_expiration_time() {
        return $this -> expiration_time;
    }

    public function get_expiration_duration() {
        return $this -> get_expiration_time() - $this -> issued_at;
    }

}
