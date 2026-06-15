
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
                    <h4 align="center">Daftar Kelompok Lokasi Pekerjaan TAD<br>PT PLN (Persero) UPDL Makassar</h4>
            </div>
           <div class="col-md-12">
                <br>
                <div class="pull-right">
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#modalKelompokLokasi">
                        <i class="fa fa-plus"></i> Tambah Kelompok Lokasi
                    </button>
                </div>

            </div>
        </div>
<table class="table table-bordered table-striped" id="mytable">
    <thead>
        <tr>
            <th width="40px" >No</th>
            <th>Nama Kelompok Lokasi</th>
            <th>Jml Sublokasi / Kamar</th>
            <th>Action</th>
        </tr>
    </thead>
<tbody>
    <?php
    $start = 0;
    foreach ($data_kelompok_lokasi as $data)
    {
        ?>
        <tr>
            <td><?php echo ++$start ?></td>
            <td><?php echo $data->nama_kelompok_lokasi ?></td>	
            <td class="text-center">
                <?php if($data->jumlah_sub_lokasi > 0){ ?>
                    <span class="badge bg-blue">
                        <?= $data->jumlah_sub_lokasi ?>
                    </span> 
                <?php } else { ?>
                    <span class="badge bg-gray">
                        <?= $data->jumlah_sub_lokasi ?>
                    </span>
                <?php } ?>
            </td>
            <td class="text-center" width="250">
                <div class="btn-group">

                    <?= anchor(
                        site_url('C_lokasi/list_sub_lokasi/'.$data->id_kelompok_lokasi),
                        '<i class="fa fa-search"></i> Lihat Sub Lokasi',
                        'class="btn btn-sm btn-primary btn-flat"'
                    ); ?>

                    <?= anchor(
                        site_url('C_lokasi/delete_kelompok_lokasi/'.$data->id_kelompok_lokasi),
                        '<i class="fa fa-trash"></i> Hapus',
                        'class="btn btn-sm btn-danger btn-flat btn-hapus"'
                    ); ?>

                </div>

            </td>
                </div>
            </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('#modalKelompokLokasi').on('shown.bs.modal', function () {
    $('input[name="nama_kelompok_lokasi"]').focus();
});
</script>

<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: '<?= $this->session->flashdata('success'); ?>',
    showConfirmButton: false,
    timer: 2000,
    toast: true
});
</script>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '<?= $this->session->flashdata('success'); ?>',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});
</script>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '<?= $this->session->flashdata('error'); ?>',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});
</script>
<?php endif; ?>


<script>
$(document).on('click', '.btn-hapus', function(e){
    e.preventDefault();

    var url = $(this).attr('href');

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data kelompok lokasi yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
});
</script>


<!-- Modal Tambah Kelompok Lokasi -->
<div class="modal fade" id="modalKelompokLokasi" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?= site_url('C_lokasi/simpan_kelompok_lokasi') ?>" method="post">

                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus-circle"></i>
                        Tambah Kelompok Lokasi
                    </h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Kelompok Lokasi</label>
                        <input type="text"
                               name="nama_kelompok_lokasi"
                               class="form-control"
                               placeholder="Masukkan nama kelompok lokasi"
                               required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>