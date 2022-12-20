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
                        <div id="collapse'.$ct.'" class="accordion-collapse collapse px-4" aria-labelledby="heading'.$ct.'" data-bs-parent="#detail">
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
                if($rd['id_item'] != null){
                    $sql_brg = "SELECT * FROM item WHERE Id = :item";
                    $stmt_brg = $conn->prepare($sql_brg);
                    $stmt_brg->execute(array(
                        ":item" => $rd['id_item']
                    ));
                    $row_brg = $stmt_brg->fetchAll();
                    echo    '<tr>
                                <td class="kodeBrg">'.$rd['id_item'].'</td>
                                <td class="namaBrg">'.$row_brg[0]['Nama_Barang'].'</td>
                                <td class="lokasiBrg">'.$row_brg[0]['Location'].'</td>
                                <td class="statusBrg">'.$status_brg.'</td>
                            </tr>';
                }else{
                    echo    '<tr>
                                <td class="kodeBrg">XXXXX</td>
                                <td class="namaBrg">Barang telah dihapus</td>
                                <td class="lokasiBrg">X</td>
                                <td class="statusBrg">'.$status_brg.'</td>
                            </tr>';
                }
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

    <?php include "navbarUser.php" ?>

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
            background-color: #e9ab59;
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
            background-color: #e9ab59 !important;
        }

        tr:nth-child(odd) {
            background-color: #d3d3d3;
            font-weight: 300;
        }

        tr:nth-child(even) {
            background-color: #e9ab59;
            font-weight: 300;
        }

        #inputSearch {
            display: none;
        }

        #search-btn{
            display: none;
        }
        @media screen and (max-width:576px) {
            .table, #namaItem, #keteranganItem, #qtyItem {
                font-size: .75em;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
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
    <div class='container d-flex align-items-end' style='min-height:25vh'>
        <h1 class='text-light'>STATUS PEMINJAMAN</h1>
    </div>

    <div class='container-fluid py-4' style='background-color:#d3d3d3; min-height: 75vh'>
        <div class = "container">
            <a type="button" class="btn w-100" href = "homeUser.php" style='background-color: #e9ab59'>KEMBALI</a>
        </div>

        <div class="container container-custom justify-content-center" id='view'>
        </div>
    </div>
</body>

</html>