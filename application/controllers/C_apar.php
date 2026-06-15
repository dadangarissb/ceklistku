<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_apar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load library dan helper yang diwajibkan
        $this->load->library(['session', 'upload', 'image_lib', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->model('M_apar');
    }

    // 1. HALAMAN UTAMA (LIST DATA)
    public function index() {
        $data['title'] = "Monitoring APAR";
        
        // QUERY JOIN: Mengambil data APAR sekaligus Tanggal Cek Terakhirnya
        $this->db->select('apar.*, MAX(ceklist_apar.created_at) as tgl_cek_terakhir');
        $this->db->from('apar');
        // Join ke tabel ceklist agar record yang belum pernah dicek tetap muncul (Left Join)
        $this->db->join('ceklist_apar', 'apar.id_apar = ceklist_apar.id_apar', 'left');
        $this->db->group_by('apar.id_apar');
        
        $data['apar'] = $this->db->get()->result_array();
        
        $this->template->user('user/apar/v_apar_list', $data);
    }

    // 2. HALAMAN FORM TAMBAH MASTER
    public function tambah_apar() {
        $data['title'] = "Input APAR Baru";
        $this->template->user('user/apar/v_tambah_apar', $data);
    }

    // 3. PROSES SIMPAN MASTER APAR
    public function proses_simpan_apar() {
        $no_apar = $this->input->post('no_apar');

        // Validasi Duplikasi No APAR
        $cek = $this->db->get_where('apar', ['no_apar' => $no_apar])->num_rows();
        if ($cek > 0) {
            $this->session->set_flashdata('swal_error', 'Nomor APAR ' . $no_apar . ' sudah terdaftar!');
            redirect('C_apar/tambah_apar');
            return;
        }

        $data = [
            'no_apar'        => $no_apar,
            'lokasi_apar'    => $this->input->post('lokasi_apar'),
            'jenis_apar'     => $this->input->post('jenis_apar'),
            'merk_apar'      => $this->input->post('merk_apar'),
            'berat_apar'     => $this->input->post('berat_apar'),
            'tgl_kadaluarsa' => $this->input->post('tgl_kadaluarsa'),
            // Upload ke folder /apar/
            'foto_apar'      => $this->_do_upload('b64_unit', 'file_unit', 'UNIT', './assets/uploads/apar/'),
            'foto_lokasi'    => $this->_do_upload('b64_loc', 'file_loc', 'LOC', './assets/uploads/apar/')
        ];

        $this->db->insert('apar', $data);
        $this->session->set_flashdata('swal_success', 'Data Master Berhasil Disimpan');
        redirect('C_apar');
    }

    // 4. HALAMAN FORM CEKLIST RUTIN
    public function form_ceklist($id_apar) {
        $data['unit'] = $this->db->get_where('apar', ['id_apar' => $id_apar])->row();
        if (!$data['unit']) {
            show_404();
        }
        $data['title'] = "Ceklist Rutin APAR";
        $this->template->user('user/apar/v_ceklist_apar', $data);
    }

    // 5. PROSES SIMPAN CEKLIST
    public function proses_simpan_ceklist() {
        $id_apar = $this->input->post('id_apar');
        
        // --- VALIDASI ANTI-DOUBLE INPUT ---
        // Cek apakah sudah ada input untuk ID APAR ini dalam 1 menit terakhir
        $satu_menit_lalu = date('Y-m-d H:i:s', strtotime('-1 minute'));
        
        $this->db->where('id_apar', $id_apar);
        $this->db->where('created_at >', $satu_menit_lalu);
        $cek_double = $this->db->get('ceklist_apar')->num_rows();

        if ($cek_double > 0) {
            // Jika ditemukan data dalam 1 menit terakhir, gagalkan proses
            $this->session->set_flashdata('swal_error', 'Gagal! Anda baru saja menginput data untuk unit ini. Tunggu sebentar.');
            redirect('C_apar');
            return; // Berhenti di sini
        }
        // -----------------------------------

        $data_cek = [
            'id_apar'       => $id_apar,
            'kategori'      => $this->input->post('kategori'),
            'tekanan'       => $this->input->post('tekanan'),
            'safety_pin'    => $this->input->post('safety_pin'),
            'handle'        => $this->input->post('handle'),
            'selang_nozzle' => $this->input->post('selang_nozzle'),
            'catatan'       => $this->input->post('catatan'),
            'created_at'    => date('Y-m-d H:i:s'),
            // Upload ke folder /ceklist/
            'foto_apar'     => $this->_do_upload('b64_cek', 'file_cek', 'CHECK', './assets/uploads/ceklist_apar/')
        ];

        $this->db->insert('ceklist_apar', $data_cek);
        
        $this->session->set_flashdata('swal_success', 'Pemeriksaan Berhasil Dicatat!');
        redirect('C_apar');
    }

    // --- FUNGSI HELPER (PRIVATE) ---

    private function _do_upload($baseName, $fileName, $prefix, $upload_path) {
        // Buat folder otomatis jika belum ada
        if(!is_dir($upload_path)) mkdir($upload_path, 0777, true);
        
        $base64 = $this->input->post($baseName);
        $final_name = 'default.jpg';

        // Logika 1: Jika ada input dari Kamera (Base64)
        if (!empty($base64)) {
            $img = str_replace('data:image/jpeg;base64,', '', $base64);
            $img = base64_decode($img);
            $final_name = $prefix . '_' . time() . '_' . rand(10,99) . '.jpg';
            file_put_contents($upload_path . $final_name, $img);
        } 
        // Logika 2: Jika ada input dari File Browser
        elseif (!empty($_FILES[$fileName]['name'])) {
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = $prefix . '_' . time() . '_' . rand(10,99);
            
            $this->upload->initialize($config);
            if ($this->upload->do_upload($fileName)) {
                $final_name = $this->upload->data('file_name');
            }
        }

        // Lakukan kompresi jika bukan file default
        if ($final_name != 'default.jpg') {
            $this->_compress_image($upload_path . $final_name);
        }

        return $final_name;
    }

    private function _compress_image($source) {
        $config['image_library']  = 'gd2';
        $config['source_image']   = $source;
        $config['maintain_ratio'] = TRUE;
        $config['width']          = 800;   // Resize max 800px lebar
        $config['quality']        = '50%'; // Kompres kualitas ke 50%
        $config['new_image']      = $source;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
}