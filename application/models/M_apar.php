<?php
class M_apar extends CI_Model {

    // Ambil semua data APAR
    public function get_all_apar() {
        return $this->db->get('apar')->result_array();
    }

    // Ambil detail satu APAR beserta riwayat ceklistnya (JOIN)
    public function get_apar_with_history($id) {
        $this->db->select('apar.*, ceklist_apar.*');
        $this->db->from('apar');
        $this->db->join('ceklist_apar', 'apar.id_apar = ceklist_apar.id_apar', 'left');
        $this->db->where('apar.id_apar', $id);
        $this->db->order_by('ceklist_apar.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert_apar($data) {
        return $this->db->insert('apar', $data);
    }

    public function insert_ceklist($data) {
        return $this->db->insert('ceklist_apar', $data);
    }
}