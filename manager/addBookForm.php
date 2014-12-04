<?php
    /*
        Этот файл отображает форму для добавления менеджером книги в базу + обработка этой формы
    */
    if ($_SESSION['user'] != 'admin')
        header("Location: ../index.php");
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $author = clearStr($_POST['author']);
        $title = clearStr($_POST['title']);
        $price = clearInt($_POST['price']);
        $pubyear = clearInt($_POST['year']);
        $category = clearStr($_POST['category']);
        $description = clearStr($_POST['description']);
        
        $tmp = $_FILES['user_file']['tmp_name'];
        $name = $_FILES['user_file']['name'];
        $image = 'dao/imgs/'.$name;
        move_uploaded_file($tmp, 'dao/imgs/'.$name);
        
        $libraryDB->saveBook($author, $title, $pubyear, $price, $image, $category, $description);
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }
?>

<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype='multipart/form-data'>
    Автор книги:
    <input type="text" name="author"/><br />
    
    Название книги:
    <input type="text" name="title"/><br />
    
    <div class="block">
			<label for="year"><span>Год издания</span></label>
			<div class="group">
				<a href="javascript:addYear(0);">+</a>
				<select name="year" id="year">
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
				</select>
				<a href="javascript:addYear(1);">+</a>
			</div>
		</div>
    
    <label for="price">Цена:</label>
    <input id="price" type="text" name="price"/><br />
    
    <label for="load">Загрузите изображение:</label><br />
    <input id="load" type='file' name='user_file'/><br />
    
    <p>
        <label for="categoryn">Выберите категорию товара</label>
        <select id="category" name="category">
            <option value="1">Компьютерная литература</option>
            <option value="2">Боевые искусства</option>
            <option value="3">Для детей</option>
            <option value="4">Цветоводство</option>
        </select><br />
    </p>
    
    <label for="description">Описание товара</label><br/>
    <textarea id="description" name="description" cols="50" rows="5"></textarea><br />
    
    <input type="submit" value="Добавить книгу"/>
</form>