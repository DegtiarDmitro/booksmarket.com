<?php
    $title = "Регистрация нового пользователя";
    if ($_SERVER['REQUEST_METHOD']=='POST'){
    	$user = $_POST['user'];
        if(!userExists($user)){
    	   $string = $_POST['password1'];
           $email = $_POST['email'];
           addUser($user, $string, $login);
           
           header("Refresh: 3; url=http://booksmarket.com");
           $title = "Вы зарегистрированы<br/>Теперь вы можете войти под своим логином";
//           exit;
    	}else{
    		$title = "Пользователь $user уже существует. Выберите другое имя.";
            header("Location: {$_SERVER['REQUEST_URI']}");
    	}
        
    }
?>
<p>
 <br /><br /><br /><br />
    <h1><?=$title?></h1>
        <form class="regForm" method="post" action="<?=$_SERVER['REQUEST_URI']?>">
      		
     			<label for="txtUser">Логин</label>
     			<input id="txtUser" type="text" name="user" size="20" /><br />
      		
     			<label for="txtString">Пароль</label>
     			<input id="txtString" type="text" name="password1" size="30"/><br />
                
                <label for="txtString">Введите пароль повторно</label>
     			<input id="txtString" type="text" name="password2" size="30"/><br />
                
                <label for="txtString">Email</label>
     			<input id="txtString" type="text" name="email" size="30"/><br />
      		
                
     			<button onclick="" >Зарегистрироватся</button>
      			
       	</form>
</p>