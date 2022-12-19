<?php
    include "connection.php";
    if(isset($_POST['user'])){
        $sql = "SELECT COUNT(*) FROM `user` WHERE `username` = :username";
        $user = $_REQUEST['user'];
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $user]);
        $row = $stmt->fetchColumn();
        echo $row;
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        function read_file(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();

                reader.onload = function(e){
                    $("#profile").attr("src",e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function(){
            let passStatus = false;
            let reStatus = false;
            let userStatus = false;
            $("#defaultProfile").on("click",function(e){
                e.preventDefault();
                $("#profile").attr("src","profile/profileDefault.jpg");
                $("#submitFile").val("");
            })

            $("#submitFile").on("change",function(){
                read_file(this);
            })

            $("#profile").on("click",function(){
                $("#submitFile").click();
            })

            $("#inputUsername").on("change",function(){
                $("#inputUsername").removeClass("shaking");
                if($("#inputUsername").val().length != 0){
                $.ajax({
                    type: "post",
                    data: {
                        user: $("#inputUsername").val(),
                    },
                    success: function(response){
                        $("#statusUser").removeAttr("hidden");
                        if(response == 0){
                            $("#inputUsername").css("background-color","#BCEAD5");
                            $("#statusUser img").attr("src","assets/check.png");
                            $("#userHelp").html("Username Valid");
                            $("#userHelp").removeClass("text-danger");
                            $("#userHelp").addClass("text-success");
                            userStatus = true;
                        }else{
                            $("#inputUsername").css("background-color","#FF9494");
                            $("#statusUser img").attr("src","assets/wrong.png");
                            $("#userHelp").html("Username has already taken! choose another one!!");
                            $("#userHelp").removeClass("text-success");
                            $("#userHelp").addClass("text-danger");
                            $("#inputUsername").addClass("shaking");
                            userStatus = false;
                        }
                    }
                });
                if (passStatus == true && reStatus == true && userStatus == true){
                        $("#signUp").removeAttr("disabled");
                    }else{
                        $("#signUp").attr("disabled","true");
                    }
                }
            });

            $("#inputUsername").on("keyup",function(){
                if($("#inputUsername").val().length == 0){
                    $("#userHelp").html("");
                    $("#inputUsername").css("background-color","#FFFFFF");
                    $("#statusUser").attr("hidden","hidden");
                    userStatus = false;
                }
                if (passStatus == true && reStatus == true && userStatus == true){
                    $("#signUp").removeAttr("disabled");
                }else{
                    $("#signUp").attr("disabled","true");
                }
            });

            $("#inputPass").on("keyup",function(){
                let pass = $("#inputPass").val();
                $("#statusPass").removeAttr("hidden");
                $("#inputPass").removeClass("shaking");
                if(pass.length == 0){
                    $("#inputPassHelp").html("");
                    $("#statusPass").attr("hidden","hidden");
                    $("#inputPass").css("background-color","#FFFFFF");
                    $("#rePass").attr("disabled","true");
                    $("#rePass").attr("placeholder","Input a valid password first!!");
                    passStatus = false;
                }
                else if(pass.length >= 8 && pass.length <= 20){
                    let i = 0;
                    let cek = true;
                    if(pass.match(/[A-Z]/) && pass.match(/\d/) && pass.match(/[a-z]/) && (pass.match(/#/)||pass.match(/@/)||pass.match(/_/))){
                        $("#statusPass img").attr("src","assets/check.png");
                        $("#inputPassHelp").html("Password is Secured");
                        $("#inputPassHelp").removeClass("text-danger");
                        $("#inputPassHelp").removeClass("text-warning");
                        $("#inputPassHelp").addClass("text-success");
                        $("#inputPass").css("background-color","#BCEAD5");
                    }else{
                        $("#statusPass img").attr("src","assets/warning.png");
                        $("#inputPassHelp").html("Password is not secured! try to use atleast 1 uppercase letter, 1 lowercase letter, and 1 of these symbols ('#','@','_')");
                        $("#inputPassHelp").removeClass("text-danger");
                        $("#inputPassHelp").removeClass("text-success");
                        $("#inputPassHelp").addClass("text-warning");
                        $("#inputPass").css("background-color","#FFFAD7");
                    }
                    passStatus = true;
                    $("#rePass").removeAttr("disabled");
                    $("#rePass").attr("placeholder","Retype your password...");
                }
                else{
                    $("#statusPass img").attr("src","assets/wrong.png");
                    $("#inputPassHelp").html("Password must be 8-20 length!");
                    $("#inputPassHelp").removeClass("text-success");
                    $("#inputPassHelp").removeClass("text-danger");
                    $("#inputPassHelp").addClass("text-danger");
                    $("#inputPass").css("background-color","#FF9494");
                    passStatus = false;
                    $("#rePass").attr("disabled","true");
                    $("#rePass").attr("placeholder","Input a valid password first!!");
                }
                if (passStatus == true && reStatus == true && userStatus == true){
                    $("#signUp").removeAttr("disabled");
                }else{
                    $("#signUp").attr("disabled","true");
                }
            });

            $("#inputPass").on("change",function(){
                if (passStatus == false && $("#inputPass").val() != ''){
                    $("#inputPass").addClass("shaking");
                }
            });

            $("#rePass").on("change",function(){
                if (reStatus == false && $("#rePass").val() != ''){
                    $("#rePass").addClass("shaking");
                }
            });
            $("#rePass").on("keyup",function(){
                let rePass = $("#rePass").val();
                $("#statusRe").removeAttr("hidden");
                $("#rePass").removeClass("shaking");
                if($("#rePass").val().length == 0){
                    $("#rePassHelp").html("");
                    $("#statusRe").attr("hidden","hidden");
                    $("#rePass").css("background-color","#FFFFFF");
                }
                else{
                    if(passStatus == true){
                        if(rePass == $("#inputPass").val()){
                            $("#statusRe img").attr("src","assets/check.png");
                            $("#rePassHelp").html("Password is confirmed");
                            $("#rePassHelp").removeClass("text-danger");
                            $("#rePassHelp").addClass("text-success");
                            $("#rePass").css("background-color","#BCEAD5");
                            reStatus = true;
                        }else{
                            $("#statusRe img").attr("src","assets/wrong.png");
                            $("#rePassHelp").html("Retype password did not match!");
                            $("#rePassHelp").removeClass("text-success");
                            $("#rePassHelp").addClass("text-danger");
                            $("#rePass").css("background-color","#FF9494");
                            reStatus = false;
                        }
                    }
                }
                if (passStatus == true && reStatus == true && userStatus == true){
                    $("#signUp").removeAttr("disabled");
                }else{
                    $("#signUp").attr("disabled","true");
                }
            });
        });
    </script>
    <style>
        #profile{
            transition:all 0.5s ease-in-out;
        }
        #profile:hover{
            box-shadow: 0px 1px 25px -12px rgba(0,0,0,0.80);
        }
        #defaultProfile{
            background-color : white;
            border : 0px;
            border-radius:50%;
            padding : 0px;
            margin : 0px;
            right:45px;
            bottom:0px;
            transition:all 0.6s ease-in-out;
        }
        #defaultProfile:hover{
            transform : scale(1.15) rotate(90deg);
            box-shadow : 0px 1px 25px -12px rgba(0,0,0,0.80);
        }
        .shaking{
            animation : shake 0.3s;
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
</head>
<body>
    <div class="container position-relative">
        <div class="row">
            <div class="position-absolute top-0 start-50 translate-middle-x" style="width: 45em">
                <h1 class="text-center">JUDUL</h1>
                <h4 class="subtitle-login text-center" style="color:red; border-bottom:1px solid black;line-height:0.1em;"><span style="background-color:white; padding:0px 6px">Sign-Up</span></h4>
                <form action="insertUser.php" method="post" enctype="multipart/form-data" style="margin-top : 20px;">
                    <div class="row" style="height:auto;">
                        <div class="col-6 col-sm-4 position-relative">
                            <input type="file" class="form-control" accept=".jpg,.jpeg,.png,.svg" id="submitFile" name="submitFile" style="display:none;" value="C:\xampp\htdocs\TekWeb\Proyek\assets\profileDefault.jpg">
                            <img id="profile" src="profile/profileDefault.jpg" width="155px" height="155px" style="border-radius:50pt; margin-left:18%;cursor:pointer;">
                            <button class="btn btn-danger position-absolute" id="defaultProfile"><img src="assets/wrong.png" width="30px" height="30px"></button>
                        </div>
                        <div class="col-6 col-sm-8">
                            <div class="row">
                                <div class="col-12">
                                    <label for="inputFirstName" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" id="inputFirstName" placeholder="Your First Name..." name="inputFirstName" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <label for="inputLastName" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" id="inputLastName" placeholder="Your Last Name..." name="inputLastName" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6 col-12">
                        <label for="inputPhoneName" class="form-label">Phone Number:</label>
                        <input type="telp" class="form-control" id="inputPhoneNumber" placeholder="Your Phone Number..." name="inputPhoneNumber" required>
                        </div>
                        <div class="col-sm-6 col-12">
                        <label for="inputEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Your Email..." name="inputEmail" required>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="inputUserName" class="form-label">Username:</label>
                            <div class="container-fluid position-relative p-0">
                                <input type="text" class="form-control" id="inputUsername" placeholder="Your Username..." name="inputUsername" aria-describedby="userHelp" required>
                                <span id="statusUser" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                            </div>
                        <div id="userHelp" class="form-text"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="inputPass" class="form-label">Password:</label>
                            <div class="container-fluid position-relative p-0">
                                <input type="password" class="form-control" id="inputPass" placeholder="Input your password" name="inputPassword" aria-describedby="passHelp" required>
                                <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                            </div>
                            <div id="inputPassHelp" class="form-text text-danger"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                        <label for="rePass" class="form-label">Retype your Password:</label>
                        <div class="container-fluid position-relative p-0">
                            <input type="password" class="form-control" id="rePass" placeholder="Input a valid password first!!" name="rePassword" aria-describedby="passHelp" required disabled>
                            <span id="statusRe" hidden = "hidden"><img src="assets/wrong.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="rePassHelp" class="form-text"></div>
                        </div>
                    </div>
                    <div class= "row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" style="width: 100%" id="signUp" disabled>Sign Up!</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <h4 class="text-center">Already have an account?<a href="login.php" style="text-decoration: none; color: black;"><button type="button" class="btn btn-warning mt-3" style="width: 100%;">
                    Log in here!</button></a></h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>