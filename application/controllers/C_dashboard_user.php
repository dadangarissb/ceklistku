<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
    }

    public function index() {
        // Pastikan user sudah login dan role satpam
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('C_login');
            exit;
        }
        
        $username    = $this->session->userdata('username');
        $id_unit    = $this->session->userdata('id_unit');
        $id_lokasi  = $this->session->userdata('id_lokasi');
        $id_kategori_pekerjaan  = $this->session->userdata('id_kategori_pekerjaan');


        $data = array(
            'username'    => $username,
		    'id_unit'     => $id_unit,
		    'id_lokasi'   => $id_lokasi,
		    'id_kategori_pekerjaan'         => $id_kategori_pekerjaan,
	    );
        
        $this->template->user('user/v_dashboard_user', $data);
    }
}
