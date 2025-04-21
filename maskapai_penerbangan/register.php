<?php 
include "server/database.php";
session_start();

$register_message = [
    'text' => "",
    'color' => ""
];

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $hash_password = hash("sha256", $password);

    if (empty($username) || empty($password) || empty($email)) {
        $register_message = [
            'text' => "Input tidak boleh kosong",
            'color' => "red"
        ];
    } else {
        try {
            $sql = "INSERT INTO user (username, role, password, email) VALUES ('$username', 'user', '$hash_password', '$email')";

            if ($db->query($sql)) {
                $register_message = [
                    'text' => "Akun berhasil dibuat",
                    'color' => "#15e600"
                ];
            } else {
                $register_message = [
                    'text' => "Username sudah digunakan",
                    'color' => "red"
                ];
            }
        } catch (mysqli_sql_exception) {
            $register_message = [
                'text' => "Gagal membuat akun",
                'color' => "red"
            ];
        }   
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            transition: background-color 0.3s;
            display: inline-block;
        }

        /* Main content styles */
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        /* Form styles */
        form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px;
        }

        form h3 {
            margin: 0 0 1.5rem 0;
            color: #ff4b4b;
            text-align: center;
            font-size: 1.5rem;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ff4b4b;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
            outline: none;
        }

        form input:focus {
            border: 2.5px solid #ff4b4b;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #ff4b4b;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-bottom: 1rem;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #f20000;
        }

        form a {
            display: block;
            text-align: center;
            color: #2196F3;
        }

        form b {
            display: block;
            color: #f44336;
            margin-bottom: 1rem;
            text-align: center;
        }

        .toggle-password {
            font-size: 14px;
            user-select: none;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .toggle-password:hover {
            opacity: 0.5;
        }

        .redirect {
            display: flex;
            justify-content: center;
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
        <a href="home.php"><h1>Eh-Tiket</h1></a>
    </header>
    <main>
        <form action="register.php" method="POST">
            <h3>Register</h3>
            <label for="username">Username:</label>
            <input type="text" placeholder="Username" name="username">
            <div class="form-group">
                <label for="password">Password:</label>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" placeholder="Masukkan password baru" style="padding-right:40px;">
                    <span toggle="#password" class="toggle-password" style="position:absolute; right:10px; top:36%; transform:translateY(-50%); cursor:pointer;">show</span>
                </div>
            </div>
            <label for="email">Email:</label>
            <input type="email" placeholder="Email" name="email">
            <b style="color: <?= $register_message['color'] ?>; display: block; margin-bottom: 1rem; text-align: center;">
                <?= $register_message['text'] ?>
            </b>
            <button type="submit" name="register">Register</button>
            <div class="redirect">Sudah punya akun?<a href="login.php" style="margin-left: 0.23rem;">Login</a></div>
        </form>
    </main>
    <script>
        // Script untuk togle 
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('toggle'));
            if (target.type === 'password') {
                target.type = 'text';
                this.textContent = 'hide';
            } else {
                target.type = 'password';
                this.textContent = 'show';
            }
        });
    </script>
</body>
</html>