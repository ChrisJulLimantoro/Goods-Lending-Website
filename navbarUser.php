<!DOCTYPE html>
<html lang="en">
<head>
    <style>

        #inputSearch{
            border: solid;
            border-width: medium;
            border-radius: 15pt;
            border-color: white;
            background-color: rgba(0, 0, 0, 0.0) !important;
            font-size: 11pt;
            color: white;
            transition: all 0.5s ease;
            height: 29px;
        }

        #inputSearch::placeholder{
            color: white;
            font-size: 11pt;
        }

        .header{
            height: 3.5em;
            z-index: 1;
            background-color:rgba(0, 0, 0, 0.5);
        }

        .header a button:hover {
            transform: translate(0%, 10%);
            opacity: 0.9;
            transition:all 0.2s ease-in-out;
        }

        #notifImg, #keranjang, #userImg, #searchImg{
            width: 2em;
            height: 2em;
        }

        #userImg{
            border-radius:40%;
        }

        .user-menu{
            color: white;
            background-color:rgba(0, 0, 0, 0.5);
        }

        .user-menu a button{
            background-color: #e9ab59;
            color: white;
            border-color: #e9ab59;
        }

        .navbar .navbar-toggler{
            border: 0pt;
        }

        .green {
            border-radius: 5px;
            width: 30%;
            text-align: center;
        }

        .red {
            border-radius: 5px;
            width: 25%;
            text-align: center;
        }

        .dropdown-divider {
            border-radius: 10px;
            height: 1.4px;
            background-color: white;
            opacity: 1;
        }

        .containerInput {
            min-width: 300px;
            transition:all 0.2s ease-in-out;
        }

        @media only screen and (max-width: 991px) {
            .containerInput {
                margin-left: auto;
                margin-right: auto;
                margin-top: 15px;
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 35px;
                height: 80%;
                display: block;
                flex: auto;
                text-align: center;
                flex-direction: column;
                align-items: flex-end;
                padding: 5px;
            }

            .containerInput input {
                width: 94%;
                margin: auto;
                display: inline-block;
                text-align: left;
                background-color: white;
                margin-bottom: 10px;
            }

        }

        @media screen and (min-width: 300px) {
            .containerInput {
                width: 300px;
            }
            
            #judul {
                font-size: 0.8em;
            }
        }

        @media screen and (min-width: 576px) {
            .containerInput {
                width: 550px;
            }

            
            #judul {
                font-size: 1.2em;
            }
        }

        @media screen and (min-width: 768px) {
            .containerInput {
                width: 720px;
            }
            
            #judul {
                font-size: 1.5em;
            }
        }

        @media screen and (min-width: 991px) {
            .containerInput {
                width: 500px;
            }
        }

        @media screen and (min-width: 1200px) {
            .containerInput {
                width: 600px;
            }
        }

    </style>
</head>
<body>
    <!-- NAVBAR -->
<nav class="navbar fixed-top navbar-expand-lg header px-lg-5 px-md-3 px-sm-1">
  <div class="container-fluid" style="max-width:100% !important">
    <!-- drop down -->
    <div class="col-auto user mx-3">
        <li class="nav-item dropdown mt-1" style="list-style: none">
            <a class="nav-link dropdown-toggle mb-1 position-relative" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $_SESSION['profile'] ?>" alt=""  id="userImg">
            </a>
            <ul class="dropdown-menu user-menu mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                <h6 class="card-title mb-1 mt-1">User ID:</h6>
                <h6 class="card-title mb-2"><?php echo $_SESSION['user'] ?></h6>
                <h6 class="card-title mb-1">Nama:</h6>
                <h6 class="card-title mb-2">
                    <?php $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                        $stmtName = $conn->prepare($sqlName);
                        $stmtName->execute(['user' => $_SESSION['user']]);
                        $rowName = $stmtName->fetchcolumn(); 
                        echo $rowName;
                    ?>
                </h6>
                <h6 class="card-title mb-1">Status: </h6>
                <h6 class="card-title mb-2">
                    <?php
                        if($_SESSION['status'] == 0){
                            echo '<p class="bg-success p-1 green">Green</p>';
                        }else{
                            echo '<p class="bg-danger p-1 red">Red</p>';
                        }
                    ?></h6>
                <li>
                <hr class="dropdown-divider"></li>
                <a href="logout.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
            </ul>
        </li>
    </div>

    <!-- judul -->
    <a class="navbar-brand text-white" id= "judul" href="homeUser.php">UPPK UK. PETRA</a>

    <!-- status -->
    <a href="status.php" class="ml-2 mt-1">
    <button type="button" class="btn">
        <i class="fa-sharp fa-solid fa-inverse fa-clock-rotate-left fa-xl"></i>
    </button>
    </a>    

    <!-- keranjang -->
    <a href="keranjang.php" class="ml-2 mt-1">
        <button type="button" class="btn">
            <i class="fa-solid fa-cart-shopping fa-inverse fa-xl"></i>
        </button>
    </a>

    <!-- tombol responsive -->
    <button class="navbar-toggler" id ="search-btn"type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="mt-1">
            <i class="fa-solid fa-inverse fa-lg fa-magnifying-glass" style="margin-top: 12px;"></i>
        </span>
    </button>
    <div class="collapse navbar-collapse mb-3 justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <!-- TOMBOL SEARCH -->
            <li class="nav-item">
                <div class="pt-3 containerInput">
                    <!-- <button class="form-control bg-dark me-2" id="searchButton"><img src="assets/search.png" alt="" id="searchImg"></button> -->
                    <input type="text" class="form-control inputSearch" id="inputSearch" placeholder="Search Product">
                </div>
            </li>
        </ul>
    </div>
  </div>
</nav>
</body>
</html>