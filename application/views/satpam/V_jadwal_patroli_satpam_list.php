<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-calendar"></i> Jadwal Patroli Unit <?= $id_unit; ?></h3>
  </div>

  <div class="box-body">
    <div class="row">
      <?php 
      date_default_timezone_set('Asia/Makassar');
      $now = date('H:i:s');
      ?>

      <?php foreach ($jadwal as $j): 
        // Tentukan status berdasarkan waktu
        if ($now < $j->jam_mulai) {
          $status = 'belum_aktif';
          $warna = 'secondary';
          $label = 'Belum Aktif';
        } elseif ($now >= $j->jam_mulai && $now <= $j->jam_selesai) {
          $status = 'aktif';
          $warna = 'primary';
          $label = 'Sedang Aktif';
        } else {
          // Cek jumlah titik patroli yang sudah dilakukan
          $this->db->where('id_jadwal', $j->id_jadwal);
          $this->db->where('id_unit', $id_unit);
          $total_dilakukan = $this->db->count_all_results('patroli');

          if ($total_dilakukan >= $jumlah_titik) {
            $status = 'complete';
            $warna = 'success';
            $label = 'Complete';
          } else {
            $status = 'tidak_lengkap';
            $warna = 'danger';
            $label = 'Tidak Lengkap';
          }
        }
      ?>
      <div class="col-md-4 col-sm-6">
        <div class="info-box bg-<?= $warna; ?>">
          <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-bold" style="color: black"><?= strtoupper($j->nama_jadwal); ?></span>
            <span style="color: black">Waktu: <?= substr($j->jam_mulai, 0, 5) . ' - ' . substr($j->jam_selesai, 0, 5); ?></span>
            <span class="label bg-<?= $warna; ?>"><?= $label; ?></span>
            <br>

            <?php if ($status == 'belum_aktif'): ?>
                <a href="" style="margin-top: 8px;" class="btn btn-block btn-default btn-sm mt-2">
                <i class="fa fa-ban"></i> Belum Aktif
                </a>
            <?php elseif ($status == 'aktif'): ?>
                <a href="<?= site_url('C_patroli/titik_patroli/'.$j->id_jadwal); ?>" style="margin-top: 8px;" class="btn btn-block btn-primary btn-sm mt-2">
                <i class="fa fa-play"></i> Mulai Patroli
                </a>
            <?php elseif ($status == 'complete'): ?>
                <a href="" style="margin-top: 8px;" class="btn btn-block btn-success btn-sm mt-2">
                <i class="fa fa-check"></i> Lengkap
                </a>
            <?php else: ?>
                <a href="<?= site_url('C_patroli/titik_patroli/'.$j->id_jadwal); ?>" style="margin-top: 8px;" class="btn btn-block btn-danger btn-sm mt-2">
                <i class="fa fa-exclamation-triangle"></i> Tidak Lengkap
                </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align: right;">
        <a href="<?= site_url('C_dashboard_satpam'); ?>" class="btn btn-flat btn-warning w-50 me-2"><i class="fa fa-arrow-circle-left"></i> Kembali ke Dashboard</a>
    </div>
  </div>
</div>

<!-- Notifikasi -->
<?php if ($this->session->flashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?= $this->session->flashdata('success'); ?>',
      timer: 2000,
      showConfirmButton: false
    });
  </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '<?= $this->session->flashdata('error'); ?>'
    });
  </script>
<?php endif; ?>
