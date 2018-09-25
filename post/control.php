<?php
    require '../classes/main.php';
    require '../db/db.php';

    //Выполняем конвертацию в балы лояльности
    if (!empty($_POST)){
        if ($_POST['convert'] == 1){
            $sql = "SELECT `summ` FROM `bank` WHERE `user_id` = '{$_SESSION['logged_user']}'";
            $preSql = $db->prepare($sql);
            $preSql->execute();
            $win = $preSql->fetch(PDO::FETCH_ASSOC)['summ'];
            Money::convert($_SESSION['logged_user'], $win, $db);
        } 
    //Добавляем номер счета в банке
        if (!empty($_POST['bank'])){
            $sql = "UPDATE `bank` SET `bank` = '{$_POST['bank']}' WHERE `user_id` = '{$_SESSION['logged_user']}'";
            $preSql = $db->prepare($sql);
            $preSql->execute();
        } 
    //Добавляем адрес доставки приза
        if (!empty($_POST['adress'])){
            $sql = "UPDATE `win` SET `adress` = '{$_POST['adress']}' WHERE `user_id` = '{$_SESSION['logged_user']}'";
            $preSql = $db->prepare($sql);
            $preSql->execute();
        }
    //Отказ от подарка
        if ($_POST['refuse'] == 1){
            $sql = "SELECT `prize` FROM `win` WHERE `user_id` = '{$_SESSION['logged_user']}'";
            $preSql = $db->prepare($sql);
            $preSql->execute();
            $name = $preSql->fetch(PDO::FETCH_ASSOC)['prize'];
            $sql = "UPDATE `item` SET `count` = `count`+'1' WHERE `name` = '$name';
                    DELETE FROM `win` WHERE `user_id` = '{$_SESSION['logged_user']}'";
            $preSql = $db->prepare($sql);
            $preSql->execute();
        }   
        header('Location: /');
    $db=null;
    }
