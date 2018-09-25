<?php
    require_once '../classes/main.php';
    require '../db/db.php';

    $prize = array();

    $prize[] = new Money;
    $prize[] = new Bonus;
    $prize[] = new Item;

    $typePrize = rand(0, count($prize)-1);

    echo $typePrize;
