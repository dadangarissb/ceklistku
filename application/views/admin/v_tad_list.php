<section class="content-header">
  <h1>
    Daftar TAD / User
    <small><?= htmlspecialchars($nama_unit); ?></small>
  </h1>
</section>

<section class="content">

  <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title">
      
    </h3>

    <div class="box-tools pull-right">
      <a href="<?= site_url('C_data_user/tambah_form'); ?>" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Tambah Data TAD
      </a>
    </div>
  </div>

    <div class="box-body">

      <div class="table-responsive">
        <table id="tadTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="50">No</th>
              <th>Username</th>
              <th>Password</th>
              <th>Nama</th>
              <th>Lokasi</th>
              <th width="120">Aksi</th>
            </tr>
          </thead>
          <tbody>
        <?php if (!empty($data_tad)): ?>
          <?php $no = 1; foreach ($data_tad as $u): ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= htmlspecialchars($u->username); ?></td>
              <td><?= htmlspecialchars($u->password); ?></td>
              <td><?= htmlspecialchars($u->nama_user); ?></td>
              <td>
                <?php if (!empty($u->lokasi)): ?>
                  <?php
                    $nama_lokasi = [];
                    foreach ($u->lokasi as $l) {
                      $nama_lokasi[] = htmlspecialchars($l->nama_lokasi);
                    }
                    echo implode(', ', $nama_lokasi);
                  ?>
                <?php else: ?>
                  <span class="text-muted">- Tidak ada lokasi -</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="<?= site_url('C_data_user/edit_form/'.$u->username); ?>" class="btn btn-info btn-xs">
                  <i class="fa fa-pencil"></i> Edit
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Belum ada data TAD.</td>
          </tr>
        <?php endif; ?>
        </tbody>
        </table>
      </div>

    </div>
  </div>

</section>

<!-- Pastikan ini sudah ada di template AdminLTE kamu -->
<script>
  $(function () {
    $('#tadTable').DataTable({
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data tersedia",
        "infoFiltered": "(difilter dari _MAX_ data)",
        "paginate": {
          "next": "Berikutnya",
          "previous": "Sebelumnya"
        }
      }
    });
  });
</script>


<!-- Sweet allert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if ($this->session->flashdata('swal')): 
  $swal = $this->session->flashdata('swal');
?>
<script>
  <?php if ($swal['type'] == 'success'): ?>
    // Kalau SUKSES: auto close
    Swal.fire({
      icon: '<?= $swal['type']; ?>',
      title: '<?= $swal['title']; ?>',
      text: '<?= $swal['text']; ?>',
      timer: 3000,              // 2 detik, bisa ubah
      showConfirmButton: false, // tidak ada tombol
      timerProgressBar: true
    });
  <?php else: ?>
    // Kalau ERROR / GAGAL: pakai tombol Close / OK
    Swal.fire({
      icon: '<?= $swal['type']; ?>',
      title: '<?= $swal['title']; ?>',
      text: '<?= $swal['text']; ?>',
      confirmButtonText: 'Tutup'
    });
  <?php endif; ?>
</script>
<?php endif; ?>
