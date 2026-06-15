<style>
  .dataTables_filter input {
    width: 400px !important;
    display: inline-block;
  }
</style>

<section class="content-header">
  <h1>
    Edit Data TAD / User
    <small><?= htmlspecialchars($nama_unit); ?></small>
  </h1>
</section>

<section class="content">

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-user"></i> Form Edit TAD</h3>
    </div>

    <form method="post" action="<?= site_url('C_data_user/update'); ?>" id="formSimpanTAD">
      <div class="box-body">

        <!-- Username -->
        <div class="form-group">
          <label>Username (tanpa spasi)</label>
          <input type="text" name="username" class="form-control"
                 value="<?= htmlspecialchars($user->username); ?>" readonly>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label>Password<span class="text-danger"> *</span></label>
          <input type="text" name="password" class="form-control"
                 value="<?= htmlspecialchars($user->password); ?>" required>
        </div>

        <!-- Nama -->
        <div class="form-group">
          <label>Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_user" class="form-control"
                 value="<?= htmlspecialchars($user->nama_user); ?>" required>
        </div>

        <!-- Lokasi (multi pilih) -->
        <div class="form-group">
          <label>Lokasi Penugasan (PIC)</label>
          <div class="table-responsive">
            <table id="tabelLokasi" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th width="45%">Nama Lokasi</th>
                  <th width="35%">PIC Saat Ini</th>
                  <th width="20%" class="text-center">Pilih / Ganti PIC</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data_lokasi as $l): ?>
                  <tr>
                    <td><?= htmlspecialchars($l->nama_lokasi); ?></td>
                    <td>
                      <?php if (!empty($l->pic)): ?>
                        <span class="label label-info"><?= htmlspecialchars($l->pic); ?></span>
                      <?php else: ?>
                        <span class="text-muted">- Kosong -</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <input type="checkbox"
                             name="lokasi[]"
                             value="<?= $l->id_lokasi; ?>"
                             class="cek-lokasi"
                             data-nama="<?= htmlspecialchars($l->nama_lokasi); ?>"
                             <?= in_array($l->id_lokasi, $lokasi_terpilih) ? 'checked' : ''; ?>>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Rekap lokasi -->
        <div class="form-group">
          <label>Rekap Lokasi Dipilih:</label>
          <div id="rekapLokasi" class="well well-sm" style="min-height:40px;">
            <span class="text-muted">Belum ada lokasi dipilih</span>
          </div>
        </div>

      </div>

        <div class="box-footer">
        <div class="pull-right">
            <a href="<?= site_url('C_data_user'); ?>" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" id="btnSimpan" class="btn btn-success">
            <i class="fa fa-save"></i> Simpan
            </button>
        </div>
        </div>
    </form>

  </div>

</section>

<!-- Disable button saat submit -->
<script>
document.getElementById('formSimpanTAD').addEventListener('submit', function() {
  var btn = document.getElementById('btnSimpan');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
});
</script>

<!-- Rekap lokasi dipilih (list bernomor) -->
<script>
function refreshRekapLokasi() {
  let selected = [];

  $('.cek-lokasi:checked').each(function() {
    selected.push($(this).data('nama'));
  });

  if (selected.length > 0) {
    let html = '<ol style="margin:0; padding-left:18px;">';
    selected.forEach(function(nama) {
      html += '<li>' + nama + '</li>';
    });
    html += '</ol>';
    $('#rekapLokasi').html(html);
  } else {
    $('#rekapLokasi').html('<span class="text-muted">Belum ada lokasi dipilih</span>');
  }
}

$(document).on('change', '.cek-lokasi', function() {
  refreshRekapLokasi();
});

// Panggil saat pertama load (biar sesuai data edit)
$(document).ready(function() {
  refreshRekapLokasi();
});
</script>

<!-- DataTables -->
<script>
$(function () {
  $('#tabelLokasi').DataTable({
    "pageLength": 10,
    "lengthMenu": [10, 25, 50, 100],
    "ordering": true,
    "columnDefs": [
      { "orderable": false, "targets": [2] }
    ],
    "language": {
      "search": "Cari Lokasi : ",
      "lengthMenu": "Tampilkan _MENU_ data",
      "zeroRecords": "Data tidak ditemukan",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      "infoEmpty": "Tidak ada data",
      "infoFiltered": "(difilter dari _MAX_ data)",
      "paginate": {
        "next": "Berikutnya",
        "previous": "Sebelumnya"
      }
    }
  });
});
</script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('swal')): ?>
  <?php $swal = $this->session->flashdata('swal'); ?>
  <script>
    Swal.fire({
      icon: '<?= $swal['type']; ?>',
      title: '<?= $swal['title']; ?>',
      text: '<?= $swal['text']; ?>',
      <?php if ($swal['type'] == 'success'): ?>
      timer: 2000,
      showConfirmButton: false
      <?php else: ?>
      confirmButtonText: 'Tutup'
      <?php endif; ?>
    });
  </script>
<?php endif; ?>
