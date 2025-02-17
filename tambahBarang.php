<?php
    include "admin_authen.php";
?>
<?php
    if(isset($_POST['loc'])){
        $sql2 = "SELECT Id FROM item WHERE Location = :loc ORDER BY Id DESC LIMIT 1";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute(['loc' => $_POST['loc']]);
        $row2 = $stmt2->fetchcolumn();
        $hasil = (int)substr($row2,1);
        echo $hasil;
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php include "navbarAdmin.php"; ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            background: url('assets/gedungQ2.jpg') fixed no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
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

        form {
            color: #fff;
        }

        /* Upload Foto */
        .uploadFoto {
            transition : all 1s ease-in-out; 
        }

        .uploadFoto label {
            width: 100%;
            border: 2px dashed #fff;
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
                    }
                });
            }
        });
    </script>
</head>
<body>
    <!-- Main content -->
    <div class="container-fluid px-5 d-flex align-items-center justify-content-center" style='margin-top: 100px;'>
        <form action="insertItem.php" method="post" enctype="multipart/form-data">
            <div class="row p-lg-5 p-3 mb-5 rounded tempatUpload"  style="backdrop-filter:blur(20px)">
                <div class="col-1 pt-1">
                    <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
                </div>
                <div class="col-10">
                    <h2 class="text-center text-light mb-lg-5 mb-3">TAMBAH BARANG</h2>
                </div>
                <div class="col-1"></div>
                <hr style="color: #fff">
                <div class="col-lg-2"></div>

                <div class="col-lg-2 col-md-6 col-12 mt-lg-3 p-2 d-flex align-items-center justify-content-center uploadFoto">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto1" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto1" id="submitFoto1" onchange="read_file(this)" value="assets/no-image.png">
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 mt-lg-3 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up2" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto2" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto2" id="submitFoto2" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 mt-lg-3 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up3" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto3" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto3" id="submitFoto3" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>

                <div class="col-lg-2 col-md-6 col-12 mt-lg-3 p-2 d-flex align-items-center justify-content-center uploadFoto" id="up4" style="opacity : 0; height: 0">
                    <img src="" class="fotoBarang">
                    <label for="submitFoto4" class="d-flex align-items-center justify-content-center">Tambah Foto</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .jfif" class="form-control hidden" multiple="false" name="submitFoto4" id="submitFoto4" onchange="read_file(this)" value="assets/no-image.png" disabled>
                    <button type="button" class="btn deleteFoto"></button>
                </div>
                <div class="col-lg-2"></div>

                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-12">
                    <label for="nama" class="mt-3 pb-1 px-1">Nama Barang <span style="color:red">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Speaker Portabel" required><br>
                </div>
                <div class="col-lg-2"></div>

                <div class="col-lg-2"></div>
                <div class="col-lg-4 col-6">
                    <label for="lokasi" class="px-1 pb-1">Lokasi <span style="color:red">*</span></label>  
                    <select class="form-select form-select-md" aria-label="Lokasi UPPK" id="lokasi" name="lokasi" required>
                        <option value="C" class="align-self-center" selected>UPPK C</option>
                        <option value="P" class="align-self-center">UPPK P</option>
                        <option value="T" class="align-self-center">UPPK T</option>
                    </select>
                </div>
                <div class="col-lg-4 col-6">
                    <label for="kodeBarang" class="px-1 pb-1">Kode Barang <span style="color:red">*</span></label>  
                    <input type="text" id="kodeBarang" name="kodeBarang" class="form-control" placeholder="X0001" readonly required><br>
                </div>
                <div class="col-lg-2"></div>

                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-12">
                    <label for="keterangan" class="px-1 pb-1">Deskripsi <span style="color:red">*</span></label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea><br>
                </div>
                <div class="col-lg-2"></div>

                <div class="col-lg-2"></div>
                <div class="col-lg-8 mb-3">
                    <button type="submit" class="btn btn-dark" id="submit" style="width:100%">Tambah</button>
                </div>
            </div>
        </form>
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