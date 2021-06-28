<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Color extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('General_datatable');
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Color";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/color/color',$data);
		$this->load->view('admin/controller/footer');
	}
	public function create()
	{
		$this->General_model->auth_check();
		$name=ucwords(trim($this->input->post("name")));
		$price=trim($this->input->post("price"));
		$remark=ucwords(trim($this->input->post("remark")));
		if(isset($name) && !empty($name)){
			$count=$this->General_model-> has_duplicate($name,'color','name');
			if($count>0){
				$data['status']="error";
				$data['msg']=" Name Already Exist" ;	
			}else{
				$detail=['name'=>$name,
							'price'=>$price,
							'remark'=>$remark,
							'status'=>'1',
							'user_id'=>$_SESSION['auth_user_id'],
							'created_at'=>date("Y-m-d h:i:s"),
							'modify_at'=>NULL ];
			$detail=$this->db->insert('color',$detail);
			$data['status']="success";
			$data['msg']="Color Added" ;		
		}
		}else{
			$data['status']="error";
			$data['msg']="Something is Worng";				
		}
		echo json_encode($data);
	}
	public function getLists(){
		$this->General_model->auth_check();
		$table='color';
		$order_column_array=array('id','name','price','remark');
		$search_order= array('name','price','remark');
		$order_by_array= array('id' => 'DESC');
        $data = $row = array();
        $Master_Data = $this->General_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
        $i = $_POST['start'];
        foreach($Master_Data as $m_data){
            $i++;
            $created = date( 'jS M Y', strtotime($m_data->created_at));
            $data[] = 	[$i,	        				
    					ucwords($m_data->name),
    					number_format($m_data->price,2),
    					ucwords($m_data->remark),
    					'<a href="'.base_url('color/get_editfrm/').$m_data->id .'"><button type="button" class="btn btn-custom btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>'];
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->General_datatable->countAll($table),
            "recordsFiltered" => $this->General_datatable->countFiltered($_POST,$table,$order_column_array,$search_order,$order_by_array),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function get_editfrm($id)
    {
    	$this->General_model->auth_check();
    	$data['method']="edit";
   		$data['frm_id']="Edit_frm";
   		$data['page_title']="Color";
    	$data['result']=$this->General_model->get_row('color','id',$id);
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/color/color',$data);
		$this->load->view('admin/controller/footer');
    }
    public function update()
    {
    	$this->General_model->auth_check();
	    $name=ucwords(trim($this->input->post("name")));
		$price=trim($this->input->post("price"));
		$remark=ucwords(trim($this->input->post("remark")));
		$status=$this->input->post("status");
		$id=$this->input->post("id");
    	if(isset($name) && !empty($name) && isset($id) && !empty($id)){
			$count=$this->db->query("select name from color where name ='".$name."' and id !='".$id."'")->num_rows();
			if($count>0){
				$data['status']="error";
	    		$data['msg']="Name Already Exist";
			}else{
	    		$detail=['name'=>$name,
							'price'=>$price,
							'remark'=>$remark,
							'status'=>$status,
							'user_id'=>$_SESSION['auth_user_id'],
							'modify_at'=>NULL 
					];
	    		$this->General_model->update('color',$detail,'id',$id);
	    		$data['status']="success";
	    		$data['msg']="Color Updated";
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