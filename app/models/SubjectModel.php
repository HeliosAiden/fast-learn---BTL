<?php
class SubjectModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'subjects';
        $this->init_table_id();
    }
}
