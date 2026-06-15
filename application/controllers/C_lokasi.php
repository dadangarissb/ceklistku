<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_lokasi extends CI_Controller
{
    protected $id_user;
    protected $id_unit;

    function __construct()
    {
        parent::__construct();
        $this->load->model(['M_lokasi','M_user','M_pekerjaan']);
        $this->load->library('form_validation');
        // $this->load->library('template');
        // $this->load->library('Simple_login');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));

        // Ambil session sekali saja
        $this->id_user = $this->session->userdata('id_user');
        $this->id_unit = $this->session->userdata('id_unit');

        // Verifikasi login
        if (empty($this->id_user) || empty($this->id_unit))
        {
            redirect('C_login');
            exit;
        }
    }

    public function index()
    {
        $data_lokasi = $this->M_lokasi->get_by_unit($id_unit);
        $data = array(
            'data_lokasi' => $data_lokasi
        );
      
        // Tampilkan halaman tambah titik patroli
        $this->template->display('admin/v_lokasi_list', $data);
    }

    public function list_sub_lokasi($id_kelompok_lokasi)
    {

        $kelompok = $this->M_lokasi->get_kelompok_lokasi_by_id($id_kelompok_lokasi);
        $data_user = $this->M_user->get_all_by_id_unit($this->id_unit);
        $kategori_pekerjaan = $this->M_pekerjaan->get_kategori_pekerjaan_by_unit($this->id_unit);

        $unit = $this->db->where('id_unit', $this->id_unit)->get('unit')->row();
        $kelompok = $this->db->where('id_kelompok_lokasi', $id_kelompok_lokasi)->get('kelompok_lokasi')->row();

        if (!$kelompok)
        {
            show_404();
        }

        $data = array(
            'kelompok'    => $kelompok,
            'data_lokasi' => $this->M_lokasi->get_by_kelompok_lokasi($this->id_unit,$id_kelompok_lokasi),
            'data_user' => $data_user,
            'kategori_pekerjaan' => $kategori_pekerjaan,
            'id_kelompok_lokasi' => $id_kelompok_lokasi,
        );

        $data['nama_kelompok_lokasi'] = $kelompok->nama_kelompok_lokasi;
        $data['nama_unit'] = $unit->nama_unit;


        $this->template->display('admin/v_lokasi_list',$data);
    }

    public function kelompok_lokasi()
    {
        $id_unit = $this->session->userdata('id_unit');
        $id_user = $this->session->userdata('id_user');

        if (empty($id_unit) || empty($id_user))
        {
            redirect('C_login');
            return;
        }

        $data['data_kelompok_lokasi']
            = $this->M_lokasi->get_kelompok_lokasi($id_unit);

        $this->template->display('admin/v_kelompok_lokasi_list',$data);
    }

    public function simpan_kelompok_lokasi()
    {
        $nama_kelompok_lokasi = trim($this->input->post('nama_kelompok_lokasi', TRUE));

        // Validasi
        if(empty($nama_kelompok_lokasi))
        {
            $this->session->set_flashdata('error', 'Nama kelompok lokasi wajib diisi');
            redirect('C_lokasi/kelompok_lokasi');
        }

        // Cek duplikasi
        $cek = $this->db->get_where(
            'kelompok_lokasi',
            array(
                'nama_kelompok_lokasi' => $nama_kelompok_lokasi,
                'id_unit' => $this->id_unit
            )
        )->row();

        if($cek)
        {
            $this->session->set_flashdata(
                'error',
                'Kelompok lokasi sudah terdaftar'
            );

            redirect('C_lokasi/kelompok_lokasi');
        }

        // Simpan data
        $data = array(
            'nama_kelompok_lokasi' => $nama_kelompok_lokasi,
            'id_unit' => $this->id_unit
        );

        if($this->db->insert('kelompok_lokasi', $data))
        {
            $this->session->set_flashdata(
                'success',
                'Kelompok lokasi berhasil ditambahkan'
            );
        }
        else
        {
            $this->session->set_flashdata(
                'error',
                'Gagal menyimpan data'
            );
        }

        redirect('C_lokasi/kelompok_lokasi');
    }

    public function tambah_sublokasi()
    {
        $id_kelompok_lokasi = $this->input->post('id_kelompok_lokasi', TRUE);
        $nama_lokasi        = trim($this->input->post('nama_lokasi', TRUE));
        $pic                = $this->input->post('pic', TRUE);
        $id_kategori        = $this->input->post('id_kategori', TRUE);

        if(empty($nama_lokasi) || empty($pic) || empty($id_kategori))
        {
            $this->session->set_flashdata('swal_icon', 'warning');
            $this->session->set_flashdata('swal_title', 'Data Belum Lengkap');
            $this->session->set_flashdata('swal_text', 'Semua data wajib diisi.');

            redirect('C_lokasi/list_sub_lokasi/'.$id_kelompok_lokasi);
        }

        // Cek duplikasi lokasi
        if($this->M_lokasi->cek_lokasi($this->id_unit, $nama_lokasi) > 0)
        {
            $this->session->set_flashdata('swal_icon', 'warning');
            $this->session->set_flashdata('swal_title', 'Data Duplikat');
            $this->session->set_flashdata('swal_text', 'Nama lokasi sudah terdaftar.');

            redirect('C_lokasi/list_sub_lokasi/'.$id_kelompok_lokasi);
        }

        $data = array(
            'id_unit'            => $this->id_unit,
            'nama_lokasi'        => $nama_lokasi,
            'id_kategori'        => $id_kategori,
            'pic'                => $pic,
            'id_kelompok_lokasi' => $id_kelompok_lokasi
        );

        if($this->M_lokasi->insert($data))
        {
            $this->session->set_flashdata('swal_icon', 'success');
            $this->session->set_flashdata('swal_title', 'Berhasil');
            $this->session->set_flashdata('swal_text', 'Lokasi berhasil ditambahkan.');
        }
        else
        {
            $this->session->set_flashdata('swal_icon', 'error');
            $this->session->set_flashdata('swal_title', 'Gagal');
            $this->session->set_flashdata('swal_text', 'Gagal menambahkan lokasi.');
        }

        redirect('C_lokasi/list_sub_lokasi/'.$id_kelompok_lokasi);
    }

    public function hapus_sublokasi($id_lokasi)
    {
        // Ambil data lokasi terlebih dahulu
        $lokasi = $this->db
                    ->where('id_lokasi', $id_lokasi)
                    ->get('lokasi')
                    ->row();

        if(!$lokasi)
        {
            $this->session->set_flashdata('swal_icon', 'error');
            $this->session->set_flashdata('swal_title', 'Gagal');
            $this->session->set_flashdata('swal_text', 'Data lokasi tidak ditemukan.');

            redirect('C_lokasi/kelompok_lokasi');
        }

        $id_kelompok_lokasi = $lokasi->id_kelompok_lokasi;

        // Hapus data
        $hapus = $this->db
                    ->where('id_lokasi', $id_lokasi)
                    ->delete('lokasi');

        if($hapus)
        {
            $this->session->set_flashdata('swal_icon', 'success');
            $this->session->set_flashdata('swal_title', 'Berhasil');
            $this->session->set_flashdata('swal_text', 'Data sub lokasi berhasil dihapus.');
        }
        else
        {
            $this->session->set_flashdata('swal_icon', 'error');
            $this->session->set_flashdata('swal_title', 'Gagal');
            $this->session->set_flashdata('swal_text', 'Data sub lokasi gagal dihapus.');
        }

        redirect('C_lokasi/list_sub_lokasi/'.$id_kelompok_lokasi);
    }

    //Untuk Cetak QR Satuan
    public function cetak_qr($id_unit, $id_lokasi)
    {
        $this->load->library('ciqrcode');

        // Ambil data lokasi
        $data_lokasi = $this->M_lokasi->get_by_id($id_lokasi);
        if (!$data_lokasi) {
            show_404();
        }

        // URL untuk QR
        $url = site_url('lokasi/detail/' . $id_unit . '/' . $id_lokasi);

        // Pastikan folder ada
        $dir = FCPATH . 'assets/qr/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Amankan nama file
        $nama_lokasi_safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data_lokasi->nama_lokasi);

        // File QR sementara (PNG)
        $qr_temp = $dir . 'tmp_qr_' . $id_unit . '_' . $id_lokasi . '.png';

        // Generate QR sementara
        $params['data'] = $url;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = $qr_temp;
        $this->ciqrcode->generate($params);

        // ===== Load QR ke canvas =====
        $qr_img = imagecreatefrompng($qr_temp);

        $qr_w = imagesx($qr_img);
        $qr_h = imagesy($qr_img);

        // Ukuran canvas (QR + teks)
        $canvas_w = $qr_w + 40;
        $canvas_h = $qr_h + 90;

        $canvas = imagecreatetruecolor($canvas_w, $canvas_h);

        // Warna
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $black = imagecolorallocate($canvas, 0, 0, 0);

        // Background putih
        imagefilledrectangle($canvas, 0, 0, $canvas_w, $canvas_h, $white);

        // Tempel QR (tengah)
        $qr_x = ($canvas_w - $qr_w) / 2;
        imagecopy($canvas, $qr_img, $qr_x, 20, 0, 0, $qr_w, $qr_h);

        // ===== Teks pakai TTF =====
        $font_path = FCPATH . 'assets/fonts/arial.ttf'; // pastikan file ini ADA

        $text1 = $data_lokasi->nama_lokasi;
        $text2 = 'Scan untuk melihat data';

        // Ukuran font
        $size1 = 14; // NAMA LOKASI (BESAR) 🔥
        $size2 = 11; // Subteks

        // Hitung agar center
        $bbox1 = imagettfbbox($size1, 0, $font_path, $text1);
        $text1_w = $bbox1[2] - $bbox1[0];

        $bbox2 = imagettfbbox($size2, 0, $font_path, $text2);
        $text2_w = $bbox2[2] - $bbox2[0];

        $text1_x = ($canvas_w - $text1_w) / 2;
        $text2_x = ($canvas_w - $text2_w) / 2;

        $text_y1 = 25 + $qr_h + 10;
        $text_y2 = $text_y1 + 20;

        // Tulis teks
        imagettftext($canvas, $size1, 0, $text1_x, $text_y1, $black, $font_path, $text1);
        imagettftext($canvas, $size2, 0, $text2_x, $text_y2, $black, $font_path, $text2);

        // Nama file final (JPG)
        $filename = 'qr_' . $nama_lokasi_safe . '.jpg';
        $final_path = $dir . $filename;

        // Simpan sebagai JPG
        imagejpeg($canvas, $final_path, 95);

        // Bersihkan memory
        imagedestroy($qr_img);
        imagedestroy($canvas);
        @unlink($qr_temp);

        // ===== Force download =====
        if (file_exists($final_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: image/jpeg');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($final_path));
            readfile($final_path);
            exit;
        } else {
            show_error('Gagal membuat file QR Code.');
        }
    }


    //DOWNLOAD QR BERDASARKAN ID KELOMPOK LOKASI
    public function download_all_qr($id_kelompok_lokasi)
    {
        $this->load->library('ciqrcode');
        $this->load->library('zip');

        $data_lokasi = $this->M_lokasi->get_by_kelompok($id_kelompok_lokasi);

        $kelompok_lokasi = $this->M_lokasi->get_kelompok_lokasi_by_id($id_kelompok_lokasi);

        if(empty($data_lokasi))
        {
            show_error('Tidak ada data lokasi.');
        }

        $dir = FCPATH . 'assets/qr/';

        if(!is_dir($dir))
        {
            mkdir($dir, 0777, true);
        }

        $font_path = FCPATH . 'assets/fonts/arial.ttf';

        foreach($data_lokasi as $lokasi)
        {
            $url = site_url(
                'lokasi/detail/' .
                $lokasi->id_unit . '/' .
                $lokasi->id_lokasi
            );

            $nama_lokasi_safe = preg_replace(
                '/[^A-Za-z0-9_\-]/',
                '_',
                $lokasi->nama_lokasi
            );

            $qr_temp = $dir.'tmp_'.$lokasi->id_lokasi.'.png';

            $params['data'] = $url;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = $qr_temp;

            $this->ciqrcode->generate($params);

            // ===== Canvas =====
            $qr_img = imagecreatefrompng($qr_temp);

            $qr_w = imagesx($qr_img);
            $qr_h = imagesy($qr_img);

            $canvas_w = $qr_w + 40;
            $canvas_h = $qr_h + 90;

            $canvas = imagecreatetruecolor($canvas_w, $canvas_h);

            $white = imagecolorallocate($canvas,255,255,255);
            $black = imagecolorallocate($canvas,0,0,0);

            imagefilledrectangle(
                $canvas,
                0,
                0,
                $canvas_w,
                $canvas_h,
                $white
            );

            $qr_x = ($canvas_w - $qr_w) / 2;

            imagecopy(
                $canvas,
                $qr_img,
                $qr_x,
                20,
                0,
                0,
                $qr_w,
                $qr_h
            );

            $text1 = $lokasi->nama_lokasi;
            $text2 = 'Scan untuk melihat data';

            $size1 = 14;
            $size2 = 11;

            $bbox1 = imagettfbbox($size1,0,$font_path,$text1);
            $text1_w = $bbox1[2]-$bbox1[0];

            $bbox2 = imagettfbbox($size2,0,$font_path,$text2);
            $text2_w = $bbox2[2]-$bbox2[0];

            $text1_x = ($canvas_w-$text1_w)/2;
            $text2_x = ($canvas_w-$text2_w)/2;

            $text_y1 = 25 + $qr_h + 10;
            $text_y2 = $text_y1 + 20;

            imagettftext(
                $canvas,
                $size1,
                0,
                $text1_x,
                $text_y1,
                $black,
                $font_path,
                $text1
            );

            imagettftext(
                $canvas,
                $size2,
                0,
                $text2_x,
                $text_y2,
                $black,
                $font_path,
                $text2
            );

            $jpg_file = $dir.'QR_'.$nama_lokasi_safe.'.jpg';

            imagejpeg($canvas,$jpg_file,95);

            imagedestroy($qr_img);
            imagedestroy($canvas);

            @unlink($qr_temp);

            // masukkan ke ZIP
            $this->zip->read_file($jpg_file);
        }

        $this->zip->download(
            'QR_'.$kelompok_lokasi->nama_kelompok_lokasi.'.zip'
        );
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
