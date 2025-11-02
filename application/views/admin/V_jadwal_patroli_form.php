<section class="content-header">
  <h1><i class="fa fa-clock-o"></i> Tambah Jadwal Patroli</h1>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Form Jadwal</h3>
    </div>

    <form action="<?= site_url('C_jadwal_patroli/simpan'); ?>" method="post">
      <div class="box-body">

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="form-group">
          <input type="hidden" class="form-control" name="id_unit" value="<?= $this->session->userdata('id_unit'); ?>" readonly>
        </div>

        <div class="form-group">
          <label>Nama Jadwal</label>
          <input type="text" class="form-control" name="nama_jadwal" placeholder="Contoh: Shift Pagi" required>
        </div>

        <div class="form-group">
          <label>Jam Mulai</label>
          <div class="input-group bootstrap-timepicker">
            <input type="text" class="form-control timepicker" name="jam_mulai" required>
            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
          </div>
        </div>

        <div class="form-group">
          <label>Jam Selesai</label>
          <div class="input-group bootstrap-timepicker">
            <input type="text" class="form-control timepicker" name="jam_selesai" required>
            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
          </div>
        </div>

        <div class="form-group">
          <label>Keterangan</label>
          <textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan tambahan..."></textarea>
        </div>

      </div>

      <div class="box-footer text-center">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <a href="<?= site_url('C_jadwal_patroli'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</section>





<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<script>
  $('.timepicker').timepicker({
    showInputs: false,
    showMeridian: false, // ⏰ format 24 jam
    minuteStep: 1
  });
</script>
