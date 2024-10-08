<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <style>
        body {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            background: url(images/frieren.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }
        .index {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }
        form {
            display: flex;
            width: 100%;
            align-items: center;
            flex-direction: column;
            border-radius: 14px;
        }
        .form {
            display: flex;
            width: 370px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            border-radius: 10px;
        }
        .form-group {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90%;
        }
        .form h1 {
            margin: 10px 0 25px 0;
        }
        input {
            display: flex;
            width: 80%;
            padding: 10px 15px 10px 15px;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: medium;
        }
        button {
            display: block;
            width: 80%;
            height: 40px;
            font-size: medium;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 4px;
            border: 0px solid;
            border-radius: 14px;
            cursor: pointer;
        }
        button:hover {
            background-color: rgba(255, 255, 200, .8);
        }
        .row {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .alert-box {
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            width: 380px;
            max-width: auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="index">
    

    <form method="POST">
        <?php
            session_start();

            //Koneksi database
            include "connection.php";

            // Cek apakah ada pesan error dalam session, jika ada, ambil dan hapus setelah ditampilkan
            $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
            unset($_SESSION['error']);  // Hapus error dari session setelah ditampilkan
            
            // Login logic
            if(isset($_POST['login'])) {
                // Mengambil data dari input pengguna
                $user = $_POST['username'];
                $pass = $_POST['password'];
                
                // Mengambil data dari database dimana 'username' disimpan sebagai '$user',
                // 'password' disimpan sebagai '$pass', dan mengambil role yang dimiliki user
                
                // Perbaikan code untuk mencegah SQL Injection menggunakan prepared statements
                $stmt = $connection->prepare("SELECT users.username, roles.role FROM users JOIN roles ON users.role_id = roles.id WHERE users.username = ? AND users.password = ?");
                $stmt->bind_param("ss", $user, $pass);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();

                // Mengecek apakah data yang dikirim user sesuai atau tidak di database
                if($data) {
                    $_SESSION['role']=$data['role'];
                    $_SESSION['username']=$data['username'];
                    header('location:dashboard.php'); 
                    // Jika sesuai, session akan diatur dan pengguna akan diarahkan ke dashboard.php
                    exit(); // Hentikan eksekusi setelah pengalihan halaman
                } else {
                    // Simpan error di session dan refresh halaman
                    $_SESSION['error'] = "Akun Anda Tidak Terdaftar!";
                    header('Location: ' . $_SERVER['PHP_SELF']); // Refresh halaman untuk menampilkan error
                    exit();
                }
            }
        ?>

        <?php
            // Tampilkan error jika ada
            if (!empty($error)) {
                echo <<<HTML
                    <div class="row">
                        <div class="alert-box">
                            $error
                        </div>
                    </div>
                HTML;
            }
        ?>

        <!-- Input form -->
        <div class="form">   
            <h1>Login</h1>     
            <div class="form-group">
                <input type="username" class="username" name="username" placeholder="Username" required>
            </div>
            <br>
            <div class="form-group">
                <input type="password" class="password" name="password" placeholder="Password" required>
            </div>
            <br>
            <button name="login" type="submit">Login</button>
            <!-- Logout Function -->
            <?php

                // Jika user masih memiliki session dan mencoba untuk mengakses index.php,
                // Akan muncul tombol logout dan user dapat mengklik untuk mengakhiri session
                if (isset($_SESSION['role'])) {
                    echo '<a href="logout.php">LogOut</a>';
                };
                
                ?>
        </div>
    </form>
</div>
</body>
</html>