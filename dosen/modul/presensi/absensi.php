<?php
@session_start();
include '../config/db.php';

$dosen_id = isset($_SESSION['dosen']) ? $_SESSION['dosen'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        $jadwal_id = $_POST['jadwal_id'];

        // Periksa apakah data sudah ada
        $check_query = mysqli_query($con, "SELECT * FROM presensi_dosens WHERE dosen_id = '$dosen_id' AND jadwal_id = '$jadwal_id'");
        if (mysqli_num_rows($check_query) > 0) {
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
            // Lanjutkan dengan penyimpanan data
            $stmt = mysqli_prepare($con, "INSERT INTO presensi_dosens (dosen_id, jadwal_id, status_dosen, waktu_presensi) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'iiss', $dosen_id, $_POST['jadwal_id'], $_POST['status_dosen'], $_POST['waktu_presensi']);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>                        
                    window.location='?page=presensi';
                </script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }

            mysqli_stmt_close($stmt);
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
                <a href="?page=presensi">Presensi Mengajar</a>
            </li>
        </ul>
    </div>
    <div class="row mt-4">
        <?php
        $hari = hari_ini(); // Memanggil fungsi hari_ini() yang berada di file PHP lain

        $jadwal = mysqli_query($con, "SELECT jadwals.*, mata_kuliahs.nm_makul, kelass.nm_kelas, ruangans.nm_ruangan, presensi_dosens.status_dosen, presensi_dosens.waktu_presensi
        FROM jadwals
        LEFT JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
        LEFT JOIN kelass ON jadwals.kelas_id = kelass.id_kelas
        LEFT JOIN ruangans ON jadwals.ruangan_id = ruangans.id_ruangan
        LEFT JOIN presensi_dosens ON jadwals.id_jadwal = presensi_dosens.jadwal_id AND presensi_dosens.dosen_id = '$dosen_id'
        INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
        WHERE jadwals.dosen_id = '$dosen_id' AND semesters.status = 1 AND jadwals.hari = '$hari' 
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
                                Kelas: <?= $j['nm_kelas']; ?>
                            </li>
                            <li>
                                Ruangan: <?= $j['nm_ruangan']; ?>
                            </li>
                        </ul>
                        <hr>
                        <ul>
                            <?php if ($j['status_dosen'] !== null && $j['waktu_presensi'] !== null) { ?>
                                <li>
                                    Status Presensi: <?= $j['status_dosen']; ?>
                                </li>
                                <li>
                                    Waktu Presensi: <?= $j['waktu_presensi']; ?>
                                </li>
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
                                <form action="" method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_dosen" value="Hadir">Hadir
                                            </label>
                                            <label class="form-radio-label">
                                                <input type="radio" name="status_dosen" value="Tidak Hadir">Tidak Hadir
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Waktu</label>
                                        <input name="waktu_presensi" type="datetime-local" id="waktu_presensi" class="form-control" required>
                                    </div>

                                    <!-- Menambahkan input tersembunyi untuk menyimpan nilai jadwal_id dan dosen_id -->
                                    <input type="hidden" name="jadwal_id" value="<?= $j['id_jadwal'] ?>">
                                    <input type="hidden" name="dosen_id" value="<?= $dosen_id ?>">

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
            echo '<div class="col-md-12"><div class="alert alert-info">Tidak ada presensi mengajar hari ini.</div></div>';
        } ?>
    </div>
</div>