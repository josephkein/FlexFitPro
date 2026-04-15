<?php

    class PaymentController{
        private $payment;

        public function __construct($payment)
        {
            $this->payment = $payment;
        }
        public function getRevenue($month){
            return $this->payment->getRevenue($month);
        }
        public function totalRevenue(){
            return $this->payment->getTotalRevenue();
        }
        public function dailyRevenue(){
            return $this->payment->getDailyRevenue();
        }
    }

?>