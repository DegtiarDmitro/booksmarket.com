<?php
    /*
        Класс реализующий интерфейс IOrdersDB
    */
    class UsersDB /*implements IOrdersDB*/ {
        protected $db;
        const DB_NAME = "users.db";
        
        //конструктор
        function __construct($path){
            if (file_exists($path.self::DB_NAME))
                $this->db = new SQLite3($path.self::DB_NAME);
            else{
                $this->db = new SQLite3($path.self::DB_NAME);
                $sql = "CREATE TABLE users(
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        login TEXT,
                        hash TEXT,
                        salt TEXT,
                        iteration INTEGER,
                        role TEXT,
                        email TEXT
                )";
                $this->db->exec($sql) or die($this->db->lastErrorMsg());
            }
        }
        
        //деструктор
        function __destruct(){
            unset($this->db);
        }
        
        //добавление пользователя в базу
        function saveUser($login, $hash, $email, $salt, $iteration, $role){
            $sql = "INSERT INTO users(login, hash, salt, iteration, role, email)
                    VALUES('$login', '$hash', '$salt', '$iteration', '$role', '$email')";
            if ($this->db->exec($sql))
                return true;
            return false;
        }

        //получение данных о пользователе по указанному логину
    	function getUser($login){
           $sql = "SELECT login, hash, email, salt, iteration, role
                    FROM users WHERE login = '$login'";
          if ($result = $this->db->query($sql)){
                $user = $result->fetchArray(SQLITE3_ASSOC);
                return $user;
           }
           return false;
    	}

        //удаление пользователя из базы
    	function deleteUser($login, $password){
    	   $sql = "DELETE FROM users 
                   WHERE login = '$login' AND password = '$password'";
           $this->db->exec($sql) or die($this->db->lastErrorMsgs());
    	}
        
    }
?>