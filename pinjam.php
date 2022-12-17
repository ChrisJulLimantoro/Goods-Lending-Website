<?php
include "user_authen.php";
?>
<?php
    if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['barang'])){
        $sql_count = "SELECT id_borrow FROM borrow ORDER BY id_borrow DESC LIMIT 1";
        $stmt_count = $conn->prepare($sql_count);
        $stmt_count->execute();
        $count = $stmt_count->fetchColumn();
        $count = (int)(substr($count,1));
        echo $count;
        if($count >= 999){
            $code = "B".($count+1);
        }else if($count >= 99){
            $code = "B0".($count+1);
        }else if($count >= 9){
            $code = "B00".($count+1);
        }else{
            $code = "B000".($count+1);
        }
        $sql_borrow = "INSERT INTO borrow(id_borrow,id_user,start_date,expired_date) VALUES(:bor,:usr,:start,:end)";
        $stmt_borrow = $conn->prepare($sql_borrow);
        $stmt_borrow->execute(array(
            ":bor" => $code,
            ":usr" => $_SESSION['user'],
            ":start" => $_POST['start'],
            ":end" => $_POST['end']
        ));
        $_SESSION['bucket'] = $code;
        $sql_input = "INSERT INTO borrow_detail VALUES (:bor,:item,0)";
        $stmt_input = $conn->prepare($sql_input);
        $stmt_input->execute(array(
            ":bor" => $_SESSION['bucket'],
            ":item" => $_POST['barang']
        ));
        exit();
    }
?>
<?php 
    if(isset($_POST['commit_brg'])){
        $sql_insert = "INSERT INTO borrow_detail VALUES (:bor,:item,0)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->execute(array(
            ":bor" => $_SESSION['bucket'],
            ":item" => $_POST['commit_brg']
        ));
        exit();
    }
?>
<?php 
    if(isset($_POST['ajax'])){
        if(isset($_SESSION['nama_brg']) && isset($_SESSION['filter'])){
            if($_SESSION['filter'] == ''){
                $sql_brg = "SELECT * FROM `item` where `Nama_Barang`= :nama and `status`= 1";
                $stmt = $conn->prepare($sql_brg);
                $stmt->execute(array(
                 ":nama" => $_SESSION['nama_brg']
                ));
            }else{
                $sql_brg = "SELECT * FROM `item` where `Nama_Barang`= :nama and `location` = :filter and `status`= 1";
                $stmt = $conn->prepare($sql_brg);
                $stmt->execute(array(
                 ":nama" => $_SESSION['nama_brg'],
                 ":filter" => $_SESSION['filter']
                ));
            }
            $row = $stmt->fetchAll();
            $i = 1;
            if($row){
                foreach($row as $s){
                    echo '<div class="col-12 accordion mt-3" id="accordionExample">';
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="heading'.$i.'">';
                    echo '<button class="accordion-button bg-warning" type="button" data-bs-toggle="collapse" data-bs-target="#acor'.$i.'" aria-expanded="true" aria-controls="panelsStayOpen-collapse'.$i.'">';
                    echo $s['Id'].'</button></h2>';
                    echo '<div id="acor'.$i.'" class="accordion-collapse collapse" aria-labelledby="heading'.$i.'"  data-bs-parent="#accordionExample">';
                    echo '<div class="accordion-body" style="overflow: auto; background-color: #d3d3d3">';
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr class="text-center">';
                    echo '<th scope="col">TANGGAL DIPINJAM</th>';
                    echo '<th scope="col">TENGGAT PENGEMBALIAN</th>';
                    echo '<th scope="col">TANGGAL PENGEMBALIAN</th>';
                    echo '<th scope="col">NAMA PIHAK PEMINJAM</th></tr></thead>';
                    $sql_tbl = "SELECT * FROM `borrow_detail` A JOIN `borrow` B ON `A`.`id_borrow` = `B`.`id_borrow` WHERE id_item = :item ORDER BY `start_date`";
                    $stmt_tbl = $conn->prepare($sql_tbl);
                    $stmt_tbl->execute(array(
                        ':item' => $s['Id']
                    ));
                    $row_tbl = $stmt_tbl->fetchAll();
                    echo '<tbody>';
                    if($row_tbl){
                        foreach($row_tbl as $r){
                            echo '<tr class="text-center">';
                            echo '<td>'.$r['start_date'].'</td>';
                            echo '<td>'.$r['expired_date'].'</td>';
                            if($r['status'] == 2){
                                echo '<td>Batal</td>';
                            }else{
                                echo '<td>'.$r['return_date'].'</td>';
                            }
                            $sql_name = "SELECT CONCAT(first_name,' ',last_name) as 'Nama_user' FROM `user` WHERE username = :user";
                            $stmt_name = $conn->prepare($sql_name);
                            $stmt_name->execute(array(
                                ":user" => $r['id_user']
                            ));
                            $col = $stmt_name->fetchColumn();
                            echo '<td>'.$col.'</td>';
                            echo '</tr>';
                        }
                    }else{
                        echo '<tr class="text-center"><td colspan="4">BELUM PERNAH DIPINJAM</td></tr>';
                    }
                    echo '</tbody></table>';
                    echo '<div class="row mt-3"><div class="col-12 justify-content-center d-flex">';
                    echo '<button type="button" class="btn btn-primary btn-minjam" style="border-radius: 3em; width: 15em;">PINJAM</button></div></div></div></div></div></div>';
                    $i += 1;
                }
            }
            else{
                echo '<h1>Barang Sudah Habis</h1>';
                echo '<button id="toHome" class="btn btn-dark my-4 px-5" type="button" style="border-radius:20pt">Back to Home</button>';
            }
        }else{
            header("Location: homeUser.php");
        }
        exit();
    }
