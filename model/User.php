<?php

    class User{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function auth($user, $pass){
            // check for user
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param('s', $user);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0){
                $assoc = $res->fetch_assoc();
                if (password_verify($pass, $assoc['password'])){
                    return $assoc;
                }
            }
            return null;
        }
        public function create($user, $pass, $role, $status){

            // check if username already exist
            $check = $this->db->prepare('SELECT username FROM users WHERE username = ?');
            $check->bind_param('s', $user);
            $check->execute();
            $res = $check->get_result();
            if ($res->num_rows > 0){
                return null;
            }
            // insert new user
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password, role, status) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss', $user, $hashed, $role, $status);
            return $stmt->execute();
        }
        public function update(){

        }
        public function destroy(){

        }
    }

?>