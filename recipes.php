<?php

/*Есть файл со списком рецептов, записанный в формате:

Название рецепта
* ингредиент
* ингредиент
* ингредиент
Сам рецепт

Выводить рецепты на экране в виде, приведенном в файле.

В дальнейшем добавить форму добавления рецепта.
*/

class Recipes
{

    private $path;
    private $name;

    /**
     * Получение символьного кода открываемого файла
     *
     * @param $name символьный код файла
     * @return mixed
     */
    public function selectFile($name)
    {
        $this->name = $name;
    }

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
     * Получает информацию из файла название.csv
     *
     * @return bool|string
     */
    protected function getRecipes()
    {
        return file_get_contents($this->path . '/' . $this->name .'.csv');
    }

    /**
     * Формирование массива для печати
     *
     * @return array
     */
    public function formationArrayForReading()
    {
        $content = explode(PHP_EOL, $this->getRecipes());
        unset($content[count($content) - 1]);
        $content[1] = explode(",", $content[1]);
        return $content;
    }

    /*public function putRecipes()
    {

    }

    public function formationArrayForWriting()
    {
        //сюда с формы приходит инфа о введенных данных
        $this->putRecipes();
    }*/
    
}