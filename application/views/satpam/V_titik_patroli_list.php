    <!-- Flashdata Notifikasi -->
    <?php if ($this->session->flashdata('success')): ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2000
          });
        });
      </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata('error'); ?>'
          });
        });
      </script>
    <?php endif; ?>

    <!-- Box utama -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Titik Patroli</h3>
      </div>

      <div class="box-body">
        <div class="row">
          <?php foreach ($titik_patroli as $titik): 
              // Cek status titik dari database
              $status = $this->M_patroli->get_status_titik($id_jadwal, $titik->id_titik, $id_unit);

              // Ambil foto jika ada
              $foto_path = !empty($titik->foto) 
                  ? base_url('uploads/titik_patroli/' . $titik->foto) 
                  : base_url('assets/img/no-image.png'); // fallback jika foto tidak ada
          ?>
            <div class="col-md-4 col-sm-6">
              <div class="info-box">
                <span class="info-box-icon" style="background-color:#f4f4f4;">
                  <img src="<?= $foto_path; ?>" 
                      alt="<?= $titik->nama_titik; ?>" 
                      style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                </span>
                <div class="info-box-content">
                  <span class="info-box-text text-bold"><?= strtoupper($titik->nama_titik); ?></span>
                  <p><?= $titik->latitude . ', ' . $titik->longitude; ?></p>

                  <?php if ($status === 'complete'): ?>
                    <button class="btn btn-block btn-success btn-xs mt-2" disabled>
                      <i class="fa fa-check"></i> Sudah Dipatroli
                    </button>
                  <?php else: ?>
                    <button class="btn btn-block btn-warning btn-xs mt-2"
                            onclick="cekLokasi(<?= $titik->latitude ?>, <?= $titik->longitude ?>, <?= $titik->id_titik ?>)">
                      <i class="fa fa-play"></i> Mulai Patroli
                    </button>
                  <?php endif; ?>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="text-align: right;">
          <a href="<?= site_url('C_patroli'); ?>" class="btn btn-flat btn-warning w-50 me-2"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
        </div>
      </div>
    </div>


<script>
function hitungJarak(lat1, lon1, lat2, lon2) {
  const R = 6371e3;
  const φ1 = lat1 * Math.PI / 180;
  const φ2 = lat2 * Math.PI / 180;
  const Δφ = (lat2 - lat1) * Math.PI / 180;
  const Δλ = (lon2 - lon1) * Math.PI / 180;
  const a = Math.sin(Δφ / 2) ** 2 +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ / 2) ** 2;
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return R * c;
}

function cekLokasi(lat_titik, lon_titik, id_titik) {
  if (!navigator.geolocation) {
    Swal.fire('Error', 'Browser Anda tidak mendukung GPS.', 'error');
    return;
  }

  Swal.fire({
    title: 'Mengecek lokasi...',
    text: 'Mohon tunggu sebentar.',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  navigator.geolocation.getCurrentPosition(function(posisi) {
    Swal.close();
    const jarak = hitungJarak(posisi.coords.latitude, posisi.coords.longitude, lat_titik, lon_titik);

    if (jarak <= 10) {
      Swal.fire({
        icon: 'success',
        title: 'Lokasi Sesuai!',
        text: 'Anda berada dalam radius 10 meter.',
        confirmButtonText: 'Lanjutkan'
      }).then(() => {
        window.location.href = "<?= site_url('C_patroli/add/') ?>" + id_titik + "/<?= $id_jadwal ?>";
      });
    } else {
      Swal.fire('Terlalu Jauh!', 'Jarak Anda: ' + jarak.toFixed(1) + ' meter. Silakan dekati titik.', 'warning');
    }

  }, function(error) {
    Swal.close();
    Swal.fire('Error', 'Gagal mendapatkan lokasi. Pastikan GPS aktif.', 'error');
  });
}
</script>
