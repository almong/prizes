<?php
    require_once '../classes/main.php';
    require '../db/db.php';

//Типы призов, названия соответствуют именам таблиц БД
    $prizes[] = 'money';
    $prizes[] = 'bonus';
    $prizes[] = 'item';

//Определяем тип приза: деньги, бонусы или предмет
    $typePrize = rand(0, count($prizes)-1);

//Получаем имя таблицы совпадающее с именем класса
    $tabName = ($prizes[$typePrize]);
    $className = ucfirst($tabName);
    $sql = ($tabName != 'item') ? "SELECT * FROM $tabName" : "SELECT count(*) FROM $tabName WHERE count > 0";
    
    $row = $className::getRange($sql, $db); // получаем значения min/max_range
    if ($row['max_range'] < $row['min_range']){
        die; //Здесь должно быть исключение приза у которого кончился лимит из лотереи.
    }
    $winPrize = new $className($tabName, $row); //Создаем объект класса который выиграл
    $win = $winPrize->random(); //Получаем значение выигрыша

    if (get_class($winPrize) == 'Item'){
        $win = $winPrize->getItemName($win, $db); //Получаем имя предмета, если выигрыш - предмет
    }
    $winPrize->savePrize($_SESSION['logged_user'], $win, $db); //Записываем выигрыш в БД
    require '../template/'.$tabName.'win.php';