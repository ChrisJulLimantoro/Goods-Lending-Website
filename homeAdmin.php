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
        // change navbar style on scroll
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
    <?php include "navbarAdmin.php"; ?>
    <style>
        .banner-image{
            background-image: url('assets/gedungQ2.jpg');
            background-size: cover;
            /* filter: blur(0.5px); */
        }
        h1{
            font-weight: 900;
            font-size: 60px;
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

        @media screen and (max-width:768px) {
            #welcome, #nama {
                font-size: 2em;
            }
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