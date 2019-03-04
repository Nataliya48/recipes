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
     * Получение символьного кода открываемого файла (с формы)
     *
     * @param $name символьный код файла
     * @return mixed
     */
    public function selectFile($name)
    {
        $this->name = $name;
    }

    /**
     * Получает информацию из файла название.csv
     *
     * @return bool|string
     */
    protected function getRecipes()
    {
        return trim(file_get_contents($this->path . '/' . $this->name . '.csv'));
    }

    /**
     * Формирование массива для печати
     *
     * @return array
     */
    public function formationArrayForReading()
    {
        $content = explode(PHP_EOL, $this->getRecipes());
        $content[1] = explode(",", $content[1]);
        return $content;
    }

    /**
     * Запись нового рецепта с формы в файл
     *
     * @param $name название
     * @param $ingredients ингредиенты
     * @param $description описание
     * @return bool|int
     */
    public function putRecipes($name, $ingredients, $description, $fileName)
    {
        if (!empty($name) && !empty($ingredients) && !empty($description)) {
            file_put_contents($this->path . '/' . $fileName . '.csv', $this->formationArrayForWriting($name, $ingredients, $description));
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
    private function formationArrayForWriting($name, $ingredients, $description)
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
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];
        if (preg_match("/^[а-яА-ЯёЁ]+$/", $text)) {
            return str_replace($cyr, $lat, $text);
        } else {
            return str_replace($lat, $cyr, $text);
        }

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
     * Возвращает транслитированную строку
     *
     * @param $text строка, которую требуется транслитировать
     * @return mixed
     */
    public function normalizeFileName($names)
    {
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