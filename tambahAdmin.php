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
        $sql_in = "INSERT INTO `admin` (Username, Password, profile) VALUES(:usr,PASSWORD(:pass),'profile/profileDefault.jpg')";
        $stmt_in = $conn->prepare($sql_in);
        $stmt_in->execute(array(
            ":usr" => $_POST['usr'],
            ":pass" => $_POST['pass']
        ));
        exit();
    }
    if(isset($_POST['ajax'])) {
        $sql = "SELECT * FROM `admin` ORDER BY status DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $row_count = 1;
        $arr = array();
        foreach($res as $hasil) {
            $temp = array();
            array_push($temp,$row_count);
            array_push($temp,$hasil['Username']);
            array_push($temp,$hasil['status']);
            array_push($arr,$temp);
            $row_count++;
        }
        echo json_encode($arr);
        exit();
    }
    if(isset($_POST['status']) && isset($_POST['username'])) {
        $currStat = $_POST['status'];
        $newStat = 0;
        if ($currStat == "1") {
            $newStat = 0;
        }
        else if ($currStat == "0") {
            $newStat = 1;
        }
        try {
            $sql = "UPDATE `admin` SET status = :status WHERE Username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ":status" => $newStat,
                ":username" => $_POST['username']
            ));
            echo 1;
            exit();
        }
        catch(Exception $e) {
            echo 0;
            exit();
        }
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
    <!-- DataTable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <?php include "navbarAdmin.php"; ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            background: url('assets/gedungQ2.jpg') fixed no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
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

        /* DataTable */
        div.dataTables_filter > label > input, .dataTables_length select, .dataTables_wrapper, .paginate_button {
            color: #fff;
        }

        div.dataTables_filter > label > input:focus, .dataTables_length select:focus {
            outline: 1px solid #fff;
        }

        div.dataTables_filter > label  {
            color: #fff;
            margin-bottom: 20px;
        }

        .dataTables_length select > option { 
            color: #000;
        }

        @media screen and (max-width: 576px) {
            #item-list th, #item-list td, #item-list button {
                font-size: .75em;
            }
        }
    </style>
    <script>
        $(document).ready(function(){
            $("#admin-list").DataTable({
                "language": {
                    "paginate": {
                        "next": "<span class='text-light'>Next</span>",
                        "previous": "<span class='text-light'>Previous</span>"
                    }
                },
                ajax : {
                    processing: true,
                    serverSide: true,
                    url : "tambahAdmin.php",
                    dataSrc : "",
                    type : "post",
                    data : {
                        ajax : 1
                    }
                },
                columns : [
                    {data : 0},
                    {data : 1},
                    {data : null,
                    "render" : function(data,type,row){
                        if(row[2] == 1){
                            return '<i class="text-success">Aktif</i>';
                        }else if(row[2] == 0){
                            return '<i class="text-danger">Tidak aktif</i>';
                        }
                        else {
                            return "";
                        }
                    }},
                    {data : null,
                    "render" : function(data,type,row){
                        if(row[2] == 1){
                            return '<button class="btn btn-danger" id="changeStats" value="1">Non-aktifkan</button>';
                        }else if(row[2] == 0){
                            return '<button class="btn btn-success" id="changeStats" value="0">Aktifkan</button>';
                        }
                        else {
                            return "";
                        }
                    }}
                ]
            });

            $(document.body).on("click", "#changeStats", function() {
                let status = $(this).val();
                let username = $(this).parent().parent().children().eq(1).text();
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                if (status == "1") {
                    swalWithBootstrapButtons.fire({
                        title : "Non aktifkan admin",
                        icon : "warning",
                        html : "Apakah anda yakin ingin menonaktifkan akun ini?",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                data : { 
                                    status : status,
                                    username : username 
                                },
                                success : function(e) {
                                    if (e == 1) {
                                        swalWithBootstrapButtons.fire ({
                                            icon : "success",
                                            title : "Berhasil!",
                                            text : "Akun berhasil dinonaktifkan!"
                                        })
                                    }
                                    else {
                                        swalWithBootstrapButtons.fire ({
                                            icon : "error",
                                            title : "Gagal!",
                                            text : "Akun gagal dinonaktifkan!"
                                        })
                                    }
                                    $("#admin-list").DataTable().ajax.reload(null,false);
                                }
                            })
                            
                        }
                    }))
                }
                else if (status == "0") {
                    swalWithBootstrapButtons.fire({
                        title : "Aktifkan admin",
                        icon : "warning",
                        html : "Apakah anda yakin ingin mengaktifkan kembali akun ini?",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                data : { 
                                    status : status,
                                    username : username 
                                },
                                success : function(e) {
                                    if (e == 1) {
                                        swalWithBootstrapButtons.fire ({
                                            icon : "success",
                                            title : "Berhasil!",
                                            text : "Akun berhasil diaktifkan!"
                                        })
                                    }
                                    else {
                                        swalWithBootstrapButtons.fire ({
                                            icon : "error",
                                            title : "Gagal!",
                                            text : "Akun gagal diaktifkan!"
                                        })
                                    }
                                    $("#admin-list").DataTable().ajax.reload(null,false);
                                }
                            })
                            
                        }
                    }))
                }
                
            })

            let passStatus = false;
            let reStatus = false;
            let userStatus = false;
            $("#inputUsername").on("change",function(){
                $("#inputUsername").removeClass("shaking");
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
    <!-- Main content -->
    <div class="container-fluid w-100 d-flex align-items-center justify-content-center"  style='margin-top: 100px;'>
        <div class="row py-5 p-lg-5 p-4 mb-5 rounded"  style="backdrop-filter:blur(20px)">
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

            <div class="col-lg-2 mb-5"></div>
            <div class="col-lg-8 mb-5">
                <button type="button" class="btn btn-dark" id="submit" style="width:100%" disabled>Tambah</button>
            </div>
            <div class="col-lg-2 mb-5"></div>

            <div class="col-1 pt-1 mt-5"></div>
            <div class="col-10 mt-5">
                <h2 class="text-center text-light mb-lg-5 mb-3">LIST ADMIN</h2>
            </div>
            <div class="col-1 mt-5"></div>
            <hr style="color: #fff">
            <table class="table table-dark table-striped table-bordered text-center align-middle" id="admin-list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class='table-light'>

                </tbody>
            </table>
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