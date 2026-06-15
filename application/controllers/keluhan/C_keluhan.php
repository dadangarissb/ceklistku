<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_keluhan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memanggil model di dalam sub-folder Keluhan
        $this->load->model('keluhan/M_keluhan');
        $this->load->helper('url');

        $this->load->library('form_validation');
        $this->load->library('template');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));
    }

    // Tampilan untuk User (Input Laporan)
    public function index() {
        $data['my_report'] = $this->M_keluhan->get_all_keluhan();
        // Jika view juga di dalam folder Keluhan: $this->load->view('Keluhan/v_user', $data);
        $this->load->view('v_user_keluhan', $data);
    }

    // Tampilan untuk Admin (Monitoring & Tindak Lanjut)
    public function monitoring_admin() {
        $data['all_keluhan'] = $this->M_keluhan->get_all_keluhan();
        $this->template->display('admin/keluhan/v_admin_keluhan', $data);
    }

    public function input_keluhan() {
        $username = $this->session->userdata('username');
        
        $data['username'] = $username;

        $this->template->user('admin/keluhan/v_tambah_keluhan', $data);
    }

    public function simpan() {
        $config['upload_path']   = './assets/uploads/keluhan/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 5120;
        $config['file_name']     = 'lapor_' . time();

        // Gunakan initialize karena library sudah di-load di construct
        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_keluhan')) {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            // --- PROSES KOMPRESI ---
            $config_resize['image_library']  = 'gd2';
            $config_resize['source_image']   = './assets/uploads/keluhan/' . $file_name;
            $config_resize['quality']        = '60%';
            $config_resize['width']          = 1000;
            $config_resize['maintain_ratio'] = TRUE;

            $this->image_lib->initialize($config_resize);
            $this->image_lib->resize();
            
            $foto = $file_name;
        } else {
            // Logika jika gagal: simpan pesan error ke flashdata untuk SweetAlert
            $this->session->set_flashdata('error', $this->upload->display_errors());
            $foto = 'default.png';
        }

    $data = [
        'nama_keluhan'   => $this->input->post('nama_keluhan'),
        'lokasi_keluhan' => $this->input->post('lokasi_keluhan'),
        'pelapor'        => $this->input->post('pelapor'),
        'foto_keluhan'   => $foto,
        'tgl_laporan'    => date('Y-m-d H:i:s'),
        'status'         => 'Pending'
    ];

    $this->M_keluhan->insert_keluhan($data);
   
    // Set Flashdata untuk memicu SweetAlert
    $this->session->set_flashdata('swal_success', 'Laporan berhasil disimpan!');

    redirect('C_dashboard_user');
}

    public function proses_tindak_lanjut() {
        $id = $this->input->post('id_keluhan');
        $data = [
            'pic'         => $this->input->post('pic'),
            'status'      => 'Selesai',
            'tgl_selesai' => date('Y-m-d H:i:s')
        ];
        
        $this->M_keluhan->update_keluhan($id, $data);
        redirect('keluhan/C_keluhan/admin'); // Redirect ke sub-folder/controller/method
    }
}