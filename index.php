<?php
include 'recipes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
        $name = $recipes->getNameFile();
        var_dump($name);
        $recipes->selectFile($_POST['recipe']);
        $recipe = $recipes->formationArrayForReading();
        //var_dump($_POST);
        $recipes->putRecipes($_POST['name'], $_POST['ingredients'], $_POST['description'], $recipes->convertFileName($_POST['name']));
    } catch (Exception $e) {
        $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
    }
}
include 'template.php';