<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
<h3>Поздравляем вы выиграли <?= $win?></h3>
    <form action="post/control.php" method="post">
        <p>Укажите адрес доставки</p>
        <input type="text" name="adress">
        <button type="submit">Отправить</button>
    </form>
    <form action="post/control.php" method="post">
        <button type="submit" name="refuse" value="1">Отказаться</button>
    </form>
</body>
</html>