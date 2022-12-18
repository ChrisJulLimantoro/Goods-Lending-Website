<?php 
    include "user_authen.php";    
?>
<?php 
    if(isset($_POST['start']) && isset($_POST['end'])){
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
            echo $code;
        $sql_borrow = "INSERT INTO borrow(id_borrow,id_user,start_date,expired_date) VALUES(:bor,:usr,:start,:end)";
        $stmt_borrow = $conn->prepare($sql_borrow);
        $stmt_borrow->execute(array(
            ":bor" => $code,
            ":usr" => $_SESSION['user'],
            ":start" => $_POST['start'],
            ":end" => $_POST['end']
        ));
        $_SESSION['bucket'] = $code;
        exit();
        }
?>
<?php
    if(isset($_POST['pinjam'])){
        $sql_change = "UPDATE borrow SET status_pinjam = 1 WHERE id_borrow = :bor";
        $stmt_change = $conn->prepare($sql_change);
        $stmt_change->execute(array(
            ":bor" => $_SESSION['bucket']
        ));
        unset($_SESSION['bucket']);
        $_SESSION['status'] = 1;
        echo '<a href="homeUser.php"><button id="backToHome" class="btn btn-dark my-4 px-5 w-100" type="button" style="border-radius:20pt">Pesanan telah diajukan</button></a>';
        exit();
    }
?>
<?php
    if(isset($_POST['verif'])) {
        $sql_verif = "SELECT count(*) as total FROM `user` WHERE `username` = :username and `password` = PASSWORD( :password )";
        $user = $_SESSION['user'];
        $pass = $_POST['verif'];
        $stmt = $conn->prepare($sql_verif);
        $stmt->execute(array(':username' => $user,
                            ':password' => $pass));
        $row = $stmt->fetch();
        if($row['total'] == 0){
            echo 0;
        }
        else {
            echo 1;
        }
        exit();
    }
   
