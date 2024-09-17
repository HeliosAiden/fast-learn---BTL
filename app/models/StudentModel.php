<?php
class Student extends UserModel
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'students';
        $this->init_table_id();
    }
}