?>
<?php 
    if(isset($_POST['id_brg'])){
        $sql_cek = "SELECT * FROM item WHERE Id = :id";
        $stmt_cek = $conn->prepare($sql_cek);
        $stmt_cek->execute(array(
            ":id" => $_POST['id_brg']
        ));
        $row_cek = $stmt_cek->fetchAll();
        echo $row_cek[0]['Status'];
        exit();
    }
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

        #userImg {
            height: 2em;
            aspect-ratio: 1 / 1;
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

        /* #showDetail {
            width: 100%;
        }

        #showDetail img {
            width: 25px;
        } */

        th {
            background-color: #ffc107 !important;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        tr:nth-child(even) {
            background-color: #ffc107;
        }

        @media screen and (max-width:576px) {
            .table {
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

            // // Button state
            // $(document.body).on("click", "#tambahBarang", function() {
            //     $(this).attr("disabled",true)
            //     $(this).text("MENUNGGU KONFIRMASI...");
            // });

            var bucket = '<?php 
                if(isset($_SESSION['bucket'])){
                    echo 0;
                }else{
                    echo 1;
                    }?>';
            var status = '<?php echo $_SESSION['status'] ?>';
            $.ajax({
                    type : "post",
                    data : {
                        ajax : 1
                    },
                    success : function(response){
                        $("#view").html(response);
                        status = '<?php echo $_SESSION['status'] ?>';
                        bucket = '<?php 
                                if(isset($_SESSION['bucket'])){
                                    echo 0;
                                }else{
                                    echo 1;
                                    }?>';
                    }
                });
            $(document.body).on("click",".btn-minjam",function(){
                let barang = $(this).parent().parent().parent().parent().parent().find(".accordion-header").find(".accordion-button").text();
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                
                $.ajax({
                    type : "post",
                    data : {
                        id_brg :  barang
                    },
                    success : function(e){
                        console.log(e);
                        if(e == 1){
                            if(bucket == 0){
                                swalWithBootstrapButtons.fire({
                                    title: 'Are you sure?',
                                    text: "Do you really want to add item with code "+barang+" to your bucket?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, i do!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                    }).then((result) => {
                                        // console.log(result);
                                        if(result.isConfirmed){
                                            $.ajax({
                                                type : "post",
                                                data : {
                                                    commit_brg : barang
                                                },
                                                success:function(e){
                                                    $.ajax({
                                                        type : "post",
                                                        data : {
                                                            ajax : 1
                                                        },
                                                        success : function(response){
                                                            console.log(parseInt($("#qty").text()));
                                                            $("#qty").text(parseInt($("#qty").text())-1);
                                                            $("#view").html(response);
                                                            status = '<?php echo $_SESSION['status'] ?>';
                                                            bucket = '<?php 
                                                                    if(isset($_SESSION['bucket'])){
                                                                        echo 0;
                                                                    }else{
                                                                        echo 1;
                                                                        }?>';
                                                            $("#window").attr("Location","pinjam.php");
                                                        }
                                                    });
                                                }
                                            })
                                            swalWithBootstrapButtons.fire(
                                                'Success',
                                                'Added 1 item to the bucket!',
                                                'success'
                                            )
                                        }else{
                                            swalWithBootstrapButtons.fire(
                                                'Cancelled',
                                                'Added process cancelled!!',
                                                'error'
                                            )
                                        }
                                    })
                            }else if(bucket == 1){
                                console.log(status);
                                if(status == 1){
                                swalWithBootstrapButtons.fire(
                                    'Error!',
                                    'You can\'t create another bucket if you have already had one or you need to return your item first before set another request!',
                                    'error'
                                )
                                }else{
                                    swalWithBootstrapButtons.fire({
                                    title: 'Are you sure?',
                                    text: "Your bucket is still empty do you want to create a new bucket!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, make new bucket!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            swalWithBootstrapButtons.fire({
                                            title: 'Creating Borrow Bucket : ',
                                            html: `<label for="start_date" class="form-label my-2">Start Borrow Date : </label>
                                                <input type="date" id="start_date" class="swal2_input form-control" placeholder="Borrow Date">
                                                <label for="expired_date" class="form-label my-2">End Borrow Date : </label>
                                                <input type="date" id="expired_date" class="swal2_input form-control" placeholder="Expiration Date">`,
                                            showCancelButton: true,
                                            confirmButtonText: 'Next',
                                            showLoaderOnConfirm: true,
                                            preConfirm: () => {
                                                const sd = $("#start_date").val();
                                                const ed = $("#expired_date").val();
                                                if (!sd || ! ed) {
                                                Swal.showValidationMessage(`Please enter Start Date and Expired Date`)
                                                }
                                                return { sd: sd, ed: ed }
                                            }
                                        }).then((result2) => {
                                            if(`${result2.value.ed}` >= `${result2.value.sd}`){
                                                $.ajax({
                                                    type : "post",
                                                    data : {
                                                        start : `${result2.value.sd}`,
                                                        end : `${result2.value.ed}`,
                                                        barang : barang
                                                    },
                                                    success:function(e){
                                                        $.ajax({
                                                            type : "post",
                                                            data : {
                                                                ajax : 1
                                                            },
                                                            success : function(response){
                                                                // console.log(parseInt($("#qty").text()));
                                                                $("#qty").text(parseInt($("#qty").text())-1);
                                                                $("#view").html(response);
                                                                status = '<?php echo $_SESSION['status'] ?>';
                                                                bucket = '<?php 
                                                                        if(isset($_SESSION['bucket'])){
                                                                            echo 0;
                                                                        }else{
                                                                            echo 1;
                                                                            }?>';
                                                            }
                                                        });
                                                    }
                                                })

                                                swalWithBootstrapButtons.fire(
                                                    'Success',
                                                    'Success creating new Borrow Bucket and added 1 item!',
                                                    'success'
                                                ).then(function(){
                                                    location.reload(true);
                                                })
                                            }else{
                                                swalWithBootstrapButtons.fire(
                                                    'Failed',
                                                    'Failed creating new Borrow Bucket, input date invalid!',
                                                    'error'
                                                )
                                            }
                                        })
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'Your action has been cancelled',
                                        'error'
                                        )
                                    }
                                })
                            }
                        }
                    }else{
                    swalWithBootstrapButtons.fire(
                        'Failed',                  
                        'Barang Sudah diambil orang lain!',
                        'error')
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(response){
                                console.log(parseInt($("#qty").text()));
                                $("#qty").text(parseInt($("#qty").text())-1);
                                $("#view").html(response);
                                status = '<?php echo $_SESSION['status'] ?>';
                                bucket = '<?php 
                                        if(isset($_SESSION['bucket'])){
                                            echo 0;
                                        }else{
                                            echo 1;
                                            }?>';
                            }
                        })
                    }
                }
                })
            });
            $(document.body).on("click","#toHome",function(){
                $(window).attr("location","backToUser.php")
            })
        });
    </script>
