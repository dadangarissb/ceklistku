<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class m_satpam extends CI_Model
{

    // public $table_satpam = 'peralatan';
    // public $id_peralatan = 'id_peralatan';
    public $order = 'DESC';


    function __construct()
    {
        // parent::__construct();
    }

    // // get all
    // function get_all()
    // {
    //     return $this->db->get($this->table_peralatan)->result();
    // }

    //get all by id unit
    function get_all_by_id_unit($id_unit)
    {
        $this->db->select('unit_satpam.*, satpam.nama_satpam, unit.nama_unit');
        $this->db->from('unit_satpam');
        $this->db->join('satpam', 'unit_satpam.id_satpam = satpam.id_satpam');
        $this->db->join('unit', 'unit_satpam.id_unit = unit.id_unit');
        $this->db->where('unit.id_unit', $id_unit);

        return $this->db->get()->result();
    }

    
    
}
