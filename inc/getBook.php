<?php
/*
** Скрипт возварщает информацию о книге по указанному id
**    id - параметр - идентификационный код книги
*/
include "../dao/LibraryDB.class.php";
// Передаем заголовки
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

// Читаем GET параметр
$id = (int) $_GET['id'];


// Открытие БД
$libraryDB = new LibraryDB("../dao/db/");

// Создание и выполнение запроса
$result = $libraryDB->getBooksById($id);
$item = $result[0];


// Формирование результата

$book= new Book($item['id'], 
                $item['title'],
                $item['author'],
                $item['image'],
                $item['pubyear'],
                $item['price'],
                $item['category'],
                $item['description']
                );
	
// Вывод результата
echo json_encode($book);

// Закрытие БД
unset($db);

// Класс книга
class Book
{
    public $id;
	public $author;
	public $title;
	public $image;
    public $pubyear;
    public $price;
    public $category;
    public $description;

	public function __construct($id='', $title='', $author='', $image='', $pubyear='', $price='', $category='', $desc='')
	{
	   $this->id = $id;
	   $this->title = $title;
	   $this->author = $author;
	   $this->image = $image;
       $this->price = $price;
       $this->pubyear = $pubyear;
       $this->category = $category;
       $this->description = $desc;
	}
}

?>