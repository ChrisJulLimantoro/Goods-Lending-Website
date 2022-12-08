<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mx-5 bg-white">
        <div class="row">
            <h3>History Peminjaman</h3>
        </div>
        <div class="row mt-3">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item mb-4" style="border-radius: 8px; border:solid;">
                    <h2 class="accordion-header" id="headingOne" style="">
                    <button class="accordion-button bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="row container-fluid text-white">
                            <div class="col-md-5 col-12 mt-2">ID PEMINJAMAN</div>
                            <div class="col-md-5 col-12 mt-2">22-07-2022 / 28-07-2022</div>
                            <div class="col-md-2 col-12 mt-2" style="float: right">STATUS</div>
                        </div>
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-dark text-white px-5">
                        <table class="table table-light table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAMA</th>
                                    <th>LOKASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P001</td>
                                    <td>MIC</td>
                                    <td>P</td>
                                </tr>
                                <tr>
                                    <td>W001</td>
                                    <td>HT</td>
                                    <td>W</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>