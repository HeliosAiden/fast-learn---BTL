<?php

class HomeModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this -> __table = 'roles';
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
}
