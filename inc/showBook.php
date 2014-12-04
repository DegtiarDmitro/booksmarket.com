<?php
    /*
        Этот файл отображает подробную информацию о книге вибранной пользователем
    */
    $item = $libraryDB->getBooksById($bookId);
    if (!$item)
        echo "Извините такой книги нету";
    else{
            $book = $item[0];
            $id = $book['id'];
            $author = $book['author'];
            $title = $book['title'];
            $pubyear = $book['pubyear'];
            $price = $book['price'];
            $image = $book['image'];
            $category = $book['category'];
            $description = nl2br($book['description']);
            $page = $_GET['page'];
            echo <<<BOOK
            <div id="selectedBook">
                <h2>$title</h2>
                Категория: $category<br>            
                <img src="$image" alt="$image" height="100" width="100" align="left"/>
                Автор: $author<br>
                Год издания: $pubyear<br>
                Цена: $price какао-бобов<br>
                Описание: $description<br>
                <span align="right"><a href="javascript:addToBasket($id)">В корзину</a></span>
            </div>
            <hr>
BOOK;
    }
?>