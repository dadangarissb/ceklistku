<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-clock-o text-blue"></i> Jadwal Patroli Unit <?= $this->session->userdata('id_unit'); ?></h3>
      <a href="<?= site_url('C_jadwal_patroli/add') ?>" class="btn btn-success btn-sm pull-right">
        <i class="fa fa-plus"></i> Tambah Jadwal
      </a>
    </div>

    <div class="box-body">
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

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nama Jadwal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($jadwal_patroli as $j): ?>
          <tr>
            <td><?= $j->nama_jadwal ?></td>
            <td><?= date('H:i', strtotime($j->jam_mulai)) ?></td>
            <td><?= date('H:i', strtotime($j->jam_selesai)) ?></td>
            <td><?= $j->keterangan ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
