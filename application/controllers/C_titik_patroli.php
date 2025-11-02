<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_titik_patroli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_titik_patroli');
        $this->load->library(['session', 'image_lib']);
        $this->load->helper(['url', 'form', 'file']);
    }

    // Form tambah titik patroli
    public function index()
    {
        echo "haha";
        $data['units'] = $this->M_titik_patroli->get_units();
        $this->load->view('admin/V_titik_patroli_add', $data);
    }

    // Simpan titik patroli (menerima foto base64)
    public function save()
    {
        // ambil POST
        $id_unit   = $this->input->post('id_unit');
        $nama      = $this->input->post('nama_titik');
        $latitude  = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $radius    = $this->input->post('radius') ?: 10;
        $deskripsi = $this->input->post('deskripsi');
        $foto_base64 = $this->input->post('foto_location'); // base64

        // validasi sederhana
        if (empty($id_unit) || empty($nama) || empty($latitude) || empty($longitude)) {
            $this->session->set_flashdata('error','Lengkapi data wajib (unit, nama, koordinat).');
            redirect('C_titik_patroli/add');
            return;
        }

        $foto_filename = null;
        if (!empty($foto_base64)) {
            // bersihkan prefix
            if (strpos($foto_base64, 'data:') === 0) {
                $foto_base64 = preg_replace('#^data:image/\w+;base64,#i', '', $foto_base64);
            }
            $foto_base64 = str_replace(' ', '+', $foto_base64);
            $foto_data = base64_decode($foto_base64);

            // buat folder jika belum ada
            $upload_path = FCPATH . 'uploads/titik_patroli/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $foto_filename = 'titik_' . time() . '_' . substr(md5(mt_rand()),0,6) . '.jpg';
            $file_path = $upload_path . $foto_filename;
            file_put_contents($file_path, $foto_data);

            // tambahan: kompres ulang di server (opsional)
            $this->image_lib->clear();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $file_path;
            $config['quality'] = '75%'; // kompres server-side
            $config['maintain_ratio'] = TRUE;
            // optional resize to max width (misal 1200px) agar tidak terlalu besar
            $config['width'] = 1200;
            $config['height'] = 1200;

            $this->image_lib->initialize($config);
            @$this->image_lib->resize(); // suppress warning jika tidak perlu resize
            $this->image_lib->clear();
        }

        // simpan ke DB
        $insert = [
            'id_unit'   => $id_unit,
            'nama_titik'=> $nama,
            'latitude'  => $latitude,
            'longitude' => $longitude,
            'radius'    => $radius,
            'deskripsi' => $deskripsi,
            'foto'      => $foto_filename
        ];

        $this->M_titik_patroli->insert($insert);
        $this->session->set_flashdata('success','Titik patroli berhasil ditambahkan.');
        redirect('C_titik_patroli');
    }
}
