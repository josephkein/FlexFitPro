<?php

    class Staff{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function display($search, $role, $status, $limit, $off){

            $s = "%$search%";
            $r = "%$role%";
            $st = "%$status%";

            $q = "SELECT username, role, status FROM users WHERE username LIKE ? AND role LIKE ? AND status LIKE ? LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sssii', $s, $r, $st, $limit, $off);    
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }
    }

?>