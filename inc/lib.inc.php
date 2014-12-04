<?php

    //основное меню сайта
    $topmenu = array(
                array('link' => 'Главная', 'href' => 'index.php'),
                array('link' => 'Книги', 'href' => 'index.php?page=book'),
                array('link' => 'Серии', 'href' => 'index.php?page=series'),
                array('link' => 'Настольные игры', 'href' => 'index.php?page=game'),
                array('link' => 'Аудиокниги', 'href' => 'index.php?page=audiobook'),
                array('link' => 'Спецпредложения', 'href' => 'index.php?page=specbook'),
                array('link' => 'Наши магазины', 'href' => 'index.php?page=stores'),
                array('link' => 'Доставка и оплата', 'href' => 'index.php?page=shiping')
                );
    //меню по категориям
    $leftmenu = array(
                 array('link' => 'Компьютерная литература', 'href' => '&category=1'),
                 array('link' => 'Боевые исскуства', 'href' => '&category=2'),
                 array('link' => 'Для детей', 'href' => '&category=3'),
                 array('link' => 'Цветоводство', 'href' => '&category=4'),
                );
    //меню для менеджера
    $adminMenu = array(
                    array('link' => 'Добавить товар в базу', 'href' => 'index.php?menuItem=add'),
                    array('link' => 'Редактировать товар в базе', 'href' => 'index.php?menuItem=redact'),
                    array('link' => 'Просмотреть список заказов', 'href' => 'index.php?menuItem=getorders'),
                    array('link' => 'Добавить/удалить менеджера', 'href' => 'index.php?menuItem=managers'),
                    array('link' => 'Посмотреть список пользователей', 'href' => 'index.php?menuItem=users'),
                    array('link' => 'Выход', 'href' => 'javascript:logOut()'),
                    );
    
    /*
        группирует елементы массивов "...menu" в зависимости от выбранной страницы
    */
    function getCategoriesMenu(){
        global $leftmenu, $page;
        $newMenu = array();
        foreach($leftmenu as $menuItem){
            $menuLine = array();
            $menuLine['link'] = $menuItem['link'];
            $menuLine['href'] = $_SERVER['SCRIPT_NAME']."?page=$page".$menuItem['href'];
            $newMenu[] = $menuLine;
        }
        return $newMenu;
    }
    
    /*
        Функция отображает меню вертикально или горизонтально, в зависимости от второго параметра
    */
    function drawMenu($menu, $horizontal = true, $style = ''){
        if(!empty($menu)){
            if ($horizontal)
                $style = " style='display: inline;'";
            echo "<ul>";
            foreach($menu as $item){
                echo "<li$style>";
                echo "<a href='{$item['href']}'>{$item['link']}</a>";
                echo "</li>";
            }
            echo "</ul>";
        }      
    }
    
    /*
        Функция очищает текст переданный методами GET or POST
    */
    function clearStr($data){
        return strip_tags(trim($data));
    }
    
    /*
        Функция очищает числа переданный методами GET or POST
    */
    function clearInt($data){
        return abs((int)$data);
    }

    /*
        инициализация массива $basket - содержит уникальный идентификатор для каждого пользователя (первая ячейка массива)
        последующие элементы массива являют собой key - идентификационный номер книги из базыи,
        value - количество книг с указанным номером
        $count - общее количество книг в заказе
    */
    function basketInit(){
        global $basket, $bookamount;
        if (!isset($_COOKIE['basket'])){
            $basket = array('orderid' => uniqid());
            saveBasket($basket);
        } else{
            $basket = unserialize(base64_decode($_COOKIE['basket']));
            $bookamount = countBooksInBasket($basket);
        }
    }
    
    function deleteItemFromBasket($id){
        global $basket;
        if (key_exists($id, $basket)){
            unset($basket[$id]);
            saveBasket($basket);
            return true;
        } else
            return false;  
    }
    /*
        сохранение массива в cookie
    */
    function saveBasket($basket){
        $basket = base64_encode(serialize($basket));
        setcookie('basket', $basket, 0x7FFFFFFF, "/");
    }
    
    /*
        подсчет общего количества книг в корзине  
    */
    function countBooksInBasket($basket){
        if(is_array($basket)){
            array_shift($basket);
            $count = 0;
            foreach($basket as $item)
                $count += $item;
            return $count;
        } else
            return 0;
    }
    
    
    /*
        добавление книги в корзину
    */
    function addToBasket($id){
        $basket = unserialize(base64_decode($_COOKIE['basket']));
        if ($basket["$id"])
            $basket["$id"]++;
        else
            $basket["$id"] = 1;
        saveBasket($basket);
    }
    
    
    /*
        возврат содержимого корзины в виде ассоциативного массива
    */
    function myBasket(){
        global $basket, $library;
        $goods = array_keys($basket);
        array_shift($goods);
        $ids = implode(',', $goods);
        if (!$result = $library->getBooksById($ids))
            return false;
        $items = resultToArray($result);
        return $items;
        
    }
    
    /*
        преобразование результата выборки из базы в ассоциативный массив
    */
    function resultToArray($data){
        global $basket;
        $arr = array();
        foreach($data as $book){
            $book['quantity'] = $basket[$book['id']];
            $arr[] = $book;
        }
        return $arr;
    }
    
    
    /*
        
    */
    function saveOrder($datetime){
        global $basket, $ordersDB;
        $goods = myBasket();
//        $sql = "INSERT INTO orders (title, author, pubyear, price, quantity, orderid, datetime)
//                VALUES(:title, :author, :pubyear, :price, :quontity, :orderid, :datetime)";
        foreach($goods as $item){
            $ordersDB->saveOrder( $item['title'],
                                $item['author'],
                                $item['pubyear'],
                                $item['price'],
                                $item['quontity'],
                                $basket['orderid'],
                                $datetime);
        }
 //       setcookie("basket", "", time()-3600);
        return true;
    }
    
    /*
        
    */     
    function getOrders(){
//        echo "in getOrders";
        global $ordersDB;
//        print_r ($ordersDB);
        if (!is_file("manager/.".ORDERS_LOG))
            return false;
//        echo("Hello");
        $orders = file("manager/.".ORDERS_LOG);
        $allorders = array();
        foreach($orders as $order){
            list($name, $email, $phone, $address, $orderid, $datetime) = explode('|', $order);
            $orderinfo = array();
            $orderinfo['name'] = $name;
            $orderinfo['email'] = $email;
            $orderinfo['phone'] = $phone;
            $orderinfo['address'] = $address;
            $orderinfo['orderid'] = $orderid;
            $orderinfo['datetime'] = $datetime;
//            $sql = "SELECT title, author, pubyear, price, quantity 
 //                   FROM orders 
//                    WHERE orderid = '$orderid' AND datetime = $datetime";
            $result = $ordersDB->getOrders($orderid, $datetime);
//            if (!$result = $ordersDB->getOrders($orderid, $datetime))
//                return false;
//            $items = $result->fetchArray(SQLITE3_ASSOC);
            $orderinfo['goods'] = $result;
            $allorders[] = $orderinfo;
        }
//        print_r($allorders);
//        echo("Hello");
        return $allorders;
    }
    
     /*
        проверяет есть ли в базе пользователь с таким логином
    */
    function userExists($login){
        global $usersDB;
        if ($user = $usersDB->getUser($login))
            return $user;
        return false;
    }
    
//    function addUser($login, $password){
//        global $usersDB;
//        $usersDB->saveUser($login, $password);
//    }
    
    
    
    ///////////////////////////
    function getHash($string, $salt="", $iteration=10){
        for ($i = 0; $i < $iterationCount; ++$i)
            $string = sha1($string.$salt);
        return $string;
    }
    
    function addUser($login, $hash, $email, $salt="", $iteration=10, $role="user"){
        global $usersDB;
        if ($_SESSION['user'] == "admin")
            $role = "admin";
        if ($usersDB->saveUser($login, $hash, $email, $salt, $iteration, $role))
            return true;
        return false;
    }

?>