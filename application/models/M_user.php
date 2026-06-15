<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_user extends CI_Model
{

    // public $table_satpam = 'peralatan';
    // public $id_peralatan = 'id_peralatan';
    public $order = 'DESC';


    function __construct()
    {
        // parent::__construct();
    }

    //get all by id unit
    public function get_all_by_id_unit($id_unit)
    {
        $this->db->select('user.*, unit.nama_unit');
        $this->db->from('user');
        $this->db->join('unit', 'user.id_unit = unit.id_unit');
        $this->db->where('user.id_unit', $id_unit);

        return $this->db->get()->result();
    }

    public function get_lokasi_by_user($username)
    {
        $this->db->select('id_lokasi, nama_lokasi');
        $this->db->from('lokasi');
        $this->db->where('pic', $username);

        return $this->db->get()->result();
    }


    function get_nama_unit($id_unit)
    {
		 return $this->db->get_where('unit', ['id_unit' => $id_unit])->row()->nama_unit ?? null;
	}	

    public function get_all_lokasi_with_pic_by_unit($id_unit)
    {
        $this->db->select('l.id_lokasi, l.nama_lokasi, l.pic, u.nama_user AS nama_pic');
        $this->db->from('lokasi l');
        $this->db->join('user u', 'l.pic = u.username', 'left');
        $this->db->where('l.id_unit', $id_unit);
        return $this->db->get()->result();
    }

    public function update_pic_lokasi($id_lokasi, $username)
    {
        return $this->db->where('id_lokasi', $id_lokasi)
                        ->update('lokasi', array('pic' => $username));
    }

    public function cek_username($username)
    {
        return $this->db->where('username', $username)
                        ->from('user')
                        ->count_all_results();
    }

    public function insert_user($data)
    {
        return $this->db->insert('user', $data); // ganti nama tabel kalau beda
    }

    public function get_all_lokasi_by_unit($id_unit)
    {
        return $this->db->where('id_unit', $id_unit)
                        ->get('lokasi')
                        ->result();
    }

    public function cek_username_exist($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('user')->num_rows(); // ganti 'user' sesuai nama tabel kamu
    }

    public function get_user_by_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }




}
