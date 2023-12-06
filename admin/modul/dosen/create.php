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
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="?page=dosen&act=add">Daftar Akun</a>
      </li>
    </ul>
  </div>
  <div class="row">

    <div class="col-md-8">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="card-title">Pendaftaran Akun Dosen</h3>
        </div>
        <div class="card-body">
          <form action="?page=dosen&act=proses" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>NIP/NUPTK</label>
              <input name="nip" type="text" class="form-control" placeholder="NIP/NUPTK" required>
            </div>

            <div class="form-group">
              <label>Nama Dosen</label>
              <input name="nama" type="text" class="form-control" placeholder="Nama dan Gelar" required>
            </div>

            <div class="form-group">
              <button name="saveDosen" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              <a href="?page=dosen&act=add" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Batal</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>