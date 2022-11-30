<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['admin']) == false){
        session_destroy();
        sleep(2);
        header("Location: login.php");
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
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
        }

        /* Navbar */
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
        #requests {
            font-weight: 400;
        }
    </style>

    <script>
        $(document).ready(function() {
            let id = $("#kode").html();
            let nama = $("#namaBrg").html();
            let peminjam = $("#peminjam").html();
            let tglPinjam = $("#tglPinjam").html();
            let tglKembali = $("#tglKembali").html();

            $(document.body).on("click", "#accept", function() {
                $.ajax (
                    
                ));

                $(this).parent().parent().remove();
            });

            $(document.body).on("click", "#deny", function() {
                $.ajax ({
                    
                });

                $(this).parent().parent().remove();
            });
        })    
    </script>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid bg-dark text-white header sticky-top">
        <div class="row px-lg-3" style="margin: 0">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-lg-2 col-3 d-flex justify-content-start text-center">   
                    <a class="navbar-brand" href="homeUser.php">KERANJANG</a>
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
    <div class="container-fluid request-list p-5">
        <h2 class="text-center mb-5">PEMINJAMAN PENDING</h2>
        <div class="col-12 table-responsive">
            <table class="table table-hover text-center align-middle">
                <tr class="table-light">
                    <th>#</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal kembali</th>
                    <th>Aksi</th>
                </tr>
                <tbody class="table-group-divider" id="requests">
                    <tr>
                        <td id="count">1</td>
                        <td id="kode">C0001</td>
                        <td id="namaBrg">Microphone Wireless</td>
                        <td id="peminjam">Budi</td>
                        <td id="tglPinjam">1/12/2022</td>
                        <td id="tglKembali">8/12/2022</td>
                        <td>
                            <button type="button" class="btn btn-success" style="width:70px" id="accept">Terima</button>
                            <button type="button" class="btn btn-danger" style="width:70px" id="deny">Tolak</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>