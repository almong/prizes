<?php
    session_start();
    $user = 'admin';
    $pass = '';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $db = new PDO('mysql:host=localhost;dbname=prizes', $user, $pass, $options);
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
