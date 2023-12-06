<?php
$edit = mysqli_query($con, "SELECT * FROM dosens WHERE id_dosen ='$_GET[id]' ");
foreach ($edit as $d) ?>
<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Dosen</h4>
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
				<a href="#" onclick="return false;">Kelola Dosen</a>
			</li>
			<li class="separator">
				<i class="flaticon-right-arrow"></i>
			</li>
			<li class="nav-item">
				<a href="?page=dosen&act=edit&id=<?= $_GET['id'] ?>">Edit Dosen</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-header d-flex align-items-center">
					<h3 class="h4">Edit Akun Dosen</h3>
				</div>
				<div class="card-body">
					<form action="?page=dosen&act=proses" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>NIP/NUPTK</label>
							<input type="hidden" name="id" value="<?= $d['id_dosen'] ?>">
							<input name="nip" type="text" class="form-control" value="<?= $d['nip'] ?>">
						</div>

						<div class="form-group">
							<label>Nama Dosen</label>
							<input name="nama" type="text" class="form-control" value="<?= $d['nm_dosen'] ?>">
						</div>

						<!-- <div class="form-group">
							<label>Foto</label>
							<p>
								<img src="../assets/img/dosen/<?= $d['foto']; ?>" class="img-fluid rounded-circle kotak" style="height: 65px; width: 65px;">
							</p>
							<input type="file" name="foto">
						</div> -->

						<div class="form-group">
							<button name="editDosen" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
								Simpan</button>
							<a href="?page=dosen" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Batal</a>

						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>