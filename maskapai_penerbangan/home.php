<!-- <?php 
session_start();

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: home.php");
}
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .logo {
            flex: 0 0 auto;
        }

        header h1 {
            margin: 0;
        }

        header nav {
            display: flex;
            gap: 1.5rem;
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
            text-align: center;
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Eh-Tiket</h1>
        </div>
        <nav>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>
    <main>
        <p>Mau beli tiket pesawat? Eh-Tiket in aja</p>
        <!-- <form action="home.php" method="POST">
            <button type="submit" name="logout" value="Logout">Logout</button>
        </form> -->
    </main>
    <?php include "layout/footer.html"?>
</body>
</html>