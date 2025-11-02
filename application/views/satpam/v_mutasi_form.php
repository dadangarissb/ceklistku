<!doctype html>
<html>
    <head>
        <title>Tambah Data Usaha</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
    </head>
    <body>
    <section class="content">

      <div class="row">
        <div class="col-md-2">
        </div> 
        <div class="col-md-8">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

        <h3 style="margin-top:0px" align="center">Form Data Usaha</h3>
        <form action="<?php echo site_url('c_user_satpam/input_mutasi_action'); ?>" method="post">
     <div class="form-group">
        <label for="tanggal_jaga">Tanggal Jaga</label>
        <input 
            type="date" 
            class="form-control" 
            name="tanggal_jaga" 
            id="tanggal_jaga" 
            value="<?php echo date('Y-m-d'); ?>" 
            readonly 
            required>
    </div>


    <div class="form-group">
        <label for="shift">Shift</label>
        <select name="shift" id="shift" class="form-control" required>
            <option value="">-- Pilih Shift --</option>
            <option value="1 ke 2">1 ke 2</option>
            <option value="2 ke 3">2 ke 3</option>
            <option value="3 ke 1">3 ke 1</option>
        </select>
    </div>

    <div class="form-group">
        <label for="petugas_serah">Petugas Serah</label>
        <input type="text" class="form-control" name="petugas_serah" id="petugas_serah" required>
    </div>

    <div class="form-group">
        <label for="petugas_terima">Petugas Terima</label>
        <select name="petugas_terima" id="petugas_terima" class="form-control" required>
            <option value="">-- Pilih Petugas Terima --</option>
            <?php foreach ($satpam as $s): ?>
                <option value="<?= $s->id_satpam; ?>" <?= set_select('petugas_terima', $s->id_satpam); ?>>
                    <?= $s->nama_satpam; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="catatan_mutasi">Catatan Mutasi</label>
        <textarea class="form-control" 
                name="catatan_mutasi" 
                id="catatan_mutasi" 
                rows="3" 
                placeholder="Tuliskan catatan mutasi di sini..." 
                required></textarea>
        <div class="invalid-feedback">
            Catatan mutasi wajib diisi.
        </div>
    </div>

    <hr>
    <h5>Daftar Peralatan Jaga</h5>

    <?php foreach ($peralatan_jaga as $key => $data) { ?>
        <div class="form-group border p-3 rounded mb-3">
            <label><strong><?php echo $data->nama_peralatan; ?></strong></label>

            <input type="hidden" name="peralatan[<?php echo $key; ?>][id_peralatan]" 
                value="<?php echo $data->id_peralatan; ?>">
            <input type="hidden" name="peralatan[<?php echo $key; ?>][nama_peralatan]" 
                value="<?php echo $data->nama_peralatan; ?>">

            <!-- 🔹 Jumlah Peralatan -->
            <input type="number" class="form-control mb-2" 
                name="peralatan[<?php echo $key; ?>][jumlah]" 
                value="<?php echo $data->jumlah; ?>" 
                placeholder="Masukkan jumlah" 
                min="0"
                required>

            <!-- 🔹 Kondisi Peralatan -->
            <select class="form-control" 
                    name="peralatan[<?php echo $key; ?>][kondisi]" 
                    required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik">Baik</option>
                <option value="Rusak">Rusak</option>
                <option value="Rusak Sebagian">Rusak Sebagian</option>
                <option value="Hilang">Hilang</option>
            </select>
        </div>
    <?php } ?>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </body>

     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.priceformat.min.js"></script>
</html>
