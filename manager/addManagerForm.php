<?
    /*
        Этот файл отображает форму для добавления менеджером нового менеджера в базу + обработка этой формы
    */
    if ($_SESSION['user'] != 'admin')
        header("Location: ../index.php");

    $user = 'root';
    $string = '1234';
    $salt = '';
    $iterationCount = 50;
    $email = $user."@booksmarket.com";
    $result = '';
    
    if (!$salt)
        $salt = 'TGH78J3B5ED942568BGHFDDJ78541';
    
    if ($_SERVER['REQUEST_METHOD']=='POST'){
    	$user = $_POST['user'] ? $_POST['user'] : $user;
    	if(!userExists($user)){
            $email = $_POST['email'] ? $_POST['email']: $email;
    		$string = $_POST['string'] ? $_POST['string']: $string;
    		$salt = $_POST['salt'] ? $_POST['salt']: $salt;
    		$iterationCount = (int) $_POST['n'] ? (int) $_POST['n']: $iterationCount;
    		$result = getHash($string, $salt, $iterationCount);
    		if(addUser($user, $result, $email, $salt, $iterationCount))
    			$result = 'Хеш '. $result. ' успешно добавлен в файл';
    		else
    			$result = 'При записи хеша '. $result. ' произошла ошибка';
    	}else{
    		$result = "Пользователь $user уже существует. Выберите другое имя.";
    	}
        header("Location: ".$_SERVER['REQUEST_URI']);
    }
?>
<h3><?= $result?></h3>
<form action="<?= $_SERVER['REQUEST_URI']?>" method="post">
	<div>
		<label for="txtUser">Логин</label>
		<input id="txtUser" type="text" name="user" value="<?= $user?>" style="width:40em"/>
	</div>
	<div>
		<label for="txtString">Пароль</label>
		<input id="txtString" type="text" name="string" value="<?= $string?>" style="width:40em"/>
	</div>
    <div>
		<label for="txtEmail">Email</label>
		<input id="txtEmail" type="text" name="string" value="<?= $email?>" style="width:40em"/>
	</div>
	<div>
		<label for="txtSalt">Соль</label>
		<input id="txtSalt" type="text" name="salt" value="<?= $salt?>"  style="width:40em"/>
	</div>	
	<div>
		<label for="txtIterationCount">Число иттераций</label>
		<input id="txtIterationCount" type="text" name="n" value="<?= $iterationCount?>"  style="width:4em"/>
	</div>		
	<div>
		<button type="submit">Создать</button>
	</div>	
</form>