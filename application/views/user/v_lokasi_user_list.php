<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Tugas: <strong><?= $this->session->userdata('nama_user'); ?></strong></h3>
    </div>

    <div class="box-body p-0">
        <div class="card-header">
            <div class="d-flex align-items-center">

                <div class="ml-auto">
                    <a href="<?= site_url('C_user/scan_ceklist'); ?>" 
                      class="btn btn-primary btn-sm">
                      <i class="fa fa-eye"></i> Scan QR Code
                    </a>
                </div>
            </div>
        </div>
        <br>

    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-navy">
                    <th width="5%">No</th>
                    <th>Nama Lokasi</th>
                    <!-- <th class="text-center">Target Frekuensi</th> -->
                    <th class="text-center">Realisasi Hari Ini</th>
                    <!-- <th>Status</th> -->
                    <!-- <th width="15%">Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($lokasi_tugas as $lt): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <strong><?= $lt->nama_lokasi; ?></strong><br>
                        <small class="text-muted"><?= $lt->nama_kategori_pekerjaan; ?></small>
                    </td>
                    <!-- <td class="text-center"><?= $lt->target_cek; ?> Kali</td> -->
                    <td class="text-center">
                        <span class="badge <?= ($lt->realisasi_hari_ini >= $lt->target_cek) ? 'bg-green' : 'bg-red'; ?>">
                            <?= $lt->realisasi_hari_ini; ?> / <?= $lt->target_cek; ?>
                        </span>
                    </td>
                    <!-- <td>
                        <?php if($lt->realisasi_hari_ini >= $lt->target_cek): ?>
                            <span class="label label-success"><i class="fa fa-check"></i> Selesai</span>
                        <?php else: ?>
                            <span class="label label-warning"><i class="fa fa-refresh fa-spin"></i> Progres</span>
                        <?php endif; ?>
                    </td> -->
                    <!-- <td>
                        <?php if($lt->realisasi_hari_ini < $lt->target_cek): ?>
                            <a href="<?= site_url('C_pekerjaan/input_harian/'.$lt->id_lokasi); ?>" class="btn btn-primary btn-sm btn-block">
                                <i class="fa fa-pencil"></i> Input Ceklist
                            </a>
                        <?php else: ?>
                            <button class="btn btn-default btn-sm btn-block" disabled>Sudah Lengkap</button>
                        <?php endif; ?>
                    </td> -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>