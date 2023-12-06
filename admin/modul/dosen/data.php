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
        <a href="?page=dosen">Data Dosen</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <a href="?page=dosen&act=add" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus"></i>
              Tambah</a>
          </div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nip</th>
                  <th>Nama Dosen</th>
                  <th>Foto</th>
                  <th>Status</th>
                  <th>Opsi</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $no = 1;
                $dosen = mysqli_query($con, "SELECT * FROM dosens");
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
                    <td><img src="../assets/img/dosen/<?= $d['foto'] ?>" width="45" height="45"></td>
                    <td>
                      <?php if ($d['status'] == '1') {
                        echo "<span class='badge badge-success'>Aktif</span>";
                      } else {
                        echo "<span class='badge badge-danger'>Tidak Aktif</span>";
                      } ?>
                    </td>
                    <td>
                      <?php
                      if ($d['status'] == 0) {
                      ?>
                        <a onclick="return confirm('Aktifkan Dosen?')" href="?page=dosen&act=set&id=<?= $d['id_dosen'] ?>&status=1" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Aktifkan</a>
                      <?php

                      } else {
                      ?>
                        <a onclick="return confirm('NonAktifkan Dosen?')" href="?page=dosen&act=set&id=<?= $d['id_dosen'] ?>&status=0" class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i> Nonaktif</a>
                      <?php
                      }
                      ?>

                      <a class="btn btn-info btn-sm" href="?page=dosen&act=edit&id=<?= $d['id_dosen'] ?>"><i class="far fa-edit"> Edit</i></a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=dosen&act=del&id=<?= $d['id_dosen'] ?>"><i class="fas fa-trash"> Hapus</i>
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