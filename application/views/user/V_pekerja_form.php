<!doctype html>
<html>
<head>
    <title>Tambah Data Pekerja</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
    <style>
    .camera-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .camera-preview video,
    .camera-preview img {
        width: 100%;
        max-width: 320px;
        height: auto;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
        position: sticky;
        bottom: 20px;
        right: 20px;
        z-index: 100;
    }

    .btn-warning {
        background-color: #f39c12;
        border-color: #e08e0b;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        width: 100%;
    }
    </style>
</head>
<body>

<div class="row">
    <div class="col-md-2"></div> 
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <h3 style="margin-top:0px" align="center">Form Pekerja Masuk</h3>

                <form action="<?php echo site_url('c_pekerja/input_pekerja_action'); ?>" method="post">

                    <!-- id_pekerja -->
                    <input type="hidden" name="id_pekerja">

                    <!-- id_pekerjaan dropdown -->
                    <div class="form-group">
                        <label for="id_pekerjaan">Perusahaan</label>
                        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            <?php foreach($pekerjaan as $row): ?>
                                <option value="<?= $row->id_pekerjaan; ?>"><?= $row->perusahaan." - ".$row->nama_pekerjaan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- nama_pekerja -->
                    <div class="form-group">
                        <label for="nama_pekerja">Nama Pekerja</label>
                        <input type="text" class="form-control" name="nama_pekerja" id="nama_pekerja"
                               value="<?= set_value('nama_pekerja'); ?>" required>
                    </div>

                    <!-- Kamera Foto -->
                    <div class="form-group mb-3">
                        <label for="foto_pekerja" class="form-label d-block">Ambil Foto Pekerja</label>
                        <div class="camera-wrapper">
                            <div class="camera-preview mb-2">
                                <video id="video" width="320" height="240" autoplay playsinline muted></video>
                                <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                                <img id="photo" src="" alt="Hasil Foto"
                                    class="border rounded mt-2"
                                    style="max-width: 320px; width:100%; display:none;"/>
                            </div>
                            <div class="button-group mb-2 justify-content-end">
                                <button type="button" class="btn btn-flat btn-success btn-sm px-4" id="btnCapture">📸 Ambil Foto</button>
                                <button type="button" class="btn btn-flat btn-warning btn-sm px-4" id="btnRetake" style="display:none;">🔄 Ulangi</button>
                            </div>
                        </div>
                        <input type="hidden" name="foto_pekerja" id="foto_pekerja">
                    </div>

                    <!-- Hidden otomatis -->
                    <input type="hidden" name="tgl_masuk" id="tgl_masuk">
                    <input type="hidden" name="status" value="masuk">
                    <input type="hidden" name="id_satpam_masuk" value="<?= $this->session->userdata('id_satpam'); ?>">

                    <!-- Tombol -->
                    <div class="action-buttons">
                        <a href="<?= site_url('c_pekerja'); ?>" class="btn btn-flat btn-warning">
                            ⬅️ Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-flat">
                            💾 Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const btnCapture = document.getElementById('btnCapture');
    const btnRetake = document.getElementById('btnRetake');
    const inputFoto = document.getElementById('foto_pekerja');
    const tglMasuk = document.getElementById('tgl_masuk');

    // Set otomatis tanggal & waktu saat submit
    const now = new Date();
    tglMasuk.value = now.toISOString().slice(0, 19).replace('T', ' ');

    // Nyalakan kamera belakang
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "environment" }, 
                audio: false 
            });
            video.srcObject = stream;
        } catch (err) {
            alert("❌ Tidak dapat mengakses kamera:\n" + err.message + 
                  "\nPastikan:\n1. Anda menggunakan HTTPS.\n2. Izin kamera diaktifkan di browser.");
        }
    }

    startCamera();

    btnCapture.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataURL = canvas.toDataURL('image/jpeg', 0.6);
        photo.src = dataURL;
        photo.style.display = 'block';
        inputFoto.value = dataURL;
        video.style.display = 'none';
        btnCapture.style.display = 'none';
        btnRetake.style.display = 'inline-block';
    });

    btnRetake.addEventListener('click', () => {
        photo.style.display = 'none';
        video.style.display = 'block';
        btnRetake.style.display = 'none';
        btnCapture.style.display = 'inline-block';
        inputFoto.value = '';
    });
});
</script>

</body>
</html>
