<?php
    include "connection.php";
    session_start();
    // kalau yg mengakses bukan admin
    if(isset($_SESSION['admin']) == false){
        session_destroy();
        sleep(2);
        header("Location: login.php");
    }
    // kalau yg mengakses adlh admin
    else{
        $inactive = 1800; 
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive) {
            header("Location: logout.php");
        }
        $_SESSION['timeout']=time();
    }
?>