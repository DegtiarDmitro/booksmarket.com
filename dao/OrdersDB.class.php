<?php
//    require "dao/OrdersDB.interface.php";
    /*
        Класс реализующий интерфейс IOrdersDB
    */
    class OrdersDB /*implements IOrdersDB*/ {
        protected $db;
        const DB_NAME = "dao/db/orders.db";
        
        //конструктор
        function __construct(){
            if (file_exists(self::DB_NAME))
                $this->db = new SQLite3(self::DB_NAME);
            else{
                $this->db = new SQLite3(self::DB_NAME);
                $sql = "CREATE TABLE orders(
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        title TEXT,
                        author TEXT,
                        pubyear INTEGER,
                        price INTEGER,
                        quantity INTEGER,
                        orderid TEXT,
                        datetime INTEGER
                )";
                $this->db->exec($sql) or die($this->db->lastErrorMsg());
            }
        }
        
        //деструктор
        function __destruct(){
            unset($this->db);
        }
        
        //добавление заказа в базу
        function saveOrder($author, $title, $pubyear, $price, $quontity, $orderid, $datetime){
            $sql = "INSERT INTO orders(title, author, pubyear, price, quantity, orderid, datetime)
                    VALUES('$title', '$author', '$pubyear', '$price', '$quontity', '$orderid', '$datetime')";
            $this->db->exec($sql) or die($this->db->lastErrorMsg());
        }

        //получение данных о заказе по идентификационному номеру и временной метке заказа
    	function getOrders($orderid, $datetime){
           $sql = "SELECT author, title, pubyear, price, quantity, orderid, datetime
                    FROM orders WHERE orderid = '$orderid' AND datetime = $datetime";
           $result = $this->db->query($sql) or die($this->db->lastErrorMsg());
           if ($result){
                $allorders = array();
                while($order = $result->fetchArray(SQLITE3_ASSOC)){
                    $allorders[] = $order;
                }
                return $allorders;
           }
           return false;
    	}

        //удаление заказа из базы по идентификационному номеру и временной метке заказа
    	function deleteBook($orderid, $datetime){
    	   $sql = "DELETE FROM orders 
                   WHERE orderid = '$orderid' AND datetime = $datetime";
           $this->db->exec($sql) or die($this->db->lastErrorMsgs());
    	}
        
    }
?>