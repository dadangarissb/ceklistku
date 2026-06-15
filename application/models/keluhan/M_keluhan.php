<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keluhan extends CI_Model {

    public function get_all_keluhan() {
        return $this->db->order_by('tgl_laporan', 'DESC')->get('keluhan')->result_array();
    }

    public function insert_keluhan($data) {
        return $this->db->insert('keluhan', $data);
    }

    public function update_keluhan($id, $data) {
        return $this->db->where('id_keluhan', $id)->update('keluhan', $data);
    }
}