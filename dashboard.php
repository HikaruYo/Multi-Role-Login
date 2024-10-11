<?php
    session_start();

    // Mengecek role yang dimiliki pengguna, jika tidak ada session atau tidak login, 
    // otomatis akan kembali terarah ke index.php
    if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
        header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
        .navbar {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: lightgrey;
            align-items: center;
            flex-direction: row;
            justify-content: space-around;
            
        }
        .navbar h1 {
            margin: 10px;
        }
        .navbar .welcome {
            align-items: center;
        }
        p {
            font-size: large;
            margin: 10px;
        }
        a {
            display: flex;
            background-color: white;
            border: 1px solid black;
            border-radius: 5px;
            text-decoration: none;
            padding: 8px;
            margin: 10px;
        }
    </style>
</head>
<body>  
    <div class="dashboard">        
        <?php           
            // Pesan selamat datang sesuai role
            // $pesan = [
            //     'superadmin'=> 'Selamat Datang Tuan',
            //     'admin'=> 'Selamat Datang',
            //     'regular'=> 'Hai'
            // ];

            $role = $_SESSION['role'];
            
            switch ($role) {
                case $role == 'regular':
                    include './regular/index.php';
                    break;
                case $role == 'admin':
                    include './admin/index.php';
                    break;
                case $role == 'superadmin':
                    include './superadmin/index.php';
            }

            // $username = htmlspecialchars($_SESSION['username']);
            // echo "<h1>{$pesan[$role]}, {$username}</h1>";

        ?>
    </div>
</body>
</html>