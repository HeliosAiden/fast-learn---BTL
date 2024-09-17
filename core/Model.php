<?php

// Base Model
class Model extends Database
{
    protected $db;
    protected $__table;
    protected $__table_id;

    function __construct()
    {
        $this->db = new Database();
    }

    protected function init_table_id()
    {
        $this->__table_id = rtrim($this->__table, 's') . '_id';
    }

    protected function init_details($id, $params = []) {
        $details = [];
        if (empty($params)) {
            $details = [$this->__table_id => $id];
        } else {
            foreach($params as $key => $value) {
                $details[$key] = $value;
            }
        }
        return $details;
    }

    protected function list($condition = '')
    {
        return $this->db->select($this->__table, $condition);
    }

    protected function detail($details = [])
    {
        if (!empty($details)) {
            $condition = '';
            foreach ($details as $key => $value) {
                $condition .= $key . ' = ' . $value . ' AND ';
            }
            $condition = rtrim($condition, ' AND ');
            return $this->list($condition);
        } else return $this -> list();
    }

    protected function search($queries=[]) {
        if (!empty($queries)) {
            return $this -> detail($queries);
        }
    }


}
