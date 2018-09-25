<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h3>Поздравляем вы выиграли <?= $win?> USD</h3>
    <form method="post">
        <p>Отправить на счет в банке:</p>
        <input type="text" name="bank">
        <button type="submit">Отправить</button>
    </form>
    <form method="post">
        <p>Конвертировать в баллы лояльности</p>
        <button type="submit">Конвертировать</button>
    </form>
</div>
</body>
</html>