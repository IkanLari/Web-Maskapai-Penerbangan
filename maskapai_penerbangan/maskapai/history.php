<?php 
include "../server/database.php";
session_start();

// Query untuk mengambil data tiket yang terkait dengan maskapai yang sedang login
$query = "SELECT t.*, t.total_harga as harga_tiket, p.maskapai, p.asal, p.tujuan, p.tanggal, p.waktu, u.username as nama_user
          FROM tiket_penerbangan t
          JOIN penerbangan p ON t.id_maskapai = p.id_maskapai
          JOIN user u ON t.id_user = u.id
          WHERE p.maskapai = '" . $_SESSION['username'] . "'
          AND t.status IN ('accepted', 'rejected')
          ORDER BY t.waktu_pemesanan DESC";
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
    <title>History</title>
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

        .center {
            text-align: center;
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Eh-Tiket</h1>
        </div>
        <nav>
            <a href="kelolaPenerbangan.php">Kelola Penerbangan</a>
            <a href="konfirmasiCustomer.php">Konfirmasi Customer</a>
            <a href="history.php" style="background-color: rgba(255, 255, 255, 0.4);">History</a>
            <a href="dashboardMaskapai.php">Dashboard</a>
        </nav>
    </header>
    <main>
        <h2>History</h2>
        <table>
            <thead>
                <tr>
                    <th class="center">Jumlah Tiket</th>
                    <th>Nama User</th>
                    <th>Maskapai</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Waktu Pemesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td class="center"><?php echo $row['jumlah_tiket']; ?></td>
                    <td><?php echo $row['nama_user']; ?></td>
                    <td><?php echo $row['maskapai']; ?></td>
                    <td><?php echo $row['asal']; ?></td>
                    <td><?php echo $row['tujuan']; ?></td>
                    <td><?php echo date('j F Y', strtotime($row['tanggal'])); ?></td>
                    <td><?php echo $row['waktu']; ?></td>
                    <td>Rp <?php echo number_format($row['harga_tiket'], 0, ',', '.'); ?></td>
                    <td><span class="status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><?php echo $row['waktu_pemesanan']; ?></td>
                </tr>
                <?php 
                }
                if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='10' style='text-align: center;'>Belum ada tiket yang direspon</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php include "../layout/footer.html"?>
</body>
</html>
