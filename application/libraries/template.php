<?php
class Template {
	
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

	function user($template,$data=null){
		$data['_content']=
		$this->_ci->load->view($template,$data,true);
		//$data['_user-panel']=
		//$this->_ci->load->view('template/user_panel',$data,true);
		$data['_header']=
		$this->_ci->load->view('template_user/header',$data,true);
		//$data['_section']=
		//$this->_ci->load->view('template/section',$data,true);
		$data['_sidebar']=
		$this->_ci->load->view('template_user/sidebar',$data,true);
		$this->_ci->load->view('/template_user.php',$data);
	}
}