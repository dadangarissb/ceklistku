<!doctype html>
<html>
    <head>
        <title>Daftar Kategori Pekerjaan</title>
    </head>

    <body>
        <section class="content">
            <div class="row">
            <!-- left column -->
                <div class="col-md-12">
                <!-- general form elements -->
                    <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-md-12 text-center">
                                    <h4 align="center">Daftar Kategori Pekerjaan TAD<br>PT PLN (Persero) UPDL Makassar</h4>
                                </div>
                                <div class="col-md-4 text-center">
                                </div>
                                <div class="col-md-4 text-center">
                                    <div style="margin-top: 4px"  id="message">
                                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                </div>
                                <div class="col-md-12 text-center">                            
                                </div>
                            </div>
                            <div class="box-tools pull-right">
                               
                                <a href="javascript:void(0);"
                                class="btn btn-sm btn-primary pull-right"
                                data-toggle="modal"
                                data-target="#modalinputkategori">
                                Tambahkan Kategori Pekerjaan
                                </a>
                                
                                <br>
                                <br>
                            </div>
                
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                    <th width="40px" >No</th>
                                    <th>Kategori Pekerjaan</th>
                                    <th>Total Detail Pekerjaan</th>
                                    <th>Total Freq Checklist</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $start = 0;
                                    foreach ($data_kategori_pekerjaan as $data)
                                    {
                                        ?>
                                        <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $data->nama_kategori_pekerjaan ?></td>
                                    <td class="text-center">
                                        <?php if($data->jml_detail == 0){ ?>
                                            <span class="badge bg-gray" style="color:#000;">
                                                <?= $data->jml_detail ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge bg-blue">
                                                <?= $data->jml_detail ?>
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if($data->jml_freq == 0){ ?>
                                            <span class="badge bg-gray" style="color:#000;">
                                                <?= $data->jml_freq?>
                                            </span>
                                            kali / hari
                                        <?php } else { ?>
                                            <span class="badge bg-blue">
                                                <?= $data->jml_freq ?>
                                            </span>
                                            kali / hari
                                        <?php } ?>
                                    </td>	    
                                    <td style="text-align:center" width="250px">
                                        <div class="btn-group">
                                            <?php
                                            echo anchor(
                                                site_url('C_pekerjaan/read/'.$data->id_kategori_pekerjaan),
                                                '<i class="fa fa-search"></i> Lihat Detail Pekerjaan',
                                                'class="btn btn-sm btn-primary btn-flat"'
                                            );

                                            echo anchor(
                                                site_url('C_pekerjaan/delete_kat_pek/'.$data->id_kategori_pekerjaan),
                                                '<i class="fa fa-trash"></i> Hapus',
                                                'class="btn btn-sm btn-danger btn-flat btn-hapus"'
                                            );
                                            ?>
                                        </div>
                                    </td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

    </body>
</html>

<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/app.min.js'); ?>"></script>


<div class="modal fade" id="modalinputkategori" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('C_pekerjaan/input_kat_pek'); ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
          <h4 class="modal-title">Tambahkan Kategori Pekerjaan</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_unit" value="<?= $data->id_unit; ?>">

          <div class="form-group mb-3">
          <label>Kategori Pekerjaan</label>
          <input type="text"
                id="kategori_pekerjaan"
                name="kategori_pekerjaan"
                class="form-control"
                placeholder="Kategori Pekerjaan"
                required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-primary" id="btn_simpan_kat">
            Simpan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($swal = $this->session->flashdata('swal')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: '<?= $swal['icon']; ?>',
        title: '<?= addslashes($swal['title']); ?>',
        text: '<?= addslashes($swal['text']); ?>',
        confirmButtonText: 'OK',
        timer: 2500,
        timerProgressBar: true
    });
});
</script>
<?php endif; ?>


<script>
    $(document).ready(function() {
        // Ambil data flashdata dari session CodeIgniter
        const flashSuccess = "<?= $this->session->flashdata('swal_success'); ?>";
        const flashError   = "<?= $this->session->flashdata('swal_error'); ?>";
        const flashWarning = "<?= $this->session->flashdata('swal_warning'); ?>";

        // Notifikasi Berhasil
        if (flashSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: flashSuccess,
                showConfirmButton: false,
                timer: 2000 // Otomatis tutup dalam 2 detik
            });
        }

        // Notifikasi Gagal/Error
        if (flashError) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: flashError,
                confirmButtonColor: '#d33'
            });
        }

        // Notifikasi Peringatan (Duplikat)
        if (flashWarning) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Sudah Ada',
                text: flashWarning,
                confirmButtonColor: '#f39c12'
            });
        }
    });

    // Tambahan: Cegah klik ganda pada tombol saat submit
    $('#modalinputkategori form').on('submit', function() {
        let btn = $('#btn_simpan_kat');
        btn.attr('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
    });

</script>



<!-- TOMBOL KONFIRMASI HAPUS -->
<script>
$(document).ready(function() {

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang sudah dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
            cancelButtonText: '<i class="fa fa-times"></i> Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

        });
    });

});
</script>