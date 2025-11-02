<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_patroli extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_patroli', 'M_titik_patroli','M_jadwal_patroli'));
        $this->load->library(['session', 'image_lib']);
    }

    public function index() {

        $id_unit = $this->session->userdata('id_unit');

        if (!$id_unit) {
            $this->session->set_flashdata('error', 'Session unit tidak ditemukan. Silakan login ulang.');
            redirect('auth/login');
            exit;
        }

        // Ambil jadwal patroli per unit
        $data['jadwal'] = $this->M_jadwal_patroli->get_by_unit($id_unit);

        // Ambil total titik patroli per unit (untuk menghitung kelengkapan)
        $data['jumlah_titik'] = $this->M_titik_patroli->count_by_unit($id_unit);

        $data['id_unit'] = $id_unit;
        $this->template->satpam('satpam/V_jadwal_patroli_satpam_list', $data);
    }

    public function titik_patroli($id_jadwal = null)
    {
        $id_unit = $this->session->userdata('id_unit');

        // Pastikan unit ada di session
        if (!$id_unit) {
            $this->session->set_flashdata('error', 'Session unit tidak ditemukan. Silakan login ulang.');
            redirect('auth/login');
            exit;
        }

        // Validasi id_jadwal
        if (!$id_jadwal) {
            $this->session->set_flashdata('error', 'Jadwal patroli tidak ditemukan.');
            redirect('C_jadwal_patroli');
            exit;
        }

        // Ambil data jadwal patroli
        $jadwal = $this->M_jadwal_patroli->get_by_id($id_jadwal);

        if (!$jadwal) {
            $this->session->set_flashdata('error', 'Data jadwal tidak valid.');
            redirect('C_jadwal_patroli');
            exit;
        }

        // Ambil daftar titik patroli berdasarkan unit
        $data['titik_patroli'] = $this->M_titik_patroli->get_by_unit($id_unit);
        $data['id_jadwal'] = $id_jadwal;
        $data['id_unit'] = $id_unit;
        $data['jadwal'] = $jadwal;

        // Kirim ke view
        $this->template->satpam('satpam/V_titik_patroli_list', $data);
    }

    // ✅ API kecil untuk ambil detail titik berdasarkan ID
    public function get_titik($id) {
        $data = $this->M_titik_patroli->get_by_id($id);
        echo json_encode($data);
    }

    public function add($id_titik = null, $id_jadwal = null)
    {
    // === Validasi parameter wajib ===
    if ($id_titik === null) {
        $this->session->set_flashdata('error', 'Titik patroli tidak ditemukan.');
        redirect('C_titik_patroli'); // Sesuaikan huruf besar
        return;
    }

    // === Ambil detail titik patroli ===
    $titik = $this->M_titik_patroli->get_by_id($id_titik);
    if (!$titik) {
        $this->session->set_flashdata('error', 'Data titik patroli tidak ditemukan.');
        redirect('C_titik_patroli');
        return;
    }

    // === Siapkan data untuk form ===
    $data['titik'] = $titik;
    $data['id_titik'] = $id_titik;
    $data['id_jadwal'] = $id_jadwal; // jadwal aktif yang dikirim dari URL
    $data['title'] = 'Form Patroli Satpam';

    // === Load view dengan template AdminLTE ===
    $this->template->satpam('satpam/V_patroli_form', $data);
    }


    public function simpan() {
        $id_titik   = $this->input->post('id_titik');
        $id_jadwal   = $this->input->post('id_jadwal');
        $id_unit    = $this->input->post('id_unit');
        $id_satpam  = $this->session->userdata('id_satpam') ?? 1;
        $latitude   = $this->input->post('latitude');
        $longitude  = $this->input->post('longitude');
        $keterangan = $this->input->post('keterangan');
        $foto_base64 = $this->input->post('foto_visitor');

        // Validasi posisi (radius 10m)
        $valid = $this->M_patroli->cek_titik_patroli($id_titik, $latitude, $longitude);
        if (!$valid) {
            $this->session->set_flashdata('error', '❌ Anda terlalu jauh dari titik patroli (lebih dari 10 meter)');
            redirect('c_patroli');
            return;
        }

        // Simpan foto base64 ke file & kompres
        $foto_nama = '';
        if (!empty($foto_base64)) {
            $foto_data = base64_decode(str_replace('data:image/jpeg;base64,', '', $foto_base64));
            $foto_nama = 'patroli_'.time().'.jpg';
            $path = './uploads/patroli/'.$foto_nama;
            file_put_contents($path, $foto_data);

            // Kompres foto agar hemat penyimpanan
            $config['image_library'] = 'gd2';
            $config['source_image'] = $path;
            $config['quality'] = '70%';
            $config['maintain_ratio'] = TRUE;

            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }

        $data = [
            'id_satpam'  => $id_satpam,
            'id_unit'    => $id_unit,
            'id_titik'   => $id_titik,
            'id_jadwal'  => $id_jadwal,
            'latitude'   => $latitude,
            'longitude'  => $longitude,
            'foto'       => $foto_nama,
            'keterangan' => $keterangan,
            'waktu'      => date('Y-m-d H:i:s')
        ];

        if ($this->M_patroli->insert($data)) {
            $this->session->set_flashdata('success', '✅ Data patroli berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menyimpan data patroli');
        }

        redirect('C_patroli/titik_patroli/' . $id_jadwal);
    }
}
