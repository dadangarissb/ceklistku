<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-dashboard"></i> Monitoring Keluhan Fasilitas</b></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead class="bg-navy" style="color:white">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Detail Keluhan</th>
                            <th class="text-center">Tgl Lapor</th>
                            <th class="text-center">Status</th>
                            <th>PIC Petugas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($all_keluhan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <b><?= $row['nama_keluhan'] ?></b><br>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> <?= $row['lokasi_keluhan'] ?></small>
                            </td>
                            <td class="text-center"><?= date('d M Y H:i', strtotime($row['tgl_laporan'])) ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 'Pending'): ?>
                                    <span class="badge" style="background-color: #dd4b39 !important; padding: 5px 10px;">🔴 Pending</span>
                                <?php else: ?>
                                    <span class="badge" style="background-color: #00a65a !important; padding: 5px 10px;">✅ Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['pic'] ? "<b>".$row['pic']."</b>" : "<i class='text-muted'>Belum ada PIC</i>" ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 'Pending'): ?>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTindakLanjut<?= $row['id_keluhan'] ?>">
                                        <i class="fa fa-edit"></i> Tindak Lanjut
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-default btn-sm" disabled><i class="fa fa-check"></i> Sudah Diatasi</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>