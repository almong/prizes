<?php
//Соединение с БД
    require '../db/db.php';    

    if (!empty($_POST)){
        $errors = array();
        $sqlLogin = "SELECT * FROM users WHERE `login` = '{$_POST['login']}'";
        $preSql = $db->prepare($sqlLogin);
        $preSql->execute();
        $loginArr = $preSql->fetchALL(PDO::FETCH_ASSOC);

        if (!empty($loginArr)){
                if (password_verify($_POST['password'], $loginArr['0']['password'])){
                    $id = $loginArr['0']['id'];
                    $_SESSION['logged_user'] = $loginArr['0'];
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