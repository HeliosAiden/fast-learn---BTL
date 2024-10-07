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

    function update_subject($id, $name) {
        $data = [
            'name' => $name
        ];
        $condition = [
            'id' => $id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    function delete_subject($id) {
        return $this -> db -> delete($this -> __table, ['id' => $id]);
    }
}
