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
        
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
        <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Verifikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Tambah Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Tabel Peminjaman</a>
                        </li>
                        
                </div>
                <div style="width: 10em;" class="px-3 user">
                    <li class="nav-item dropdown" style="list-style: none; width: 3em;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="profile/profileDefault.jpg" alt="" style="width: 3em; height: 3em;border-radius: 30px">
                        </a>
                        <ul class="dropdown-menu mt-3" style="color: white;">
                            <h5 class="dropdown-item">Username: </h5>
                            <h5 class="dropdown-item">LeoAdmin</h5>
                            <!-- <li><a class="dropdown-item" href="#"></a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li> -->
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="btn btn-primary mx-2">Log out</button></li>
                        </ul>
                    </li>
                </div>
            
        </div>
    </nav>

    <div class="banner-image w-100 vh-100 d-flex justify-content-center align-items-center">
        <div class="content text-center" style="z-index:10;">
            <h1 class="text-white" style="">WELCOME,</h1>
            <h1 class="text-white" style="">CJ BLOK</h1>
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