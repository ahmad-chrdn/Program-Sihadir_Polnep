<?php
$edit = mysqli_query($con, "SELECT * FROM mahasiswas WHERE id_mahasiswa ='$_GET[id]' ");
foreach ($edit as $m) ?>
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
        <a href="#" onclick="return false;">Kelola Mahasiswa</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="?page=mahasiswa&act=edit&id=<?= $_GET['id'] ?>">Edit Mahasiswa</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4">Edit Akun Mahasiswa</h3>
        </div>
        <div class="card-body">
          <form action="?page=mahasiswa&act=proses" method="post" enctype="multipart/form-data">

            <table cellpadding="3" style="font-weight: bold;">
              <tr>
                <td>NIM</td>
                <td>:</td>
                <td><input type="hidden" name="id" value="<?= $m['id_mahasiswa'] ?>">
                  <input name="nim" type="text" class="form-control" value="<?= $m['nim'] ?>">
                </td>
              </tr>

              <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td><input type="text" name="nama" class="form-control" value="<?= $m['nm_mahasiswa'] ?>"></td>
              </tr>

              <!-- Academic Information -->
              <tr>
                <td>Kelas Mahasiswa</td>
                <td>:</td>
                <td>
                  <select class="form-control" name="kelas">
                    <option value="">Pilih Kelas</option>
                    <?php
                    $kelas = mysqli_query($con, "SELECT * FROM kelass ORDER BY id_kelas ASC");
                    foreach ($kelas as $kelasData) {
                      $selected = ($kelasData['id_kelas'] == $m['kelas_id']) ? "selected" : "";
                      echo "<option value='{$kelasData['id_kelas']}' $selected>{$kelasData['nm_kelas']}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>
                  <select class="form-control" name="prodi">
                    <option value="">Prodi - Jurusan</option>
                    <?php
                    $sqlProdi = mysqli_query($con, "SELECT prodis.id_prodi, prodis.nama_prodi, jurusans.nama_jurusan FROM prodis JOIN jurusans ON prodis.jurusan_id = jurusans.id_jurusan ORDER BY prodis.id_prodi ASC");

                    foreach ($sqlProdi as $prodi) {
                      $selected = ($prodi['id_prodi'] == $m['prodi_id']) ? "selected" : "";
                      echo "<option value='{$prodi['id_prodi']}' $selected>{$prodi['nama_prodi']} - {$prodi['nama_jurusan']}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>
                  <select class="form-control" name="jurusan">
                    <option value="">Pilih Jurusan</option>
                    <?php
                    $sqlJurusan = mysqli_query($con, "SELECT * FROM jurusans ORDER BY id_jurusan ASC");
                    foreach ($sqlJurusan as $jurusan) {
                      $selected = ($jurusan['id_jurusan'] == $m['jurusan_id']) ? "selected" : "";
                      echo "<option value='{$jurusan['id_jurusan']}' $selected>{$jurusan['nama_jurusan']}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <!-- <tr>
                <td>Pas Foto</td>
                <td>:</td>
                <td><input type="file" class="form-control" name="foto"></td>
              </tr> -->

              <tr>
                <td colspan="3">
                  <button name="editMahasiswa" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                    Simpan</button>
                  <a href="?page=mahasiswa" class="btn btn-warning"><i class="fa fa-chevron-left"></i>
                    Batal</a>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>