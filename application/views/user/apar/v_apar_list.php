
    <div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Daftar APAR</h3>
        
        <div class="box-tools pull-right">
            <a href="<?= base_url('C_apar/tambah_apar') ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Tambah APAR Baru
            </a>
            
            <a href="<?= base_url('C_dashboard_user') ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-blue">
                        <th>No. APAR</th>
                        <th>Lokasi</th>
                        <!-- <th>Jenis / Merk</th> -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($apar as $row): ?>
                    <tr>
                        <td><b><?= $row['no_apar'] ?></b></td>
                        
                        <td>
                            <?= $row['lokasi_apar'] ?>
                            <br>
                            <small class="text-muted">
                                <?php if(!empty($row['tgl_cek_terakhir'])): ?>
                                    <i class="fa fa-calendar-check-o text-success"></i> 
                                    Terakhir Cek: <span class="text-success"><b><?= date('d/m/Y H:i', strtotime($row['tgl_cek_terakhir'])) ?></b></span>
                                <?php else: ?>
                                    <i class="fa fa-warning text-danger"></i> 
                                    <span class="text-danger">Belum Pernah Dicek</span>
                                <?php endif; ?>
                            </small>
                        </td>

                        <td>
                            <a href="<?= base_url('C_apar/form_ceklist/'.$row['id_apar']) ?>" class="btn btn-sm btn-success">
                                <i class="fa fa-check-square"></i> Cek Rutin
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


<div class="modal fade" id="modalCek">
    </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Notifikasi Berhasil
        <?php if($this->session->flashdata('swal_success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('swal_success'); ?>',
                showConfirmButton: false,
                timer: 2500
            });
        <?php endif; ?>

        // Notifikasi Gagal / Error
        <?php if($this->session->flashdata('swal_error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $this->session->flashdata('swal_error'); ?>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Tutup'
            });
        <?php endif; ?>
    });
</script>