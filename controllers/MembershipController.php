<?php

    class MembershipController{
        private $membership;

        public function __construct($membership)
        {
            $this->membership = $membership;
        }
        public function getActive($customer_id){
            return $this->membership->getActive($customer_id);
        }
         // display members
         public function display($search, $plan, $limit, $off){
            return $this->membership->display($search, $plan, $limit, $off);
         }
    }

?>