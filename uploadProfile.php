<?php
$target_dir = "profile/";
$target_file = $target_dir . basename($_FILES["submitFile"]["name"]);
$uploadOk = 1;

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

if ($uploadOk != 0){
    if(move_uploaded_file($_FILES["submitFile"]["tmp_name"], $target_file)){
        echo "sukses";
    }else{
        echo "failed";
    }
}
?>