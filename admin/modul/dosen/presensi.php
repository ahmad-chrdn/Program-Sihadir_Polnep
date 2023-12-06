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
                <a href="#" onclick="return false;">
                    Kelola Dosen
                </a>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="?page=dosen&act=pre">Presensi Dosen</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Daftar Presensi Dosen</h3>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nip</th>
                                    <th>Nama Dosen</th>
                                    <th>Mata Kuliah</th>
                                    <th>Status</th>
                                    <th>Tanggal dan Waktu</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                $dosen = mysqli_query($con, "SELECT presensi_dosens.*, dosens.nip, dosens.nm_dosen, jadwals.*, mata_kuliahs.nm_makul
                                FROM presensi_dosens
                                INNER JOIN dosens ON presensi_dosens.dosen_id = dosens.id_dosen
                                INNER JOIN jadwals ON presensi_dosens.jadwal_id = jadwals.id_jadwal
                                INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
                                INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
                                WHERE semesters.status = 1");
                                foreach ($dosen as $d) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $d['nip']; ?>
                                        </td>
                                        <td>
                                            <?= $d['nm_dosen']; ?>
                                        </td>
                                        <td>
                                            <?= $d['nm_makul']; ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status_dosen'] == 'Hadir') {
                                                echo "<span class='badge badge-success'>Hadir</span>";
                                            } else {
                                                echo "<span class='badge badge-danger'>Tidak Hadir</span>";
                                            } ?>
                                        </td>
                                        <td>
                                            <?= $d['waktu_presensi']; ?>
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