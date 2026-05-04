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
                $ind = (int) $row['day'];
                $daily[$ind] = $row['visits'];
            }
            return $daily;
            
        }

        public function todayVisit(){
            $q = "SELECT COUNT(visit_id) AS visits FROM visits 
            WHERE visit_date >= CURDATE() 
            AND visit_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)";

            $stmt = $this->db->prepare($q);
            $stmt->execute();

            $res = $stmt->get_result();
            $data = $res->fetch_assoc();
            return $data['visits'];

        }

        public function display($search, $date, $limit, $off){
            $s = "%{$search}%";

            if (!empty($date)){
                $start = $date . " 00:00:00";
                $end = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));

                $q = "SELECT v.visit_id AS id, c.customer_name AS customer, c.customer_type AS type, u.username AS staff, v.visit_date AS date
                FROM visits AS v
                INNER JOIN customers AS c ON c.customer_id = v.customer_id
                INNER JOIN users AS u ON u.user_id = v.user_id
                WHERE c.customer_name LIKE ? AND v.visit_date >= ? AND v.visit_date < ?
                ORDER BY v.visit_date DESC
                LIMIT ? OFFSET ?";

                $stmt = $this->db->prepare($q);
                $stmt->bind_param('sssii', $s, $start, $end, $limit, $off);
            } else {
                $q = "SELECT v.visit_id AS id, c.customer_name AS customer, c.customer_type AS type, u.username AS staff, v.visit_date AS date
                FROM visits AS v
                INNER JOIN customers AS c ON c.customer_id = v.customer_id
                INNER JOIN users AS u ON u.user_id = v.user_id
                WHERE c.customer_name LIKE ?
                ORDER BY v.visit_date DESC
                LIMIT ? OFFSET ?";

                $stmt = $this->db->prepare($q);
                $stmt->bind_param('sii', $s, $limit, $off);
            }

            $stmt->execute();
            $res = $stmt->get_result();

            return $res->fetch_all(MYSQLI_ASSOC);
        }
        
        public function store($customer_id, $user_id, $visit_date){
            $q = "INSERT INTO visits (customer_id, user_id, visit_date) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($q);
            $stmt->bind_param('iis', $customer_id, $user_id, $visit_date);
            return $stmt->execute();
        }

    
    }

?>