<?php

    class Visit{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
        public function getMonthlyVisit(){
            $q = "SELECT COUNT(visit_id) as monthly_visit 
                 FROM visits WHERE visit_date >= CURDATE() - INTERVAL DAY(CURDATE())-1 DAY AND
                 visit_date < CURDATE() + INTERVAL 1 DAY
            ";
            $stmt = $this->db->prepare($q);
            
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0){
                $r = $res->fetch_assoc();
                return $r['monthly_visit'];
            }
            return null;
        }
        public function getTotalVisits(){
            $stmt = $this->db->prepare("SELECT COUNT(visit_id) AS total_visit FROM visits");
            $stmt->execute();

            $res = $stmt->get_result();

            if ($res->num_rows > 0){
                $r = $res->fetch_assoc();
                return $r['total_visit'];
            }
            return null;
        }
    }

?>