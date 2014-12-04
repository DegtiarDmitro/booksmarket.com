<?php
    /*
        Этот файл определяет заголовки для загружаемых страниц
    */
    ob_start();   
    define("ORDERS_LOG", "orders.log");         //файл для хранения заказов
    
    include "/dao/OrdersDB.class.php";
    include "/dao/LibraryDB.class.php";
    include "/dao/UsersDB.class.php";
    session_start();
    
    $ordersDB = new OrdersDB;
    $libraryDB = new LibraryDB("dao/db/");
    $usersDB = new UsersDB("dao/db/");
    $basket = array();
    $bookamount = 0;
    basketInit();
        
    $title = "Добро пожаловать в наш магазин";
    
    if (!empty($_GET['registr']) and $_GET['registr'] == 'on')
        $regisration = true;                                    //если true - будет отображена страница регистрации
    
    if (isset($_SESSION['user']))
        $user = $_SESSION['user'];                              
        
    
    if (!empty($_GET['menuItem']))
        $menuItem = clearStr($_GET['menuItem']);
        
    if (!empty($_GET['bookid']))
        $bookId = clearStr($_GET['bookid']);
    
    if (!empty($_GET['page']))
        $page = strtolower(clearStr($_GET['page']));
    
    if (!empty($_GET['category']))
        $category = strtolower(clearInt($_GET['category']));
    
?>