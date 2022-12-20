<?php
    include "connection.php";
    session_start();

    // kosongi cart waktu logout
    if(isset($_SESSION['bucket'])){
        $sql_up = "UPDATE `item` SET `Status` = 1 WHERE `Id` = ANY (SELECT `id_item` FROM `borrow_detail` WHERE id_borrow = :bor)";
        $stmt_up = $conn->prepare($sql_up);
        $stmt_up->execute(array(
            ":bor" => $_SESSION['bucket']
        ));
        $sql_del = "DELETE FROM `borrow` WHERE `id_borrow` = :bor";
        $stmt_del = $conn->prepare($sql_del);
        $stmt_del->execute(array(
            ":bor" => $_SESSION['bucket']
        ));
    }
    session_destroy();
    sleep(2);
    header("Location: login.php");
    ?>