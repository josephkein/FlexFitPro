<?php

    class VisitController{
        private $visit;

        public function __construct($visit)
        {
            $this->visit = $visit;
        }
        public function monthlyVisit(){
            return $this->visit->getMonthlyVisit();
        }
        public function totalVisit(){
            return $this->visit->getTotalVisits();
        }
        public function dailyVisits(){
            return $this->visit->dailyVisits();
        }
        public function display($search, $date, $limit, $off){
            return $this->visit->display($search, $date, $limit, $off);
        }
        public function addVisit($customer_id, $user_id, $visit_date){
            return $this->visit->store($customer_id, $user_id, $visit_date);
        }
        public function displayLogs($search, $date, $limit, $off){
            return $this->visit->display($search, $date, $limit, $off);
        }
        public function todayVisit(){
            return $this->visit->todayVisit();
        }
    }

?>