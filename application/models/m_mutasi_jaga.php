<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class m_mutasi_jaga extends CI_Model
{

    public $tabel_mutasi_jaga = 'mutasi_jaga';
    public $tabel_approval = 'approval_mutasi';
    public $tabel_mutasi_peralatan = 'mutasi_peralatan';
    public $id_mutasi_jaga = 'id_mutasi_jaga';
    public $id_mutasi_peralatan = 'id_mutasi_peralatan';
    public $order = 'DESC';


    function __construct()
    {
        // parent::__construct();
    }

    // get all
    function get_all()
    {
        // $this->db->join('jenis_usaha', 'data_umkm.id_jenis_usaha= jenis_usaha.id_jenis_usaha');
        // $this->db->join('kelurahan', 'data_umkm.id_kelurahan= kelurahan.id_kelurahan');
        //$this->db->like('status', 'Ditolak');
        return $this->db->get($this->tabel_mutasi_jaga)->result();
    }

    function get_mutasi_peralatan($id_mutasi_jaga)
    {
        // $this->db->order_by($this->id, $this->order);
        $this->db->where('id_mutasi_jaga', $id_mutasi_jaga);
        return $this->db->get($this->tabel_mutasi_peralatan)->result();
    }

    // get data by id
    function get_by_id($id_mutasi_jaga)
    {
        $this->db->where($this->id_mutasi_jaga, $id_mutasi_jaga);
        $this->db->join('unit', 'mutasi_jaga.id_unit= unit.id_unit');
        return $this->db->get($this->tabel_mutasi_jaga)->row();
    }

    function get_data_approval($id_mutasi_jaga)
    {
        //  $this->db->select('
        // am.*,
        // s.nama_satpam AS nama_petugas_terima,
        // u1.username AS nama_approver_1,
        // u2.username AS nama_approver_2
        // ');
        // $this->db->from('approval_mutasi AS am');
        
        // Join ke tabel satpam (petugas terima)
        $this->db->join('satpam', 'approval_mutasi.id_petugas_terima = satpam.id_satpam', 'left');

        // Join ke tabel user untuk approver 1 dan approver 2
        // $this->db->join('user AS u1', 'am.id_approver_1 = u1.id_user', 'left');
        // $this->db->join('user AS u2', 'am.id_approver_2 = u2.id_user', 'left');

        // Filter berdasarkan id mutasi jaga
        // $this->db->where('am.id_mutasi_jaga', $id_mutasi_jaga);

        $this->db->where($this->id_mutasi_jaga, $id_mutasi_jaga);
        return $this->db->get($this->tabel_approval)->row();
    }

    function get_approver_1_by_id_unit($id_unit)
    {
        $this->db->where('admin.id_unit', $id_unit);
        $this->db->where('admin.role', "approver 1");
        return $this->db->get('admin')->row();
    }

    function get_approver_2_by_id_unit($id_unit)
    {
        $this->db->where('admin.id_unit', $id_unit);
        $this->db->where('admin.role', "approver 2");
        return $this->db->get('admin')->row();
    }
    

    public function insert_mutasi($data)
    {
        $this->db->insert('mutasi_jaga', $data);
    }

    // Insert banyak data peralatan sekaligus
    public function insert_mutasi_peralatan_batch($data)
    {
        $this->db->insert_batch('mutasi_peralatan', $data);
    }

    public function insert_approval_mutasi($data)
    {
        $this->db->insert('approval_mutasi', $data);
    }

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