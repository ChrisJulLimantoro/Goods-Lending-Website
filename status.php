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
            echo '<div class="row mt-5 px-3 py-4 bg-dark text-light">
                    <div class="col-12">
                        <div class="row">
                            <h3 class="col-md-3 col-12" id="namaItem">'.$rb['id_borrow'].'</h3>
                            <h5 class="col-md-6 col-12" id="keteranganItem">'.$rb['start_date'].' / '.$rb['expired_date'].'</h5>
                            <h3 class="col-md-3 col-12" id="qtyItem">'.$status.'</h3>
                        </div>
                    </div>
                    <!-- Detail item -->
                    <div class="accordion" id="detail">
                        <div class="accordion-header mt-2" id="heading'.$ct.'">
                            <button type="button" id="showDetail" class="collapsed detail-item-button" data-bs-toggle="collapse" data-bs-target="#collapse'.$ct.'" aria-expanded="true" aria-controls="collapse'.$ct.'">
                                <img src="assets/more.png">
                            </button>
                        </div>
                        <div id="collapse'.$ct.'" class="accordion-collapse collapse" aria-labelledby="heading'.$ct.'" data-bs-parent="#detail">
                            <table class="table table-sm table-dark table-bordered border-light mt-3 text-center align-middle" id="tabelDetail">
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
            echo '</tbody></table></div></div></div>';
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
            min-height:;
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
    
    <!-- Navbar -->
    <div class="container-fluid bg-dark text-white header sticky-top">
        <div class="row px-lg-3" style="margin: 0">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-lg-2 col-3 d-flex justify-content-start text-center">   
                    <a class="navbar-brand" href="homeUser.php">STATUS</a>
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
    <div class="container-fluid detail-box" id="view">
        <!-- Item card -->
        
    </div>
</body>
</html>