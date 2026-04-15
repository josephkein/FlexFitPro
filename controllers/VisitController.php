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
    }

?>