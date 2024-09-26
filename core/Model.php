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

    public function init_table_id()
    {
        $this->__table_id = rtrim($this->__table, 's') . '_id';
    }

    public function init_details($id, $params = []) {
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

    public function init_condition($data = []) {
        $condition = '';
        if (!empty($data)) {
            foreach($data as $key => $value) {
                $condition .= $key . ' = ' . $value;
            }
            $condition = rtrim($condition, ' = ');
        }
        return $condition;
    }

    public function select_all() {
        return $this->db->select($this->__table);
    }

    public function select_condition($condition = '')
    {
        return $this->db->select($this->__table, $condition);
    }

    public function detail($details = [])
    {
        if (!empty($details)) {
            $condition = '';
            foreach ($details as $key => $value) {
                $condition .= $key . ' = ' . $value . ' AND ';
            }
            $condition = rtrim($condition, ' AND ');
            return $this->select_condition($condition);
        } else return $this -> select_all();
    }

    public function search($queries=[]) {
        if (!empty($queries)) {
            return $this -> detail($queries);
        }
    }


}
