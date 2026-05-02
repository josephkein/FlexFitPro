<?php

    class Membership{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function getActive($customer_id) {
            $q = "SELECT m.membership_id, m.start_date, p.plan_name, p.duration_month,
                         DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) AS end_date
                  FROM memberships AS m
                  INNER JOIN plans AS p ON p.plan_id = m.plan_id
                  WHERE m.customer_id = ?
                    AND DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) >= CURDATE()
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

            $q = "SELECT c.customer_name AS customer, p.plan_name AS plan, m.start_date AS start, DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) AS end FROM memberships AS m
             INNER JOIN customers AS c ON c.customer_id = m.customer_id
             INNER JOIN plans AS p ON p.plan_id = m.plan_id WHERE c.customer_name LIKE ? AND p.plan_name LIKE ? ORDER BY end DESC LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('ssii', $s, $p, $limit, $off);
            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
            
        }
    }

?>
