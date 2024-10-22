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

    public function change_password($new_password, $user_id) {
        $options = ['cost' => $this->hashing_config['cost']];
        $hashedPassword = password_hash($new_password, constant($this->hashing_config['algorithm']), $options);
        $data = [
           'password_hash' => $hashedPassword,
        ];
        $condition = [
            'id' => $user_id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    public function update_user_info($user_id, $user_info_id) {
        $data = [
            'user_info' => $user_info_id
        ];
        $condition = [
            'id' => $user_id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    public function update_user_state($user_id, $state) {
        $data = [
            'state' => $state
        ];
        $condition = [
            'id' => $user_id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    public function active_user($user_id) {
        $data = [
            'state' => 'Active'
        ];
        $condition = [
            'id' => $user_id
        ];
        $response = $this -> db -> update($this -> __table, $data, $condition);
        if (!$response) {
            echo 'Activate user failed!';
        }
    }

    public function get_current_user_password_hash($user_id) {
        $user_data = $this -> db -> select($this -> __table, ['id' => $user_id])[0];
        $password_hash = $user_data['password_hash'];
        return $password_hash;
    }

}
