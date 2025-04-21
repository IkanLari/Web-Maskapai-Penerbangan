<?php 
include "../server/database.php";
session_start();

$query_tiket = "SELECT * FROM penerbangan ORDER BY maskapai ASC, asal ASC, tujuan ASC, tanggal ASC, waktu ASC";
$result = mysqli_query($db, $query_tiket);

if(!$result) {
    die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
}

// Kelompokin penerbangan berdasarkan maskapai
$flights_by_airline = [];
while($row = mysqli_fetch_assoc($result)) {
    $flights_by_airline[$row['maskapai']][] = $row;
}

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: ../home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        html {
            height: 100%;
            margin: 0;
        }
        
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

        button {
            color: white;
            background-color: #2195f300;
            border-width: 0;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: medium;
        }

        button:hover {
            background-color: rgba(255,255,255,0.2);
        }

        /* Main content styles */
        main {
            flex: 1;
            padding: 2rem;
            text-align: center;
            margin-top: 0;
        }

        main p {
            font-size: 1.5rem;
            color: #333;
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

        /* Flight cards container */
        .flight-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Flight card style */
        .flight-card {
            width: calc(22% - 20px); /* 4 cards per row with gap */
            min-width: 250px;
            border: 1px solid #ddd;
            background-color: #ff4b4b;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .flight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .airline {
            font-weight: bold;
            font-size: 1.2rem;
            color: white;
            margin-bottom: 5px;
        }

        .flight-route {
            background-color: white;
            color: #ff4b4b;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: Calibri, sans-serif;
            font-size: 1.05rem;
            font-weight: bold;
        }

        .labeling {
            color: white;
            margin: 10px 0;
        }

        .detailed-description{
            display: flex; 
            justify-content: space-between; 
            margin-top: 10px;
        }

        .flight-date {
            margin: 15px 0;
            font-size: 1rem;
            color: white;
        }

        .price {
            font-size: 1.3rem;
            font-weight: bold;
            color: white;
            margin: 15px 0 10px;
        }

        .book-btn {
            background-color: white;
            color: #ff4b4b;
            border: none;
            padding: 12px 0;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            margin: 5px 0;
            display: inline-block;
            text-decoration: none;
        }

        .book-btn:hover {
            background-color: #f2f2f2;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }

        /* Airline row style */
        .airline-row {
            width: 100%;
            margin-bottom: 30px;
            padding-bottom: 15px;
        }

        .airline-header {
            display: flex;
            justify-content: flex-start;
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff4b4b;
            margin-bottom: 15px;
            padding-left: 10px;
        }

        .airline-flights {
            display: flex;
            flex-wrap: wrap;
            gap: 33px;
            justify-content: flex-start;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .flight-card {
                width: calc(33.33% - 20px);
            }
        }

        @media (max-width: 900px) {
            .flight-card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 600px) {
            .flight-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Eh-Tiket</h1>
        </div>
        <nav>            
            <a href="tiketSaya.php">Tiket Saya</a>
            <a href="history.php">History</a>
            <form action="dashboardUser.php" method="POST">
                <button type="submit" name="logout" value="Logout">Logout</button>
            </form>
        </nav>
    </header>
    <main>
        <h3>Selamat datang <?php echo $_SESSION["username"] ?> (User Only)</h3>
        <h1>Pesan Tiket Penerbanganmu Sekarang :)</h1>

        <div class="flight-container">
            <?php foreach($flights_by_airline as $airline => $flights): ?>
                <div class="airline-row">
                    <div class="airline-header"><?php echo $airline ?> ></div>
                    <div class="airline-flights">
                        <?php foreach($flights as $row): ?>
                            <div class="flight-card">
                                <div class="airline"><?php echo $row['maskapai'] ?></div>
                                <div class="labeling">From</div>
                                <div class="flight-route"><?php echo $row['asal'] ?></div>
                                <div class="labeling">To</div>
                                <div class="flight-route"><?php echo $row['tujuan'] ?></div>
                                <div class="detailed-description">
                                    <div>
                                        <div class="labeling">Flight Date:</div>
                                        <div class="flight-date"><b><?php echo date('j F Y', strtotime($row['tanggal'])); ?></b></div>
                                    </div>
                                    <div>
                                        <div class="labeling">Time:</div>
                                        <div class="flight-date"><b><?php echo $row['waktu'] ?></b></div>
                                    </div>
                                </div>
                                <div class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></div>
                                <a href="javascript:void(0);" class="book-btn" onclick="addTicket(<?php echo $row['id_maskapai'] ?>)"><b>Pesan Sekarang →</b></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="modalContainer" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
            <div style="background:white; padding:20px; border-radius:5px; width:50%; position:relative;">
                <span onclick="closeModal()" style="position:absolute; top:10px; right:10px; cursor:pointer; font-size:20px;">&times;</span>
                <iframe id="editFrame" style="width:100%; height:400px; border:none;"></iframe>
            </div>
        </div>

        <script>
            function addTicket(id_maskapai) {
                const modal = document.getElementById('modalContainer');
                const frame = document.getElementById('editFrame');
                
                frame.src = `pesanTiket.php?id_maskapai=${id_maskapai}`;
                modal.style.display = 'flex';
                
                // Handle message from iframe
                window.addEventListener('message', function(e) {
                    if (e.data === 'closeModal') {
                        closeModal();
                        location.reload();
                    }
                });
            }
            
            function closeModal() {
                document.getElementById('modalContainer').style.display = 'none';
                document.getElementById('editFrame').src = '';
            }

            // Close modal when clicking outside
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