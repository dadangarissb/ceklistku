<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Pekerja | PT PLN (Persero) UPDL Makassar</title>
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
    .btn-group-top {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 15px;
    }
    @media (max-width: 767px) {
      .btn-group-top { justify-content: center; }
    }

    /* Search box styling */
    .dataTables_filter {
      text-align: left !important;
    }
    .dataTables_filter label {
      font-weight: bold;
    }
    .dataTables_filter input {
      border-radius: 10px;
      padding: 5px 10px;
      border: 1px solid #ccc;
      margin-left: 8px;
    }

    /* Tabel Responsive */
    table.dataTable thead th {
      background-color: #009879;
      color: #fff;
      text-align: center;
    }
    .badge {
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 6px;
    }
  </style>
</head>

<body>
  <div class="page-header">
    <h4>Daftar Pekerja</h4>
    <p>PT PLN (Persero) UPDL Makassar</p>
  </div>

  <!-- Tombol Aksi -->
  <div class="btn-group-top">
    <a href="<?= site_url('C_dashboard_satpam'); ?>" class="btn btn-default">
      <i class="fa fa-home"></i> Dashboard
    </a>
    <a href="<?= site_url('C_pekerja/input_pekerja'); ?>" class="btn btn-success">
      <i class="fa fa-user-plus"></i> Tambah Pekerja
    </a>
  </div>

  <!-- 💻📱 TABEL RESPONSIVE (SAMA UNTUK DESKTOP & MOBILE) -->
  <div class="table-responsive">
    <table id="pekerjaTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th width="50">No</th>
          <th>Nama</th>
          <th>Perusahaan</th>
          <!-- <th>Pekerjaan</th>
          <th>Tanggal Masuk</th>
          <th>Tanggal Keluar</th> -->
          <!-- <th>Status</th> -->
          <th width="100" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data_pekerja)): ?>
          <?php $no = 1; foreach ($data_pekerja as $data): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <?= htmlspecialchars($data->nama_pekerja) ?><br>
                <?php if ($data->status == 'masuk'): ?>
                <span class="label label-warning">Masuk</span>
                <?php elseif ($data->status == 'keluar'): ?>
                <span class="label label-success">Keluar</span>
                <?php else: ?>
                <span class="label label-default">Tidak Diketahui</span>
                <?php endif; ?>
                <!-- <?php if (!empty($data->foto)): ?>
                  <img src="<?= base_url('uploads/pekerja/'.$data->foto); ?>" 
                       alt="Foto" width="40" height="40" 
                       class="rounded-circle mt-1">
                <?php endif; ?> -->
              </td>
              <td><?= htmlspecialchars($data->perusahaan) ?></td>
              <!-- <td><?= htmlspecialchars($data->nama_pekerjaan) ?></td>
              <td><?= htmlspecialchars($data->tgl_masuk) ?></td>
              <td><?= htmlspecialchars($data->tgl_keluar ?: '-') ?></td> -->
              
              <td class="text-center">
                <a href="<?= site_url('C_pekerja/read/'.$data->id_pekerja); ?>" class="btn btn-info btn-sm">
                  <i class="fa fa-eye"></i> Detail
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="8" class="text-center">Belum ada data pekerja.</td></tr>
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
      $('#pekerjaTable').DataTable({
        responsive: true,
        language: {
          search: "🔍 Cari Data Pekerja:",
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          zeroRecords: "Data tidak ditemukan",
          paginate: { next: "Selanjutnya", previous: "Sebelumnya" }
        },
        dom: '<"top"f>rt<"bottom"lip><"clear">'
      });
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: '<?php echo $this->session->flashdata('success'); ?>',
  showConfirmButton: false,
  timer: 2000
});
</script>
<?php elseif($this->session->flashdata('error')): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Gagal!',
  text: '<?php echo $this->session->flashdata('error'); ?>',
  showConfirmButton: true
});
</script>
<?php endif; ?>
  
</body>
</html>
