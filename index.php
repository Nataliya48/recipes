<?php
include 'recipes.php';
try {

    $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
    $names = $recipes->normalizeFileName($recipes->getFileNames());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recipes->selectFile($_POST['recipe']);
        $recipe = $recipes->formationArrayForReading();
        $recipes->putRecipes($_POST['name'], $_POST['ingredients'], $_POST['description'], $recipes->convertFileName($_POST['name']));
        //$recipes->getRecipes();
    }
} catch (Exception $e) {
    $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
}
include 'template.php';