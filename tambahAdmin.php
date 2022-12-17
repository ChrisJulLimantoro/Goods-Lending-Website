<?php
    require "connection.php";
    include "admin_authen.php";
?>
<?php
    if(isset($_POST['admin'])){
        $sql = "SELECT COUNT(*) FROM `admin` WHERE `Username` = :username";
        $user = $_POST['admin'];
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ':username' => $user
        ));
        $row = $stmt->fetchcolumn();
        echo $row;
        exit;
    }
?>
<?php
    if(isset($_POST['usr']) && isset($_POST['pass'])){
        $sql_in = "INSERT INTO `admin` VALUES(:usr,PASSWORD(:pass),'profile/profileDefault.jpg')";
        $stmt_in = $conn->prepare($sql_in);
        $stmt_in->execute(array(
            ":usr" => $_POST['usr'],
            ":pass" => $_POST['pass']
        ));
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin</title>

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
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            background: url('assets/gedungQ2.jpg') fixed no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            transition: all .5s ease;
        }

        .nav-link{
            font-weight: bold;
        }

        .active{
            transition: all 0.5s ease;
        }
        .active:hover{
            background-color: #5179d6;
            transform: scale(1.2);
        }

        .hidden {
            display: none !important;
        }

        /* Main */
        .fa-angle-left {
            color: #fff;
            height: 30px;
            transition: all .3s ease;
        }

        .fa-angle-left:hover {
            transform: scale(1.15);
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
    <script>
        $(document).ready(function(){
            let passStatus = false;
            let reStatus = false;
            let userStatus = false;
            $("#inputUsername").on("change",function(){
                $("#inputUsername").removeClass("shaking");
                // console.log( $("#inputUsername").val());
                if($("#inputUsername").val().length != 0){
                $.ajax({
                    type: "post",
                    data: {
                        admin: $("#inputUsername").val(),
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
                        $("#submit").removeAttr("disabled");
                    }else{
                        $("#submit").attr("disabled","true");
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
                    $("#submit").removeAttr("disabled");
                }else{
                    $("#submit").attr("disabled","true");
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
                    $("#submit").removeAttr("disabled");
                }else{
                    $("#submit").attr("disabled","true");
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
                    $("#submit").removeAttr("disabled");
                }else{
                    $("#submit").attr("disabled","true");
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
            $("#submit").on('click',function(){
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
                        usr  : $('#inputUsername').val(),
                        pass : $('#inputPass').val()
                    },
                    success : function(e){
                        swalWithBootstrapButtons.fire ({
                            icon : "success",
                            title : "Success!",
                            text : "new admin has successfully added!"
                        }).then(function(){
                            location.reload(true);
                        })
                    }
                })
            })
        })
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3" style="backdrop-filter : blur(3px);">
        <div class="container-fluid justify-content-between">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="homeAdmin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tambahBarang.php">Tambah Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="terimaPeminjaman.php">Terima Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="history.php">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tambahAdmin.php">Tambah Admin</a>
                    </li>
                </ul>
            </div>
            <div style="width: 5em; display:!important inline, position:!important absolute" class="user">
                <div class="dropdown" style="list-style: none; width: 3em;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $_SESSION['profile'] ?>" alt="" style="width: 3em; height: 3em; border-radius: 50%">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-3" style="color: white;">
                        <h5 class="dropdown-item">Username: </h5>
                        <h5 class="dropdown-item"><?php echo $_SESSION['admin'] ?></h5>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="logout.php"><button class="btn btn-primary mx-2" >Log out</button></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main content -->
    <div class="container-fluid mt-lg-3 w-100 vh-100 d-flex align-items-center justify-content-center">
        <div class="row p-5 mb-5 rounded"  style="backdrop-filter:blur(20px)">
            <div class="col-1 pt-1">
                <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
            </div>
            <div class="col-10">
                <h2 class="text-center text-light mb-lg-5 mb-3">TAMBAH ADMIN</h2>
            </div>
            <div class="col-1"></div>
            <hr style="color: #fff">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12 mb-1">
                <label for="inputUsername" class="mb-1 text-light form-label">Username</label>
                <div class="container-fluid positive-relative p-0">
                    <input type="text" id="inputUsername" name="inputUsername" class="form-control px-3" placeholder="Enter a username" required>
                    <span id="statusUser" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                </div>
                <div id="userHelp" class="form-text"></div>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12 mb-1">
                <label for="inputPass" class="mb-1 text-light form-label">Password</label>
                <div class="container-fluid position-relative p-0">
                    <input type="password" id="inputPass" name="inputPass" class="form-control px-3" placeholder="Create a password" required>
                    <span id="statusPass" hidden="hidden"><img src="assets/check.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                </div>
                <div id="inputPassHelp" class="form-text text-danger mt-0"></div>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12 mb-4">
                <label for="rePass" class="mb-1 text-light form-label">Retype Password</label>
                <div class="container-fluid positive-relative p-0">
                    <input type="password" id="rePass" name="rePass" class="form-control px-3" placeholder="Retype your password" required disabled>
                    <span id="statusRe" hidden = "hidden"><img src="assets/wrong.png" width="24px" height="24px" style="position:absolute;top:5.4pt;right:10.2pt;"></span>
                </div>
                <div id="rePassHelp" class="form-text"></div>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 mb-3">
                <button type="button" class="btn btn-dark" id="submit" style="width:100%" disabled>Tambah</button>
            </div>
        </div>
    </div>

    <script>
        var nav= document.querySelector('nav');
        window.addEventListener('scroll', function(){
          if (window.pageYOffset > 50){
            nav.classList.add('bg-dark', 'shadow');
          }else{
            nav.classList.remove('bg-dark','shadow');
          }
        });
    </script>
</body>
</html>