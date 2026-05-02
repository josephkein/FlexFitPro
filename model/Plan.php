<?php

    class Plans{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }
        public function display(){
            $q = "SELECT plan_id AS id, plan_name AS name, duration_month AS duration, price FROM plans";
            $stmt = $this->db->prepare($q);
            $stmt->execute();

            $res = $stmt->get_result();
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        public function create($name, $duration, $price){
            $q = "INSERT INTO plans (plan_name, duration_month, price) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sid', $name, $duration, $price);
            return $stmt->execute();
        }
        public function destroy($id){
            $q = "DELETE FROM plans WHERE plan_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        }
        public function update($id, $name, $duration, $price){
            $q = "UPDATE plans SET plan_name = ?, duration_month = ?, price = ? WHERE plan_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('sidi', $name, $duration, $price, $id);
            return $stmt->execute();
        }
        public function get($id){
            $q = "SELECT plan_id AS id, plan_name AS name, duration_month AS duration, price FROM plans WHERE plan_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }