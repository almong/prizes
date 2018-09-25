<?php
    require_once '../classes/main.php';
    require '../db/db.php';

    //типы призов, названия соответствуют именам таблиц БД
    $prizes[] = 'money';
    $prizes[] = 'bonus';
    $prizes[] = 'item';

    //Определяем тип приза: деньги, бонусы или предмет
    $typePrize = rand(0, count($prizes)-1);

    //Заполняем объект данными
    //Получаем имя таблицы совпадающее с именем класса
    $tabName = ($prizes[$typePrize]);
    
    function getRange($sql, $db){
        $preSql = $db->prepare($sql);
        $preSql->execute(); 
        return $preSql->fetch(PDO::FETCH_ASSOC);
    }

    function newPrize($tabName, $row){
        $className = ucfirst($tabName);
        return new $className($row);
    }

    if ($tabName != 'item'){
    $sql = "SELECT * FROM $tabName";
        $arr = getRange($sql, $db);
        $row = ['name' => $tabName,
                'min_range' => $arr['min_range'],
                'max_range' => $arr['max_range']
        ];
        $prize = newPrize($tabName,$row);
    }else {
        $sql = "SELECT count(*) FROM $tabName";
        $arr = getRange($sql, $db);
        $row = ['name' => $tabName,
                'min_range' => 0,
                'max_range' => $arr['count(*)']
        ];
        $prize = newPrize($tabName,$row);
    }
    echo $prize->random();
    
    // print_r(get_class($prize[$typePrize]));
