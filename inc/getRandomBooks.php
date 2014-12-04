<?php
    /*
        файл отвечает за отображение случайных книг
    */ 
        if ($books = $libraryDB->getBooks()){           //запихиваем данные по всем книгам в массив $books
            $booksIds = array();
            foreach($books as $book)
                $booksIds[] = $book['id'];              //в массив $booksIds запихиваем значения всех id
            if (count($booksIds) > 3){                  //усли в базе больше 3-х книг то дальше выбираем 3 случайные
                $maxId = $booksIds[count($booksIds) - 1];
                $randId = array();
                for ($i = 0; $i < 3; ){
                    $number = rand(1, $maxId);
                    if ((array_search($number, $booksIds) !== false) && (array_search($number, $randId) === false)){
                        $randId[] = $number;
                        $i++;
                    }
                }
                $booksIds = $randId;
            }
                foreach($books as $book){
                    if (array_search($book['id'], $booksIds) !== false){
                    $id = $book['id'];
                    $author = $book['author'];
                    $title = $book['title'];
                    $pubyear = $book['pubyear'];
                    $image = $book['image'];
                    echo <<<BOOK
                    <div id="randBook">
                        <h4>$title</h4>                
                        <img src="$image" alt="$image" height="100" width="100" align="left"/>
                        Автор: $author<br>
                        Год издания: $pubyear<br>
                    </div>
                    <p align="right"><a href="{$_SERVER['SCRIPT_NAME']}?bookid=$id">Подробнее</a></p>
                    <hr>
BOOK;
                    }
                }
        }else
            echo "Произошла ошибка при выборке книг из базы";
?>