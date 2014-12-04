<?php
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        include "lib.inc.php";
        session_start();
        if (empty($_SESSION['user']))
            echo "Для покупки книг Вам необходимо зарегистрироватся";
        else{
            $id = $_GET['id'];
            addToBasket($id);
        }
    }