<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mutasi Jaga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE & Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/skins/_all-skins.min.css'); ?>">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/datatables/dataTables.bootstrap.css'); ?>">

    <style>
        @media (max-width: 768px) {
            table thead { display: none; }
            table tbody tr {
                display: block;
                margin-bottom: 15px;
                background: #f9f9f9;
                border-radius: 10px;
                padding: 10px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            table tbody td {
                display: block;
                text-align: left !important;
                font-size: 14px;
                border: none !important;
                padding: 6px 10px;
            }
            .btn-group {
                display: flex;
                justify-content: flex-end;
            }
        }

        @media (min-width: 769px) {
            .mobile-only { display: none; }
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .top-buttons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .btn-flat {
            border-radius: 6px !important;
            font-size: 14px;
        }

        h4 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content-wrapper {
            padding: 20px;
        }
    </style>
</head>

<body class="hold-transition skin-green sidebar-mini">
<div class="content-wrapper">
    <section class="content-header">
        <h4 class="text-center">Daftar Mutasi Jaga Satuan Pengamanan<br>PT PLN (Persero) UPDL Makassar</h4>
    </section>

    <section class="content">
        <div class="box box-success">
            <div class="box-body">

                <!-- Tombol Atas -->
                <div class="top-buttons">
                    <?= anchor(site_url('dashboard'), '⬅ Kembali ke Dashboard', 'class="btn btn-default btn-flat"'); ?>
                    <?= anchor(site_url('C_mutasi_jaga/input_mutasi_jaga'), '➕ Input Mutasi Jaga', 'class="btn btn-primary btn-flat"'); ?>
                </div>

                <!-- Pesan -->
                <div id="message" class="text-center mb-3">
                    <?= $this->session->userdata('message') ?: ''; ?>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="40px">No</th>
                                <th>Tanggal Jaga</th>
                                <th>Shift</th>
                                <th>Petugas Serah</th>
                                <th>Petugas Terima</th>
                                <th width="120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $start = 0; foreach ($data_mutasi as $data): ?>
                                <tr>
                                    <td><?= ++$start ?></td>

                                    <!-- Mode desktop -->
                                    <td><?= $data->tanggal_jaga ?></td>
                                    <td><?= $data->shift ?></td>
                                    <td><?= $data->petugas_serah ?></td>
                                    <td><?= $data->petugas_terima ?></td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?= anchor('c_mutasi_jaga/read/'.$data->id_mutasi_jaga, 'Detail', 'class="btn btn-sm btn-info btn-flat"'); ?>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Mode HP (dalam blok 1 kolom) -->
                                <tr class="mobile-only">
                                    <td>
                                        <strong>#<?= $start; ?></strong><br>
                                        <b>Tanggal:</b> <?= $data->tanggal_jaga ?><br>
                                        <b>Shift:</b> <?= $data->shift ?><br>
                                        <b>Serah:</b> <?= $data->petugas_serah ?><br>
                                        <b>Terima:</b> <?= $data->petugas_terima ?><br>
                                        <div class="text-right mt-2">
                                            <?= anchor('c_mutasi_jaga/read/'.$data->id_mutasi_jaga, 'Detail', 'class="btn btn-xs btn-info btn-flat"'); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>
</div>

<!-- Scripts -->
<script src="<?= base_url('assets/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/dataTables.bootstrap.min.js'); ?>"></script>

<script>
$(function () {
    $('#mytable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(difilter dari total _MAX_ data)"
        }
    });
});
</script>

</body>
</html>
