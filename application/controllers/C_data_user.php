<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_data_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['M_user','M_lokasi']);
        $this->load->library('session');
        $this->load->library('template');
        $this->load->library('image_lib');
        $this->load->helper(['url', 'html']);

        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->userdata('id_user')) {
            // Kalau belum login, redirect ke halaman login
            redirect('C_login'); // sesuaikan dengan controller login kamu
            return;
        }

        $id_unit = $this->session->userdata('id_unit');

        $this->load->model('M_user');

        // Ambil user per unit
        $users = $this->M_user->get_all_by_id_unit($id_unit);

        // Untuk tiap user, ambil lokasi-lokasinya
        foreach ($users as $u) {
            $u->lokasi = $this->M_user->get_lokasi_by_user($u->username);
        }

        $nama_unit = $this->M_user->get_nama_unit($id_unit);

        $data = array(
            'data_tad'  => $users,
            'nama_unit' => $nama_unit
        );

        $this->template->display('admin/v_tad_list', $data);
    }    

    public function tambah_form()
    {
        // Cek apakah user sudah login
        if (!$this->session->userdata('id_user')) {
            // Kalau belum login, redirect ke halaman login
            redirect('C_login'); // sesuaikan dengan controller login kamu
            return;
        }

        $id_unit = $this->session->userdata('id_unit');

        $data = array(
        'id_unit'  => $id_unit,
        'nama_unit'   => $this->M_user->get_nama_unit($id_unit),
        'data_lokasi' => $this->M_user->get_all_lokasi_with_pic_by_unit($id_unit)
    );

        $this->template->display('admin/v_tad_form_tambah', $data);
    }   

    public function edit_form($username)
    {
        if (!$this->session->userdata('id_user')) {
            redirect('C_login');
            return;
        }

        $id_unit  = $this->session->userdata('id_unit');
        $nama_unit  = $this->session->userdata('nama_unit');

        $user = $this->M_user->get_user_by_username($username);
        if (!$user) {
            show_404();
        }

        $data_lokasi = $this->M_lokasi->get_by_unit($id_unit);
        $lokasi_user = $this->M_user->get_lokasi_by_user($username);

        $lokasi_terpilih = [];
        foreach ($lokasi_user as $l) {
            $lokasi_terpilih[] = $l->id_lokasi;
        }

        $data = [
            'mode'            => 'edit',
            'user'            => $user,
            'id_unit'            => $id_unit,
            'nama_unit'            => $nama_unit,
            'data_lokasi'     => $data_lokasi,
            'lokasi_terpilih' => $lokasi_terpilih
        ];

        // 👇 PAKAI VIEW YANG SAMA
        $this->template->display('admin/v_tad_form_edit', $data);
    }


    public function cek_username()
    {
        $username = $this->input->post('username');

        $this->load->model('M_user');

        $cek = $this->M_user->cek_username_exist($username);

        if ($cek > 0) {
            echo json_encode(['status' => 'taken']);
        } else {
            echo json_encode(['status' => 'available']);
        }
    }

    public function simpan()
    {   
        $username = $this->input->post('username', true);
        $password = $this->input->post('password');
        $nama_user = $this->input->post('nama_user', true);
        $lokasi = $this->input->post('lokasi'); // array


        // 1. Cek username unik
        if ($this->M_user->cek_username($username) > 0) {
            $this->session->set_flashdata('swal', [
                'type'  => 'error',
                'title' => 'Gagal disimpan',
                'text'  => 'Username sudah digunakan!'
            ]);
            redirect('C_data_user/tambah_form');
            return;
        }

        // 2. Cek password sama
        // if ($password !== $password_konfirmasi) {
        //     $this->session->set_flashdata('error', 'Password dan konfirmasi password tidak sama!');
        //     redirect('C_data_user/tambah_form');
        //     return;
        // }

        // 3. Simpan user
        $data_user = array(
            'username'  => $username,
            //'password'  => password_hash($password, PASSWORD_DEFAULT), // lebih aman
            'password'  => $password, // lebih aman
            'nama_user' => $nama_user,
            'id_unit'   => $this->session->userdata('id_unit')
        );

        $insert = $this->M_user->insert_user($data_user);

        if (!$insert) {
        // Ambil error DB
        $error = $this->db->error();

        // 1062 = Duplicate entry (MySQL)
        if ($error['code'] == 1062) {
                // Artinya kemungkinan besar karena double klik
                // Kita anggap SUKSES, karena data sudah masuk dari request pertama

                $this->session->set_flashdata('swal', [
                    'type'  => 'success',
                    'title' => 'Berhasil',
                    'text'  => 'Data TAD berhasil ditambahkan.'
                ]);

                // Update PIC lokasi jika dipilih
                if (!empty($lokasi)) {
                    foreach ($lokasi as $id_lokasi) {
                        // Set user baru sebagai PIC di lokasi tsb
                        $this->M_user->update_pic_lokasi($id_lokasi, $username);
                    }
                    
                }
                redirect('C_data_user');
            } else {
                // Error lain (beneran gagal)
                $this->session->set_flashdata('swal', [
                    'type'  => 'error',
                    'title' => 'Gagal',
                    'text'  => 'Gagal menyimpan data!'
                ]);
                redirect('C_data_user/tambah_form');
                return;
            }
        }

        // Update PIC lokasi jika dipilih
        if (!empty($lokasi)) {
            foreach ($lokasi as $id_lokasi) {
                // Set user baru sebagai PIC di lokasi tsb
                $this->M_user->update_pic_lokasi($id_lokasi, $username);
            }
            
        }

        $this->session->set_flashdata('swal', [
            'type'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Data TAD berhasil ditambahkan.'
        ]);
        redirect('C_data_user');
    }

    public function update()
    {
        $username   = $this->input->post('username', true);
        $password   = $this->input->post('password'); // boleh kosong
        $nama_user  = $this->input->post('nama_user', true);
        $lokasi     = $this->input->post('lokasi'); // array id_lokasi

        if (empty($username) || empty($nama_user)) {
            $this->session->set_flashdata('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Data tidak lengkap.'
            ]);
            redirect('C_data_user');
            return;
        }

        // Mulai transaksi biar aman
        $this->db->trans_begin();

        try {
            // 1. Update data user
            $data_update = [
                'nama_user' => $nama_user
            ];

            if (!empty($password)) {
                // Kalau mau aman, pakai hash:
                // $data_update['password'] = password_hash($password, PASSWORD_DEFAULT);
                $data_update['password'] = $password;
            }

            $this->db->where('username', $username);
            $this->db->update('user', $data_update);

            // 2. Reset PIC lama yang pakai username ini
            $this->db->where('pic', $username);
            $this->db->update('lokasi', ['pic' => null]);

            // 3. Set PIC baru sesuai checklist
            if (!empty($lokasi)) {
                foreach ($lokasi as $id_lokasi) {
                    $this->db->where('id_lokasi', $id_lokasi);
                    $this->db->update('lokasi', ['pic' => $username]);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal update data');
            }

            $this->db->trans_commit();

            $this->session->set_flashdata('swal', [
                'type'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Data TAD berhasil diupdate.'
            ]);

            redirect('C_data_user');

        } catch (Exception $e) {

            $this->db->trans_rollback();

            $this->session->set_flashdata('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Terjadi kesalahan saat menyimpan data.'
            ]);

            redirect('C_data_user');
        }
    }

}
