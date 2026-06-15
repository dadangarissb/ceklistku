<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {
	
	// Index login
	function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_login'));
        $this->load->library('form_validation');
        // $this->load->library('template');
        // $this->load->library('session');
    }

    public function index() 
    {  
        $this->load->view('v_login');

    }

    public function aksi_login(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username atau password tidak boleh kosong');
            $this->index();
        }
        else{

        $data = array(
            'id_user' => $username,
            'password' => $password
            );
        
        //Cek dulu data di database admin
        $cek_data_admin = $this->M_login->cek_login_admin($data);
        // $cek_data_satpam = $this->M_login->cek_login_satpam($data);

        // Cek apakah user ditemukan
        if ($cek_data_admin->num_rows() > 0) {

            // Ambil 1 baris data user
            $admin = $cek_data_admin->row();

            $id_user   = $admin->id_user;
            $nama_user = $admin->nama_user;
            $jabatan   = $admin->jabatan;
            $id_unit   = $admin->id_unit;
            $status    = $admin->status;

            // Contoh: simpan data ke session
            $this->session->set_userdata([
                'id_user'   => $id_user,
                'nama_user' => $nama_user,
                'jabatan'   => $jabatan,
                'id_unit'   => $id_unit,
                'status'    => $status
            ]);

            redirect(base_url("c_dashboard_admin"));

        }
        elseif(($cek_data_user = $this->M_login->cek_login_user($data))->num_rows() > 0)
            {
                // Ambil 1 baris data user
                $user = $cek_data_user->row();


                $this->session->set_userdata([
                    'username'      => $user->username,
                    'nama_user'     => $user->nama_user,
                    'id_unit'       => $user->id_unit,
                    // 'id_lokasi'     => $user->id_lokasi,
                    'id_kategori_pekerjaan'     => $user->id_kategori_pekerjaan,
                ]);

                redirect(base_url("C_dashboard_user"));

            }
        else{
            $this->session->set_flashdata('message','(<span class="text-danger">Username atau Password anda salah/ tidak terdaftar ! ) <br> Silahkan Coba Lagi');
            redirect(base_url("C_login"));
        }
    }
    }

    
	
	// Logout di sini
	public function logout() {
    $this->session->sess_destroy();
    redirect(base_url("c_login"));
    }	



    public function _rules() 
    {
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}