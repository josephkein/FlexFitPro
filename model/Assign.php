<?php

    class Assign{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }
        public function display($search, $end, $limit, $off){
            $s = "$search%";
            $start = $end . " 00:00:00";

            $q = "SELECT c.coaching_id AS id, 
                        CONCAT(t.first_name, ' ', t.last_name) AS trainer,
                        cu.customer_name AS trainee, 
                        c.status, 
                        c.start_date AS start, 
                        c.end_date AS end,
                        CASE WHEN c.end_date < CURDATE() THEN 'Done' ELSE 'Ongoing' END AS session 
                FROM coaching AS c 
                JOIN trainers AS t ON c.trainer_id = t.trainer_id 
                JOIN customers AS cu ON c.customer_id = cu.customer_id
                WHERE (
                        CONCAT(t.first_name, ' ', t.last_name) LIKE ?
                        OR cu.customer_name LIKE ?
                )
                AND c.end_date < CURDATE()
                ORDER BY c.coaching_id DESC 
                LIMIT ? OFFSET ?";

            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('ssii', $s, $s, $limit, $off);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }

?>