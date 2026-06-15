<section class="content-header">
  <h1>
    Data ceklist pekerjaan
    <!-- <small><?= htmlspecialchars($nama_unit); ?></small> -->
  </h1>
</section>

<section class="content">

  <div class="box box-primary">
    <div class="box-body">
    <!-- FILTER -->
    <div class="card card-secondary card-outline mb-3">
      <div class="card-body">
        <form method="get" action="<?= site_url('C_ceklist/rekap'); ?>">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Awal</label>
                <input type="date" name="tgl_awal" class="form-control"
                       value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : ''; ?>">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" class="form-control"
                       value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : ''; ?>">
              </div>
            </div>

            <!-- <div class="col-md-4">
              <div class="form-group">
                <label>Nama TAD</label>
                <input type="text" name="nama_tad" class="form-control" placeholder="Cari nama TAD..."
                       value="<?= isset($_GET['nama_tad']) ? htmlspecialchars($_GET['nama_tad']) : ''; ?>">
              </div>
            </div> -->

            <div class="col-md-2 d-flex align-items-end">
              <br>
              <button type="submit" class="btn btn-primary btn-block">
                <i class="fa fa-search"></i> Tampilkan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- END FILTER -->


    <!-- REKAP -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h4 class="card-title">
          <i class="fas fa-clipboard-check"></i>
          Rekap Checklist Lokasi
        </h4>
      </div>

      <div class="card-body p-0">

        <table id="rekapTable" class="table table-bordered table-hover mb-0">
          <thead class="bg-primary">
          <tr>
            <th width="5%" class="text-center">No</th>
            <th>Nama Lokasi</th>
            <th>PIC / User</th>
            <th>Tanggal Ceklist</th>
            <th width="35%">Progress Checklist</th>
            <th width="15%" class="text-center">Status</th>
          </tr>
        </thead>


          <tbody>
            <?php 
              $no = 1;
              foreach ($ceklist as $row):

                $total  = (int) $row->total_seharusnya;
                $done   = (int) $row->sudah_ceklist;
                $persen = ($total > 0) ? round(($done / $total) * 100) : 0;

                if ($persen == 100) {
                  $color  = 'success';
                  $status = 'Lengkap';
                  $icon   = 'check-circle';
                } elseif ($persen > 0) {
                  $color  = 'warning';
                  $status = 'Sebagian';
                  $icon   = 'hourglass-half';
                } else {
                  $color  = 'danger';
                  $status = 'Belum';
                  $icon   = 'times-circle';
                }
            ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= htmlspecialchars($row->nama_lokasi); ?></td>
              <td><?= htmlspecialchars($row->nama_user); ?></td>
              <td><?= date('d-m-Y', strtotime($row->tgl_ceklist)); ?></td>
              <td>
                <div class="progress progress-sm mb-1">
                  <div class="progress-bar bg-<?= $color; ?>" style="width: <?= $persen; ?>%"></div>
                </div>
                <small class="text-muted">
                  <?= $done; ?> / <?= $total; ?> checklist (<?= $persen; ?>%)
                </small>
              </td>
              <td class="text-center">
                <span class="badge badge-<?= $color; ?>">
                  <i class="fas fa-<?= $icon; ?>"></i>
                  <?= $status; ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>

          </tbody>

        </table>

      </div>
    </div>
    <!-- END REKAP -->

  </div>
</section>


<script>
  $(function () {
    $.fn.dataTable.ext.errMode = 'none';

    $('#rekapTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "language": {
        "search": "Cari Data : ",
        "lengthMenu": "Tampilkan _MENU_ data",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data tersedia",
        "infoFiltered": "(difilter dari _MAX_ data)",
        "paginate": {
          "next": "Berikutnya",
          "previous": "Sebelumnya"
        }
      }
    });

    // Membuat form pencarian lebih panjang
    $('#rekapTable_filter input')
      .css('width', '400px')
      .css('display', 'inline-block');

  });
</script>


