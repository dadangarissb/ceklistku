<style>
  .dataTables_filter input {
    width: 400px !important;   /* atur sesuai selera, misal 300px / 400px */
    display: inline-block;
  }
</style>

<section class="content-header">
  <h1>
    Tambah Data TAD / User
    <small><?= htmlspecialchars($nama_unit); ?></small>
  </h1>
</section>

<section class="content">

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-user-plus"></i> Form Tambah TAD</h3>
    </div>

    <form method="post" action="<?= site_url('C_data_user/simpan'); ?>" id="formSimpanTAD">
      <div class="box-body">

      <input type="hidden" name="id_unit" id="id_unit" class="form-control" required>

        <!-- Username -->
        <div class="form-group">
          <label>Username (tanpa spasi)<span class="text-danger">*</span></label>
          <input type="text" name="username" id="username" class="form-control" required autocomplete="off">
          <small id="usernameHelp" class="form-text"></small>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label>Password <span class="text-danger">*</span></label>
          <input type="text" name="password" class="form-control" required placeholder="">
        </div>

        <!-- Konfirmasi Password -->
        <!-- <div class="form-group">
          <label>Ulangi Password <span class="text-danger">*</span></label>
          <input type="password" name="password_konfirmasi" class="form-control" required placeholder="Ulangi password">
        </div> -->

        <!-- Nama -->
        <div class="form-group">
          <label>Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_user" class="form-control" required placeholder="">
        </div>

        <!-- Lokasi (multi pilih) -->
        <div class="form-group">
          <label>Lokasi Penugasan</label>
          <div class="form-group">
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
                        <?php if (!empty($l->nama_pic)): ?>
                          <span class="label label-info"><?= htmlspecialchars($l->nama_pic); ?></span>
                        <?php else: ?>
                          <span class="text-muted">- Kosong -</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <input type="checkbox" 
                              name="lokasi[]" 
                              value="<?= $l->id_lokasi; ?>" 
                              class="cek-lokasi"
                              data-nama="<?= htmlspecialchars($l->nama_lokasi); ?>">
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          

          <div class="form-group">
              <label>Rekap Lokasi Dipilih:</label>
              <div id="rekapLokasi" class="well well-sm" style="min-height:40px;">
                <span class="text-muted">Belum ada lokasi dipilih</span>
              </div>
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

<!-- Untuk disable button simpan setelah klik simpan -->
<script>
document.getElementById('formSimpanTAD').addEventListener('submit', function() {
  var btn = document.getElementById('btnSimpan');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
});
</script>



<!-- Untuk menampilkan lokasi yang dipilih -->
<script>
  $(document).on('change', '.cek-lokasi', function() {
    let selected = [];

    $('.cek-lokasi:checked').each(function() {
      selected.push($(this).data('nama'));
    });

    if (selected.length > 0) {
      $('#rekapLokasi').html('<ul><li>' + selected.join('</li><li>') + '</li></ul>');
    } else {
      $('#rekapLokasi').html('<span class="text-muted">Belum ada lokasi dipilih</span>');
    }
  });
</script>


<!-- JAvascript list lokasi dipilih bernomor -->
<script>
  $(document).on('change', '.cek-lokasi', function() {
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
  });
</script>


<!-- Javascript data tables -->
<script>
  $(function () {
    $('#tabelLokasi').DataTable({
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      "ordering": true,
      "columnDefs": [
        { "orderable": false, "targets": [2] } // kolom "Pilih" tidak bisa di-sort
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

<!-- Untuk cek ketersediaan username -->
<script>
$(document).ready(function() {
  $('#username').on('keyup blur', function() {
    var username = $(this).val();

    if (username.length < 3) {
      $('#usernameHelp').html('<span class="text-muted">Minimal 3 karakter</span>');
      return;
    }

    $.ajax({
      url: "<?= site_url('C_data_user/cek_username'); ?>",
      type: "POST",
      data: { username: username },
      dataType: "json",
      success: function(res) {
        if (res.status == 'taken') {
          $('#usernameHelp').html('<span class="text-danger"><i class="fa fa-times"></i> Username sudah digunakan, cari username lain</span>');
        } else {
          $('#usernameHelp').html('<span class="text-success"><i class="fa fa-check"></i> Username tersedia</span>');
        }
      },
      error: function() {
        $('#usernameHelp').html('<span class="text-warning">Gagal cek username</span>');
      }
    });
  });
});
</script>



<!-- Sweet allert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 <?php if ($this->session->flashdata('swal')): ?>
  <?php $swal = $this->session->flashdata('swal'); ?>
  <script>
    Swal.fire({
      icon: '<?= $swal['type']; ?>',
      title: '<?= $swal['title']; ?>',
      text: '<?= $swal['text']; ?>',
      confirmButtonText: 'Tutup'
    });
  </script>
<?php endif; ?>