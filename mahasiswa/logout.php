<?php
session_start();

// Membersihkan variabel sesi yang spesifik (jika diperlukan)
unset($_SESSION['mahasiswa']);

// Mengarahkan ulang ke halaman login.php menggunakan header
header("Location: ../");
exit();
