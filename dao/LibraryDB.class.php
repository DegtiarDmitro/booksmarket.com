<?php
    /*
        Класс реализующий подключение к базе library.db и функционал для работы с ней
    */
    class LibraryDB /*implements ILibraryDB*/{
        protected $db;
        const DB_NAME = "library.db";
        
        //конструктор
        function __construct($path){
            if (is_file($path.self::DB_NAME)){
                $this->db = new SQLite3($path.self::DB_NAME);
            }
                
            else{
               $this->db = new SQLite3($path.self::DB_NAME);
                
               //Создание таблицы books
               $sql = "CREATE TABLE books(
                    	id INTEGER PRIMARY KEY AUTOINCREMENT,
                        author TEXT,
                    	title TEXT,
                        pubyear INTEGER,
                        price INTEGER,
                        image TEXT,
                    	category INTEGER,
                    	description TEXT
                    )";
               $this->db->exec($sql) or die($this->db->lastErrorMsg());
                
               //Создание таблицы category
               $sql = "CREATE TABLE category(
                    	id INTEGER,
                    	name TEXT
                   )";
               $this->db->exec($sql) or die($this->db->lastErrorMsg());
                
               //Вставка данных в таблицу category
               $sql = "INSERT INTO category(id, name)
                        SELECT 1 as id, 'Компьютерная литература' as name
                        UNION SELECT 2 as id, 'Боевые искусства' as name
                        UNION SELECT 3 as id, 'Для детей' as name
                        UNION SELECT 4 as id, 'Цветоводство' as name";
               $this->db->exec($sql) or die($this->db->lastErrorMsg());
            }
        }
        
        //деструктор
        function __destruct(){
            unset($this->db);
        }
        
        
        //Добавление новой книги в базу
        function saveBook($author, $title, $pubyear, $price, $image, $category, $description){
            $sql = "INSERT INTO books(author, title, pubyear, price, image, category, description)
                    VALUES('$author', '$title', '$pubyear', '$price', '$image', '$category', '$description')";
            $this->db->exec($sql) or die($this->db->lastErrorMsg());
            if ($this->db->lastErrorCode())
                return false;
            return true;
        }
        
        
        //возвращает все книги из таблицы
        function getBooks(){
            $sql = "SELECT books.id as id, author, title, pubyear, price, image, category.name as category, description
                    FROM books, category
                    WHERE books.category = category.id";
            $result = $this->db->query($sql);
            if ($result){
                $allBooks = array();
                while($book = $result->fetchArray(SQLITE3_ASSOC)){
                    $allBooks[] = $book;
                }
                return $allBooks;
            }
            return false;
        }
        
        //возврвщает книги по указанным id (для отображения книг находящихся в корзине)
        function getBooksById($id){
//            $sql = "SELECT id, author, title, pubyear, price, image
//                    FROM books WHERE id IN($id)";
            $sql = "SELECT books.id as id, author, title, pubyear, price, image, category.name as category, description
                    FROM books, category 
                    WHERE books.category = category.id AND books.id IN ($id)";
            $result = $this->db->query($sql);
            if ($result){
                $allBooks = array();
                while($book = $result->fetchArray(SQLITE3_ASSOC)){
                    $allBooks[] = $book;
                }
                return $allBooks;
            }
            return false;
        }
        
        
        //возвращает книги по указанной категории (при нажатии на соответствующий пункт меню)
        function getBooksByCategory($category){
            $sql = "SELECT books.id as id, author, title, pubyear, price, image, category.name as category, description
                    FROM books, category 
                    WHERE books.category = category.id AND books.category = '$category'";
            $result = $this->db->query($sql) or die($this->db->lastErrorMsg());
            if ($result){
                $allBooks = array();
                while($book = $result->fetchArray(SQLITE3_ASSOC)){
                    $allBooks[] = $book;
                }
                return $allBooks;
            }
            return false;
        }
        
        //возвращает ids книг которые присутствуют в базе
        function getBooksIds(){
            $sql = "SELECT id as
                    FROM books";
            if ($result = $this->db->query($sql)){
                $allIds = array();
                while($id = $result->fetchArray(SQLITE3_ASSOC)){
                    $allIds[] = $id;
                }
                return $allIds;
            }
            return false;
        }
        
        
        function deleteBook($id){
            $sql = "DELETE FROM books WHERE id = $id";
            $this->db->exec($sql);
            if ($this->db->lastErrorCode())
                return false;
            return true;
        }
        
    }
?>