?>
<?php
    if(isset($_POST['ajax'])){
        if(isset($_SESSION['bucket'])){
            $sql_tgl = "SELECT * FROM `borrow` WHERE `id_borrow` = :bor";
            $stmt_tgl = $conn->prepare($sql_tgl);
            $stmt_tgl->execute(array(
                ":bor" => $_SESSION['bucket']
            ));
            $row_tgl = $stmt_tgl->fetchAll();
            $tgl_start = date_create($row_tgl[0]['start_date']);
            $tgl_start = date_format($tgl_start, "d/m/Y");
            $tgl_end = date_create($row_tgl[0]['expired_date']);
            $tgl_end = date_format($tgl_end, "d/m/Y");
            echo '<div class="row bg-light d-flex justify-content-center align-items-center p-4 mt-4">';
            echo '<p> START : '.$tgl_start.'</p>';
            echo '<p> EXPIRED : '.$tgl_end.'</p></div>';
            $sql_brg = "SELECT `Nama_Barang`,COUNT(*) as 'count',`Deskripsi`,`image` FROM `borrow_detail` JOIN `item` ON `id_item` = `Id` WHERE `id_borrow` = :bor GROUP BY `Nama_Barang`";
            $stmt_brg = $conn->prepare($sql_brg);
            $stmt_brg->execute(array(
                ":bor" => $_SESSION['bucket']
            ));
            $row_brg = $stmt_brg->fetchAll();
            $row_count = 0;
            foreach($row_brg as $r){
                echo '<div class="row mt-5 px-3 py-4 bg-light text-dark">';
                echo '<div class="col-lg-3 col-5">';
                echo '<img src="'.$r['image'].'" id="imgItem"></div>';
                echo '<div class="col-lg-8 col-5">';
                echo '<h3 id="namaItem">Nama Barang: '.$r['Nama_Barang'].'</h3>';
                echo '<h5 id="keteranganItem">'.$r['Deskripsi'].'</h5>';
                echo '<h3 id="qtyItem">Quantity: '.$r['count'].'</h3></div>';
                echo '<div class="col-1 justify-content-end">';
                echo '<button type="button" id="deleteAll" class="btn-close btn-delete-all"></button></div></div>';
                echo '<div class="row">';
                echo '<div class="accordion" id="detail">';
                echo '<div class="accordion-header" id="heading1">';
                echo '<button type="button" id="showDetail" class="collapsed detail-item-button showDetail" data-bs-toggle="collapse" data-bs-target="#collapse'.($row_count+1).'" aria-expanded="true" aria-controls="collapse'.($row_count+1).'">';
                echo '<img src="assets/more.png"></button></div>';
                echo '<div id="collapse'.($row_count+1).'" class="accordion-collapse collapse" aria-labelledby="heading'.($row_count+1).'" data-bs-parent="#detail">';
                echo '<div class="table-responsive px-4"><table class="table table-bordered my-4 text-center align-middle" id="tabelDetail">';
                echo '<thead><tr><th>Kode</th><th>Lokasi</th><th>Aksi</th></tr></thead>';
                for($i=0;$i<$r['count'];$i++){
                    $sql_temp = "SELECT * FROM `borrow_detail` JOIN `item` ON `id_item` = `Id` WHERE `id_item` = ANY (SELECT `Id` FROM `item` WHERE `Nama_Barang` = :nm)";
                    $stmt_temp = $conn->prepare($sql_temp);
                    $stmt_temp->execute(array(
                        ":nm" => $r['Nama_Barang']
                    ));
                    $row_temp = $stmt_temp->fetchAll();
                    echo '<tr><td class="kodeBrg">'.$row_temp[$i]['id_item'].'</td>';
                    echo '<td class="lokasiBrg">'.$row_temp[$i]['Location'].'</td>';
                    echo '<td><button type="button" id="deleteOne" class="btn-close btn-delete-one"></button></td>';
                    echo '</tr>';
                }
                echo '</table></div></div></div></div>';
                $row_count += 1;
            }
            if($row_count > 0){
                echo '<button id="pinjamBarang" class="btn btn-dark my-4 w-100" type="button" style="border-radius:20pt">Ajukan Peminjaman</button>';
            }else{
                echo '<a href="homeUser.php" ><button class="btn btn-dark my-4 w-100" type="button" style="border-radius:20pt">Lihat Barang</button></a>';
            }
        }else{
            if($_SESSION['status'] == 1){
                echo '<h1 class="text-center mt-5">Barang Pinjaman belum dikembalikan!</h1>';
                echo '<h2 class="text-center">Harap Kembalikan Barang pinjaman terlebih dahulu baru anda dapat membuat keranjang baru!</h2>';
                echo '<a href="homeUser.php"><button class="btn btn-dark my-4 px-5 w-100" type="button" style="border-radius:20pt">Back to Home</button></a>';
            }else{
                echo '<h1 class="text-center mt-5">Keranjang Masih Kosong!</h1>';
                echo '<button id="createBucket" class="btn btn-dark my-4 px-5 w-100" type="button" style="border-radius:20pt">Buat Keranjang Baru</button>';
            }
        }
        // echo var_dump($_SESSION);
        exit();
    }
?>
<?php
    if(isset($_POST['hapusAll'])){
        $sql_up = "UPDATE `item` SET `Status` = 1 WHERE `Id` = ANY (SELECT `id_item` FROM `borrow_detail` WHERE id_borrow = :bor and id_item = ANY (SELECT Id FROM `item` WHERE nama_barang = :nama))";
        $stmt_up = $conn->prepare($sql_up);
        $stmt_up->execute(array(
            ":bor" => $_SESSION['bucket'],
            ":nama" => $_POST['hapusAll']
        ));
        $sql_del_all = "DELETE FROM `borrow_detail` WHERE id_borrow = :bor and id_item = ANY (SELECT Id FROM `item` WHERE nama_barang = :nama)";
        $stmt_del_all = $conn->prepare($sql_del_all);
        $stmt_del_all->execute(array(
            ":bor" => $_SESSION['bucket'],
            ":nama" => $_POST['hapusAll']
        ));
        exit();
    }
