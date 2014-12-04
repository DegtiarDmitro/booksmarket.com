<?
    header('Content-type: text/html; charset=utf-8');
    header('Cache-Control: no-store, no-cache');
    
    require_once "inc/lib.inc.php";
    require_once "inc/headers.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<title>title</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="inc/style.css" />
        <script type="text/javascript" src="inc/lib.js"></script>
        <script type="text/javascript" src="inc/json2.js"></script>
	</head>
	<body>
    
        <!-- Верхняя часть страницы -->
		<div id="header">
			<img onclick="location.href='index.php'" src="inc/logo.jpg" width="80" height="55" alt="Наш логотип" class="logo"/>
            <?php
                if ($regisration){
                    include "inc/secure/registrationForm.php";
                }else   
                    include "inc/routing.top.php";
            ?>            
        </div>
        
        
        <!-- Верхнее меню -->
        <div id="topmenu">
            <?php
                if (!$regisration)
                    drawMenu($topmenu);
            ?>
        </div>
        
        
        <!-- Левый блок -->
        <div id="leftblock">
            <?php
                include "inc/routing.left.php";
            ?>             
        </div>
        
        
        <!-- Контент -->
		<div id="content">
			<h1><?=$header?></h1>
		    <?php
                include "inc/routing.content.php";
            ?>	
		</div>
        
        
        <!-- Нижняя часть страницы -->
		<div id="footer">
			&copy; Мега-книжный магазин <?= date('Y')?>
		</div>
	</body>
</html>