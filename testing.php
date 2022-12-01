<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <style>
            #inputSearch{
                border: solid;
                width: 75%;
                height:2em;
                margin-top: 0.5em;
                border-radius: 20pt;
                transition: all 0.5s ease;
            }
            .header{
                height: 4em;
                position : sticky;
                top:0;
                z-index: 1;
            }

            #notifImg, #keranjang, #userImg, #searchImg{
                width: 2em;
                height: 2em;
                top:10px;
            }
            #userImg{
                border-radius:40%;
            }

            #filter{
                position : fixed;
                top : 7em;
                left : -90pt; 
                width: 150px;
                height: 150px;
                border-radius: 50%;
                z-index : 10;
            }
            .filter-prop{
                position: absolute;
                border-radius : 50%;
                color:black;
                padding:5pt;
                transition:all 0.7s ease-in-out;
            }
            #No{
                top:60px;
                left:130px;
            }
            #P{
                top:-20px;
                left:60px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            #C{
                top:60px;
                left:-20px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            #T{
                top:150px;
                left:80px;
                padding-left:8pt;
                padding-right:8pt; 
            }
            .peopleCard{
                border-radius: 15pt;
            }

            .opening{
                background-color: black;
                background-image: url("assets/opening.jpg");
                background-color: #cccccc;
                height: 25em;
                top : 4em;
            }

            .card {
                /* height: 300px; */
                border-radius: 20px;
                background: white;
                position: relative;
                transition: 0.5s ease-out;
                overflow: visible;
                /* z-index: -1; */
                box-shadow: 2px 5px 23px -8px rgba(0,0,0,0.75);
            }

            .card-details {
                color: black;
                height: 100%;
                gap: .5em;
                display: grid;
                place-content: center;
            }

            .card-button {
                transform: translate(-50%, 125%);
                width: 60%;
                border-radius: 1rem;
                z-index: 3;
                border: none;
                background-color: #008bf8;
                color: #fff;
                font-size: 1rem;
                padding: .5rem 1rem;
                position: absolute;
                left: 50%;
                bottom: 0;
                opacity: 0;
                transition: 0.3s ease-out;
            }

            .text-body {
                color: rgb(134, 134, 134);
            }

            /*Text*/
            .text-title {
                text-align: center;
                font-size: 1em;
                font-weight: bold;
            }

            /*Hover*/
            .card:hover {
                border-color: #008bf8;
                box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
            }

            .card:hover .card-button {
                transform: translate(-50%, 50%);
                opacity: 1;
            }    
            
            .footer {
                left: 0;
                width: 100%;
                height: 3.5em;
                color: white;
                text-align: center;
            }

            #inputSearch::placeholder{
                font-size: 11px;
            }
    </style>
</head>
<body>
<div class="container barang mt-3">
 <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1" id="viewItem">
   <div class="col mt-5 contCard">
        <div class="card" style="width: 18rem; height: 26rem; padding-left: 1em; padding-right: 1em; padding-top: 1em;">
            <div class="text-center">
                <div id="carouselExampleControlsNoTouching" class="carousel slide carousel-dark" data-bs-touch="false" data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="item/mic.jfif" class="d-block w-100" alt="..." style="width: 12em; height: 14em;">
                        </div>
                        <div class="carousel-item">
                            <img src="item/speaker.jfif" class="d-block w-100" alt="..." style="width: 12em; height: 14em;">
                        </div>
                        <div class="carousel-item">
                            <img src="item/WT.jfif" class="d-block w-100" alt="..." style="width: 12em; height: 14em;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="card-details">
                <p class="text-title">Random</p>
                <p class="text-title">Quantity : 5</p>
                <p class="text-body" style="padding-left : 10px;">Blablabla</p>
            </div>
            <button class="card-button">Pinjam!</button>
        </div>
    </div>
  </div>
</div>
</body>
</html>