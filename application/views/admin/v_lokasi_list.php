<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<section class="content">
    <div class="row">
        <div class="col-md-12">
        <!-- general form elements -->
            <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
            <div class="form-group">
            <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12 text-center">
                <h4 align="center">
                    Daftar Ruangan / Sub Lokasi<br>
                    <?= $nama_kelompok_lokasi; ?><br>
                    <?= $nama_unit; ?>
                </h4>
            </div>
            
        </div>

        <div class="box-tools pull-right" style="margin-bottom:10px;">
            <button type="button"
                    class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalTambahLokasi">
                <i class="fa fa-plus"></i> Tambah Lokasi
            </button>

            <?php if(!empty($data_lokasi)){ ?>
                <a href="<?= site_url('C_lokasi/download_all_qr/'.$id_kelompok_lokasi) ?>"
                class="btn btn-success btn-sm"
                style="margin-left:5px;">
                    <i class="fa fa-qrcode"></i> Download Semua QR
                </a>

            <?php } else { ?>
                <button type="button"
                        class="btn btn-success btn-sm"
                        style="margin-left:5px;"
                        disabled>
                    <i class="fa fa-qrcode"></i> Download Semua QR
                </button>
            <?php } ?>

             <a href="<?= site_url('C_lokasi/kelompok_lokasi') ?>"
            class="btn btn-warning btn-sm"
            style="margin-left:5px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

<table class="table table-bordered table-striped" id="mytable">
    <thead>
        <tr>
            <th width="40px" >No</th>
            <th>Nama Lokasi</th>
            <th>PIC</th>
            <th>Kategori</th>
            <!-- <th>Kelompok Lokasi</th> -->
            <th>Action</th>
        </tr>
    </thead>
<tbody>
<?php if(!empty($data_lokasi)){ ?>

    <?php
    $start = 0;
    foreach ($data_lokasi as $data){
    ?>
        <tr>
            <td><?= ++$start ?></td>
            <td><?= $data->nama_lokasi ?></td>
            <td><?= $data->nama_user ?></td>
            <td><?= $data->nama_kategori_pekerjaan ?></td>

            <td style="text-align:center" width="350px">
                <div class="btn-group">

                    <button type="button"
                            class="btn btn-sm btn-warning btn-flat btn-edit disabled"
                            data-id="<?= $data->id_lokasi ?>"
                            data-nama="<?= $data->nama_lokasi ?>"
                            data-pic="<?= $data->pic ?>"
                            data-kategori="<?= $data->id_kategori ?>"
                            data-kelompok="<?= $data->id_kelompok_lokasi ?>"
                            data-toggle="modal"
                            data-target="#modalEditLokasi">
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    <a href="<?= site_url('C_lokasi/hapus_sublokasi/'.$data->id_lokasi) ?>"
                       class="btn btn-sm btn-danger btn-flat btn-hapus">
                        <i class="fa fa-trash"></i> Hapus
                    </a>

                    <?= anchor(
                        site_url('C_lokasi/cetak_qr/'.$data->id_unit.'/'.$data->id_lokasi),
                        '<i class="fa fa-download"></i> Download QR',
                        'class="btn btn-sm btn-success btn-flat"'
                    ); ?>

                </div>
            </td>
        </tr>
    <?php } ?>

<?php } else { ?>

    <tr>
        <td colspan="5" class="text-center">
            <b>Data lokasi belum tersedia</b>
        </td>
    </tr>

<?php } ?>
</tbody>
</table>


<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SWEET ALERT -->
<?php if($this->session->flashdata('swal_icon')){ ?>
<script>
$(document).ready(function() {

    Swal.fire({
        icon: '<?= $this->session->flashdata('swal_icon'); ?>',
        title: '<?= $this->session->flashdata('swal_title'); ?>',
        text: '<?= $this->session->flashdata('swal_text'); ?>',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false
    });

});
</script>
<?php } ?>


<script>
$(document).on('click','.btn-edit',function(){

    $('#edit_id_lokasi').val($(this).data('id'));
    $('#edit_nama_lokasi').val($(this).data('nama'));
    $('#edit_pic').val($(this).data('pic'));

});
</script>

<script>
$(document).on('click','.btn-hapus',function(e){

    e.preventDefault();

    let url = $(this).attr('href');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data lokasi akan dihapus permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result)=>{

        if(result.isConfirmed){
            window.location.href = url;
        }

    });

});
</script>

<!-- SCRIPT UNTUK MENCARI DATA PADA DROPDOWN -->
<script>
$(document).ready(function(){

    $('.select2-pic').select2({
        placeholder: '- Pilih PIC -',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#modalTambahLokasi')
    });

    $('.select2-kategori').select2({
        placeholder: '- Pilih Kategori Pekerjaan -',
        width: '100%',
        allowClear: true,
        dropdownParent: $('#modalTambahLokasi')
    });

});
</script>


<!-- MODAL UNTUK TAMBAH LOKASI -->
<div class="modal fade" id="modalTambahLokasi">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?= site_url('C_lokasi/tambah_sublokasi') ?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>

                    <h4 class="modal-title">
                        Tambah Lokasi
                    </h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_kelompok_lokasi" class="form-control" value="<?php echo $id_kelompok_lokasi; ?>" required>
                    <div class="form-group">
                        <label>Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>PIC</label>

                        <select name="pic"
                                class="form-control select2-pic"
                                required>
                            <option value=""></option>

                            <?php foreach($data_user as $u){ ?>
                                <option value="<?= $u->username ?>">
                                    <?= $u->nama_user ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>

                        <select name="id_kategori"
                                class="form-control select2-kategori"
                                required>
                            <option value=""></option>

                            <?php foreach($kategori_pekerjaan as $k){ ?>
                                <option value="<?= $k->id_kategori_pekerjaan ?>">
                                    <?= $k->nama_kategori_pekerjaan ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


<!-- MODAL UNTUK EDIT LOKASI -->
<div class="modal fade" id="modalEditLokasi">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?= site_url('C_lokasi/update') ?>" method="post">

                <input type="hidden"
                       name="id_lokasi"
                       id="edit_id_lokasi">

                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        &times;
                    </button>

                    <h4 class="modal-title">
                        Edit Lokasi
                    </h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Lokasi</label>

                        <input type="text"
                               id="edit_nama_lokasi"
                               name="nama_lokasi"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>PIC</label>

                        <select name="pic"
                                id="edit_pic"
                                class="form-control">

                            <?php foreach($data_user as $u){ ?>

                                <option value="<?= $u->username ?>">
                                    <?= $u->nama_user ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-warning">
                        Update
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


