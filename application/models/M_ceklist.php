<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ceklist extends CI_Model {

    private $tabel = 'ceklist_harian';

    public function get_rekap_ceklist_by_unit($id_unit, $tgl_awal = null, $tgl_akhir = null, $nama_tad = null)
    {
        $this->db->select('
            l.id_lokasi,
            l.nama_lokasi,
            c.nama_user,
            c.tgl_ceklist,

            COUNT(DISTINCT CASE 
                WHEN c.status = "sudah" THEN c.id_detail_pekerjaan 
            END) AS sudah_ceklist,

            COUNT(DISTINCT dp.id_detail_pekerjaan) AS total_seharusnya
        ');

        // Tabel utama
        $this->db->from('ceklist_harian c');

        // Join lokasi
        $this->db->join('lokasi l', 'l.id_lokasi = c.id_lokasi', 'inner');

        // Join master pekerjaan
        $this->db->join('kategori_pekerjaan kp', 'kp.id_kategori_pekerjaan = l.id_kategori', 'inner');
        $this->db->join('detail_pekerjaan dp', 'dp.id_kategori_pekerjaan = kp.id_kategori_pekerjaan', 'inner');

        // Filter unit
        $this->db->where('l.id_unit', $id_unit);

        // Filter tanggal (opsional)
        if (!empty($tgl_awal)) {
            $this->db->where('c.tgl_ceklist >=', $tgl_awal);
        }
        if (!empty($tgl_akhir)) {
            $this->db->where('c.tgl_ceklist <=', $tgl_akhir);
        }

        // Filter nama TAD (opsional)
        if (!empty($nama_tad)) {
            $this->db->like('c.nama_user', $nama_tad);
        }

        // 🔹 Grouping penting
        $this->db->group_by('l.id_lokasi');
        $this->db->group_by('c.nama_user');
        $this->db->group_by('c.tgl_ceklist');

        $this->db->order_by('c.tgl_ceklist', 'DESC');
        $this->db->order_by('l.nama_lokasi', 'ASC');

        return $this->db->get()->result();
    }


    public function get_monitoring_pic($username)
    {
        // 1. Ambil semua lokasi yang ditugaskan ke PIC ini
        $this->db->select('l.*, k.nama_kategori_pekerjaan');
        $this->db->from('lokasi l'); 
        $this->db->join('kategori_pekerjaan k', 'l.id_kategori = k.id_kategori_pekerjaan');
        $this->db->where('l.pic', $username);
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            // 2. Hitung TARGET (Berapa kali harus ceklist di tabel freq_ceklist)
            $this->db->where('id_kategori_pekerjaan', $row->id_kategori);
            $row->target_cek = $this->db->count_all_results('freq_ceklist');

            // 3. Hitung REALISASI (Berapa kali sudah input di tabel id_ceklist HARI INI)
            $this->db->where('id_lokasi', $row->id_lokasi);
            $this->db->where('tgl_ceklist', date('Y-m-d'));
            // Jika di tabel id_ceklist kamu menyimpan per detail_pekerjaan, 
            // kita gunakan DISTINCT atau GROUP BY agar dihitung 1 sesi saja
            $this->db->group_by('created_at'); 
            $row->realisasi_hari_ini = $this->db->get('ceklist_harian')->num_rows(); 
        }

        return $query;
    }


    // public function get_rekap_ceklist_by_username($username)
    // {
    //     $this->db->select('
    //         l.id_lokasi,
    //         l.nama_lokasi,
    //         COUNT(DISTINCT CASE 
    //             WHEN ch.status = "sudah" THEN ch.id_detail_pekerjaan 
    //         END) AS sudah_ceklist,
    //         COUNT(DISTINCT dp.id_detail_pekerjaan) AS total_seharusnya
    //     ');

    //     $this->db->from('lokasi l');

    //     $this->db->join(
    //         'kategori_pekerjaan kp',
    //         'kp.id_kategori_pekerjaan = l.id_kategori',
    //         'inner'
    //     );

    //     $this->db->join(
    //         'detail_pekerjaan dp',
    //         'dp.id_kategori_pekerjaan = kp.id_kategori_pekerjaan',
    //         'inner'
    //     );

    //     $this->db->join(
    //         'ceklist_harian ch',
    //         'ch.id_lokasi = l.id_lokasi
    //         AND ch.id_detail_pekerjaan = dp.id_detail_pekerjaan
    //         AND ch.username = '.$this->db->escape($username).'
    //         AND ch.tgl_ceklist = CURDATE()',
    //         'left'
    //     );

    //     $this->db->group_by('l.id_lokasi');

    //     return $this->db->get()->result();
    // }


    public function insert($data) {
        return $this->db->insert($this->tabel, $data);
    }


}
