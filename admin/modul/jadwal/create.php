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
                <a href="#" onclick="return false;">
                    Kelola Jadwal
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="?page=jadwal&act=add">Tambah Jadwal</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="card-title">Jadwal Perkuliahan</div>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Program Studi</label>
                                    <select name="prodi" class="form-control">
                                        <option value="">Pilih Prodi</option>
                                        <?php
                                        $prodi = mysqli_query($con, "SELECT * FROM prodis ORDER BY id_prodi ASC");
                                        foreach ($prodi as $c) {
                                            echo "<option value='$c[id_prodi]'>$c[nama_prodi]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <input type="hidden" name="semester" value="<?= $semAktif['id_semester'] ?>">
                                    <?php
                                    $semAktif = mysqli_query($con, "SELECT * FROM semesters WHERE status=1 ORDER BY id_semester ASC");

                                    // Memeriksa apakah ada semester aktif
                                    if (mysqli_num_rows($semAktif) > 0) {
                                        foreach ($semAktif as $c) {
                                            echo "<input type='text' class='form-control' value='" . $c['semester'] . " " . $c['thn_ajaran'] . "' readonly>";
                                            echo "<input type='hidden' name='semester' value='" . $c['id_semester'] . "'>";
                                        }
                                    } else {
                                        // Jika tidak ada semester aktif, tampilkan placeholder
                                        echo "<input type='text' class='form-control' placeholder='Tidak ada Semester' readonly>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <label>Hari</label><br />
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="hari" value="Senin">
                                        <span class="form-radio-sign">Senin</span>
                                    </label>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="hari" value="Selasa">
                                        <span class="form-radio-sign">Selasa</span>
                                    </label>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="hari" value="Rabu">
                                        <span class="form-radio-sign">Rabu</span>
                                    </label>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="hari" value="Kamis">
                                        <span class="form-radio-sign">Kamis</span>
                                    </label>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="hari" value="Jumat">
                                        <span class="form-radio-sign">Jumat</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jamke">Jam Ke</label>
                                    <input name="jamke" type="text" class="form-control" id="jam_ke" placeholder="1 - 11" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="durasi">Durasi</label>
                                    <input name="durasi" type="text" class="form-control" id="durasi" placeholder="00:00 - 00:00" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas" class="form-control">
                                        <option value="">Pilih Kelas</option>
                                        <?php
                                        $kelas = mysqli_query($con, "SELECT * FROM kelass ORDER BY id_kelas ASC");
                                        foreach ($kelas as $c) {
                                            echo "<option value='$c[id_kelas]'>$c[nm_kelas]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mata Kuliah</label>
                                    <select name="makul" class="form-control">
                                        <option value="">Pilih Makul</option>
                                        <?php
                                        $makul = mysqli_query($con, "SELECT * FROM mata_kuliahs ORDER BY id_makul ASC");
                                        foreach ($makul as $c) {
                                            echo "<option value='$c[id_makul]'>[ $c[kd_makul] ] $c[nm_makul]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dosen</label>
                                    <select name="dosen" class="form-control">
                                        <option value="">Pilih Dosen</option>
                                        <?php
                                        $dosen = mysqli_query($con, "SELECT * FROM dosens ORDER BY id_dosen ASC");
                                        foreach ($dosen as $c) {
                                            echo "<option value='$c[id_dosen]'>$c[nm_dosen]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ruang</label>
                                    <select name="ruang" class="form-control">
                                        <option value="">Pilih Ruangan</option>
                                        <?php
                                        $ruang = mysqli_query($con, "SELECT * FROM ruangans ORDER BY id_ruangan ASC");
                                        foreach ($ruang as $c) {
                                            echo "<option value='$c[id_ruangan]'>$c[nm_ruangan]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" name="save" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="?page=jadwal&act=add" class="btn btn-warning">
                                        <i class="fa fa-chevron-left"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['save'])) {

                        $prodi = $_POST['prodi'];
                        $semAktif = $_POST['semester'];
                        $hari = $_POST['hari'];
                        $jamke = $_POST['jamke'];
                        $durasi = $_POST['durasi'];
                        $kelas = $_POST['kelas'];
                        $makul = $_POST['makul'];
                        $dosen = $_POST['dosen'];
                        $ruang = $_POST['ruang'];

                        $insert = mysqli_query($con, "INSERT INTO jadwals VALUES (NULL,'$hari', '$jamke', '$durasi', '$makul', '$dosen', '$ruang', '$kelas', '$semAktif', '$prodi')");

                        if ($insert) {
                            echo "<script>
                                window.location.replace('?page=jadwal');
                            </script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>