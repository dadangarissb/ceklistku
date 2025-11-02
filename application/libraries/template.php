

<?php
class template {
	
	protected $_ci;
	
	function __construct(){
		$this ->_ci=&get_instance();
	}
	
	function display($template,$data=null){
		$data['_content']=
		$this->_ci->load->view($template,$data,true);
		//$data['_user-panel']=
		//$this->_ci->load->view('template/user_panel',$data,true);
		$data['_header']=
		$this->_ci->load->view('template/header',$data,true);
		//$data['_section']=
		//$this->_ci->load->view('template/section',$data,true);
		$data['_sidebar']=
		$this->_ci->load->view('template/sidebar',$data,true);
		$this->_ci->load->view('/template.php',$data);
	}

	function satpam($template,$data=null){
		$data['_content']=
		$this->_ci->load->view($template,$data,true);
		//$data['_user-panel']=
		//$this->_ci->load->view('template/user_panel',$data,true);
		$data['_header']=
		$this->_ci->load->view('template_satpam/header',$data,true);
		//$data['_section']=
		//$this->_ci->load->view('template/section',$data,true);
		$data['_sidebar']=
		$this->_ci->load->view('template_satpam/sidebar',$data,true);
		$this->_ci->load->view('/template_satpam.php',$data);
	}
}