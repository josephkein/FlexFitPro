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
        public function display($search, $type, $order, $limit, $off){
            return $this->customer->display($search, $type, $order, $limit, $off);
        }

        // delete customers
        public function delete($id){
            return $this->customer->destroy($id);
        }

        // get user
        public function getCustomer($id){
            return $this->customer->get($id);
        }
    }

?>