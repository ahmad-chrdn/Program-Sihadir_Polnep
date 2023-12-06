<?php
session_start();

// Membersihkan variabel sesi yang spesifik (jika diperlukan)
unset($_SESSION['admin']);

// Mengarahkan ulang ke halaman login.php menggunakan header
header("Location: ./index.php");
exit();
