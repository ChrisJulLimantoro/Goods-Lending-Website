<?php 
    include "user_authen.php";    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');

        body {
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
            overflow-y: scroll;
        }

        /* Navbar style */
        #inputSearch{
            border: transparent;
            width: 75%;
            height: 3em;
            border-radius: 20pt;
        }

        .header {
            width: 100%;
            top: 0;
            z-index: 1;
        }
    
        #notifImg, #keranjang, #userImg {
            height: 2em;
            aspect-ratio: 1 / 1;
        }

        #userImg {
            border-radius: 40%;
        }

        .dropdown-menu {
            z-index: 1;
        }

        @media only screen and (max-width: 576px) {
            .navbar-brand {
                font-size: .75em;
            }
        }

        /* Main */
        .detail-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            align-items: center;
            width: 60%;
            min-height: 90vh;
        }

        .detail-box > div {
            border-radius: 20pt;
            width: 100%;
            transition: all .5s ease-in-out;
        }

        .detail-box > div:hover {
            box-shadow: 0 0 30px #aaa;
        }

        #namaItem, #qtyItem, #keteranganItem {
            font-size: 1.25em;
        }

        @media screen and (max-width: 920px) {
            .detail-box {
                width: 90%;
            }
            #namaItem, #qtyItem, #keteranganItem, .table tr {
                font-size: .75em;
            }
        }

        #imgItem {
            width: 100%;
            aspect-ratio: 1 / 1;
        }

        .btn-close {
            transition: all .5s ease;
        }

        .btn-close:hover {
            transform: scale(1.15) rotate(-90deg);
        }

        /* Accordion */
        .accordion, .accordion-item, .detail-item-button {
            background-color: #212529;
            color: #fff;
            border: none;
        }

        #showDetail {
            width: 100%;
        }

        #showDetail img {
            width: 25px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $.ajax({
                type : "post",
                data : {
                    ajax : 1
                },
                success : function(response){
                    $("#view").html(response);
                }
            })
            // Delete per JENIS item
            $(document.body).on("click", ".btn-delete-all", function() {
                let name = $(this).parent().parent().find('.col-lg-8').find('#namaItem').text().substring(13);
                $.ajax({
                    type : "post",
                    data : {
                        hapusAll : name
                    },
                    success : function(response){
                        console.log("sukses");
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(response){
                                $("#view").html(response);
                            }
                        });
                    }
                });
            });

            // Delete per item
            $(document.body).on("click", ".btn-delete-one", function() {
                // $(this).parent().parent().remove();
                let idOne = $(this).parent().parent().find(".kodeBrg").text();
                $.ajax({
                    type : "post",
                    data : {
                        hapus : idOne
                    },
                    success : function(response){
                        console.log("sukses");
                        $.ajax({
                            type : "post",
                            data : {
                                ajax : 1
                            },
                            success : function(response){
                                $("#view").html(response);
                            }
                        });
                    }
                });
            });
            
            // Animasi tombol
            $(document.body).on("click", ".showDetail", function() {
                $(this).find("img").css("transition", "all .5s ease");

                if ($(this).find("img").css("transform") != "none")
                    $(this).find("img").css("transform", "none");
                else
                    $(this).find("img").css("transform", "rotate(180deg)");
            });
            // ajax create new bucket
            var status = '<?php echo $_SESSION['status']?>'
            $(document.body).on("click","#createBucket",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                if(status == 1){
                    swalWithBootstrapButtons.fire(
                        'Error!',
                        'You can\'t create another bucket if you have already had one or you need to return your item first before set another request!',
                        'error'
                    )
                }else{
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "Do You wish to create a new bucket?!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, make new bucket!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                swalWithBootstrapButtons.fire({
                                title: 'Creating Borrow Bucket : ',
                                html: `<label for="start_date" class="form-label my-2">Start Borrow Date : </label>
                                    <input type="date" id="start_date" class="swal2_input form-control" placeholder="Borrow Date">
                                    <label for="expired_date" class="form-label my-2">End Borrow Date : </label>
                                    <input type="date" id="expired_date" class="swal2_input form-control" placeholder="Expiration Date">`,
                                showCancelButton: true,
                                confirmButtonText: 'Next',
                                showLoaderOnConfirm: true,
                                preConfirm: () => {
                                    const sd = $("#start_date").val();
                                    const ed = $("#expired_date").val();
                                    if (!sd || ! ed) {
                                    Swal.showValidationMessage(`Please enter Start Date and Expired Date`)
                                    }
                                    return { sd: sd, ed: ed }
                                }
                            }).then((result2) => {
                                if(`${result2.value.ed}` >= `${result2.value.sd}`){
                                    $.ajax({
                                        type : "post",
                                        data : {
                                            start : `${result2.value.sd}`,
                                            end : `${result2.value.ed}`,
                                        },
                                        success:function(e){
                                            console.log(e);
                                            $.ajax({
                                                type : "post",
                                                data : {
                                                    ajax : 1
                                                },
                                                success : function(response){
                                                    $("#view").html(response);
                                                }
                                            })
                                        }
                                    })

                                    swalWithBootstrapButtons.fire(
                                        'Success',
                                        'Success creating new Borrow Bucket and added 1 item!',
                                        'success'
                                    )
                                }else{
                                    swalWithBootstrapButtons.fire(
                                        'Failed',
                                        'Failed creating new Borrow Bucket, input date invalid!',
                                        'error'
                                    )
                                }
                            })
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your action has been cancelled',
                            'error'
                            )
                        }
                    })
                }
            });
            // ajax ajukan pinjaman
            $(document.body).on("click","#pinjamBarang",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title : "Enter your password",
                    html : "<input type='password' class='form-control' name='verif' id='verif'>",
                    showCancelButton: true,
                    confirmButtonText: 'Continue',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const pass = $("#verif").val();
                        if (!pass) {
                        Swal.showValidationMessage(`Please enter a valid password!`)
                        }
                        return { pass: pass }
                    }
                })
                .then((result) => {
                    $.ajax ({
                        type : "post",
                        data : {
                            verif : `${result.value.pass}`
                        },
                        success : function(e) {
                            if (e == 1) {
                                $.ajax({
                                    type : "post",
                                    data : {
                                        pinjam : 1
                                    },
                                    success : function(e){
                                        // console.log('sukses');
                                        $("#view").html(e);
                                    }
                                });
                                
                                swalWithBootstrapButtons.fire ({
                                    icon : "success",
                                    title : "Success!",
                                    text : "Verification Succeed!"
                                })
                            }
                            else {
                                swalWithBootstrapButtons.fire ({
                                    icon : "error",
                                    title : "Failed!",
                                    text : "Wrong Password!"
                                })
                            }
                        }
                    })
                })
            });
        });
    </script>
