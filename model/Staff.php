<?php

    class Staff{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function display($search, $role, $status, $limit, $off){

            $s = "$search%";
            $r = "$role%";
            $st = "$status%";

            $q = "SELECT user_id, username, role, status FROM users WHERE username LIKE ? AND role LIKE ? AND status LIKE ? LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sssii', $s, $r, $st, $limit, $off);    
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }
        public function store($username, $role, $status, $password, $confirm_password){
            $q = "INSERT INTO users (username, role, status, password) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $username, $role, $status, $hashed_password);
            return $stmt->execute();
        }

        public function destroy($user_id){
            $q = "DELETE FROM users WHERE user_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $user_id);
            return $stmt->execute();
        }

        public function get($user_id){
            $q = "SELECT username, password, role, status FROM users WHERE user_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_assoc();
        }

        public function update($user_id, $username, $role, $status, $password){
            if ($password == null || $password == ''){
                $q = "UPDATE users SET username = ?, role = ?, status = ? WHERE user_id = ?";
                $stmt = $this->db->prepare($q);
                $stmt->bind_param('sssi', $username, $role, $status, $user_id);
                return $stmt->execute();
            }
            else{
                $q = "UPDATE users SET username = ?, role = ?, status = ?, password = ? WHERE user_id = ?";
                $stmt = $this->db->prepare($q);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param('ssssi', $username, $role, $status, $hashed_password, $user_id);
                return $stmt->execute();
            }
        }
    }

?>