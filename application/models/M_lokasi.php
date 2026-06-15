<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lokasi extends CI_Model
{
    private $table = 'lokasi';

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function insert($data)
    {
        return $this->db->insert('lokasi', $data);
    }

    public function cek_lokasi($id_unit, $nama_lokasi)
    {
        return $this->db
                    ->where('id_unit', $id_unit)
                    ->where('nama_lokasi', $nama_lokasi)
                    ->count_all_results('lokasi');
    }

    public function get_by_unit($id_unit)
    {
        return $this->db
            // Tentukan kolom secara spesifik dan beri alias jika perlu
            ->select('l.*, u.nama_user, kp.nama_kategori_pekerjaan, kl.nama_kelompok_lokasi')
            ->from('lokasi as l')

            // JOIN USER
            ->join(
                'user as u',
                'u.username = l.pic AND u.id_unit = l.id_unit',
                'left'
            )

            // JOIN KATEGORI PEKERJAAN
            ->join(
                'kategori_pekerjaan as kp',
                'kp.id_kategori_pekerjaan = l.id_kategori AND kp.id_unit = l.id_unit',
                'left'
            )

            // JOIN KELOMPOK LOKASI
            ->join(
                'kelompok_lokasi as kl',
                'kl.id_kelompok_lokasi = l.id_kelompok_lokasi AND kl.id_unit = l.id_unit',
                'left'
            )

            ->where('l.id_unit', $id_unit)
            ->order_by('l.id_lokasi', 'ASC')
            ->get()
            ->result();
    }

    // Ambil satu titik berdasarkan ID
    public function get_by_id($id_lokasi) {
        return $this->db->where('id_lokasi', $id_lokasi)
                        ->get($this->table)
                        ->row();
    }

    public function get_by_username($username)
    {
        $this->db->from('lokasi');           // pastikan query dari tabel lokasi
        $this->db->where('pic', $username);  // filter berdasarkan username
        return $this->db->get()->result();      // eksekusi dan ambil hasil
    }

    public function get_kelompok_lokasi($id_unit)
    {
        $this->db->select('
            kl.id_kelompok_lokasi,
            kl.nama_kelompok_lokasi,
            kl.id_unit,
            COUNT(l.id_lokasi) AS jumlah_sub_lokasi
        ');

        $this->db->from('kelompok_lokasi kl');

        $this->db->join(
            'lokasi l',
            'l.id_kelompok_lokasi = kl.id_kelompok_lokasi',
            'left'
        );

        $this->db->where('kl.id_unit', $id_unit);

        $this->db->group_by(array(
            'kl.id_kelompok_lokasi',
            'kl.nama_kelompok_lokasi',
            'kl.id_unit'
        ));

        $this->db->order_by('kl.nama_kelompok_lokasi', 'ASC');

        return $this->db->get()->result();
    }

    public function get_rekap_kondisi() {
        $this->db->select('
            m.nama_kelompok_lokasi, 
            COUNT(CASE WHEN t.kondisi = "baik" THEN 1 END) as jumlah_baik,
            COUNT(CASE WHEN t.kondisi = "rusak" THEN 1 END) as jumlah_rusak,
            GROUP_CONCAT(CASE WHEN t.kondisi = "rusak" AND t.keterangan != "" THEN t.keterangan END SEPARATOR ", ") as detail_kerusakan
        ');
        $this->db->from('kelompok_lokasi m'); // Tabel Wisma (Gambar 2)
        $this->db->join('lokasi t', 'm.id_kelompok_lokasi = t.id_kelompok_lokasi', 'left'); // Tabel Kondisi (Gambar 1)
        $this->db->group_by('m.id_kelompok_lokasi');
        $this->db->order_by('m.id_kelompok_lokasi', 'ASC');
        
        return $this->db->get()->result_array();
    }


    public function get_by_kelompok_lokasi($id_unit, $id_kelompok_lokasi)
    {
        return $this->db
            ->select('
                l.*,
                u.nama_user,
                kp.nama_kategori_pekerjaan,
                kl.nama_kelompok_lokasi
            ')
            ->from('lokasi l')

            ->join(
                'user u',
                'u.username = l.pic AND u.id_unit = l.id_unit',
                'left'
            )

            ->join(
                'kategori_pekerjaan kp',
                'kp.id_kategori_pekerjaan = l.id_kategori AND kp.id_unit = l.id_unit',
                'left'
            )

            ->join(
                'kelompok_lokasi kl',
                'kl.id_kelompok_lokasi = l.id_kelompok_lokasi',
                'left'
            )

            ->where('l.id_unit', $id_unit)
            ->where('l.id_kelompok_lokasi', $id_kelompok_lokasi)

            ->order_by('l.nama_lokasi', 'ASC')

            ->get()
            ->result();
    }

    public function get_kelompok_lokasi_by_id($id_kelompok_lokasi)
    {
        return $this->db
            ->where('id_kelompok_lokasi', $id_kelompok_lokasi)
            ->get('kelompok_lokasi')
            ->row();
    }

    //GET LOKASI BY ID KELOMPOK UNTUK CETAK SEMUA QR
    public function get_by_kelompok($id_kelompok_lokasi)
    {
        return $this->db
                    ->where('id_kelompok_lokasi', $id_kelompok_lokasi)
                    ->get('lokasi')
                    ->result();
    }

    public function delete($id_lokasi)
    {
        return $this->db
                    ->where('id_lokasi', $id_lokasi)
                    ->delete('lokasi');
    }

}
