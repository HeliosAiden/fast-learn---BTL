<?php

    // Base Model
    class Model extends Database {
        protected $db;
        protected $__table;

        function __construct()
        {
            $this ->db = new Database();
        }

        protected function list($condition = '') {
            return $this-> db-> select($this -> __table, $condition);
        }

        protected function detail($condition = []) {
            $queryStr = '';
            foreach($condition as $key => $value) {
                $queryStr .= $key . ' = ' . $value . ' AND ';
            }
            $queryStr = rtrim($queryStr, ' AND ');
            echo $queryStr;
            return $this-> list($queryStr);
        }
    }


?>