</head>
<body>
    
    <!-- Navbar -->
    <div class="container-fluid bg-dark text-white header sticky-top">
        <div class="row px-lg-3" style="margin: 0">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="col-lg-2 col-3 d-flex justify-content-start text-center">   
                    <a class="navbar-brand" href="homeUser.php">KERANJANG</a>
                </div>
                
                <div class="col-lg-8 col-5 d-flex justify-content-center">
                    <input type="text" class="form-control px-4" id="inputSearch" placeholder="Search Product">
                </div>

                <div class="col-lg-2 col-4 d-flex justify-content-center">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-dark">
                            <img src="assets/notif.png" alt=""  id="notifImg">
                            <span class="position-absolute badge rounded-pill bg-danger">
                            99+
                            </span>
                        </button>
                    </div>
                    
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <a href="keranjang.php">
                            <button type="button" class="btn btn-dark">
                                <img src="assets/keranjang.png" alt=""  id="keranjang">
                            </button>
                        </a>
                    </div>

                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <li class="nav-item dropdown mt-2" style="list-style: none">
                            <a class="nav-link dropdown-toggle mb-2 position-relative dropdown-menu-end" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $_SESSION['profile'] ?>" alt=""  id="userImg">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark text-white mt-3 px-3" aria-labelledby="navbarDropdown" style=" width: 15em;">
                                <h6 class="card-title mb-2">User ID:</h6>
                                <h6 class="card-title mb-1">
                                    <?php
                                         echo $_SESSION['user'] 
                                    ?>
                                </h6>
                                <h6 class="card-title mb-2">Nama:</h6>
                                <h6 class="card-title mb-1">
                                    <?php 
                                    $sqlName = "SELECT CONCAT(first_name,' ',last_name) AS name FROM `user` WHERE `username` = :user";
                                        $stmtName = $conn->prepare($sqlName);
                                        $stmtName->execute(['user' => $_SESSION['user']]);
                                        $rowName = $stmtName->fetchcolumn(); 
                                        echo $rowName;
                                    ?>
                                </h6>
                                <li><hr class="dropdown-divider"></li>
                                <a href="logout.php"><button type="button" class="btn btn-light">LOGOUT</button></a>
                            </ul>
                        </li>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="container-fluid detail-box mt-4" id="view">
    </div>
</body>
</html>