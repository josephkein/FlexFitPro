<?php

    class Database{
        private $con;

        public function __construct(array $c)
        {
            $this->con = new mysqli($c['host'], $c['user'], $c['pass'], $c['db']);
            if ($this->con->connect_error) die ("Connection Failed" . $this->con->connect_error);
        }
        public function getConnection(){
            return $this->con;
        }
    }

?>