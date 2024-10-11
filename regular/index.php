<?php
    session_start();

    // Mengecek role yang dimiliki pengguna, jika tidak ada session atau tidak login, 
    // otomatis akan kembali terarah ke index.php
    if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
        header('location:index.php');
    }
?>


<div class="dashboard">
    <nav class="navbar">
        <div class="welcome">
            <p>Anda login sebagai: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            
            <?php           
            // Pesan selamat datang sesuai role
            $role = $_SESSION['role'];
            $username = htmlspecialchars($_SESSION['username']);
            echo "<h1>Hai, {$username}</h1>";
            
            ?>
        </div>

        <!-- Logout Function -->
        <a href="logout.php">LogOut</a>
    </nav>
</div>