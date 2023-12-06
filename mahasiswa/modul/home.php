<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">Mahasiswa</h2>
				<h5 class="text-white mb-2">Selamat Datang, <b class="text-warning">
						<?= $data['nm_mahasiswa']; ?>
					</b> | Aplikasi Absensi Sihadir</h5>
			</div>
			<div id="jam" class="ml-md-auto py-2 py-md-0" style="font-size: 30px; color: white;"></div>
		</div>
	</div>

	<script>
		// Fungsi untuk menampilkan jam waktu nyata
		function updateJam() {
			var now = new Date();
			var jam = now.getHours();
			var menit = now.getMinutes();
			var detik = now.getSeconds();

			// Format jam dengan menambahkan 0 di depan jika kurang dari 10
			jam = (jam < 10) ? "0" + jam : jam;
			menit = (menit < 10) ? "0" + menit : menit;
			detik = (detik < 10) ? "0" + detik : detik;

			// Tampilkan jam di dalam elemen dengan ID 'jam'
			document.getElementById('jam').innerHTML = jam + ":" + menit + ":" + detik;

			// Set interval untuk memperbarui setiap detik
			setTimeout(updateJam, 1000);
		}

		// Panggil fungsi saat halaman dimuat
		updateJam();
	</script>
</div>
<div class="page-inner mt--5">
	<div class="row mt--2">
		<div class="col-md-6">
			<div class="card full-height">
				<div class="card-header">
					<h4 class="card-title" id="tanggal"></h4>
					<!-- <br>
					<h5 id="tanggal"></h5> -->

					<script>
						// Fungsi untuk mendapatkan tanggal waktu nyata
						function updateTanggal() {
							var now = new Date();
							var options = {
								weekday: 'long',
								year: 'numeric',
								month: 'long',
								day: 'numeric'
							};
							var formattedDate = now.toLocaleDateString('id-ID', options);

							// Perbarui elemen dengan ID 'tanggal' dengan tanggal waktu nyata
							document.getElementById('tanggal').textContent = formattedDate;
						}

						// Panggil fungsi saat halaman dimuat dan set interval untuk memperbarui setiap menit (jika diperlukan)
						updateTanggal();
						setInterval(updateTanggal, 60000); // Update setiap menit
					</script>
				</div>
				<div class="card-body">
					<div class="card-title">
						<center>
							<img src="../assets/img/Logo_Polnep.png" width="200">
							<br>
							<b>Politeknik Negeri Pontianak</b>
						</center>
					</div>
					<div class="card-category">
						<center>
							Jl. Jenderal Ahmad Yani, Bansir Laut, Pontianak Tenggara
							<br>Kota Pontianak, Kalimantan Barat, 78124
							<br>Email: kampus@polnep.ac.id
						</center>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Informasi Presensi</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-default card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-check"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Hadir</p>
												<h4 class="card-title">
													<?php echo $jumlah_hadir; ?>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-default card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-clock"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Terlambat</p>
												<h4 class="card-title">
													<?php echo $jumlah_terlambat; ?>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-default card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-file"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Izin</p>
												<h4 class="card-title">
													<?php echo $jumlah_izin; ?>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-default card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-procedures"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Sakit</p>
												<h4 class="card-title">
													<?php echo $jumlah_sakit; ?>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-default card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="fas fa-times"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Alpa</p>
												<h4 class="card-title">
													<?php echo $jumlah_alpa; ?>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>