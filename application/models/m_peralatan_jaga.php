<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class m_peralatan_jaga extends CI_Model
{

    public $table_peralatan = 'peralatan';
    public $id_peralatan = 'id_peralatan';
    public $order = 'DESC';


    function __construct()
    {
        // parent::__construct();
    }

    // get all
    function get_all()
    {
        return $this->db->get($this->table_peralatan)->result();
    }

    // get data by id
    // function get_by_id($id_mutasi_jaga)
    // {
    //     $this->db->where($this->id_mutasi_jaga, $id_mutasi_jaga);
    //     $this->db->join('unit', 'mutasi_jaga.id_unit= unit.id_unit');
    //     return $this->db->get($this->table_mutasi_jaga)->row();
    // }
    
    // // get total rows
    // function total_rows($q = NULL) {
    //     $this->db->like('id_umkm', $q);
	// $this->db->or_like('nama_perusahaan', $q);
	// $this->db->or_like('nama_pimpinan', $q);
	// $this->db->or_like('foto_pimpinan', $q);
	// $this->db->or_like('no_ktp', $q);
	// $this->db->or_like('gambar_ktp', $q);
	// $this->db->or_like('alamat', $q);
	// $this->db->or_like('rt', $q);
	// $this->db->or_like('rw', $q);
	// $this->db->or_like('kelurahan', $q);
	// $this->db->or_like('jenis_usaha', $q);
	// $this->db->or_like('no_siup', $q);
	// $this->db->or_like('no_npwp', $q);
	// $this->db->or_like('no_tdp', $q);
	// $this->db->or_like('pirt', $q);
	// $this->db->or_like('halal', $q);
	// $this->db->or_like('hki', $q);
	// $this->db->or_like('lain1', $q);
	// $this->db->or_like('lain2', $q);
	// $this->db->or_like('spesifikasi_produk', $q);
	// $this->db->or_like('bahan_baku', $q);
	// $this->db->or_like('permasalahan', $q);
	// $this->db->from($this->table);
    //     return $this->db->count_all_results();
    // }

    // // get data with limit and search
    // function get_limit_data($limit, $start = 0, $q = NULL) {
    //     $this->db->order_by($this->id, $this->order);
    //     $this->db->like('id_umkm', $q);
	// $this->db->or_like('nama_perusahaan', $q);
	// $this->db->or_like('nama_pimpinan', $q);
	// $this->db->or_like('foto_pimpinan', $q);
	// $this->db->or_like('no_ktp', $q);
	// $this->db->or_like('gambar_ktp', $q);
	// $this->db->or_like('alamat', $q);
	// $this->db->or_like('rt', $q);
	// $this->db->or_like('rw', $q);
	// $this->db->or_like('kelurahan', $q);
	// $this->db->or_like('jenis_usaha', $q);
	// $this->db->or_like('no_siup', $q);
	// $this->db->or_like('no_npwp', $q);
	// $this->db->or_like('no_tdp', $q);
	// $this->db->or_like('pirt', $q);
	// $this->db->or_like('halal', $q);
	// $this->db->or_like('hki', $q);
	// $this->db->or_like('lain1', $q);
	// $this->db->or_like('lain2', $q);
	// $this->db->or_like('spesifikasi_produk', $q);
	// $this->db->or_like('bahan_baku', $q);
	// $this->db->or_like('permasalahan', $q);
	// $this->db->limit($limit, $start);
    //     return $this->db->get($this->table)->result();
    // }

    // // insert data
    // function insert($data)
    // {
    //     $this->db->insert($this->table, $data);
    // }

    // // update data
    // function update($id, $data)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->update($this->table, $data);
    // }

    // // delete data
    // function delete($id)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->delete($this->table);
    // }

    // function cek_register($data){       
    //     //return $this->db->get_where($table,$where);
    //     $this->db->where($this->email, $data['email']);
    //     //$this->db->where($this->password, $data['password']);
    //     $query=$this->db->get($this->table);

    //      if ($query->num_rows() > 0) {
    //         return $query->result();
    //     }
    // }   

    // function cek_register2($data){      
    //     //return $this->db->get_where($table,$where);
    //     $this->db->where($this->nama_perusahaan, $data['nama_perusahaan']);
    //     //$this->db->where($this->password, $data['password']);
    //     $query=$this->db->get($this->table);

    //      if ($query->num_rows() > 0) {
    //         return $query->result();
    //     }
    // }
    // public function ambil_kelurahan($kode_kec){
    //     $this->db->where('id_kecamatan',$kode_kec);
    //     $this->db->order_by('nama_kelurahan','asc');
    //     $sql_kelurahan=$this->db->get($this->kelurahan);
    //     if($sql_kelurahan->num_rows()>0){

    //     foreach ($sql_kelurahan->result_array() as $row)
    //     {
    //         $result[$row['id_kelurahan']]= ucwords(strtolower($row['nama_kelurahan']));
    //     }
    //     } else {
    //        $result['-']= '- Belum Ada Kelurahan -';
    //     }
    //     return $result;
    // }

    // public function ambil_kecamatan() {
    //     //$this->db->insert($this->table, $data);
    // $sql_kecamatan=$this->db->get($this->table2);    
    // if($sql_kecamatan->num_rows()>0){
    //     foreach ($sql_kecamatan->result_array() as $row)
    //         {
    //             $result['-']= '- Pilih Kecamatan -';
    //             $result[$row['id_kecamatan']]= ucwords(strtolower($row['nama_kecamatan']));
    //         }
    //         return $result;
    //     }
    // }
    
}

/* End of file M_DataUmkm.php */
/* Location: ./application/models/M_DataUmkm.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-09-23 10:54:52 */
/* http://harviacode.com */