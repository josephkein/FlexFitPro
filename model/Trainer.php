<?php

    class Trainer{
        private $db;

        public function __construct(mysqli $db)
        {
            $this->db = $db;
        }
       
    }

?>