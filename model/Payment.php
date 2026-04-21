<?php

    class Payment{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function monthly(){
            $query = "SELECT MONTH(payment_date) AS month, SUM(amount) AS total_amt FROM payments WHERE payment_date >= '2026-01-01' AND payment_date < '2027-01-01' GROUP BY MONTH(payment_date) ORDER BY MONTH(payment_date)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $monthly = array_fill(0, 12, 0);

            while ($row = $result->fetch_assoc()){
                $ind = $row['month'] - 1;
                $monthly[$ind] = $row['total_amt'];
            }
            return $monthly;
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