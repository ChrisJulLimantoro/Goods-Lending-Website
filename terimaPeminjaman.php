<?php
    include "admin_authen.php";
?>
<?php
    // if(isset($_POST['ajax'])){
    //     $sql_ajax = "SELECT * FROM borrow_detail a JOIN borrow b on a.id_borrow = b.id_borrow WHERE status_pinjam <> 0 and status = 0 ORDER BY a.id_borrow";
    //     $stmt_ajax = $conn->prepare($sql_ajax);
    //     $stmt_ajax->execute();
    //     $row_ajax = $stmt_ajax->fetchAll();
    //     $count = 1;
    //     if($row_ajax){
    //         foreach($row_ajax as $r){
    //             echo '<tr><td class="count">'.$count.'</td>';
    //             echo '<td class="kode_brg">'.$r['id_item'].'</td>';
    //             echo '<td class="kode_bor" style="display:none">'.$r['id_borrow'].'</td>';
    //             echo '<td class="kode_org" style="display:none">'.$r['id_user'].'</td>';
    //             $sql_brg = "SELECT Nama_Barang FROM item WHERE Id = :id";
    //             $stmt_brg = $conn->prepare($sql_brg);
    //             $stmt_brg->execute(array(
    //                 ":id" => $r['id_item']
    //             ));
    //             $nm_brg = $stmt_brg->fetchcolumn();
    //             echo '<td class="namaBrg">'.$nm_brg.'</td>';
    //             $sql_org = "SELECT CONCAT(first_name,' ',last_name) AS 'name',email FROM user WHERE username = :id";
    //             $stmt_org = $conn->prepare($sql_org);
    //             $stmt_org->execute(array(
    //                 ":id" => $r['id_user']
    //             ));
    //             $nm_org = $stmt_org->fetchAll();
    //             echo '<td class="peminjam">'.$nm_org[0]['name'].'</td>';
    //             echo '<td class="email" style="display:none">'.$nm_org[0]['email'].'</td>';
    //             echo '<td class="tglPinjam">'.$r['start_date'].'</td>';
    //             echo '<td class="tglKembali">'.$r['expired_date'].'</td>';
    //             echo '<td> <button type="button" class="btn btn-success btn-acc" style="width:70px">Terima</button>
    //                         <button type="button" class="btn btn-danger btn-cnc" style="width:70px">Tolak</button>
    //                 </td></tr>';
    //                 $count++;
    //         }
    //     }else{
    //         echo '<tr><td colspan="7" class ="text-center"><strong>Tidak ada pending request</strong></td></tr>';
    //     }
    //     exit();
    // }
?>
<?php
    if(isset($_POST['ajax'])){
        $sql_ajax = "SELECT * FROM borrow_detail a JOIN borrow b on a.id_borrow = b.id_borrow WHERE status_pinjam <> 0 and status = 0 ORDER BY a.id_borrow";
        $stmt_ajax = $conn->prepare($sql_ajax);
        $stmt_ajax->execute();
        $row_ajax = $stmt_ajax->fetchAll();
        $count = 1;
        $arr = array();
        if($row_ajax){
            foreach($row_ajax as $r){
                $temp = array();
                array_push($temp,$count);
                array_push($temp,$r['id_item']);
                array_push($temp,$r['id_borrow']);
                array_push($temp,$r['id_user']);
                $sql_brg = "SELECT Nama_Barang FROM item WHERE Id = :id";
                $stmt_brg = $conn->prepare($sql_brg);
                $stmt_brg->execute(array(
                    ":id" => $r['id_item']
                ));
                $nm_brg = $stmt_brg->fetchcolumn();
                array_push($temp,$nm_brg);
                $sql_org = "SELECT CONCAT(first_name,' ',last_name) AS 'name' FROM user WHERE username = :id";
                $stmt_org = $conn->prepare($sql_org);
                $stmt_org->execute(array(
                    ":id" => $r['id_user']
                ));
                $nm_org = $stmt_org->fetchAll();
                array_push($temp,$nm_org[0]['name']);
                array_push($temp,$r['start_date']);
                array_push($temp,$r['expired_date']);
                array_push($arr,$temp);
                $count += 1;
            }
            $json = json_encode($arr);
            echo $json;
        }
        exit();
    }
