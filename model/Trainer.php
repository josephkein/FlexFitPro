<?php

    class Trainer{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        
        // display trainers
        public function display($search, $limit, $off){
            $s = "%$search%";
 
            $q = "SELECT CONCAT(t.first_name, ' ' , t.last_name) AS trainer,
             t.capacity, t.rate, COUNT(c.coaching_id) AS trainees FROM 
             trainers AS t LEFT JOIN coaching AS c ON c.trainer_id = t.trainer_id
              WHERE t.first_name LIKE ? 
              GROUP BY t.trainer_id LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sii', $s, $limit, $off);    
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }
        public function create($first, $last, $rate, $capacity){

            // insert new customer
            $q = "INSERT INTO trainers (first_name, last_name, rate, capacity) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param("ssdi", $first, $last, $rate, $capacity);
            return $stmt->execute();

        }
    }

?>