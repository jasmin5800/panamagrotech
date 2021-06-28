<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Item extends CI_Controller {
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
		$data['page_title']="Item";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/setting/item',$data);
		$this->load->view('admin/controller/footer');
	}
	public function create()
	{
		$this->General_model->auth_check();
		$name=ucwords(trim($this->input->post("name")));
		if(isset($name) && !empty($name)){
			$count=$this->General_model-> has_duplicate($name,'item','item_name');
			if($count>0){
				$data['status']="error";
				$data['msg']="Item Already Exist" ;	
			}else{
				$msg="item insert ".$name;
				$this->LogModel->simplelog($msg);
				$detail=['item_name'=>$name,
							'status'=>'1',
							'user_id'=>$_SESSION['auth_user_id'],
							'created_at'=>date("Y-m-d h:i:s")];
			$detail=$this->db->insert('item',$detail);
			$data['status']="success";
			$data['msg']="Item Added" ;		
		}
		}else{
			$data['status']="error";
			$data['msg']="Something is Worng";				
		}
		echo json_encode($data);
	}
	public function getLists(){
		$this->General_model->auth_check();
		$table='item';
		$order_column_array=array('item_id ','item_name');
		$search_order= array('item_name');
		$order_by_array= array('item_id ' => 'ASC');
        $data = $row = array();
        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
        $i = $_POST['start'];
        foreach($Master_Data as $m_data){
            $i++;
            $created = date( 'jS M Y', strtotime($m_data->created_at));
            $data[] = 	[$i,	        				
    					$m_data->item_name,
    					'<a href="'.base_url('item/get_editfrm/').$m_data->item_id .'"><button type="button" class="btn btn-custom btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>'];
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
       		$data['page_title']="Item";
	    	$data['result']=$this->General_model->get_row('item','item_id',$id);
	    	$this->load->view('admin/controller/header');
			$this->load->view('admin/controller/sidebar');
			$this->load->view('admin/setting/item',$data);
			$this->load->view('admin/controller/footer');
	    }
	    public function update()
	    {
	    	$this->General_model->auth_check();
		    $name=ucwords($this->input->post("name"));
			$status=$this->input->post("status");
			$id=$this->input->post("id");
	    	if(isset($name) && !empty($name)){
				$count=$this->General_model-> has_duplicate_query("select item_name from item where item_name ='".$name."' and item_id !='".$id."'");
				
				if($count>0){
					$data['status']="error";
		    		$data['msg']="Item Already Exist";
				}else{
					$msg="item Update ".$name;
					$this->LogModel->simplelog($msg);
		    		$detail=['item_name'=>$name,
						'status'=>$status,
						'user_id'=>$_SESSION['auth_user_id'],
						];
		    		$this->General_model->update('item',$detail,'item_id',$id);
		    		$data['status']="success";
		    		$data['msg']="Item Updated";
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
	    		$msg="item Deleted ".$id;
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