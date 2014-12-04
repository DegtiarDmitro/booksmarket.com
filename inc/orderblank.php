<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = clearStr($_POST['inpName']);
        $email = clearStr($_POST['inpEmail']);
        $phone = clearStr($_POST['inpPhone']);
        $addr = clearStr($_POST['inpAddr']);
        $orderid = $basket['orderid'];
        $datetime = time();
        $str = $name."|".$email."|".$phone."|".$addr."|".$orderid."|".$datetime."\n";
        if (!file_put_contents("manager/.".ORDERS_LOG, $str, FILE_APPEND))
            echo "Ошибка при записи файла!!";
        saveOrder($datetime);


        header("Refresh: 3; url = http://booksmarket.com/index.php");
?>
    <h3>Спасибо за Ваш заказ</h3>
    <p>В ближайшее время с вами свяжется на почтальон</p>
<?php
    } else{
?>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
    <label for="inpName">Как к Вам обращатсь?</label>
    <input id="inpName" type="text" name="inpName"/><br />
    <label for="inpEmail">Ваш email</label>
    <input id="inpEmail" type="text" name="inpEmail" size="50"/><br />
    <label for="inpPhone">Ваш номер телефона</label>
    <input id="inpPhone" type="text" name="inpPhone" size="50"/><br />
    <label for="inpAddr">Аддрес доставки?</label>
    <input id="inpAddr" type="text" name="inpAddr" size="100"/><br />
    <input type="submit" value="Я все правильно заполнил"/>
</form>
<?php
}
?>