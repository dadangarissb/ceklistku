<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_ceklist extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['M_pekerjaan','M_ceklist']);
        $this->load->library('form_validation');
        // $this->load->library('template');
        // $this->load->library('Simple_login');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));
    }

    
    public function rekap() {
        // Ambil id unit (sesuaikan dengan sistem login kamu)
        $id_unit = $this->session->userdata('id_unit');

        // Ambil filter dari GET
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $nama_tad = $this->input->get('nama_tad');

        // 🔹 Kalau semua kosong, default = hari ini
        if (empty($tgl_awal) && empty($tgl_akhir) && empty($nama_tad)) {
            $tgl_awal = date('Y-m-d');
            $tgl_akhir = date('Y-m-d');
        }

        // Panggil model
        $data['ceklist'] = $this->M_ceklist->get_rekap_ceklist_by_unit(
            $id_unit,
            $tgl_awal,
            $tgl_akhir,
            $nama_tad
        );

        // Kirim juga ke view biar kepakai di value input
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['nama_tad'] = $nama_tad;
        
        $this->template->display('admin/v_data_ceklist', $data);

    }

    // public function titik_patroli($id_jadwal = null)
    // {
    //     $id_unit = $this->session->userdata('id_unit');

    //     if (!$id_unit) {
    //         $this->session->set_flashdata('error', 'Session unit tidak ditemukan. Silakan login ulang.');
    //         redirect('auth/login');
    //         exit;
    //     }

    //     if (!$id_jadwal) {
    //         $this->session->set_flashdata('error', 'Jadwal patroli tidak ditemukan.');
    //         redirect('C_jadwal_patroli');
    //         exit;
    //     }

    //     $jadwal = $this->M_jadwal_patroli->get_by_id($id_jadwal);
    //     if (!$jadwal) {
    //         $this->session->set_flashdata('error', 'Data jadwal tidak valid.');
    //         redirect('C_jadwal_patroli');
    //         exit;
    //     }

    //     $titik_list = $this->M_titik_patroli->get_by_unit($id_unit);

    //     // 🔹 Tambahan: cek status patroli untuk tiap titik
    //     foreach ($titik_list as $titik) {
    //         $titik->status = $this->M_patroli->get_status_titik($id_jadwal, $titik->id_titik, $id_unit);
    //     }

    //     $data['titik_patroli'] = $titik_list;
    //     $data['id_jadwal'] = $id_jadwal;
    //     $data['id_unit'] = $id_unit;
    //     $data['jadwal'] = $jadwal;

    //     $this->template->satpam('satpam/V_titik_patroli_list', $data);
    // }

    // public function add_ajax()
    // {
    //     if (!$this->input->is_ajax_request()) {
    //         show_404();
    //     }

    //     $id_titik  = $this->input->post('id_titik');
    //     $id_jadwal = $this->input->post('id_jadwal');
    //     $latitude  = $this->input->post('latitude');
    //     $longitude = $this->input->post('longitude');
    //     $id_unit   = $this->session->userdata('id_unit');
    //     $id_satpam = $this->session->userdata('id_satpam');

    //     if (!$id_titik || !$id_jadwal || !$id_unit) {
    //         echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    //         return;
    //     }

    //     // 🔹 Cek apakah titik sudah pernah dipatroli hari ini
    //     $cek = $this->M_patroli->cek_sudah_patroli($id_titik, $id_jadwal, $id_unit);
    //     if ($cek) {
    //         echo json_encode(['status' => 'error', 'message' => 'Titik ini sudah dipatroli sebelumnya.']);
    //         return;
    //     }

    //     $data = [
    //         'id_titik'  => $id_titik,
    //         'id_jadwal' => $id_jadwal,
    //         'id_unit'   => $id_unit,
    //         'id_satpam' => $id_satpam,
    //         'latitude'  => $latitude,
    //         'longitude' => $longitude,
    //         'waktu'     => date('Y-m-d H:i:s')
    //     ];

    //     if ($this->M_patroli->insert($data)) {
    //         echo json_encode(['status' => 'ok', 'message' => 'Data patroli berhasil disimpan.']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data patroli.']);
    //     }
    // }



    // // ✅ API kecil untuk ambil detail titik berdasarkan ID
    // public function get_titik($id) {
    //     $data = $this->M_titik_patroli->get_by_id($id);
    //     echo json_encode($data);
    // }

    // public function add($id_titik = null, $id_jadwal = null)
    // {
    // // === Validasi parameter wajib ===
    // if ($id_titik === null) {
    //     $this->session->set_flashdata('error', 'Titik patroli tidak ditemukan.');
    //     redirect('C_titik_patroli'); // Sesuaikan huruf besar
    //     return;
    // }

    // // === Ambil detail titik patroli ===
    // $titik = $this->M_titik_patroli->get_by_id($id_titik);
    // if (!$titik) {
    //     $this->session->set_flashdata('error', 'Data titik patroli tidak ditemukan.');
    //     redirect('C_titik_patroli');
    //     return;
    // }

    // // === Siapkan data untuk form ===
    // $data['titik'] = $titik;
    // $data['id_titik'] = $id_titik;
    // $data['id_jadwal'] = $id_jadwal; // jadwal aktif yang dikirim dari URL
    // $data['title'] = 'Form Patroli Satpam';

    // // === Load view dengan template AdminLTE ===
    // $this->template->satpam('satpam/V_patroli_form', $data);
    // }


    // public function simpan() {
    //     $id_titik   = $this->input->post('id_titik');
    //     $id_jadwal  = $this->input->post('id_jadwal');
    //     $id_unit    = $this->input->post('id_unit');
    //     $id_satpam  = $this->session->userdata('id_satpam') ?? 1;
    //     $latitude   = $this->input->post('latitude');
    //     $longitude  = $this->input->post('longitude');
    //     $keterangan = $this->input->post('keterangan');
    //     $foto_base64 = $this->input->post('foto_visitor');

    //     // ✅ Validasi posisi dari backend
    //     if (!$this->M_patroli->cek_titik_patroli($id_titik, $latitude, $longitude, 5)) {
    //         $this->session->set_flashdata('error', 'Anda terlalu jauh dari titik patroli (lebih dari 5 meter).');
    //         redirect('C_patroli/titik_patroli/' . $id_jadwal);
    //         return;
    //     }

    //     // ✅ Simpan foto base64 ke file & kompres
    //     $foto_nama = '';
    //     if (!empty($foto_base64)) {
    //         $foto_data = base64_decode(str_replace('data:image/jpeg;base64,', '', $foto_base64));
    //         $foto_nama = 'patroli_' . time() . '.jpg';
    //         $path = './uploads/patroli/' . $foto_nama;
    //         file_put_contents($path, $foto_data);

    //         // Kompres foto
    //         $config['image_library'] = 'gd2';
    //         $config['source_image'] = $path;
    //         $config['quality'] = '70%';
    //         $config['maintain_ratio'] = TRUE;

    //         $this->image_lib->initialize($config);
    //         $this->image_lib->resize();
    //     }

    //     // ✅ Simpan ke database
    //     $data = [
    //         'id_satpam'  => $id_satpam,
    //         'id_unit'    => $id_unit,
    //         'id_titik'   => $id_titik,
    //         'id_jadwal'  => $id_jadwal,
    //         'latitude'   => $latitude,
    //         'longitude'  => $longitude,
    //         'foto'       => $foto_nama,
    //         'keterangan' => $keterangan,
    //         'waktu'      => date('Y-m-d H:i:s')
    //     ];

    //     if ($this->M_patroli->insert($data)) {
    //         $this->session->set_flashdata('success', '✅ Data patroli berhasil disimpan.');
    //     } else {
    //         $this->session->set_flashdata('error', '❌ Gagal menyimpan data patroli.');
    //     }

    //     redirect('C_patroli/titik_patroli/' . $id_jadwal);
    // }
}
