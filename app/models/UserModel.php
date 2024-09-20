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

    private function get_options() {
        return ['cost' => $this->hashing_config['cost']];
    }

    public function register($username, $email, $password, $role_id)
    {
        // Hash the password using bcrypt
        $options = $this->get_options();
        $hashedPassword = password_hash($password, $this->hashing_config['algorithm'], $options);

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role_id' => $role_id
        ];

        $is_registered = $this -> insert($this->__table, $data);
        if ($is_registered) {
            $user = $this->db->select($this->__table, $data);
            return $user;
        }

        return false;
    }

    public function login($username, $password)
    {
        $condition = [
            'username' => $username
        ];
        $user = $this->db->select($this->__table, $condition);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; // Return user data if login is successful
        }

        return false; // Return false if credentials don't match
    }

    public function get_list()
    {
        return $this -> list();
    }

    public function get_detail($id, $details=[])
    {
        $details = $this -> init_details($id, $details);
        return $this -> detail($details);
    }

    public function search_user($details=[]) {
        $details = $this -> init_details('', $details);
        return $this -> detail($details);
    }

    public function delete_user() {

    }

}
