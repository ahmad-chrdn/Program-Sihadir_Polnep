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
                    Kelola Mahasiswa
                </a>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="?page=mahasiswa&act=pre">Presensi Mahasiswa</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
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
                                    <th>Hari</th>
                                    <th>Nim</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                    <th>Mata Kuliah</th>
                                    <th>Status</th>
                                    <th>Dokumen</th>
                                    <th>Waktu</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                $mahasiswa = mysqli_query($con, "SELECT
                                presensi_mahasiswas.*,
                                mahasiswas.nim,
                                mahasiswas.nm_mahasiswa,
                                kelass.nm_kelas,
                                prodis.nama_prodi,
                                jadwals.*,
                                mata_kuliahs.nm_makul
                            FROM presensi_mahasiswas
                            INNER JOIN mahasiswas ON presensi_mahasiswas.mahasiswa_id = mahasiswas.id_mahasiswa
                            INNER JOIN jadwals ON presensi_mahasiswas.jadwal_id = jadwals.id_jadwal
                            INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
                            INNER JOIN prodis ON mahasiswas.prodi_id = prodis.id_prodi
                            INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
                            INNER JOIN kelass ON mahasiswas.kelas_id = kelass.id_kelas
                            WHERE (status_presensi = 'Dikonfirmasi' OR status_presensi = 'Ditolak') AND semesters.status = 1");
                                foreach ($mahasiswa as $m) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $m['hari']; ?>
                                        </td>
                                        <td>
                                            <?= $m['nim']; ?>
                                        </td>
                                        <td>
                                            <?= $m['nm_mahasiswa']; ?>
                                        </td>
                                        <td>
                                            <?= $m['nm_kelas']; ?>
                                        </td>
                                        <td>
                                            <?= $m['nama_prodi']; ?>
                                        </td>
                                        <td>
                                            <?= $m['nm_makul']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusMahasiswa = $m['status_mahasiswa'];

                                            if ($statusMahasiswa == 'Hadir') {
                                                echo "<span class='badge badge-success'>Hadir</span>";
                                            } elseif ($statusMahasiswa == 'Terlambat') {
                                                echo "<span class='badge badge-warning'>Terlambat</span>";
                                            } elseif ($statusMahasiswa == 'Izin') {
                                                echo "<span class='badge badge-info'>Izin</span>";
                                            } elseif ($statusMahasiswa == 'Sakit') {
                                                echo "<span class='badge badge-warning'>Sakit</span>";
                                            } elseif ($statusMahasiswa == 'Alpa') {
                                                echo "<span class='badge badge-danger'>Alpa</span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $m['dokumen'] ? $m['dokumen'] : '-'; ?>
                                        </td>
                                        <td>
                                            <?= $m['waktu_presensi']; ?>
                                        </td>
                                        <td>
                                            <?php if ($m['dokumen']) : ?>
                                                <a href="/assets/dokumen/<?= $m['dokumen']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-file-contract"></i></a>
                                            <?php else : ?> -
                                            <?php endif; ?>
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