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

<!-- печатать всплывающий список из массива файлов, который присутствует в директории, и при выборе печатать этот рецепт на экране -->

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

<h1 class="title">Рецепт из файла</h1>
<h1 class="title">Выберите рецепт</h1>

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

<hr>
<hr>
<hr>
<hr>
<hr>


<table border="1" width="100%" cellpadding="5">



    <tr class="title">
        <th>Яблоки в духовке</th>
        <th>Крабовый салат</th>
        <th>Пицца на батоне</th>
        <th>Сосиски с беконом и сыром</th>
        <th>Фруктовый десерт</th>
    </tr>

    <tr>
        <td>
            <ul>
                <li>Яблоки</li>
                <li>Корица</li>
                <li>Мед</li>
                <li>Сахарная пудра</li>
                <li>Изюм (при желании)</li>
                <li>Орехи</li>
                <li>Бумага для запекания</li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Огурец (свежий)</li>
                <li>Яйцо</li>
                <li>Кукуруза</li>
                <li>Горошик</li>
                <li>Крабовые палочки</li>
                <li>Майонез</li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Ветчина 200г</li>
                <li>Сыр 200г</li>
                <li>Майонез</li>
                <li>Кетчуп</li>
                <li>Батон</li>
                <li>Зелень (при желании)</li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Сосиски</li>
                <li>Сыр</li>
                <li>Бекон</li>
                <li>Соус для мяса</li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Творог</li>
                <li>Йогурт</li>
                <li>Орехи</li>
                <li>Мандарины и (киви, бананы...)</li>
                <li>Мята (при желании)</li>
                <li>Какао (при желании)</li>
            </ul>
        </td>
    </tr>


</table>

<h1 class="title">Яблоки в духовке</h1>
<hr>
<ul>
    <li>Яблоки</li>
    <li>Корица</li>
    <li>Мед</li>
    <li>Сахарная пудра</li>
    <li>Изюм (при желании)</li>
    <li>Орехи</li>
    <li>Бумага для запекания</li>
</ul>
<hr>

<h1 class="title">Крабовый салат</h1>
<hr>
<ul>
    <li>Огурец (свежий)</li>
    <li>Яйцо</li>
    <li>Кукуруза</li>
    <li>Горошик</li>
    <li>Крабовые палочки</li>
    <li>Майонез</li>
</ul>
<hr>

<h1 class="title">Пицца на батоне</h1>
<hr>
<ul>
    <li>Ветчина 200г</li>
    <li>Сыр 200г</li>
    <li>Майонез</li>
    <li>Кетчуп</li>
    <li>Батон</li>
    <li>Зелень (при желании)</li>
</ul>
<hr>

<h1 class="title">Сосиски с беконом и сыром</h1>
<hr>
<ul>
    <li>Сосиски</li>
    <li>Сыр</li>
    <li>Бекон</li>
    <li>Соус для мяса</li>
</ul>
<hr>

<h1 class="title">Фруктовый десерт</h1>
<hr>
<ul>
    <li>Творог</li>
    <li>Йогурт</li>
    <li>Орехи</li>
    <li>Мандарины и (киви, бананы...)</li>
    <li>Мята (при желании)</li>
    <li>Какао (при желании)</li>
</ul>
<hr>
</body>
<?php endif; ?>