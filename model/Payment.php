<?php

    class Payment{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function getMonthlyRevenue($month){
            $query = "SELECT SUM(amount) AS total_amt FROM payments WHERE MONTH(payment_date) = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $month);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) return $result->fetch_assoc();
            return null;
        }
        public function getTotalRevenue(){
            $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) AS total_revenue FROM payments");
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0){
                $r = $res->fetch_assoc();
                return $r['total_revenue'];
            }
            return 0;
        }
        public function getDailyRevenue(){
            $stmt = $this->db->prepare("SELECT COALESCE(SUM(amount), 0) AS daily FROM payments WHERE payment_date >= CURDATE() AND payment_date < CURDATE() + INTERVAL 1 DAY");
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0){
                $r = $res->fetch_assoc();
                return $r['daily'];
            }
            return null;
        }
    }

?>