<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_titik_patroli extends CI_Model
{
    private $table = 'titik_patroli';

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_units()
    {
        return $this->db->get('unit')->result();
    }

     // Ambil semua titik berdasarkan unit satpam
    public function get_by_unit($id_unit) {
        return $this->db->where('id_unit', $id_unit)
                        ->order_by('nama_titik', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    // Ambil satu titik berdasarkan ID
    public function get_by_id($id_titik) {
        return $this->db->where('id_titik', $id_titik)
                        ->get($this->table)
                        ->row();
    }

    public function count_by_unit($id_unit)
    {
        return $this->db->where('id_unit', $id_unit)->count_all_results('titik_patroli');
    }
}
