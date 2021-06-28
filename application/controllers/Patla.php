<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Patla extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('PatlaModel');
        $this->load->model('Genral_datatable');
        $this->load->model('LogModel');
        $this->General_model->auth_superadmin();
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Patla";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/setting/patla',$data);
		$this->load->view('admin/controller/footer');
	}
	public function create()
	{
		$this->General_model->auth_check();
		$name=ucwords(trim($this->input->post("name")));
		if(isset($name) && !empty($name)){
			$count=$this->General_model-> has_duplicate($name,'patla','patla_name');
			if($count>0){
				$data['status']="error";
				$data['msg']="Patla Already Exist" ;	
			}else{
				$msg="Patla insert ".$name;
				$this->LogModel->simplelog($msg);
				$detail=['patla_name'=>$name,
							'status'=>'1',
							'user_id'=>$_SESSION['auth_user_id'],
							'created_at'=>date("Y-m-d h:i:s")];
			$detail=$this->db->insert('patla',$detail);
			$data['status']="success";
			$data['msg']="Patla Added" ;		
		}
		}else{
			$data['status']="error";
			$data['msg']="Something is Worng";				
		}
		echo json_encode($data);
	}
	public function getLists(){
		$this->General_model->auth_check();
		$columns = array( 
		                    0 =>'patla_id',
		                    1 =>'patla_name'
		                );
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->PatlaModel->allposts_count();
		$totalFiltered = $totalData; 
		if(empty($this->input->post('search')['value']))
		{            
		    $posts = $this->PatlaModel->allposts($limit,$start,$order,$dir);
		}
		else {
		    $search = $this->input->post('search')['value']; 
		    $posts =  $this->PatlaModel->posts_search($limit,$start,$search,$order,$dir);
		    $totalFiltered = $this->PatlaModel->posts_search_count($search);
		}
		$data = array();
		if(!empty($posts))
		{
		    $i=1;
		    foreach ($posts as $post)
		    {
		        $nestedData['sr_no'] =$i;
		        $nestedData['name'] =$post->patla_name;
		        $nestedData['button'] ='<a href="'.base_url('Patla/get_editfrm/').$post->patla_id .'"><button type="button" class="btn btn-custom btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>';
		        $data[] = $nestedData;
		        $i++;
		    }
		}
		$json_data = array(
		            "draw"            => intval($this->input->post('draw')),  
		            "recordsTotal"    => intval($totalData),  
		            "recordsFiltered" => intval($totalFiltered), 
		            "data"            => $data   
		            );
		echo json_encode($json_data);
    }
    public function get_editfrm($id)
    {
    	$this->General_model->auth_check();
    	$data['method']="edit";
   		$data['frm_id']="Edit_frm";
   		$data['page_title']="Patla";
    	$data['result']=$this->General_model->get_row('patla','patla_id',$id);
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/setting/patla',$data);
		$this->load->view('admin/controller/footer');
    }
    public function update()
    {
    	$this->General_model->auth_check();
	    $name=ucwords($this->input->post("name"));
		$status=$this->input->post("status");
		$id=$this->input->post("id");
    	if(isset($name) && !empty($name)){
			$count=$this->General_model-> has_duplicate_query("select patla_name from patla where patla_name ='".$name."' and patla_id !='".$id."'");
			if($count>0){
				$data['status']="error";
	    		$data['msg']="Patla Already Exist";
			}else{
				$msg="patla update ".$name;
				$this->LogModel->simplelog($msg);
	    		$detail=['patla_name'=>$name,
	    			'user_id'=>$_SESSION['auth_user_id'],
					'status'=>$status,
					];
	    		$this->General_model->update('patla',$detail,'patla_id',$id);
	    		$data['status']="success";
	    		$data['msg']="Patla Updated";
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
    		$msg="Patla delete ".$id;
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