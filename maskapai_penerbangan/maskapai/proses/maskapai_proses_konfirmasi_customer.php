<?php
include "../../server/database.php";
session_start();

if (isset($_GET['id_tiket']) && isset($_GET['status'])) {
    $id_tiket = (int)$_GET['id_tiket'];
    $status = $_GET['status'];
    
    // Verifikasi bahwa tiket tersebut milik maskapai yang sedang login
    $verify_query = "SELECT p.maskapai 
                    FROM tiket_penerbangan t 
                    JOIN penerbangan p ON t.id_maskapai = p.id_maskapai 
                    WHERE t.id_tiket = $id_tiket";
    $verify_result = mysqli_query($db, $verify_query);
    $verify_data = mysqli_fetch_assoc($verify_result);
    
    if ($verify_data && $verify_data['maskapai'] === $_SESSION['username']) {
        // Update status tiket
        $query = "UPDATE tiket_penerbangan SET status = '$status' WHERE id_tiket = $id_tiket";
        
        $result = mysqli_query($db, $query);
        
        if (!$result) {
            $error = mysqli_error($db);
            error_log("Update error: " . $error);
            error_log("Query: " . $query);
        }
    } else {
        error_log("Unauthorized access attempt for ticket ID: " . $id_tiket);
    }
}
exit();
?>
