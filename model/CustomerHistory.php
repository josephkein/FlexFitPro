<?php

    class CustomerHistory {
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function create($customer_id, $trainer, $visit, $plan){
            $q = "INSERT INTO customer_history (customer_id, prev_trainer, prev_visit, prev_plan) VALUES(?, ?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('isss', $customer_id, $trainer, $visit, $plan);
            return $stmt->execute();

        }
        // Previous (most recent non-active) membership plan
        public function getPreviousPlan($id)
        {
            $q = "SELECT p.plan_name, p.duration_month, m.start_date,
                    DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) AS end_date,
                    CASE
                        WHEN CURDATE() < m.start_date THEN 'Pending'
                        WHEN CURDATE() BETWEEN m.start_date
                            AND DATE_ADD(m.start_date, INTERVAL p.duration_month MONTH) THEN 'Active'
                        ELSE 'Expired'
                    END AS status
                  FROM memberships m
                  JOIN plans p ON p.plan_id = m.plan_id
                  WHERE m.customer_id = ?
                  ORDER BY m.start_date DESC
                  LIMIT 1";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // Most recent trainer assigned (from coaching table)
        public function getPreviousTrainer($id)
        {
            $q = "SELECT CONCAT(t.first_name, ' ', t.last_name) AS trainer_name,
                    ch.start_date, ch.end_date
                  FROM coaching ch
                  JOIN trainers t ON t.trainer_id = ch.trainer_id
                  WHERE ch.customer_id = ?
                  ORDER BY ch.start_date DESC
                  LIMIT 1";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // Last visit logged
        public function getLastVisit($id)
        {
            $q = "SELECT v.visit_date, u.username AS logged_by,
                    COALESCE(pay.amount, 0) AS fee
                  FROM visits v
                  JOIN users u ON u.user_id = v.user_id
                  LEFT JOIN payments pay
                        ON  pay.customer_id = v.customer_id
                        AND pay.payment_type = 'visit'
                        AND DATE(pay.payment_date) = DATE(v.visit_date)
                  WHERE v.customer_id = ?
                  ORDER BY v.visit_date DESC
                  LIMIT 1";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }

?>
