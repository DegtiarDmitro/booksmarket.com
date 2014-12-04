<?php
    switch($user){
        case 'admin': $topmenu = null; break;
        case 'user': include "inc/secure/logout.php"; break;
        default: include "inc/secure/login.php";
    }
?>