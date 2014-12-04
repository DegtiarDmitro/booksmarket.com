<?php
    $title = "Что будем редактировать?";
?>

<h1><?=$title?></h1>
<form>
    <label for="findByTitle">введите название книги</label>
    <input id="findByTitle" type="text" name="findByTitle" size="100"/><br />
    
    <label for="findByAuthor">(и/или) введите автора книги</label>
    <input id="findByAuthor" type="text" name="findByAuthor" size="50"/><br />
    
    <button type="button" onclick="findBook()">Найти</button>
</form>

<div id="divResult">
<?php
    include 'inc/showCatalog.php';
?>
</div>