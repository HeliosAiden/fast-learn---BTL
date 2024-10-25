<?php

class FileModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'files';
        $this->init_table_id();
    }

    public function create_file($user_id, $file_name, $file_path, $file_type, $file_size) {
        $data = [
            'user_id' => $user_id,
            'file_name' => $file_name,
            'file_path' => $file_path,
            'file_type' => $file_type,
            'file_size' => $file_size,
        ];
        return $this -> db -> insert($this->__table, $data);
    }

    public function delete_file($id) {
        return $this -> db -> delete($this->__table, ['id' => $id]);
    }

    public function get_file_with_condition($condition = [], $keys=[], $exceptions=[]) {
        $row = $this -> db -> select($this -> __table, $condition, $keys, $exceptions);
        if (!empty($row)) {
            return $row[0];
        }
        return null;
    }
}