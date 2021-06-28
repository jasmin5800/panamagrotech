<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Party extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('Genral_datatable');
        $this->load->model('LogModel');
        $this->General_model->auth_superadmin();
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Party";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/setting/party',$data);
		$this->load->view('admin/controller/footer');
	}
	public function create()
	{
		$this->General_model->auth_check();
		$name=ucwords(trim($this->input->post("name")));
		$srt_name=ucwords(trim($this->input->post("srt_name")));
		$mobile=trim($this->input->post("mobile"));
		$city=trim($this->input->post("city"));
		$address=trim($this->input->post("address"));
		$gst_no=trim($this->input->post("gst_no"));
		$pan_no=trim($this->input->post("pan_no"));
		if(isset($name) && !empty($name) && isset($srt_name) && !empty($srt_name) && isset($mobile) && !empty($mobile) && isset($city) && !empty($city) && isset($address) && !empty($address) && isset($gst_no) && !empty($gst_no) && isset($pan_no) && !empty($pan_no)){
			$count=$this->General_model-> has_duplicate($gst_no,'party','gst_number');
			if($count>0){
				$data['status']="error";
				$data['msg']="Party Already Exist" ;	
			}else{
				$msg="Party insert ".$name;
				$this->LogModel->simplelog($msg);
				$detail=['party_name'=>$name,
							'srt_name'=>$srt_name,
							'user_id'=>$_SESSION['auth_user_id'],
							'mobile_number'=>$mobile,
							'city'=>$city,
							'address'=>$address,
							'gst_number'=>$gst_no,
							'pan_number'=>$pan_no,
							'status'=>'1',
							'created_at'=>date("Y-m-d h:i:s")];
			$detail=$this->db->insert('party',$detail);
			$data['status']="success";
			$data['msg']="Party Added";		
		}
		}else{
			$data['status']="error";
			$data['msg']="Something is Worng";				
		}
		echo json_encode($data);
	}
	public function getLists(){
		$this->General_model->auth_check();
		$table='party';
		$order_column_array=array('party_id','party_name','srt_name','mobile_number','city','address','gst_number','pan_number');
		$search_order= array('party_name','srt_name','mobile_number','city','address','gst_number','pan_number');
		$order_by_array= array('party_id ' => 'ASC');
        $data = $row = array();
        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
        $i = $_POST['start'];
        foreach($Master_Data as $m_data){
            $i++;
            $data[] = 	[$i,	        				
    					$m_data->party_name,
    					$m_data->srt_name,
    					$m_data->mobile_number,
    					$m_data->city,
    					$m_data->address,
    					$m_data->gst_number,
    					$m_data->pan_number,
    					'<a href="'.base_url('Party/get_editfrm/').$m_data->party_id .'"><button type="button" class="btn btn-custom btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>'];
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Genral_datatable->countAll($table),
            "recordsFiltered" => $this->Genral_datatable->countFiltered($_POST,$table,$order_column_array,$search_order,$order_by_array),
            "data" => $data,
        );
        echo json_encode($output);
    }
	    public function get_editfrm($id)
	    {
	    	$this->General_model->auth_check();
	    	$data['method']="edit";
       		$data['frm_id']="Edit_frm";
       		$data['page_title']="Party";
	    	$data['result']=$this->General_model->get_row('party','party_id',$id);
	    	$this->load->view('admin/controller/header');
			$this->load->view('admin/controller/sidebar');
			$this->load->view('admin/setting/party',$data);
			$this->load->view('admin/controller/footer');
	    }
	    public function update()
	    {
	    	$this->General_model->auth_check();
			$id=$this->input->post("id");
	    	$name=ucwords(trim($this->input->post("name")));
	    	$srt_name=ucwords(trim($this->input->post("srt_name")));
	    	$mobile=trim($this->input->post("mobile"));
	    	$city=trim($this->input->post("city"));
	    	$address=trim($this->input->post("address"));
	    	$gst_no=trim($this->input->post("gst_no"));
	    	$pan_no=trim($this->input->post("pan_no"));
			$status=$this->input->post("status");
	    	if(isset($name) && !empty($name) && isset($srt_name) && !empty($srt_name) && isset($mobile) && !empty($mobile) && isset($city) && !empty($city) && isset($address) && !empty($address) && isset($gst_no) && !empty($gst_no) && isset($pan_no) && !empty($id) && isset($id) && !empty($pan_no)){
				$count=$this->General_model-> has_duplicate_query("select gst_number from party where gst_number ='".$gst_no."' and party_id !='".$id."'");
				if($count>0){
					$data['status']="error";
		    		$data['msg']="Party Already Exist";
				}else{
					$msg="Party Update ".$name;
					$this->LogModel->simplelog($msg);
		    		$detail=['party_name'=>$name,
								'srt_name'=>$srt_name,
								'user_id'=>$_SESSION['auth_user_id'],
								'mobile_number'=>$mobile,
								'city'=>$city,
								'address'=>$address,
								'gst_number'=>$gst_no,
								'pan_number'=>$pan_no,
								'status'=>$status ];
		    		$this->General_model->update('party',$detail,'party_id',$id);
		    		$data['status']="success";
		    		$data['msg']="Party Updated";
		    		}
		    	}else{
		    		$data['status']="error";
		    		$data['msg']="Something is Worng";				
		    	}
		    echo json_encode($data);
	    }
	    public function delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$msg="party delete ".$id;
				$this->LogModel->simplelog($msg);
	    		$detail=$this->General_model->delete('item','id_item',$id);
	    		$data['status']="success";
	    		$data['msg']="Item Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
}