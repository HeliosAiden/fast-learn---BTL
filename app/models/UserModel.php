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

    public function register($username, $password, $role='Student')
    {
        // Hash the password using bcrypt
        $options = ['cost' => $this->hashing_config['cost']];
        $hashedPassword = password_hash($password, constant($this->hashing_config['algorithm']), $options);

        $data = [
            'username' => $username,
            'password_hash' => $hashedPassword,
            'role' => $role
        ];

        $response = $this -> db -> insert($this->__table, $data);
        if ($response) {
            $condition = $this -> init_condition($data);

            $user = $this -> db ->select($this->__table, $condition);
            return $user;
        }

        return $response;
    }

    public function login($username, $password, $role)
    {
        $condition = 'username = "' . $username . '" AND role = "' . $role . '"';
        $statement = $this->db->select($this->__table, $condition);
        $user = $statement[0][0];
        if ($statement[1] && password_verify($password, $user['password_hash'])) {
            return [$user, true]; // Return user data if login is successful
        }

        return [null, false]; // Return false if credentials don't match
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
