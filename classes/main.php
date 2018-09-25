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
        public function convert($user, $win, $db)
        {
            $coefficient = 10;
            $bonus = $win*$coefficient;
            Bonus::savePrize($user, $bonus, $db);
            $sql = "UPDATE money SET count = count+$win;
                    DELETE FROM bank WHERE user_id = $user";
            $preSql = $db->prepare($sql);
            $preSql->execute();
        }

        public function savePrize($user, $win, $db)
        {
            $sql = "SELECT max_range, `count` FROM `money`";
            $preSql = $db->prepare($sql);
            $preSql->execute();
            $money = $preSql->fetch(PDO::FETCH_ASSOC);
            if ($money['max_range'] <= $money['count']){
                $sql = "INSERT INTO bank(user_id, summ) VALUE ('$user', '$win');
                        UPDATE money SET count = count-$win";
                $preSql = $db->prepare($sql);
                $preSql->execute();
            } else {
                die;
                //Действия при недостатке денежных средств
            }
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

        public function savePrize($user, $win , $db)
        {
            $sql = "UPDATE users SET bonus = bonus + $win WHERE id = $user";
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
        }
    }

    class Item extends Main
    {
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            $arr = $preSql->fetch(PDO::FETCH_ASSOC);
            return array('min_range' => 0, 'max_range' => $arr['count(*)']-1);
        }

        public function getItemName($win, $db)
        {
            $sql = "SELECT * FROM item WHERE count > 0";
            $preSql = $db->prepare($sql);
            $preSql->execute();
            $arr = $preSql->fetchAll(PDO::FETCH_ASSOC);
            return $arr[$win]['name'];
        }

        public function savePrize($user, $win , $db)
        {
            $sql = "INSERT INTO win(user_id, prize) VALUE ('$user', '$win');
                    UPDATE `item` SET `count` = `count`-'1' WHERE `name` = '$win';";
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
        }
    }