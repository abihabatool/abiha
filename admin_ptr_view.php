<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_ptr_view extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('su/admin_model');
		$this->load->model('su/admin_ptr_model');
		$this->load->model('su/adminptrajaxmodel');
		$this->load->helper('text');
		
	 	 $mobile_nums=$this->admin_model->mgr_skype_contact();   	  
         $this->session->set_userdata('skype_mgr_nums', $mobile_nums);
 
		
	}
	function index()
	{
		if($this->session->userdata('admin_login')!=null){
			$res['mgr'] = $this->admin_model->table_record('mgr');
			$res['viewContent'] = 'admin_view_ptr';
			
			$this->load->view('/su/header', $res);
			$this->load->view('/su/admin_view_ptr');
		}
		else{
			redirect(site_url('/su/admin_controller'));
		}
	}
	
	function active_selection()
	{
		if($this->input->get_post('st_val') != "")
			$ptr_sel_status=$this->input->get_post('st_val');
		else
			$ptr_sel_status=Null;
		
		$output=$this->admin_ptr_model->active_selection($ptr_sel_status);
		$this->_SendJSON($output);
	
	}
	
	public function GetPtrListAjax() {
		
		if($this->input->get_post('st_val') != "")
		$ptr_sel_status=$this->input->get_post('st_val');
		else
			$ptr_sel_status=Null;
		
        $output = $this->adminptrajaxmodel->GetPtrListForDataTable($ptr_sel_status);
		
        $this->_SendJSON($output);
    }
	
	function admin_ptr_profile()
	{
		$ptr_id=$this->input->get('ptr_id');
		$result['ptr_profile']=$this->admin_ptr_model->ptr_profile($ptr_id);
		$result['ptr_docs']=$this->admin_ptr_model->ptr_docs($ptr_id);
		//echo "<pre>"; print_r($result['ptr_docs']);
		//if($result['ptr_profile'] == false)
			//echo "data was not found";
		//else
		$this->load->view('su/admin_ptr_profile',$result);
	}
	
	function ptr_change_status()
	{
		$rad_val=$this->input->post('rad_val');
		$rad_class=$this->input->post('rad_class');
		$this->admin_ptr_model->ptr_change_status($rad_val,$rad_class);
	
	}
	
	function ptr_main_status()
	{
		$chk_val=$this->input->post('chk_val');
		$chk_ptr_id=$this->input->post('chk_ptr_id');
		$this->admin_ptr_model->ptr_main_status($chk_val,$chk_ptr_id);
		
	}
	
	function admin_ptr_my_drivers()
	{
		$result['ptr_id']=$this->input->get_post('ptr_id');
		$result['drv_profile']=$this->admin_ptr_model->drv_profile($result['ptr_id']);
			

		//echo "<pre>"; print_r($result);
		$this->load->view('su/admin_ptr_my_drivers',$result);
		//$this->load->view('mgr/admin_ptr_my_drivers');
	}
	
	function getdrvlistajax()
	{
		$output=$this->adminptrajaxmodel->GetdrvListForDataTable();
		$this->_SendJSON($output);

	}
	
	function GetDrvDocs()
	{
		$drv_id=$this->input->get_post("drv_id");
		$result['drv_docs']=$this->admin_ptr_model->GetDrvDocs($drv_id);
	}
	/*
	function getdrvlistajax()
	{
		 $output = $this->adminajaxmodel->GetDrvListForDataTable();

        $this->_SendJSON($output);
	}
	*/
	
	function drv_change_status()
	{
		$rad_val=$this->input->post('rad_val');
		$rad_class=$this->input->post('rad_class');
		$this->admin_ptr_model->drv_change_status($rad_val,$rad_class);
	
	}

	function drv_main_status()
	{
		$chk_val=$this->input->post('chk_val');
		$chk_drv_id=$this->input->post('chk_drv_id');
		$this->admin_ptr_model->drv_main_status($chk_val,$chk_drv_id);

	}
	
	function admin_ptr_vehicles()
	{
		$ptr_id=$this->input->get('ptr_id');
		$result['vhl_profile']=$this->admin_ptr_model->vhl_profile($ptr_id);
		//echo "<pre>"; print_r($result);
		//exit;
		
		$this->load->view('su/admin_ptr_vehicles',$result);
	}
	
	
	function GetVhlDocs()
	{
		$vhl_id=$this->input->get_post("vhl_id");
		$this->admin_ptr_model->GetvhlDocs($vhl_id);
	}
	
	function vhl_change_status()
	{
		$rad_val=$this->input->post('rad_val');
		$rad_class=$this->input->post('rad_class');
		$this->admin_ptr_model->vhl_change_status($rad_val,$rad_class);
	
	}
	
	function vhl_main_status()
	{
		$chk_val=$this->input->post('chk_val');
		$chk_vhl_id=$this->input->post('chk_vhl_id');
		$this->admin_ptr_model->vhl_main_status($chk_val,$chk_vhl_id);

	}
	
	function mail_manual()
	{
		$this->load->view("su/mail_manual");
	}
	
	
	 protected function _SendJSON($data) {
        $this->output->set_content_type('application/json');
        $json = json_encode($data);
        $this->output->_display($json);
        exit;
    }
}