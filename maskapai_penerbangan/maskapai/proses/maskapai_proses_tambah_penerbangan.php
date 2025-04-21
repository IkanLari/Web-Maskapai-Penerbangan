<?php
include "../../server/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maskapai = $_SESSION['username'];
    $asal = mysqli_real_escape_string($db, $_POST['asal']);
    $tujuan = mysqli_real_escape_string($db, $_POST['tujuan']);
    $tanggal = mysqli_real_escape_string($db, $_POST['tanggal']);
    $waktu = mysqli_real_escape_string($db, $_POST['waktu']);
    $harga = mysqli_real_escape_string($db, $_POST['harga']);
        
    $query = "INSERT INTO penerbangan (maskapai, asal, tujuan, tanggal, waktu, harga) 
            VALUES ('$maskapai', '$asal', '$tujuan', '$tanggal', '$waktu', '$harga')";
        
    $result = mysqli_query($db, $query);
        
    if ($result) {
        echo "<script>alert('Data penerbangan berhasil ditambahkan'); window.parent.location.reload();</script>";
    } else {
        $error = mysqli_error($db);
        echo "<script>alert('Gagal menambahkan data penerbangan: " . addslashes($error) . "');</script>";
        error_log("Add error: " . $error);
        error_log("Query: " . $query);
    }
}
exit();
?> 