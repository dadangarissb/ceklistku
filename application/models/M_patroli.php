<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_patroli extends CI_Model {

    private $tabel = 'patroli';

    public function insert($data) {
        return $this->db->insert($this->tabel, $data);
    }

    public function get_titik_patroli() {
        return $this->db->get('titik_patroli')->result();
    }

    // Hitung jarak antara dua koordinat (dalam meter)
    public function cek_titik_patroli($id_titik, $latitude, $longitude) {
        $titik = $this->db->get_where('titik_patroli', ['id_titik' => $id_titik])->row();
        if (!$titik) return false;

        $earthRadius = 6371000; // meter
        $dLat = deg2rad($latitude - $titik->latitude);
        $dLon = deg2rad($longitude - $titik->longitude);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($titik->latitude)) * cos(deg2rad($latitude)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return ($distance <= $titik->radius);
    }

    //untuk mengecek apakah titik ini sudah dilakukan patroli atau belum
    public function get_status_titik($id_jadwal, $id_titik, $id_unit)
    {
        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->where('id_titik', $id_titik);
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->get('patroli');

        // Jika data ditemukan berarti titik ini sudah dilakukan patroli
        if ($query->num_rows() > 0) {
            return 'complete';
        } else {
            return 'pending';
        }
    }
    
    public function get_jadwal_aktif($id_unit)
    {
        $jam_sekarang = date('H:i:s');
        $this->db->where('id_unit', $id_unit);
        $this->db->where('jam_mulai <=', $jam_sekarang);
        $this->db->where('jam_selesai >=', $jam_sekarang);
        return $this->db->get('jadwal_patroli')->row();
    }

    public function count_titik_by_unit($id_unit)
    {
        return $this->db->where('id_unit', $id_unit)->count_all_results('titik_patroli');
    }

    public function count_patroli_selesai($id_jadwal, $id_unit)
    {
        return $this->db->where('id_jadwal', $id_jadwal)
                        ->where('id_unit', $id_unit)
                        ->count_all_results('patroli');
    }
}
