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
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="?page=mahasiswa&act=add">Daftar Akun</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="card-title">Pendaftaran Akun Mahasiswa</h3>
        </div>
        <div class="card-body">
          <form action="?page=mahasiswa&act=proses" method="post" enctype="multipart/form-data">

            <table cellpadding="3" style="font-weight: bold;">
              <tr>
                <td>NIM</td>
                <td>:</td>
                <td><input type="text" class="form-control" name="nim" placeholder="NIM Mahasiswa" required></td>
              </tr>

              <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td><input name="nama" type="text" class="form-control" placeholder="Nama Mahasiswa" required> </td>
              </tr>

              <tr>
                <td>Kelas Mahasiswa</td>
                <td>:</td>
                <td>
                  <select class="form-control" name="kelas">
                    <option>Pilih Kelas</option>
                    <?php
                    $sqlKelas = mysqli_query($con, "SELECT * FROM kelass ORDER BY id_kelas ASC");
                    while ($kelas = mysqli_fetch_array($sqlKelas)) {
                      echo "<option value='$kelas[id_kelas]'>$kelas[nm_kelas]</option>";
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
                    <option>Prodi - Jurusan</option>
                    <?php
                    $sqlProdi = mysqli_query($con, "SELECT prodis.id_prodi, prodis.nama_prodi, jurusans.nama_jurusan FROM prodis JOIN jurusans ON prodis.jurusan_id = jurusans.id_jurusan ORDER BY prodis.id_prodi ASC");

                    while ($prodi = mysqli_fetch_array($sqlProdi)) {
                      echo "<option value='$prodi[id_prodi]'>$prodi[nama_prodi] - $prodi[nama_jurusan]</option>";
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
                    <option>Pilih Jurusan</option>
                    <?php
                    $sqlJurusan = mysqli_query($con, "SELECT * FROM jurusans ORDER BY id_jurusan ASC");
                    while ($jurusan = mysqli_fetch_array($sqlJurusan)) {
                      echo "<option value='$jurusan[id_jurusan]'>$jurusan[nama_jurusan]</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td colspan="3">
                  <button name="saveMahasiswa" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                    Simpan</button>
                  <a href="?page=mahasiswa&act=add" class="btn btn-warning"><i class="fa fa-chevron-left"></i>
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