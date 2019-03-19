<?php
include 'recipes.php';
try {

    $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
    $listNames = $recipes->getListName();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish = $recipes->getRecipe($_POST['recipe']);
        var_dump($dish);
        foreach ($dish as $d){
            var_dump($dish[$d]);
            foreach ($d['items'] as $key){
                var_dump($key);
            }
        }
        $recipe = $recipes->formationArrayForReading();
        //$recipes->putRecipes($_POST['name'], $_POST['ingredients'], $_POST['description'], $recipes->convertFileName($_POST['name']));
    }
} catch (Exception $e) {
    $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
}
include 'template.php';