<?php

class HomeModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this -> __table = 'roles';
        $this->init_table_id();
    }

    public function get_list()
    {
        return $this -> list();
    }

    public function get_detail($id, $details=[])
    {
        $params = [$this->__table_id => $id];
        if (!empty($details)) {
            foreach($details as $key => $value) {
                $params[$key] = $value;
            }
        }
        return $this -> detail($params);
    }
}
