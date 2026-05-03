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
        public function display($search, $type, $date, $limit, $off){
            return $this->payment->display($search, $type, $date, $limit, $off);
        }
        public function getPayment($id){
            return $this->payment->get($id);
        }
        public function create($customer_id, $user_id, $date, $amount, $type){
            return $this->payment->create($customer_id, $user_id, $date, $amount, $type);
        }
        public function delete($id){
            return $this->payment->destroy($id);
        }
        public function update($id, $amount, $payment_type){
            return $this->payment->update($id, $amount, $payment_type);
        }
    }

?>