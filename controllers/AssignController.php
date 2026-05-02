<?php

    class AssignController{
        private $assign;

        public function __construct($assign)
        {
            $this->assign = $assign;
        }

        public function display($search, $enddate, $limit, $off){
            return $this->assign->display($search, $enddate, $limit, $off);
        }
    }


?>