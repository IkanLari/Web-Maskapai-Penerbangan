<?php
include "../../server/database.php";
session_start();

if (isset($_GET['id_tiket'])) {
    $id_tiket = (int)$_GET['id_tiket'];
    
    // Update status tiket menjadi progress
    $query = "UPDATE tiket_penerbangan SET status = 'progress' WHERE id_tiket = $id_tiket";
    
    $result = mysqli_query($db, $query);
    
    if (!$result) {
        $error = mysqli_error($db);
        echo "<script>alert('Gagal mengubah status tiket: " . addslashes($error) . "'); window.location.href='../konfirmasiPembayaran.php';</script>";
        error_log("Update error: " . $error);
        error_log("Query: " . $query);
    }
} else {
    error_log("Unauthorized access attempt for ticket ID: " . $id_tiket);
}
exit();
?> 
