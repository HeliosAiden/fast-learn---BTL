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

    public function get_detail($id)
    {
        return $this -> detail($id);
    }
}
