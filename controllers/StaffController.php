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

    }

?>