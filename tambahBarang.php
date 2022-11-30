<?php
    include "connection.php";
    session_start();
    // if(isset($_SESSION['user']) == false){
    //     session_destroy();
    //     header('Location: login.php');
    // }
    // $sql = 'SELECT profile FROM `admin` WHERE `username` = :user';
    // $stmt = $conn->prepare($sql);
    // $stmt->execute(['user' => $_SESSION['user']]);
    // $row = $stmt->fetchcolumn();
    // $_SESSION['profile'] = $row;
?>
<?php
    if(isset($_POST['loc'])){
        $sql2 = "SELECT COUNT(*) FROM item WHERE Location = :loc";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute(['loc' => $_POST['loc']]);
        $row2 = $stmt2->fetchcolumn();
        echo $row2;
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
            overflow-x: scroll;
        }

        .hidden {
            display: none !important;
        }

        /* Navbar style */
        #inputSearch{
            border: transparent;
            width: 75%;
            height: 3em;
            border-radius: 20pt;
        }

        .header {
            width: 100%;
            top: 0;
            z-index: 1;
        }
    
        #notifImg, #keranjang, #userImg {
            height: 2em;
            aspect-ratio: 1 / 1;
        }

        #userImg {
            border-radius: 40%;
        }

        @media only screen and (max-width: 576px) {
            .navbar-brand {
                font-size: 12px;
            }
        }

        /* Upload Foto */
        .uploadFoto {
            transition : all 1s ease-in-out; 
        }

        .uploadFoto label {
            width: 100%;
            border: 2px dashed #222;
            border-radius: 20px;
            aspect-ratio: 1 / 1;
            cursor: pointer;
        }

        .uploadFoto img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 20px;
            display: none;
            cursor: pointer;
            transition: all 0.5s ease;
        }

        .deleteFoto {
            background-image: url("assets/wrong.png");
            background-size: cover;
            background-color: transparent;
            border: 0;
            position: absolute;
            display: none;
            border-radius: 50%;
            width: 30px;
            aspect-ratio: 1 / 1;
            transition: all 0.5s ease;
        }

    </style>

<script>
        // display foto
        function read_file(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                var image = $(input).parent().find("img");

                reader.onload = function(){
                    image.attr("src", reader.result);
                    image.css("display", "block");

                    // $(input).parent().css("border", "none");
                    $(input).parent().find("label").addClass("hidden");
                }
                reader.readAsDataURL(input.files[0]);
                $(input).parent().next().css("opacity","1");
                $(input).parent().next().find("input").removeAttr("disabled");
                $(input).parent().next().css("height", "100%");
            }
        };

        $(document).ready(function() {
            let boxMade = 4;
            generateId('C');
            // delete foto
            $(document.body).on("click", ".deleteFoto", function(e) {
                e.preventDefault();
                console.log("bisa del");
                $(this).parent().find('input').val("");
                $(this).parent().find("img").attr("src", "");
                $(this).parent().find("label").removeClass("hidden");
                $(this).parent().find("img").css("display","none");

                $(this).parent().next().css("opacity","0");
                $(this).parent().next().find("input").attr("disabled","true");
                $(this).parent().next().css("height", "0");
                // read_file(this);
            });
            
            $(document.body).on("change","#lokasi",function(e){
                $loc = $("#lokasi :selected").val();
                // console.log($loc);
                generateId($loc);
            });

            // munculin tombol buat delete foto
            $(document.body).on("mouseenter", ".uploadFoto", function() {
                if (($(this).next().find("img").attr("src") == "" && $(this).find("img").attr("src") != "") 
                    || ($(this).attr("id") == "up4" && $(this).find("img").attr("src") != "")) {
                    $(this).find("button").css("display", "block");
                    $(this).find("img").css("opacity",".85");
                }
            });

            $(document.body).on("mouseleave", ".uploadFoto", function() {
                $(this).find("button").css("display", "none");
                $(this).find("img").css("opacity", "1");
            });

            function generateId($loc){
                $.ajax({
                    type : "post",
                    data : {
                        loc : $loc
                    },
                    success : function(response){
                        if(response > 999){
                            $("#kodeBarang").val($loc + (parseInt(response)+1));
                        }else if(response > 99){
                            $("#kodeBarang").val($loc + "0" + (parseInt(response)+1));
                        }else if(response > 9){
                            $("#kodeBarang").val($loc + "00" + (parseInt(response)+1));
                        }else{
                            $("#kodeBarang").val($loc + "000" + (parseInt(response)+1));
                        }
                        console.log($("#kodeBarang").val());
                    }
                });
            }
        });
    </script>
