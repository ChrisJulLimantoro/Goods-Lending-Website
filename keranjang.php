<?php 
    include "connection.php";
    session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
            overflow-y: scroll;
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

        .dropdown-menu {
            z-index: 1;
        }

        @media only screen and (max-width: 576px) {
            .navbar-brand {
                font-size: .75em;
            }
        }

        /* Main */
        .detail-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            align-items: center;
            width: 60%;
            min-height: 90vh;
        }

        .detail-box > div {
            border-radius: 20pt;
            width: 100%;
            transition: all .5s ease-in-out;
        }

        .detail-box > div:hover {
            box-shadow: 0 0 30px #aaa;
        }

        #namaItem, #qtyItem, #keteranganItem {
            font-size: 1.25em;
        }

        @media screen and (max-width: 920px) {
            .detail-box {
                width: 90%;
            }
            #namaItem, #qtyItem, #keteranganItem, .table tr {
                font-size: .75em;
            }
        }

        #imgItem {
            width: 100%;
            aspect-ratio: 1 / 1;
        }

        .btn-close {
            transition: all .5s ease;
        }

        .btn-close:hover {
            transform: scale(1.15) rotate(-90deg);
        }

        /* Accordion */
        .accordion, .accordion-item, .detail-item-button {
            background-color: #212529;
            color: #fff;
            border: none;
        }

        #showDetail {
            width: 100%;
        }

        #showDetail img {
            width: 25px;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Delete per JENIS item
            $(document.body).on("click", "#deleteAll", function() {
                $(this).parent().parent().remove();
            });

            // Delete per item
            $(document.body).on("click", "#deleteOne", function() {
                $(this).parent().parent().remove();
            });
            
            // Animasi tombol
            $(document.body).on("click", "#showDetail", function() {
                $(this).find("img").css("transition", "all .5s ease");

                if ($(this).find("img").css("transform") != "none")
                    $(this).find("img").css("transform", "none");
                else
                    $(this).find("img").css("transform", "rotate(180deg)");
            });
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid bg-dark text-white header sticky-top">
        <div class="row px-lg-3" style="margin: 0">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-lg-2 col-3 d-flex justify-content-start text-center">   
                    <a class="navbar-brand" href="homeUser.php">KERANJANG</a>
                </div>
                
                <div class="col-lg-8 col-5 d-flex justify-content-center">
                    <input type="text" class="form-control px-4" id="inputSearch" placeholder="Search Product">
                </div>

                <div class="col-lg-2 col-4 d-flex justify-content-center">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-dark">
                            <img src="assets/notif.png" alt=""  id="notifImg">
                            <span class="position-absolute badge rounded-pill bg-danger">
                            99+
                            </span>
                        </button>
                    </div>
                    
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <a href="keranjang.php">
                            <button type="button" class="btn btn-dark">
                                <img src="assets/keranjang.png" alt=""  id="keranjang">
                            </button>
                        </a>
                    </div>

                    <div class="col-4 d-flex justify-content-center align-items-center">
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
    
    <!-- Main content -->
    <div class="container-fluid detail-box">
        <!-- Item card -->
        <div class="row mt-5 px-3 py-4 bg-dark text-light">
            <div class="col-lg-3 col-5">
                <img src="item/mic.jfif" id="imgItem">
            </div>

            <div class="col-lg-8 col-5">
                <h3 id="namaItem">Microphone</h3>
                <h5 id="keteranganItem">Gawe karaoke</h5>
                <h3 id="qtyItem">Qty: 8</h3>
            </div>

            <div class="col-1">
                <button type="button" id="deleteAll" class="btn-close btn-close-white"></button>
            </div>

            <!-- Detail item -->
            <div class="accordion" id="detail">
                <div class="accordion-header mt-2" id="heading1">
                    <button type="button" id="showDetail" class="collapsed detail-item-button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <img src="assets/more.png">
                    </button>
                </div>
                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#detail">
                    <table class="table table-sm table-dark table-bordered border-light mt-3 text-center align-middle" id="tabelDetail">
                        <tr>
                            <th>Kode</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <td id="kodeBrg">C0001</td>
                            <td id="lokasiBrg">C</td>
                            <td><button type="button" id="deleteOne" class="btn-close btn-close-white"></button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <button id="pinjamBarang" class="btn btn-dark my-4 px-5" type="button" style="border-radius:20pt">Ajukan Peminjaman</button>
    </div>
</body>
</html>