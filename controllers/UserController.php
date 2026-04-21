<?php

    class UserController{
        private $user;

        public function __construct($user)
        {
            $this->user = $user;
        }
        // authenticate user
        public function login($user, $pass){
            return $this->user->auth($user, $pass);
        }
        public function create($user, $pass, $role, $status){
            return $this->user->create($user, $pass, $role, $status);
        }
    }

?>