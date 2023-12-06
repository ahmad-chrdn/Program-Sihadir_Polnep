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
        <h4 class="page-title">Jadwal</h4>
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
                <a href="?page=jadwal">Jadwal Kuliah</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm text-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih Hari
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="?page=jadwal">---Semua---</a>
                                <a class="dropdown-item" href="?page=jadwal&day=Senin">Senin</a>
                                <a class="dropdown-item" href="?page=jadwal&day=Selasa">Selasa</a>
                                <a class="dropdown-item" href="?page=jadwal&day=Rabu">Rabu</a>
                                <a class="dropdown-item" href="?page=jadwal&day=Kamis">Kamis</a>
                                <a class="dropdown-item" href="?page=jadwal&day=Jumat">Jumat</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Durasi</th>
                                    <th>Jam Ke</th>
                                    <th>Mata Kuliah</th>
                                    <th>Dosen</th>
                                    <th>Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectedDay = isset($_GET['day']) ? mysqli_real_escape_string($con, $_GET['day']) : '';
                                $condition = !empty($selectedDay) ? "AND jadwals.hari = '$selectedDay'" : '';
                                // Tambahkan kondisi khusus jika tidak ada hari yang dipilih
                                $orderByDay = !empty($selectedDay) ? 'jadwals.hari,' : 'FIELD(jadwals.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat"),';

                                $jadwal = mysqli_query($con, "SELECT jadwals.*, mata_kuliahs.nm_makul, dosens.nm_dosen, ruangans.nm_ruangan
                                    FROM jadwals
                                    INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
                                    INNER JOIN dosens ON jadwals.dosen_id = dosens.id_dosen
                                    INNER JOIN ruangans ON jadwals.ruangan_id = ruangans.id_ruangan
                                    INNER JOIN mahasiswas ON mahasiswas.kelas_id = jadwals.kelas_id AND mahasiswas.prodi_id = jadwals.prodi_id
                                    INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester  
                                    WHERE mahasiswas.id_mahasiswa = '$mahasiswa_id' $condition AND semesters.status = 1
                                    ORDER BY $orderByDay CAST(jadwals.jam_ke AS UNSIGNED) ASC");
                                foreach ($jadwal as $j) { ?>
                                    <tr>
                                        <td>
                                            <?= $j['hari']; ?>
                                        </td>
                                        <td>
                                            <?= $j['durasi']; ?>
                                        </td>
                                        <td>
                                            <?= $j['jam_ke']; ?>
                                        </td>
                                        <td>
                                            <?= $j['nm_makul']; ?>
                                        </td>
                                        <td>
                                            <?= $j['nm_dosen']; ?>
                                        </td>
                                        <td>
                                            <?= $j['nm_ruangan']; ?>
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