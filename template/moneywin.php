<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h3>Поздравляем вы выиграли <?= $win?> USD</h3>
    <form action="post/control.php"method="post">
        <p>Отправить на счет в банке:</p>
        <input type="text" name="bank">
        <button type="submit" name="btn_bank" value="1">Отправить</button>
    </form>
    <form action="post/control.php"method="post">
        <p>Конвертировать в баллы лояльности</p>
        <button type="submit" name="convert" value="1">Конвертировать</button>
    </form>
</body>
</html>