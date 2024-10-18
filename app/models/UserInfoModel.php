<?php
class UserInfoModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'user_infos';
        $this->init_table_id();
    }

    function create_user_info($firstname=null, $lastname=null, $gender=null, $phone_number=null, $dob=null) {
        $data = [];
        if (isset($firstname)) {
            $data['firstname'] = $firstname;
        }
        if (isset($lastname)) {
            $data['lastname'] = $lastname;
        }
        if (isset($gender)) {
            $data['gender'] = $gender;
        }
        if (isset($phone_number)) {
            $data['phone_number'] = $phone_number;
        }
        if (isset($dob)) {
            $data['dob'] = $dob;
        }
        return $this -> db -> insert($this->__table, $data);
    }

    function update_user_info($id, $firstname=null, $lastname=null, $gender=null, $phone_number=null, $dob=null) {
        $data = [];
        if (isset($firstname)) {
            $data['firstname'] = $firstname;
        }
        if (isset($lastname)) {
            $data['lastname'] = $lastname;
        }
        if (isset($gender)) {
            $data['gender'] = $gender;
        }
        if (isset($phone_number)) {
            $data['phone_number'] = $phone_number;
        }
        if (isset($dob)) {
            $data['dob'] = $dob;
        }
        $condition = [
            'id' => $id
        ];
        return $this -> db -> update($this -> __table, $data, $condition);
    }

    function delete_user_info($id) {
        return $this -> db -> delete($this -> __table, ['id' => $id]);
    }
}
