<?php
    /*
        Этот файл отображает каталог книг которые находятся в базе. (По категориям или все сразу)
    */
    $books;
    if (isset($category))
        $books = $libraryDB->getBooksByCategory($category);
    else
        $books = $libraryDB->getBooks();
    
    if (!$books)
        echo "Данный товар отсутствует";
    else{
        if ($_SESSION['user'] == 'admin'){
            $action1 = "Редактировать";
            $action2 = "Удалить";
            $function1 = "javascript:redactBook";
            $function2 = "deleteBook";
        } else{
            $action1 = "Подробнее";
            $action2 = "В корзину";
            $function1 = "{$_SERVER['REQUEST_URI']}&bookid=$id";
            $function2 = "addToBasket";
        }
        foreach($books as $book){
            $id = $book['id'];
            $author = $book['author'];
            $title = $book['title'];
            $pubyear = $book['pubyear'];
            $price = $book['price'];
            $image = $book['image'];
            $category = $book['category'];
            $description = nl2br($book['description']);
            $page = $_GET['page'];
            echo <<<BOOKS
            <div>
                <h2>$title</h2>
                Категория: $category<br>            
                <img src="$image" height="100" width="100" align="left"/>
                Автор: $author<br>
                Год издания: $pubyear<br>
                Цена: $price какао-бобов<br>
                Описание: $description<br>
                <span ><a href="$function1($id)">$action1</a></span>
                <span align="right"><a href="javascript:$function2($id)">$action2</a></span>
            </div>
            <hr>
BOOKS;
        }
    }
?>