</head>
<body>
    <div class="container-fluid bg-dark text-white header sticky-top">
        <div class="row px-lg-3" style="margin: 0">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-lg-2 col-3 d-flex justify-content-start text-center">   
                    <a class="navbar-brand animate_animated animate__fadeInUp" href="homeUser.php">UPPK</a>
                </div>
                
                <div class="col-lg-8 col-6 d-flex justify-content-center">
                    <input type="text" class="form-control px-4" id="inputSearch" placeholder="Search Product">
                </div>

                <div class="col-lg-2 col-3 d-flex justify-content-end">
                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-dark">
                            <img src="assets/notif.png" alt=""  id="notifImg">
                            <span class="position-absolute badge rounded-pill bg-danger">
                            99+
                            </span>
                        </button>
                    </div>
                    
                    <!-- <div class="pe-2">
                        <button type="button" class="btn btn-dark">
                            <img src="assets/keranjang.png" alt=""  id="keranjang">
                        </button>
                    </li> -->

                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <li class="nav-item dropdown mt-2" style="list-style: none">
                            <a class="nav-link dropdown-toggle mb-2 position-relative dropdown-menu-end" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $_SESSION['profile'] ?>" alt=""  id="userImg">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark text-white mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                                <h6 class="card-title mb-2">User ID:</h6>
                                <h6 class="card-title mb-1">
                                    <?php
                                         echo $_SESSION['user'] 
                                    ?>
                                </h6>
                                <h6 class="card-title mb-2">Nama:</h6>
                                <h6 class="card-title mb-1">
                                    <?php 
                                    $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                                        $stmtName = $conn->prepare($sqlName);
                                        $stmtName->execute(['user' => $_SESSION['user']]);
                                        $rowName = $stmtName->fetchcolumn(); 
                                        echo $rowName;
                                    ?>
                                </h6>
                                <li><hr class="dropdown-divider"></li>
                                <a href="login.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
                            </ul>
                        </li>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    

    <div class="container-fluid p-5 align-items-center justify-content-center">
        <form action="insertItem.php" method="post" enctype="multipart/form-data" >
            <div class="row text-center px-3 tempatUpload">
                <div class="col-lg-2 col-12 py-4 d-flex align-items-start">
                    <a href="homeAdmin.php"><img src="assets/back.png" height="25px"></a>
                </div>

                <div class="col-lg-2 col-md-6 col-12 p-2 d-flex align-items-center justify-content-center uploadFoto">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto1" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto1" id="submitFoto1" onchange="read_file(this)" value="assets/no-image.png">
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up2" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto2" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto2" id="submitFoto2" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up3" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto3" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto3" id="submitFoto3" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up4" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto4" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto4" id="submitFoto4" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-12">
                    <label for="nama" class="mt-5 pb-2 px-1">Nama Barang <span style="color:red">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Speaker Portabel" required><br>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-4 col-6">
                    <label for="lokasi" class="py-2 px-1">Lokasi <span style="color:red">*</span></label>  
                    <select class="form-select form-select-md" aria-label="Lokasi UPPK" id="lokasi" name="lokasi" required>
                        <option value="C" class="align-self-center" selected>UPPK C</option>
                        <option value="P" class="align-self-center">UPPK P</option>
                        <option value="T" class="align-self-center">UPPK T</option>
                    </select>
                </div>
                <div class="col-lg-4 col-6">
                    <label for="kodeBarang" class="py-2 px-1">Kode Barang <span style="color:red">*</span></label>  
                    <input type="text" id="kodeBarang" name="kodeBarang" class="form-control" placeholder="X0001" readonly required><br>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-12">
                    <label for="keterangan" class="py-2 px-1">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea><br>
                </div>
                <div class="col-lg-2"></div>
            </div>
                
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <button type="submit" class="btn btn-dark" id="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>