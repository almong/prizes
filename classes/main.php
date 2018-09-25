<?php
    class Main 
    {
        public $prizeName;
        public $minRange;
        public $maxRange;
            
        function __construct($tabName, $row)
        {
            $this->prizeName = $tabName;
            $this->minRange = $row['min_range'];
            $this->maxRange = $row['max_range'];
        }

        function random()
        {
            return rand($this->minRange, $this->maxRange);            
        }
    }

    class Money extends Main
    {
        function convert($win)
        {
            $coefficient = 2;
            return $win*$coefficient;   
        }

        function bank($user, $win, $bank, $db)
        {
            $sql = "INSERT INTO bank(user_id, summ, bank, done) 
            VALUE ('$user', '$win', '$bank', '0')";
            $preSql = $db->prepare($sql);
            $preSql->execute();
        }

        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            return $preSql->fetch(PDO::FETCH_ASSOC);
        }
    }

    class Bonus extends Main
    {
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            return $preSql->fetch(PDO::FETCH_ASSOC);
        }
    }

    class Item extends Main
    {
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            $arr = $preSql->fetch(PDO::FETCH_ASSOC);
            return array('min_range' => 0, 'max_range' =>$arr['count(*)']);
        }
    }