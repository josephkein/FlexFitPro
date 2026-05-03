<?php

    class Membership{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function getActive($customer_id) {
            $q = "SELECT m.membership_id AS id, m.start_date, p.plan_name, p.duration_month,
                         DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) AS end_date
                  FROM memberships AS m
                  INNER JOIN plans AS p ON p.plan_id = m.plan_id
                  WHERE m.customer_id = ?
                  ORDER BY end_date DESC
                  LIMIT 1";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $customer_id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_assoc(); 
        }
        // display members
        public function display($search, $plan, $limit, $off){
            $s = "$search%";
            $p = "$plan%";

            $q = "SELECT m.membership_id AS id, c.customer_name AS customer, p.plan_name AS plan, m.start_date AS start, DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) AS end FROM memberships AS m
             INNER JOIN customers AS c ON c.customer_id = m.customer_id
             INNER JOIN plans AS p ON p.plan_id = m.plan_id WHERE c.customer_name LIKE ? AND p.plan_name LIKE ? ORDER BY end DESC LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('ssii', $s, $p, $limit, $off);
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
            
        }

        public function create($customer_id, $plan_id, $start_date){
            $q = "INSERT INTO memberships (customer_id, plan_id, start_date) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('iis', $customer_id, $plan_id, $start_date);
            return $stmt->execute();
        }
        public function destroy($id){
            $q = "DELETE FROM memberships WHERE membership_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        }

        public function update($id, $plan_id, $start_date){
            $q = "UPDATE memberships SET plan_id = ?, start_date = ? WHERE membership_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('isi', $plan_id, $start_date, $id);
            return $stmt->execute();
        }

        public function get($id){
            $q = "SELECT m.membership_id AS id, m.customer_id, m.plan_id, m.start_date, c.customer_name AS customer_name, p.plan_name AS plan_name FROM memberships AS m
                  INNER JOIN customers AS c ON c.customer_id = m.customer_id
                  INNER JOIN plans AS p ON p.plan_id = m.plan_id
                  WHERE m.membership_id = ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_assoc();
        }
    }

?>
