<?php
//Соединение с БД
    require '../db/db.php';    
//Ищем пользователя в БД
    if (!empty($_POST)){
        $errors = array();
        $sqlLogin = "SELECT * FROM users WHERE `login` = '{$_POST['login']}'";
        $preSql = $db->prepare($sqlLogin);
        $preSql->execute();
        $loginArr = $preSql->fetch(PDO::FETCH_ASSOC);
//Проверяем пароль
        if (!empty($loginArr)){
                if (password_verify($_POST['password'], $loginArr['password'])){
                    $id = $loginArr['id'];
                    $_SESSION['logged_user'] = $id;
                    header('LOCATION: /index.php');
                    die;
                } 
                $errors[] = 'Пароль введен не верно!';
        } else {
            $errors[] = 'Пользователь не найден!';
        }
        if (!empty($errors)){
            echo '<div style="color: red; text-align: center;">'.array_shift($errors).'</div><hr>';
        }
    }
    $db = null;

    require '../template/formlogin.php';