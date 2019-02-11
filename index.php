<?php
include 'recipes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
        $recipes->selectFile($_POST['recipe']);
        $recipe = $recipes->formationArrayForReading();
    } catch (Exception $e) {
        $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
    }
}
include 'template.php';