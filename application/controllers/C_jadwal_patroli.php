<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_jadwal_patroli extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_jadwal_patroli');
        $this->load->library('form_validation');
        $this->load->library('template');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));
    }

    public function index() {
        $id_unit = $this->session->userdata('id_unit');
        $data['jadwal_patroli'] = $this->M_jadwal_patroli->get_all($id_unit);
        
        $this->template->display('admin/V_jadwal_patroli_list', $data);
    }

    public function add() {
        $this->template->display('admin/V_jadwal_patroli_form');
    }

    public function simpan() {
        $id_unit = $this->session->userdata('id_unit');

        $data = [
            'id_unit' => $id_unit,
            'nama_jadwal' => $this->input->post('nama_jadwal'),
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'keterangan' => $this->input->post('keterangan')
        ];

        if ($this->M_jadwal_patroli->insert($data)) {
            $this->session->set_flashdata('success', '✅ Jadwal patroli berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menambahkan jadwal patroli');
        }

        redirect('C_jadwal_patroli');
    }
}
