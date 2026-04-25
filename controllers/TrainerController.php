<?php

    class TrainerController{
        private $trainer;

        public function __construct($trainer)
        {
            $this->trainer = $trainer;
        }
        public function display($search, $limit, $off){
            return $this->trainer->display($search, $limit, $off);
        }
        public function addTrainer($first, $last, $rate, $capacity){
            return $this->trainer->create($first, $last, $rate, $capacity);
        }
        public function update($first, $last, $rate, $capacity, $id){
            return $this->trainer->edit($first, $last, $rate, $capacity, $id);
        }
        public function getTrainer($id){
            return $this->trainer->get($id);
        }
        public function destroy($id){
            return $this->trainer->delete($id);
        }
    }


?>