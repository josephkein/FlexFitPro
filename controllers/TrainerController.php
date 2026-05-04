<?php

    class TrainerController{
        private $trainer;

        public function __construct($trainer)
        {
            $this->trainer = $trainer;
        }
        public function display($search, $min, $max, $limit, $off){
            return $this->trainer->display($search, $min, $max, $limit, $off);
        }
        public function addTrainer($first, $last, $contact, $rate, $capacity){
            return $this->trainer->create($first, $last, $contact, $rate, $capacity);
        }
        public function update($first, $last, $contact, $rate, $capacity, $id){
            return $this->trainer->edit($first, $last, $contact, $rate, $capacity, $id);
        }
        public function getTrainer($id){
            return $this->trainer->get($id);
        }
        public function destroy($id){
            return $this->trainer->delete($id);
        }
        public function available(){
            return $this->trainer->available();
        }
    }


?>