<?php
$target_dir = "item/";
if(isset($_FILES["submitFoto1"])){
    $target_file1 = $target_dir . basename($_FILES["submitFoto1"]["name"]);
    $uploadOk = 1;

    if (file_exists($target_file1)) {
        echo "Sorry, file already exists.1";
        $uploadOk = 0;
    }

    if ($uploadOk != 0){
        if(move_uploaded_file($_FILES["submitFoto1"]["tmp_name"], $target_file1)){
            echo "sukses";
        }else{
            echo "failed";
        }
    }
}
if(isset($_FILES["submitFoto2"])){
    $target_file2 = $target_dir . basename($_FILES["submitFoto2"]["name"]);
    $uploadOk = 1;
    if (file_exists($target_file2)) {
        echo "Sorry, file already exists.2";
        $uploadOk = 0;
    }

    if ($uploadOk != 0){
        if(move_uploaded_file($_FILES["submitFoto2"]["tmp_name"], $target_file2)){
            echo "sukses";
        }else{
            echo "failed";
        }
    }
}
if(isset($_FILES["submitFoto3"])){
    $target_file3 = $target_dir . basename($_FILES["submitFoto3"]["name"]);
    $uploadOk = 1;
    echo basename($_FILES["submitFoto3"]["name"]);
    if (file_exists($target_file3)) {
        echo "Sorry, file already exists.3";
        $uploadOk = 0;
    }

    if ($uploadOk != 0){
        if(move_uploaded_file($_FILES["submitFoto3"]["tmp_name"], $target_file3)){
            echo "sukses";
        }else{
            echo "failed";
        }
    }
}
if(isset($_FILES["submitFoto4"])){
    $target_file4 = $target_dir . basename($_FILES["submitFoto4"]["name"]);
    $uploadOk = 1;
    if (file_exists($target_file4)) {
        echo "Sorry, file already exists.4";
        $uploadOk = 0;
    }

    if ($uploadOk != 0){
        if(move_uploaded_file($_FILES["submitFoto4"]["tmp_name"], $target_file4)){
            echo "sukses";
        }else{
            echo "failed";
        }
    }
}
?>