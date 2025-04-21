<?php
include "../server/database.php";
session_start();

// Mengambil data penerbangan berdasarkan ID
if(isset($_GET['id_maskapai'])) {
    $id = $_GET['id_maskapai'];
    $query = "SELECT * FROM penerbangan WHERE id_maskapai = $id AND maskapai = '".$_SESSION['username']."'";
    $result = mysqli_query($db, $query);
    
    if(!$result) {
        die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
    }
    
    $flight = mysqli_fetch_assoc($result);
    
    if(!$flight) {
        die("Penerbangan tidak ditemukan");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerbangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
        }

        h2 {
            margin-top: 0;
            color: #ff4b4b;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ff4b4b;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
        }
        
        form input:focus {
            border: 2.5px solid #ff4b4b;
        }

        button {
            background-color: #ff4b4b;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        button:hover {
            background-color: #f20000;
        }
    </style>
</head>
<body>
    <h2>Edit Penerbangan</h2>
    <form method="POST" action="./proses/maskapai_proses_edit_penerbangan.php">
        <input type="hidden" name="id_maskapai" value="<?php echo $flight['id_maskapai']; ?>">
        
        <div class="form-group">
            <label for="asal">Asal:</label>
            <input type="text" id="asal" name="asal" value="<?php echo htmlspecialchars($flight['asal']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="tujuan">Tujuan:</label>
            <input type="text" id="tujuan" name="tujuan" value="<?php echo htmlspecialchars($flight['tujuan']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="tanggal">Tanggal Keberangkatan:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo $flight['tanggal']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="waktu">Jam Terbang:</label>
            <input type="time" id="waktu" name="waktu" value="<?php echo $flight['waktu']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="harga">Harga Tiket:</label>
            <input type="text" id="harga" name="harga" 
                   value="<?php echo 'Rp ' . number_format($flight['harga'], 0, ',', '.'); ?>" 
                   oninput="formatCurrency(this)" required>
        </div>
        
        <button type="submit">Simpan Perubahan</button>
    </form>

    <script>
        // Format currency input
        function formatCurrency(input) {
            // Menghapus karakter non-digit
            let value = input.value.replace(/[^0-9]/g, '');
            
            // Format ke currency
            if(value.length > 0) {
                value = parseInt(value, 10);
                input.value = 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            } else {
                input.value = '';
            }
        }
        
        // Menghapus formatting sebelum disubmit
        document.querySelector('form').addEventListener('submit', function() {
            const hargaInput = document.getElementById('harga');
            hargaInput.value = hargaInput.value.replace(/[^0-9]/g, '');
        });

        // Script untuk menutup modal setelah submit
        document.querySelector('form').addEventListener('submit', function() {
            window.parent.closeModal();
        });
    </script>
</body>
</html>