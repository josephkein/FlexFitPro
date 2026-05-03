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
        public function display($search, $type, $order, $membership, $limit, $off){
            return $this->customer->display($search, $type, $order, $membership, $limit, $off);
        }

        // delete customers
        public function delete($id){
            return $this->customer->destroy($id);
        }

        // get customer
        public function getCustomer($id){
            return $this->customer->get($id);
        }

        // edit custmomer
        public function update($name, $type, $id){
            return $this->customer->edit($name, $type, $id);
        }

        public function suggestion($search){
            return $this->customer->suggestion($search);
        }
    }

?>