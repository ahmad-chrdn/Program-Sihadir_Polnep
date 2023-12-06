<?php
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$status = isset($_GET['status']) ? $_GET['status'] : 0;

// Validasi tipe data dan nilai yang diharapkan
$id = is_numeric($id) ? (int) $id : 0;
$status = in_array($status, [0, 1]) ? (int) $status : 0;

// Gunakan prepared statement
$query = ($status == 0) ? "UPDATE dosens SET status=0 WHERE id_dosen=?" : "UPDATE dosens SET status=1 WHERE id_dosen=?";
$stmt = mysqli_prepare($con, $query);

// Bind parameter
mysqli_stmt_bind_param($stmt, "i", $id);

// Eksekusi statement
mysqli_stmt_execute($stmt);

// Periksa apakah query berhasil dieksekusi
if ($stmt) {
  // Query berhasil dieksekusi
  echo "<script>window.location='?page=dosen';</script>";
} else {
  // Query gagal
  echo "Error: " . mysqli_error($con);
}

// Tutup statement
mysqli_stmt_close($stmt);
