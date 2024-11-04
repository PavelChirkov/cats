<?php
include_once 'Cats.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Учет Кошек</title>
</head>
<body>
<h1>Учет Кошек</h1>
<form action="/cat_management.php" method="post">
    <label>Кличка:</label>
    <input type="text" name="name" required><br>

    <label>Пол:</label>
    <select name="gender" required>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select><br>

    <label>Возраст (в годах):</label>
    <input type="number" name="age" required><br>

    <input type="hidden" name="action" value="add">
    <button type="submit">Добавить кошку</button>
</form>

<h2>Фильтрация кошек</h2>
<form action="index.php" method="get">
    <label>Возраст:</label>
    <input type="number" name="filter_age"><br>ИЛИ

    <label>Пол:</label>
    <select name="filter_gender">
        <option value="">Все</option>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select>

    <br>
    <button type="submit">Фильтровать</button>
</form>

<h2>Список кошек</h2>
<div id="cats_list">
    <?php
     $cats = new Cats();
     $cats->print();
    ?>
</div>
</body>
</html>