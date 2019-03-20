<?php

class Recipes
{

    private $path;
    private $name;

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
    }

    /**
     * Открыть data.json
     *
     * @return mixed
     */
    private function openJson()
    {
        return json_decode(file_get_contents($this->path . '/data.json'));
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
        $file = $this->openJson();
        foreach ($file as $value){
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
        $file = $this->openJson();
        foreach ($file as $value){
            if ($value->ru === $name){
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
        //открыть файл и получить из него массив. кодировать из json. в конец массива добавить доп рецепт. кодировать json
        $file = $this->openJson();
        if (!empty($name) && !empty($ingredients) && !empty($description)) {
            $file[] = $this->formationArrayForWriting($name, $ingredients, $description);
            file_put_contents($this->path . '/data.json', $file);
        }
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
        $array = [$name, $ingredients, $description];
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

        /*
        if (preg_match('/^[а-яА-ЯёЁ\s]+$/', $text)) {
            return str_replace($cyr, $lat, $text);
        } else {
            return str_replace($lat, $cyr, $text);
        }*/

    }

    /**
     * Возвращает транслитированную строку
     *
     * @param $text строка, которую требуется транслитировать
     * @return mixed
     */
    public function convertFileName($text)
    {
        return $this->translateName($text);
    }

    /**
     * Записать в json файл новый рецепт
     *
     * @param $name название
     * @param $ingredients ингредиенты
     * @param $description описание
     */
    public function addInJson($name, $ingredients, $description)
    {
        $file = $this->openJson();
        $this->name = $this->translateName($name);
        $items = explode(',', $ingredients);
        $file[] = ['ru' => $name, 'en' => $this->name, 'items' => $items, 'description' => $description];
        file_put_contents($this->path . '/data.json', json_encode($file, JSON_PRETTY_PRINT));
    }

    /**
     * Возвращает транслитированную строку
     *
     * @param $text строка, которую требуется транслитировать
     * @return mixed
     */
    public function normalizeFileName($names)
    {
        //удалится за ненадобностью
        $result = [];
        foreach ($names as $name){
            $result[] = $this->translateName($name);
        }
        return $result;
    }


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