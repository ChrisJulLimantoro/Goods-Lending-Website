<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['admin']) == false){
        session_destroy();
        sleep(2);
        header("Location: login.php");
    }else{
        $sql = 'SELECT profile FROM `user` WHERE `username` = :user';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user' => $_SESSION['user']]);
        $row = $stmt->fetchcolumn();
        $_SESSION['profile'] = $row;
    }
    ?>