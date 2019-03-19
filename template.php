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

        .additional {
            color: #d66666;
            font-style: italic;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 13pt
        }

        #add {
            display: none;
        }
    </style>


</head>
<body>
<h1 class="title">Выберите рецепт</h1>
<?php if (!empty($listNames)): ?>
    <form method="post">
        <p><select size="1" name="recipe">
                <option disabled>Выберите рецепт</option>
                <?php foreach ($listNames as $name): ?>
                    <option value="<?= $name ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select></p>
        <p><input type="submit" value="Выбрать"></p>
    </form>
<?php else: ?>
    <h1 class="title">Введите свой первый рецепт</h1>
<?php endif; ?>
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

<form method="post" id="add" name="add">
    <h1 class="title">Добавить свой рецепт</h1>
    <p class="additional">Введите название:</p>
    <input type="text" required name="name"><br>
    <p class="additional">Введите ингридиенты через запятую:</p>
    <input type="text" required name="ingredients"><br>
    <p class="additional">Опишите сам рецепт приготовления:</p>
    <input type="text" required name="description"><br>
    <p><input type="submit" value="Записать"></p>
</form>

<button id="show-form">Показать форму</button>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="/script.js" type="text/javascript"></script>
</body>
<?php endif; ?>