</head>

<body>
    <?php 
        $sql_brg2 = "SELECT * FROM item WHERE Nama_Barang = :nama";
        $stmt_brg2 = $conn->prepare($sql_brg2);
        $stmt_brg2->execute(array(
            ":nama" => $_SESSION['nama_brg']
        ));
        $row = $stmt_brg2->fetchAll();
        $img = $row[0]['image'];
        $desc = $row[0]['Deskripsi'];
        if($_SESSION['filter'] == ''){
            $sql_count2 = "SELECT COUNT(*) FROM `item` where `Nama_Barang`= :nama and `status`= 1";
            $stmt_count2 = $conn->prepare($sql_count2);
            $stmt_count2->execute(array(
             ":nama" => $_SESSION['nama_brg']
            ));
        }else{
            $sql_count2 = "SELECT COUNT(*) FROM `item` where `Nama_Barang`= :nama and `location` = :filter and `status`= 1";
            $stmt_count2 = $conn->prepare($sql_count2);
            $stmt_count2->execute(array(
             ":nama" => $_SESSION['nama_brg'],
             ":filter" => $_SESSION['filter']
            ));
        }
        $jum = $stmt_count2->fetchColumn();
    ?>

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
        </div>
    </nav>

    <h1 class='text-light mt-5 px-5'>PEMINJAMAN BARANG</h1>
    <div class='container-fluid py-4' style='background-color:#d3d3d3; min-height: 73vh'>
    
    <div class = "container">
        <a type="button" class="btn btn-warning" href = "homeUser.php">KEMBALI</a>
    </div>

    <div class = "container" style = "background-color:#D3D3D3">
        <div class="row mt-4 px-5 py-5 bg-light" id=''>
            <div class = "col-md-3">
                <div class = "row justify-content-center">
                    <div class="col-md-11">
                        <div class = "card img">
                            <img src="<?php echo $img ?>" alt="" style="width: 100%; height: 100%;">
                        </div>
                    </div>
                </div>
            </div>

            <div class = "col-md-9">
                <div class = "d-flex flex-column">
                    <div class = "p-2">NAMA BARANG : <?php echo $_SESSION['nama_brg']?></div>
                </div>
                <div class = "d-flex flex-column">
                    <div class = "p-2"><?php echo $desc ?></div>
                </div>
                <div class = "d-flex flex-column">
                    <div class = "p-2">STOCK : <?php echo $jum?></div>
                </div>
                
            </div>

            <div class="row mt-3 justify-content-center text-center" id="view">

            </div>
        </div>
    </div>
</body>
</html>