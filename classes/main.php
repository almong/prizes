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
//Поиск случайного значения в диапазоне
        function random()
        {
            return rand($this->minRange, $this->maxRange);            
        }
     }
//Класс приза - Деньги
    class Money extends Main
    {
//Конвертация из денег в баллы с использованием коэффициента
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
//Запись выигрыша в БД
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
//Получаем из БД диапазон для случайного значения
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            return $preSql->fetch(PDO::FETCH_ASSOC);
        }
    }
//Класс приза - Баллы
    class Bonus extends Main
    {
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            return $preSql->fetch(PDO::FETCH_ASSOC);
        }
//Получаем из БД диапазон для случайного значения
        public function savePrize($user, $win , $db)
        {
            $sql = "UPDATE users SET bonus = bonus + $win WHERE id = $user";
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
        }
    }
//Класс приза - Предмет
    class Item extends Main
    {
//Получаем из БД диапазон для случайного значения
        public function getRange($sql, $db){
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
            $arr = $preSql->fetch(PDO::FETCH_ASSOC);
            return array('min_range' => 0, 'max_range' => $arr['count(*)']-1);
        }
//Получаем название предмета
        public function getItemName($win, $db)
        {
            $sql = "SELECT * FROM item WHERE count > 0";
            $preSql = $db->prepare($sql);
            $preSql->execute();
            $arr = $preSql->fetchAll(PDO::FETCH_ASSOC);
            return $arr[$win]['name'];
        }
//Получаем из БД диапазон для случайного значения

        public function savePrize($user, $win , $db)
        {
            $sql = "INSERT INTO win(user_id, prize) VALUE ('$user', '$win');
                    UPDATE `item` SET `count` = `count`-'1' WHERE `name` = '$win';";
            $preSql = $db->prepare($sql);
            $preSql->execute(); 
        }
    }