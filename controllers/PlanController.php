<?php

    class PlanController{
        private $plan;

        public function __construct($plan)
        {
            $this->plan = $plan;
        }
        public function display(){
            return $this->plan->display();
        }
        public function create($name, $duration, $price){
            return $this->plan->create($name, $duration, $price);
        }
        public function delete($plan_id){
            return $this->plan->destroy($plan_id);
        }
        public function update($plan_id, $name, $duration, $price){
            return $this->plan->update($plan_id, $name, $duration, $price);
        }
        public function get($plan_id){
            return $this->plan->get($plan_id);
        }
    }

?>