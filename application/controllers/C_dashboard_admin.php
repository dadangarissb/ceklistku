<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_dashboard_admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_mutasi_jaga'));
        $this->load->library('form_validation');
        $this->load->library('template');
        // $this->load->library('Simple_login');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library(array('upload','image_lib'));
    }

    public function index()
    {
        $data_mutasi = $this->m_mutasi_jaga->get_all();
        $data = array(
            'data_mutasi' => $data_mutasi
        );

        $this->template->display('v_dashboard_admin', $data);
    }


    public function read($id_mutasi_jaga) 
    {
        $row = $this->m_mutasi_jaga->get_by_id($id_mutasi_jaga);
        $mutasi_peralatan = $this->m_mutasi_jaga->get_mutasi_peralatan($id_mutasi_jaga);
        $data_approval = $this->m_mutasi_jaga->get_data_approval($id_mutasi_jaga);
        $approver_1 = $this->m_mutasi_jaga->get_approver_1_by_id_unit("1");
        
        if($data_approval->approver_1_at){
            $approver_1_at = "disetujui";
        }
        else{
            $approver_1_at = "menunggu";
        }

        if($data_approval->approver_2_at){
            $approver_2_at = "disetujui";
        }
        else{
            $approver_2_at = "menunggu";
        }

        $row = $this->m_mutasi_jaga->get_by_id($id_mutasi_jaga);
        if ($row) {
            $data = array(
		'id_mutasi_jaga' => $row->id_mutasi_jaga,
		'tanggal_jaga' => $row->tanggal_jaga,
		'shift' => $row->shift,
		'petugas_serah' => $row->petugas_serah,
		'petugas_terima' => $row->petugas_terima,
		'catatan_mutasi' => $row->catatan_mutasi,
		'dibuat_pada' => $row->dibuat_pada,
        'nama_unit' => $row->nama_unit,
        'mutasi_peralatan' => $mutasi_peralatan,
        'diserahkan_oleh' => $row->petugas_serah,
        'diterima_oleh' => $data_approval->nama_satpam,
        'approver_1' => $data_approval->nama_approver_1,
        'approver_2' => $data_approval->nama_approver_2,
        'approval_1_status' => $approver_1_at,
        'approval_2_status' => $approver_2_at,
        
	    );
            $this->template->display('mutasi_jaga/v_mutasi_detail', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('c_mutasi_jaga'));
        }
    }

    

//     public function create() 
//     {
//     	$jenis=$this->M_Jenis_Usaha->get_all();
//     	$kelurahan=$this->M_Kelurahan->get_all();
//         $data = array(
//             'button' => 'Submit',
//             'action' => site_url('C_dataumkm/create_action'),
// 	    'id_umkm' => set_value('id_umkm'),
// 	    'nama_perusahaan' => set_value('nama_perusahaan'),
// 	    'nama_pimpinan' => set_value('nama_pimpinan'),
// 	    'foto_pimpinan' => set_value('foto_pimpinan'),
// 	    'no_ktp' => set_value('no_ktp'),
// 	    'alamat' => set_value('alamat'),
// 	    'id_kelurahan' => set_value('id_kelurahan'),
// 	    'email' => set_value('email'),
//         'pass2' => set_value('pass2'),
//         'no_hp' => set_value('no_hp'),
// 	    'spesifikasi_produk' => set_value('spesifikasi_produk'),
// 	    'bahan_baku' => set_value('bahan_baku'),
// 	    'permasalahan' => set_value('permasalahan'),
// 	    'no_siup' => set_value('no_siup'),
// 	    'no_npwp' => set_value('no_npwp'),
// 	    'no_tdp' => set_value('no_tdp'),
// 	    'pirt' => set_value('pirt'),
// 	    'halal' => set_value('halal'),
// 	    'hki' => set_value('hki'),
// 	    'id_jenis_usaha' => set_value('id_jenis_usaha'),
// 	    'jenis'=>$jenis,
// 	    'kelurahan'=>$kelurahan,
// 	    //'kecamatan'=>$this->M_DataUmkm->ambil_kecamatan()
// 	);
//         $this->template->display('c_dataumkm/data_umkm_form', $data);
//     }
    
    
//     public function create_action() 
//     {
//         $this->_rules();

//         $config['upload_path']='./foto_pimpinan/';
//         $config['allowed_types']='jpeg|gif|jpg|png';

