<section class="content-header">
</section>

<div class="col-md-12">
  <div class="nav-tabs-custom">
    <div class="tab-content">
      <body>
        <h4 align="center">
          Detail Data Visitor <br>
          PT PLN (Persero) UPDL Makassar
        </h4>                
      </body>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content" style="font-size:11pt">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-success">
        <table class="table" border="0">
          <tr><td></td><td>Nama</td><td width="80%"><?php echo ": ".$nama_visitor; ?></td></tr>
          <tr><td></td><td>Instansi </td><td><?php echo ": ".$instansi; ?></td></tr>
          <tr><td></td><td>Keperluan</td><td><?php echo ": ".$keperluan; ?></td></tr>
          <tr><td></td><td>Bertemu</td><td><?php echo ": ".$bertemu_dengan; ?></td></tr>
          <tr><td></td><td>Tgl Masuk</td><td><?php echo ": ".$tgl_masuk; ?></td></tr>
          <tr><td></td><td>Tgl Keluar</td><td><?php echo ": ".($tgl_keluar ? $tgl_keluar : '-'); ?></td></tr>
          <tr><td></td><td>No Kartu</td><td><?php echo ": ".$no_kartu_akses; ?></td></tr>
          <tr><td></td><td>Satpam Penerima</td><td><?php echo ": ".$id_satpam_masuk; ?></td></tr>
          <tr><td></td><td>Satpam Pelepas</td><td><?php echo ": ".($id_satpam_keluar ? $id_satpam_keluar : '-'); ?></td></tr>
          <tr>
            <td></td>
            <td>Status Visitor</td>
            <td>
              <?php if (empty($tgl_keluar)): ?>
                  <span class="label label-warning" style="font-size: 11pt; padding: 5px 10px;">Masuk</span>
              <?php else: ?>
                  <span class="label label-primary" style="font-size: 11pt; padding: 5px 10px;">Keluar</span>
              <?php endif; ?>
            </td>
          </tr>
          <tr><td></td><td>Foto Visitor</td>
            <td>
              <?php if (!empty($foto) && file_exists(FCPATH.'uploads/visitor/'.$foto)) : ?>
                <img src="<?= base_url('uploads/visitor/'.$foto); ?>" 
                     alt="Foto Visitor" 
                     width="200" 
                     class="img-thumbnail" 
                     style="border:1px solid #ccc; margin-top:5px;">
              <?php else: ?>
                <img src="<?= base_url('assets/img/no-photo.png'); ?>" 
                     alt="Tidak ada foto" 
                     width="200" 
                     class="img-thumbnail" 
                     style="border:1px solid #ccc; margin-top:5px;">
              <?php endif; ?>
            </td>
          </tr>
        </table>
      </div>

      <div class="text-center mb-3">
        <?php echo anchor(site_url('c_visitor'), 'Kembali', 'class="btn btn-warning btn-flat"'); ?>
        <?php echo anchor(site_url('c_visitor/cetak_pdf/'.$id_visitor), 'Download PDF', 'class="btn btn-success btn-flat"'); ?>
      </div>
    </div>
  </div>
</section>
