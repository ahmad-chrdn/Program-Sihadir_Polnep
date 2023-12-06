<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Mata Kuliah</h4>
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
        <a href="?page=master&act=makul">Mata Kuliah</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#addMakul"><i class="fa fa-plus"></i> Tambah</a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Mata Kuliah</th>
                  <th>SKS</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $makul = mysqli_query($con, "SELECT * FROM mata_kuliahs ORDER BY id_makul ASC");
                foreach ($makul as $m) { ?>
                  <tr>
                    <td>
                      <?= $no++; ?>.
                    </td>
                    <td>
                      <?= $m['kd_makul']; ?>
                    </td>
                    <td>
                      <?= $m['nm_makul']; ?>
                    </td>
                    <td>
                      <?= $m['sks']; ?>
                    </td>
                    <td>
                      <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $m['id_makul'] ?>"><i class="far fa-edit"></i> Edit</a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=master&act=delMakul&id=<?= $m['id_makul'] ?>"><i class="fas fa-trash"></i> Hapus</a>

                      <!-- Modal Edit -->
                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $m['id_makul'] ?>" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 id="exampleModalLabel" class="modal-title">Edit Mata Kuliah</h4>
                              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                              <form action="" method="post">
                                <div class="row">
                                  <div class="col-md-10">
                                    <div class="form-group">
                                      <label for="kd_makul">Kode Mata Kuliah</label>
                                      <input name="kode" type="text" id="kd_makul" value="<?= $m['kd_makul'] ?>" class="form-control">
                                    </div>

                                    <div class="form-group">
                                      <label for="nm_makul">Nama Mata Kuliah</label>
                                      <input name="id" type="hidden" value="<?= $m['id_makul'] ?>">
                                      <input name="makul" type="text" id="nm_makul" value="<?= $m['nm_makul'] ?>" class="form-control">
                                    </div>

                                    <div class="form-group">
                                      <label for="sks">SKS</label>
                                      <input name="jumlah_sks" type="text" id="sks" value="<?= $m['sks'] ?>" class="form-control">
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
                                // Periksa apakah kode mata kuliah yang akan diubah sudah ada dalam database selain data yang akan diubah
                                $checkExistQuery = mysqli_query($con, "SELECT * FROM mata_kuliahs WHERE kd_makul='$_POST[kode]' AND id_makul <> '$_POST[id]'");
                                $numRows = mysqli_num_rows($checkExistQuery);

                                if ($numRows > 0) {
                                  // Kode mata kuliah sudah ada, tampilkan notifikasi error dan arahkan kembali ke form edit dengan menyertakan ID yang ingin diedit
                                  echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'Kode mata kuliah sudah digunakan. Masukkan kode yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=master&act=makul');
                }, 3000);   
              </script>";
                                } else {
                                  // Kode mata kuliah belum ada, lanjutkan dengan proses pengeditan

                                  $save = mysqli_query($con, "UPDATE mata_kuliahs SET kd_makul='$_POST[kode]', nm_makul='$_POST[makul]', sks='$_POST[jumlah_sks]' WHERE id_makul='$_POST[id]' ");

                                  if ($save) {
                                    echo "
            <script>
                window.location.replace('?page=master&act=makul');
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

      <!-- Modal Tambah Mata Kuliah -->
      <div id="addMakul" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="exampleModalLabel" class="modal-title">Tambah Mata Kuliah</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <form action="" method="post" class="form-horizontal">
                <div class="form-group">
                  <label for="kd_makul">Kode</label>
                  <input name="kode" type="text" id="kd_makul" placeholder="Kode Mata Kuliah" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="nm_makul">Mata Kuliah</label>
                  <input name="makul" type="text" id="nm_makul" placeholder="Nama Mata Kuliah" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="sks">SKS</label>
                  <input name="jumlah_sks" type="text" id="sks" placeholder="Jumlah SKS" class="form-control" required>
                </div>

                <div class="form-group">
                  <button name="save" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                    Simpan</button>
                </div>
              </form>
              <?php
              if (isset($_POST['save'])) {
                $kode = $_POST['kode'];
                $makul = $_POST['makul'];
                $jumlah_sks = $_POST['jumlah_sks'];

                // Periksa apakah kode mata kuliah sudah ada dalam database
                $checkExistQuery = mysqli_query($con, "SELECT * FROM mata_kuliahs WHERE kd_makul='$kode'");
                $numRows = mysqli_num_rows($checkExistQuery);

                if ($numRows > 0) {
                  // Kode mata kuliah sudah ada, tampilkan notifikasi error
                  echo "<script type='text/javascript'>
                setTimeout(function () { 
                    swal('Maaf!', 'Kode mata kuliah sudah digunakan. Masukkan kode yang lain!', {
                        icon : 'error',
                        buttons: {                    
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });    
                }, 100);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=master&act=makul');
                }, 3000);   
              </script>";
                } else {
                  // Kode mata kuliah belum ada, lanjutkan dengan menyimpan data
                  $save = mysqli_query($con, "INSERT INTO mata_kuliahs VALUES(NULL,'$kode','$makul','$jumlah_sks')");

                  if ($save) {
                    echo "<script>
                    window.location.replace('?page=master&act=makul');
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