//         $this->upload->initialize($config);

//         $this->upload->do_upload('foto_pimpinan');

//         if ($this->form_validation->run() == FALSE) {
//             $this->create();
//         } else {

//             $nama_image=$this->upload->data();

//             $data = array(
// 		'nama_perusahaan' => $this->input->post('nama_perusahaan',TRUE),
// 		'nama_pimpinan' => $this->input->post('nama_pimpinan',TRUE),
// 		'no_ktp' => $this->input->post('no_ktp',TRUE),
// 		'alamat' => $this->input->post('alamat',TRUE),
// 		'id_kelurahan' => $this->input->post('id_kelurahan',TRUE),
// 		'id_jenis_usaha' => $this->input->post('id_jenis_usaha',TRUE),
// 		'email' => $this->input->post('email',TRUE),
//         'password' => $this->input->post('pass2',TRUE),
//         'no_hp' => $this->input->post('no_hp',TRUE),
// 		'spesifikasi_produk' => $this->input->post('spesifikasi_produk',TRUE),
// 		'bahan_baku' => $this->input->post('bahan_baku',TRUE),
// 		'permasalahan' => $this->input->post('permasalahan',TRUE),
// 		'no_siup' => $this->input->post('no_siup',TRUE),
// 		'no_npwp' => $this->input->post('no_npwp',TRUE),
// 		'no_tdp' => $this->input->post('no_tdp',TRUE),
// 		'pirt' => $this->input->post('pirt',TRUE),
// 		'halal' => $this->input->post('halal',TRUE),
// 		'hki' => $this->input->post('hki',TRUE),
//         'foto_pimpinan' => $nama_image['file_name'],
// 	    );

//             $this->M_DataUmkm->insert($data);
//             $this->session->set_flashdata('message', 'Create Record Success');
//             redirect(site_url('c_dataumkm/read/'.$c_dataumkm->id_umkm));
//         }
//     }

// /*    public function list_data_usaha($id_umkm)
//     {
//         $c_datausaha = $this->M_DataUsaha->get_all();

//         $data = array(
//             'c_datausaha_data' => $c_datausaha
//         );

//         $this->load->view('c_datausaha/data_usaha_list', $data);
//     }*/
    
//     public function update($id) 
//     {
//         $row = $this->M_DataUmkm->get_by_id($id);
//         $jenis=$this->M_Jenis_Usaha->get_all();
//         $kelurahan=$this->M_Kelurahan->get_all();

//         if ($row) {
//             $data = array(
//                 'button' => 'Update',
//                 'action' => site_url('c_dataumkm/update_action'),
// 		'id_umkm' => set_value('id_umkm', $row->id_umkm),
// 		'nama_perusahaan' => set_value('nama_perusahaan', $row->nama_perusahaan),
// 		'nama_pimpinan' => set_value('nama_pimpinan', $row->nama_pimpinan),
// 		'foto_pimpinan' => set_value('foto_pimpinan', $row->foto_pimpinan),
// 		'no_ktp' => set_value('no_ktp', $row->no_ktp),
// 		'alamat' => set_value('alamat', $row->alamat),
// 		'id_kelurahan' => set_value('id_kelurahan', $row->id_kelurahan),
// 		'email' => set_value('email', $row->email),
//         'pass2' => set_value('pass2', $row->password),
//         'no_hp' => set_value('email', $row->no_hp),
// 		'id_jenis_usaha' => set_value('id_jenis_usaha', $row->id_jenis_usaha),
// 		'no_siup' => set_value('no_siup', $row->no_siup),
// 		'no_npwp' => set_value('no_npwp', $row->no_npwp),
// 		'no_tdp' => set_value('no_tdp', $row->no_tdp),
// 		'pirt' => set_value('pirt', $row->pirt),
// 		'halal' => set_value('halal', $row->halal),
// 		'hki' => set_value('hki', $row->hki),
// 		'spesifikasi_produk' => set_value('spesifikasi_produk', $row->spesifikasi_produk),
// 		'bahan_baku' => set_value('bahan_baku', $row->bahan_baku),
// 		'permasalahan' => set_value('permasalahan', $row->permasalahan),
// 		'jenis'=>$jenis,
// 		'kelurahan'=>$kelurahan,
// 	    );
//             $this->template->display('c_dataumkm/data_umkm_update', $data);
//         } else {
//             $this->session->set_flashdata('message', 'Data tidak ditemukan');
//             redirect(site_url('c_dataumkm/read/'.$c_dataumkm->id_umkm));
//         }
//     }

    
    
