<?php
class SubjectModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'subjects';
        $this->init_table_id();
    }

    function create_subject($name) {
        $data = [
            'name' => $name
        ];
        return $this -> db -> insert($this->__table, $data);
    }
}
