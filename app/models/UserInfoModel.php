<?php
class UserInfoModel extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->__table = 'user_infos';
        $this->init_table_id();
    }

    function create_user_info($user_id, $firstname='', $lastname='', $gender=null, $phone_number='', $dob=null, $about='') {
        $data = ['user_id' => $user_id];
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
            $data['date_of_birth'] = $dob;
        }
        if (isset($about)) {
            $data['about'] = $about;
        }
        return $this -> db -> insert($this->__table, $data);
    }

    function retrieve_user_info($id) {
        $condition = ['user_id' => $id];
        $user_infos = $this -> db -> select($this -> __table, $condition);
        if (!empty($user_infos)) {
            return $user_infos[0];
        }
    }

    function update_user_info($id, $firstname='', $lastname='', $gender=null, $phone_number='', $dob=null, $about='') {
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
            $data['date_of_birth'] = $dob;
        }
        if (isset($about)) {
            $data['about'] = $about;
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
