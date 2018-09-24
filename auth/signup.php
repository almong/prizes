<?php
//Соединение с БД
    require '../db/db.php';
//Функция проверки на логина на уникальность
    function uniqLogin($login, $db)
    {
        $sql = "SELECT id FROM users WHERE `login` = '$login'";
        $preSql = $db->prepare($sql);
        $preSql->execute();

        if ($preSql->fetchALL(PDO::FETCH_ASSOC)){
            return true;
        } else {
            return false;
        }
    }
//Функция записи логина/пароля в БД
    function signup($login, $password, $db)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(login, password) VALUE ('$login', '$password')";
        $preSql = $db->prepare($sql);
        $preSql->execute();
    }
// Проверяем введены ли данные в форму
    if (!empty($_POST)){
        $errors = array();
//Проверка на не пустой логин
        if (trim($_POST['login']) == ''){
            $errors[] = 'Введите логин!';
        } 
//Проверка на не пустой пароль
        if ($_POST['password'] == ''){
            $errors[] = 'Введите пароль!';
        } 
//Проверка логина на уникальность
        if (uniqLogin($_POST['login'], $db)){
            $errors[] = 'Пользователь с таким логином уже существует';
        }
// Если ошибок нет то добавляем в БД запись о пользователе.
        if (empty($errors)){
            signup($_POST['login'], $_POST['password'], $db);
            header('LOCATION: signin.php');  
            die; 
        } else {
            echo array_shift($errors);
        }
    }
    $db = null;

    require '../template/formlogin.php';