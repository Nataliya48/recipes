<?php
include 'recipes.php';
include 'recipe.php';
include 'vendor/autoload.php';
try {

    $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
    $listNames = $recipes->getListName();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish = $recipes->getRecipe($_POST['recipe']);
        $recipes->putRecipes($_POST['name'], $_POST['ingredients'], $_POST['description']);
    }
} catch (Exception $e) {
    $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
}
include 'template.php';