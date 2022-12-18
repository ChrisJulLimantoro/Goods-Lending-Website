<?php
include "user_authen.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Peminjaman Barang</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');

        body {
            font-family: 'Russo One', sans-serif;
            font-weight: 700;
            overflow-y: scroll;
            letter-spacing: 1px;
        }

        /* Navbar style */
        #inputSearch {
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

        #notifImg,
        #keranjang,
        #userImg {
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

        #imgItem {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: contain;
            height: 200px;
        }

        /* Accordion */
        .accordion,
        .accordion-item,
        .detail-item-button {
            color: #fff;
            border: none;
        }

        #showDetail {
            width: 100%;
        }

        #showDetail img {
            width: 25px;
        }

        tr:nth-child(odd) {
            background-color: #ffc107;
        }

        tr:nth-child(even) {
            background-color: #fff;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Animasi tombol
            $(document.body).on("click", "#showDetail", function() {
                $(this).find("img").css("transition", "all .5s ease");

                if ($(this).find("img").css("transform") != "none")
                    $(this).find("img").css("transform", "none");
                else
                    $(this).find("img").css("transform", "rotate(180deg)");
            });

            // Button state
            $(document.body).on("click", "#tambahBarang", function() {
                $(this).attr("disabled",true)
                $(this).text("MENUNGGU KONFIRMASI...");
            });
        });
    </script>
</head>

<body style = "background-color:#D3D3D3">
    <div class="container-fluid bg-warning text-white header">
        <div class="row px-lg-3">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-3">
                    <a class="navbar-brand text-black" href="homeUser.php">PEMINJAMAN BARANG</a>
                </div>
                <div class="col-7">
                </div>

                <div class="col-md-2 col-4 d-flex">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn opacity-75">
                            <img src="assets/notif.png" alt="" id="notifImg">
                        </button>
                    </div>

                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <a href="keranjang.php">
                            <button type="button" class="btn opacity-75">
                                <img src="assets/keranjang.png" alt="" id="keranjang">
                            </button>
                        </a>
                    </div>

                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <li class="nav-item dropdown mt-2" style="list-style: none">
                            <a class="nav-link dropdown-toggle mb-2 position-relative dropdown-menu-end" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $_SESSION['profile'] ?>" alt="" id="userImg">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-warning text-white mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                                <h6 class="card-title mb-1">User ID:</h6>
                                <h6 class="card-title mb-2">
                                    <?php
                                    echo $_SESSION['user']
                                    ?>
                                </h6>
                                <h6 class="card-title mb-1">Nama:</h6>
                                <h6 class="card-title mb-2">
                                    <?php
                                    $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                                    $stmtName = $conn->prepare($sqlName);
                                    $stmtName->execute(['user' => $_SESSION['user']]);
                                    $rowName = $stmtName->fetchcolumn();
                                    echo $rowName;
                                    ?>
                                </h6>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <a href="login.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
                            </ul>
                        </li>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
    <div class = "container container-custom mt-4">
        <a type="button" class="btn btn-warning" href = #>KEMBALI</a>
    </div>

    <div class = "container container-custom bg-light">
        <div class="row mt-4 px-5 py-5">
            <div class = "col-md-3">
                <div class = "row justify-content-center">
                    <div class="col-md-11">
                        <div class = "card">
                        <img src="https://img2.pngdownload.id/20180611/web/kisspng-cardboard-box-computer-icons-5b1e549bbe6db0.87161963152871439578.jpg"
                                        id = "imgItem" class="card-img">
                        </div>
                    </div>
                </div>
            </div>

            <div class = "col-md-9">
                <div class = "d-flex flex-column">
                    <div class = "p-2">NAMA BARANG          : MIC</div>
                </div>
                <div class = "d-flex flex-column">
                    <div class = "p-2">QUANTITY             : 2</div>
                </div>
                <div class = "d-flex flex-column">
                    <div class = "p-2">KETERANGAN           : UNTUK MENGERASKAN SUARA ANDA</div>
                </div>
            </div>

            <div class="accordion" id="detail">
                <div class="accordion-header mt-2 px-2" id="heading1">
                    <button type="button" id="showDetail" class="collapsed detail-item-button bg-warning" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <div class = "p-2">
                            <div style="float: left;margin-bottom: 7px;" class="text-black">C002</div><img src="assets/more.png" style="float:right;"></div>
                    </button>
                </div>
                <div id="collapse1" class="accordion-collapse collapse px-2" aria-labelledby="heading1" data-bs-parent="#detail">
                    <div style="background-color: #D3D3D3;">
                        <div class="px-2 py-2">
                        <table class="table table-sm table-bordered border-dark mt-2 px-1 text-center align-middle" id="tabelDetail">
                            <trn>
                                <th>TANGGAL DIPINJAM</th>
                                <th>TENGGAT PENGEMBALIAN</th>
                                <th>TANGGAL PENGEMBALIAN</th>
                                <th>NAMA PIHAK PEMINJAM</th>
                            </trn>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="accordion" id="detail">
                <div class="accordion-header mt-2 px-2" id="heading1">
                    <button type="button" id="showDetail" class="collapsed detail-item-button bg-warning" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                        <div class = "p-2">
                            <div style="float: left;margin-bottom: 7px;" class="text-black">C002</div><img src="assets/more.png" style="float:right;"></div>
                    </button>
                </div>
                <div id="collapse2" class="accordion-collapse collapse px-2" aria-labelledby="heading1" data-bs-parent="#detail">
                    <div style="background-color: #D3D3D3;">
                        <div class="px-2 py-2">
                        <table class="table table-sm table-bordered border-dark mt-2 px-1 text-center align-middle" id="tabelDetail">
                            <trn>
                                <th>TANGGAL DIPINJAM</th>
                                <th>TENGGAT PENGEMBALIAN</th>
                                <th>TANGGAL PENGEMBALIAN</th>
                                <th>NAMA PIHAK PEMINJAM</th>
                            </trn>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                            <tr>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                                <td>####</td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <div class="container mx-auto d-block text-center">
        <button id="tambahBarang" class="btn btn-warning my-4 px-5" type="button" style="border-radius:20pt">TAMBAH BARANG</button>
    </div>
</body>

</html>