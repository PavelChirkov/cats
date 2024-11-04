<?php
include_once 'Cats.php';

$id = (int) $_GET['id'];
$cats = new Cats();
$cat = $cats->One($id);

?>
<form action="/cat_management.php" method="post">
<table>
    <tr>
        <td>#</td>
        <td><?=(int)$cat->id;?></td>
    </tr>
    <tr>
        <td>Кличка</td>
        <td>
            <input type="text" name="name" value="<?=(string)$cat->name;?>" required>
        </td>
    </tr>
    <tr>
        <td>Пол</td>
        <td>
            <select name="gender">
                <option value="">Все</option>
                <option value="male" <? print ((string)$cat->gender === "male" )? "selected":""; ?>>Мужской</option>
                <option value="female" <? print ((string)$cat->gender !== "male" )? "selected":"";?>>Женский</option>
            </select>
            <?=(string)$cat->gender;?></td>
    </tr>
    <tr>
        <td>Возраст</td>
        <td>
            <input type="text" name="age" value="<?=(string)$cat->age;?>" required>
        </td>
    </tr>
</table>
    <input type="hidden" name="id" value="<?=(int)$cat->id;?>">
    <input type="hidden" name="action" value="update">
    <button type="submit">Изменить</button>
</form>

Мать:
<?php
if(!isset($cat->mother)){?>
<form action="/cat_management.php" method="post">
    <select name="mother">
        <? $cats->print('select','female'); ?>
    </select>
    <input type="hidden" name="id" value="<?=(int)$cat->id;?>">
    <input type="hidden" name="action" value="updateMother">
    <button type="submit">Добавить</button>
</form>
<?php }else{?> <strong> <?=$cat->mother;?></strong> <a href="/cat_management.php?action=deleteMother&id=<?=(int)$cat->id;?>">Удалить</a><?php }?>
<div style="clear:both"></div>
Отец/Отцы:

<form action="/cat_management.php" method="post">
    <select name="father">
        <? $cats->print('select'); ?>
    </select>
    <input type="hidden" name="id" value="<?=(int)$cat->id;?>">
    <input type="hidden" name="action" value="updateFather">
    <button type="submit">Добавить</button>
</form>

<ul>
<?php
    $i = 0;
    foreach ($cat->father as $father){?>
        <li><?=$father;?><a href="/cat_management.php?action=deletefather&id=<?=(int)$cat->id;?>&delete_father=<?=$i;?>">Удалить</a></li>
    <?
    $i++;
    }?>
</ul>
