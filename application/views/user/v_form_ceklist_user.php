    <div class="box box-primary">
        <div class="box-header with-border text-center">
            <h3 class="box-title"><b><?= $nama_lokasi ?></b></h3>
            <div class="text-muted"><?= date('d M Y') ?></div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="bg-gray">
                        <th width="50px" class="text-center">No</th>
                        <th>Daftar Pekerjaan Yang Harus Dicek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($uraian_tugas as $ut): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td><?= $ut->nama_detail_pekerjaan ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <?php foreach ($jadwal_sesi as $s): ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-solid border-light" style="border: 1px solid #ddd;">
                <div class="box-header with-border <?= ($s->status_cek == 'sudah') ? 'bg-green' : 'bg-gray' ?>">
                    <h3 class="box-title" style="color:#fff">
                        <p>Jadwal: <?= substr($s->waktu_awal_cek, 0, 5) ?> - <?= substr($s->waktu_akhir_cek, 0, 5) ?></p>
                    </h3>
                </div>
                <div class="box-body text-center">
                    <?php if($s->status_cek == 'sudah'): ?>
                        <button class="btn btn-success btn-lg btn-block disabled">
                            <i class="fa fa-check-circle"></i> SUDAH CEKLIST
                        </button>
                    <?php elseif($s->boleh_input): ?>
                        <a href="<?= site_url('C_user/proses_konfirmasi/'.$id_lokasi.'/'.$s->id_freq_ceklist) ?>" 
                           class="btn btn-primary btn-lg btn-block"
                           onclick="return confirm('Sudah mengecek semua uraian tugas di atas?')">
                           <b>KONFIRMASI SEKARANG</b>
                        </a>
                    <!-- <?php if($s->boleh_input): ?>
                        <button type="button" 
                                class="btn btn-primary btn-lg btn-block" 
                                onclick="konfirmasiCeklist('<?= $id_lokasi ?>', '<?= $s->id_freq_ceklist ?>', '<?= substr($s->waktu_awal_cek, 0, 5) ?>')">
                            <b>KONFIRMASI SEKARANG</b>
                        </button>
                    <?php endif; ?> -->

                    <?php else: ?>
                        <button class="btn btn-default btn-lg btn-block disabled text-muted">
                            <i class="fa fa-lock"></i> TERKUNCI
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

<div class="row">
    <div class="col-xs-12">
        <br>
        <a href="<?= site_url('C_user/list_lokasi_user/'.$username) ?>" class="btn btn-warning btn-block btn-flat">
            <i class="fa fa-home"></i> Kembali ke Menu Lokasi
        </a>
        <br>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function konfirmasiCeklist(id_lokasi, id_freq, jam) {
    Swal.fire({
        title: 'Konfirmasi Sesi ' + jam,
        text: "Apakah Anda yakin sudah mengerjakan semua uraian tugas di atas?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Sudah Selesai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Arahkan ke URL proses konfirmasi jika user klik "Ya"
            window.location.href = "<?= site_url('C_pekerjaan/proses_konfirmasi/') ?>" + id_lokasi + "/" + id_freq;
        }
    })
}

// Menampilkan Alert Sukses/Gagal dari Flashdata Controller
<?php if($this->session->flashdata('success')): ?>
    Swal.fire('Berhasil!', '<?= $this->session->flashdata('success') ?>', 'success');
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    Swal.fire('Gagal!', '<?= $this->session->flashdata('error') ?>', 'error');
<?php endif; ?>
</script>