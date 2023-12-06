<?php
if (isset($_POST['saveDosen'])) {
	$nip = $_POST['nip'];

	// Default Password
	$newPassword = "polnep";

	// Periksa apakah NIP sudah ada dalam database
	$checkExistQuery = mysqli_query($con, "SELECT * FROM dosens WHERE nip='$nip'");
	$numRows = mysqli_num_rows($checkExistQuery);

	if ($numRows > 0) {
		// NIP sudah ada, tampilkan notifikasi error
		echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'NIP sudah digunakan. Masukkan NIP yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=dosen&act=add');
                }, 3000);   
              </script>";
	} else {
		// NIP belum ada, lanjutkan dengan menyimpan data

		// Menggunakan password_hash
		$pass = password_hash($newPassword, PASSWORD_DEFAULT);

		// Nama gambar default yang akan digunakan
		$nama_gambar = "default_dosen.png";

		// Pindahkan gambar ke folder yang diinginkan
		$target_folder = "../assets/img/dosen/";
		$target_path = $target_folder . $nama_gambar;

		// Prepare statement
		$stmt = $con->prepare("INSERT INTO dosens (nip, nm_dosen, password, foto, status) VALUES (?, ?, ?, ?, ?)");

		// Bind parameters
		$status = 1; // Sesuaikan dengan nilai status yang diinginkan
		$stmt->bind_param("ssssi", $_POST['nip'], $_POST['nama'], $pass, $nama_gambar, $status);

		// Execute statement
		$save = $stmt->execute();

		// Check for successful execution
		if ($save) {
			echo "
            <script>
                window.location='?page=dosen';
            </script>";
		} else {
			echo "Error: " . $stmt->error;
		}

		// Close statement
		$stmt->close();
	}
} elseif (isset($_POST['editDosen'])) {
	// Periksa apakah NIP yang akan diubah sudah ada dalam database selain data yang akan diubah
	$checkExistQuery = mysqli_query($con, "SELECT * FROM dosens WHERE nip='$_POST[nip]' AND id_dosen <> '$_POST[id]'");
	$numRows = mysqli_num_rows($checkExistQuery);

	if ($numRows > 0) {
		// NIP sudah ada, tampilkan notifikasi error
		echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'NIP sudah digunakan. Masukkan NIP yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
					window.location.replace('?page=dosen&act=edit&id=" . $_POST['id'] . "');
                }, 3000);   
              </script>";
	} else {
		// NIP belum ada, lanjutkan dengan proses pengeditan

		// $gambar = @$_FILES['foto']['name'];
		// if (!empty($gambar)) {
		// 	move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/dosen/$gambar");
		// 	$ganti = $con->prepare("UPDATE dosens SET foto=? WHERE id_dosen=?");
		// 	$ganti->bind_param("si", $gambar, $_POST['id']);
		// 	$ganti->execute();
		// 	$ganti->close();
		// }

		// Prepare statement untuk pengeditan
		$stmtEdit = $con->prepare("UPDATE dosens SET nip=?, nm_dosen=? WHERE id_dosen=?");

		// Bind parameters
		$stmtEdit->bind_param("ssi", $_POST['nip'], $_POST['nama'], $_POST['id']);

		// Execute statement
		$editDosen = $stmtEdit->execute();

		// Check for successful execution
		if ($editDosen) {
			echo "
            <script>
                window.location='?page=dosen';
            </script>";
		} else {
			echo "Error: " . $stmtEdit->error;
		}

		// Close statement
		$stmtEdit->close();
	}
}
