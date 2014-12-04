<?php
    if ($_SESSION['user'] != 'admin')
        header("Location: ../index.php");
//    header("Content-Type: text/html; charset=utf-8");
//    session_start();
//    if ($_SESSION['user'] != 'admin')
//        header("Location: http://booksmarket.com/index.php");
//    include "addBookForm.php";
/*    require_once "../dao/LibraryDB.class.php";
    require_once "../dao/OrdersDB.class.php";
    require_once "../inc/lib.inc.php";
    
    require_once "inc/header.inc.php";
    require_once "../orders/lib_for_orders.php";
    require_once "../inc/headers.inc.php";
*/    
?>
<h1>Что-бы сделать админу?</h1>
<div>
    <?php
//        drawMenu($adminMenu, false);
    
    ?>
</div>
<div>
    Сдесь будет окно работы админа
    <?php
//        include "inc/routing.inc.php";
    ?>
</div>
