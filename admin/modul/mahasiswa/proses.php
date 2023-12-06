<?php
if (isset($_POST['saveMahasiswa'])) {
	$nim = $_POST['nim'];

	// Default Password
	$newPassword = "polnep";

	// Periksa apakah NIM sudah ada dalam database
	$checkExistQuery = mysqli_query($con, "SELECT * FROM mahasiswas WHERE nim='$nim'");
	$numRows = mysqli_num_rows($checkExistQuery);

	if ($numRows > 0) {
		// NIM sudah ada, tampilkan notifikasi error
		echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'NIM sudah digunakan. Masukkan NIM yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=mahasiswa&act=add');
                }, 3000);   
              </script>";
	} else {
		// NIM belum ada, lanjutkan dengan menyimpan data

		// Menggunakan password_hash
		$pass = password_hash($newPassword, PASSWORD_DEFAULT);

		// Nama gambar default yang akan digunakan
		$nama_gambar = "default_mahasiswa.png";

		// Pindahkan gambar ke folder yang diinginkan
		$target_folder = "../assets/img/mahasiswa/";
		$target_path = $target_folder . $nama_gambar;

		// Prepare statement
		$stmt = $con->prepare("INSERT INTO mahasiswas (nim, nm_mahasiswa, password, foto, kelas_id, prodi_id, jurusan_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

		// Bind parameters
		$status = 1; // Sesuaikan dengan nilai status yang diinginkan
		$stmt->bind_param("ssssssss", $nim, $_POST['nama'], $pass, $nama_gambar, $_POST['kelas'], $_POST['prodi'], $_POST['jurusan'], $status);

		// Execute statement
		$save = $stmt->execute();

		// Check for successful execution
		if ($save) {
			echo "
            <script>
                window.location='?page=mahasiswa';
            </script>";
		} else {
			echo "Error: " . $stmt->error;
		}

		// Close statement
		$stmt->close();
	}
} elseif (isset($_POST['editMahasiswa'])) {
	// Periksa apakah NIM yang akan diubah sudah ada dalam database selain data yang akan diubah
	$checkExistQuery = mysqli_query($con, "SELECT * FROM mahasiswas WHERE nim='$_POST[nim]' AND id_mahasiswa <> '$_POST[id]'");
	$numRows = mysqli_num_rows($checkExistQuery);

	if ($numRows > 0) {
		// NIM sudah ada, tampilkan notifikasi error
		echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'NIM sudah digunakan. Masukkan NIM yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
					window.location.replace('?page=mahasiswa&act=edit&id=" . $_POST['id'] . "');
                }, 3000);   
              </script>";
	} else {
		// NIM belum ada, lanjutkan dengan proses pengeditan

		// $gambar = @$_FILES['foto']['name'];
		// if (!empty($gambar)) {
		// 	move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/mahasiswa/$gambar");
		// 	$ganti = $con->prepare("UPDATE mahasiswas SET foto=? WHERE id_mahasiswa=?");
		// 	$ganti->bind_param("si", $gambar, $_POST['id']);
		// 	$ganti->execute();
		// 	$ganti->close();
		// }

		// Prepare statement untuk pengeditan
		$stmtEdit = $con->prepare("UPDATE mahasiswas SET nim=?, nm_mahasiswa=?, kelas_id=?, prodi_id=?, jurusan_id=? WHERE id_mahasiswa=?");

		// Bind parameters
		$stmtEdit->bind_param("sssssi", $_POST['nim'], $_POST['nama'], $_POST['kelas'], $_POST['prodi'], $_POST['jurusan'], $_POST['id']);

		// Execute statement
		$edit = $stmtEdit->execute();

		// Check for successful execution
		if ($edit) {
			echo "
            <script>
                window.location='?page=mahasiswa';
            </script>";
		} else {
			echo "Error: " . $stmtEdit->error;
		}

		// Close statement
		$stmtEdit->close();
	}
}
