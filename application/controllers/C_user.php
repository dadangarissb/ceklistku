<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['M_pekerjaan','M_ceklist','M_lokasi']);
        $this->load->library('form_validation');
        // $this->load->library('template');
        // $this->load->library('Simple_login');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));

        $username = $this->session->userdata('username'); 
        if (!$username) {
            redirect('C_login');
        }
    }

    public function scan_ceklist()
    {
         $this->template->user('user/v_scan');
    }

    public function list_lokasi_user($username)
    {
        // Pastikan session username sesuai dengan kolom 'pic' di tabel lokasi
        $username = $this->session->userdata('username'); 

        if (!$username) {
            redirect('login');
        }

        $data['lokasi_tugas'] = $this->M_ceklist->get_monitoring_pic($username);

        $this->template->user('user/v_lokasi_user_list', $data);
    }

    public function form_ceklist_user($id_unit, $id_lokasi)
    {
        // 1. SETTING ZONA WAKTU MUTLAK (Sangat Penting!)
        // Ini memastikan jam PHP sama dengan jam di sudut kanan bawah komputer Anda (WIB)
        date_default_timezone_set('Asia/Jakarta');

        $username = $this->session->userdata('username');
        $today    = date('Y-m-d');
        
        // Ambil jam sekarang dan langsung ubah ke angka integer (timestamp)
        $now_string = date('H:i:s');
        $time_now   = strtotime($now_string); 

        // ... (kode ambil lokasi dan uraian tugas tetap sama) ...
        $lokasi = $this->db->get_where('lokasi', ['id_lokasi' => $id_lokasi])->row();
        $data['uraian_tugas'] = $this->db->get_where('detail_pekerjaan', ['id_kategori_pekerjaan' => $lokasi->id_kategori])->result();
        
        $jadwal_sesi = $this->db->get_where('freq_ceklist', ['id_kategori_pekerjaan' => $lokasi->id_kategori])->result();

        foreach ($jadwal_sesi as $sesi) {
            $cek = $this->db->get_where('ceklist_harian', [
                'id_lokasi'       => $id_lokasi,
                'tgl_ceklist'     => $today,
                'id_freq_ceklist' => $sesi->id_freq_ceklist
            ])->row();

            if ($cek) {
                $sesi->status_cek = 'sudah';
            } else {
                $sesi->status_cek = 'belum';
                
                // 2. LOGIKA WAKTU YANG PASTI BISA (Ubah batas awal & akhir ke angka integer)
                $waktu_awal  = strtotime($sesi->waktu_awal_cek);
                $waktu_akhir = strtotime($sesi->waktu_akhir_cek);

                // 3. BANDINGKAN ANGKANYA
                if ($time_now >= $waktu_awal && $time_now <= $waktu_akhir) {
                    $sesi->boleh_input = true;  // Tombol Aktif (Biru)
                } else {
                    $sesi->boleh_input = false; // Tombol Terkunci (Abu-abu)
                }
            }
        }

        $data['nama_lokasi'] = $lokasi->nama_lokasi;
        $data['id_lokasi']   = $id_lokasi;
        $data['username']    = $username;
        $data['jadwal_sesi'] = $jadwal_sesi;

        $this->template->user('user/v_form_ceklist_user', $data);
    }

    public function proses_konfirmasi($id_lokasi, $id_freq_ceklist)
    {
        
        date_default_timezone_set('Asia/Jakarta');

        $username = $this->session->userdata('username');
        // $nama_user = $this->session->userdata('nama_lengkap'); // Pastikan session ini ada saat login

        if (!$username) {
            redirect('C_login');
        }

        $today = date('Y-m-d');

        // --- PROTEKSI: CEK DOUBLE INPUT ---
        $this->db->where([
            'id_lokasi'       => $id_lokasi,
            'tgl_ceklist'     => $today,
            'id_freq_ceklist' => $id_freq_ceklist
        ]);
        $cek_sudah_ada = $this->db->get('ceklist_harian')->num_rows();

        if ($cek_sudah_ada > 0) {
            $this->session->set_flashdata('error', 'Sesi ini sudah dikonfirmasi!');
            redirect('C_user/list_lokasi_user/'.$username);
            return; 
        }

        // --- PROSES SIMPAN 1 BARIS SAJA ---
        $data_simpan = [
            'id_lokasi'       => $id_lokasi,
            'tgl_ceklist'     => $today,
            'id_freq_ceklist' => $id_freq_ceklist,
            'username'        => $username,
            // 'nama_user'       => $nama_user, // Nama petugas ikut disimpan
            'status'          => 'sudah',
            'created_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('ceklist_harian', $data_simpan)) {
            $this->session->set_flashdata('success', 'Konfirmasi berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan konfirmasi.');
        }

        redirect('C_user/list_lokasi_user/'.$username);
    }




}
