<?php
include '../../server/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['id'];
    $id_maskapai = mysqli_real_escape_string($db, $_POST['id_maskapai']);
    $no_rekening = mysqli_real_escape_string($db, $_POST['no_rekening']);
    $jumlah_tiket = mysqli_real_escape_string($db, $_POST['jumlah_tiket']);
    $total_harga = mysqli_real_escape_string($db, $_POST['total_harga']);
    $waktu_pemesanan = date('Y-m-d H:i:s');
    
    // Validasi jumlah tiket minimal 1
    if ($jumlah_tiket < 1) {
        echo "Jumlah tiket tidak valid";
        exit();
    }
    
    // Insert ke database
    $query = "INSERT INTO tiket_penerbangan (id_user, id_maskapai, no_rekening, jumlah_tiket, total_harga, waktu_pemesanan, status) 
              VALUES ('$id_user', '$id_maskapai', '$no_rekening', '$jumlah_tiket', '$total_harga', '$waktu_pemesanan', 'pending')";
    
    $result = mysqli_query($db, $query);

    if ($result) {
        echo "<script>alert('Tiket berhasil dipesan'); window.location.href='../tiketSaya.php';</script>";
    } else {
        $error = mysqli_error($db);
        echo "<script>alert('Gagal memesan tiket: " . addslashes($error) . "');</script>";
        error_log("Book error: " . $error);
        error_log("Query: " . $query);
    }
}
exit();
?> 