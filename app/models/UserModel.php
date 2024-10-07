<?php
class UserModel extends Model
{
    private $hashing_config = [];

    function __construct()
    {
        parent::__construct();
        $this->__table = 'users';
        $this->init_table_id();
        global $hashing_config;
        $this->hashing_config = $hashing_config;
    }

    public function register($username, $password, $email, $role='Student')
    {
        // Hash the password using bcrypt
        $options = ['cost' => $this->hashing_config['cost']];
        $hashedPassword = password_hash($password, constant($this->hashing_config['algorithm']), $options);

        $data = [
            'username' => $username,
            'password_hash' => $hashedPassword,
            'email' => $email,
            'role' => $role,
        ];

        return $this -> db -> insert($this->__table, $data);
    }

    public function login($username, $password, $role)
    {
        $condition = [
            'username' => $username,
            'role' => $role,
        ];
        $rows = $this->db->select($this->__table, $condition);
        if ($rows) {
            $user = $rows[0]; // Select first user found
            if ($user && password_verify($password, $user['password_hash'])) {
                return $user;
            }
        }

        return null; // Return null if credentials don't match
    }

}
