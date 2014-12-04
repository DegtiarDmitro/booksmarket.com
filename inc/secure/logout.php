<?php
    /*
        файл отвечает за отображение кнопки "Выйти" и ссылки на корзину пользователя
    */
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "POST" and $_POST['logout'] == "exit"){
            session_destroy();
            setcookie(session_name(), "");
            echo "http://booksmarket.com";
            exit;
    }
?>
    <form method="POST" action="inc/secure/logout.php">
        <label for="quit">Добро пожаловать <?=$_COOKIE['userName']?></label>
        <a href="index.php?page=basket">Корзина</a>
        <button id="quit" type="button" onclick="logOut()">Выйти</button>
    </form>