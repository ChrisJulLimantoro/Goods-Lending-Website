<?php
    $conn = new PDO('mysql:host=localhost;port=3306;dbname=proyek-final','root','');
    if ($conn === false){
        echo "Failed to connect!";
    }
?>