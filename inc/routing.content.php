<?php
    /*
        Этот файл определяет контент из какой страницы будет отображатся в областе основного контента
    */
    if ($regisration)
        exit;
    else if ($user == 'admin'){
        switch($menuItem){
            case 'add': include "manager/addBookForm.php"; break;
            case 'redact': include "manager/redactBooks.php"; break;
            case 'getorders': include "manager/allOrders.php"; break;
            case 'managers': include "manager/addManagerForm.php"; break;
            case 'users': ;
            case 'exit': ;
            default: echo "<h1>Здесь должна быть страничка со статистикой посещения сайта</h1>";
        }
    } else if($bookId)
        include 'inc/showBook.php';     
    else{
       switch($page){
            case 'book': include 'inc/showCatalog.php'; break;
            case 'series':
            case 'game':
            case 'audiobook': 
            case 'specbook': include 'inc/not-ready-page.php'; break;
            case 'stores': include 'inc/ourStores.php'; break;
            case 'shiping': include 'inc/ship.inc.php'; break;
            case 'basket': include "inc/basket.php"; break;
            case 'order': include "inc/orderblank.php"; break;
            
            default: include "index.inc.php";
        } 
    }   
?>