<?php
include "../../server/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id_maskapai'];
    $asal = mysqli_real_escape_string($db, $_POST['asal']);
    $tujuan = mysqli_real_escape_string($db, $_POST['tujuan']);
    $tanggal = mysqli_real_escape_string($db, $_POST['tanggal']);
    $waktu = mysqli_real_escape_string($db, $_POST['waktu']);
    $harga = mysqli_real_escape_string($db, $_POST['harga']);
    
    // Menghapus format currency jika ada
    $harga = preg_replace('/[^0-9]/', '', $harga);
    
    $query = "UPDATE penerbangan SET 
              asal = '$asal', 
              tujuan = '$tujuan', 
              tanggal = '$tanggal', 
              waktu = '$waktu', 
              harga = '$harga' 
              WHERE id_maskapai = $id AND maskapai = '".$_SESSION['username']."'";
    
    $result = mysqli_query($db, $query);
    
    if ($result) {
        echo "<script>alert('Data penerbangan berhasil diupdate'); window.parent.location.reload();</script>";
    } else {
        $error = mysqli_error($db);
        echo "<script>alert('Gagal mengupdate data penerbangan: " . addslashes($error) . "');</script>";
        error_log("Update error: " . $error);
        error_log("Query: " . $query);
    }
}
exit();
?> 