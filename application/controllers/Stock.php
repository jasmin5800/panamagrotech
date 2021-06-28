<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Stock extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('StockModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role2();
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Stock";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/stock/index',$data);
		$this->load->view('admin/controller/footer');
	}
    public function get_addfrm()
    {
    	$this->General_model->auth_check();
		$data['page_title']="Stock";
		$data['party']=$this->General_model->get_data('party','status','*','1');
		$data['item']=$this->General_model->get_data('item','status','*','1');
		$data['transport']=$this->General_model->get_data('transport','status','*','1');
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/stock/create',$data);
		$this->load->view('admin/controller/footer');
    }
	public function create()
	{
		$this->General_model->auth_check();
		$party=trim($this->input->post("party"));
		$item=trim($this->input->post("item"));
		$transport=trim($this->input->post("transport"));
		$date = explode('/',$this->input->post('date')); 
		$date =[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$marchant_no=ucwords(trim($this->input->post("marchant_no")));
		$challan_no=trim($this->input->post("challan_no"));
		$challan_no=str_replace(" ","",$challan_no);
		$challan_no=str_replace(".","-",$challan_no);
		$t_bala=trim($this->input->post("t_bala"));
		$t_taka=trim($this->input->post("t_taka"));
		$t_mtr=trim($this->input->post("t_mtr"));
		$mtr_value=trim($this->input->post("mtr_value"));
		$sub_total=trim($this->input->post("sub_total"));
		$tax=trim($this->input->post("tax"));
		$g_total=trim($this->input->post("g_total"));
		if(isset($party) && !empty($party) && isset($challan_no) && !empty($challan_no) && isset($item) && !empty($item) && isset($date) && !empty($date) && isset($t_bala) && !empty($t_bala) && isset($t_taka) && !empty($t_taka) && isset($mtr_value) && !empty($mtr_value) && isset($sub_total) && !empty($sub_total) && isset($g_total) && !empty($g_total)){
			
		$partydetail=$this->General_model->get_row('party','party_id',$party);
		$detail=['party_id'=>$party,
					'challan_no'=>$challan_no,
					'date'=>$date,
					'marchant_no'=>$marchant_no,
					'item_id'=>$item,
					'mobile'=>$partydetail->mobile_number,
					't_bala'=>$t_bala,
					'gst_no'=>$partydetail->gst_number,
					'pan_no'=>$partydetail->pan_number,
					'total_meter'=>$t_mtr,
					'meter_value'=>$mtr_value,
					'sub_total'=>$sub_total,
					'tax'=>$tax,
					'g_total'=>$g_total,
					'transport_id'=>$transport,
					'lot_no'=>NULL,
					'user_id'=>$_SESSION['auth_user_id'],
					'status'=>'1',
					'created_at'=>date("Y-m-d h:i:s")];
				$stock = $this->General_model->addid('stock',$detail);
				$i=0;
				$msg="Stock insert id ".$stock;
				$this->LogModel->simplelog($msg);
				foreach($this->input->post('bala_no') as $lt)
				{
					$bala_no=$this->input->post('bala_no')[$i]; 
					$taka=$this->input->post('taka')[$i]; 
					$mtr=$this->input->post('mtr')[$i]; 
					$lr_no=$this->input->post('lr_no')[$i];
					$lr_date = explode('/',$this->input->post('lr_date')[$i]);
					$lr_date =[$lr_date[2],$lr_date[1],$lr_date[0]];
					$lr_date=implode("-", $lr_date);	
					if(isset($bala_no) && !empty($bala_no) && isset($taka) && !empty($taka) && isset($mtr) && !empty($mtr) && isset($lr_date) && !empty($lr_date)){
						$stock_product = [
							'stock_id'=>$stock, 
								'bala_no'=>$bala_no, 
								'taka'=>$taka, 
								'mtr'=>$mtr, 
								'lr_date'=>$lr_date, 
								'lr_no'=>$lr_no, 						
								'created_at'=>date('Y/m/d H:m:i'),						
								'status'=>'1'
						];
						$this->General_model->add('stock_product',$stock_product);
					}
					$i++;
				}
			$sess_data = ['status'  => 'success',
				            'msg'  => 'Stock Added' ];
			$this->session->set_userdata($sess_data);
			redirect('Stock/view_invoice/'.$stock);
		}else{
			$sess_data = ['status'  => 'error',
				            'msg'  => 'Something Is Worng' ];
			$this->session->set_userdata($sess_data);
			redirect('Stock/get_addfrm/');
		}
	}
	public function getLists(){
		$columns = array( 
                    0 =>'stock_id', 
                    1 =>'date',
                    2=> 'party_name',
                    3=> 'item_name',
                    4 =>'challan_no',
                    5=> 'meter_value',
                    6=> 'total_meter',
                    7=> 'g_total',
                    8=> 'transport_name',
                    9=> 'user_name'
                );
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->StockModel->allposts_count();
		$totalFiltered = $totalData; 
		if(empty($this->input->post('search')['value']))
		{            
		    $posts = $this->StockModel->allposts($limit,$start,$order,$dir);
		}
		else {
		    $search = $this->input->post('search')['value']; 
		    $posts =  $this->StockModel->posts_search($limit,$start,$search,$order,$dir);
		    $totalFiltered = $this->StockModel->posts_search_count($search);
		}
		$data = array();
		if(!empty($posts))
		{
		    $i=1;
		    foreach ($posts as $post)
		    {
		    	if($_SESSION['auth_role_id']=="1"){
		    		$button='<a href="'.base_url('Stock/view_invoice/').$post->stock_id.'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
		        		<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->stock_id.'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
		    	}else{
		    		$button='<a href="'.base_url('Stock/view_invoice/').$post->stock_id.'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
		    	}
		        $nestedData['sr_no'] =$i;
		        $nestedData['date'] =date('d/m/Y',strtotime($post->date));
		        $nestedData['party_name'] =$post->party_name;
		        $nestedData['item_name'] = $post->item_name;
		        $nestedData['challan_no'] =$post->challan_no;
		        $nestedData['meter_value'] =number_format($post->meter_value,2);
		        $nestedData['total_meter'] = number_format($post->total_meter,2);
		        $nestedData['g_total'] =number_format($post->g_total,2);
		        $nestedData['transport_name'] = $post->transport_name;
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
    }
    public function update()
    {
    }
    public function view_invoice($id)
    {
    	$data['page_title']="Stock";
    	$data['stock'] = $this->db->query("SELECT t1.*,t2.party_name,t3.transport_name,t4.item_name FROM stock as t1 LEFT JOIN party as t2 ON t1.party_id = t2.party_id LEFT JOIN transport as t3 ON t1.transport_id = t3.transport_id LEFT JOIN item as t4 ON t1.item_id = t4.item_id WHERE stock_id='".$id."'")->row();
    	$data['stockdetail'] = $this->General_model->get_data('stock_product','stock_id','*',$id);
    	$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/stock/invoice',$data);
		$this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
    	$this->General_model->auth_check();
    	if(isset($id) && !empty($id)){
    		$i=0;
			$msg="Stock Deleted ".$id;
			$this->LogModel->simplelog($msg);
    		$detail=$this->General_model->delete('stock','stock_id',$id);
    		$detail=$this->General_model->delete('stock_product','stock_id',$id);
    		$data['status']="success";
    		$data['msg']="Stock Deleted";
    	}else{
    		$data['status']="error";
    		$data['msg']="Something is Worng";				
    	}
    	echo json_encode($data);
    }
    public function check_challan()
    {
    	$this->General_model->auth_check();
    	$party=$this->input->post('party');
    	$challan_no =trim($this->input->post('challan_no'));
    	$challan_no=str_replace(" ","",$challan_no);
    	$challan_no=str_replace(".","-",$challan_no);
    	if(isset($party) && !empty($party) && isset($challan_no) && !empty($challan_no) ){
    		$check_challan=$this->db->query("SELECT * FROM `stock` WHERE party_id='".$party."' and challan_no LIKE '".$challan_no."'")->num_rows();
    		if($check_challan > 0){
    			$data['status']="error";
    			$data['msg']="Party's Challan Number Already Exist";
    		}else{
    			$data['status']="success";
    		}
    	}else{
    		$data['status']="error";
    		$data['msg']="Something is Worng";				
    	}
    	echo json_encode($data);
    }
}