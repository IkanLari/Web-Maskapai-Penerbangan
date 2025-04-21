<?php
include "../server/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penerbangan</title>
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
    <h2>Tambah Penerbangan Baru</h2>
    <form method="POST" action="./proses/maskapai_proses_tambah_penerbangan.php">
        <div class="form-group">
            <label for="asal">Asal:</label>
            <input type="text" id="asal" name="asal" required>
        </div>
        
        <div class="form-group">
            <label for="tujuan">Tujuan:</label>
            <input type="text" id="tujuan" name="tujuan" required>
        </div>
        
        <div class="form-group">
            <label for="tanggal">Tanggal Keberangkatan:</label>
            <input type="date" id="tanggal" name="tanggal" required>
        </div>
        
        <div class="form-group">
            <label for="waktu">Jam Terbang:</label>
            <input type="time" id="waktu" name="waktu" required>
        </div>
        
        <div class="form-group">
            <label for="harga">Harga Tiket:</label>
            <input type="text" id="harga" name="harga" value="<?php echo isset($row['harga']) ? number_format($row['harga'], 0, ',', '.') : ''; ?>" required>
        </div>
        
        <button type="submit">Tambah</button>
    </form>
    <script>
        // Format input saat mengetik
        document.getElementById('harga').addEventListener('input', function(e) {
            // Batasi maksimal 21 digit (karena 22 digit sudah bermasalah)
            if (this.value.replace(/\D/g,'').length > 21) {
                this.value = this.value.slice(0, -1);
                return;
            }
            
            // Format ke Rupiah
            let num = this.value.replace(/\D/g,'');
            if(num.length > 0) {
                this.value = 'Rp ' + num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            } else {
                this.value = '';
            }
        });


        // Script untuk menutup modal setelah submit dan mengembalikan ke format angka biasa
        document.querySelector('form').addEventListener('submit', function() {
            const hargaInput = document.getElementById('harga');
            hargaInput.value = hargaInput.value.replace(/[^0-9]/g, '');
            window.parent.closeModal();
        });
    </script>
</body>
</html>