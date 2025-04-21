<?php
include "../server/database.php";

// Ambil data penerbangan untuk mendapatkan informasi tiket
if(isset($_GET['id_maskapai'])) {
    $id_maskapai = mysqli_real_escape_string($db, $_GET['id_maskapai']);
    
    // Ambil harga tiket dari database
    $query = "SELECT harga FROM penerbangan WHERE id_maskapai = '$id_maskapai'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $harga_tiket = $row['harga'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Tiket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            height: 100vh;
            box-sizing: border-box;
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

        input {
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
            padding: 12px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            position: absolute;
            bottom: 20px;
            left: 0;
            margin: 0 20px;
            width: calc(100% - 40px);
        }

        button:hover {
            background-color: #f20000;
        }

        .warning-text {
            color: #856404;
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 0.9em;
        }

        form {
            height: calc(100% - 30px);
            position: relative;
        }

        .total-harga {
            margin-top: 20px;
            padding: 15px;
            background-color: #ffeded;
            border-radius: 4px;
            font-size: 1.1em;
            font-weight: bold;
            color: #ff4b4b;
        }
    </style>
</head>
<body>
    <h2>Form Pemesanan Tiket</h2>
    <form method="POST" action="./proses/user_proses_pesan_tiket.php">
        <input type="hidden" name="id_maskapai" id="id_maskapai" value="<?php echo isset($_GET['id_maskapai']) ? $_GET['id_maskapai'] : ''; ?>">
        <input type="hidden" name="harga_tiket" id="harga_tiket" value="<?php echo isset($harga_tiket) ? $harga_tiket : 0; ?>">
        <input type="hidden" name="total_harga" id="total_harga" value="">
        
        <div class="form-group">
            <label for="no_rekening">Nomor Rekening:</label>
            <input type="text" id="no_rekening" name="no_rekening" placeholder="Masukkan nomor rekening untuk pembayaran tiket" required>
            <input type="hidden" id="no_rekening_clean" name="no_rekening_clean">
        </div>
        
        <div class="form-group">
            <label for="jumlah_tiket">Jumlah Tiket:</label>
            <input type="number" id="jumlah_tiket" name="jumlah_tiket" placeholder="Masukkan jumlah tiket yang ingin dipesan" required>
        </div>

        <div class="total-harga" id="displayTotalHarga">
            Total Harga: Rp 0
        </div>
        
        <button type="submit">Pesan Tiket</button>
    </form>

    <script>
        const hargaTiket = <?php echo isset($harga_tiket) ? $harga_tiket : 0; ?>;
        const totalHargaDisplay = document.getElementById('displayTotalHarga');
        const totalHargaInput = document.getElementById('total_harga');
        const jumlahTiketInput = document.getElementById('jumlah_tiket');
        
        // Format number to currency
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Function to clear ticket input
        function clearTicketInput() {
            jumlahTiketInput.value = '';
            totalHargaDisplay.textContent = 'Total Harga: Rp 0';
            totalHargaInput.value = '0';
        }

        // Hitung total harga saat jumlah tiket berubah
        jumlahTiketInput.addEventListener('input', function(e) {
            if (this.value < 0) this.value = 0;
            const jumlahTiket = parseInt(this.value) || 0;
            const totalHarga = jumlahTiket * hargaTiket;
            
            totalHargaDisplay.textContent = `Total Harga: Rp ${formatRupiah(totalHarga)}`;
            totalHargaInput.value = totalHarga;
        });

        document.getElementById('no_rekening').addEventListener('input', function(e) {
            // Hapus karakter non-digit
            let cleaned = this.value.replace(/\D/g, '');
            
            // Batasi panjang input
            cleaned = cleaned.substring(0, 16);
            
            // Format dengan tanda hubung
            let formatted = '';
            for(let i = 0; i < cleaned.length; i++) {
                if(i > 0 && i % 4 === 0) {
                    formatted += '-';
                }
                formatted += cleaned[i];
            }
            
            // Update nilai yang ditampilkan
            this.value = formatted;
            
            // Simpan nilai bersih (tanpa tanda hubung) ke hidden input
            document.getElementById('no_rekening_clean').value = cleaned;
        });

        // Sebelum form di-submit, pastikan menggunakan nilai bersih
        document.querySelector('form').addEventListener('submit', function(e) {
            const cleanValue = document.getElementById('no_rekening_clean').value;
            document.getElementById('no_rekening').value = cleanValue;
            window.parent.closeModal();
        });
    </script>
</body>
</html>