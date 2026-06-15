<section class="content-header">

</section>

    <div class="col-md-12">
        <div class="nav-tabs-custom">
          <div class="tab-content">
                <body>
                  <h4 align="center"> List Pekerjaan </h4>                
                </body>
            </div>
          </div>
      </div>

  <section class="content" style="font-size:11pt">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-primary">
                  <table class="table" border="0">
                    
                    <tr>
                        <td>Kategori Pekerjaan</td>
                        <td>
                            <?php echo ": ".$nama_kategori_pekerjaan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Frekuensi ceklist</td>
                        <td>
                            <?php echo ": ".$total_frekuensi." kali"; ?> 
                            <a href="javascript:void(0);"
                              class="btn btn-sm btn-primary pull-right"
                              data-toggle="modal"
                              data-target="#modalinputceklist">
                              Tambahkan Waktu Ceklist
                            </a>
                            <br><br>
                          <table class="table table-bordered table-striped" id="table-frekuensi">
                              <thead>
                                  <tr style="background-color: #f4f4f4;">
                                      <th width="5%">No</th>
                                      <th width="65%">Range Waktu Ceklist</th>
                                      <th width="30%">Durasi</th>
                                      
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                  $no = 1;
                                  if (!empty($list_frekuensi)) {
                                      foreach ($list_frekuensi as $f) { ?>
                                          <tr>
                                              <td class="text-center"><?= $no++; ?></td>
                                              <td>
                                                  <?= $f->waktu_awal_menit." - ".$f->waktu_akhir_menit; ?>
                                              </td>
                                              <td>
                                                  <i class="fa fa-clock-o"></i> <?= $f->durasi; ?>
                                              </td>
                                          </tr>
                                      <?php } 
                                  } else { ?>
                                      <tr>
                                          <td colspan="3" class="text-center text-muted">
                                              <em>Belum ada pengaturan waktu ceklist untuk kategori ini.</em>
                                          </td>
                                      </tr>
                                  <?php } ?>
                              </tbody>
                          </table>
                        </td>
                    </tr>
                    <tr>
                      <td>Detail Pekerjaan</td><td> 
                      <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                              <th width="4px" >No</th>
                              <th>Daftar Pekerjaan 
                                <a href="javascript:void(0);"
                                  class="btn btn-sm btn-primary pull-right"
                                  data-toggle="modal"
                                  data-target="#modalDetailPekerjaan">
                                Tambahkan Detail Pekerjaan
                            </a></th>
                              </tr>
                        </thead>
                        <tbody>
                          <?php
                          $start=0;
                          if (!empty($detail_pekerjaan)) {
                              foreach ($detail_pekerjaan as $detail) {
                          ?>
                                  <tr>
                                      <td><?php echo ++$start ?></td>
                                      <td><?php echo $detail->nama_detail_pekerjaan ?></td>
                                  </tr>
                          <?php
                              }
                          } else {
                          ?>
                              <tr>
                                  <td colspan="2" style="text-align:center;">
                                      Belum ada daftar pekerjaan, silahkan tambahkan terlebih dahulu
                                  </td>
                              </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>  
                      
                      
                  </table>   
      </div>
      <?php echo anchor(site_url('C_pekerjaan'), 'Kembali', 'class="btn btn-warning btn-flat"'); ?>
      </div>
        
    
<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/app.min.js'); ?>"></script>



<div class="modal fade" id="modalDetailPekerjaan" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('C_pekerjaan/input_detail_pekerjaan_action'); ?>" method="post">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
          <h4 class="modal-title">Tambah Detail Pekerjaan</h4>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id_kategori_pekerjaan" value="<?= $id_kategori_pekerjaan; ?>">

          <div class="form-group">
            <label>Nama Detail Pekerjaan</label>
            <input type="text"
                   name="nama_detail_pekerjaan"
                   class="form-control"
                   placeholder="Masukkan detail pekerjaan"
                   required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<div class="modal fade" id="modalinputceklist" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('C_pekerjaan/input_waktu_ceklist'); ?>" method="post" onsubmit="disableButton()">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
          <h4 class="modal-title">Tambahkan Waktu Ceklist</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_kategori_pekerjaan" value="<?= $id_kategori_pekerjaan; ?>">

          <div class="form-group mb-3">
          <label>Waktu Awal</label>
          <input type="text"
                id="waktu_awal"
                name="waktu_awal"
                class="form-control"
                placeholder="Pilih waktu awal"
                required>
          </div>

          <div class="form-group mb-3">
          <label>Waktu Akhir</label>
          <input type="text"
                id="waktu_akhir"
                name="waktu_akhir"
                class="form-control"
                placeholder="Pilih waktu akhir"
                required>

          <small id="warning_waktu" class="text-danger" style="display:none; margin-top: 5px;">
          *Waktu akhir tidak boleh lebih kecil atau sama dari waktu awal
          </small>
          </div>

          <div class="form-group mb-3">
          <label>Durasi</label>
          <input type="text"
                id="durasi"
                class="form-control"
                readonly
                placeholder="Durasi otomatis">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-primary" id="btn_simpan_waktu">
            Simpan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>


<script>

flatpickr("#waktu_awal", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

flatpickr("#waktu_akhir", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

function hitungDurasi() {
    let awal = document.getElementById("waktu_awal").value;
    let akhir = document.getElementById("waktu_akhir").value;

    let durasiField = document.getElementById("durasi");
    let warning = document.getElementById("warning_waktu");
    let btnSimpan = document.getElementById("btn_simpan_waktu");

    if(awal && akhir){
        if(akhir <= awal){
            warning.style.display = "block";
            durasiField.value = "";
            btnSimpan.disabled = true; // Nonaktifkan tombol
            return;
        }

        // Reset peringatan dan aktifkan tombol jika valid
        warning.style.display = "none";
        btnSimpan.disabled = false;

        let start = awal.split(":");
        let end = akhir.split(":");

        let startMinutes = parseInt(start[0]) * 60 + parseInt(start[1]);
        let endMinutes = parseInt(end[0]) * 60 + parseInt(end[1]);

        let diff = endMinutes - startMinutes;

        let jam = Math.floor(diff / 60);
        let menit = diff % 60;

        durasiField.value = jam + " Jam " + menit + " Menit";
    } else {
        // Jika salah satu form dikosongkan lagi, aktifkan kembali agar tidak terkunci
        btnSimpan.disabled = false;
        warning.style.display = "none";
    }
}


function disableButton() {
    // Cari tombol simpan berdasarkan ID
    var btn = document.getElementById('btn_simpan_waktu');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
    return true; // Biarkan form tetap terkirim
}

// Gunakan event 'input' atau 'change' untuk mendeteksi perubahan
document.getElementById("waktu_awal").addEventListener("change", hitungDurasi);
document.getElementById("waktu_akhir").addEventListener("change", hitungDurasi);

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    $('#modalinputceklist form').on('submit', function() {
        let btn = $('#btn_simpan_waktu');
        btn.attr('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
    });
</script>