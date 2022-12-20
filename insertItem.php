<?php
    include "connection.php";
    include "uploadItem.php";

    // utk tambah barang
    if(isset($_POST['nama']) && isset($_POST['lokasi']) && isset($_POST['kodeBarang']) && isset($_POST['keterangan'])){
        $sql = 'INSERT INTO item (id,nama_barang,deskripsi,status,location)
                VALUES (:id,:nama,:deskripsi,1,:location)';
        $stmt= $conn->prepare($sql);
        $stmt->execute(array(
            ':id' => $_POST['kodeBarang'],
            ':nama' => $_POST['nama'],
            ':deskripsi' => $_POST['keterangan'],
            ':location' => $_POST['lokasi']
        ));
        if(isset($_FILES["submitFoto1"])){
            $sql2 = "UPDATE `item` SET `image` = :image
                        WHERE `id` = :id";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute(array(
                ':image' => $target_file1,
                ':id' => $_POST['kodeBarang']
            ));
        }
        if(isset($_FILES["submitFoto2"])){
            $sql3 = "UPDATE `item` SET `image2` = :image
                        WHERE `id` = :id";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->execute(array(
                ':image' => $target_file2,
                ':id' => $_POST['kodeBarang']
            ));
        }
        if(isset($_FILES["submitFoto3"])){
            // echo $target_file3;
            $sql4 = "UPDATE `item` SET `image3` = :image
                        WHERE `id` = :id";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->execute(array(
                ':image' => $target_file3,
                ':id' => $_POST['kodeBarang']
            ));
        }
        if(isset($_FILES["submitFoto4"])){
            $sql5 = "UPDATE `item` SET `image4` = :image
                        WHERE `id` = :id";
            $stmt5 = $conn->prepare($sql5);
            $stmt5->execute(array(
                ':image' => $target_file4,
                ':id' => $_POST['kodeBarang']
            ));
        }
        header("Location: tambahBarang.php");
    }
?>