<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <style>
        .card {
        overflow: visible;
        position: relative;
        background: #647C90;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .2);
        border-radius: 1px;
        }

        .card:before, .card:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        background: #E2DED0;
        transition: 0.5s;
        z-index: -99;
        }

        .details {
        position: absolute;
        left: -10px;
        right: 0;
        bottom: 5px;
        height: 60px;
        text-align: center;
        text-transform: uppercase;
        }

        /*Image*/
        .imgbox {
        position: absolute;
        top: 10px;
        left: 10px;
        bottom: 10px;
        right: 10px;
        background: #E2DED0;
        transition: 0.5s;
        z-index: 1;
        }

        .img {
        background: #4C555D;
        background-image: linear-gradient(45deg, #4158D0, #C850C0);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }

        /*Hover*/
        .card:hover .imgbox {
        bottom: 80px;
        }

        .card:hover:before {
        transform: rotate(20deg);
        }

        .card:hover:after {
        transform: rotate(10deg);
        box-shadow: 0 2px 20px rgba(0, 0, 0, .2);
        }
    </style>
</head>
<body class="">
    <div class="container-fluid bg-dark">
        <div class="row">

            <div class="col-1">
                <button class="bg-dark" style="border: none">
                    <a href="homeUser.php">
                        <img src="back.png" alt="" style="height: 2em;">
                    </a>
                </button>
            </div>

            <div class="col-11 d-flex justify-content-center" style="padding-right: 10em;">
                <h4 class="text-white">
                    <a class="navbar-brand title text-white" href="homeUser.php">PEMINJAMAN BARANG</a>
                </h4> 
            </div>
        </div>
    </div>


    <div class="row mt-5 start-50 justify-content-center mx-5 px-5" >
        <div class="col-lg-3 col-12">
            <div class="card" style="width: 16rem; height: 18rem; border:none;">
                <div class="imgbox">
                    <div class="img">
                        <img src="talky.jpeg" alt="" style="width: 100%; height: 100%;">
                    </div>
                </div>
                <div class="details">
                    <h2 class="title text-white" style="font-size: 30px;">WALKY TALKY</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-12 mx-2" style="padding-left: 3em;">
            <div class="row">
                <div class="col-6">
                    <h3>Nama: </h3>
                    <h3>Walky Talky</h3>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h3>Kode: </h3>
                    <h3>KPT02_050219</h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h3>Keterangan: </h3>
                    <h3>adalah sebuah walky talky</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5 start-50 justify-content-center mx-5 px-5" >
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acor1" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                             PINJAM 1
                        </button>
                    </h2>
                    <div id="acor1" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body" style="overflow: auto;">
                            <table class="table">
                                <thead>
                                    <tr class="table-dark text-center">
                                        <th scope="col">TANGGAL DIPINJAM</th>
                                        <th scope="col">TANGGAL PENGEMBALIAN</th>
                                        <th scope="col">TENGGAT PENGEMBALIAN</th>
                                        <th scope="col">NAMA PIHAK PEMINJAM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>11 - 02 - 2021</td>
                                        <td>15 - 02 - 2021</td>
                                        <td>16 - 02 - 2021</td>
                                        <td>Budi</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <div class="col-12 justify-content-center d-flex">
                                    <button type="button" class="btn btn-primary" style="border-radius: 3em; width: 15em;">PINJAM</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acor2" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                             PINJAM 2
                        </button>
                    </h2>
                    <div id="acor2" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body" style="overflow: auto;">
                            <table class="table">
                                <thead>
                                    <tr class="table-dark text-center">
                                        <th scope="col">TANGGAL DIPINJAM</th>
                                        <th scope="col">TANGGAL PENGEMBALIAN</th>
                                        <th scope="col">TENGGAT PENGEMBALIAN</th>
                                        <th scope="col">NAMA PIHAK PEMINJAM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>11 - 02 - 2021</td>
                                        <td>15 - 02 - 2021</td>
                                        <td>16 - 02 - 2021</td>
                                        <td>Budi</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <div class="col-12 justify-content-center d-flex">
                                    <button type="button" class="btn btn-primary" style="border-radius: 3em; width: 15em;">PINJAM</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-heading3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acor3" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                             PINJAM 3
                        </button>
                    </h2>
                    <div id="acor3" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading3">
                        <div class="accordion-body" style="overflow: auto;">
                            <table class="table">
                                <thead>
                                    <tr class="table-dark text-center">
                                        <th scope="col">TANGGAL DIPINJAM</th>
                                        <th scope="col">TANGGAL PENGEMBALIAN</th>
                                        <th scope="col">TENGGAT PENGEMBALIAN</th>
                                        <th scope="col">NAMA PIHAK PEMINJAM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>11 - 02 - 2021</td>
                                        <td>15 - 02 - 2021</td>
                                        <td>16 - 02 - 2021</td>
                                        <td>Budi</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <div class="col-12 justify-content-center d-flex">
                                    <button type="button" class="btn btn-primary" style="border-radius: 3em; width: 15em;">PINJAM</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
        </div>
        <!-- <table class="table">
            <thead>
                <tr class="table-dark text-center">
                    <th scope="col">TANGGAL DIPINJAM</th>
                    <th scope="col">TANGGAL PENGEMBALIAN</th>
                    <th scope="col">TENGGAT PENGEMBALIAN</th>
                    <th scope="col">NAMA PIHAK PEMINJAM</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>11 - 02 - 2021</td>
                    <td>15 - 02 - 2021</td>
                    <td>16 - 02 - 2021</td>
                    <td>Budi</td>
                </tr>
            </tbody>
        </table> -->
    </div>
</body>
</html>