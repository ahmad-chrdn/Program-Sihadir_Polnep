<?php
// Periksa apakah parameter id yang diterima adalah angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	// Gunakan parameter binding untuk mencegah SQL Injection
	$id_mahasiswa = mysqli_real_escape_string($con, $_GET['id']);

	// Hapus data dengan parameter yang aman
	$del = mysqli_query($con, "DELETE FROM mahasiswas WHERE id_mahasiswa='$id_mahasiswa'");

	if ($del) {
		echo "<script>
            // alert('Data telah dihapus !');
            window.location='?page=mahasiswa';
        </script>";
	} else {
		// Tampilkan pesan kesalahan jika query tidak berhasil
		echo "Error: " . mysqli_error($con);
	}
} else {
	// Tampilkan pesan kesalahan jika parameter id tidak valid
	echo "ID tidak valid.";
}
