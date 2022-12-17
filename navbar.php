<?php
    include "connection.php";
?>
<head>
    <script>
        $(document).ready(function(){
            $(window).resize(function(){
                var width= $(window).width();
                if(width<992){
                    $(".user").removeClass("px-3");
                }else{
                    $(".user").addClass("px-3");
                }
            });
        })

        var nav= document.querySelector('nav');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 100) {
                nav.classList.add('bg-dark', 'shadow');
            }
            else {
                nav.classList.remove('bg-dark','shadow');
            }
        });
    </script>
    </script>
    <style>
        .nav-link{
            font-weight: bold;
        }
       
        .active{
            transition: all 0.5s ease;
            border-radius: 20px;
        }
        .active:hover{
            
            background-color: #5179d6;
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3" style="backdrop-filter : blur(0);">
        <div class="container-fluid justify-content-between">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2">
                        <li class="nav-item px-3">
                            <a class="nav-link active px-3" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link active px-3" aria-current="page" href="terimaPeminjaman.php">Verifikasi</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link active px-3" aria-current="page" href="tambahBarang.php">Tambah Barang</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link active px-3" aria-current="page" href="#">Tabel Peminjaman</a>
                        </li>
                        
                </div>
                <div style="width: 5em;" class="user">
                    <li class="nav-item dropdown" style="list-style: none; width: 3em;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="profile/profileDefault.jpg" alt="" style="width: 3em; height: 3em;border-radius: 30px">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3" style="color: white;">
                            <h5 class="dropdown-item">Username: </h5>
                            <h5 class="dropdown-item"><?php echo $_SESSION['user'] ?></h5>
                            <!-- <li><a class="dropdown-item" href="#"></a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li> -->
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="btn btn-primary mx-2">Log out</button></li>
                        </ul>
                    </li>
                </div>
            
        </div>
    </nav>
    
</body>
</html>