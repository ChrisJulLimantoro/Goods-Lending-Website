<?php 
    include "connection.php";
    session_start();
    if(isset($_SESSION['nama_brg']) && isset($_SESSION['filter'])){
        unset($_SESSION['nama_brg']);
        unset($_SESSION['filter']);
        header("Location: homeUser.php");
    }else{
        echo var_dump($_SESSION);
    }
?>