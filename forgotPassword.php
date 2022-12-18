<?php
    include "connection.php";
?>
<?php
    if(isset($_POST['usr']) && isset($_POST['pass']) && isset($_POST['email'])){
        $sql = "SELECT COUNT(*) FROM user WHERE username = :usr and email = :em";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":usr" => $_POST['usr'],
            ":em"  => $_POST['email']
        ));
        $res = $stmt->fetchColumn();
        echo $res;
        if($res == 1){
            $sql_up = "UPDATE user SET password = PASSWORD(:ps) WHERE username = :usr";
            $stmt_up = $conn->prepare($sql_up);
            $stmt_up->execute(array(
                ":ps" => $_POST['usr'],
                ":usr" => $_POST['usr']
            ));
        }
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *,::after,::before{
            box-sizing:border-box;
        }
        .box{
            padding: 45px;
            background-color:rgba(255,255,255,.95);
            box-shadow: 1px 0px 17px -5px rgba(0,0,0,0.75);
            border-radius:10px;
        }
        .header {
            position:relative;
            background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        }
        .waves {
            position:relative;
            width: 100%;
            height:20vh;
            margin-bottom:-7px; /*Fix for safari gap*/
            min-height:100px;
            max-height:150px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes move-forever {
            0% {
            transform: translate3d(-90px,0,0);
            }
            100% { 
                transform: translate3d(85px,0,0);
            }
        }
        .flex { /*Flexbox for containers*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* TITLE */
        .spinner {
        align-items: center;
        height: 50px;
        width: max-content;
        font-size: 48px;
        font-weight: 800;
        font-family: monospace;
        letter-spacing: 0.3em;
        color: #2B3467;
        filter: drop-shadow(0 0 10px);
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .spinner span {
        font-size: 32px;
        animation: loading6454 1.75s ease infinite;
        }

        .spinner:hover{
            color: #82C3EC;
        }

        .spinner span:nth-child(2) {
        animation-delay: 0.25s;
        }

        .spinner span:nth-child(3) {
        animation-delay: 0.5s;
        }

        .spinner span:nth-child(4) {
        animation-delay: 0.75s;
        }

        .spinner span:nth-child(5) {
        animation-delay: 1s;
        }

        .spinner span:nth-child(6) {
        animation-delay: 1.25s;
        }

        .spinner span:nth-child(7) {
        animation-delay: 1.5s;
        }

        @keyframes loading6454 {
        0%, 100% {
        transform: translateY(0);
        }

        50% {
        transform: translateY(-10px);
        }
        }

        /* new button */
        button {
            font-family: inherit;
            font-size: 20px;
            background: royalblue;
            color: white;
            padding: 0.7em 1em;
            padding-left: 0.9em;
            display: flex;
            align-items: center;
            height: 2em;
            width: 7em;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.2s;
            }

        button span {
        display: block;
        margin-left: 0.7em;
        transition: all 0.3s ease-in-out;
        }

        button svg {
        display: block;
        transform-origin: center center;
        transition: transform 0.3s ease-in-out;
        }

        button:hover .svg-wrapper {
        animation: fly-1 0.6s ease-in-out infinite alternate;
        }

        button:hover svg {
        transform: translateX(1.2em) rotate(45deg) scale(1.1);
        }

        button:hover span {
        transform: translateX(5em);
        }

        button:active {
        transform: scale(0.95);
        }

        @keyframes fly-1 {
        from {
            
            transform: translateY(0.1em);
        }

        to {
            margin-left: 1em;
            transform: translateY(-0.1em);
        }
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
        /* background */

        .waves {
            position:relative;
            width: 100%;
            height:20vh;
            margin-bottom:-7px; /*Fix for safari gap*/
            min-height:100px;
            max-height:150px;
        }
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes move-forever {
            0% {
            transform: translate3d(-90px,0,0);
            }
            100% { 
                transform: translate3d(85px,0,0);
            }
        }
        .flex { /*Flexbox for containers*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    </style>
    <script>
        $(document).ready(function(){
            let passStatus = false;
            let reStatus = false;
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
                if (passStatus == true && reStatus == true){
                    $("#btn-check").removeAttr("disabled");
                }else{
                    $("#btn-check").attr("disabled","true");
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
                if (passStatus == true && reStatus == true){
                    $("#btn-check").removeAttr("disabled");
                }else{
                    $("#btn-check").attr("disabled","true");
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
            $("#btn-check").on("click",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                });
                $.ajax({
                    type : "post",
                    data : {
                        usr  : $("#inputUsername").val(),
                        email: $("#inputEmail").val(),
                        pass : $("#inputPass").val() 
                    },
                    success:function(e){
                        if(e == 1){
                            swalWithBootstrapButtons.fire({
                                    icon : "success",
                                    title : "Success!",
                                    text : "New Password created"
                                }).then(function(){
                                    $(window).attr("location","login.php");
                            })
                        }else{
                            swalWithBootstrapButtons.fire({
                                    icon : "error",
                                    title : "Failed!",
                                    text : "Either your username or email wrong!"
                                }).then(function(){
                                location.reload(true);
                            })
                        }
                    }
                })
            })
        })
    </script>
</head>
<body>
    <div class="header pt-5">
    <!--Waves Container-->
    <div class="container-fluid d-flex align-items-center justify-content-center pt-3">
        <div class="row" style="width: 100%">
            <div class="col-lg-4 col-md-3 col-sm-2 col-1"></div>
            <div class="col-lg-4 col-md-6 col-sm-8 col-10 box text-center">
            <div class="spinner">
                <span>F</span>
                <span>O</span>
                <span>R</span>
                <span>G</span>
                <span>O</span>
                <span>T</span>
            </div>
            <div class="spinner">
                
                <span>P</span>
                <span>A</span>
                <span>S</span>
                <span>S</span>
                <span>W</span>
                <span>O</span>
                <span>R</span>
                <span>D</span>
            </div>
                <form action="" method="post">
                    <div class="mb-3">
                        <br>
                        <div class="container-fluid position-relative p-0">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" class="form-control text-center" id="inputUsername" aria-describedby="userHelp" name="inputUsername" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="container-fluid position-relative p-0">
                            <label for="inputEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control text-center" id="inputEmail" aria-describedby="userHelp" name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="container-fluid position-relative p-0">
                            <label for="inputPass" class="form-label">New Password</label>
                            <input type="password" class="form-control text-center" id="inputPass" aria-describedby="passHelp" name="pass" placeholder="Your New Password" required>
                            <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="inputPassHelp" class="form-text">must be 8-20 characters</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="container-fluid position-relative p-0">
                            <label for="rePass" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control text-center" id="rePass" aria-describedby="passHelp" name="pass" placeholder="Confirm.." disabled>
                            <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                        </div>
                        <div id="rePassHelp" class="form-text"></div>
                    </div>
                    <div class="row mb-3 text-center">
                        <div class="col-lg-4 col-md-3 col-2 p-0 mx-0"></div>
                        <div class="col-5 p-0 mx-0">
                            <button type="button" id="btn-check" disabled>
                                <div class="svg-wrapper-1">
                                    <div class="svg-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                                    </svg>
                                    </div>
                                </div>
                                <span>Change</span>
                            </button>
                        </div>
                        <div class="col-3 p-0 mx-0"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div>
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
        <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
        </svg>
    </div>
    <!--Waves end-->

    </div>
    
</body>
</html>