<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal_patroli extends CI_Model {

    public function get_all($id_unit = null) {
        if ($id_unit) {
            $this->db->where('id_unit', $id_unit);
        }
        return $this->db->get('jadwal_patroli')->result();
    }

    public function get_by_id($id_jadwal) {
        return $this->db->get_where('jadwal_patroli', ['id_jadwal' => $id_jadwal])->row();
    }
    

    public function insert($data) {
        return $this->db->insert('jadwal_patroli', $data);
    }

    public function update($id_jadwal, $data) {
        $this->db->where('id_jadwal', $id_jadwal);
        return $this->db->update('jadwal_patroli', $data);
    }

    public function delete($id_jadwal) {
        $this->db->where('id_jadwal', $id_jadwal);
        return $this->db->delete('jadwal_patroli');
    }

    public function get_by_unit($id_unit)
    {
        return $this->db->where('id_unit', $id_unit)
                        ->order_by('jam_mulai', 'ASC')
                        ->get('jadwal_patroli')
                        ->result();
    }
}
