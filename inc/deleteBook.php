<?php
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        include "../dao/LibraryDB.class.php";
        session_start();
        if ($_SESSION['user'] == 'admin'){
            $id = $_GET['id'];
            $library = new LibraryDB("../dao/db/");
            if (!$library->deleteBook($id))
                echo "Указанной книги нету";
        }
    }