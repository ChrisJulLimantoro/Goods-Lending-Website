<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['user']) == false){
        session_destroy();
        sleep(2);
        header("Location: login.php");
    }else{
        $inactive = 1800; 
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive) {
            header("Location: logout.php");
        }
        $_SESSION['timeout']=time();
    }
?>