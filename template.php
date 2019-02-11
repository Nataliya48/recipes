<html>
<head>
    <style>
        body {
            background: #ffefd5; /* Цвет фона и путь к файлу */
        }
        .title {
            color: #b00000;
            font-style: italic;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 17pt
        }
    </style>
</head>
<body>

<h1 class="title">Выберите рецепт</h1>

<form method="post">
    <p><select size="1" name="recipe">
            <option disabled>Выберите рецепт</option>
            <option value="apple-in-the-oven">Яблоки в духовке</option>
            <option value="crab-salad">Крабовый салат</option>
            <option value="pizza-on-a-loaf">Пицца на батоне</option>
            <option value="fruit-dessert">Фруктовый десерт</option>
        </select></p>
    <p><input type="submit" value="Выбрать"></p>
</form>

<?php
if (isset($errorMsg)):
    echo $errorMsg;
else:
?>

<h1 class="title"><?= $recipe[0] ?></h1>
<hr>
<ul>
    <?php foreach ($recipe[1] as $row): ?>
    <li>
        <?= $row; ?>
    </li>
    <?php endforeach; ?>
</ul>
<p><?= $recipe[2]; ?></p>
<hr>

</body>
<?php endif; ?>