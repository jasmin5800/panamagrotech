<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Devide extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('DevideModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role2();
    }
	public function index()
	{
		$data['page_title']="Devide";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/devide/index',$data);
		$this->load->view('admin/controller/footer');
	}
    public function get_addfrm()
    {
    	$this->General_model->auth_check();
		$data['page_title']="Devide";
		$data['lot_no'] =$this->db->query("SELECT `lot_no` FROM `cut` WHERE `use_for`='1' and `devide_status`='1' ORDER BY `cut`.`lot_no` DESC")->result();
		$data['patla'] = $this->General_model->get_data('patla','status','patla_name,patla_id','1');
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/devide/create',$data);
		$this->load->view('admin/controller/footer');
    }
	public function create()
	{
		$this->General_model->auth_check();
		$lot_no=trim($this->input->post("lot_no"));
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$vahicle=strtoupper(trim($this->input->post("vahicle")));
		$vahicle_no=strtoupper(trim($this->input->post("vahicle_no")));
		$total_pcs=$this->input->post('total_pcs');
		$address=strtoupper(trim($this->input->post("address")));
		$patla_id=$this->input->post('patla');
		$pcs=$this->input->post('pcs');
		if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($patla_id) && !empty($patla_id) && isset($pcs) && !empty($pcs)){
		$detail=$this->General_model->get_row_fild('cut','lot_no','party_id,item_id',$lot_no);
		$challan_no=$this->DevideModel->challan_no();
				$msg="Devide insert lotno ".$lot_no;
				$this->LogModel->simplelog($msg);
			$devide=['challan_no'=>$challan_no['challan_no'],
						'lot_no'=>$lot_no,
						'address'=>$address,
						'vahicle'=>$vahicle,
						'vahicle_no'=>$vahicle_no,
						'party_id'=>$detail->party_id,
						'item_id'=>$detail->item_id,							
						'date'=>$date,
						'patla_id'=>$patla_id,
						'devide_pcs'=>$pcs,
						'total_pcs'=>$total_pcs,
						'user_id'=>$_SESSION['auth_user_id'],
						'status'=>'1',
						'created_at'=>date("Y-m-d h:i:s")];
			$devide = $this->General_model->addid('devide',$devide);
			$sess_data = ['status'  => 'success',
				            'msg'  => 'Devide Added' ];
			$this->session->set_userdata($sess_data);		
			redirect('Devide/view_invoice/'.$devide);
		}else{
			$sess_data = ['status'  => 'error',
				            'msg'  => 'Something Is Worng' ];
			$this->session->set_userdata($sess_data);	
			redirect('Devide/get_addfrm/');
		}
	}
	public function getLists(){
		$columns = array( 
                    0 =>'id_devide', 
                    1=> 'lot_no',
                    2 =>'challan_no',
                    3=> 'date',
                    4 =>'patla_name',
                    5 =>'address',
                    6=> 'devide_pcs',
                    7=> 'vahicle_no',
                    8=> 'user_name',
                );
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->DevideModel->allposts_count();
		$totalFiltered = $totalData; 
		if(empty($this->input->post('search')['value']))
		{            
		    $posts = $this->DevideModel->allposts($limit,$start,$order,$dir);
		}
		else {
		    $search = $this->input->post('search')['value']; 
		    $posts =  $this->DevideModel->posts_search($limit,$start,$search,$order,$dir);
		    $totalFiltered = $this->DevideModel->posts_search_count($search);
		}
		$data = array();
		if(!empty($posts))
		{
		    $i=1;
		    foreach ($posts as $post)
		    {
	    		if($_SESSION['auth_role_id']=="1"){
	    			$button='<a href="'.base_url('Devide/get_editfrm/').$post->id_devide.'"><button type="button" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
		        	<a href="'.base_url('Devide/view_invoice/').$post->id_devide.'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
		        	<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->id_devide.'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
	    		}else{
	    			$button='<a href="'.base_url('Devide/get_editfrm/').$post->id_devide.'"><button type="button" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
		        		<a href="'.base_url('Devide/view_invoice/').$post->id_devide.'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
	    		}
		        $nestedData['sr_no'] =$i;
		        $nestedData['challan_no'] =$post->challan_no;
		        $nestedData['lot_no'] =LOT.$post->lot_no;
		        $nestedData['date'] =date('d/m/Y',strtotime($post->date));
		        $nestedData['patla_name'] =$post->patla_name;
		        $nestedData['address'] =$post->address;
		        $nestedData['devide_pcs'] = $post->devide_pcs;
		        $nestedData['vahicle_no'] = $post->vahicle_no;
		        $nestedData['user_name'] =strtoupper($post->user_name);
		        $nestedData['button'] =$button;
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
    	$data['page_title']="Devide";
    	$data['devide']=$this->General_model->get_row('devide','id_devide',$id);
    	$cut=$this->db->query("SELECT SUM(total_pcs) as total_pcs FROM `cut` WHERE party_id='".$data['devide']->party_id."' and item_id='".$data['devide']->item_id."' and use_for='1'")->row();
    	$devide_pcs=$this->db->query("SELECT SUM(devide_pcs) as devide_pcs FROM `devide` WHERE party_id='".$data['devide']->party_id."' and item_id='".$data['devide']->item_id."' and id_devide != '".$id."'")->row();
    	$data['total_pcs']=$cut->total_pcs-$devide_pcs->devide_pcs;
    	$data['patla'] = $this->General_model->get_data('patla','status','*','1');
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/devide/edit',$data);
		$this->load->view('admin/controller/footer');
    }
    public function update()
    {
    	$this->General_model->auth_check();
    	$lot_no=trim($this->input->post("lot_no"));
    	$devide_id=$this->input->post('devide_id');
    	$date = explode('/',$this->input->post('date')); 
    	$date =[$date[2],$date[1],$date[0]];
    	$date=implode("-", $date);
    	$vahicle=strtoupper(trim($this->input->post("vahicle")));
    	$vahicle_no=strtoupper(trim($this->input->post("vahicle_no")));
    	$total_pcs=$this->input->post('total_pcs');
    	$address=strtoupper(trim($this->input->post("address")));
    	$patla_id=$this->input->post('patla');
    	$pcs=$this->input->post('pcs');
    	if(isset($date) && !empty($date) && isset($patla_id) && !empty($patla_id) && isset($pcs) && !empty($pcs) && isset($devide_id) && !empty($devide_id)){
    		$lotno=
    		$msg="Devide Update lotno ".$lot_no;
			$this->LogModel->simplelog($msg);
    		$devide=['address'=>$address,
    					'vahicle'=>$vahicle,
    					'vahicle_no'=>$vahicle_no,
    					'date'=>$date,
    					'patla_id'=>$patla_id,
    					'devide_pcs'=>$pcs,
    					'total_pcs'=>$total_pcs,
    					'user_id'=>$_SESSION['auth_user_id'] ];
    			$this->General_model->update('devide',$devide,'id_devide',$devide_id);
    			$sess_data = ['status'  => 'success',
    				            	'msg'  => 'Devide Updated' ];
    			$this->session->set_userdata($sess_data);		
    			redirect('Devide/view_invoice/'.$devide_id);
    		}else{
    			$sess_data = ['status'  => 'error',
    				            'msg'  => 'Something Is Worng' ];
    			$this->session->set_userdata($sess_data);	
    			redirect('Devide/get_editfrm/'.$devide_id);
    	}
    }
    public function view_invoice($id)
    {
    	$data['page_title']="Devide";
    	$data['devide']=$this->db->query("SELECT t1.*, t2.cut_pcs,t3.patla_name FROM devide as t1 LEFT JOIN balance as t2 ON t1.lot_no = t2.lot_no LEFT JOIN patla as t3 ON t1.patla_id = t3.patla_id WHERE t1.id_devide='".$id."'")->row();
    	$data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['devide']->lot_no."'")->row();
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/devide/invoice',$data);
		$this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
    	$this->General_model->auth_check();
    	if(isset($id) && !empty($id)){
    		$devide=$this->General_model->delete('devide','id_devide',$id);
    		$msg="Devide Deleted id ".$id;
			$this->LogModel->simplelog($msg);

    		$data['status']="success";
    		$data['msg']="Devide Deleted";
    	}else{
    		$data['status']="error";
    		$data['msg']="Something is Worng";				
    	}
    	echo json_encode($data);
    }
    public function totalpcs($id)
    { 			
    	$this->General_model->auth_check();
    	if(isset($id) && !empty($id)){
    		$data['status']="success";
    		$cut_row=$this->General_model->get_row('cut','lot_no',$id);
    		$party_id=$cut_row->party_id;
    		$item_id=$cut_row->item_id;
    		$cut_pcs=$cut_row->total_pcs;
    		$cut_tpcs=$this->db->query("SELECT SUM(total_pcs) as total_pcs FROM `cut` WHERE party_id='".$party_id."' and item_id='".$item_id."' and use_for='1' and lot_no <='".$id."'")->row();
    		$total_pcs=((empty($cut_tpcs->total_pcs) && !isset($cut_tpcs->total_pcs))?0:$cut_tpcs->total_pcs);
    		$devide_tpcs=$this->db->query("SELECT SUM(devide_pcs) as devide_pcs FROM `devide` WHERE party_id='".$party_id."' and item_id='".$item_id."' and lot_no <='".$id."'")->row();
    		$devide_pcs=((empty($devide_tpcs->devide_pcs) && !isset($devide_tpcs->devide_pcs))?0:$devide_tpcs->devide_pcs);
    		$pending_pcs=$total_pcs-$devide_pcs;
    		$data['flag']=['total_pcs'=>$pending_pcs];
    	}else{
    		$data['status']="error";
    		$data['msg']="Something is Worng";				
    	}
    	echo json_encode($data);
    }
}