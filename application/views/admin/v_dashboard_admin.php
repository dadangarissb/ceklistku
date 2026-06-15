<section class="content">
  <div class="box box-primary">
    <div class="box-body">
     
          <h3> Dashboard</h3>
          <hr>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="bg-navy" style="color: white;">
            <tr>
              <th class="text-center" width="50">No.</th>
              <th style="vertical-align: middle;">Nama Kelompok Lokasi (Wisma)</th>
              <th class="text-center" width="180">Kondisi Baik</th>
              <th class="text-center" width="180">Kondisi Rusak</th>
              <th style="vertical-align: middle;">Detail Kerusakan</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1; 
            foreach($rekap as $row): 
            ?>
            <tr>
              <td class="text-center" style="vertical-align: middle;"><?= $no++; ?></td>
              <td style="vertical-align: middle;">
                <p><?= $row['nama_kelompok_lokasi']; ?></p>
              </td>
              
              <td class="text-center" style="vertical-align: middle;">
                <span class="badge badge-success" style="padding: 8px 15px; background-color: #28a745 !important;">
                <?= $row['jumlah_baik']; ?> kamar
                </span>
              </td>
              
              <td class="text-center" style="vertical-align: middle;">
                <?php if($row['jumlah_rusak'] > 0): ?>
                  <span class="badge badge-danger" style="padding: 8px 15px; background-color: #dc3545 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <?= $row['jumlah_rusak']; ?> kamar
                  </span>
                <?php else: ?>
                  <span class="badge badge-secondary" style="padding: 8px 15px; opacity: 0.6;">
                    0 kamar
                  </span>
                <?php endif; ?>
              </td>
              
              <td style="vertical-align: middle;">
                <?php if(!empty($row['detail_kerusakan'])): ?>
                  <span class="text-danger" style="font-weight: 500;">
                    <i class="fa fa-info-circle"></i> <?= $row['detail_kerusakan']; ?>
                  </span>
                <?php else: ?>
                  <small class="text-muted" style="font-style: italic;">- Tidak ada kerusakan -</small>
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

<style>
  /* Mengatasi masalah tampilan kecil di layar lebar */
  .table {
    width: 100% !important;
    margin-bottom: 0;
  }
  .table thead th {
    background-color: #3c8dbc; /* Warna biru khas AdminLTE */
    color: #fff;
    border-bottom: 3px solid #ddd;
  }
  .table tbody tr:hover {
    background-color: #f9f9f9 !important;
    transition: 0.2s;
  }
  .badge {
    border-radius: 4px; /* Membuat badge lebih tegas (style AdminLTE) */
  }
</style>