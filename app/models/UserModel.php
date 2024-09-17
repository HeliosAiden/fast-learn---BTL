<?php
class UserModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'users';
        $this->init_table_id();
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

    public function create_user($data = []) {
        $statement = $this -> insert($this->__table, $data);
        if ($statement) {
            return $this -> get_detail(1);
        } else {

        }
    }

    public function search_user($details=[]) {
        $details = $this -> init_details('', $details);
        return $this -> detail($details);
    }

    public function add_user() {

    }

    public function delete_user() {

    }

}
