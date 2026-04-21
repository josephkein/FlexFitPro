<?php

    class Customer{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function create($name, $type){

            // insert new customer
            $q = "INSERT INTO customers (customer_name, customer_type) VALUES (?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param("ss", $name, $type);
            return $stmt->execute();

        }
        public function destroy(){

        }
        public function update(){

        }
        public function display($search, $type, $member){
            $q = "SELECT c.customer_name AS name, c.customer_type AS type, m.membership_id AS member, t.first_name AS trainer FROM customers AS c
             LEFT JOIN memberships AS m ON m.customer_id = c.customer_id 
             LEFT JOIN coaching AS ch ON ch.customer_id = c.customer_id 
             LEFT JOIN trainers AS t ON t.trainer_id = ch.trainer_id WHERE name LIKE ? AND type = ? AND member = ? LIMIT 7";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sss', $search, $type, $member);
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }
    }

?>