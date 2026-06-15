<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_pekerjaan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['M_pekerjaan','M_detail_pekerjaan']);
        $this->load->library('form_validation');
        // $this->load->library('template');
        // $this->load->library('Simple_login');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));
    }

    public function index()
    {
        $id_unit = $this->session->userdata('id_unit');

        $data = array(
            'data_kategori_pekerjaan' => $this->M_pekerjaan->get_all($id_unit),
            'id_unit'                 => $id_unit,
        );

        $this->template->display('admin/v_pekerjaan_list', $data);
    }


    public function read($id_kategori_pekerjaan) 
    {
        $id_user = $this->session->userdata('id_user');
        $id_unit = $this->session->userdata('id_unit');

        $row = $this->M_pekerjaan->get_by_id($id_kategori_pekerjaan);
        $detail_pekerjaan = $this->M_detail_pekerjaan->get_by_id_kategori($id_kategori_pekerjaan);
        
        // --- TAMBAHAN: Ambil data frekuensi ceklist ---
        $this->db->where('id_kategori_pekerjaan', $id_kategori_pekerjaan);
        $this->db->order_by('waktu_awal_cek', 'ASC');
        $list_frekuensi = $this->db->get('freq_ceklist')->result();

        // Hitung durasi untuk setiap baris frekuensi
        foreach ($list_frekuensi as $f) {
            $awal_raw  = strtotime($f->waktu_awal_cek);
            $akhir_raw = strtotime($f->waktu_akhir_cek);
            
            // Format waktu agar hanya Jam:Menit (00:00)
            $f->waktu_awal_menit  = date('H:i', $awal_raw);
            $f->waktu_akhir_menit = date('H:i', $akhir_raw);

            // Hitung Durasi
            $akhir_calc = $akhir_raw;
            if ($akhir_calc < $awal_raw) { $akhir_calc += 86400; }
            $diff  = $akhir_calc - $awal_raw;
            $jam   = floor($diff / 3600);
            $menit = floor(($diff % 3600) / 60);
            
            $f->durasi = $jam . " Jam " . $menit . " Menit";
        }
        // ----------------------------------------------

        if ($row) {
            $data = array(
                'id_kategori_pekerjaan'   => $row->id_kategori_pekerjaan,
                'nama_kategori_pekerjaan' => $row->nama_kategori_pekerjaan,
                'detail_pekerjaan'        => $detail_pekerjaan,
                'list_frekuensi'          => $list_frekuensi, // Kirim variabel baru ini ke view
                'total_frekuensi'         => count($list_frekuensi)
            );
            $this->template->display('admin/v_detail_pekerjaan', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_pekerjaan'));
        }
    }
    
    public function input_detail_pekerjaan_action() 
    {
    // $this->_rules();
    $id_user   = $this->session->userdata('id_user');
    $nama_user = $this->session->userdata('nama_user');
    $id_unit   = $this->session->userdata('id_unit');

    $id_kategori_pekerjaan   = $this->input->post('id_kategori_pekerjaan');
    
   
    $data = array(
        'id_kategori_pekerjaan'    => $id_kategori_pekerjaan,
        'nama_detail_pekerjaan'    => $this->input->post('nama_detail_pekerjaan', TRUE),
    );

        
    // Insert ke tabel detial pekerjaan
    $this->M_detail_pekerjaan->insert($data);

    // ============================
    // 3️⃣ Redirect dan notifikasi
    // ============================
    $this->session->set_flashdata('message', 'Data berhasil diinput!');
    redirect(site_url('C_pekerjaan/read/'.$id_kategori_pekerjaan));

    }

    public function input_waktu_ceklist() {
        $id_kategori = $this->input->post('id_kategori_pekerjaan', TRUE);
        $awal  = $this->input->post('waktu_awal', TRUE);
        $akhir = $this->input->post('waktu_akhir', TRUE);

        if (!empty($awal) && !empty($akhir)) {
            // 1. Validasi Logika Waktu
            if ($akhir < $awal) {
                $this->session->set_flashdata('swal_error', 'Waktu akhir tidak boleh lebih kecil dari waktu awal!');
                redirect(site_url('C_pekerjaan/read/' . $id_kategori));
            }

            // 2. Cek Duplikat (Cegah Double Input)
            $check = $this->db->get_where('freq_ceklist', [
                'id_kategori_pekerjaan' => $id_kategori,
                'waktu_awal_cek'        => $awal,
                'waktu_akhir_cek'       => $akhir
            ]);

            if ($check->num_rows() > 0) {
                $this->session->set_flashdata('swal_warning', 'Data waktu ini sudah terdaftar sebelumnya!');
                redirect(site_url('C_pekerjaan/read/' . $id_kategori));
            }

            // 3. Proses Simpan
            $data = [
                'id_kategori_pekerjaan' => $id_kategori,
                'waktu_awal_cek'        => $awal,
                'waktu_akhir_cek'       => $akhir
            ];

            $simpan = $this->M_pekerjaan->insert_waktu_ceklist($data);

            if ($simpan) {
                $this->session->set_flashdata('swal_success', 'Data waktu ceklist berhasil disimpan!');
            } else {
                $this->session->set_flashdata('swal_error', 'Terjadi kesalahan sistem saat menyimpan data.');
            }
            
        } else {
            $this->session->set_flashdata('swal_error', 'Mohon isi semua form waktu!');
        }

        redirect(site_url('C_pekerjaan/read/' . $id_kategori));
    }

    public function input_kat_pek()
    {
        echo $id_unit = $this->input->post('id_unit', TRUE);
        echo $kategori_pekerjaan = trim($this->input->post('kategori_pekerjaan', TRUE));

        // Validasi
        if (empty($id_unit) || empty($kategori_pekerjaan))
        {
            $this->session->set_flashdata('swal', array(
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Data wajib diisi.'
            ));

            redirect($_SERVER['HTTP_REFERER']);
        }

        // Cek duplikat
        $cek = $this->db
            ->where('id_unit', $id_unit)
            ->where('nama_kategori_pekerjaan', $kategori_pekerjaan)
            ->get('kategori_pekerjaan');

        if ($cek->num_rows() > 0)
        {
            $this->session->set_flashdata('swal', array(
                'icon'  => 'warning',
                'title' => 'Data Sudah Ada',
                'text'  => 'Kategori pekerjaan tersebut sudah terdaftar.'
            ));

            redirect($_SERVER['HTTP_REFERER']);
        }

        // Simpan data
        $data = array(
            'id_unit'             => $id_unit,
            'nama_kategori_pekerjaan'  => $kategori_pekerjaan,
        );

        if ($this->db->insert('kategori_pekerjaan', $data))
        {
            $this->session->set_flashdata('swal', array(
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Data berhasil disimpan.'
            ));
        }
        else
        {
            $this->session->set_flashdata('swal', array(
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Data gagal disimpan.'
            ));
        }

        redirect('C_pekerjaan');
    }

    public function delete_kat_pek($id_kategori_pekerjaan)
    {
        $kategori = $this->M_pekerjaan->get_kategori_by_id($id_kategori_pekerjaan);

        if (!$kategori)
        {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Kategori pekerjaan tidak ditemukan.'
            ]);

            redirect('C_pekerjaan');
        }

        $hapus = $this->M_pekerjaan->delete_kategori_pekerjaan($id_kategori_pekerjaan);

        if ($hapus)
        {
            $this->session->set_flashdata('swal', [
                'icon'  => 'success',
                'title' => 'Berhasil',
                'text'  => 'Kategori pekerjaan berhasil dihapus.'
            ]);
        }
        else
        {
            $this->session->set_flashdata('swal', [
                'icon'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Terjadi kesalahan saat menghapus data.'
            ]);
        }

        redirect('C_pekerjaan');
    }
    



}

/* End of file C_DataUmkm.php */
/* Location: ./application/controllers/C_DataUmkm.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-09-23 10:54:52 */
/* http://harviacode.com */