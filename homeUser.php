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
            $sql = 'SELECT DISTINCT Nama_Barang FROM item WHERE status = 1 and Nama_Barang LIKE :filt';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':filt' => '%'.$_POST['filter_nama'].'%'
            ));
            $row = $stmt->fetchAll();
            if($row){
                foreach($row as $s){
                    // lama
                    // $sql2 = 'SELECT COUNT(*) FROM item WHERE status = 1 and Nama_Barang = :nama';
                    // $stmt2 = $conn->prepare($sql2);
                    // $stmt2->execute(array(
                    //     ':nama' => $s['Nama_Barang']
                    // ));
                    // $row2 = $stmt2->fetchColumn();
                    // echo '<div class="col mt-5 contCard">';
                    // echo '<div class="card" style="width: 18rem; height: 24rem;" >';
                    // echo '<div class="text-center">';
                    // echo '<img src="'.$s['image'].'" class="card-img-top" alt="" style="width: 12em; height: 10em;"></div>';
                    // echo '<div class="card-details">';
                    // echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    // echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    // echo '<p class="text-body" style="padding-left : 10px;">'.$s['Deskripsi'].'</p></div>';
                    // echo '<button class="card-button">Pinjam!</button></div></div>';

                    //$sql_sl = "SELECT Deskripsi,image,image2,image3,image4 FROM item WHERE Nama_Barang = :nama LIMIT 1";
                    //$stmt_sl = $conn->prepare($sql_sl);
                    //$stmt_sl->execute(array(
                    //    ":nama" => $s['Nama_Barang']
                    //));
                    //$row_sl = $stmt_sl->fetchAll();
                    //$arr = array($row_sl[0]['image2'],$row_sl[0]['image3'],$row_sl[0]['image4']);
                    $sql2 = 'SELECT COUNT(*) FROM item WHERE status = 1 and Nama_Barang = :nama';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute(array(
                        ':nama' => $s['Nama_Barang']
                    ));
                    $row2 = $stmt2->fetchColumn();

                    echo '<div class="card my-4">
                        <div class="card-img" style="background-image:url('.$s['image'].');">
                            <div class="overlay">
                                <div class="overlay-content" id="'.$s['Nama_Barang'].'">
                                    <button class="card-button">Pinjam!</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <a href="#!">
                                <h2 class="nama_barang">'.$s['Nama_Barang'].'</h2>
                                <p>'.$s['Deskripsi'].'</p>
                            </a>
                        </div>
                    </div>';
                    //echo '<div class="col mt-5 contCard">';
                    //echo '<div class="card" style="width: 18rem; height: 28rem;">';
                    //echo '<div class="text-center">';
                    //echo '<div id="carouselExampleControlsNoTouching'.$i.'" class="carousel slide" data-bs-touch="false" data-bs-interval="false">';
                    //echo '<div class="carousel-inner">';
                    //echo '<div class="carousel-item active p-2"><img src="'.$row_sl[0]['image'].'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    //foreach($arr as $a){
                    //    if($a != "assets/no-image.png"){
                    //        echo '<div class="carousel-item p-2"><img src="'.$a.'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    //    }
                    //}
                    //echo '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="prev">
                    //        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    //        <span class="visually-hidden">Previous</span>
                    //    </button>
                    //    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="next">
                    //        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    //        <span class="visually-hidden">Next</span>
                    //    </button></div></div>';
                    //echo '<div class="card-details">';
                    //echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    //echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    //echo '<p class="text-body" style="padding-left : 10px;">'.$row_sl[0]['Deskripsi'].'</p></div>';
                    //echo '<button class="card-button">Pinjam!</button></div></div>';
                    //$i += 1;
                }
            }
        }else{
            $sql = 'SELECT DISTINCT Nama_Barang FROM item WHERE status = 1 and location = :loc and Nama_barang LIKE :filt';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ':loc' => $_POST['loc'],
                ':filt' => '%'.$_POST['filter_nama'].'%'
            ));
            $row = $stmt->fetchAll();
            if($row){
                foreach($row as $s){
                    $sql_sl = "SELECT Deskripsi,image,image2,image3,image4 FROM item WHERE Nama_Barang = :nama and location = :loc LIMIT 1";
                    $stmt_sl = $conn->prepare($sql_sl);
                    $stmt_sl->execute(array(
                        ":nama" => $s['Nama_Barang'],
                        ":loc" => $_POST['loc']
                    ));
                    $row_sl = $stmt_sl->fetchAll();
                    $arr = array($row_sl[0]['image2'],$row_sl[0]['image3'],$row_sl[0]['image4']);
                    $sql2 = 'SELECT COUNT(*) FROM item WHERE status = 1 and Nama_Barang = :nama and location = :loc';
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute(array(
                        ':nama' => $s['Nama_Barang'],
                        ':loc' => $_POST['loc']
                    ));
                    $row2 = $stmt2->fetchColumn();
                    // lama
                    // echo '<div class="col mt-5">';
                    // echo '<div class="card" style="width: 18rem; height: 24rem;">';
                    // echo '<div class="text-center">';
                    // echo '<img src="'.$s['image'].'" class="card-img-top" alt="" style="width: 12em; height: 10em;"></div>';
                    // echo '<div class="card-details">';
                    // echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    // echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    // echo '<p class="text-body" style="padding-left : 10px;">'.$s['Deskripsi'].'</p></div>';
                    // echo '<button class="card-button">Pinjam!</button></div></div>';

                    echo '<div class="card my-4">
                        <div class="card-img" style="background-image:url('.$s['image'].');">
                            <div class="overlay">
                                <div class="overlay-content" id="'.$s['Nama_Barang'].'">
                                    <button class="card-button">Pinjam!</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <a href="#!">
                                <h2 class="nama_barang">'.$s['Nama_Barang'].'</h2>
                                <p>'.$s['Deskripsi'].'</p>
                            </a>
                        </div>
                    </div>';

                    //echo '<div class="col mt-5 contCard">';
                    //echo '<div class="card" style="width: 18rem; height: 28rem;">';
                    //echo '<div class="text-center">';
                    //echo '<div id="carouselExampleControlsNoTouching'.$i.'" class="carousel slide" data-bs-touch="false" data-bs-interval="false">';
                    //echo '<div class="carousel-inner">';
                    //echo '<div class="carousel-item active p-2"><img src="'.$row_sl[0]['image'].'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    //foreach($arr as $a){
                    //    if($a != "assets/no-image.png"){
                    //        echo '<div class="carousel-item p-2"><img src="'.$a.'" class="d-block w-100" alt="..." style ="aspect-ratio:1/1;"></div>';
                    //   }
                    //}
                    //echo '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="prev">
                    //        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    //        <span class="visually-hidden">Previous</span>
                    //    </button>
                    //    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching'.$i.'" data-bs-slide="next">
                    //        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    //        <span class="visually-hidden">Next</span>
                    //   </button></div></div>';
                    //echo '<div class="card-details">';
                    //echo '<p class="text-title nama_barang">'.$s['Nama_Barang'].'</p>';
                    //echo '<p class="text-title">Quantity : '.$row2.'</p>';
                    //echo '<p class="text-body" style="padding-left : 10px;">'.$row_sl[0]['Deskripsi'].'</p></div>';
                    //echo '<button class="card-button">Pinjam!</button></div></div>';
                    //$i += 1;

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
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/b1be1f623b.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('.card').delay(1800).queue(function(next) {
                $(this).removeClass('hover');
                $('a.hover').removeClass('hover');
                next();
            });

            // AOS.init();
            // var width = $(window).width();
            //     if (width<576){
            //         $("#viewItem").addClass("mx-4");
            //     }
            //     if (width>=576){
            //         $("#viewItem").removeClass("mx-4");
            //     }
            //     if (width >= 850){
            //         $(".kiri").css("display", "inline");
            //         $("#inputSearch").css("display","inline");
            //         $("#judul").css("font-size","24px");
            //         $("#searchButton").css("display","none");
            //         $("#inputSearch").css("width", "75%");
            //         $("#inputSearch").css("height", "2em");
            //         $("#inputSearch").css("background-color","#fff");
            //         $(".containerInput").css("margin-left","0em");
            //         $(".keranjang").css("display", "inline");
            //         $(".user").css("display", "inline");
            //         $(".kanan").css("display", "inline");
            //     }
            //     if (width < 550 && width > 350){
            //         $("#keranjang").css("width", "1.2em");
            //         $("#keranjang").css("height", "1.2em");
            //         $("#userImg").css("width", "1.5em");
            //         $("#userImg").css("height", "1.5em");
            //         $("#searchImg").css("width", "1.5em");
            //         $("#searchImg").css("height", "1.5em");
            //         $("#judul").css("font-size","12px");
            //     }
            //     if(width < 350){
            //         $("#judul").css("font-size","6px");
            //     }
            //     if (width < 850 && width >= 551){
            //         $("#keranjang").css("width", "2em");
            //         $("#keranjang").css("height", "2em");
            //         $("#userImg").css("width", "2em");
            //         $("#userImg").css("height", "2em");
            //         $("#searchImg").css("width", "2em");
            //         $("#searchImg").css("height", "2em");
            //         $("#judul").css("font-size","20px");
            //     }
            //     if(width < 750){
            //         $("#searchButton").css("display","inline");
            //         $(".kiri").css("display", "none");
            //         $("#inputSearch").css("background-color","#212529");
            //         $("#inputSearch").css("width","0.000001px");
            //         $("#inputSearch").css("height","0.000001px");
            //     }

            // $(window).resize(function() {
            //     var width = $(window).width();
            //     if (width<576){
                    
            //         $("#viewItem").addClass("mx-4");
            //     }
            //     if (width>=576){
            //         $("#viewItem").removeClass("mx-4");
            //     }
            //     if (width >= 850){
            //         $(".kiri").css("display", "inline");
            //         $("#inputSearch").css("display","inline");
            //         $("#judul").css("font-size","24px");
            //         $("#searchButton").css("display","none");
            //         $("#inputSearch").css("width", "75%");
            //         $("#inputSearch").css("height", "2em");
            //         $("#inputSearch").css("background-color","#fff");
            //         $(".containerInput").css("margin-left","0em");
            //         $(".keranjang").css("display", "inline");
            //         $(".user").css("display", "inline");
            //         $(".kanan").css("display", "inline");
            //     }
            //     if (width < 550 && width > 350){
            //         $("#keranjang").css("width", "1.5em");
            //         $("#keranjang").css("height", "1.5em");
            //         $("#userImg").css("width", "1.5em");
            //         $("#userImg").css("height", "1.5em");
            //         $("#searchImg").css("width", "1.5em");
            //         $("#searchImg").css("height", "1.5em");
            //         $("#judul").css("font-size","12px");
            //     }
            //     if(width < 350){
            //         $("#judul").css("font-size","6px");
            //     }
            //     if (width < 850 && width >= 551){
            //         $("#keranjang").css("width", "2em");
            //         $("#keranjang").css("height", "2em");
            //         $("#userImg").css("width", "2em");
            //         $("#userImg").css("height", "2em");
            //         $("#searchImg").css("width", "2em");
            //         $("#searchImg").css("height", "2em");
            //         $("#judul").css("font-size","20px");
            //     }
            //     if(width < 750){
            //         $("#searchButton").css("display","inline");
            //         $(".kiri").css("display", "none");
            //         $("#inputSearch").css("background-color","#212529");
            //         $("#inputSearch").css("width","0.000001px");
            //         $("#inputSearch").css("height","0.000001px");
            //     }
            // });

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
                        $("#namaGedung").html("UPPK Gedung T")
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
                        $("#namaGedung").html("UPPK Gedung C")
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
                        $("#namaGedung").html("UPPK Gedung P")
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
                        $("#namaGedung").html("UPPK UK. Petra")
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
                console.log($(this).parent().attr("id"));
                let nama_brang = $(this).parent().attr("id");
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
        @import url('https://fonts.googleapis.com/css2?family=Secular+One&display=swap');
        body {
            font-family: 'Secular One', sans-serif !important;
            min-width: 425px;
            top: 0;
            left: 0;
        }

        .card {
            width: 300px;
            display: inline-block;
            border-radius: 4px;
            box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
            background: #fff;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
            float: none;
            margin-bottom: 10px;
        }
        .card:hover, .card.hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 25px 0 rgba(0, 0, 0, 0.3), 0 0 1px 0 rgba(0, 0, 0, 0.25);
        }
        .card:hover .card-content, .card.hover .card-content {
            box-shadow: inset 0 3px 0 0 #ccb65e;
            border-color: #e9ab59;
        }

        .card:hover .card-img .overlay, .card.hover .card-img .overlay {
            background-color: rgba(25, 29, 38, 0.7);
            transition: opacity 0.2s ease;
            opacity: 1;
        }
        
        .card-img {
            position: relative;
            height: 260px;
            width: 100%;
            background-color: #fff;
            transition: opacity 0.2s ease;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .card-img .overlay {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            opacity: 0;
        }
        .card-img .overlay .overlay-content {
            line-height: 270px;
            width: 100%;
            text-align: center;
            color: #fff;
        }

        .card-img .overlay .overlay-content button {
            color: white;
            padding: 0 2rem;
            display: inline-block;
            border: #e9ab59;
            height: 40px;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            background-color: #e9ab59;
        }
        
        .card-img .overlay .overlay-content a:hover, .card-img .overlay .overlay-content a.hover {
            background: #e9ab59;
            border-color: #e9ab59;
        }
        
        .card-content {
            width: 100%;
            min-height: 104px;
            background-color: #e9ab59;
            border-top: 1px solid #e9e9eb;
            border-bottom-right-radius: 2px;
            border-bottom-left-radius: 2px;
            padding: 1rem 1.2rem;
            transition: all 0.2s ease;
        }
        .card-content a {
            text-decoration: none;
            color: white;
        }

        .card-content h2,
        .card-content a h2 {
            font-size: 17pt;
            font-weight: 500;
        }

        .card-content p,
        .card-content a p {
            font-size: 12pt;
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: rgba(255,255,255, 0.95);
        }

        #inputSearch{
            border: solid;
            border-width: medium;
            border-radius: 15pt;
            border-color: white;
            background-color: rgba(0, 0, 0, 0.0) !important;
            font-size: 11pt;
            color: white;
            transition: all 0.5s ease;
            height: 29px;
        }

        #inputSearch::placeholder{
            color: white;
            font-size: 11pt;
        }

        .header{
            height: 3.5em;
            z-index: 1;
            background-color:rgba(0, 0, 0, 0.5);
        }

        .header a button:hover {
            transform: translate(0%, 10%);
            opacity: 0.9;
            transition:all 0.2s ease-in-out;
        }

        #notifImg, #keranjang, #userImg, #searchImg{
            width: 2em;
            height: 2em;
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
            color: #e9ab59;
            top:60px;
            left:130px;
        }
        #P{
            color: #e9ab59;
            top:-20px;
            left:60px;
            padding-left:8pt;
            padding-right:8pt; 
        }
        #C{
            color: #e9ab59;
            top:60px;
            left:-20px;
            padding-left:8pt;
            padding-right:8pt; 
        }
        #T{
            color: #e9ab59;
            top:150px;
            left:80px;
            padding-left:8pt;
            padding-right:8pt; 
        }
        
        .peopleCard{
            border-radius: 15pt;
        }

        .opening{
            background-image: url("assets/opening-gedungQ.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            height: 15em;
        }

        .user-menu{
            color: white;
            background-color:rgba(0, 0, 0, 0.5);
        }

        .user-menu a button{
            background-color: #e9ab59;
            color: white;
            border-color: #e9ab59;
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

        .footer {
            left: 0;
            width: 100%;
            height: 3.5em;
            color: white;
            text-align: center;
        }

        .navbar .navbar-toggler{
            border: 0pt;
        }

        .green {
            border-radius: 5px;
            width: 30%;
            text-align: center;
        }

        .red {
            border-radius: 5px;
            width: 25%;
            text-align: center;
        }

        .dropdown-divider {
            border-radius: 10px;
            height: 1.4px;
            background-color: white;
            opacity: 1;
        }

        .containerInput {
            min-width: 300px;
            transition:all 0.2s ease-in-out;
        }

        @media only screen and (max-width: 991px) {
            .containerInput {
                margin-left: auto;
                margin-right: auto;
                margin-top: 15px;
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 35px;
                height: 80%;
                display: block;
                flex: auto;
                text-align: center;
                flex-direction: column;
                align-items: flex-end;
                padding: 5px;
            }

            .containerInput input {
                width: 94%;
                margin: auto;
                display: inline-block;
                text-align: left;
                background-color: white;
                margin-bottom: 10px;
            }
        }

        @media screen and (min-width: 300px) {
            .containerInput {
                width: 300px;
            }
        }

        @media screen and (min-width: 576px) {
            .containerInput {
                width: 550px;
            }
        }

        @media screen and (min-width: 768px) {
            .containerInput {
                width: 720px;
            }
        }

        @media screen and (min-width: 991px) {
            .containerInput {
                width: 600px;
            }
        }
    </style>
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar fixed-top navbar-expand-lg header px-lg-5 px-md-3 px-sm-1">
  <div class="container-fluid">
    <!-- drop down -->
    <div class="col-auto user mx-3">
        <li class="nav-item dropdown mt-1" style="list-style: none">
            <a class="nav-link dropdown-toggle mb-1 position-relative" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $_SESSION['profile'] ?>" alt=""  id="userImg">
            </a>
            <ul class="dropdown-menu user-menu mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                <h6 class="card-title mb-1 mt-1">User ID:</h6>
                <h6 class="card-title mb-2"><?php echo $_SESSION['user'] ?></h6>
                <h6 class="card-title mb-1">Nama:</h6>
                <h6 class="card-title mb-2">
                    <?php $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                        $stmtName = $conn->prepare($sqlName);
                        $stmtName->execute(['user' => $_SESSION['user']]);
                        $rowName = $stmtName->fetchcolumn(); 
                        echo $rowName;
                    ?>
                </h6>
                <h6 class="card-title mb-1">Status: </h6>
                <h6 class="card-title mb-2">
                    <?php
                        if($_SESSION['status'] == 0){
                            echo '<p class="bg-success p-1 green">Green</p>';
                        }else{
                            echo '<p class="bg-danger p-1 red">Red</p>';
                        }
                    ?></h6>
                <li>
                <hr class="dropdown-divider"></li>
                <a href="logout.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
            </ul>
        </li>
    </div>

    <!-- judul -->
    <a class="navbar-brand text-white" id= "judul" href="homeUser.php">UPPK UK. PETRA</a>

    <!-- status -->
    <a href="status.php" class="ml-2 mt-1">
    <button type="button" class="btn">
        <i class="fa-sharp fa-solid fa-inverse fa-clock-rotate-left fa-xl"></i>
    </button>
    </a>    

    <!-- keranjang -->
    <a href="keranjang.php" class="ml-2 mt-1">
        <button type="button" class="btn">
            <i class="fa-solid fa-cart-shopping fa-inverse fa-xl"></i>
        </button>
    </a>

    <!-- tombol responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="mt-1">
        <i class="fa-solid fa-inverse fa-lg fa-magnifying-glass" style="margin-top: 12px;"></i>
    </span>
    </button>
    <div class="collapse navbar-collapse justify-content-end mb-3" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <!-- TOMBOL SEARCH -->
            <li class="nav-item">
                <div class="pt-3 containerInput">
                    <!-- <button class="form-control bg-dark me-2" id="searchButton"><img src="assets/search.png" alt="" id="searchImg"></button> -->
                    <input type="text" class="form-control inputSearch" id="inputSearch" placeholder="Search Product">
                </div>
            </li>
        </ul>
    </div>
  </div>
</nav>

<!-- filter -->
<div  id="filter" style="background-color: #e9ab59; z-index: 10;">
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
    <div class="row mt-0 float-end">
            <div class="card bg-dark peopleCard text-light" style="width: 15rem; margin-right: 2em; height: 15em; display: none;">
                <div class="card-body">
                </div>
            </div>
    </div>
    <br>
    <div class="text-white mx-4" style="margin-top: 90px; margin-left:70px !important;">
            <h1>WELCOME TO</h1>
            <h1 id="namaGedung">UPPK UK. Petra</h1>
    </div>
</div>

<div class="container barang mt-3">
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1" id="viewItem">

    </div>
</div>
</body>