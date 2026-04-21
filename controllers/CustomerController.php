<?php

    class CustomerController{
        private $customer;

        public function __construct($customer)
        {
            return $this->customer = $customer;
        }
        
        // add new customer
        public function addCustomer($name, $type){
            return $this->customer->create($name, $type);
        }

        // display customers
        public function display($search, $type, $member){
            return $this->customer->display($search, $type, $member);
        }

        // delete customers
        public function delete($id){
            return $this->customer->destroy($id);
        }
    }

?>