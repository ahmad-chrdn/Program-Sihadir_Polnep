<?php
@session_start();
include '../config/db.php';

$id_dosen = isset($_SESSION['dosen']) ? $_SESSION['dosen'] : null;

if (!$id_dosen) {
?>
	<script>
		alert('Maaf ! Anda Belum Login !!');
		window.location = '../user.php';
	</script>
<?php
	exit; // tambahkan exit untuk menghentikan eksekusi lebih lanjut setelah melakukan redirect
}

$hari = hari_ini(); // Memanggil fungsi hari_ini() yang berada di file PHP lain
// Data Presensi
$query = mysqli_query($con, "SELECT COUNT(CASE WHEN pd.status_dosen = 'Hadir' THEN 1 END) AS jumlah_hadir,
    COUNT(CASE WHEN pd.status_dosen = 'Tidak Hadir' THEN 1 END) AS jumlah_tidakHadir
    FROM presensi_dosens pd
    INNER JOIN jadwals j ON pd.jadwal_id = j.id_jadwal
    INNER JOIN semesters ON j.semester_id = semesters.id_semester
    WHERE j.hari = '$hari'
    AND semesters.status = 1
    AND pd.dosen_id = '$id_dosen'");

// Mengambil data
$jumlah_hadir = 0; // inisialisasi variabel
$jumlah_tidakHadir = 0; // inisialisasi variabel

if ($query) {
	$row = mysqli_fetch_assoc($query);
	$jumlah_hadir = $row['jumlah_hadir'];
	$jumlah_tidakHadir = $row['jumlah_tidakHadir'];
} else {
	die('Error: ' . mysqli_error($con));
}

$sql = mysqli_query($con, "SELECT * FROM dosens WHERE id_dosen = '$id_dosen'");

if (!$sql) {
	die('Error: ' . mysqli_error($con));
}

$data = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Dosen | Aplikasi Absensi</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/Logo_Polnep.png" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['../assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets/css/demo.css">
</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="dashboard.php" class="logo">
					<img src="../assets/img/Sihadir.png" alt="Logo" class="logo-image" style="width: 120px; height: auto;">
					<!-- <img src="../assets/img/Slogan.png" alt="navbar brand" class="navbar-brand" width="40"> -->
					<!-- <b class="text-white">Sihadir | Polnep</b> -->
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<a href="dashboard.php" class="logo">
							<img src="../assets/img/Slogan.png" alt="Logo" class="logo-image" style="width: 240px; height: auto;">
						</a>
					</div>
					<!-- <div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>
					</div> -->
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<!-- <li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li> -->

						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="../assets/img/dosen/<?= $data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="../assets/img/dosen/<?= $data['foto'] ?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>
													<?= $data['nm_dosen'] ?>
												</h4>
												<p class="text-muted">
													<?= $data['nip'] ?>
												</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#gantiPassword" class="collapsed">Ganti Password</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#pengaturanAkun" class="collapsed">Account Setting</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="logout.php">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="../assets/img/dosen/<?= $data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									<?= $data['nm_dosen'] ?>
									<span class="user-level"><?= $data['nip'] ?></span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">

									<li>
										<a href="#" data-toggle="modal" data-target="#pengaturanAkun" class="collapsed">
											<span class="link-collapse">Pengaturan Akun</span>
										</a>
									</li>
									<li>
										<a href="#" data-toggle="modal" data-target="#gantiPassword" class="collapsed">
											<span class="link-collapse">Ganti Password</span>
										</a>
									</li>

								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="dashboard.php" class="collapsed">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menu Utama</h4>
						</li>
						<li class="nav-item">
							<a href="?page=presensi">
								<i class="fas fa-list-alt"></i>
								<p>Presensi</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="?page=jadwal">
								<i class="fas fa-clipboard-check"></i>
								<p>Jadwal Mengajar</p>
							</a>
						</li>

						<li class="nav-item">
							<a data-toggle="collapse" href="#konfirmasi">
								<i class="fas fa-clipboard-list"></i>
								<p>Presensi Mahasiswa</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="konfirmasi">
								<ul class="nav nav-collapse">
									<?php
									$hari = hari_ini(); // Memanggil fungsi hari_ini() yang berada di file PHP lain

									$kelas = mysqli_query($con, "SELECT jadwals.*, kelass.nm_kelas, mata_kuliahs.nm_makul 
									FROM jadwals
									INNER JOIN kelass ON jadwals.kelas_id = kelass.id_kelas
									INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
									INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
									WHERE jadwals.dosen_id = '$id_dosen' AND semesters.status = 1 AND jadwals.hari = '$hari'
									ORDER BY CAST(jadwals.jam_ke AS UNSIGNED) AND id_kelas ASC");
									if (mysqli_num_rows($kelas) > 0) {
										foreach ($kelas as $k) {
											$jadwal_id = $k['id_jadwal'];
									?>
											<li>
												<a href="?page=konfirmasi&jadwal=<?= $jadwal_id ?>">
													<span class="sub-item"><?= $k['nm_makul']; ?> (<?= strtoupper($k['nm_kelas']) ?> - Jam Ke <?= $k['jam_ke']; ?>)</span>
												</a>
												</a>
											</li>
									<?php
										}
									} else {
										echo '<li class="nav-item"><a href="#" class="nav-link"><span class="sub-item">Tidak ada presensi</span></a></li>';
									}
									?>
								</ul>
							</div>
						</li>

						<li class="nav-item">
							<a data-toggle="collapse" href="#rekapAbsen">
								<i class="fas fa-list-alt"></i>
								<p>Rekap Presensi</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="rekapAbsen">
								<ul class="nav nav-collapse">
									<?php
									$kelas = mysqli_query($con, "SELECT * FROM kelass ORDER BY id_kelas ASC");
									foreach ($kelas as $k) { ?>
										<li>
											<a href="?page=rekap&kelas=<?= $k['id_kelas'] ?> ">
												<span class="sub-item">KELAS
													<?= strtoupper($k['nm_kelas']); ?>
												</span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
						</li>

						<li class="nav-item active mt-3">
							<a href="logout.php" class="collapsed">
								<i class="fas fa-arrow-alt-circle-left"></i>
								<p>Logout</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">

				<!-- Halaman dinamis -->
				<?php
				error_reporting();
				$page = @$_GET['page'];
				$act = @$_GET['act'];

				if ($page == 'presensi') {
					include 'modul/presensi/absensi.php';
				} else if ($page == 'jadwal') {
					include 'modul/jadwal/jadwal_mengajar.php';
				} elseif ($page == 'konfirmasi') {
					include 'modul/konfirmasi/konfir.php';
				} elseif ($page == 'status') {
					include 'modul/status/info.php';
				} elseif ($page == '') {
					include 'modul/home.php';
				} else {
					echo "<b>Tidak ada Halaman</b>";
				}
				?>
				<!-- end -->
			</div>

			<!-- modal ganti password -->
			<div class="modal fade bs-example-modal-sm" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="gantiPass">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="gantiPass">Ganti Password</h4>
							<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
						</div>
						<form action="" method="post">
							<div class="modal-body">
								<div class="form-group">
									<label class="control-label">Password Lama</label>
									<input name="pass" type="text" class="form-control" placeholder="Password Lama" required>
								</div>
								<div class="form-group">
									<label class="control-label">Password Baru</label>
									<input name="pass1" type="text" class="form-control" placeholder="Password Baru" required>
								</div>
							</div>
							<div class="modal-footer">
								<button name="changePassword" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
									Simpan</button>
							</div>
						</form>
						<?php
						if (isset($_POST['changePassword'])) {
							$passLama = $data['password'];
							$pass = $_POST['pass'];
							$newPass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);

							if (password_verify($pass, $passLama)) {
								$stmt = $con->prepare("UPDATE dosens SET password=? WHERE id_dosen=?");
								$stmt->bind_param("si", $newPass, $data['id_dosen']);
								$stmt->execute();
								$stmt->close();

								echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal('Sukses', 'Password berhasil diganti', {
                                    	icon : 'success',
                                    	buttons: {        			
                                        confirm: {
                                            className : 'btn btn-success'
                                        }
                                    },
                                });    
                            		},100);  
                                window.setTimeout(function(){ 
                                    window.location.replace('dashboard.php');
                                } ,3000);   
                                </script>";
							} else {
								echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal('Maaf!', 'Password lama tidak sesuai', {
                                    	icon : 'error',
                                    	buttons: {        			
                                        confirm: {
                                            className : 'btn btn-danger'
                                        }
                                    },
                                });    
                            		},100);  
                                window.setTimeout(function(){ 
                                    window.location.replace('dashboard.php');
                                } ,3000);   
                                </script>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<!--end modal ganti password -->

			<!-- Modal pengaturan akun-->
			<div class="modal fade" id="pengaturanAkun" tabindex="-1" role="dialog" aria-labelledby="akunAtur">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="akunAtur"><i class="fas fa-user-cog"></i> Pengaturan Akun</h3>
							<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
						</div>
						<form action="" method="post" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="form-group">
									<label>NIP</label>
									<input type="text" name="nip" class="form-control" value="<?= $data['nip'] ?>" readonly>
								</div>
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" name="nama" class="form-control" value="<?= $data['nm_dosen'] ?>">
									<input type="hidden" name="id" value="<?= $data['id_dosen'] ?>">
								</div>
								<div class="form-group">
									<label>Foto Profile</label>
									<p>
										<img src="../assets/img/dosen/<?= $data['foto'] ?>" class="img-thumbnail" style="height: 50px;width: 50px;">
									</p>
									<input type="file" name="foto">
								</div>
							</div>
							<div class="modal-footer">
								<button name="updateProfile" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
							</div>
						</form>
						<?php
						if (isset($_POST['updateProfile'])) {
							$id_dosen = $_POST['id'];

							// Upload gambar hanya jika ada gambar yang diunggah
							if (!empty($_FILES['foto']['name'])) {
								$gambar = $_FILES['foto']['name'];
								move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/dosen/$gambar");
								$ganti = mysqli_query($con, "UPDATE dosens SET foto='$gambar' WHERE id_dosen='$id_dosen'");
							}

							// Gunakan parameter binding pada pernyataan SQL untuk keamanan
							$sqlEdit = mysqli_prepare($con, "UPDATE dosens SET nm_dosen=? WHERE id_dosen=?");
							mysqli_stmt_bind_param($sqlEdit, "si", $_POST['nama'], $id_dosen);
							mysqli_stmt_execute($sqlEdit);

							if ($sqlEdit) {
								echo "<script>
            						// alert('Sukses! Data berhasil diperbarui');
            					window.location='dashboard.php';
            				</script>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<!-- end modal pengaturan akun -->

			<footer class="footer">
				<!-- <div class="container d-flex justify-content-center">
					<div class="copyright"> -->
				<div class="container">
					<div class="copyright ml-auto">
						&copy;
						<?php echo date('Y'); ?> Politeknik Negeri Pontianak (<a href="dashboard.php">Sihadir </a> | Teknik
						Elektro)
					</div>
				</div>
			</footer>

		</div>

	</div>
	<!--   Core JS Files   -->
	<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="../assets/js/core/popper.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Datatables -->
	<script src="../assets/js/plugin/datatables/datatables.min.js"></script>



	<!-- Sweet Alert -->
	<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="../assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="../assets/js/setting-demo.js"></script>

	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({});

			$('#multi-filter-select').DataTable({
				"pageLength": 5,
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
							.appendTo($(column.footer()).empty())
							.on('change', function() {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);

								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column.data().unique().sort().each(function(d, j) {
							select.append('<option value="' + d + '">' + d + '</option>')
						});
					});
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
				]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
</body>

</html>