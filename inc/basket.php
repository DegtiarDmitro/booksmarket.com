<?php
    /*
        файл отвечает за отображение содержимого корзины пользователя
    */	
	if (isset($_GET['del'])){
	   $del = $_GET['del'];
       if (deleteItemFromBasket($del))
            header("Location: http://booksmarket.com/index.php?page=basket");   
	}
    if (!$bookamount)
        $header = "Ваша корзина пуста";
    else
        $header = "Ваша корзина:";
?>
<h1><?=$header?></h1>
<?php
    if ($bookamount){
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	$items = myBasket();
    $sum = 0;
    $i = 1;
    if (is_array($items))
        foreach($items as $item){   
 ?>
    <tr>
        <td><?=$i?></td>
        <td><?=$item['title']?></td>
        <td><?=$item['author']?></td>
        <td><?=$item['pubyear']?></td>
        <td><?=$item['price']?></td>
        <td><?=$item['quantity']?></td>
        <td><a href="<?=$_SERVER['REQUEST_URI']?>&del=<?=$item['id']?>">Удалить</a></td>
    </tr>
 <?php
    $i++;
    $sum += $item['quantity'] * $item['price'];
 }  
?>
</table>

<p>Всего товаров в корзине на сумму: <?=$sum?> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='<?=$_SERVER['PHP_SELF']?>?page=order'" />
</div>
<?php
    }
?>