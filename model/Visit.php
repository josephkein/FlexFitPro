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
        
        public function dailyVisits(){
            $q = "SELECT COUNT(visit_id) AS visits, WEEKDAY(visit_date) as day FROM visits WHERE
             visit_date >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) AND
             visit_date < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 7 DAY)
             GROUP BY WEEKDAY(visit_date) ORDER BY day";
            $stmt = $this->db->prepare($q);
            $stmt->execute();

            $res = $stmt->get_result();

            $daily = array_fill(0, 7, 0);

            while ($row = $res->fetch_assoc()){
                $ind = $row['day'] - 1;
                $daily[$ind] = $row['visits'];
            }
            return $daily;
            
        }
    }

?>