//     public function update_action() 
//     {
//         $this->_rules();

//         $config['upload_path']='./foto_pimpinan/';
//         $config['allowed_types']='jpeg|gif|jpg|png';

//         $this->upload->initialize($config);

//         $this->upload->do_upload('foto_pimpinan');

//         if ($this->form_validation->run() == FALSE) {
//             $this->update($this->input->post('id_umkm', TRUE));
//         } else {

//         $foto_lama=$this->input->post('foto_lama',TRUE);
//         $nama_image=$this->upload->data();
//             if($nama_image['file_name']==''){
//                 $nama_image['file_name']=$foto_lama;
//             }
//             else {
//                 if ($nama_image!=null || $foto_lama !='') {
//                     if (file_exists('./foto_pimpinan/'.$foto_lama)) {
//                        unlink('./foto_pimpinan/'.$foto_lama);
//                     }
//                 }
//             }


//             $data = array(
// 		'nama_perusahaan' => $this->input->post('nama_perusahaan',TRUE),
// 		'nama_pimpinan' => $this->input->post('nama_pimpinan',TRUE),
// 		'no_ktp' => $this->input->post('no_ktp',TRUE),
// 		'alamat' => $this->input->post('alamat',TRUE),
//         'foto_pimpinan' => $nama_image['file_name'],
//         //'foto_pimpinan' => $this->input->post('foto_pimpinan',TRUE),
// 		'id_kelurahan' => $this->input->post('id_kelurahan',TRUE),
// 		'email' => $this->input->post('email',TRUE),
//         'password' => $this->input->post('pass2',TRUE),
//         'no_hp' => $this->input->post('no_hp',TRUE),
// 		'id_jenis_usaha' => $this->input->post('id_jenis_usaha',TRUE),
// 		'no_siup' => $this->input->post('no_siup',TRUE),
// 		'no_npwp' => $this->input->post('no_npwp',TRUE),
// 		'no_tdp' => $this->input->post('no_tdp',TRUE),
// 		'pirt' => $this->input->post('pirt',TRUE),
// 		'halal' => $this->input->post('halal',TRUE),
// 		'hki' => $this->input->post('hki',TRUE),
// 		'spesifikasi_produk' => $this->input->post('spesifikasi_produk',TRUE),
// 		'bahan_baku' => $this->input->post('bahan_baku',TRUE),
// 		'permasalahan' => $this->input->post('permasalahan',TRUE),
// 	    );

//             $this->M_DataUmkm->update($this->input->post('id_umkm', TRUE), $data);
//             $this->session->set_flashdata('message', 'Update Record Success');
//             redirect(site_url('c_dataumkm'));
//         }
//     }

    

    
//     public function delete($id,$id_umkm) 
//     {
//         $row = $this->M_DataUmkm->get_by_id($id);

//         if ($row) {
//             $this->M_DataUmkm->delete($id);
//             $this->session->set_flashdata('message', 'Delete Record Success');
//             redirect(site_url('c_dataumkm'));
//         } else {
//             $this->session->set_flashdata('message', 'Record Not Found');
//             redirect(site_url('c_dataumkm'));
//         }
//     }

//     public function Cetak_List()
//     {
//         $c_dataumkm = $this->M_DataUmkm->get_all();

//         $data = array(
//             'c_dataumkm_data' => $c_dataumkm
//         );

//         $this->load->view('c_dataumkm/cetak_data_umkm_list', $data);
//         $html = $this->output->get_output();
  
//              // Load/panggil library dompdfnya
//              $this->load->library('dompdf_gen');
  
//             // Convert to PDF
//             $this->dompdf->load_html($html);
//             $this->dompdf->render();
//             //utk menampilkan preview pdf
//             $this->dompdf->stream("Daftar UMKM Kota Solo.pdf",array('Attachment'=>0));
//             //atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
//             //$this->dompdf->stream("welcome.pdf");
//     }

