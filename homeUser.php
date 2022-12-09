<?php
    include "user_authen.php";
?>
<?php
    if(isset($_POST['nama']) && isset($_POST['filter'])){
        $_SESSION['nama_brg'] = $_POST['nama'];
        $_SESSION['filter'] = $_POST['filter'];
        exit();
    }
?>
<!-- ini php buat ngefilter by ajax -->
<?php
    if(isset($_POST['loc'])){
        $i = 1;
        if($_POST['loc'] == ''){
            $sql = 'SELECT DISTINCT Nama_Barang, Deskripsi, image,image2,image3,image4 FROM item WHERE status = 1 and Nama_Barang LIKE :filt';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':filt' => '%'.$_POST['filter_nama'].'%'
            ));
            $row = $stmt->fetchAll();
            if($row){
                foreach($row as $s){
                    $arr = array($s['image2'],$s['image3'],$s['image4']);
                    $sql2 = 'SELECT COUNT(*) FROM item WHERE status = 1 and Nama_Barang = :nama';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute(array(
                        ':nama' => $s['Nama_Barang']
                    ));
                    $row2 = $stmt2->fetchColumn();
                    echo '<div class="col mt-5 contCard">';
                    echo '<div class="card" style="width: 18rem; height: 28rem;">';
                    echo '<div class="text-center">';
                    echo '<div id="carouselExampleControlsNoTouching'.$i.'" class="carousel slide" data-bs-touch="false" data-bs-interval="false">';
                    echo '<div class="carousel-inner">';
                    echo '<div class="carousel-item active p-2"><img src="'.$s['image'].'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    foreach($arr as $a){
                        if($a != "assets/no-image.png"){
                            echo '<div class="carousel-item p-2"><img src="'.$a.'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                        }
                    }
                    echo '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button></div></div>';
                    echo '<div class="card-details">';
                    echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    echo '<p class="text-body" style="padding-left : 10px;">'.$s['Deskripsi'].'</p></div>';
                    echo '<button class="card-button">Pinjam!</button></div></div>';
                    $i += 1;
                }
            }
        }else{
            $sql = 'SELECT DISTINCT Nama_Barang, Deskripsi, image,image2,image3,image4 FROM item WHERE status = 1 and location = :loc and Nama_barang LIKE :filt';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':loc' => $_POST['loc'],
                ':filt' => '%'.$_POST['filter_nama'].'%'
            ));
            $row = $stmt->fetchAll();
            if($row){
                foreach($row as $s){
                    $arr = array($s['image2'],$s['image3'],$s['image4']);
                    $sql2 = 'SELECT COUNT(*) FROM item WHERE status = 1 and Nama_Barang = :nama and location = :loc';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute(array(
                        ':nama' => $s['Nama_Barang'],
                        ':loc' => $_POST['loc']
                    ));
                    $row2 = $stmt2->fetchColumn();
                    echo '<div class="col mt-5 contCard">';
                    echo '<div class="card" style="width: 18rem; height: 28rem;">';
                    echo '<div class="text-center">';
                    echo '<div id="carouselExampleControlsNoTouching'.$i.'" class="carousel slide" data-bs-touch="false" data-bs-interval="false">';
                    echo '<div class="carousel-inner">';
                    echo '<div class="carousel-item active p-2"><img src="'.$s['image'].'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    foreach($arr as $a){
                        echo $a;
                        if($a != "assets/no-image.png"){
                            echo '<div class="carousel-item p-2"><img src="'.$a.'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                        }
                    }
                    echo '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button></div></div>';
                    echo '<div class="card-details">';
                    echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    echo '<p class="text-body" style="padding-left : 10px;">'.$s['Deskripsi'].'</p></div>';
                    echo '<button class="card-button">Pinjam!</button></div></div>';
                    $i += 1;
                }
            }
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
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        $(document).ready(function(){
            AOS.init();
            var width = $(window).width();
                if (width<576){
                    $("#viewItem").addClass("mx-4");
                }
                if (width>=576){
                    $("#viewItem").removeClass("mx-4");
                }
                if (width >= 850){
                    $(".kiri").css("display", "inline");
                    $("#inputSearch").css("display","inline");
                    $("#judul").css("font-size","24px");
                    $("#searchButton").css("display","none");
                    $("#inputSearch").css("width", "75%");
                    $("#inputSearch").css("height", "2em");
                    $("#inputSearch").css("background-color","#fff");
                    $(".containerInput").css("margin-left","0em");
                    $(".keranjang").css("display", "inline");
                    $(".user").css("display", "inline");
                    $(".kanan").css("display", "inline");
                }
                if (width < 550 && width > 350){
                    $("#keranjang").css("width", "1.2em");
                    $("#keranjang").css("height", "1.2em");
                    $("#userImg").css("width", "1.5em");
                    $("#userImg").css("height", "1.5em");
                    $("#searchImg").css("width", "1.5em");
                    $("#searchImg").css("height", "1.5em");
                    $("#judul").css("font-size","12px");
                }
                if(width < 350){
                    $("#judul").css("font-size","6px");
                }
                if (width < 850 && width >= 551){
                    $("#keranjang").css("width", "2em");
                    $("#keranjang").css("height", "2em");
                    $("#userImg").css("width", "2em");
                    $("#userImg").css("height", "2em");
                    $("#searchImg").css("width", "2em");
                    $("#searchImg").css("height", "2em");
                    $("#judul").css("font-size","20px");
                }
                if(width < 750){
                    $("#searchButton").css("display","inline");
                    $(".kiri").css("display", "none");
                    $("#inputSearch").css("background-color","#212529");
                    $("#inputSearch").css("width","0.000001px");
                    $("#inputSearch").css("height","0.000001px");
                }
            $(window).resize(function() {
                var width = $(window).width();
                if (width<576){
                    
                    $("#viewItem").addClass("mx-4");
                }
                if (width>=576){
                    $("#viewItem").removeClass("mx-4");
                }
                if (width >= 850){
                    $(".kiri").css("display", "inline");
                    $("#inputSearch").css("display","inline");
                    $("#judul").css("font-size","24px");
                    $("#searchButton").css("display","none");
                    $("#inputSearch").css("width", "75%");
                    $("#inputSearch").css("height", "2em");
                    $("#inputSearch").css("background-color","#fff");
                    $(".containerInput").css("margin-left","0em");
                    $(".keranjang").css("display", "inline");
                    $(".user").css("display", "inline");
                    $(".kanan").css("display", "inline");
                }
                if (width < 550 && width > 350){
                    $("#keranjang").css("width", "1.5em");
                    $("#keranjang").css("height", "1.5em");
                    $("#userImg").css("width", "1.5em");
                    $("#userImg").css("height", "1.5em");
                    $("#searchImg").css("width", "1.5em");
                    $("#searchImg").css("height", "1.5em");
                    $("#judul").css("font-size","12px");
                }
                if(width < 350){
                    $("#judul").css("font-size","6px");
                }
                if (width < 850 && width >= 551){
                    $("#keranjang").css("width", "2em");
                    $("#keranjang").css("height", "2em");
                    $("#userImg").css("width", "2em");
                    $("#userImg").css("height", "2em");
                    $("#searchImg").css("width", "2em");
                    $("#searchImg").css("height", "2em");
                    $("#judul").css("font-size","20px");
                }
                if(width < 750){
                    $("#searchButton").css("display","inline");
                    $(".kiri").css("display", "none");
                    $("#inputSearch").css("background-color","#212529");
                    $("#inputSearch").css("width","0.000001px");
                    $("#inputSearch").css("height","0.000001px");
                }
            });

            $("#searchButton").click(function(){

                $("#inputSearch").css("background-color","#fff");
                $("#searchButton").css("display", "none");
                $("#inputSearch").css("width", "100%");
                $("#inputSearch").css("height", "2em");
                $(".keranjang").css("display", "none");
                $(".user").css("display", "none");
                $(".kanan").css("display", "none");
                $(".containerInput").css("margin-left", "4em");
                $("#inputSearch").val("")

            });

            $("#inputSearch").on("change", function(){
                $(".containerInput").css("margin-left", "0em");
                $("#searchButton").css("display","inline");
                $("#inputSearch").css("background-color","#212529");
                $("#inputSearch").css("width","0.000001px");
                $("#inputSearch").css("height","0.000001px");
                $(".keranjang").css("display", "inline");
                $(".user").css("display", "inline");
                $(".kanan").css("display", "inline");
                $("#inputSearch").val("");
            })
            let count = 0;
            let status = false;
            let filter = "";
            $.ajax({
                    type : "post",
                    data : {
                        loc : filter,
                        filter_nama : $("#inputSearch").val()
                    },
                    success : function(response){
                        $("#viewItem").html(response);
                    }
                });
            $("#buttonUser").click(function(){
                now= $(".peopleCard").css("display");

                if(now=="none"){
                    $(".peopleCard").css("display", "inline");
                }else{
                    $(".peopleCard").css("display", "none");
                }
            })
            // $("#profile").on("click",function(){
                
            // })
            $("#filter").on("click",function(){
                    if (count==0){
                        $("#No").css("top","-40px");
                        $("#No").css("left","70px");
                        $("#T").css("top","60px");
                        $("#T").css("left","130px");
                        $("#C").css("top","150px");
                        $("#C").css("left","80px");
                        $("#P").css("top","60px");
                        $("#P").css("left","-20px");
                        filter = "T";
                    }else if (count == 1){
                        $("#T").css("top","-40px");
                        $("#T").css("left","70px");
                        $("#C").css("top","60px");
                        $("#C").css("left","130px");
                        $("#P").css("top","150px");
                        $("#P").css("left","80px");
                        $("#No").css("top","60px");
                        $("#No").css("left","-20px");
                        filter = "C";
                    }else if (count == 2){
                        $("#C").css("top","-40px");
                        $("#C").css("left","70px");
                        $("#P").css("top","60px");
                        $("#P").css("left","130px");
                        $("#No").css("top","150px");
                        $("#No").css("left","80px");
                        $("#T").css("top","60px");
                        $("#T").css("left","-20px");
                        filter = "P";
                    }else if (count == 3){
                        $("#P").css("top","-40px");
                        $("#P").css("left","70px");
                        $("#No").css("top","60px");
                        $("#No").css("left","130px");
                        $("#T").css("top","150px");
                        $("#T").css("left","80px");
                        $("#C").css("top","60px");
                        $("#C").css("left","-20px");
                        filter = "";
                    }
                count = (count + 1)%4;
                $.ajax({
                    type : "post",
                    data : {
                        loc : filter,
                        filter_nama : $("#inputSearch").val()
                    },
                    success : function(response){
                        $("#viewItem").html(response);
                    }
                });
            })
            $("#inputSearch").on("keyup",function(){
                $.ajax({
                    type : "post",
                    data : {
                        loc : filter,
                        filter_nama : $("#inputSearch").val()
                    },
                    success : function(response){
                        $("#viewItem").html(response);
                    }
                });
            });
            $(document.body).on("click",".card-button",function(){
                console.log($(this).parent().find(".nama_barang").text());
                let nama_brang = $(this).parent().find(".nama_barang").text();
                $.ajax({
                    type : "post",
                    data : {
                        nama : nama_brang,
                        filter  : filter
                    },
                    success : function(response){
                        setTimeout(() => {
                            $(window).attr("location","pinjam.php");
                        },1000)
                    }
                })
            })
        })
    </script>
    <style>
            #inputSearch{
                border: solid;
                width: 75%;
                height:2em;
                margin-top: 0.5em;
                border-radius: 20pt;
                transition: all 0.5s ease;
            }
            .header{
                height: 4em;
                position : sticky;
                top:0;
                z-index: 1;
            }

            #notifImg, #keranjang, #userImg, #searchImg{
                width: 2em;
                height: 2em;
                top:10px;
            }
            #userImg{
                border-radius:40%;
            }

            #filter{
                position : fixed;
                top : 7em;
                left : -90pt; 
                width: 150px;
                height: 150px;
                border-radius: 50%;
                z-index : 10;
            }
            .filter-prop{
                position: absolute;
                border-radius : 50%;
                color:black;
                padding:5pt;
                transition:all 0.7s ease-in-out;
            }
            #No{
                top:60px;
                left:130px;
            }
            #P{
                top:-20px;
                left:60px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            #C{
                top:60px;
                left:-20px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            #T{
                top:150px;
                left:80px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            .peopleCard{
                border-radius: 15pt;
            }

            .opening{
                background-color: black;
                background-image: url("assets/opening.jpg");
                background-color: #cccccc;
                height: 25em;
                top : 4em;
            }

            .card {
                /* height: 300px; */
                border-radius: 20px;
                background: white;
                position: relative;
                transition: 0.5s ease-out;
                overflow: visible;
                /* z-index: -1; */
                box-shadow: 2px 5px 23px -8px rgba(0,0,0,0.75);
            }

            .card-details {
                color: black;
                height: 100%;
                gap: .5em;
                display: grid;
                place-content: center;
            }

            .card-button {
                transform: translate(-50%, 125%);
                width: 60%;
                border-radius: 1rem;
                z-index: 3;
                border: none;
                background-color: #008bf8;
                color: #fff;
                font-size: 1rem;
                padding: .5rem 1rem;
                position: absolute;
                left: 50%;
                bottom: 0;
                opacity: 0;
                transition: 0.3s ease-out;
            }

            .text-body {
                color: rgb(134, 134, 134);
            }

            /*Text*/
            .text-title {
                text-align: center;
                font-size: 1em;
                font-weight: bold;
            }

            /*Hover*/
            .card:hover {
                border-color: #008bf8;
                box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
            }

            .card:hover .card-button {
                transform: translate(-50%, 50%);
                opacity: 1;
            }    
            
            .footer {
                left: 0;
                width: 100%;
                height: 3.5em;
                color: white;
                text-align: center;
            }

            #inputSearch::placeholder{
                font-size: 11px;
            }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="container-fluid bg-dark text-white header">
    <div class="row">
        <div class="col-4 pt-3 left">
            <h4>
                <a class="navbar-brand" id= "judul" href="homeUser.php">PEMINJAMAN BARANG</a>
            </h4>   
        </div>
        <div class="col-4 pt-2 d-flex justify-content-center containerInput">
            <button class="bg-dark" style="border:none; width: 2em; height: 2em; margin-top: 10px; display: none;" id="searchButton"><img src="assets/search.png" alt="" id="searchImg" style=""></button>
            <input type="text" class="form-control" id="inputSearch" placeholder="Search Product">
        </div>
        <div class="col-4 pt-3 kanan">
            <div class="row float-end">
                <div class="col-auto kiri">

                </div>
                <div class="col-auto">
                    <a href="status.php">
                        <button type="button" class="btn btn-dark position-relative mb-2">
                            <img src="assets/notif.png" alt=""  id="notifImg">
                        </button>
                    </a>    
                </div>
                <div class="col-auto keranjang">
                    <a href="keranjang.php">
                        <button type="button" class="btn btn-dark position-relative mb-2">
                            <img src="assets/keranjang.png" alt=""  id="keranjang">
                        </button>
                    </a>
                </div>

                <div class="col-auto user">
                    <li class="nav-item dropdown mt-2" style="list-style: none">
                        <a class="nav-link dropdown-toggle mb-2 position-relative" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo $_SESSION['profile'] ?>" alt=""  id="userImg">
                        </a>
                        <ul class="dropdown-menu bg-dark text-white mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                            <h6 class="card-title mb-2">User ID:</h6>
                            <h6 class="card-title mb-1"><?php echo $_SESSION['user'] ?></h6>
                            <h6 class="card-title mb-2">Nama:</h6>
                            <h6 class="card-title mb-1">
                                <?php $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                                    $stmtName = $conn->prepare($sqlName);
                                    $stmtName->execute(['user' => $_SESSION['user']]);
                                    $rowName = $stmtName->fetchcolumn(); 
                                    echo $rowName;
                                ?>
                            </h6>
                            <h6 class="card-title mb-2">Status: </h6>
                            <h6 class="card-title mb-1">
                                <?php
                                    if($_SESSION['status'] == 0){
                                        echo "Green";
                                    }else{
                                        echo "Red";
                                    }
                                ?></h6>
                            <li><hr class="dropdown-divider"></li>
                            <a href="logout.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
                        </ul>
                    </li>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- filter -->
