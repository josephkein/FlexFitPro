<?php

    class Assign{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }
        public function display($search, $end, $session, $limit, $off){
            $s = "$search%";

            // Session filter: ongoing or done assignments
            $condition = "";
            if ($session == 'ongoing') {
                $condition = "AND c.end_date >= CURDATE()";
            } elseif ($session == 'done') {
                $condition = "AND c.end_date < CURDATE()";
            }

            // End date filter: only add this condition when the user selected a date
            $endCondition = "";
            if (!empty($end)) {
                $endCondition = "AND c.end_date >= ? AND c.end_date < ?";
                $endNext = date('Y-m-d', strtotime($end . ' +1 day'));
            }

            $q = "SELECT c.coaching_id AS id, 
                        CONCAT(t.first_name, ' ', t.last_name) AS trainer,
                        cu.customer_name AS trainee, 
                        c.start_date AS start, 
                        c.end_date AS end,
                        CASE WHEN c.end_date < CURDATE() THEN 'Done' ELSE 'Ongoing' END AS session 
                FROM coaching AS c 
                JOIN trainers AS t ON c.trainer_id = t.trainer_id 
                JOIN customers AS cu ON c.customer_id = cu.customer_id
                WHERE (
                    t.first_name LIKE ?
                    OR t.last_name LIKE ?
                    OR cu.customer_name LIKE ?
                )
                $condition
                $endCondition
                ORDER BY c.coaching_id DESC 
                LIMIT ? OFFSET ?";

            $stmt = $this->conn->prepare($q);

            if (!empty($end)) {
                $stmt->bind_param('sssssii', $s, $s, $s, $end, $endNext, $limit, $off);
            } else {
                $stmt->bind_param('sssii', $s, $s, $s, $limit, $off);
            }

            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function create($customer_id, $trainer_id, $start_date, $end_date){
            $q = "INSERT INTO coaching (customer_id, trainer_id, start_date, end_date) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($q);
            $stmt->bind_param("iiss", $customer_id, $trainer_id, $start_date, $end_date);
            return $stmt->execute();
        }

        public function update($customer_id, $trainer_id, $start_date, $end_date, $assign_id){
            $q = "UPDATE coaching SET customer_id = ?, trainer_id = ?, start_date = ?, end_date = ? WHERE coaching_id = ?";
            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('iissi', $customer_id, $trainer_id, $start_date, $end_date, $assign_id);
            return $stmt->execute();
        }

        public function destroy($assign_id){
            $q = "DELETE FROM coaching WHERE coaching_id = ?";
            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('i', $assign_id);
            return $stmt->execute();
        }
        public function get($id){
            $q = "SELECT c.coaching_id AS id, c.customer_id, c.trainer_id, cu.customer_name AS trainee, CONCAT(t.first_name, ' ', t.last_name) AS trainer, c.start_date AS start, c.end_date AS end FROM coaching AS c JOIN trainers AS t ON c.trainer_id = t.trainer_id JOIN customers AS cu ON c.customer_id = cu.customer_id WHERE c.coaching_id = ?";
            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }
        public function search($id){
            $q = "SELECT c.coaching_id AS id, c.customer_id, c.trainer_id, cu.customer_name AS trainee, CONCAT(t.first_name, ' ', t.last_name) AS trainer, c.start_date AS start, c.end_date AS end FROM coaching AS c JOIN trainers AS t ON c.trainer_id = t.trainer_id JOIN customers AS cu ON c.customer_id = cu.customer_id WHERE c.customer_id = ?";
            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }
        public function isFull($trainer_id){
            $q = "SELECT t.trainer_id, t.capacity, COUNT(c.trainer_id) 
            AS current FROM trainers AS t LEFT JOIN coaching 
            AS c ON c.trainer_id = t.trainer_id 
            AND c.end_date > CURDATE() WHERE t.trainer_id = ?
             ORDER BY t.trainer_id";

            $stmt = $this->conn->prepare($q);
            $stmt->bind_param('i', $trainer_id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }
    }
?>