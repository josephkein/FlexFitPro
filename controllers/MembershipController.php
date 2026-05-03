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

         public function create($customer_id, $plan_id, $start_date){
            return $this->membership->create($customer_id, $plan_id, $start_date);
         }
        public function delete($id){
            return $this->membership->destroy($id);
        }
        public function update($id, $plan_id, $start_date){
            return $this->membership->update($id, $plan_id, $start_date);
        }

    }

?>