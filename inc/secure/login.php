<?php
    /*
        файл отвечает за отображение формы входа в систему и обработку этой формы
    */
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        header('Content-type: text/html; charset=utf-8');
        include "../../dao/UsersDB.class.php";
        include "../lib.inc.php";
        session_start();
        $usersDB = new UsersDB("../../dao/db/");
        
        if (!empty($_POST['login']) and !empty($_POST['password'])){
            $loginForm = trim(strip_tags($_POST['login']));
            $passwordForm = trim(strip_tags($_POST['password']));
                if ($user = userExists($loginForm)){
                    $passwordDB = $user['password'];
                    $roleDB = $user['role'];
                        if ($pw == $password){
                            $_SESSION['user'] = $roleDB;
                            setcookie("userName", $user['login'], 0x7FFFFFFF, "/");
                            echo "http://booksmarket.com";
                        } 
                }
        }
        exit;   
    }
?>
    <form class="slogan" method="post">
  		<div>
 			<label for="txtUser">Логин</label>
 			<input id="txtUser" type="text" name="user" value="гость" />
  		</div>
  		<div>
 			<label for="txtString">Пароль</label>
 			<input id="txtString" type="text" name="pw" />
  		</div>
  		<div>
            <a href="index.php?registr=on">Регистрация</a>
 			<button type="button" onclick="checkLog()" >Войти</button>
  		</div>	
    </form>