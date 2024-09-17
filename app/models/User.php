<?php
class User extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'users';
    }

    public function get_list()
    {
        return $this -> list();
    }

    public function get_detail($id, $details=[])
    {
        $condition = ['id' => $id];
        if (!empty($details)) {
            foreach($details as $key => $value) {
                $condition[$key] = $value;
            }
        }
        return $this -> detail($condition);
    }

    public function create_user($data = []) {
        $statement = $this -> insert($this->__table, $data);
        if ($statement) {
            return $this -> get_detail(1);
        } else {

        }
    }
}
