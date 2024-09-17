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

        protected function detail($id) {
            return $this-> list($id);
        }
    }


?>