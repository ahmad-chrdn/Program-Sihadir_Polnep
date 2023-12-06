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
        <h4 class="page-title">Info</h4>
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
                <a href="?page=status">Info Status</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Status Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Program Studi</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $info = mysqli_query($con, "SELECT
                                mahasiswas.nim,
                                mahasiswas.nm_mahasiswa,
                                kelass.nm_kelas,
                                prodis.nama_prodi,
                                jurusans.nama_jurusan,                              
                                mahasiswas.status
                                    FROM mahasiswas
                                    JOIN kelass ON mahasiswas.kelas_id = kelass.id_kelas
                                    JOIN prodis ON mahasiswas.prodi_id = prodis.id_prodi
                                    JOIN jurusans ON mahasiswas.jurusan_id = jurusans.id_jurusan                  
                                    WHERE mahasiswas.id_mahasiswa = $mahasiswa_id");
                                foreach ($info as $i) { ?>
                                    <tr>
                                        <td>
                                            <?= $i['nim']; ?>
                                        </td>
                                        <td>
                                            <?= $i['nm_mahasiswa']; ?>
                                        </td>
                                        <td>
                                            <?= $i['nm_kelas']; ?>
                                        </td>
                                        <td>
                                            <?= $i['nama_prodi']; ?>
                                        </td>
                                        <td>
                                            <?= $i['nama_jurusan']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $i['status'];

                                            if ($status == 'Aktif') {
                                                echo "<span class='badge badge-success'>Aktif</span>";
                                            } elseif ($status == 'SP1') {
                                                echo "<span class='badge badge-warning'>SP1</span>";
                                            } elseif ($status == 'SP2') {
                                                echo "<span class='badge badge-warning'>SP2</span>";
                                            } elseif ($status == 'SP3') {
                                                echo "<span class='badge badge-danger'>SP3</span>";
                                            } elseif ($status == 'DO') {
                                                echo "<span class='badge badge-danger'>DO</span>";
                                            }
                                            ?>
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