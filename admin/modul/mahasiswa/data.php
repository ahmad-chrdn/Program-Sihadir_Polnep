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
        <a href="?page=mahasiswa">Data Mahasiswa</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <a href="?page=mahasiswa&act=add" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus"></i>
              Tambah</a>
          </div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nim</th>
                  <th>Nama Mahasiswa</th>
                  <th>Foto</th>
                  <th>Kelas</th>
                  <th>Prodi</th>
                  <th>Jurusan</th>
                  <th>Status</th>
                  <th>Opsi</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $no = 1;
                $mahasiswa = mysqli_query($con, "SELECT m.*, k.nm_kelas, p.nama_prodi, j.nama_jurusan
                FROM mahasiswas m
                JOIN kelass k ON m.kelas_id = k.id_kelas
                JOIN prodis p ON m.prodi_id = p.id_prodi
                JOIN jurusans j ON p.jurusan_id = j.id_jurusan");
                foreach ($mahasiswa as $m) { ?>
                  <tr>
                    <td>
                      <?= $no++; ?>.
                    </td>
                    <td>
                      <?= $m['nim']; ?>
                    </td>
                    <td>
                      <?= $m['nm_mahasiswa']; ?>
                    </td>
                    <td><img src="../assets/img/mahasiswa/<?= $m['foto'] ?>" width="45" height="45"></td>
                    <td>
                      <?= $m['nm_kelas']; ?>
                    </td>
                    <td>
                      <?= $m['nama_prodi']; ?>
                    </td>
                    <td>
                      <?= $m['nama_jurusan']; ?>
                    </td>
                    <td>
                      <?php
                      $status = $m['status'];

                      if ($status == 'Aktif') {
                        echo "<span class='badge badge-success'>Aktif</span>";
                      } elseif ($status == 'SP1') {
                        echo "<span class='badge badge-warning'>SP1</span>";
                      } elseif ($status == 'SP2') {
                        echo "<span class='badge badge-warning'>SP2</span>";
                      } elseif ($status == 'SP3') {
                        echo "<span class='badge badge-danger'>SP3</span>";
                      } elseif ($status == 'DO') {
                        echo "<span class='badge badge-danger'>DO</span>";
                      }
                      ?>
                    </td>
                    <td>
                      <!-- Modal Edit Status -->
                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?= $m['id_mahasiswa'] ?>" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 id="exampleModalLabel" class="modal-title">Edit Status</h4>
                              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                              <form action="" method="post">
                                <div class="row">
                                  <div class="col-md-10">
                                    <div class="form-group">
                                      <label for="nim">Nim Mahasiswa</label>
                                      <input name="kode" type="text" id="nim" value="<?= $m['nim'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label for="nm_mahasiswa">Nama Mahasiswa</label>
                                      <input name="id" type="hidden" value="<?= $m['id_mahasiswa'] ?>">
                                      <input name="nama" type="text" id="nm_mahasiswa" value="<?= $m['nm_mahasiswa'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label for="status">Status</label>
                                      <select name="status" id="status" class="form-control">
                                        <option value="Aktif" <?= $m['status'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="SP1" <?= $m['status'] == 'SP1' ? 'selected' : ''; ?>>SP1</option>
                                        <option value="SP2" <?= $m['status'] == 'SP2' ? 'selected' : ''; ?>>SP2</option>
                                        <option value="SP3" <?= $m['status'] == 'SP3' ? 'selected' : ''; ?>>SP3</option>
                                        <option value="DO" <?= $m['status'] == 'DO' ? 'selected' : ''; ?>>DO</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <button name="submit_status" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                        Simpan</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                              <?php
                              if (isset($_POST['submit_status'])) {
                                $newStatus = $_POST['status'];
                                $idMahasiswa = $_POST['id'];
                                $updateStatusQuery = mysqli_query($con, "UPDATE mahasiswas SET status='$newStatus' WHERE id_mahasiswa='$idMahasiswa'");
                                if ($updateStatusQuery) {
                                  echo "<script>window.location.replace('?page=mahasiswa');</script>";
                                } else {
                                  echo "<script type='text/javascript'>
                                        setTimeout(function () { 
                                            swal('Maaf!', 'Gagal mengubah status mahasiswa', {
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
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit<?= $m['id_mahasiswa'] ?>"><i class="fas fa-info-circle"></i></a>
                      <a class="btn btn-info btn-sm" href="?page=mahasiswa&act=edit&id=<?= $m['id_mahasiswa'] ?>"><i class="far fa-edit"></i></a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=mahasiswa&act=del&id=<?= $m['id_mahasiswa'] ?>"><i class="fas fa-trash"></i>
                      </a>
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