<?php 
session_start();

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: ../home.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        }

        header h1 {
            margin: 0;
        }

        header nav {
            display: flex;
            gap: 1rem; 
            margin-left: auto;
        }

        button {
            color: white;
            background-color: #2195f300;
            border-width: 0;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: medium;
        }
        header a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        header a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Main content styles */
        main {
            flex: 1;
            padding: 2rem;
            text-align: center;
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
            <a href="kelolaUser.php">Kelola User</a>
            <a href="tambahMaskapai.php">Tambah Maskapai</a>
            <a href="showDataPenerbangan.php">Data Penerbangan</a>
            <a href="konfirmasiPembayaran.php">Konfirmasi Pembayaran</a>
            <a href="history.php">History</a>
            <form action="dashboardAdmin.php" method="POST">
                <button type="submit" name="logout" value="Logout">Logout</button>
            </form>
        </nav>
    </header>
    <main>
        <h3>Selamat datang <?= $_SESSION["username"] ?> (Admin Only)</h3>
    </main>
    <?php include "../layout/footer.html"?>
</body>
</html>