?>
<?php 
    if(isset($_POST['bor']) && isset($_POST['brg']) && isset($_POST['stu']) && isset($_POST['org'])){
        $sql_up = "UPDATE borrow_detail SET status = :stu WHERE id_borrow = :bor and id_item = :brg";
        $stmt_up = $conn->prepare($sql_up);
        $stmt_up->execute(array(
            ":stu" => $_POST['stu'],
            ":bor" => $_POST['bor'],
            ":brg" => $_POST['brg']
        ));
        if($_POST['stu'] == 2){
            $sql_res = "UPDATE item SET status = 1 WHERE Id = :brg";
            $stmt_res = $conn->prepare($sql_res);
            $stmt_res->execute(array(
                ":brg" => $_POST['brg']
            ));
            $sql_cek = "SELECT status FROM borrow_detail WHERE id_borrow = :bor";
            $stmt_cek = $conn->prepare($sql_cek);
            $stmt_cek->execute(array(
                ":bor" => $_POST['bor']
            ));
            $row_cek = $stmt_cek->fetchAll();
            $sql_jum = "SELECT count(*) FROM borrow_detail WHERE id_borrow = :bor";
            $stmt_jum = $conn->prepare($sql_jum);
            $stmt_jum->execute(array(
                ":bor" => $_POST['bor']
            ));
            $row_jum = $stmt_jum->fetchColumn();
            $checker = 0;
            foreach($row_cek as $rc){
                if($rc['status'] == 2){
                    $checker += 1;
                }
            }
            if($checker == $row_jum){
                $sql_user = "UPDATE user SET status = 0 WHERE username = :user";
                $stmt_user = $conn->prepare($sql_user);
                $stmt_user->execute(array(
                    ":user" => $_POST['org']
                ));
                $sql_bor = "UPDATE borrow SET status_pinjam = 2 WHERE id_borrow = :bor";
                $stmt_bor = $conn->prepare($sql_bor);
                $stmt_bor->execute(array(
                    ":bor" => $_POST['bor']
                ));
            }
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
    <title>Terima Peminjaman</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- DataTable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <?php include "navbarAdmin.php"; ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            background: url('assets/gedungQ2.jpg') fixed no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        /* Main */
        #requests {
            font-weight: 400;
        }

        .fa-angle-left {
            color: #fff;
            height: 30px;
            transition: all .3s ease;
        }

        .fa-angle-left:hover {
            transform: scale(1.15);
        }

        /* DataTable */
        div.dataTables_filter > label > input, .dataTables_length select, .dataTables_wrapper, .paginate_button {
            color: #fff;
        }

        div.dataTables_filter > label > input:focus, .dataTables_length select:focus {
            outline: 1px solid #fff;
        }

        div.dataTables_filter > label  {
            color: #fff;
            margin-bottom: 20px;
        }

        .dataTables_length select > option { 
            color: #000;
        }

        .dt-head-center {text-align: center;}

        @media screen and (max-width: 576px) {
            #request-list th, #request-list td, #request-list button {
                font-size: .75em;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#request-list").removeAttr("width").DataTable({
                "language": {
                    "paginate": {
                        "next": "<span class='text-light'>Next</span>",
                        "previous": "<span class='text-light'>Previous</span>"
                    }
                },
                ajax : {
                    processing: true,
                    serverSide: true,
                    url : "terimaPeminjaman.php",
                    dataSrc : "",
                    type : "post",
                    data : {
                        ajax : 1
                    }
                },
                columns : [
                    {data : 0},
                    {data : 1},
                    {data : 2},
                    {data : 3},
                    {data : 4},
                    {data : 5},
                    {data : 6},
                    {data : 7},
                    {data : null,
                    "render" : function(data,type,row){
                        return '<button type="button" class="btn btn-success btn-acc" style="width:70px">Terima</button>' +
                        '<button type="button" class="btn btn-danger btn-cnc" style="width:70px">Tolak</button>'
                    }}
                ],
                columnDefs: [
                    {
                        target: 2,
                        visible: false,
                        searchable: false,
                        width : "0"
                    },
                    {
                        target: 3,
                        visible: false,
                        searchable: false,
                        width : "0"
                    },
                    { width : "5%" , targets : 0},
                    { width : "10%" , targets : 1},
                    { width : "15%" , targets : 4},
                    { width : "15%" , targets : 5},
                    { width : "15%" , targets : 6},
                    { width : "15%" , targets : 7},
                    { width : "25%" , targets : 8}
                ],
                    fixedColumns : true
            });
            
            // $.ajax({
            //     type : "post",
            //     data : {
            //         ajax : 1
            //     },
            //     success : function(e){
            //         $("#requests").html(e);
            //     }
            // })
            $(document.body).on("click", ".btn-acc", function() {
                $.ajax ({
                    type : "post",
                    data : {
                        brg : $(this).parent().parent().find(".kode_brg").text(),
                        bor : $(this).parent().parent().find(".kode_bor").text(),
                        stu : 1,
                        org : $(this).parent().parent().find(".kode_org").text()
                    },
                    success : function(){
                        $("#request-list").DataTable().ajax.reload(null,false);
                    }
                });
            });

            $(document.body).on("click", ".btn-cnc", function() {
                $.ajax ({
                    type : "post",
                    data : {
                        brg : $(this).parent().parent().find(".kode_brg").text(),
                        bor : $(this).parent().parent().find(".kode_bor").text(),
                        stu : 2,
                        org : $(this).parent().parent().find(".kode_org").text()
                    },
                    success : function(){
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(e){
                                $("#request-list").DataTable().ajax.reload(null,false);
                            }
                        })
                    }
                });
            });
        })    
    </script>
</head>
<body>
    <!-- Main content -->
    <div class="container-fluid request-list p-5" style='margin-top: 100px;'>
        <div class="row p-lg-5 p-3 rounded" style="backdrop-filter:blur(20px)">
            <div class="col-1 pt-1">
                <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
            </div>
            <div class="col-10">
                <h2 class="text-center text-light mb-lg-5 mb-3">PEMINJAMAN PENDING</h2>
            </div>
            <div class="col-1"></div>

            <hr style="color: #fff">
            
            <div class="col-12 table-responsive">
                <table class="table table-striped text-center align-middle" id="request-list" style="max-width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center align-middle">#</th>
                            <th class="text-center align-middle">Kode Barang</th>
                            <th class="text-center align-middle">Kode Borrow</th>
                            <th class="text-center align-middle">Kode user</th>
                            <th class="text-center align-middle">Nama Barang</th>
                            <th class="text-center align-middle">Nama Peminjam</th>
                            <th class="text-center align-middle">Tanggal Pinjam</th>
                            <th class="text-center align-middle">Tanggal kembali</th>
                            <th class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-light" id="requests">
                    </tbody>
                </table>
            </div>
        </div>
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