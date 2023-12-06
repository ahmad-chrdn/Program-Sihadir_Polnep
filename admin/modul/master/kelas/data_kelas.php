<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelas</h4>
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
                    Kelola Akademik
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="?page=master&act=kelas">Kelas</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addKelas"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $kelas = mysqli_query($con, "SELECT * FROM kelass");
                                foreach ($kelas as $k) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $k['kd_kelas']; ?>
                                        </td>
                                        <td>
                                            <?= $k['nm_kelas']; ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $k['id_kelas'] ?>"><i class="far fa-edit"></i> Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=master&act=delKelas&id=<?= $k['id_kelas'] ?>"><i class="fas fa-trash"></i> Hapus</a>

                                            <!-- Modal Edit -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $k['id_kelas'] ?>" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Edit Kelas</h4>
                                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="nama_kelas">Nama Kelas</label>
                                                                            <input name="id" type="hidden" value="<?= $k['id_kelas'] ?>">
                                                                            <input name="kelas" type="text" id="nama_kelas" value="<?= $k['nm_kelas'] ?>" class="form-control">
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
                                                                $save = mysqli_query($con, "UPDATE kelass SET nm_kelas='$_POST[kelas]' WHERE id_kelas='$_POST[id]' ");
                                                                if ($save) {
                                                                    echo "<script>
                                                // alert('Data diubah !');
                                                window.location='?page=master&act=kelas';
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

            <!-- Modal Tambah Kelas -->
            <div id="addKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Kelas</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="kode_kelas">Kode Kelas</label>
                                    <?php
                                    // Kode untuk menghasilkan kode kelas secara otomatis
                                    $result = mysqli_query($con, "SELECT MAX(kd_kelas) AS max_kode FROM kelass");
                                    $row = mysqli_fetch_assoc($result);
                                    $max_kode = $row['max_kode'];

                                    // Jika tidak ada data dalam tabel, atur kode awal
                                    if ($max_kode == null) {
                                        $next_kode = 'KL-0001';
                                    } else {
                                        $max_number = substr($max_kode, 3); // Ambil angka setelah 'KL-'
                                        $next_number = (int)$max_number + 1; // Tambahkan 1
                                        $next_kode = 'KL-' . sprintf('%04d', $next_number); // Format ulang sebagai kode baru
                                    }
                                    ?>
                                    <input name="kode" type="text" id="kode_kelas" value="<?= $next_kode ?>" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input name="kelas" type="text" id="nama_kelas" placeholder="Nama Kelas" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['save'])) {
                                $save = mysqli_query($con, "INSERT INTO kelass VALUES(NULL,'$_POST[kode]','$_POST[kelas]') ");
                                if ($save) {
                                    echo "<script>
                        // alert('Data tersimpan !');
                        window.location='?page=master&act=kelas';
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