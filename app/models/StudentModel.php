<?php
    require_once _DIR_ROOT . '/app/models/UserModel.php';

class StudentModel extends UserModel
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'students';
        $this->init_table_id();
    }
}
