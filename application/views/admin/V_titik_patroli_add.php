
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Titik Patroli</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <style>
    body { padding: 16px; }
    video, canvas, img { max-width:100%; border:1px solid #ddd; border-radius:6px; }
    .small { font-size:0.9rem; color:#666; }
  </style>
</head>
<body>
  <div class="container">
    <h4>Tambah Titik Patroli (ambil lokasi & foto)</h4>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <form id="formTitik" method="post" action="<?= site_url('C_titik_patroli/save') ?>">
      <div class="mb-3">
        <label class="form-label">Unit</label>
        <select name="id_unit" class="form-control" required>
          <option value="">-- Pilih Unit --</option>
          <?php foreach($units as $u): ?>
            <option value="<?= $u->id_unit ?>"><?= htmlspecialchars($u->nama_unit) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Titik</label>
        <input type="text" name="nama_titik" class="form-control" required placeholder="Contoh: Parkiran Driver">
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Latitude</label>
          <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Longitude</label>
          <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
        </div>
      </div>

      <div class="mb-3">
        <button type="button" id="btnGetLoc" class="btn btn-outline-primary">Ambil Lokasi Sekarang</button>
        <span id="locStatus" class="small ms-2">Status: menunggu lokasi...</span>
      </div>

      <div class="mb-3">
        <label class="form-label">Radius (meter)</label>
        <input type="number" name="radius" class="form-control" value="10" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi (opsional)</label>
        <textarea name="deskripsi" class="form-control" rows="2"></textarea>
      </div>

      <hr>

      <!-- Kamera & Foto -->
      <div class="mb-3 text-center">
        <label class="form-label">Ambil Foto Lokasi</label>
        <div class="mb-2">
          <video id="video" width="320" height="240" autoplay playsinline muted style="background:#000"></video>
          <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
          <img id="preview" src="" alt="Preview foto" style="display:none; margin-top:10px;"/>
        </div>

        <div>
          <button type="button" id="btnCapture" class="btn btn-success btn-sm">Ambil Foto</button>
          <button type="button" id="btnRetake" class="btn btn-warning btn-sm" style="display:none;">Ulangi</button>
        </div>

        <div class="small mt-2">Foto akan dikompres di browser sebelum dikirim.</div>
        <input type="hidden" name="foto_location" id="foto_location">
      </div>

      <div>
        <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan Titik Patroli</button>
        <a href="<?= base_url() ?>" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>

<script>
(function(){
  // Elemen
  const btnGetLoc = document.getElementById('btnGetLoc');
  const locStatus = document.getElementById('locStatus');
  const latInput = document.getElementById('latitude');
  const lonInput = document.getElementById('longitude');

  // Kamera elemen
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const preview = document.getElementById('preview');
  const btnCapture = document.getElementById('btnCapture');
  const btnRetake = document.getElementById('btnRetake');
  const fotoInput = document.getElementById('foto_location');
  const btnSubmit = document.getElementById('btnSubmit');

  // Mulai kamera (kamera belakang di HP jika tersedia)
  async function startCamera() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" }, audio: false });
      video.srcObject = stream;
    } catch (err) {
      alert('Tidak dapat mengakses kamera: ' + err.message);
    }
  }

  startCamera();

  // Ambil lokasi sekarang
  btnGetLoc.addEventListener('click', function(){
    locStatus.textContent = 'Meminta lokasi...';
    if (!navigator.geolocation) {
      locStatus.textContent = 'Geolocation tidak didukung.';
      return;
    }

    navigator.geolocation.getCurrentPosition(function(pos){
      latInput.value = pos.coords.latitude.toFixed(8);
      lonInput.value = pos.coords.longitude.toFixed(8);
      locStatus.textContent = 'Lokasi berhasil diambil.';
    }, function(err){
      switch(err.code) {
        case err.PERMISSION_DENIED:
          locStatus.textContent = 'Izin lokasi ditolak.';
          break;
        case err.POSITION_UNAVAILABLE:
          locStatus.textContent = 'Posisi tidak tersedia.';
          break;
        case err.TIMEOUT:
          locStatus.textContent = 'Permintaan lokasi kedaluwarsa.';
          break;
        default:
          locStatus.textContent = 'Terjadi kesalahan saat mengambil lokasi.';
      }
    }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
  });

  // Ambil foto & kompres di sisi client
  btnCapture.addEventListener('click', function(){
    const ctx = canvas.getContext('2d');

    // skala: gunakan ukuran canvas 640x480 (foto lebih detail)
    canvas.width = 640;
    canvas.height = 480;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // toBlob dengan kualitas 0.6 (60%)
    canvas.toBlob(function(blob){
      const reader = new FileReader();
      reader.onloadend = function() {
        const base64data = reader.result; // data:image/jpeg;base64,...
        fotoInput.value = base64data;
        preview.src = base64data;
        preview.style.display = 'block';
        // tampilkan tombol retake
        btnRetake.style.display = 'inline-block';
        btnCapture.style.display = 'none';
      };
      reader.readAsDataURL(blob);
    }, 'image/jpeg', 0.6);
  });

  // Ulangi foto
  btnRetake.addEventListener('click', function(){
    fotoInput.value = '';
    preview.src = '';
    preview.style.display = 'none';
    btnRetake.style.display = 'none';
    btnCapture.style.display = 'inline-block';
  });

  // Optional: blok submit jika foto belum diambil atau lokasi kosong
  document.getElementById('formTitik').addEventListener('submit', function(e){
    if (!latInput.value || !lonInput.value) {
      e.preventDefault();
      alert('Ambil lokasi terlebih dahulu (klik "Ambil Lokasi Sekarang").');
      return;
    }
    if (!fotoInput.value) {
      e.preventDefault();
      alert('Ambil foto lokasi terlebih dahulu.');
      return;
    }
    // else biarkan submit; foto_base64 dikirim di foto_location
  });

})();
</script>
</body>
</html>
