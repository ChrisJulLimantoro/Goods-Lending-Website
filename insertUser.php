<?php
    include "connection.php";
    include "uploadProfile.php";
    if(isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && isset($_POST['inputPhoneNumber']) && isset($_POST['inputEmail']) && isset($_POST['inputUsername']) && isset($_POST['inputPassword'])){
            $sql = "INSERT INTO `user`(`username`,`password`,`first_name`,`last_name`,`phone_number`,`email`,`profile`)
                        VALUES (:username, PASSWORD(:password), UPPER(:fname), UPPER(:lname), :phone, :email, 'profile/profileDefault.jpg')";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':username' => $_POST['inputUsername'],
                ':password' => $_POST['inputPassword'],
                ":fname" => $_POST['inputFirstName'],
                ":lname" => $_POST['inputLastName'],
                ":phone" => $_POST['inputPhoneNumber'],
                ":email" => $_POST['inputEmail']
            ));
            if($_FILES['submitFile']['name'] != ''){
                $sql2 = "UPDATE `user` SET `profile` = :profile
                            WHERE `username` = :username";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute(array(
                    ':profile' => $target_file,
                    ':username' => $_POST['inputUsername']
                ));
            }
            header("location: login.php");
    }else{
        echo "fail";
    }
?>