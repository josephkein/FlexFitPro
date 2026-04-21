<?php

    class PaymentController{
        private $payment;

        public function __construct($payment)
        {
            $this->payment = $payment;
        }
        public function getMonthly(){
            return $this->payment->monthly();
        }
        public function totalRevenue(){
            return $this->payment->getTotalRevenue();
        }
        public function dailyRevenue(){
            return $this->payment->getDailyRevenue();
        }
    }

?>