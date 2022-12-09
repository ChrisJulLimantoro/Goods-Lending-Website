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
        if($count > 999){
            $code = "B".($count+1);
        }else if($count > 99){
            $code = "B0".($count+1);
        }else if($count > 9){
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
                    echo '<div class="accordion" id="accordionPanelsStayOpenExample">';
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="panelsStayOpen-heading'.$i.'">';
                    echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acor'.$i.'" aria-expanded="true" aria-controls="panelsStayOpen-collapse'.$i.'">';
                    echo $s['Id'].'</button></h2>';
                    echo '<div id="acor'.$i.'" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading'.$i.'">';
                    echo '<div class="accordion-body" style="overflow: auto;">';
                    echo '<table class="table">';
                    echo '<thead><tr class="table-dark text-center">';
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
    <title>Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <style>
        .card {
        overflow: visible;
        position: relative;
        background: #647C90;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .2);
        border-radius: 1px;
        }

        .card:before, .card:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        background: #E2DED0;
        transition: 0.5s;
        z-index: -99;
        }

        .details {
        position: absolute;
        left: -10px;
        right: 0;
        bottom: 5px;
        height: 60px;
        text-align: center;
        text-transform: uppercase;
        }

        /*Image*/
        .imgbox {
        position: absolute;
        top: 10px;
        left: 10px;
        bottom: 10px;
        right: 10px;
        background: #E2DED0;
        transition: 0.5s;
        z-index: 1;
        }

        .img {
        background: #4C555D;
        background-image: linear-gradient(45deg, #4158D0, #C850C0);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }

        /*Hover*/
        .card:hover .imgbox {
        bottom: 80px;
        }

        .card:hover:before {
        transform: rotate(20deg);
        }

        .card:hover:after {
        transform: rotate(10deg);
        box-shadow: 0 2px 20px rgba(0, 0, 0, .2);
        }
    </style>
    <script>
        $(document).ready(function(){
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
        })
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
    <div class="container-fluid bg-dark">
        <div class="row">

            <div class="col-1">
                <button class="bg-dark" style="border: none">
                    <a href="homeUser.php">
                        <img src="back.png" alt="" style="height: 2em;">
                    </a>
                </button>
            </div>

            <div class="col-11 d-flex justify-content-center" style="padding-right: 10em;">
                <h4 class="text-white">
                    <a class="navbar-brand title text-white" href="backToUser.php">PEMINJAMAN BARANG</a>
                </h4> 
            </div>
        </div>
    </div>


    <div class="row mt-5 start-50 justify-content-center mx-5 px-5" >
        <div class="col-lg-3 col-12">
            <div class="card" style="width: 16rem; height: 18rem; border:none;">
                <div class="imgbox">
                    <div class="img">
                        <img src="<?php echo $img ?>" alt="" style="width: 100%; height: 100%;">
                    </div>
                </div>
                <div class="details">
                    <h2 class="title text-white" style="font-size: 30px;" id="card-detail"><?php echo $_SESSION['nama_brg'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-12 mx-2" style="padding-left: 3em;">
            <div class="row">
                <div class="col-6">
                    <h3>Nama: </h3>
                    <h3><?php echo $_SESSION['nama_brg']?></h3>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h3>Quantity: </h3>
                    <h3 id="qty"><?php echo $jum?></h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h3>Keterangan: </h3>
                    <h3><?php echo $desc ?></h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5 start-50 justify-content-center mx-5 px-5 detail-box text-center" id="view">

    </div>
</body>
</html>