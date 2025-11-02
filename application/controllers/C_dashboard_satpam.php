<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dashboard_satpam extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        // Pastikan user sudah login dan role satpam
        if (!$this->session->userdata('id_satpam')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('Auth');
            exit;
        }

        $data['title'] = 'Dashboard Satpam';
        $this->template->satpam('satpam/V_dashboard_satpam', $data);
    }
}
