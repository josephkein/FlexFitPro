<?php

    class AssignController{
        private $assign;

        public function __construct($assign)
        {
            $this->assign = $assign;
        }

        public function display($search, $enddate, $session, $limit, $off){
            return $this->assign->display($search, $enddate, $session, $limit, $off);
        }
        public function create($customer_id, $trainer_id, $start_date, $end_date){
            return $this->assign->create($customer_id, $trainer_id, $start_date, $end_date);
        }
        public function update($customer_id, $trainer_id, $start_date, $end_date, $assign_id){
            return $this->assign->update($customer_id, $trainer_id, $start_date, $end_date, $assign_id);
        }
        public function destroy($assign_id){
            return $this->assign->destroy($assign_id);
        }
        public function get($id){
            return $this->assign->get($id);
        }
        public function search($customer_id){
            return $this->assign->search($customer_id);
        }
        public function isFull($trainer_id){
            return $this->assign->isFull($trainer_id);
        }
    }


?>