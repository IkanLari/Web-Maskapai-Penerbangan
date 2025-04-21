<?php
include "../../server/database.php";

$id_maskapai = $_GET['id_maskapai'];

// Dapatkan data user berdasarkan ID untuk mendapatkan gambar profil
$pilih = mysqli_query($db, "SELECT * FROM penerbangan WHERE id_maskapai = '$id_maskapai'");
$data = mysqli_fetch_array($pilih);
// $foto = $data['gambar'];

// // Hapus file gambar profil jika ada
// if (file_exists('gambar/'.$foto)) {
//     unlink('gambar/'.$foto);
// }

// Hapus data dari database
$hapus = mysqli_query($db, "DELETE FROM penerbangan WHERE id_maskapai = '$id_maskapai'");

// Redirect dengan status sesuai hasil query
if (!$result) {        
    $error = mysqli_error($db);
    echo "<script>alert('Penerbangan gagal dihapus: " . addslashes($error) . "'); window.location.href='../kelolaPenerbangan.php';</script>";
    error_log("Error: " . $error);
    error_log("Query: " . $query);        
} else {
    echo "<script>alert('Penerbangan berhasil dihapus'); window.location.href='../kelolaPenerbangan.php';</script>";
    header("location: ../kelolaPenerbangan.php");
}
exit();
?>