<div  id="filter" style="background-color: #7C9CAB; z-index: 10;">
    <div class="poisition-relative">
        <input id="filter" type="text" value = "0" hidden>
        <span class="filter-prop bg-light position-absolute" id="No">All</span>
        <span class="filter-prop bg-light position-absolute" id="P">P</span>
        <span class="filter-prop bg-light position-absolute" id="C">C</span>
        <span class="filter-prop bg-light position-absolute" id="T">T</span>
    </div>
</div>
<!-- card -->
<div class="container-fluid opening">
    <div class="row mt-2 float-end">
            <div class="card bg-dark peopleCard text-light" style="width: 15rem; margin-right: 2em; height: 15em; display: none;">
                <div class="card-body">
                    </div>
            </div>
    </div>
    <br>
    <div class="text-white mx-5" style="margin-top: 200px;">
            <h1>WELCOME TO</h1>
            <h1>UPPK C</h1>
            <hr style="width: 20em;">
    </div>
</div>

<div class="container-fluid peraturan bg-dark text-white">
    <div class="row">
        <div class="col-12 text-center pt-3">
            <h5>PERATURAN</h5>
        </div>
        <br>
    </div>
</div>

<div class="container barang mt-3">
 <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1" id="viewItem">
   <!-- <div class="col mt-5 contCard">
        <div class="card" style="width: 18rem; height: 24rem;">
            <div class="text-center">
                <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="item/mic.jfif" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="item/speaker.jfif" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="item/WT.jfif" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="card-details">
                <p class="text-title">Random</p>
                <p class="text-title">Quantity : 5</p>
                <p class="text-body" style="padding-left : 10px;">Blablabla</p>
            </div>
            <button class="card-button">Pinjam!</button>
        </div>
    </div> -->
  </div>
</div>
</body>