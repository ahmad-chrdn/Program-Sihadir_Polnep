<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Ruangan</h4>
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
                <a href="?page=master&act=ruangan">Ruangan</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addRuangan"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Ruangan</th>
                                    <th>Nama Ruangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $ruangan = mysqli_query($con, "SELECT * FROM ruangans");
                                foreach ($ruangan as $r) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $r['kd_ruangan']; ?>
                                        </td>
                                        <td>
                                            <?= $r['nm_ruangan']; ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $r['id_ruangan'] ?>"><i class="far fa-edit"></i> Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=master&act=delRuangan&id=<?= $r['id_ruangan'] ?>"><i class="fas fa-trash"></i> Hapus</a>

                                            <!-- Modal Edit -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $r['id_ruangan'] ?>" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Edit Ruangan</h4>
                                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="nm_ruangan">Nama Ruangan</label>
                                                                            <input name="id" type="hidden" value="<?= $r['id_ruangan'] ?>">
                                                                            <input name="ruangan" type="text" id="nm_ruangan" value="<?= $r['nm_ruangan'] ?>" class="form-control">
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
                                                                $save = mysqli_query($con, "UPDATE ruangans SET nm_ruangan='$_POST[ruangan]' WHERE id_ruangan='$_POST[id]' ");
                                                                if ($save) {
                                                                    echo "<script>
                                                // alert('Data diubah !');
                                                window.location='?page=master&act=ruangan';
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

            <!-- Modal Tambah Ruangan -->
            <div id="addRuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Ruangan</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="kd_ruangan">Kode Ruangan</label>
                                    <?php
                                    // Kode untuk menghasilkan kode ruangan secara otomatis
                                    $result = mysqli_query($con, "SELECT MAX(kd_ruangan) AS max_kode FROM ruangans");
                                    $row = mysqli_fetch_assoc($result);
                                    $max_kode = $row['max_kode'];

                                    // Jika tidak ada data dalam tabel, atur kode awal
                                    if ($max_kode == null) {
                                        $next_kode = 'R-0001';
                                    } else {
                                        $max_number = substr($max_kode, 3); // Ambil angka setelah 'KL-'
                                        $next_number = (int)$max_number + 1; // Tambahkan 1
                                        $next_kode = 'R-' . sprintf('%04d', $next_number); // Format ulang sebagai kode baru
                                    }
                                    ?>
                                    <input name="kode" type="text" id="kd_ruangan" value="<?= $next_kode ?>" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nm_ruangan">Nama Ruangan</label>
                                    <input name="ruangan" type="text" id="nm_ruangan" placeholder="Nama Ruangan" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['save'])) {
                                $save = mysqli_query($con, "INSERT INTO ruangans VALUES(NULL,'$_POST[kode]','$_POST[ruangan]') ");
                                if ($save) {
                                    echo "<script>
                        // alert('Data tersimpan !');
                        window.location='?page=master&act=ruangan';
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