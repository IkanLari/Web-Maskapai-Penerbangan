<?php
include "../../server/database.php";

$id = $_GET['id'];

// Dapatkan data user berdasarkan ID untuk mendapatkan gambar profil
$pilih = mysqli_query($db, "SELECT * FROM user WHERE id = '$id'");
$data = mysqli_fetch_array($pilih);
 // $foto = $data['gambar'];

// // Hapus file gambar profil jika ada
// if (file_exists('gambar/'.$foto)) {
//     unlink('gambar/'.$foto);
// }

// Hapus data dari database
$hapus = mysqli_query($db, "DELETE FROM user WHERE id = '$id'");

// Redirect dengan status sesuai hasil query
if (!$result) {        
    $error = mysqli_error($db);
    echo "<script>alert('User gagal dihapus: " . addslashes($error) . "'); window.location.href='../kelolaUser.php';</script>";
    error_log("Error: " . $error);
    error_log("Query: " . $query);
}
exit();
?>