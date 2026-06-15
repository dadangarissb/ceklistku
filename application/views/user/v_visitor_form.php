<!doctype html>
<html>
<head>
    <title>Tambah Data Visitor</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
    <style>
    /* ==== Tampilan kamera responsif ==== */
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

        body {
            font-size: 15.5px;
        }
    }

    /* ==== Tombol aksi bawah kanan ==== */
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
    </style>
</head>
<body>

<div class="row">
    <div class="col-md-2"></div> 
    <div class="col-md-8">
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
                        <textarea class="form-control" name="keperluan" id="keperluan" rows="3"
                            placeholder="Tuliskan keperluan di sini..." required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <!-- <label for="bertemu_dengan">Bertemu Dengan</label>
                        <input type="text" class="form-control" name="bertemu_dengan" id="bertemu_dengan"
                            value="<?= set_value('bertemu_dengan'); ?>" required> -->
                        <input type="hidden" name="bertemu_dengan" id="bertemu_dengan" value="-">
                    </div>

                    <div class="form-group mb-3">
                        <!-- <label for="tgl_masuk">Tanggal & Waktu Masuk</label>
                        <input type="datetime-local" class="form-control" name="tgl_masuk" id="tgl_masuk" 
                            value="<?= set_value('tgl_masuk'); ?>" required> -->
                         <input type="hidden" name="tgl_masuk" id="tgl_masuk" value="">
                    </div>

                    <div class="form-group mb-3">
                        <label for="no_kartu_akses">Nomor Kartu Akses</label>
                        <input type="text" class="form-control" name="no_kartu_akses" id="no_kartu_akses"
                            value="<?= set_value('no_kartu_akses'); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto_visitor" class="form-label d-block">Ambil Foto Visitor</label>
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
                            <style>
                            .button-group {
                                display: flex;
                                justify-content: flex-end; /* tombol ke kanan */
                                gap: 10px;
                                width: 100%;
                            }

                            .button-group .btn {
                                padding: 8px 20px;
                                border-radius: 6px;
                                font-weight: 500;
                            }
                            </style>

                        </div>
                        <input type="hidden" name="foto_visitor" id="foto_visitor">
                    </div>

                    <!-- ID Satpam otomatis -->
                    <input type="hidden" name="id_satpam_masuk" value="<?= $this->session->userdata('id_satpam'); ?>">

                    <!-- Tombol Aksi -->
                    <br>
                    <div class="action-buttons">
                        <a href="<?= site_url('c_visitor'); ?>" class="btn btn-flat btn-warning">
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
<script src="<?php echo base_url(); ?>assets/js/jquery.priceformat.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const btnCapture = document.getElementById('btnCapture');
    const btnRetake = document.getElementById('btnRetake');
    const inputFoto = document.getElementById('foto_visitor');

    async function startCamera() {
        try {
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
