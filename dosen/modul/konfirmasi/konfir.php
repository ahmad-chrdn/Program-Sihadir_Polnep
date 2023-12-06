<?php
@session_start();
include '../config/db.php';

$dosen_id = isset($_SESSION['dosen']) ? $_SESSION['dosen'] : null;

// Menagmbik informasi jadwal
$jadwal_id = isset($_GET['jadwal']) ? $_GET['jadwal'] : null;

// SQL mendapatkan data mahasiswa
$kelasMahasiswa = mysqli_query($con, "SELECT
    pm.id_presensi_mahasiswa,
    m.nim,
    m.nm_mahasiswa,
    p.nama_prodi,
    pm.status_mahasiswa,
    pm.dokumen,
    pm.waktu_presensi,
    pm.status_presensi,
    pm.waktu_konfirmasi,
    k.nm_kelas,
    mk.nm_makul,
    j.jam_ke
FROM presensi_mahasiswas pm
JOIN jadwals j ON pm.jadwal_id = j.id_jadwal
JOIN dosens d ON j.dosen_id = d.id_dosen
JOIN mahasiswas m ON pm.mahasiswa_id = m.id_mahasiswa
JOIN prodis p ON m.prodi_id = p.id_prodi
JOIN kelass k ON j.kelas_id = k.id_kelas
JOIN mata_kuliahs mk ON j.makul_id = mk.id_makul
WHERE d.id_dosen = '$dosen_id' AND j.id_jadwal = $jadwal_id
");

// Periksa apakah query mengembalikan hasil atau mengalami kesalahan
if (!$kelasMahasiswa) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Mahasiswa</h4>
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
                <a href="#" onclick="return false;">
                    Presensi Mahasiswa
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <?php
                $displayedCombinations = [];

                foreach ($kelasMahasiswa as $km) {
                    $combination = $km['nm_makul'] . ' (' . strtoupper($km['nm_kelas']) . ' - Jam Ke ' . $km['jam_ke'] . ')';

                    if (!in_array($combination, $displayedCombinations)) {
                        echo '<a href="?page=konfirmasi&jadwal=' . $_GET['jadwal'] . '">' . $combination . '</a>';
                        $displayedCombinations[] = $combination;
                    }
                }
                ?>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Sisipkan bagian tabel presensi di sini -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Daftar Presensi Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nim</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Prodi</th>
                                    <th>Status</th>
                                    <th>Dokumen</th>
                                    <th>Waktu</th>
                                    <th>Status Presensi</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($kelasMahasiswa as $km) :
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $km['nim']; ?></td>
                                        <td><?= $km['nm_mahasiswa']; ?></td>
                                        <td><?= $km['nama_prodi']; ?></td>
                                        <td>
                                            <?php
                                            $status = $km['status_mahasiswa'];

                                            if ($status == 'Hadir') {
                                                echo "<span class='badge badge-success'>Hadir</span>";
                                            } elseif ($status == 'Terlambat') {
                                                echo "<span class='badge badge-warning'>Terlambat</span>";
                                            } elseif ($status == 'Izin') {
                                                echo "<span class='badge badge-warning'>Izin</span>";
                                            } elseif ($status == 'Sakit') {
                                                echo "<span class='badge badge-danger'>Sakit</span>";
                                            } elseif ($status == 'Alpa') {
                                                echo "<span class='badge badge-danger'>Alpa</span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $km['dokumen'] ? $km['dokumen'] : '-'; ?>
                                        </td>
                                        <td><?= $km['waktu_presensi']; ?></td>
                                        <td><?= $km['status_presensi']; ?></td>
                                        <td>
                                            <!-- Modal Konfirmasi Status -->
                                            <div class="modal fade" id="edit<?= $km['id_presensi_mahasiswa'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Status Presensi</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="nim">Nim Mahasiswa</label>
                                                                            <input name="kode" type="text" id="nim" value="<?= $km['nim'] ?>" class="form-control" readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="nm_mahasiswa">Nama Mahasiswa</label>
                                                                            <input name="id" type="hidden" value="<?= $km['id_presensi_mahasiswa'] ?>">
                                                                            <input name="nama" type="text" id="nm_mahasiswa" value="<?= $km['nm_mahasiswa'] ?>" class="form-control" readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="status_mahasiswa">Status Kehadiran</label>
                                                                            <select name="status_mahasiswa" id="status_mahasiswa" class="form-control">
                                                                                <option value="Hadir" <?= $km['status_mahasiswa'] == 'Hadir' ? 'selected' : ''; ?>>Hadir</option>
                                                                                <option value="Terlambat" <?= $km['status_mahasiswa'] == 'Terlambat' ? 'selected' : ''; ?>>Terlambat</option>
                                                                                <option value="Izin" <?= $km['status_mahasiswa'] == 'Izin' ? 'selected' : ''; ?>>Izin</option>
                                                                                <option value="Sakit" <?= $km['status_mahasiswa'] == 'Sakit' ? 'selected' : ''; ?>>Sakit</option>
                                                                                <option value="Alpa" <?= $km['status_mahasiswa'] == 'Alpa' ? 'selected' : ''; ?>>Alpa</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="status_presensi">Status Presensi</label>
                                                                            <select name="status_presensi" id="status_presensi" class="form-control">
                                                                                <option value="Menunggu Konfirmasi" <?= $km['status_presensi'] == 'Menunggu Konfirmasi' ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                                                                                <option value="Dikonfirmasi" <?= $km['status_presensi'] == 'Dikonfirmasi' ? 'selected' : ''; ?>>Dikonfirmasi</option>
                                                                                <option value="Ditolak" <?= $km['status_presensi'] == 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="waktu_konfirmasi">Waktu Konfirmasi</label>
                                                                            <input name="waktu_konfirmasi" type="time" id="waktu_konfirmasi" value="<?= $km['waktu_konfirmasi'] ?>" class="form-control" step="1">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button name="submit_status" class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <?php
                                                            if (isset($_POST['submit_status'])) {
                                                                $newStatusMahasiswa = $_POST['status_mahasiswa'];
                                                                $newStatusPresensi = $_POST['status_presensi'];
                                                                $waktuKonfirmasi = $_POST['waktu_konfirmasi'];
                                                                $idPresensiMahasiswa = $_POST['id'];

                                                                // Gunakan prepared statement untuk mencegah SQL injection
                                                                $updateStatusQuery = mysqli_prepare($con, "UPDATE presensi_mahasiswas SET status_mahasiswa=?, status_presensi=?, waktu_konfirmasi=? WHERE id_presensi_mahasiswa=?");
                                                                mysqli_stmt_bind_param($updateStatusQuery, "sssi", $newStatusMahasiswa, $newStatusPresensi, $waktuKonfirmasi, $idPresensiMahasiswa);

                                                                if (mysqli_stmt_execute($updateStatusQuery)) {
                                                                    echo "<script>window.location.replace('?page=konfirmasi&jadwal=$jadwal_id');</script>";
                                                                } else {
                                                                    echo "<script type='text/javascript'>
                                                                        setTimeout(function () { 
                                                                        swal('Maaf!', 'Gagal mengubah status presensi', {
                                                                        icon : 'error',
                                                                        buttons: {                    
                                                                        confirm: {
                                                                        className : 'btn btn-danger'
                                                                            }
                                                                        },
                                                                    });    
                                                                }, 100);  
                                                                </script>";
                                                                }
                                                                mysqli_stmt_close($updateStatusQuery);
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit<?= $km['id_presensi_mahasiswa'] ?>"><i class="fas fa-info-circle"></i></a>

                                            <!-- Tombol lihat dokumen -->
                                            <?php if ($km['dokumen']) : ?>
                                                <a href="/assets/dokumen/<?= $km['dokumen']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-file-contract"></i></a>
                                            <?php else : ?> -
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>