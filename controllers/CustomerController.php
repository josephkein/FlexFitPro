<?php

    class CustomerController{
        private $customer;

        public function __construct($customer)
        {
            return $this->customer = $customer;
        }
        
        public function addCustomer($name, $type){
            return $this->customer->create($name, $type);
        }

        public function display($search, $type, $member){
            return $this->customer->display($search, $type, $member);
        }
    }

?>