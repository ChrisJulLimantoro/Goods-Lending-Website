<?php
    include "admin_authen.php";
?>
<?php
    if (isset($_POST['id'])) {
        echo 1;
        exit();
    }
?>
<?php
    if (isset($_POST['newID']) && isset($_POST['newName']) && isset($_POST['newDesc'])) {
        echo 1;
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

        /* Navbar */
        .navbar {
            transition: all .5s ease;
        }

        .nav-link{
            font-weight: bold;
        }

        .active{
            transition: all 0.5s ease;
        }
        .active:hover{
            background-color: #5179d6;
            transform: scale(1.2);
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
                }
            });

            // konfirmasi pengembalian
            $(document.body).on("click", "#btn-return", function() {
                let kode = $(this).parent().parent().find("#kode").html();
                let parent = $(this).parent();
                console.log(kode);
                $.ajax({
                    type : "post",
                    data : {
                        id : kode
                    },
                    success : function(e) {
                        if (e == 1) {
                            console.log("tes")
                            parent.html("Tersedia");
                            parent.addClass("text-success")
                        }
                    }
                })
            });

            // edit barang
            $(document.body).on("click", "#btn-edit", function() {
                let currID = $(this).parent().parent().children().eq(1).text();
                let currName = $(this).parent().parent().children().eq(2).text();
                let currDesc = $(this).parent().parent().children().eq(4).text();

                $("#modalBody").find(".alert").remove();
                $("#newID").val(currID);
                $("#newName").val(currName);
                $("#newDesc").val(currDesc);
            });

            // update detail barang
            $(document.body).on("click", "#btn-update", function() {
                $.ajax({
                    type : "post",
                    data : {
                        newID : $("#newID").val(),
                        newName : $("#newName").val(),
                        newDesc : $("#newDesc").val()
                    },
                    success : function(e) {
                        showResult(e)
                    }
                });

            });

            // delete barang
            $(document.body).on("click", "#btn-del", function() {
                $(this).parent().parent().remove();
            });

            function showResult(data) {
                if (data == 1) {
                    // console.log("1");
                    $("#modalBody").prepend('<div class="col-12 alert alert-success" role="alert">Data berhasil diupdate!</div>');
                }
                else {
                    // console.log("0");
                    $("#modalBody").prepend('<div class="col-12 alert alert-danger" role="alert">Kesalahan dalam mengubah data, silahkan coba lagi</div>');
                }    
            }
        });
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark p-md-3" style="backdrop-filter : blur(3px);">
        <div class="container-fluid justify-content-between">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="homeAdmin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tambahBarang.php">Tambah Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="terimaPeminjaman.php">Terima Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="history.php">Riwayat</a>
                    </li>
                </ul>
            </div>
            <div style="width: 5em; display:!important inline, position:!important absolute" class="user">
                <div class="dropdown" style="list-style: none; width: 3em;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $_SESSION['profile'] ?>" alt="" style="width: 3em; height: 3em; border-radius: 50%">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-3" style="color: white;">
                        <h5 class="dropdown-item">Username: </h5>
                        <h5 class="dropdown-item"><?php echo $_SESSION['admin'] ?></h5>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="logout.php"><button class="btn btn-primary mx-2" >Log out</button></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main content -->
    <div class="container-fluid p-5">
        <div class="row p-lg-5 p-3 rounded" style="backdrop-filter:blur(20px); border-radius: 20pt">
            <div class="col-1 pt-1">
                <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
            </div>
            <div class="col-10">
                <h2 class="text-center text-light mb-lg-5 mb-3">INVENTORY</h2>
            </div>
            <div class="col-1"></div>
            
            <div class="col-12 table-responsive">
                <table class="table table-dark table-striped table-bordered text-center align-middle" id="item-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th> 
                            <th>Aksi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                            $sql = "SELECT * FROM item";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $res = $stmt->fetchAll();
                            $row_count = 1;
                            foreach($res as $hasil) {
                                echo "<tr>";
                                echo "<td>" . $row_count . "</td>";
                                echo "<td id='kode'>" . $hasil['Id'] . "</td>";
                                echo "<td>" . $hasil['Nama_Barang'] . "</td>";
                                echo "<td>" . $hasil['Location'] . "</td>";
                                echo "<td>" . $hasil['Deskripsi'] . "</td>";
                                echo "<td><button class='btn btn-warning me-lg-3' id='btn-edit' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fa-solid fa-pen-to-square'></i></button>";
                                echo "<button class='btn btn-danger' id='btn-del'><i class='fa-solid fa-trash'></i></button></td>";
                                if ($hasil['Status'] == 1) {
                                    echo "<td class='text-success'>Tersedia</td>";
                                }
                                else {
                                    echo "<td><button class='btn btn-primary' id='btn-return'>Konfirmasi Pengembalian</button></td>";
                                }
                                echo "</tr>";
                                $row_count++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row" id="modalBody">
                            <div class="col-12 pb-3">
                                <label for="newName" class="form-label"><b>Kode Barang</b></label>
                                <input type="text" id="newID" name="newID" class="form-control" required disabled>
                            </div>
                            <div class="col-12 pb-3">
                                <label for="newName" class="form-label"><b>Nama Barang</b></label>
                                <input type="text" id="newName" name="newName" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="newDesc" class="form-label"><b>Deskripsi</b></label>
                                <textarea class="form-control" id="newDesc" name="newDesc" rows="3" required></textarea><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-update">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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