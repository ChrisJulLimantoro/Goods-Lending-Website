<?php
include "user_authen.php";
?>
<?php
    if(isset($_POST['ajax'])){
        $sql_bor = "SELECT * FROM borrow WHERE id_user = :user ORDER BY id_borrow DESC";
        $stmt_bor = $conn->prepare($sql_bor);
        $stmt_bor->execute(array(
            ":user" => $_SESSION['user']
        ));
        $row_bor = $stmt_bor->fetchAll();
        $ct = 1;
        foreach($row_bor as $rb){
            if($rb['status_pinjam'] == 0){
                $status = 'Draft';
            }else if($rb['status_pinjam'] == 1){
                $status = 'On Progress';
            }else if($rb['status_pinjam'] == 2){
                $status = 'Selesai';
            }
            $start_date = date_create($rb['start_date']);
            $start_date = date_format($start_date, "d/m/Y");
            $expr_date = date_create($rb['expired_date']);
            $expr_date = date_format($expr_date, "d/m/Y");
            echo '<div class="row mt-5 py-4 bg-light text-dark justify-content-center">
                    <div class="row text-center">
                        <h3 class="col-md-3 col-12" id="namaItem">'.$rb['id_borrow'].'</h3>
                        <h5 class="col-md-6 col-12" id="keteranganItem">'.$start_date.' - '.$expr_date.'</h5>
                        <h3 class="col-md-3 col-12" id="qtyItem">'.$status.'</h3>
                    </div>
                    </div>
                    <!-- Detail item -->
                    <div class="row">
                    <div class="accordion" id="detail">
                        <div class="accordion-header" id="heading'.$ct.'">
                            <button type="button" id="showDetail" class="collapsed detail-item-button" data-bs-toggle="collapse" data-bs-target="#collapse'.$ct.'" aria-expanded="true" aria-controls="collapse'.$ct.'">
                                <img src="assets/more.png">
                            </button>
                        </div>
                        <div id="collapse'.$ct.'" class="accordion-collapse collapse px-lg-4" aria-labelledby="heading'.$ct.'" data-bs-parent="#detail">
                            <div class="table-responsive">
                            <table class="table table-bordered mt-3 text-center align-middle" id="tabelDetail">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Status Barang</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $sql_det = "SELECT * FROM borrow_detail WHERE id_borrow = :bor";
            $stmt_det = $conn->prepare($sql_det);
            $stmt_det->execute(array(
                ":bor" => $rb['id_borrow']
            ));
            $row_det = $stmt_det->fetchAll();
            foreach($row_det as $rd){
                $sql_brg = "SELECT * FROM item WHERE Id = :item";
                $stmt_brg = $conn->prepare($sql_brg);
                $stmt_brg->execute(array(
                    ":item" => $rd['id_item']
                ));
                $row_brg = $stmt_brg->fetchAll();
                if($rd['status'] == 0){
                    $status_brg = 'Menunggu Verifikasi';
                }else if($rd['status'] == 1){
                    $status_brg = 'Diterima';
                }else if($rd['status'] == 2){
                    $status_brg = 'Ditolak';
                }else if($rd['status'] == 3){
                    $status_brg = 'Barang di User';
                }else if($rd['status'] == 4){
                    $status_brg = 'Telah Dikembalikan';
                }
                echo    '<tr>
                            <td class="kodeBrg">'.$rd['id_item'].'</td>
                            <td class="namaBrg">'.$row_brg[0]['Nama_Barang'].'</td>
                            <td class="lokasiBrg">'.$row_brg[0]['Location'].'</td>
                            <td class="statusBrg">'.$status_brg.'</td>
                        </tr>';
            } 
            echo '</tbody></table></div></div></div></div></div>';
            $ct += 1;
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
    <title>STATUS PEMINJAMAN</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');

        body {
            font-family: 'Russo One', sans-serif;
            font-weight: 700;
            overflow-y: scroll;
            letter-spacing: 1px;
            background: url(assets/gedungQ2.jpg) fixed no-repeat;
            background-size: cover;
        }

        /* Navbar style */
        .navbar {
            background-color: rgba(0, 0, 0, .5);
            color: #fff;
        }

        .fa-cart-shopping, .fa-clock-rotate-left {
            color: #fff;
        }

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
        .accordion, .accordion-item {
            background-color: #f8f9fa;
            color: #fff;
            border: none;
            padding: 0;
            margin: 0;
        }

        .accordion-header, .detail-item-button {
            background-color: #ffc107;
            border: none;
            height: 40px;
            width: 100%;
        }

        #showDetail {
            width: 100%;
        }

        #showDetail img {
            width: 25px;
        }

        th {
            background-color: #ffc107 !important;
        }

        tr:nth-child(odd) {
            background-color: #d3d3d3;
        }

        tr:nth-child(even) {
            background-color: #ffc107;
        }

        @media screen and (max-width:576px) {
            .table, #namaItem, #keteranganItem, #qtyItem {
                font-size: .75em;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            // // Animasi tombol
            // $(document.body).on("click", "#showDetail", function() {
            //     $(this).find("img").css("transition", "all .5s ease");

            //     if ($(this).find("img").css("transform") != "none")
            //         $(this).find("img").css("transform", "none");
            //     else
            //         $(this).find("img").css("transform", "rotate(180deg)");
            // });

            $.ajax({
                type : "post",
                data : {
                    ajax : 1
                },
                success : function(response){
                    $("#view").html(response);
                }
            })
            
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
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark px-3 px-md-5 py-md-3">
        <a class="navbar-brand" href="homeUser.php">UPPK UK. PETRA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 me-3 mb-lg-0">
                <li class="nav-item me-3">
                    <a href='status.php' class="nav-link">
                        <i class="fa-solid fa-clock-rotate-left fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a href="keranjang.php" class='nav-link'>
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div style="width: 5em; display:!important inline, position:!important absolute" class="user">
            <div class="dropdown" style="list-style: none; width: 3em;">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $_SESSION['profile'] ?>" alt="" style="width: 3em; height: 3em; border-radius: 50%" id='imgItem'>
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
    </nav>


    <h1 class='text-light mt-5 px-5'>STATUS PEMINJAMAN</h1>
    <div class='container-fluid py-4' style='background-color:#d3d3d3; min-height: 73vh'>
    
    <div class = "container">
        <a type="button" class="btn btn-warning" href = "homeUser.php">KEMBALI</a>
    </div>

    <div class="container container-custom justify-content-center" id='view'>
        <!-- <div class="row mt-4 px-2 py-3">
            <div class="col-md-3">
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="p-2">
                            ID PEMINJAMAN
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-column text-center">
                    <div class="p-2">22-07-2022 / 28-07-2022</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-2">
                    <button type="button" style="float:right;" id="showDetail" class="collapsed detail-item-button bg-light" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <img src="assets/more.png">
                    </button>
                </div>
            </div>
        </div>
        <div id="collapse1" class="accordion-collapse collapse row mt-1 mx-2" aria-labelledby="heading1" data-bs-parent="#detail">
            <div>
                <div class="px-1 py-1">
                    <table class="table table-sm table-bordered border-dark mt-2 px-1 py-1 text-center align-middle" id="tabelDetail">
                        <trn>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>LOKASI</th>
                        </trn>
                        <tr>
                            <td>P001</td>
                            <td>MIC</td>
                            <td>P</td>
                        </tr>
                        <tr>
                            <td>W001</td>
                            <td>HT</td>
                            <td>W</td>
                        </tr>
                        <tr>
                            <td>T002</td>
                            <td>MEJA</td>
                            <td>T</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
</body>

</html>