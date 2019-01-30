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

    private $file;
    private $name;
    private $composition;
    private $description;

    /*
     * нужно получать с формы данные, какое поле было выбрано и в соответствии с этим открывать нужный файл
     * */

    /**
     * Получение символьного кода открываемого файла
     *
     * @param $name символьный код файла
     * @return mixed
     */
    public function selectFile($name)
    {
        $this->name = $name;
        var_dump([$this->name, $name]);
    }

    /**
     * Recipes constructor.
     * @param $storagePath директория с файлом
     * @throws Exception если файл или директория не доступны для записи или чтения
     */
    public function __construct($storagePath)
    {
        //$this->file = $storagePath . '/' . $this->name .'.csv'; //файл с рецептами
        $this->file = $storagePath . '/recipes.csv';
        /*if (!is_readable($storagePath) || !is_readable($this->file)) {
            chmod($storagePath, 0777);
            chmod($this->file, 0777);
        }*/
        if (!is_writable($storagePath) || !is_readable($storagePath)) {
            throw new Exception('Directory unavailable for writing or reading: ' . $storagePath);
        }
        /*if (!is_writable($this->file) || !is_readable($this->file)) {
            throw new Exception('File unavailable for writing or reading: ' . $storagePath);
        }*/
    }

    /**
     * Получает информацию из файла название.csv
     *
     * @return bool|string
     */
    protected function getRecipes()
    {
        return file_get_contents($this->file);
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