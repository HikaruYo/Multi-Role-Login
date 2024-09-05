<?php

// Mengakhiri session
session_start();
session_unset();
session_destroy();

// Otomatis mengarah ke index.php saat session berakhir
header('location:index.php');