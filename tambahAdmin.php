<?php
    require "connection.php";
    include "admin_authen.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
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

        .hidden {
            display: none !important;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3" style="backdrop-filter : blur(3px);">
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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tambahAdmin.php">Tambah Admin</a>
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
    <div class="container-fluid w-100 vh-100 d-flex align-items-center justify-content-center">
        <div class="row p-5 mb-5 rounded"  style="backdrop-filter:blur(20px)">
            <div class="col-lg-2 mt-lg-3 col-12 d-flex align-items-start justify-content-center">
                <a href="homeAdmin.php"><i class="fa-solid fa-2xl fa-angle-left"></i></a>
            </div>
            <div class="col-lg-8 col-12">
                <label for="username" class="mb-1 text-light form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control px-3" placeholder="Enter a username" required><br>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12">
                <label for="username" class="mb-1 text-light form-label">Password</label>
                <input type="text" id="username" name="username" class="form-control px-3" placeholder="Create a password" required><br>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-12">
                <label for="username" class="mb-1 text-light form-label">Retype Password</label>
                <input type="text" id="username" name="username" class="form-control px-3" placeholder="Retype your password" required><br>
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2"></div>
            <div class="col-lg-8 mb-3">
                <button type="submit" class="btn btn-dark" id="submit" style="width:100%">Tambah</button>
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