?>
<?php
    if(isset($_POST['hapus'])){
        $sql_up2 = "UPDATE `item` SET `Status` = 1 WHERE `Id` = :id";
        $stmt_up2 = $conn->prepare($sql_up2);
        $stmt_up2->execute(array(
            ":id" => $_POST['hapus']
        ));
        $sql_del_all2 = "DELETE FROM `borrow_detail` WHERE id_borrow = :bor and id_item = :id";
        $stmt_del_all2 = $conn->prepare($sql_del_all2);
        $stmt_del_all2->execute(array(
            ":bor" => $_SESSION['bucket'],
            ":id" => $_POST['hapus']
        ));
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');

        body {
            font-family: 'Russo One', sans-serif;
            font-weight: 400;
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
        /* .detail-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }

        .detail-box > div {
            border-radius: 20pt;
            width: 100%;
            transition: all .5s ease-in-out;
        } */

        /* .detail-box > div:hover {
            box-shadow: 0 0 30px #aaa;
        } */

        #namaItem, #qtyItem, #keteranganItem {
            font-size: 1.25em;
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
            height: 50px;
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
            $.ajax({
                type : "post",
                data : {
                    ajax : 1
                },
                success : function(response){
                    $("#view").html(response);
                }
            })
            // Delete per JENIS item
            $(document.body).on("click", ".btn-delete-all", function() {
                let name = $(this).parent().parent().find('.col-lg-8').find('#namaItem').text().substring(13);
                $.ajax({
                    type : "post",
                    data : {
                        hapusAll : name
                    },
                    success : function(response){
                        console.log("sukses");
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(response){
                                $("#view").html(response);
                            }
                        });
                    }
                });
            });

            // Delete per item
            $(document.body).on("click", ".btn-delete-one", function() {
                // $(this).parent().parent().remove();
                let idOne = $(this).parent().parent().find(".kodeBrg").text();
                $.ajax({
                    type : "post",
                    data : {
                        hapus : idOne
                    },
                    success : function(response){
                        console.log("sukses");
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(response){
                                $("#view").html(response);
                            }
                        });
                    }
                });
            });
            
            // Animasi tombol
            $(document.body).on("click", ".showDetail", function() {
                $(this).find("img").css("transition", "all .5s ease");

                if ($(this).find("img").css("transform") != "none")
                    $(this).find("img").css("transform", "none");
                else
                    $(this).find("img").css("transform", "rotate(180deg)");
            });
            // ajax create new bucket
            var status = '<?php echo $_SESSION['status']?>'
            $(document.body).on("click","#createBucket",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                if(status == 1){
                    swalWithBootstrapButtons.fire(
                        'Error!',
                        'You can\'t create another bucket if you have already had one or you need to return your item first before set another request!',
                        'error'
                    )
                }else{
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "Do You wish to create a new bucket?!",
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
                                        },
                                        success:function(e){
                                            console.log(e);
                                            $.ajax({
                                                type : "post",
                                                data : {
                                                    ajax : 1
                                                },
                                                success : function(response){
                                                    $("#view").html(response);
                                                }
                                            })
                                        }
                                    })

                                    swalWithBootstrapButtons.fire(
                                        'Success',
                                        'Success creating new Borrow Bucket and added 1 item!',
                                        'success'
                                    )
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
            });
            // ajax ajukan pinjaman
            $(document.body).on("click","#pinjamBarang",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title : "Enter your password",
                    html : "<input type='password' class='form-control' name='verif' id='verif'>",
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const pass = $("#verif").val();
                        if (!pass) {
                        Swal.showValidationMessage(`Please enter a valid password!`)
                        }
                        return { pass: pass }
                    }
                })
                .then((result) => {
                    $.ajax ({
                        type : "post",
                        data : {
                            verif : `${result.value.pass}`
                        },
                        success : function(e) {
                            if (e == 1) {
                                $.ajax({
                                    type : "post",
                                    data : {
                                        pinjam : 1
                                    },
                                    success : function(e){
                                        // console.log('sukses');
                                        $("#view").html(e);
                                    }
                                });
                                
                                swalWithBootstrapButtons.fire ({
                                    icon : "success",
                                    title : "Success!",
                                    text : "Verification Succeed!"
                                })
                            }
                            else {
                                swalWithBootstrapButtons.fire ({
                                    icon : "error",
                                    title : "Failed!",
                                    text : "Wrong Password!"
                                })
                            }
                        }
                    })
                })
            });
        });
    </script>
</head>
<body>
    
    <!-- Navbar -->
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
    
    <h1 class='text-light mt-5 px-5'>KERANJANG</h1>
    <div class='container-fluid py-4' style='background-color:#d3d3d3; min-height: 73vh'>
    
    <div class = "container">
        <a type="button" class="btn btn-warning" href = "homeUser.php">KEMBALI</a>
    </div>

    <div class="container container-custom justify-content-center" id='view'>

    <!-- Main content -->
    <div class="container-fluid mt-4" id="view">
    </div>
</body>
</html>