<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kompensasi</h4>
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
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="?page=mahasiswa&act=kompen">Kompensasi</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addKompen"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nim</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                    <th>Jurusan</th>
                                    <th>Jam</th>
                                    <th>Ketarangan</th>
                                    <th>Tanggal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $kompensasi = mysqli_query($con, "SELECT 
                                k.id_kompensasi,
                                m.nim,
                                m.nm_mahasiswa,                             
                                kls.nm_kelas,
                                p.nama_prodi,
                                j.nama_jurusan,                                
                                k.jumlah_jam,
                                k.keterangan,
                                k.tanggal
                                FROM kompensasis k
                                JOIN mahasiswas m ON k.mahasiswa_id = m.id_mahasiswa
                                JOIN kelass kls ON m.kelas_id = kls.id_kelas
                                JOIN prodis p ON m.prodi_id = p.id_prodi
                                JOIN jurusans j ON m.jurusan_id = j.id_jurusan
                            ");
                                foreach ($kompensasi as $k) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $k['nim']; ?>
                                        </td>
                                        <td>
                                            <?= $k['nm_mahasiswa']; ?>
                                        </td>
                                        <td>
                                            <?= $k['nm_kelas']; ?>
                                        </td>
                                        <td>
                                            <?= $k['nama_prodi']; ?>
                                        </td>
                                        <td>
                                            <?= $k['nama_jurusan']; ?>
                                        </td>
                                        <td>
                                            <?= $k['jumlah_jam']; ?>
                                        </td>
                                        <td>
                                            <?= $k['keterangan']; ?>
                                        </td>
                                        <td>
                                            <?= $k['tanggal']; ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $k['id_kompensasi'] ?>"><i class="far fa-edit"></i></a>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=mahasiswa&act=delKompen&id=<?= $k['id_kompensasi'] ?>"><i class="fas fa-trash"></i></a>

                                            <!-- Modal Edit -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $k['id_kompensasi'] ?>" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Edit Kompensasi</h4>
                                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?= $k['id_kompensasi'] ?>"> <!-- Tambahkan input tersembunyi untuk id -->
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="mahasiswa">Nama Mahasiswa</label>
                                                                            <input type="text" class="form-control" value="<?= $k['nm_mahasiswa'] ?> (<?= $k['nim'] ?>)" readonly>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="jumlah_jam">Jumlah Jam</label>
                                                                            <input name="jumlah_jam" type="text" id="jumlah_jam" value="<?= $k['jumlah_jam'] ?>" class="form-control" placeholder="Masukkan Jumlah Jam" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="keterangan">Keterangan</label>
                                                                            <input name="keterangan" type="text" id="keterangan" value="<?= $k['keterangan'] ?>" class="form-control" placeholder="Masukkan Keterangan" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="tanggal">Tanggal</label>
                                                                            <input name="tanggal" type="date" id="tanggal" value="<?= $k['tanggal'] ?>" class="form-control" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <button name="edit" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                                                Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <?php
                                                            if (isset($_POST['edit'])) {
                                                                // Proses pengeditan data
                                                                $id = $_POST['id'];
                                                                $jumlah_jam = $_POST['jumlah_jam'];
                                                                $keterangan = $_POST['keterangan'];
                                                                $tanggal = $_POST['tanggal'];

                                                                // Lanjutkan dengan proses pengeditan
                                                                $save = mysqli_query($con, "UPDATE kompensasis SET jumlah_jam='$jumlah_jam', keterangan='$keterangan', tanggal='$tanggal' WHERE id_kompensasi='$id'");

                                                                if ($save) {
                                                                    echo "<script>
                                                                        window.location.replace('?page=mahasiswa&act=kompen');
                                                                    </script>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal -->

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Kompensasi -->
            <div id="addKompen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Kompensasi</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label>Nama Mahasiswa</label>
                                    <select name="mahasiswa" class="form-control">
                                        <option value="">Pilih Mahasiswa</option>
                                        <?php
                                        $mahasiswa = mysqli_query($con, "SELECT * FROM mahasiswas WHERE status IN ('Aktif', 'SP1', 'SP2', 'SP3') ORDER BY id_mahasiswa ASC");
                                        foreach ($mahasiswa as $k) {
                                            echo "<option value='$k[id_mahasiswa]'>$k[nm_mahasiswa] ($k[nim])</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah_jam">Jumlah Jam</label>
                                    <input name="jumlah_jam" type="text" id="jumlah_jam" class="form-control" placeholder="Masukkan Jumlah Jam" required>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input name="keterangan" type="text" id="keterangan" class="form-control" placeholder="Masukkan Keterangan" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input name="tanggal" type="date" id="tanggal" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['save'])) {
                                // Proses penyimpanan data kompensasi
                                $mahasiswa = $_POST['mahasiswa'];
                                $jumlah_jam = $_POST['jumlah_jam'];
                                $keterangan = $_POST['keterangan'];
                                $tanggal = $_POST['tanggal'];

                                // Lakukan operasi penyimpanan data ke database
                                $save = mysqli_query($con, "INSERT INTO kompensasis VALUES (NULL, '$mahasiswa', '$jumlah_jam', '$keterangan', '$tanggal')");

                                if ($save) {
                                    echo "<script>
                                        window.location.replace('?page=mahasiswa&act=kompen');
                                    </script>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>