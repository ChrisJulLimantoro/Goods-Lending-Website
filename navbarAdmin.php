<!DOCTYPE html>
<html lang="en">
<head>
    <style>
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
            transform: scale(1.07);
        }
    </style>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3" style="backdrop-filter : blur(3px);">
        <div class="container-fluid justify-content-between">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="homeAdmin.php">Home</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="tambahBarang.php">Tambah Barang</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="terimaPeminjaman.php">Terima Peminjaman</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link active" aria-current="page" href="inventory.php">Inventory</a>
                        </li>
                        <li class="nav-item me-3">
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
</body>
</html>