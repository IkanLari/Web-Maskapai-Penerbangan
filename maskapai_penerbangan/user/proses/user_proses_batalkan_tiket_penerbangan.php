<?php
include "../../server/database.php";

$id_tiket = $_GET['id_tiket'];

// Dapatkan data user berdasarkan ID untuk mendapatkan gambar profil
$pilih = mysqli_query($db, "SELECT * FROM tiket_penerbangan WHERE id_tiket = '$id_tiket'");
$data = mysqli_fetch_array($pilih);
// $foto = $data['gambar'];

// // Hapus file gambar profil jika ada
// if (file_exists('gambar/'.$foto)) {
//     unlink('gambar/'.$foto);
// }

// Hapus data dari database
$hapus = mysqli_query($db, "DELETE FROM tiket_penerbangan WHERE id_tiket = '$id_tiket'");

// Redirect dengan status sesuai hasil query
if (!$result) {
    $error = mysqli_error($db);
    echo "<script>alert('Tiket penerbangan gagal dibatalkan: " . addslashes($error) . "'); window.location.href='../tiketSaya.php';</script>";
    error_log("Error: " . $error);
    error_log("Query: " . $query);
} else {
    echo "<script>alert('Tiket penerbangan berhasil dibatalkan'); window.location.href='../tiketSaya.php';</script>";
    header("location: ../tiketSaya.php");
}
exit();
?>