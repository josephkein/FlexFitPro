<?php

    class Trainer{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        
        // display trainers
        public function display($search, $limit, $off){
            $s = "$search%";
 
            $q = "SELECT t.trainer_id, CONCAT(t.first_name, ' ' , t.last_name) AS trainer,
             t.capacity, t.rate, COUNT(c.coaching_id) AS trainees FROM 
             trainers AS t LEFT JOIN coaching AS c ON c.trainer_id = t.trainer_id AND c.status = 'Active'
              WHERE t.first_name LIKE ? 
              GROUP BY t.trainer_id LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sii', $s, $limit, $off);    
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }

        // add new trainer
        public function create($first, $last, $rate, $capacity){

            // insert new trainer
            $q = "INSERT INTO trainers (first_name, last_name, rate, capacity) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param("ssdi", $first, $last, $rate, $capacity);
            return $stmt->execute();

        }
        
        // update trainer
        public function edit($first, $last, $rate, $capacity, $id){

            $q = "UPDATE trainers SET first_name = ?, last_name = ?, rate = ?, capacity = ? WHERE trainer_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param("ssdii", $first, $last, $rate, $capacity, $id);
            return $stmt->execute();
        }

        // Get trainer by id
        public function get($id){
            $q = "SELECT first_name, last_name, rate, capacity FROM trainers WHERE trainer_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);        
            $stmt->execute();

            $res = $stmt->get_result();
            return $res->fetch_assoc();
        }

        // Delete a trainer
        public function delete($id){
            $q1 = "DELETE FROM coaching WHERE trainer_id = ?";
            $s1 = $this->db->prepare($q1);
            $s1->bind_param("i", $id);
            $s1->execute();

            $q = "DELETE FROM trainers WHERE trainer_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);        
            return $stmt->execute();

        }
    }

?>