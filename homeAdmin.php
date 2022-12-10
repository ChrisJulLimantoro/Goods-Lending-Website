<?php
    include "admin_authen.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
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
    </script>
    <style>
        .banner-image{
            background-image: url('assets/gedungQ2.jpg');
            background-size: cover;
            /* filter: blur(0.5px); */
            
        }

        .nav-link{
            font-weight: bold;
        }

        h1{
            font-weight: 900;
            font-size: 60px;
        }
        .active{
            transition: all 0.5s ease;
        }
        .active:hover{
            background-color: #5179d6;
            transform: scale(1.2);
        }
        #welcome{
            overflow : hidden;
            border-right: none;
            animation: typing 3s steps(40, end), blink-caret .75s step-end 4;
        }
        #nama{
            overflow : hidden;
            width:0%;
            border-right: none;
            animation: typing 3s 3s forwards steps(40, end), blink-caret .75s 3s step-end 4;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        /* The typewriter cursor effect */
        @keyframes blink-caret {
            from, to { border-right: 0.15em solid transparent }
            50% { border-right: 0.15em solid orange; }
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
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
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
    

    <div class="banner-image w-100 vh-100 d-flex justify-content-center align-items-center">
        <div class="content text-center" style="z-index:10;" id="text">
            <h1 class="text-white" style="" id="welcome">WELCOME,</h1>
            <h1 class="text-white" style="" id="nama"><?php echo $_SESSION['admin'] ?></h1>
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