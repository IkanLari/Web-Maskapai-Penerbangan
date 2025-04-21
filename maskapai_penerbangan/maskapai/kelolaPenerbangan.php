<?php 
include "../server/database.php";
session_start();

$query_maskapai = "SELECT * FROM user WHERE role = 'maskapai'";
$result = mysqli_query($db, $query_maskapai);

if(!$result) {
    die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penerbangan</title>
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

        .add {
            color: white;
            background-color: #28a745;
            text-decoration: none;
            padding: 8px;
            border-radius: 3px;
            font-weight: bold;
        }

        .add:hover {
            background-color: rgb(34, 134, 58);
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
            text-align: center;
        }

        .action-links a {
            color: white;
            background-color: #2196F3;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .action-links a:hover {
            background-color:rgb(27, 122, 199);
        }

        .action-links a.hapus {
            color: white;
            background-color: #f44336;
        }

        .action-links a.hapus:hover {
            background-color:rgb(205, 56, 45);
        }

        /* Modal styles */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-iframe {
            width: 50%;
            height: 70%;
            border: none;
            background: white;
            border-radius: 5px;
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
            <a href="kelolaPenerbangan.php" style="background-color: rgba(255, 255, 255, 0.4);">Kelola Penerbangan</a>
            <a href="konfirmasiCustomer.php">Konfirmasi Customer</a>
            <a href="history.php">History</a>
            <a href="dashboardMaskapai.php">Dashboard</a>
        </nav>
    </header>
    <main>
        <h2>All Flight</h2>
        <br>
        <a href="javascript:void(0);" class="add" onclick="addFlight()">Tambah penerbangan</a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Maskapai</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal keberangkatan</th>
                    <th>Jam terbang</th>
                    <th>Harga tiket</th>
                    <th class="action">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM penerbangan WHERE maskapai = '".$_SESSION['username']."'";
                $result = mysqli_query($db, $query);

                if(!$result) {
                    die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
                }

                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $row['maskapai']; ?></td>
                    <td><?php echo $row['asal']; ?></td>
                    <td><?php echo $row['tujuan']; ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['waktu']; ?></td>
                    <td><?php echo 'Rp ' . number_format((float)$row['harga'], 0, ',', '.'); ?></td>
                    <td class="action-links">
                        <a href="javascript:void(0);" class="edit" onclick="popUpEdit(<?php echo $row['id_maskapai']; ?>)">Edit</a>
                        <a href="javascript:void(0);" class="hapus" onclick="confirmDelete(<?php echo $row['id_maskapai']; ?>)">Hapus</a>
                    </td>
                </tr>
                <?php 
                $no++;
                }
                ?>
            </tbody>
        </table>

        <div id="modalContainer" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
            <div style="background:white; padding:20px; border-radius:5px; width:50%; position:relative;">
                <span onclick="closeModal()" style="position:absolute; top:10px; right:10px; cursor:pointer; font-size:20px;">&times;</span>
                <iframe id="editFrame" style="width:100%; height:400px; border:none;"></iframe>
            </div>
        </div>

        <script>
            function addFlight() {
                const modal = document.getElementById('modalContainer');
                const frame = document.getElementById('editFrame');
                
                frame.src = `tambahPenerbangan.php`;
                modal.style.display = 'flex';
                
                // Menangani pengiriman form dari iframe
                window.addEventListener('message', function(e) {
                    if (e.data === 'closeModal') {
                        closeModal();
                        location.reload();
                    }
                });
                
                frame.onload = function() {
                    frame.contentWindow.scrollTo(0, 0);
                };
            }

            function confirmDelete(id_maskapai){
                if (confirm("Anda yakin ingin menghapus data ini?")) {
                    fetch('./proses/maskapai_proses_hapus_penerbangan.php?id_maskapai=' + id_maskapai, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Penerbangan telah dibatalkan");
                        location.reload();
                    })
                    .catch(error =>
                        alert("Gagal membatalkan penerbangan")
                    );
                }
            }
            
            function popUpEdit(id_maskapai) {
                const modal = document.getElementById('modalContainer');
                const frame = document.getElementById('editFrame');
                
                frame.src = `editPenerbangan.php?id_maskapai=${id_maskapai}`;
                modal.style.display = 'flex';
                
                // Menangani response dari iframe
                window.addEventListener('message', function(e) {
                    if (e.data.action === 'closeModal') {
                        closeModal();
                        if (e.data.success) {
                            alert(e.data.message);
                            location.reload();
                        } else {
                            alert(e.data.message);
                        }
                    }
                }, {once: true});
                
                frame.onload = function() {
                    frame.contentWindow.scrollTo(0, 0);
                };
            }
            
            function closeModal() {
                document.getElementById('modalContainer').style.display = 'none';
                document.getElementById('editFrame').src = '';
            }

            // Tutup modal saat klik di luar konten
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('modalContainer');
                if (event.target === modal) {
                    closeModal();
                }
            });
        </script>
    </main>
    <?php include "../layout/footer.html"?>
</body>
</html>