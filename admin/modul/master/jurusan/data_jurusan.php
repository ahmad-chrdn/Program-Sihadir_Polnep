<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Jurusan</h4>
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
                <a href="?page=master&act=jurusan">Jurusan</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addJurusan"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Jurusan</th>
                                    <th>Nama Jurusan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $jurusan = mysqli_query($con, "SELECT * FROM jurusans");
                                foreach ($jurusan as $j) { ?>
                                    <tr>
                                        <td>
                                            <?= $no++; ?>.
                                        </td>
                                        <td>
                                            <?= $j['kd_jurusan']; ?>
                                        </td>
                                        <td>
                                            <?= $j['nama_jurusan']; ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $j['id_jurusan'] ?>"><i class="far fa-edit"></i> Edit</a>
                                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=master&act=delJurusan&id=<?= $j['id_jurusan'] ?>"><i class="fas fa-trash"></i> Hapus</a>

                                            <!-- Modal Edit -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $j['id_jurusan'] ?>" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Edit Jurusan</h4>
                                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="kd_jurusan">Kode Jurusan</label>
                                                                            <input name="kode" type="text" id="kd_jurusan" value="<?= $j['kd_jurusan'] ?>" class="form-control">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="nama_jurusan">Nama Jurusan</label>
                                                                            <input name="id" type="hidden" value="<?= $j['id_jurusan'] ?>">
                                                                            <input name="jurusan" type="text" id="nama_jurusan" value="<?= $j['nama_jurusan'] ?>" class="form-control">
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
                                                                // Periksa apakah kode jurusan yang akan diubah sudah ada dalam database selain data yang akan diubah
                                                                $checkExistQuery = mysqli_query($con, "SELECT * FROM jurusans WHERE kd_jurusan='$_POST[kode]' AND id_jurusan <> '$_POST[id]'");
                                                                $numRows = mysqli_num_rows($checkExistQuery);

                                                                if ($numRows > 0) {
                                                                    // Kode jurusan sudah ada, tampilkan notifikasi error dan arahkan kembali ke form edit dengan menyertakan ID yang ingin diedit
                                                                    echo "<script type='text/javascript'>
                                                                        setTimeout(function () { 
                                                                            swal('Maaf!', 'Kode jurusan sudah digunakan. Masukkan kode yang lain!', {
                                                                        icon : 'error',
                                                                        buttons: {                    
                                                                            confirm: {
                                                                                className : 'btn btn-danger'
                                                                                        }
                                                                                    },
                                                                                });    
                                                                        }, 100);  
                                                                            window.setTimeout(function(){ 
                                                                        window.location.replace('?page=master&act=jurusan');
                                                                        }, 3000);   
                                                                    </script>";
                                                                } else {
                                                                    // Kode jurusan belum ada, lanjutkan dengan proses pengeditan
                                                                    $save = mysqli_query($con, "UPDATE jurusans SET kd_jurusan='$_POST[kode]', nama_jurusan='$_POST[jurusan]' WHERE id_jurusan='$_POST[id]' ");

                                                                    if ($save) {
                                                                        echo "<script>
                                                                            window.location.replace('?page=master&act=jurusan');
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

            <!-- Modal Tambah Jurusan -->
            <div id="addJurusan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Jurusan</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="kd_jurusan">Kode Jurusan</label>
                                    <input name="kode" type="text" id="kd_jurusan" placeholder="Kode Jurusan" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_jurusan">Nama Jurusan</label>
                                    <input name="jurusan" type="text" id="nama_jurusan" placeholder="Nama jurusan" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['save'])) {
                                $kode = $_POST['kode'];
                                $jurusan = $_POST['jurusan'];

                                // Periksa apakah kode jurusan sudah ada dalam database
                                $checkExistQuery = mysqli_query($con, "SELECT * FROM jurusans WHERE kd_jurusan='$kode'");
                                $numRows = mysqli_num_rows($checkExistQuery);

                                if ($numRows > 0) {
                                    // Kode jurusan sudah ada, tampilkan notifikasi error
                                    echo "<script type='text/javascript'>
                                    setTimeout(function () { 
                                        swal('Maaf!', 'Kode jurusan sudah digunakan. Masukkan kode yang lain!', {
                                            icon : 'error',
                                            buttons: {                    
                                                confirm: {
                                                    className : 'btn btn-danger'
                                                }
                                            },
                                        });    
                                    }, 100);  
                                    window.setTimeout(function(){ 
                                        window.location.replace('?page=master&act=jurusan');
                                    }, 3000);   
                                    </script>";
                                } else {
                                    // Kode jurusan belum ada, lanjutkan dengan menyimpan data
                                    $save = mysqli_query($con, "INSERT INTO jurusans VALUES(NULL,'$kode','$jurusan')");

                                    if ($save) {
                                        echo "<script>
                                            window.location.replace('?page=master&act=jurusan');
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