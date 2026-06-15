<?php 

class M_login extends CI_Model{	
	// public $tabel_user = 'user';

	function cek_login_admin($data){		
		//return $this->db->get_where($table,$where);
		$this->db->where('id_user', $data['id_user']);
		$this->db->where('password', $data['password']);
		$query=$this->db->get('admin');
		return $query;
		// if ($query->num_rows() > 0) {
        //     return $query;
        // }
	}	

	function cek_login_user($data){		
		//return $this->db->get_where($table,$where);
		$this->db->where('username', $data['id_user']);
		$this->db->where('password', $data['password']);
		$query=$this->db->get('user');
		return $query;
		// if ($query->num_rows() > 0) {
        //     return $query;
        // }
	}	

	function cek_id($data){		
		//return $this->db->get_where($table,$where);
		$this->db->where($this->email, $data['email']);
		//$this->db->where($this->password, $data['password']);
		return $this->db->get($this->table)->row();
	}	

}

// function get_allimage($id_umkm) {
//         $this->db->where($this->id_umkm, $id_umkm);
//         //$this->db->from($this->table);
// 		$query = $this->db->get($this->table);

//         //cek apakah ada data
//         if ($query->num_rows() > 0) {
//             return $query->result();
//         }
// 	}