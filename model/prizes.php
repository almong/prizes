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
    $sql = ($tabName != 'item') ? "SELECT * FROM $tabName" : "SELECT count(*) FROM $tabName";
    
    $row = $className::getRange($sql, $db); // получаем значения min/max_range
    $winPrize = new $className($tabName, $row);
    $win = $winPrize->random();
    
    print_r($winPrize);
    echo $win;
//Выигрыш - Деньги
    if (get_class($winPrize) == 'Money'){
        require '../template/moneywin.php';
    }
//Выигрыш - Бонусы
    if (get_class($winPrize) == 'Bonus'){
        require '../template/bonuswin.php';
    }
//Выигрыш - Предмет
    if (get_class($winPrize) == 'Item'){
        require '../template/Itemwin.php';
    }
