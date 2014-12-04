<?php
    /*
        Этот файл определяет контент из какой страницы будет отображатся в левой части страницы
    */
    if ($regisration)
        exit;
    else if ($user == 'admin'){
        drawMenu($adminMenu, false);
    } else{
        switch($page){
            case 'book': 
            case 'series':
            case 'game':
            case 'audiobook':
            case 'specbook': drawMenu(getCategoriesMenu(), false); break;
            
            default: include "inc/getRandomBooks.php";
        }
    }
    
?>