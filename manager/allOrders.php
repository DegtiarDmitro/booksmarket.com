<?php
    //файл отображает на сранице менеджера все поступившие заказы
    
    if ($_SESSION['user'] != 'admin')
        header("Location: ../index.php");
?>

<h1>Поступившие заказы:</h1>
<?php
    
    $orders = getOrders();
    if (is_array($orders)){
        foreach($orders as $order){
?>
<hr/>
<h2>Заказ номер: <?=$order['orderid']?></h2>
<p><b>Заказчик</b>: <?=$order['name']?></p>
<p><b>Email</b>: <?=$order['email']?></p>
<p><b>Телефон</b>: <?=$order['phone']?></p>
<p><b>Адрес доставки</b>: <?=$order['address']?></p>
<p><b>Дата размещения заказа</b>:<?=date("d-m-Y h:i", $order['datetime'])?></p>

<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
</tr>
<?php
    $number = 1;
    $sum = 0;
    foreach($order['goods'] as $goods){
?>
<tr>
    <td><?=$number?></td>
    <td><?=$goods['author']?></td>
    <td><?=$goods['title']?></td>
    <td><?=$goods['pubyear']?></td>
    <td><?=$goods['price']?></td>
    <td><?=$goods['quantity']?></td>
</tr>

<?php
        $number++;
        $sum += $goods['price'] * $goods['quantity'];
    }
?>

</table>
<p>Всего товаров в заказе на сумму: <?=$sum?>руб.</p>
<p align="right"><a href="">Удалить заказ</a></p>
<?php
    }
}
?>