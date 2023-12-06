<?php
@session_start();
include '../config/db.php';

$mahasiswa_id = isset($_SESSION['mahasiswa']) ? $_SESSION['mahasiswa'] : null;

if (!$sql) {
	die('Error: ' . mysqli_error($con));
}

$data = mysqli_fetch_array($sql);
?>

<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Kompensasi</h4>
		<ul class="breadcrumbs">
			<li class="nav-home">
				<a href="./dashboard.php">
					<i class="flaticon-home"></i>
				</a>
			</li>
			<li class="separator">
				<i class="flaticon-right-arrow"></i>
			</li>
			<li class="nav-item">
				<a href="?page=kompensasi">Kompensasi</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header d-flex align-items-center">
					<h3 class="card-title">Info Kompensasi</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="basic-datatables" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Jumlah Jam</th>
									<th>Keterangan</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								$kompensasi = mysqli_query($con, "SELECT * FROM kompensasis JOIN mahasiswas ON kompensasis.mahasiswa_id = mahasiswas.id_mahasiswa 
								WHERE mahasiswas.id_mahasiswa = '$mahasiswa_id'");
								foreach ($kompensasi as $k) { ?>
									<tr>
										<td>
											<?= $no++; ?>.
										</td>
										<td>
											<?= $k['jumlah_jam']; ?>
										</td>
										<td>
											<?= $k['keterangan']; ?>
										</td>
										<td>
											<?= $k['tanggal']; ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>