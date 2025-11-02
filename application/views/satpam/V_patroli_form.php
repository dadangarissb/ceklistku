<!DOCTYPE html>
<html>
<head>
  <title>Form Patroli Satpam</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { background-color: #f4f6f9; }
    .card { margin-top: 20px; border-radius: 10px; }
    .btn { border-radius: 8px; }
  </style>
</head>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Form Patroli</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12 col-sm-12">

            <?php if ($this->session->flashdata('error')): ?>
            <script>
                Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('error'); ?>'
                });
            </script>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <script>
                Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('success'); ?>'
                }).then(() => {
                window.location.href = "<?= site_url('c_titik_patroli'); ?>";
                });
            </script>
            <?php endif; ?>

            <form action="<?= site_url('C_patroli/simpan'); ?>" method="post">
    
            <input type="hidden" name="id_jadwal" value="<?= $id_jadwal ?>">

            <div class="form-group">
                <label>Unit</label>
                <input type="text" class="form-control" value="<?= $titik->nama_unit ?? 'UPDL Makassar'; ?>" readonly>
                <input type="hidden" name="id_unit" value="<?= $titik->id_unit ?? 1; ?>">
            </div>

            <div class="form-group">
                <label>Titik Patroli</label>
                <input type="text" class="form-control" value="<?= $titik->nama_titik; ?>" readonly>
                <input type="hidden" name="id_titik" value="<?= $titik->id_titik; ?>">
            </div>

            <div class="form-group text-center">
                <label>Ambil Foto Lokasi Patroli</label><br>
                <video id="video" width="320" height="240" autoplay
                    style="display:block; margin:10px auto; border:1px solid #ccc; border-radius:6px;">
                </video>
                <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                <img id="photo" src="" style="max-width: 100%; width:320px; display:none; 
                border:1px solid #ccc; margin:10px auto; display:block; border-radius:6px;"/>

                <div class="mt-2">
                <button type="button" id="btnCapture" class="btn btn-flat btn-success btn-sm" style="padding: 5px 100px;">
                    <i class="fa fa-camera"></i> Ambil Foto Lokasi</button>
                <button type="button" id="btnRetake" class="btn btn-flat btn-warning btn-sm" style="display:none; padding: 5px 100px;">
                    <i class="fa fa-camera"></i> Ulangi</button>
                </div>
                <input type="hidden" name="foto_lokasi" id="foto_lokasi">
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="form-group">
                <label>Keterangan</label>
                <textarea id="keterangan"
                    name="keterangan"
                    class="form-control"
                    rows="3"
                    placeholder="Tulis catatan kondisi atau kejadian di titik patroli..."
                    required></textarea>
            </div>

            <div style="text-align: right;">
                <a href="<?= site_url('C_patroli/titik_patroli/'.$id_jadwal); ?>" class="btn btn-flat btn-warning w-50 me-2"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                <button type="submit" class="btn btn-flat btn-primary w-50 ms-2"><i class="fa fa-save"></i> Simpan Patroli</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
// === Ambil lokasi ===
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(pos => {
    document.getElementById('latitude').value = pos.coords.latitude;
    document.getElementById('longitude').value = pos.coords.longitude;
  }, () => Swal.fire('Gagal!', 'Tidak dapat mengambil lokasi. Pastikan GPS aktif.', 'error'));
} else {
  Swal.fire('Error', 'Browser tidak mendukung GPS', 'error');
}

// === Kamera ===
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photo = document.getElementById('photo');
const btnCapture = document.getElementById('btnCapture');
const btnRetake = document.getElementById('btnRetake');
const inputFoto = document.getElementById('foto_lokasi');

// Minta izin kamera
navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
  .then(stream => { video.srcObject = stream; })
  .catch(err => Swal.fire('Error', 'Tidak bisa mengakses kamera: ' + err, 'error'));

// Tangkap & kompres foto
btnCapture.addEventListener('click', () => {
  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  const dataURL = canvas.toDataURL('image/jpeg', 0.5); // kompres 50%
  photo.src = dataURL;
  photo.style.display = 'block';
  inputFoto.value = dataURL;
  video.style.display = 'none';
  btnCapture.style.display = 'none';
  btnRetake.style.display = 'inline-block';
});

// Ulangi ambil foto
btnRetake.addEventListener('click', () => {
  photo.style.display = 'none';
  video.style.display = 'block';
  btnRetake.style.display = 'none';
  btnCapture.style.display = 'inline-block';
  inputFoto.value = '';
});
</script>

</body>
</html>
