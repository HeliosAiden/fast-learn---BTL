<?php

class HomeModel extends Model
{
    protected $__table = 'roles';
    function __construct()
    {
        parent::__construct();
    }

    public function get_list()
    {
        $data = $this ->db->select($this -> __table);
        return $data;
    }

    public function get_detail($id)
    {
        $data = [
            'Item 1',
            'Item 2',
            'Item 3'
        ];
        return $data[$id];
    }
}
