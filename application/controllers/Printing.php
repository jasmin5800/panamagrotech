<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Printing extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('PrintingModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role3();
    }
	public function index()
	{	
		$data['page_title']="Printing";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/printing/index',$data);
		$this->load->view('admin/controller/footer');
	}
    public function get_addfrm()
    {
    	$this->General_model->auth_check();
		$data['page_title']="Printing";
		$data['lot_no'] =$this->General_model->get_data('cut','print_status','lot_no','1');
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/printing/create',$data);
		$this->load->view('admin/controller/footer');
    }
	public function create()
	{
		$this->General_model->auth_check();
		$lot_no=trim($this->input->post("lot_no"));
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$lot_pcs=$this->input->post('lot_pcs');
		$t_design=$this->input->post('t_design');
		$t_pcs=$this->input->post('t_pcs');
		$t_missprint=$this->input->post('t_missprint');
		$cloth_val=$this->input->post('cloth_val');
		$sub_total=$this->input->post('sub_total');
		$tax=$this->input->post('tax');
		$g_total=$this->input->post('g_total');
		$printing_val=$this->input->post('printing_val');
		if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($printing_val) && !empty($printing_val)){
			$challan_no=$this->PrintingModel->challan_no();
			$detail=['challan_no'=>$challan_no['challan_no'],
						'lot_no'=>$lot_no,
						'date'=>$date,
						't_design'=>$t_design,
						't_pcs'=>$t_pcs,
						't_missprint'=>$t_missprint,
						'cloth_value'=>$cloth_val,
						'sub_total'=>$sub_total,
						'tax'=>$tax,
						'g_total'=>$g_total,
						'print_val'=>$printing_val,
						'user_id'=>$_SESSION['auth_user_id'],
						'status'=>'1',
						'created_at'=>date("Y-m-d h:i:s")];
			$printing = $this->General_model->addid('printing',$detail);
			$msg="printing insert Lotno ".$lot_no;
			$this->LogModel->simplelog($msg);
			$this->General_model->update('balance',['print_cloth'=>$printing_val],'lot_no',$lot_no);
			$this->General_model->update('cut',['print_status'=>0],'lot_no',$lot_no);
			$party=$this->General_model->get_row('cut','lot_no',$lot_no);
			$i=0;
			foreach ($this->input->post('design_no') as $key) {
				$design_no=$this->input->post('design_no')[$i];
				$design_no=str_replace(" ","",$design_no);
				$color=$this->input->post('color')[$i];
				$pcs=$this->input->post('pcs')[$i];
				$miss_print=$this->input->post('miss_print')[$i];
				$patla_id=$this->input->post('patla')[$i];
				if(isset($printing) && !empty($printing) && !empty($design_no) && !empty($color)  &&!empty($pcs) && !empty($patla_id)){
					$design_unique=$this->PrintingModel->unique_design();
					$priting_lot=['printing_id'=>$printing,
									'lot_no'=>$lot_no,
									'design_no'=>$design_no,
									'unique_design'=>$design_unique,
									'color'=>$color,
									'date'=>$date,
									'party_id'=>$party->party_id,
									'pcs'=>$pcs,
									'miss_pcs'=>$miss_print,
									'patla_id'=>$patla_id,
									'status'=>1,
									'created_at'=>date("Y-m-d h:i:s")];
					$this->General_model->add('priting_lot',$priting_lot);
					}
				$i++;
			}
			$sess_data = ['status'  => 'success',
				            'msg'  => 'Printing Added' ];
			$this->session->set_userdata($sess_data);		
			redirect('Printing/view_invoice/'.$printing);
		}else{
			$sess_data = ['status'  => 'error',
				            'msg'  => 'Something Is Worng' ];
			$this->session->set_userdata($sess_data);	
			redirect('Printing/get_addfrm/');
		}
	}
	public function getLists(){
		$columns = array( 
                    0 =>'printing_id', 
                    1 =>'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4 =>'t_missprint',
                    5 =>'t_pcs',
                    6=> 'cloth_value',
                    7=> 'g_total',
                    8=> 'print_val',
                    8=> 'user_name',
                );
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->PrintingModel->allposts_count();
		$totalFiltered = $totalData; 
		if(empty($this->input->post('search')['value']))
		{            
		    $posts = $this->PrintingModel->allposts($limit,$start,$order,$dir);
		}
		else {
		    $search = $this->input->post('search')['value']; 
		    $posts =  $this->PrintingModel->posts_search($limit,$start,$search,$order,$dir);
		    $totalFiltered = $this->PrintingModel->posts_search_count($search);
		}
		$data = array();
		if(!empty($posts))
		{
			setlocale(LC_MONETARY, 'en_IN');
		    $i=1;
		    foreach ($posts as $post)
		    {	
		    	if($_SESSION['auth_role_id']=="1"){
		    	   $button='<a href="'.base_url('Printing/get_editfrm/').$post->printing_id .'"><button type="button" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
		        		<a href="'.base_url('Printing/view_invoice/').$post->printing_id .'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
		        		<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->printing_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
		    	}else{
		    	   $button='<a href="'.base_url('Printing/get_editfrm/').$post->printing_id .'"><button type="button" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
		        		<a href="'.base_url('Printing/view_invoice/').$post->printing_id .'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
		    	}
		        $nestedData['sr_no'] =$i;
		        $nestedData['lot_no'] =LOT.$post->lot_no;
		        $nestedData['challan_no'] =$post->challan_no;
		        $nestedData['date'] =date('d/m/Y',strtotime($post->date));
		        $nestedData['t_missprint'] =$post->t_missprint;
		        $nestedData['t_pcs'] =$post->t_pcs;
		        $nestedData['cloth_value'] = number_format($post->cloth_value,2);
		        $nestedData['g_total'] =  number_format($post->g_total,2);
		        $nestedData['print_val'] = number_format($post->print_val,2);
		        $nestedData['user_name'] = strtoupper($post->user_name);
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
    	$data['page_title']="Printing";
    	$data['printing']=$this->General_model->get_row('printing','printing_id',$id);
    	$data['patla'] =$this->db->query("SELECT t1.patla_id,t2.patla_name FROM devide as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id WHERE t1.lot_no='".$data['printing']->lot_no."'")->result();
    	$data['lot_pcs']=$this->db->query("SELECT SUM(devide_pcs) as lot_pcs FROM `devide` WHERE lot_no='".$data['printing']->lot_no."'")->row();
    	$data['balance']=$this->General_model->get_row('balance','lot_no',$data['printing']->lot_no);	
    	$data['printing_lot']=$this->General_model->get_data('priting_lot','printing_id','*',$id);
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/printing/edit',$data);
		$this->load->view('admin/controller/footer');
    }
    public function update()
    {
    	$this->General_model->auth_check();
		$lot_no=trim($this->input->post("lot_no"));
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$lot_pcs=$this->input->post('lot_pcs');
		$t_design=$this->input->post('t_design');
		$t_pcs=$this->input->post('t_pcs');
		$t_missprint=$this->input->post('t_missprint');
		$cloth_val=$this->input->post('cloth_val');
		$sub_total=$this->input->post('sub_total');
		$tax=$this->input->post('tax');
		$g_total=$this->input->post('g_total');
		$printing_val=$this->input->post('printing_val');
		$printing_id=$this->input->post('printing_id');
		if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($printing_val) && !empty($printing_val) && isset($printing_id) && !empty($printing_id)){
			$detail=[
						'date'=>$date,
						't_design'=>$t_design,
						't_pcs'=>$t_pcs,
						't_missprint'=>$t_missprint,
						'cloth_value'=>$cloth_val,
						'sub_total'=>$sub_total,
						'tax'=>$tax,
						'g_total'=>$g_total,
						'user_id'=>$_SESSION['auth_user_id'],
						'print_val'=>$printing_val ];
			$this->General_model->update('printing',$detail,'printing_id ',$printing_id);
			$this->General_model->update('balance',['print_cloth'=>$printing_val],'lot_no',$lot_no);
			$msg="printing Update Lotno ".$lot_no;
			$this->LogModel->simplelog($msg);
			$i=0;
			$party=$this->General_model->get_row('cut','lot_no',$lot_no);
			foreach ($this->input->post('design_no') as $key) {
				$design_no=$this->input->post('design_no')[$i];
				$design_no=str_replace(" ","",$design_no);
				$color=$this->input->post('color')[$i];
				$pcs=$this->input->post('pcs')[$i];
				$miss_print=$this->input->post('miss_print')[$i];
				$patla_id=$this->input->post('patla')[$i];
				$pl_id=$this->input->post('pl_id')[$i];
				if(isset($printing_id) && !empty($printing_id) && isset($pl_id) && !empty($pl_id) &&  !empty($design_no) && !empty($color)  &&!empty($pcs) && !empty($patla_id)){
					$priting_lot=['design_no'=>$design_no,
									'color'=>$color,
									'date'=>$date,
									'pcs'=>$pcs,
									'miss_pcs'=>$miss_print,
									'patla_id'=>$patla_id,
									];
					$this->General_model->update('priting_lot',$priting_lot,'pl_id',$pl_id);
					}elseif(isset($printing_id) && !empty($printing_id) &&  !empty($design_no) && !empty($color)  &&!empty($pcs) && !empty($patla_id)){
					$design_unique=$this->PrintingModel->unique_design();
					$priting_lot=['printing_id'=>$printing_id,
									'lot_no'=>$lot_no,
									'design_no'=>$design_no,
									'unique_design'=>$design_unique,
									'color'=>$color,
									'date'=>$date,
									'party_id'=>$party->party_id,
									'pcs'=>$pcs,
									'miss_pcs'=>$miss_print,
									'patla_id'=>$patla_id,
									'status'=>1,
									'created_at'=>date("Y-m-d h:i:s")];
					$this->General_model->add('priting_lot',$priting_lot);
					}
				$i++;
			}
    			$sess_data = ['status'  => 'success',
    				            	'msg'  => 'Printing Updated' ];
    			$this->session->set_userdata($sess_data);		
    			redirect('Printing/view_invoice/'.$printing_id);
    		}else{
    			$sess_data = ['status'  => 'error',
    				            'msg'  => 'Something Is Worng' ];
    			$this->session->set_userdata($sess_data);	
    			redirect('Printing/get_editfrm/'.$printing_id);
    	}
    }
    public function view_invoice($id)
    {
    	$data['page_title']="Devide";
    	$data['printing']=$this->General_model->get_row('printing','printing_id',$id);
    	$data['printing_lot']=$this->db->query("select t1.*,t2.patla_name from priting_lot as t1,patla as t2 where printing_id='".$id."' and t1.patla_id=t2.patla_id ORDER BY `t1`.`design_no` ASC")->result();
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/printing/invoice',$data);
		$this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
    	$this->General_model->auth_check();
    	if(isset($id) && !empty($id)){
    		$printing=$this->General_model->get_row('printing','printing_id',$id);
    		$lot_no=$printing->lot_no;
    		$msg="printing delete Lotno ".$lot_no;
			$this->LogModel->simplelog($msg);
    		$balance=['print_cloth'=>0,
    						'silicate_cloth'=>0,							
    						'silicate_status'=>1,
    						'dholai_cloth'=>0,
    						'dholai_status'=>1,
    						'kanji_cloth'=>0,
    						'Kanji_status'=>1,
    						'ghadi_cloth'=>0,
    						'ghadi_status'=>1,
    						'embroidery_cloth'=>0,
    						'embroidery_status'=>1,
    						'packing_cloth'=>0,
    						'packing_status'=>1 ];
    		$this->General_model->update('balance',$balance,'lot_no',$lot_no);
    		$this->General_model->update('cut',['print_status'=>1],'lot_no',$lot_no);
            $this->General_model->delete('process','lot_no ',$lot_no);
            $this->General_model->delete('process_lot','lot_no',$lot_no);
            $this->General_model->delete('ghadi','lot_no',$lot_no);
            $this->General_model->delete('ghadi_lot','lot_no',$lot_no);
            $this->General_model->delete('emdevide','lot_no',$lot_no);
            $this->General_model->delete('emdevide_lot','lot_no',$lot_no);
            $this->General_model->delete('embroidery','lot_no',$lot_no);
            $this->General_model->delete('embroidery_lot','lot_no',$lot_no);
            $this->General_model->delete('packing','lot_no',$lot_no);
            $this->General_model->delete('packing_lot','lot_no',$lot_no);
            $this->General_model->delete('priting_lot','printing_id',$id);
    		$this->General_model->delete('printing','printing_id',$id);
    		$data['status']="success";
    		$data['msg']="Printing Deleted";
    	}else{
    		$data['status']="error";
    		$data['msg']="Something is Worng";				
    	}
    	echo json_encode($data);
    }
    public function get_detail($id)
	{
		$this->General_model->auth_check();
		if(isset($id) && !empty($id)){				
			$data['lot']=$this->General_model->get_row('balance','lot_no',$id);
			$data['lot_pcs']=$this->db->query("SELECT SUM(devide_pcs) as lot_pcs FROM `devide` WHERE lot_no='".$id."'")->row();
			$patla=$this->db->query("SELECT t1.patla_id,t2.patla_name FROM devide as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id WHERE t1.lot_no='".$id."'")->result();
			$data['patla']=$patla;			
			$data['status']="success";				
		}else{
			$data['status']="error";
		}
		echo json_encode($data);
	}
}