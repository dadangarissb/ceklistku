<section class="content">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Ceklist Rutin APAR: <b><?= $unit->no_apar ?></b></h3>
        </div>

        <form id="formCeklist" action="<?= base_url('C_apar/proses_simpan_ceklist') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_apar" value="<?= $unit->id_apar ?>">
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control">
                                <option value="cek rutin">Cek Rutin</option>
                                <option value="isi ulang">Isi Ulang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tekanan (Pressure)</label>
                            <select name="tekanan" class="form-control">
                                <option value="Normal">Normal</option>
                                <option value="Turun">Turun</option>
                                <option value="Over">Over</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Safety Pin & Segel</label>
                            <select name="safety_pin" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Handle</label>
                            <select name="handle" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Selang & Nozzle</label>
                            <select name="selang_nozzle" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kondisi Fisik Tabung</label>
                            <select name="kondisi_fisik" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" name="catatan" class="form-control" placeholder="Contoh: Kondisi bersih, siap digunakan" value="Baik">
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <label>Foto Bukti Pemeriksaan</label>
                        <div style="border: 2px dashed #ddd; padding: 10px; background: #f9f9f9;">
                            <video id="v_cek" width="100%" autoplay style="display:none; border-radius:5px;"></video>
                            <img id="p_cek" src="#" class="img-thumbnail" style="display:none; max-height: 200px;">
                            <div id="h_cek" style="padding: 20px;"><i class="fa fa-camera fa-3x text-muted"></i></div>
                            
                            <button type="button" class="btn btn-default btn-sm btn-block" onclick="openCamCek()">Buka Kamera</button>
                            <button type="button" id="s_cek" class="btn btn-primary btn-sm btn-block" style="display:none;" onclick="snapCek()">Ambil Foto</button>
                            
                            <input type="file" name="file_cek" class="form-control input-sm" style="margin-top:5px;" accept="image/*">
                            <input type="hidden" name="b64_cek" id="b64_cek">
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" id="btnSimpanCek" class="btn btn-warning pull-right btn-lg">SIMPAN HASIL CEK</button>
            </div>
        </form>
    </div>
</section>

<canvas id="canvas_cek" style="display:none;"></canvas>

<script>
    let streamCek = null;

    // Cegah Double Click
    document.getElementById('formCeklist').onsubmit = function() {
        document.getElementById('btnSimpanCek').disabled = true;
        document.getElementById('btnSimpanCek').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
        return true;
    };

    async function openCamCek() {
        if (streamCek) streamCek.getTracks().forEach(t => t.stop());
        try {
            streamCek = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
            let v = document.getElementById('v_cek');
            v.srcObject = streamCek;
            v.style.display = 'block';
            document.getElementById('h_cek').style.display = 'none';
            document.getElementById('p_cek').style.display = 'none';
            document.getElementById('s_cek').style.display = 'block';
        } catch (e) { alert("Kamera Error/Non-HTTPS"); }
    }

    function snapCek() {
        let v = document.getElementById('v_cek');
        let c = document.getElementById('canvas_cek');
        c.width = v.videoWidth; c.height = v.videoHeight;
        c.getContext('2d').drawImage(v, 0, 0);
        
        // KOMPRESI 1: Di Browser (Kualitas 0.6)
        let data = c.toDataURL('image/jpeg', 0.6); 
        document.getElementById('b64_cek').value = data;
        
        let p = document.getElementById('p_cek');
        p.src = data; p.style.display = 'block';
        v.style.display = 'none';
        document.getElementById('s_cek').style.display = 'none';
        streamCek.getTracks().forEach(t => t.stop());
    }
</script>