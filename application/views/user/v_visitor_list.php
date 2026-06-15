<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Tamu | PT PLN (Persero) UPDL Makassar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <style>
    body {
      background-color: #f4f6f9;
      font-size: 14px;
    }

    .page-header {
      text-align: center;
      margin: 20px 0 30px 0;
    }

    .page-header h4 {
      margin-bottom: 5px;
      font-weight: bold;
    }

    /* Tombol dashboard dan tambah tamu */
    .btn-group-top {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 15px;
    }

    @media (max-width: 767px) {
      .btn-group-top {
        justify-content: center;
      }
    }

    /* ====== Tampilan Mobile: Kartu ====== */
    .table-mobile {
      display: none;
    }

    @media (max-width: 767px) {
      .table-desktop {
        display: none;
      }
      

      .table-mobile {
        display: block;
      }

      .table-mobile table {
        width: 100%;
        background-color: #fff;
        border-collapse: separate;
        border-spacing: 0 10px;
      }

      .table-mobile tbody tr {
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 10px;
      }

      .table-mobile td {
        border: none !important;
        padding: 12px 15px !important;
        vertical-align: middle !important;
      }

      .table-mobile .btn-detail {
        font-size: 13px;
        padding: 6px 14px;
        border-radius: 20px;
        white-space: nowrap;
      }

      .table-mobile .d-flex {
        display: flex !important;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: nowrap;
        gap: 8px;
      }

      body {
        font-size: 15.5px;
      }
      .table-mobile td {
        font-size: 16px !important;
      }
      .table-mobile .btn-detail {
        font-size: 14px;
        padding: 7px 15px;
      }
    }

    /* ====== Tampilan Desktop ====== */
    @media (min-width: 768px) {
      .table-desktop table {
        background-color: #fff;
        width: 100%;
      }

      .table-desktop th {
        background-color: #009879;
        color: #fff;
        text-align: center;
      }
    }
  </style>
</head>

<body>

    <div class="page-header">
      <h4>Daftar Tamu</h4>
      <p>PT PLN (Persero) UPDL Makassar</p>
    </div>

    <!-- Tombol Aksi -->
    <div class="btn-group-top">
      <a href="<?= site_url('C_dashboard_satpam'); ?>" class="btn btn-default">
        <i class="fa fa-home"></i> Dashboard
      </a>
      <a href="<?= site_url('c_visitor/input_visitor'); ?>" class="btn btn-success">
        <i class="fa fa-user-plus"></i> Tambah Tamu
      </a>
    </div>

    <!-- 💻 TABEL DESKTOP (DataTables) -->
    <div class="table-responsive table-desktop">
      <table id="visitorTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="50">No</th>
            <th>Nama</th>
            <th>Instansi</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Keluar</th>
            <th>Status</th>
            <th width="100" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($data_visitor)): ?>
            <?php $no = 1; foreach ($data_visitor as $data): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data->nama_visitor) ?></td>
                <td><?= htmlspecialchars($data->instansi) ?></td>
                <td><?= htmlspecialchars($data->tgl_masuk) ?></td>
                <td><?= htmlspecialchars($data->tgl_keluar) ?></td>
                <td>
                  <?php if ($data->status == 'masuk'): ?>
                    <span class="badge bg-success">Masuk</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Keluar</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="<?= site_url('c_visitor/read/'.$data->id_visitor); ?>" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i> Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center">Belum ada data tamu.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- 📱 TABEL MOBILE -->
    <div class="table-responsive table-mobile">
      <table class="table">
        <thead>
          <tr>
            <th width="40" class="text-center">No</th>
            <th>Data Tamu</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($data_visitor)): ?>
            <?php $no = 1; foreach ($data_visitor as $data): ?>
              <tr>
                <td class="text-center align-top"><?= $no++ ?></td>
                <td>
                  <div class="d-flex">
                    <div>
                      <b>Nama:</b> <?= htmlspecialchars($data->nama_visitor) ?><br>
                      <b>Instansi:</b> <?= htmlspecialchars($data->instansi) ?><br>
                      <b>Status:</b>
                      <?php if ($data->status == 'masuk'): ?>
                        <span class="badge bg-success">Masuk</span>
                      <?php else: ?>
                        <span class="badge bg-secondary">Keluar</span>
                      <?php endif; ?>
                    </div>
                    <div>
                      <a href="<?= site_url('c_visitor/read/'.$data->id_visitor); ?>" class="btn btn-info btn-sm btn-detail">
                        <i class="fa fa-eye"></i> Detail
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2" class="text-center">Belum ada data tamu.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  <!-- jQuery & Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#visitorTable').DataTable({
        responsive: true,
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          paginate: { next: "Selanjutnya", previous: "Sebelumnya" }
        }
      });
    });
  </script>
</body>
</html>
