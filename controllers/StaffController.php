<?php

    class StaffController{
        private $staff;

        public function __construct($staff)
        {
            $this->staff = $staff;
        }
        public function display($search, $role, $status, $limit, $off){
            return $this->staff->display($search, $role, $status, $limit, $off);
        }
        public function store($username, $role, $status, $password, $confirm_password){
            return $this->staff->store($username, $role, $status, $password, $confirm_password);
        }
        public function delete($user_id){
            return $this->staff->destroy($user_id);
        }
        public function get($user_id){
            return $this->staff->get($user_id);
        }
        public function update($user_id, $username, $role, $status, $password){
            return $this->staff->update($user_id, $username, $role, $status, $password);
        }
    }

?>