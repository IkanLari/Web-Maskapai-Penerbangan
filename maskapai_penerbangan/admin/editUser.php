<?php
include "../server/database.php";

// Ambil data user berdasarkan ID
if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($db, $query);
    
    if(!$result) {
        die("Query error: ".mysqli_errno($db)." - ".mysqli_error($db));
    }
    
    $user = mysqli_fetch_assoc($result);
    
    if(!$user) {
        die("User tidak ditemukan");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0 20px;
            margin: 0;
        }

        h2 {
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

        form select:hover {
            cursor: pointer;
        }

        button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #f20000;
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
    </style>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="./proses/admin_proses_edit_user.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="maskapai" <?php echo ($user['role'] == 'maskapai') ? 'selected' : ''; ?>>Maskapai</option>
            </select>
        </div>
                
        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin diubah):</label>
            <div style="position:relative;">
                <input type="password" id="password" name="password" placeholder="Masukkan password baru" style="padding-right:40px;">
                <span toggle="#password" class="toggle-password" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">show</span>
            </div>
        </div>
                
        <button type="submit">Simpan Perubahan</button>
    </form>

    <script>
        // Script untuk menutup modal setelah submit
        document.querySelector('form').addEventListener('submit', function() {
            window.parent.closeModal();
        });

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