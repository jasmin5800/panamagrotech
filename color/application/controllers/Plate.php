<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Plate extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('PlateModel');
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Plate";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/plate/index',$data);
		$this->load->view('admin/controller/footer');
	}
	public function create()
	{
		$this->General_model->auth_check();
		$data['page_title']="Plate";
		$data["method"]="add";
		$data['frm_id']="Add_frm";
		$color=$this->db->where('status','1')->get('color');
		$data['color']=$color->result();
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/plate/create',$data);
		$this->load->view('admin/controller/footer');
	}
	public function store()
	{
		$this->General_model->auth_check();
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$design=$this->input->post('design');
		$remark=$this->input->post('remark');
		if(isset($date) && !empty($date) &&  isset($design) && !empty($design)){
		    $challan_no=$this->PlateModel->challan_no();
		    $detail=['challan_no'=>$challan_no['challan_no'],
		                'design'=>$design,
		                'date'=>$date,
		                'remark'=>$remark,
		                'user_id'=>$_SESSION['auth_user_id'],
		                'status'=>'1',		                
		                'created_at'=>date("Y-m-d h:i:s"),
		            	'modify_at'=>NULL ];
		    $plate_id=$this->General_model->addid('plate',$detail);
		    $i=0;
		    foreach ($this->input->post('plate_no') as $key) {
		        $plate_no=$this->input->post('plate_no')[$i];
		        $color=$this->input->post('color')[$i];
		        $match_no=$this->input->post('match_no')[$i];
		        $gram=$this->input->post('gram')[$i];
		        $gram=$this->PlateModel->garmConvert($gram);
		        if(isset($plate_id) && !empty($plate_id) && !empty($plate_no) && !empty($color)  &&!empty($gram)){
		            $plate_lot=['plate_id'=>$plate_id,
		                            'plate_no'=>$plate_no,
		                            'match_no'=>$match_no,
		                            'color_id'=>$color,
		                            'gram'=>$gram,
		                            'status'=>'1',
		                            'created_at'=>date("Y-m-d h:i:s"),
		            				'modify_at'=>NULL ];
		            $this->General_model->add('plate_lot',$plate_lot);
		            }
		        $i++;
		    }
		    $sess_data = ['status'  => 'success',
		                    'msg'  => 'Plate Added' ];
		    $this->session->set_userdata($sess_data);       
		    redirect('plate/show/'.$plate_id);
		}else{
		    $sess_data = ['status'  => 'error',
		                    'msg'  => 'Something Is Worng' ];
		    $this->session->set_userdata($sess_data);   
		    redirect('palte/create/');
		}
	}
	public function getLists(){
	    $columns = array( 
	                0=>'id', 
	                1=> 'design',
	                2=> 'date',
	                3=> 'challan_no',
	                4=> 'remark',
	                5=> 'user_name',
	            );
	    $limit = $this->input->post('length');
	    $start = $this->input->post('start');
	    $order = $columns[$this->input->post('order')[0]['column']];
	    $dir = $this->input->post('order')[0]['dir'];
	    $totalData = $this->PlateModel->allposts_count();
	    $totalFiltered = $totalData; 
	    if(empty($this->input->post('search')['value']))
	    {            
	        $posts = $this->PlateModel->allposts($limit,$start,$order,$dir);
	    }
	    else {
	        $search = $this->input->post('search')['value']; 
	        $posts =  $this->PlateModel->posts_search($limit,$start,$search,$order,$dir);
	        $totalFiltered = $this->PlateModel->posts_search_count($search);
	    }
	    $data = array();
	    if(!empty($posts))
	    {
	        setlocale(LC_MONETARY, 'en_IN');
	        $i=1;
	        foreach ($posts as $post)
	        {
	            $nestedData['sr_no'] =$i;
	            $nestedData['design'] =$post->design;
	            $nestedData['date'] =date('d/m/Y',strtotime($post->date));
	            $nestedData['challan_no'] =$post->challan_no;
	            $nestedData['remark'] =ucwords($post->remark);
	            $nestedData['user_name'] =ucwords($post->user_name);
	            $nestedData['button'] ='
	            <a href="'.base_url('plate/edit/').$post->id .'"><button type="button" class="btn btn-primary waves-effect btn-sm waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
	            <a href="'.base_url('plate/show/').$post->id .'"><button type="button" class="btn btn-success waves-effect btn-sm waves-light"><i class="mdi mdi-eye" aria-hidden="true"></i></button></a>
	            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>
	            ';
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
	public function show($id)
	{
		$this->General_model->auth_check();
		$data['page_title']="Plate";
		$data['plate']=$this->General_model->get_row('plate','id',$id);
		$plate_lot=$this->db->select('t1.*,t2.name as color_name')
						->join('color as t2', 't1.color_id = t2.id', 'left')
						->where('plate_id',$id)
						->get('plate_lot as t1');
		$data['plate_lot']=$plate_lot->result();
		foreach ($data['plate_lot'] as $key => $value) {
			$data['custom_plate'][$value->plate_no][$value->match_no][]=['color_name'=>$value->color_name,'gram'=>$this->PlateModel->customOrsign("$value->gram")];
		}
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/plate/invoice',$data);
		$this->load->view('admin/controller/footer');
	}
	public function edit($id)
	{
		$this->General_model->auth_check();
		$data['page_title']="Plate";
		$data['color']=$this->General_model->get_all('color');
		$data['plate']=$this->General_model->get_row('plate','id',$id);
		$plate_lot=$this->General_model->get_data('plate_lot','plate_id','*',$id);
		foreach ($plate_lot as $key => $value) {
			$data['plate_lot'][$value->plate_no][]=
							['id'=>$value->id,
								'plate_no'=>$value->plate_no,
								'color_id'=>$value->color_id,
								'match_no'=>$value->match_no,
								'gram'=>$this->PlateModel->customOrsign("$value->gram"),
									];
		}
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/plate/edit',$data);
		$this->load->view('admin/controller/footer');
	}
	public function update()
	{
		$this->General_model->auth_check();
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$design=$this->input->post('design');
		$remark=$this->input->post('remark');
		$plate_id=$this->input->post('plate_id');
		if(isset($date) && !empty($date) &&  isset($design) && !empty($design) && isset($plate_id) && !empty($plate_id)){
		    $detail=['design'=>$design,
		                'date'=>$date,
		                'remark'=>$remark,
		                'user_id'=>$_SESSION['auth_user_id'],
		            	'modify_at'=>date("Y-m-d h:i:s") ];
		    $this->General_model->update('plate',$detail,'id',$plate_id);
		    $i=0;
		    foreach ($this->input->post('plate_no') as $key) {
		        $plate_no=$this->input->post('plate_no')[$i];
		        $color=$this->input->post('color')[$i];
		        $match_no=$this->input->post('match_no')[$i];
		        $gram=$this->input->post('gram')[$i];
		        $gram=$this->PlateModel->garmConvert($gram);
		        $platelot_id=$this->input->post('platelot_id')[$i];
		        if(isset($platelot_id) && !empty($platelot_id) && isset($plate_id) && !empty($plate_id) && !empty($plate_no) && !empty($color)  &&!empty($gram)){
		            $plate_lot=['plate_no'=>$plate_no,
		                            'match_no'=>$match_no,
		                            'color_id'=>$color,
		                            'gram'=>$gram,
		            				'modify_at'=>date("Y-m-d h:i:s") ];
		            $this->General_model->update('plate_lot',$plate_lot,'id',$platelot_id);
		         }elseif(isset($plate_id) && !empty($plate_id) && !empty($plate_no) && !empty($color)  &&!empty($gram)){
		         	$plate_lot=['plate_id'=>$plate_id,
		         	                'plate_no'=>$plate_no,
		         	                'match_no'=>$match_no,
		         	                'color_id'=>$color,
		         	                'gram'=>$gram,
		         	                'status'=>'1',
		         	                'created_at'=>date("Y-m-d h:i:s"),
		         					'modify_at'=>NULL ];
		         	$this->General_model->add('plate_lot',$plate_lot);
		         }else{
		         }
		        $i++;
		    }
		    $sess_data = ['status'  => 'success',
		                    'msg'  => 'Plate Added' ];
		    $this->session->set_userdata($sess_data);       
		    redirect('plate/show/'.$plate_id);
		}else{
		    $sess_data = ['status'  => 'error',
		                    'msg'  => 'Something Is Worng' ];
		    $this->session->set_userdata($sess_data);   
		    redirect('palte/index/');
		}
	}
	public function delete($id)
	{
		$this->General_model->auth_check();
		if(isset($id) && !empty($id)){
			$this->General_model->delete('plate_lot','plate_id',$id);
			$this->General_model->delete('plate','id',$id);
			$data['status']="success" ;
			$data['msg']="Plate Deleted Successful";
		}else{
			$data['status']="error";
			$data['msg']="Something is Worng";				
		}
		echo json_encode($data);
	}
}