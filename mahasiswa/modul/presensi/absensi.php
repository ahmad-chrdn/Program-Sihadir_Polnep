<?php
@session_start();
include '../config/db.php';

$mahasiswa_id = isset($_SESSION['mahasiswa']) ? $_SESSION['mahasiswa'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        $jadwal_id = $_POST['jadwal_id'];
        $status_mahasiswa = $_POST['status_mahasiswa'];
        $waktu_presensi = $_POST['waktu_presensi'];
        $dosen_id = $_POST['dosen_id'];
        $waktu_konfirmasi = '';

        // Inisialisasi variabel $nama_dokumen dan $folder_dokumen
        $nama_dokumen = '';
        $folder_dokumen = '';

        // Cek apakah presensi sudah pernah dilakukan
        $checkPresensiQuery = mysqli_query($con, "SELECT * FROM presensi_mahasiswas WHERE mahasiswa_id = '$mahasiswa_id' AND jadwal_id = '$jadwal_id'");

        if (mysqli_num_rows($checkPresensiQuery) > 0) {
            // Jika sudah ada presensi, tampilkan pesan
            echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal('Maaf!', 'Anda sudah melakukan presensi sebelumnya', {
                                    	icon : 'error',
                                    	buttons: {        			
                                        confirm: {
                                            className : 'btn btn-danger'
                                        }
                                    },
                                });    
                            		},100);  
                                window.setTimeout(function(){ 
                                    window.location.replace('?page=presensi');
                                } ,3000);   
                                </script>";
        } else {
            // Jika belum ada presensi, lanjutkan dengan menyimpan data presensi
            // Periksa apakah status "Sakit" atau "Izin" dan dokumen telah diunggah
            if (($status_mahasiswa == 'Sakit' || $status_mahasiswa == 'Izin') && (!empty($_FILES['dokumen']['name']))) {
                // Proses penyimpanan data dan dokumen
                $nama_dokumen = $_FILES['dokumen']['name'];
                $temp_dokumen = $_FILES['dokumen']['tmp_name'];

                // Sesuaikan path folder dokumen dengan struktur server Anda
                $folder_dokumen = $_SERVER['DOCUMENT_ROOT'] . '/assets/dokumen/' . $nama_dokumen;

                // Gunakan prepared statement untuk menghindari SQL injection
                $stmt = mysqli_prepare($con, "INSERT INTO presensi_mahasiswas (mahasiswa_id, jadwal_id, status_mahasiswa, dokumen, waktu_presensi, dosen_id, status_presensi, waktu_konfirmasi) 
                VALUES (?, ?, ?, ?, ?, ?, 'Menunggu Konfirmasi', ?)");

                // Bind parameter ke statement
                mysqli_stmt_bind_param($stmt, "iisssis", $mahasiswa_id, $jadwal_id, $status_mahasiswa, $nama_dokumen, $waktu_presensi, $dosen_id, $waktu_konfirmasi);

                // Eksekusi statement
                $executeResult = mysqli_stmt_execute($stmt);

                // Periksa keberhasilan penyimpanan data
                if ($executeResult) {
                    // Pindahkan dokumen ke folder yang ditentukan
                    move_uploaded_file($temp_dokumen, $folder_dokumen);

                    // Tampilkan pesan sukses
                    // echo '<div class="alert alert-success">Presensi berhasil disimpan.</div>';
                    echo "<script>                        
                        window.location='?page=presensi';
                    </script>";
                } else {
                    // Tampilkan pesan kesalahan SQL jika terjadi
                    echo '<div class="alert alert-danger">Gagal menyimpan presensi. Error: ' . mysqli_stmt_error($stmt) . '</div>';
                }

                // Tutup statement
                mysqli_stmt_close($stmt);
            } elseif ($status_mahasiswa == 'Sakit' || $status_mahasiswa == 'Izin') {
                // Jika status "Sakit" atau "Izin" tetapi tidak ada dokumen diunggah
                echo '<div class="alert alert-danger">Anda wajib mengunggah dokumen jika memilih "Sakit" atau "Izin".</div>';
            } elseif (!empty($_FILES['dokumen']['name'])) {
                // Jika status bukan "Sakit" atau "Izin" dan mahasiswa mencoba mengunggah dokumen
                echo '<div class="alert alert-danger">Anda hanya dapat mengunggah dokumen jika memilih "Sakit" atau "Izin".</div>';
            } else {
                // Proses penyimpanan data tanpa dokumen
                $stmt = mysqli_prepare($con, "INSERT INTO presensi_mahasiswas (mahasiswa_id, jadwal_id, status_mahasiswa, waktu_presensi, dosen_id, status_presensi, waktu_konfirmasi) 
                VALUES (?, ?, ?, ?, ?, 'Menunggu Konfirmasi', ?)");

                // Bind parameter ke statement
                mysqli_stmt_bind_param($stmt, "iisssi", $mahasiswa_id, $jadwal_id, $status_mahasiswa, $waktu_presensi, $dosen_id, $waktu_konfirmasi);

                // Eksekusi statement
                $executeResult = mysqli_stmt_execute($stmt);

                // Periksa keberhasilan penyimpanan data
                if ($executeResult) {
                    // Tampilkan pesan sukses
                    // echo '<div class="alert alert-success">Presensi berhasil disimpan.</div>';
                    echo "<script>                        
                        window.location='?page=presensi';
                    </script>";
                } else {
                    // Tampilkan pesan kesalahan SQL jika terjadi
                    echo '<div class="alert alert-danger">Gagal menyimpan presensi. Error: ' . mysqli_stmt_error($stmt) . '</div>';
                }

                // Tutup statement
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Presensi</h4>
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
                <a href="?page=presensi">Presensi Makul</a>
            </li>
        </ul>
    </div>
    <div class="row mt-4">
        <?php
        $hari = hari_ini(); // Memanggil fungsi hari_ini() yang berada di file PHP lain

        $jadwal = mysqli_query($con, "SELECT 
        jadwals.*, 
        mata_kuliahs.nm_makul, 
        dosens.nm_dosen, 
        ruangans.nm_ruangan, 
        presensi_mahasiswas.status_mahasiswa, 
        presensi_mahasiswas.waktu_presensi,
        presensi_mahasiswas.status_presensi, 
        presensi_mahasiswas.waktu_konfirmasi,
        CASE 
            WHEN presensi_mahasiswas.status_presensi = 'Menunggu Konfirmasi' THEN 'Menunggu Konfirmasi'
            WHEN presensi_mahasiswas.status_presensi = 'Dikonfirmasi' THEN 'Dikonfirmasi'
            WHEN presensi_mahasiswas.status_presensi = 'Ditolak' THEN 'Ditolak'            
        END AS status_konfirmasi_tampil,
        CASE 
            WHEN presensi_mahasiswas.status_presensi = 'Menunggu Konfirmasi' THEN NULL
            WHEN presensi_mahasiswas.status_presensi = 'Ditolak' THEN NULL
            ELSE presensi_mahasiswas.waktu_konfirmasi
        END AS waktu_konfirmasi_tampil
    FROM jadwals
    INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
    INNER JOIN dosens ON jadwals.dosen_id = dosens.id_dosen
    INNER JOIN ruangans ON jadwals.ruangan_id = ruangans.id_ruangan
    INNER JOIN mahasiswas ON mahasiswas.kelas_id = jadwals.kelas_id AND mahasiswas.prodi_id = jadwals.prodi_id
    LEFT JOIN presensi_mahasiswas ON mahasiswas.id_mahasiswa = presensi_mahasiswas.mahasiswa_id AND jadwals.id_jadwal = presensi_mahasiswas.jadwal_id
    INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
    WHERE mahasiswas.id_mahasiswa = '$mahasiswa_id' AND semesters.status = 1 AND jadwals.hari = '$hari'
    ORDER BY CAST(jadwals.jam_ke AS UNSIGNED) ASC");

        if (mysqli_num_rows($jadwal) > 0) {
            foreach ($jadwal as $j) { ?>
                <div class="col-md-5 col-xs-12">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong>
                            <h3><?= $j['nm_makul']; ?></h3>
                        </strong>
                        <hr>
                        <ul>
                            <li>
                                Hari: <?= $j['hari']; ?>
                            </li>
                            <li>
                                Durasi: <?= $j['durasi']; ?>
                            </li>
                            <li>
                                Jam Ke: <?= $j['jam_ke']; ?>
                            </li>
                            <li>
                                Dosen: <?= $j['nm_dosen']; ?>
                            </li>
                            <li>
                                Ruangan: <?= $j['nm_ruangan']; ?>
                            </li>
                        </ul>
                        <hr>
                        <ul>
                            <?php if ($j['status_mahasiswa'] !== null && $j['waktu_presensi'] !== null) { ?>
                                <li>
                                    Status Presensi: <?= $j['status_mahasiswa']; ?>
                                </li>
                                <li>
                                    Waktu Presensi: <?= $j['waktu_presensi']; ?>
                                </li>
                                <?php if ($j['status_presensi'] !== null && $j['waktu_konfirmasi'] !== null) { ?>
                                    <?php if ($j['status_presensi'] === 'Menunggu Konfirmasi') { ?>
                                        <!-- Jika status masih menunggu konfirmasi -->
                                        <li>
                                            Status Konfirmasi: Menunggu Konfirmasi
                                        </li>
                                        <li>
                                            Waktu Konfirmasi: Tidak ada
                                        </li>
                                    <?php } elseif ($j['status_presensi'] === 'Ditolak') { ?>
                                        <!-- Jika status ditolak -->
                                        <li>
                                            Status Konfirmasi: <?= $j['status_presensi']; ?>
                                        </li>
                                        <li>
                                            Waktu Konfirmasi: <?= $j['waktu_konfirmasi']; ?>
                                        </li>
                                        </li>
                                    <?php } else { ?>
                                        <!-- Jika status sudah dikonfirmasi -->
                                        <li>
                                            Status Konfirmasi: <?= $j['status_presensi']; ?>
                                        </li>
                                        <li>
                                            Waktu Konfirmasi: <?= $j['waktu_konfirmasi']; ?>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <li>
                                    Status Presensi: Belum melakukan presensi
                                </li>
                                <li>
                                    Waktu Presensi: Tidak ada
                                </li>
                            <?php } ?>
                        </ul>

                        <hr>
                        <a href="" class="btn btn-primary btn-block text-left" data-toggle="modal" data-target="#addAbsen<?= $j['id_jadwal'] ?>">
                            <i class="fas fa-clipboard-check"></i> Isi Presensi
                        </a>
                    </div>
                </div>
                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addAbsen<?= $j['id_jadwal'] ?>" class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="exampleModalLabel" class="modal-title">Absen <?= $j['nm_makul']; ?></h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_mahasiswa" value="Hadir">Hadir
                                            </label>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_mahasiswa" value="Terlambat">Terlambat
                                            </label>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_mahasiswa" value="Izin">Izin
                                            </label>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_mahasiswa" value="Sakit">Sakit
                                            </label>
                                            <!-- <label class="form-radio-label">
                                                <input type="radio" name="status_mahasiswa" value="Alpa">Alpa
                                            </label> -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Dokumen</label>
                                        <input name="dokumen" type="file" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Waktu</label>
                                        <input name="waktu_presensi" type="datetime-local" id="waktu_presensi" class="form-control" required>
                                    </div>

                                    <!-- Menambahkan input tersembunyi untuk menyimpan nilai jadwal_id, mahasiswa_id, dan dosen_id -->
                                    <input type="hidden" name="mahasiswa_id" value="<?= $mahasiswa_id ?>">
                                    <input type="hidden" name="jadwal_id" value="<?= $j['id_jadwal'] ?>">
                                    <input type="hidden" name="dosen_id" value="<?= $j['dosen_id'] ?>">
                                    <input type="hidden" name="waktu_konfirmasi" value="">

                                    <div class="form-group">
                                        <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                            Simpan</button>
                                    </div>
                                </form>
                                <?php
                                // Kode PHP untuk menyimpan data telah dipindahkan ke atas
                                ?>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        <?php }
        } else {
            echo '<div class="col-md-12"><div class="alert alert-info">Tidak ada presensi perkuliahan hari ini.</div></div>';
        } ?>
    </div>
</div>