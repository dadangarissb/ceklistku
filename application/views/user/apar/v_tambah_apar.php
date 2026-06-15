<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-fire-extinguisher"></i> Tambah Inventaris APAR</h3>
        </div>

        <form id="formApar" action="<?= base_url('C_apar/proses_simpan_apar') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor APAR <span class="text-red">*</span></label>
                            <input type="text" name="no_apar" class="form-control" required placeholder="Contoh: APR-001">
                        </div>
                        <div class="form-group">
                            <label>Lokasi <span class="text-red">*</span></label>
                            <input type="text" name="lokasi_apar" class="form-control" required placeholder="Gedung A Lt. 1">
                        </div>
                        <div class="form-group">
                            <label>Jenis & Merk</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select name="jenis_apar" class="form-control">
                                        <option value="Powder">Powder</option>
                                        <option value="CO2">CO2</option>
                                        <option value="Halotron">Halotron</option>
                                        <option value="Foam">Foam</option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" name="merk_apar" class="form-control" placeholder="Merk">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>Berat (Kg)</label>
                                <input type="number" step="0.01" name="berat_apar" class="form-control">
                            </div>
                            <div class="col-xs-6">
                                <label>Kadaluarsa</label>
                                <input type="date" name="tgl_kadaluarsa" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <label>Foto Unit</label>
                        <div class="well well-sm">
                            <video id="v_unit" width="100%" autoplay style="display:none; border-radius:5px;"></video>
                            <img id="p_unit" src="#" class="img-thumbnail" style="display:none;">
                            <div id="h_unit"><i class="fa fa-camera fa-3x text-muted"></i></div>
                            <button type="button" class="btn btn-default btn-xs btn-block" onclick="openCam('unit')" style="margin-top:5px;">Buka Kamera</button>
                            <button type="button" id="s_unit" class="btn btn-primary btn-xs btn-block" style="display:none;" onclick="snap('unit')">Ambil Foto</button>
                            <input type="file" name="file_unit" class="form-control input-sm" style="margin-top:5px;" accept="image/*">
                            <input type="hidden" name="b64_unit" id="b64_unit">
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <label>Foto Lokasi</label>
                        <div class="well well-sm">
                            <video id="v_loc" width="100%" autoplay style="display:none; border-radius:5px;"></video>
                            <img id="p_loc" src="#" class="img-thumbnail" style="display:none;">
                            <div id="h_loc"><i class="fa fa-map-marker fa-3x text-muted"></i></div>
                            <button type="button" class="btn btn-default btn-xs btn-block" onclick="openCam('loc')" style="margin-top:5px;">Buka Kamera</button>
                            <button type="button" id="s_loc" class="btn btn-primary btn-xs btn-block" style="display:none;" onclick="snap('loc')">Ambil Foto</button>
                            <input type="file" name="file_loc" class="form-control input-sm" style="margin-top:5px;" accept="image/*">
                            <input type="hidden" name="b64_loc" id="b64_loc">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" id="btnSimpan" class="btn btn-success pull-right"><i class="fa fa-save"></i> SIMPAN DATA</button>
            </div>
        </form>
    </div>
</section>

<canvas id="canvas_tmp" style="display:none;"></canvas>





<script>
    let stream = null;
    // Cegah Double Click
    document.getElementById('formApar').onsubmit = function() {
        document.getElementById('btnSimpan').disabled = true;
        document.getElementById('btnSimpan').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memproses...';
        return true;
    };

    async function openCam(m) {
        if (stream) stream.getTracks().forEach(t => t.stop());
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
            let v = document.getElementById(m === 'unit' ? 'v_unit' : 'v_loc');
            v.srcObject = stream;
            v.style.display = 'block';
            document.getElementById(m === 'unit' ? 'h_unit' : 'h_loc').style.display = 'none';
            document.getElementById(m === 'unit' ? 'p_unit' : 'p_loc').style.display = 'none';
            document.getElementById(m === 'unit' ? 's_unit' : 's_loc').style.display = 'block';
        } catch (e) { alert("Akses Kamera Gagal!"); }
    }

    function snap(m) {
        let v = document.getElementById(m === 'unit' ? 'v_unit' : 'v_loc');
        let c = document.getElementById('canvas_tmp');
        c.width = v.videoWidth; c.height = v.videoHeight;
        c.getContext('2d').drawImage(v, 0, 0);
        let data = c.toDataURL('image/jpeg', 0.6); // Kompresi awal di Browser (60%)
        document.getElementById(m === 'unit' ? 'b64_unit' : 'b64_loc').value = data;
        let p = document.getElementById(m === 'unit' ? 'p_unit' : 'p_loc');
        p.src = data; p.style.display = 'block';
        v.style.display = 'none';
        document.getElementById(m === 'unit' ? 's_unit' : 's_loc').style.display = 'none';
        stream.getTracks().forEach(t => t.stop());
    }
</script>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Notifikasi Berhasil
        <?php if($this->session->flashdata('swal_success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('swal_success'); ?>',
                timer: 2500,
                showConfirmButton: false
            });
        <?php endif; ?>

        // Notifikasi Gagal
        <?php if($this->session->flashdata('swal_error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Simpan',
                text: '<?= $this->session->flashdata('swal_error'); ?>'
            });
        <?php endif; ?>
    });
</script>