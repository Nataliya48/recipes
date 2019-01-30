<?php
include 'recipes.php';
var_dump(['$_POST'=>$_POST['recipe']]);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $recipes = new Recipes("/home/nata/Рабочий стол/Recipes");
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipe = $recipes->formationArrayForReading();
            //$recipes->selectFile($_POST['recipe']);
        //}
    } catch (Exception $e) {
        $errorMsg = 'Выброшено исключение: ' . $e->getMessage() . "\n";
    }
}
include 'template.php';