<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Program Studi</h4>
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
                <a href="?page=master&act=prodi">Program Studi</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addProdi"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Prodi</th>
                                    <th>Nama Prodi</th>
                                    <th>Jenjang</th>
                                    <th>Jurusan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $prodi = mysqli_query($con, "SELECT prodis.*, jurusans.nama_jurusan 
                            FROM prodis 
                            JOIN jurusans ON prodis.jurusan_id = jurusans.id_jurusan");

                                foreach ($prodi as $p) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $p['kd_prodi']; ?>
                                        </td>
                                        <td>
                                            <?= $p['nama_prodi']; ?>
                                        </td>
                                        <td>
                                            <?= $p['jenjang']; ?>
                                        </td>
                                        <td>
                                            <?= $p['nama_jurusan']; ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $p['id_prodi'] ?>"><i class="far fa-edit"></i> Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=master&act=delProdi&id=<?= $p['id_prodi'] ?>"><i class="fas fa-trash"></i> Hapus</a>

                                            <!-- Modal Edit -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $p['id_prodi'] ?>" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Edit Prodi</h4>
                                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="kd_prodi">Kode Prodi</label>
                                                                            <input name="kode" type="text" id="kd_prodi" value="<?= $p['kd_prodi'] ?>" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="nama_prodi">Nama Prodi</label>
                                                                            <input name="id" type="hidden" value="<?= $p['id_prodi'] ?>">
                                                                            <input name="prodi" type="text" id="nama_prodi" value="<?= $p['nama_prodi'] ?>" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="jenjang">Jenjang</label>
                                                                            <input name="jenjang" type="text" id="jenjang" value="<?= $p['jenjang'] ?>" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="jurusan_id">Jurusan</label>
                                                                            <select class="form-control" name="jurusan">
                                                                                <option>Pilih Jurusan</option>
                                                                                <?php
                                                                                $sqlJurusan = mysqli_query($con, "SELECT * FROM jurusans ORDER BY id_jurusan ASC");
                                                                                while ($jurusan = mysqli_fetch_array($sqlJurusan)) {
                                                                                    $selected = ($p['jurusan_id'] == $jurusan['id_jurusan']) ? 'selected' : '';
                                                                                    echo "<option value='$jurusan[id_jurusan]' $selected>$jurusan[nama_jurusan]</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
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
                                                                // Periksa apakah kode prodi yang akan diubah sudah ada dalam database selain data yang akan diubah
                                                                $checkExistQuery = mysqli_query($con, "SELECT * FROM prodis WHERE kd_prodi='$_POST[kode]' AND id_prodi <> '$_POST[id]'");
                                                                $numRows = mysqli_num_rows($checkExistQuery);

                                                                if ($numRows > 0) {
                                                                    // Kode prodi sudah ada, tampilkan notifikasi error dan arahkan kembali ke form edit dengan menyertakan ID yang ingin diedit
                                                                    echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'Kode prodi sudah digunakan. Masukkan kode yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=master&act=prodi');
                }, 3000);   
              </script>";
                                                                } else {
                                                                    // Kode prodi belum ada, lanjutkan dengan proses pengeditan

                                                                    $save = mysqli_query($con, "UPDATE prodis SET kd_prodi='$_POST[kode]', nama_prodi='$_POST[prodi]', jenjang='$_POST[jenjang]', jurusan_id='$_POST[jurusan]' WHERE id_prodi='$_POST[id]' ");

                                                                    if ($save) {
                                                                        echo "
            <script>
                window.location.replace('?page=master&act=prodi');
            </script>";
                                                                    }
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

            <!-- Modal Tambah Prodi -->
            <div id="addProdi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Prodi</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="kd_prodi">Kode Prodi</label>
                                    <input name="kode" type="text" id="kd_prodi" placeholder="Kode Prodi" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_prodi">Nama Prodi</label>
                                    <input name="prodi" type="text" id="nama_prodi" placeholder="Nama Prodi" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="jenjang">Jenjang</label>
                                    <input name="jenjang" type="text" id="jenjang" placeholder="Jenjang Prodi" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="jurusan_id">Jurusan</label>
                                    <select class="form-control" name="jurusan">
                                        <option>Pilih Jurusan</option>
                                        <?php
                                        $sqlJurusan = mysqli_query($con, "SELECT * FROM jurusans ORDER BY id_jurusan ASC");
                                        while ($jurusan = mysqli_fetch_array($sqlJurusan)) {
                                            echo "<option value='$jurusan[id_jurusan]'>$jurusan[nama_jurusan]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['save'])) {
                                $kode = $_POST['kode'];
                                $prodi = $_POST['prodi'];
                                $jenjang = $_POST['jenjang'];
                                $jurusan = $_POST['jurusan'];

                                // Periksa apakah kode prodi sudah ada dalam database
                                $checkExistQuery = mysqli_query($con, "SELECT * FROM prodis WHERE kd_prodi='$kode'");
                                $numRows = mysqli_num_rows($checkExistQuery);

                                if ($numRows > 0) {
                                    // Kode prodi sudah ada, tampilkan notifikasi error
                                    echo "<script type='text/javascript'>
                                        setTimeout(function () { 
                                            swal('Maaf!', 'Kode prodi sudah digunakan. Masukkan kode yang lain!', {
                                        icon : 'error',
                                    buttons: {                    
                                        confirm: {
                                    className : 'btn btn-danger'
                                        }
                                    },
                                        });    
                                    }, 100);  
                                    window.setTimeout(function(){ 
                                    window.location.replace('?page=master&act=prodi');
                                    }, 3000);   
                                    </script>";
                                } else {
                                    // Kode prodi belum ada, lanjutkan dengan menyimpan data
                                    $save = mysqli_query($con, "INSERT INTO prodis VALUES(NULL,'$kode','$prodi', '$jenjang', '$jurusan')");

                                    if ($save) {
                                        // Data berhasil disimpan, arahkan pengguna ke halaman prodi
                                        echo "<script>
                                            window.location.replace('?page=master&act=prodi');
                                        </script>";
                                    }
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