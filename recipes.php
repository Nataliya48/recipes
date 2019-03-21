<?php

class Recipes
{

    private $path;
    private $name;
    /**
     * @var array Recipe
     */
    public $recipes;

    /**
     * Recipes constructor.
     * @param $storagePath директория с файлом
     * @throws Exception если файл или директория не доступны для записи или чтения
     */
    public function __construct($storagePath)
    {
        $this->path = $storagePath;
        if (!is_writable($this->path) || !is_readable($this->path)) {
            throw new Exception('Directory unavailable for writing or reading: ' . $this->path);
        }
        if (!file_exists($this->path . '/data.json')) {
            file_put_contents($this->path . '/data.json', '');
            chmod($this->path . '/data.json', 0777);
        }
        $this->openJson();
    }

    /**
     * Открыть data.json
     *
     * @return mixed
     */
    private function openJson()
    {
        $json = json_decode(file_get_contents($this->path . '/data.json'));
        $mapper = new JsonMapper();
        $this->recipes = array_map(function ($value) use($mapper) {
            return $mapper->map($value, new Recipe());
        }, $json);
    }

    /**
     * Запись в файл нового рецепта
     */
    private function saveRecipe()
    {
        file_put_contents($this->path . '/data.json', json_encode($this->recipes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Проверка файлов в директории
     *
     * @return array
     */
    private function getFilesInPathDir()
    {
        return array_diff(scandir($this->path), ['..', '.']);
    }

    /**
     * Получение списка названий из data.json
     *
     * @return array
     */
    public function getListName(): array
    {
        foreach ($this->recipes as $value) {
            $array[] = $value->ru;
        }
        return $array;
    }

    /**
     * Получает информацию из файла data.json, по ключу, выбранному на форме index.php
     *
     * @param $name название выбранного файла
     * @return mixed
     */
    public function getRecipe($name)
    {
        foreach ($this->recipes as $value) {
            if ($value->ru === $name) {
                return $value;
            }
        }
    }

    /**
     * Запись нового рецепта с формы в файл
     *
     * @param $name название
     * @param $ingredients ингредиенты
     * @param $description описание
     * @return bool|int
     */
    public function putRecipes($name, $ingredients, $description)
    {
        $recipe = new Recipe();
        $recipe->ru = $name;
        $recipe->description = $description;
        $recipe->en = $this->translateName($name);
        $recipe->items = explode(',', $ingredients);
        $this->recipes[]=$recipe;
        $this->saveRecipe();
    }

    /**
     * Формирование массива с формы для записи
     *
     * @param $name название
     * @param $ingredients ингредиенты
     * @param $description описание
     * @return string
     */
    public function formationArrayForWriting($name, $ingredients, $description)
    {
        $array = ['ru' => $name, 'en' => $this->translateName($name), 'items' => explode(',', $ingredients), 'description' => $description];
        return implode(PHP_EOL, $array);
    }

    /**
     * Перевод названия с кириллицы на латиницу
     *
     * @param $text строка, которую требуется транслитировать
     * @return mixed
     */
    private function translateName($text)
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', ' '
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya', '_'
        ];
        return str_replace($cyr, $lat, $text);
    }

    /**
     * Записать в json файл новый рецепт
     *
     * @param $name название
     * @param $ingredients ингредиенты
     * @param $description описание
     */
    /*public function addInJson($name, $ingredients, $description)
    {
        $file = $this->openJson();
        $this->name = $this->translateName($name);
        $items = explode(',', $ingredients);
        $file[] = ['ru' => $name, 'en' => $this->name, 'items' => $items, 'description' => $description];
        file_put_contents($this->path . '/data.json', json_encode($file, JSON_PRETTY_PRINT));
    }*/

    /**
     * Возвращает транслитированную строку
     *
     * @param $text строка, которую требуется транслитировать
     * @return mixed
     */
    /*public function normalizeFileName($names)
    {
        //удалится за ненадобностью
        $result = [];
        foreach ($names as $name) {
            $result[] = $this->translateName($name);
        }
        return $result;
    }*/


    /**
     * Возвращает список названий файлов без расширения
     *
     * @return array
     */
    public function getFileNames(): array
    {
        $names = $this->getFilesInPathDir();
        $names = array_map(function ($name) {
            return pathinfo($name, PATHINFO_FILENAME);
        }, $names);
        return $names;
    }
}