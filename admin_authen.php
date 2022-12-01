<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['admin']) == false){
        session_destroy();
        sleep(2);
        header("Location: login.php");
    }
    ?>