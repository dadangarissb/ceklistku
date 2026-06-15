<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"> <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Buat Laporan Keluhan Baru</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('keluhan/C_keluhan') ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="<?= base_url('Keluhan/C_keluhan/simpan') ?>" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name="pelapor" class="form-control input-lg" value="<?php echo $username; ?>" required>
                        <div class="form-group">
                            <label>Nama Keluhan / Barang Rusak</label>
                            <input type="text" name="nama_keluhan" class="form-control input-lg" placeholder="Misal: Pompa Air Mati" required>
                        </div>

                        <div class="form-group">
                            <label>Lokasi Detail</label>
                            <input type="text" name="lokasi_keluhan" class="form-control" placeholder="Misal: Wisma Gladiol Ruang Makan" required>
                        </div>

                        <div class="form-group">
                            <label>Unggah Foto Bukti (Kondisi Saat Ini)</label>
                            <input type="file" name="foto_keluhan" class="form-control" accept="image/*" required>
                            <p class="help-block">Pastikan foto jelas agar mudah diidentifikasi PIC.</p>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Kosongkan Form</button>
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-save"></i> Simpan & Kirim Laporan
                        </button>
                    </div>
                </form>
                </div>
        </div>
    </div>
</section>

<style>
    /* Tambahan agar inputan terlihat lebih profesional */
    .form-control:focus {
        border-color: #3c8dbc;
        box-shadow: none;
    }
    .box {
        margin-top: 20px;
        border-top: 3px solid #3c8dbc;
    }
</style>