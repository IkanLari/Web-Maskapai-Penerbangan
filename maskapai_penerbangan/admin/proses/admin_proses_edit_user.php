<?php
include "../../server/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $role = mysqli_real_escape_string($db, $_POST['role']);
    
    // Jika password diisi, update password dengan hash SHA256
    if (!empty($_POST['password'])) {
            $password = hash('sha256', $_POST['password']);
            $query = "UPDATE user SET 
                    username = '$username', 
                    email = '$email', 
                    role = '$role', 
                    password = '$password' 
                    WHERE id = $id";
    } else {
        $query = "UPDATE user SET 
                username = '$username', 
                email = '$email', 
                role = '$role' 
                WHERE id = $id";
    }
        
    $result = mysqli_query($db, $query);
        
    if ($result) {
        echo "<script>alert('Data user berhasil diupdate'); window.parent.location.reload();</script>";
    } else {
        $error = mysqli_error($db);
        echo "<script>alert('Gagal mengupdate data user: " . addslashes($error) . "');</script>";
        error_log("Update error: " . $error);
        error_log("Query: " . $query);
    }
}
exit();
?> 