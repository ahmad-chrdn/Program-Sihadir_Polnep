<div class="page-inner">
  <div class="page-header">
    <h4 class="page-title">Jadwal</h4>
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
          Kelola Jadwal
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="?page=jadwal">Jadwal</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="btn-group">
            <a href="?page=jadwal&act=add" class="btn btn-primary btn-sm text-white mr-2"><i class="fa fa-plus"></i> Tambah</a>
            <button class="btn btn-primary btn-sm text-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Pilih Hari
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="?page=jadwal">---Semua---</a>
              <a class="dropdown-item" href="?page=jadwal&day=Senin">Senin</a>
              <a class="dropdown-item" href="?page=jadwal&day=Selasa">Selasa</a>
              <a class="dropdown-item" href="?page=jadwal&day=Rabu">Rabu</a>
              <a class="dropdown-item" href="?page=jadwal&day=Kamis">Kamis</a>
              <a class="dropdown-item" href="?page=jadwal&day=Jumat">Jumat</a>
            </div>
          </div>
        </div>


        <div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Prodi</th>
                  <th>Hari</th>
                  <!-- <th>Sesi</th> -->
                  <th>Kelas</th>
                  <th>Mata Kuliah</th>
                  <th>Dosen</th>
                  <th>Ruang</th>
                  <th>Semester</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $selectedDay = isset($_GET['day']) ? mysqli_real_escape_string($con, $_GET['day']) : '';
                $condition = !empty($selectedDay) ? "AND jadwals.hari = '$selectedDay'" : '';
                // Tambahkan kondisi khusus jika tidak ada hari yang dipilih
                $orderByDay = !empty($selectedDay) ? 'jadwals.hari,' : 'FIELD(jadwals.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat"),';

                $jadwal = mysqli_query($con, "SELECT 
                jadwals.id_jadwal,
                prodis.nama_prodi,
                jadwals.hari,
                jadwals.jam_ke,
                kelass.nm_kelas,
                mata_kuliahs.nm_makul,
                dosens.nm_dosen,
                ruangans.nm_ruangan,
                semesters.semester,
                semesters.thn_ajaran
            FROM jadwals
            INNER JOIN prodis ON jadwals.prodi_id = prodis.id_prodi
            INNER JOIN kelass ON jadwals.kelas_id = kelass.id_kelas
            INNER JOIN mata_kuliahs ON jadwals.makul_id = mata_kuliahs.id_makul
            INNER JOIN dosens ON jadwals.dosen_id = dosens.id_dosen
            INNER JOIN ruangans ON jadwals.ruangan_id = ruangans.id_ruangan
            INNER JOIN semesters ON jadwals.semester_id = semesters.id_semester
            WHERE semesters.status = 1 $condition
            ORDER BY $orderByDay CAST(jadwals.jam_ke AS UNSIGNED) ASC");
                foreach ($jadwal as $j) { ?>
                  <tr>
                    <td>
                      <?= $no++; ?>.
                    </td>
                    <td>
                      <?= $j['nama_prodi']; ?>
                    </td>
                    <td>
                      <?= $j['hari']; ?>
                    </td>
                    <td>
                      <?= $j['nm_kelas']; ?>
                    </td>
                    <td>
                      <?= $j['nm_makul']; ?>
                    </td>
                    <td>
                      <?= $j['nm_dosen']; ?>
                    </td>
                    <td>
                      <?= $j['nm_ruangan']; ?>
                    </td>
                    <td>
                      <?= $j['semester'] ?> <?= $j['thn_ajaran'] ?>
                    </td>
                    <td>
                      <a class="btn btn-info btn-sm" href="?page=jadwal&act=edit&id=<?= $j['id_jadwal'] ?>"><i class="far fa-edit"></i></a>
                      <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" href="?page=jadwal&act=del&id=<?= $j['id_jadwal'] ?>"><i class="fas fa-trash"></i></a>

                      <!-- <a  href="?page=nilai&jadwal=<?= $j['id_pelajaran']; ?>" class="btn btn-success btn-sm"><i class="fas fa-file-contract"></i> Lihat Absen</a> -->
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