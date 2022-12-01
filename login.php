<?php
    include "connection.php";
    if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['acc'])){
        if($_POST['acc'] == 'user'){
            $sql = "SELECT count(*) as total FROM `user` WHERE `username` = :username and `password` = PASSWORD( :password )";
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(':username' => $user,
                                ':password' => $pass));
            $row = $stmt->fetch();
            if($row['total'] == 0){
                $sql2 = "SELECT count(*) AS total FROM `user` WHERE `username` = :username";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute([':username' => $user]);
                $row2 = $stmt2->fetch();
                if ($row2['total'] == 1){
                    echo "-1";
                }
                else{
                    echo "0";
                }
            }else{
                echo "1";
                session_start();
                $_SESSION['user'] = $user;
            }
            exit;
        }else{
            $sql3 = "SELECT count(*) as total FROM `admin` WHERE `username` = :username and `password` = PASSWORD( :password )";
            $admin = $_POST['user'];
            $pass = $_POST['pass'];
            $stmt3 = $conn->prepare($sql3);
            $stmt3->execute(array(':username' => $admin,
                                ':password' => $pass));
            $row3 = $stmt3->fetch();
            if($row3['total'] == 0){
                $sql4 = "SELECT count(*) AS total FROM `admin` WHERE `username` = :username";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->execute([':username' => $admin]);
                $row4 = $stmt4->fetch();
                if ($row4['total'] == 1){
                    echo "-1";
                }
                else{
                    echo "0";
                }
            }else{
                echo "2";
                session_start();
                $_SESSION['user'] = $admin;
            }
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <style>
        *,::after.::before{
            box-sizing:border-box;
        }
        .box{
            padding: 45px;
            box-shadow: 1px 0px 17px -5px rgba(0,0,0,0.75);
            border-radius:10px;
        }
        .shaking{
            animation : shake 0.3s;
        }

        @media screen and (max-width: 576px) {
            body {
                font-size: .75em;
            }
            #inputUsername, #inputPassword {
                font-size: 1em;
            }
            #signIn, #signUp {
                font-size: 1em;
            }
        }

        @keyframes shake {
            0% {
                transform : translate(1px,1px) rotate(0deg); 
            }
            10% {
                transform : translate(-1px,-2px) rotate(-1deg); 
            }
            20% {
                transform : translate(-3px,0px) rotate(1deg); 
            }
            30% {
                transform : translate(3px,2px) rotate(0deg); 
            }
            40% {
                transform : translate(1px,-1px) rotate(1deg); 
            }
            50% {
                transform : translate(-1px,2px) rotate(-1deg); 
            }
            60% {
                transform : translate(-3px,1px) rotate(0deg); 
            }
            70% {
                transform : translate(3px,1px) rotate(-1deg); 
            }
            80% {
                transform : translate(-1px,-1px) rotate(1deg); 
            }
            90% {
                transform : translate(1px,2px) rotate(0deg); 
            }
            100% {
                transform : translate(1px,-2px) rotate(-1deg); 
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function(){
            $("#signIn").on("click",function(){
                console.log($('input[name="acc"]:checked').val());
                $("#inputPassword").removeClass("shaking");
                $("#inputUsername").removeClass("shaking");
                $.ajax({
                        type : "post",
                        data : {
                            user : $("#inputUsername").val(),
                            pass : $("#inputPassword").val(),
                            acc  : $('input[name="acc"]:checked').val()
                        },
                        success : function(response){
                            if(response == 0){
                                $("#statusUser").removeAttr("hidden");
                                $("#statusUser img").attr("src","assets/wrong.png");
                                $("#userHelp").html("Username invalid!!");
                                $("#userHelp").removeClass("text-success");
                                $("#userHelp").addClass("text-danger");
                                $("#inputUsername").css("background-color","#FF9494");
                                $("#inputUsername").addClass("shaking");
                                $("#inputPassword").addClass("shaking");
                            }else{
                                $("#statusUser").removeAttr("hidden");
                                $("#statusUser img").attr("src","assets/check.png");
                                $("#userHelp").html("Username valid!!");
                                $("#userHelp").removeClass("text-danger");
                                $("#userHelp").addClass("text-success");
                                $("#inputUsername").css("background-color","#BCEAD5");
                                if(response == 1){
                                    $("#statusPass").removeAttr("hidden");
                                    $("#statusPass img").attr("src","assets/check.png");
                                    $("#passHelp").html("Password Correct!!");
                                    $("#passHelp").removeClass("text-danger");
                                    $("#passHelp").addClass("text-success");
                                    $("#inputPassword").css("background-color","#BCEAD5");
                                    setTimeout(() => {
                                        $(window).attr("location","homeUser.php");
                                    }, 1000);
                                }else if(response == 2){
                                    $("#statusPass").removeAttr("hidden");
                                    $("#statusPass img").attr("src","assets/check.png");
                                    $("#passHelp").html("Password Correct!!");
                                    $("#passHelp").removeClass("text-danger");
                                    $("#passHelp").addClass("text-success");
                                    $("#inputPassword").css("background-color","#BCEAD5");
                                    setTimeout(() => {
                                        $(window).attr("location","homeAdmin.php");
                                    }, 1000);
                                }else{
                                    $("#statusPass").removeAttr("hidden");
                                    $("#statusPass img").attr("src","assets/wrong.png");
                                    $("#passHelp").html("Password incorrect!!");
                                    $("#passHelp").removeClass("text-success");
                                    $("#passHelp").addClass("text-danger");
                                    $("#inputPassword").css("background-color","#FF9494");
                                    $("#inputPassword").addClass("shaking");
                                }
                            }
                        }});
                });
                $("#inputPassword").on("keyup",function(){
                    $("#inputPassword")
                })
            })
    </script>


</head>
<body>
    <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="row" style="width: 100%">
            <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
            <div class="col-lg-4 col-md-6 col-sm-8 col-10 box">
                <h1 class="text-center">JUDUL</h1>
                <h4 class="subtitle-login text-center" style="color:red; border-bottom:1px solid black;line-height:0.1em;"><span style="background-color:white; padding:0px 6px">Login</span></h4>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <br>
                        <label for="inputUserName" class="form-label">User Name:</label>
                        <div class="container-fluid position-relative p-0">
                            <input type="text" class="form-control text-center" id="inputUsername" aria-describedby="userHelp" name="user" placeholder="username">
                            <span id="statusUser" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="userHelp" class="form-text">We'll never share your username with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check col-6" style="float:left">
                            <input class="form-check-input" type="radio" name="acc" id="userAcc" value="user" checked>
                            <label class="form-check-label" for="userAcc">
                                User
                            </label>
                        </div>
                        <div class="form-check col-6" style="float:left;">
                            <input class="form-check-input" type="radio" name="acc" id="adminAcc" value="admin">
                            <label class="form-check-label" for="adminAcc">
                                Admin
                            </label>
                        </div>
                        <br>
                    </div>
                    <div class="mb-3">
                        <label for="inputUserName" class="form-label">Password:</label>
                        <div class="container-fluid position-relative p-0">
                            <input type="password" class="form-control text-center" id="inputPassword" aria-describedby="passHelp" name="pass" placeholder="password">
                            <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="passHelp" class="form-text">must be 8-20 characters</div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="button" class="btn btn-primary" id="signIn">Sign In</button>
                    </div>
                </form>
                <div>
                    <p class="text-center">You don't have an account? sign up first!</p>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" id="signUp"><a href="SignUp.php" style="text-decoration: none; color: white;">Sign Up!</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>