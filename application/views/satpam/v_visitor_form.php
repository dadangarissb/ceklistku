<!doctype html>
<html>
    <head>
        <title>Tambah Data Visitor</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
        /* Agar tampilan fleksibel di HP */
        .camera-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* rata kiri */
        }

        .camera-preview video,
        .camera-preview img {
            width: 100%;
            max-width: 320px;
            height: auto;
        }

        @media (max-width: 576px) {
            .camera-preview video,
            .camera-preview img {
                max-width: 100%;
            }
            .button-group {
                display: flex;
                flex-direction: row;
                gap: 10px;
            }
        }
        </style>
    </head>
    <body>
    <section class="content">

      <div class="row">
        <div class="col-md-2">
        </div> 
        <div class="col-md-8">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

        <h3 style="margin-top:0px" align="center">Form Visitor</h3>
        <form action="<?php echo site_url('c_visitor/input_visitor_action'); ?>" method="post">
     
    <div class="form-group">
        <label for="petugas_serah">Nama Visitor</label>
        <input type="text" class="form-control" name="nama_visitor" id="nama_visitor"
        value="<?= set_value('nama_visitor'); ?>" required>
    </div>

     <div class="form-group mb-3">
        <label for="instansi">Instansi / Perusahaan</label>
        <input type="text" class="form-control" name="instansi" id="instansi" 
                value="<?= set_value('instansi'); ?>" required>
    </div>

    <div class="form-group">
        <label for="keperluan">Keperluan</label>
        <textarea class="form-control" 
                name="keperluan" 
                id="keperluan" 
                rows="3" 
                placeholder="Tuliskan keperluan di sini..." 
                required></textarea>
        <div class="invalid-feedback">
           Keperluan visitor wajib diisi.
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="bertemu_dengan">Bertemu Dengan</label>
        <input type="text" class="form-control" name="bertemu_dengan" id="bertemu_dengan"
                value="<?= set_value('bertemu_dengan'); ?>" required>
    </div>

    <div class="form-group mb-3">
        <label for="tgl_masuk">Tanggal & Waktu Masuk</label>
        <input type="datetime-local" class="form-control" name="tgl_masuk" id="tgl_masuk" 
                value="<?= set_value('tgl_masuk'); ?>" required>
    </div>

    <!-- <div class="form-group mb-3">
        <label for="tgl_keluar">Tanggal & Waktu Keluar</label>
        <input type="datetime-local" class="form-control" name="tgl_keluar" id="tgl_keluar" 
                value="<?= set_value('tgl_keluar'); ?>">
    </div> -->

    <div class="form-group mb-3">
        <label for="no_kartu_akses">Nomor Kartu Akses</label>
        <input type="text" class="form-control" name="no_kartu_akses" id="no_kartu_akses"
                value="<?= set_value('no_kartu_akses'); ?>" required>
    </div>

    <div class="form-group mb-3">
    <label for="foto_visitor" class="form-label d-block">Ambil Foto Visitor</label>

    <div class="camera-wrapper">
        <div class="camera-preview mb-2">
            <!-- <video id="video" class="border rounded w-100" style="max-width: 320px; height: auto;" autoplay></video> -->
            <video id="video" width="320" height="240" autoplay playsinline muted></video>
            <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
            <img id="photo" src="" alt="Hasil Foto" 
                class="border rounded mt-2" 
                style="max-width: 320px; width:100%; display:none;"/>
        </div>

        <div class="button-group mb-2">
            <button type="button" class="btn btn-success btn-sm" id="btnCapture">📸 Ambil Foto</button>
            <button type="button" class="btn btn-warning btn-sm" id="btnRetake" style="display:none;">🔄 Ulangi</button>
        </div>
    </div>

    <!-- Hidden input untuk simpan hasil base64 -->
    <input type="hidden" name="foto_visitor" id="foto_visitor">
    </div>

    <!-- ID Satpam otomatis diambil dari session -->
    <input type="hidden" name="id_satpam_masuk" value="<?= $this->session->userdata('id_satpam'); ?>">


    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </body>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.priceformat.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const btnCapture = document.getElementById('btnCapture');
    const btnRetake = document.getElementById('btnRetake');
    const inputFoto = document.getElementById('foto_visitor');

    // Fungsi untuk mengaktifkan kamera
    async function startCamera() {
        try {
            // Minta izin kamera (gunakan kamera depan di HP jika tersedia)
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "user" }, 
                audio: false 
            });
            video.srcObject = stream;
        } catch (err) {
            alert("❌ Tidak dapat mengakses kamera:\n" + err.message + 
                  "\nPastikan:\n1. Anda menggunakan HTTPS.\n2. Izin kamera diaktifkan di browser.");
        }
    }

    // Jalankan saat halaman siap
    startCamera();

    // Tombol ambil foto
    btnCapture.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // 💡 Kompres ke 0.6 kualitas (60%) agar hemat data
        const dataURL = canvas.toDataURL('image/jpeg', 0.6);

        // Tampilkan hasil foto
        photo.src = dataURL;
        photo.style.display = 'block';

        // Simpan hasil base64 ke input hidden
        inputFoto.value = dataURL;

        // Ubah tampilan tombol
        video.style.display = 'none';
        btnCapture.style.display = 'none';
        btnRetake.style.display = 'inline-block';
    });

    // Tombol ulangi foto
    btnRetake.addEventListener('click', () => {
        photo.style.display = 'none';
        video.style.display = 'block';
        btnRetake.style.display = 'none';
        btnCapture.style.display = 'inline-block';
        inputFoto.value = '';
    });
});
</script>


</html>


