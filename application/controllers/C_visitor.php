<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_visitor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['m_mutasi_jaga', 'm_peralatan_jaga', 'm_satpam','M_visitor']);
        $this->load->library('session');
        $this->load->library('template');
        $this->load->library('image_lib');
        $this->load->helper(['url', 'html']);

        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data_visitor = $this->M_visitor->get_all();
        $data = array(
            'data_visitor' => $data_visitor
        );

        $this->template->satpam('satpam/v_visitor_list', $data);
    }    

    public function input_visitor() 
    {
        $id_satpam_masuk = $this->session->userdata('id_satpam');
                
        $data = array(
	    'nama_visitor' => set_value('nama_visitor'),
	    'instansi' => set_value('instansi'),
	    'keperluan' => set_value('keperluan'),
	    'bertemu_dengan' => set_value('bertemu_dengan'),
	    'tgl_masuk' => set_value('tg_masuk'),
	    'tgl_keluar' => set_value('tgl_keluar'),
	    'id_satpam_masuk' => $id_satpam_masuk,
        'no_kartu_akes' => set_value('no_kartu_akses'),
	    );

        $this->template->satpam('satpam/v_visitor_form', $data);
    }
    
    
    public function input_visitor_action() 
    {
    // $this->_rules();

    // pastikan session satpam sudah aktif
    $id_satpam = $this->session->userdata('id_satpam');
    if (!$id_satpam) {
        $this->session->set_flashdata('error', 'Session satpam tidak ditemukan, silakan login ulang.');
        redirect('c_login'); 
    }

    $foto_base64 = $this->input->post('foto_visitor');

    // ambil data dari form
    $data = array(
        'nama_visitor'     => $this->input->post('nama_visitor', TRUE),
        'instansi'         => $this->input->post('instansi', TRUE),
        'keperluan'        => $this->input->post('keperluan', TRUE),
        'bertemu_dengan'   => $this->input->post('bertemu_dengan', TRUE),
        'tgl_masuk'        => $this->input->post('tgl_masuk', TRUE),
        'tgl_keluar'       => NULL, // diisi nanti saat visitor keluar
        'no_kartu_akses'   => $this->input->post('no_kartu_akses', TRUE),
        'id_satpam_masuk'  => $id_satpam,
        'status'           => 'masuk', // default status
    );

    // ====== FOTO BASE64 HANDLING ======
    if ($foto_base64) {
        // Hilangkan prefix dan spasi
        $foto_base64 = str_replace('data:image/jpeg;base64,', '', $foto_base64);
        $foto_base64 = str_replace(' ', '+', $foto_base64);
        $foto_data   = base64_decode($foto_base64);

        // Buat nama file unik
        $nama_file = 'visitor_' . time() . '.jpg';
        $path = FCPATH . 'uploads/visitor/' . $nama_file;

        // Simpan file ke server
        file_put_contents($path, $foto_data);

        // ====== KOMPRES SETELAH FILE DISIMPAN ======
        $this->load->library('image_lib');

        $config['image_library']  = 'gd2';
        $config['source_image']   = $path;
        $config['quality']        = '70%'; // kompres 70%
        $config['maintain_ratio'] = TRUE;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        // ===============================

        // Simpan nama file ke database
        $data['foto'] = $nama_file;
    }


    // simpan ke database lewat model
    $this->M_visitor->insert_data($data);

    // tampilkan notifikasi dan redirect
    $this->session->set_flashdata('success', 'Data visitor berhasil disimpan.');
    redirect('c_visitor');
    }

    
    public function update_status($id_visitor) 
    {
       $id_satpam = $this->session->userdata('id_satpam');

        $data = array(
		'id_visitor' => $id_visitor,
		'id_satpam_keluar' => $id_satpam,
        'tgl_keluar'     => date('Y-m-d H:i:s'), // <— Tambahkan datetime sekarang
        'status' => "keluar",
	    );
        
        $this->M_visitor->update_status($data);

        redirect('C_visitor');
    }

    public function read($id_visitor)
    {
        $row = $this->M_visitor->get_by_id($id_visitor);

        if ($row) {
            $data = array(
                'id_visitor'      => $row->id_visitor,
                'nama_visitor'    => $row->nama_visitor,
                'instansi'        => $row->instansi,
                'keperluan'       => $row->keperluan,
                'bertemu_dengan'  => $row->bertemu_dengan,
                'tgl_masuk'       => $row->tgl_masuk,
                'tgl_keluar'      => $row->tgl_keluar,
                'no_kartu_akses'  => $row->no_kartu_akses,
                'id_satpam_masuk' => $row->id_satpam_masuk,
                'id_satpam_keluar'=> $row->id_satpam_keluar,
                'foto'    => $row->foto,
            );

            $this->template->satpam('satpam/V_visitor_detail', $data);

        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('C_visitor'));
        }
    }

}