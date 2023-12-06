<?php
// Gantilah dengan koneksi ke database yang sesuai
$con = mysqli_connect("localhost", "root", "", "hadir");

// Username dan password baru
$username = "3202116083";
$newPassword = "polnep";

// Enkripsi password baru
$newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password di database
mysqli_query($con, "UPDATE `mahasiswas` SET `password` = '$newHashedPassword' WHERE `nim` = '$username'");
