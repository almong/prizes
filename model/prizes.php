<?php
    require_once '../classes/main.php';
    require '../db/db.php';

    //типы призов, названия соответствуют именам таблиц БД
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
        echo $className.' Error';
        die; //Здесь должно быть исключение приза у которого кончился лимит из лотереи.
    }
    $winPrize = new $className($tabName, $row);
    $win = $winPrize->random();
    
    if (get_class($winPrize) == 'Item'){
        $win = $winPrize->getItemName($win, $db);
    }
    $winPrize->savePrize($_SESSION['logged_user'], $win, $db);
    require '../template/'.$tabName.'win.php';