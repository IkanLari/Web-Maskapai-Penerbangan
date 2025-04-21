<?php 
include "../server/database.php";
session_start();

// Query untuk mengambil data tiket user dengan detail penerbangan
$query = "SELECT t.*, t.total_harga as harga_tiket, p.maskapai, p.asal, p.tujuan, p.tanggal, p.waktu 
          FROM tiket_penerbangan t
          JOIN penerbangan p ON t.id_maskapai = p.id_maskapai
          WHERE t.id_user = " . $_SESSION['id'] . "
          ORDER BY p.tanggal DESC, p.waktu DESC";
          
$result = mysqli_query($db, $query);

if(!$result) {
    die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya</title>
    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header styles */
        header {
            background-color: #ff4b4b;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        header h1 {
            margin: 0;
        }

        header nav {
            display: flex;
            gap: 1rem; 
            margin-left: auto;
        }
        
        header a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        header a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Main content styles */
        main {
            flex: 1;
            padding: 2rem;
            margin: 0 auto; 
            width: calc(100% - 4rem); 
            box-sizing: border-box;
        }

        h2 {
            color: #ff4b4b;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action {
            text-align: center;
        }

        .action-links{
            text-align: right;
        }

        .action-links a {
            color: white;
            background-color: #f44336;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .action-links a:hover {
            background-color:rgb(205, 56, 45);
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        .status.pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 5px 14px;
        }

        .status.accepted {
            background-color: #d4edda;
            color: #155724;
        }

        .status.rejected {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 12.5px;
        }

        .status.progress {
            background-color: #cce5ff;
            color: #004085;
            padding: 5px 11.4px;
        }

        .total_harga{
            text-align: right; 
            margin-top: 20px; 
            font-size: 1.18em;
        }

        /* Footer styles */
        footer {
            background-color: #f5f5f5;
            padding: 1rem;
            text-align: center;
            color: #666;
        }

        footer hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 0.5rem 0;
        }

        /* Card styles */
        .ticket-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }

        .no-tickets {
            width: 100%;
            text-align: center;
            color: #666;
            padding: 40px 0;
            font-size: 1.1em;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .ticket-card {
            flex: 0 1 calc(50% - 10px);
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-width: 300px;
            max-width: calc(50% - 10px);
            position: relative;
            padding-bottom: 70px;
            box-sizing: border-box;
        }

        .airline {
            color: #ff4b4b;
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .route-info {
            margin: 10px 0;
            padding-right: 100px;
        }

        .label {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 3px;
        }

        .value {
            font-weight: bold;
            font-size: 1em;
            margin-bottom: 8px;
        }

        .price-action-container {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price {
            color: #ff4b4b;
            font-size: 1.3em;
            font-weight: bold;
        }

        .status-container {
            position: absolute;
            right: 20px;
            top: 60px;
        }

        .action-container a {
            display: inline-block;
            padding: 8px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .action-container a:hover {
            background-color: #d32f2f;
        }

        .total_harga {
            text-align: right; 
            margin-top: 30px; 
            font-size: 1.2em;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .ticket-info {
            margin: 10px 0;
            padding-right: 100px;
        }

        .ticket-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Eh-Tiket</h1>
        </div>
        <nav>
            <a href="tiketSaya.php" style="background-color: rgba(255, 255, 255, 0.4);">Tiket Saya</a>
            <a href="history.php">History</a>
            <a href="dashboardUser.php">Dashboard</a>
        </nav>
    </header>
    <main>
        <h2>Tiket Saya</h2>
        <?php
        $no = 1;
        // Hitung total harga
        $total_harga = 0;
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] !== 'rejected') {
                $total_harga += $row['harga_tiket'];
            }
            $no++;
        }
        
        // Reset counter dan pointer
        $no = 1;
        mysqli_data_seek($result, 0);
        
        // Tampilkan total harga jika ada tiket
        if (mysqli_num_rows($result) > 0) {
        ?>
        <div class="total_harga" style="margin: 15px 0 30px 0; text-align: right; background: none; box-shadow: none; padding: 0;">
            <strong>Total harga yang dibayar: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></strong>
        </div>
        <?php 
        }
        ?>
        
        <div class="ticket-container">
        <?php
        // Tampilkan tiket
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="ticket-card">
                <div class="airline"><?php echo $row['maskapai']; ?></div>
                <div class="status-container">
                    <span class="status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span>
                </div>
                <div class="route-info">
                    <div class="label">From</div>
                    <div class="value"><?php echo $row['asal']; ?></div>
                    <div class="label">To</div>
                    <div class="value"><?php echo $row['tujuan']; ?></div>
                    <div class="label">Flight Date</div>
                    <div class="value"><?php echo date('j F Y', strtotime($row['tanggal'])); ?></div>
                    <div class="label">Time</div>
                    <div class="value"><?php echo $row['waktu']; ?></div>
                </div>
                <div class="ticket-details">
                    <div>
                        <div class="label">Nomor Rekening</div>
                        <div class="value"><?php 
                            // Format nomor rekening dengan tanda hubung setiap 4 digit
                            $norek = $row['no_rekening'];
                            $formatted_rekening = '';
                            for($i = 0; $i < strlen($norek); $i++) {
                                if($i > 0 && $i % 4 === 0) {
                                    $formatted_rekening .= '-';
                                }
                                $formatted_rekening .= $norek[$i];
                            }
                            echo $formatted_rekening;
                        ?></div>
                    </div>
                    <div>
                        <div class="label">Jumlah Tiket</div>
                        <div class="value"><?php echo $row['jumlah_tiket']; ?> tiket</div>
                    </div>
                </div>
                <div class="price-action-container">
                    <div class="price">Total Harga: Rp <?php echo number_format($row['harga_tiket'], 0, ',', '.'); ?></div>
                    <div class="action-container">
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id_tiket']; ?>)">Batalkan</a>
                    </div>
                </div>
            </div>
        <?php 
            $no++;
        }
        
        if (mysqli_num_rows($result) == 0) {
            echo "<div class='no-tickets'>Belum ada tiket yang dipesan</div>";
        }
        ?>
        </div>
        <script>
            function confirmDelete(id_tiket){
                if (confirm("Anda yakin ingin membatalkan tiket penerbangan ini?")) {
                    fetch('./proses/user_proses_batalkan_tiket_penerbangan.php?id_tiket=' + id_tiket, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Tiket penerbangan telah dibatalkan");
                        location.reload();
                    })
                    .catch(error =>
                        alert("Gagal membatalkan Tiket penerbangan")
                    );
                }
            }
        </script>
    </main>
    <?php include "../layout/footer.html"?>
</body>
</html>