//    	public function Cetak($id) 
//     {
//         $row = $this->M_DataUmkm->get_by_id($id);
//         $row2 = $this->M_DataUsaha->get_by_id($id);
//         $row3 = $this->M_Pengajuan_pameran->get_peserta($id);
//         //$row3 = $this->M_Peserta_pameran->get_by_id($id);
//         if ($row) {
//             $data['dataumkm'] = array(
// 		'id_umkm' => $row->id_umkm,
//   		'nama_perusahaan' => $row->nama_perusahaan,
// 		'nama_pimpinan' => $row->nama_pimpinan,
// 		//'foto_pimpinan' => $row->foto_pimpinan,
// 		'no_ktp' => $row->no_ktp,
//         'email' => $row->email,
//         'no_hp' => $row->no_hp,
// 		'alamat' => $row->alamat,
// 		'nama_kelurahan' => $row->nama_kelurahan,
// 		'nama_kecamatan' => $row->nama_kecamatan,
// 		// 'id_jenis_usaha' => $row->id_jenis_usaha,
// 		'nama_jenis_usaha' => $row->nama_jenis_usaha,
// 		'no_siup' => $row->no_siup,
// 		'no_npwp' => $row->no_npwp,
// 		'no_tdp' => $row->no_tdp,
// 		'pirt' => $row->pirt,
// 		'halal' => $row->halal,
// 		'hki' => $row->hki,
// 		//'lain1' => $row->lain1,
// 		'spesifikasi_produk' => $row->spesifikasi_produk,
// 		'bahan_baku' => $row->bahan_baku,
// 		'permasalahan' => $row->permasalahan,
// 	    );
//             $data['datausaha'] = array(
//             	'row2'=>$row2);
//             $data['pengajuan_pameran'] = array(
//                 'row3'=>$row3);
//            // $data['peserta_pameran'] = array(
//             //	'row2'=>$row3);
//             $this->load->view('c_dataumkm/data_umkm_cetak', $data);
  
//  			$html = $this->output->get_output();
  
//  			 // Load/panggil library dompdfnya
//  			 $this->load->library('dompdf_gen');
  
//   			// Convert to PDF
//             $this->dompdf->set_paper("A4");
//   			$this->dompdf->load_html($html);
//   			$this->dompdf->render();
//   			//utk menampilkan preview pdf
//   			$this->dompdf->stream("Profil UMKM.pdf",array('Attachment'=>0));
//   			//atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
//   			//$this->dompdf->stream("welcome.pdf");
  
//  		}
//         else { 
//             $this->session->set_flashdata('message', 'Record Not Found');
//             redirect(site_url('c_dataumkm'));
//         }
//     }
    

//     public function _rules() 
//     {
// 	$this->form_validation->set_rules('nama_perusahaan', 'nama perusahaan', 'trim|required');
// 	$this->form_validation->set_rules('nama_pimpinan', 'nama pimpinan', 'trim|required');
// 	// $this->form_validation->set_rules('foto_pimpinan', 'foto pimpinan', 'trim|required');
// 	$this->form_validation->set_rules('no_ktp', 'no ktp', 'trim|required');
// 	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
//     $this->form_validation->set_rules('email', 'email', 'trim|required');
//     $this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required');
// 	//$this->form_validation->set_rules('kelurahan', 'kelurahan', 'trim|required');
// 	$this->form_validation->set_rules('id_jenis_usaha', 'id_jenis usaha', 'trim|required');
// 	// $this->form_validation->set_rules('no_siup', 'no siup', 'trim|required');
// 	// $this->form_validation->set_rules('no_npwp', 'no npwp', 'trim|required');
// 	// $this->form_validation->set_rules('no_tdp', 'no tdp', 'trim|required');
// 	// $this->form_validation->set_rules('pirt', 'pirt', 'trim|required');
// 	// $this->form_validation->set_rules('halal', 'halal', 'trim|required');
// 	// $this->form_validation->set_rules('hki', 'hki', 'trim|required');
// 	$this->form_validation->set_rules('spesifikasi_produk', 'spesifikasi produk', 'trim|required');
// 	$this->form_validation->set_rules('bahan_baku', 'bahan baku', 'trim|required');
// 	$this->form_validation->set_rules('permasalahan', 'permasalahan', 'trim|required');

// 	$this->form_validation->set_rules('id_umkm', 'id_umkm', 'trim');
// 	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//     }


}

/* End of file C_DataUmkm.php */
/* Location: ./application/controllers/C_DataUmkm.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-09-23 10:54:52 */
/* http://harviacode.com */