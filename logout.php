<?php
    session_start();
    session_destroy();
    sleep(2);
    header("Location: login.php");
?>