<?php
    include "admin_authen.php";
?>
<?php 
    if(isset($_POST['ajax'])){
        $sql = "SELECT i.Id AS IdBarang, i.Nama_Barang AS namaBarang, CONCAT(u.first_name, ' ', u.last_name) AS namaPeminjam, b.start_date, b.return_date, d.status AS status FROM borrow_detail d JOIN borrow b ON d.id_borrow = b.id_borrow JOIN item i on d.id_item = i.Id JOIN user u on b.id_user = u.username WHERE d.status <> 0 ORDER BY b.start_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $row_count = 1;
        $arr = array();
        foreach($res as $hasil) {
            $temp = array();
            array_push($temp,$row_count);
            array_push($temp,$hasil['IdBarang']);
            array_push($temp,$hasil['namaBarang']);
            array_push($temp,$hasil['namaPeminjam']);
            array_push($temp,$hasil['start_date']);
            array_push($temp,$hasil['return_date']);
            array_push($temp,$hasil['status']);
            $row_count++;
            array_push($arr,$temp);
        }
        $json = json_encode($arr);
        echo $json;
        exit();
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>

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
            /* font-family: 'League Spartan', sans-serif;
            font-weight: 700; */
            background: url('assets/gedungQ2.jpg') fixed no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
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
            #item-list th, #item-list td, #item-list button {
                font-size: .75em;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#item-list").DataTable({
                "language": {
                    "paginate": {
                        "next": "<span class='text-light'>Next</span>",
                        "previous": "<span class='text-light'>Previous</span>"
                    }
                },
                ajax : {
                    processing: true,
                    serverSide: true,
                    url : "history.php",
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
                    {data : null,
                    "render" : function(data,type,row){
                        if(row[6] == 2){
                            return '<i class="text-danger"></i>';
                        }
                        else if(row[6] == 3){
                            return '<i class="text-warning">belum kembali</i>';
                        }
                        else if(row[6] == 4){
                            if(row[5] == null){
                                return '<i class="text-primary">Barang lainnya belum kembali</i>';
                            }else{
                                return '<i class="text-success">'+row[5]+'</i>';
                            }
                        }
                        else {
                            return "";
                        }
                    }},
                    {data : null,
                    "render" : function(data,type,row){
                        if(row[6] == 1){
                            return '<i class="text-success">Peminjaman Diterima</i>';
                        }else if(row[6] == 2){
                            return '<i class="text-danger">Peminjaman Ditolak</i>';
                        }else if(row[6] == 3){
                            return '<i class="text-primary">Barang dibawa User</i>';
                        }else if(row[6] == 4){
                            return '<i class="text-secondary">Barang Telah Dikembalikan</i>';
                        }
                        else {
                            return "";
                        }
                    }}
                ],  
            });
        });
    </script>
</head>
<body>
    <!-- Main content -->
    <div class="container-fluid p-5" style='margin-top: 100px;'>
        <div class="row p-lg-5 p-3 rounded" style="backdrop-filter:blur(20px); border-radius: 20pt">
            <div class="col-1 pt-1">
                <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
            </div>
            <div class="col-10">
                <h2 class="text-center text-light mb-lg-5 mb-3">RIWAYAT PEMINJAMAN BARANG</h2>
            </div>
            <div class="col-1"></div>
            <hr style="color: #fff">
            <div class="col-12 table-responsive">
                <table class="table table-dark table-striped table-bordered text-center align-middle" id="item-list">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">#</th>
                            <th class="text-center align-middle">Kode Barang</th>
                            <th class="text-center align-middle">Nama Barang</th>
                            <th class="text-center align-middle">Nama peminjam</th>
                            <th class="text-center align-middle">Tanggal Pinjam</th>
                            <th class="text-center align-middle">Tanggal Pengembalian</th> 
                            <th class="text-center align-middle">Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var nav= document.querySelector('nav');
        window.addEventListener('scroll', function(){
          if (window.pageYOffset > 100){
            nav.classList.add('bg-dark', 'shadow');
          }else{
            nav.classList.remove('bg-dark','shadow');
          }
        });
    </script>
</body>
</html>