<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  RoughPurchase extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('Genral_datatable');
        $this->load->database();
        $this->General_model->auth_admin();
    }
	public function index()
	{
		$this->General_model->auth_check();
		$data['page_title']="Purchase";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/rough/purchase/purchase_detail',$data);
		$this->load->view('admin/controller/footer');
	}
	public function get_addfrm()
	{
		$this->General_model->auth_check();
		$data["party"]=$this->General_model->get_all_where('party','status','1');
		$data["item"]=$this->General_model->get_all_where('item','status','1');
		$data["method"]="add";
		$data['page_title']="Purchase";
		$data['action']=base_url('RoughPurchase/invoice_create');
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/partial/rough_purchase',$data);
		$this->load->view('admin/controller/footer');
	}
	public function invoice_create(){
		$this->General_model->auth_check();
		$invoice_no=$this->input->post("invoice_no");
		$party=$this->input->post("party_id");	
		$date=$this->input->post("date");
		$date=explode("/", $date);
		$date=[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$t_fine=$this->input->post("t_fine");
		$t_amount=$this->input->post("t_amount");
		$remark=$this->input->post("remark");
		if(isset($party) && !empty($party) && isset($date) && !empty($date)) {		
			$i=0;
			$j=0;
			$query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();
			$purchase_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_purchase` WHERE `party_id`='".$party."'")->row();
			$sell_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_invoice` WHERE `party_id`='".$party."'")->row();
			$purchase_fine=((isset($purchase_fines->t_fine) && !empty($purchase_fines->t_fine))?$purchase_fines->t_fine:0);
			$sell_fine=((isset($sell_fines->t_fine) && !empty($sell_fines->t_fine))?$sell_fines->t_fine:0);
			$p_fine=$purchase_fine-$sell_fine;
			if($purchase_fine>$sell_fine){
				$status_pfine="cr";
			}else{
				$status_pfine="db";
			}
			if($p_fine+$t_fine>0){
				$c_fine=abs($p_fine+$t_fine);
				$p_fine=abs($p_fine);
				$status_cfine="cr";				
			}else{
				$c_fine=abs($p_fine+$t_fine);
				$p_fine=abs($p_fine);
				$status_cfine="db";
			}
			$purchase_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='1' and party_id='".$party."'")->row();
			$sell_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='2' and party_id='".$party."'")->row();
			$purchase_rs=((isset($purchase_rupees->p_rs) && !empty($purchase_rupees->p_rs))?$purchase_rupees->p_rs:0);
			$sell_rs=((isset($sell_rupees->p_rs) && !empty($sell_rupees->p_rs))?$sell_rupees->p_rs:0);
			$p_rs=$purchase_rs-$sell_rs;
			if($purchase_rs>$sell_rs){
				$status_prs="cr";
			}else{
				$status_prs="db";
			}
			if($p_rs+$t_amount>0){
				$c_rs=abs($p_rs+$t_amount);
				$p_rs=abs($p_rs);
				$status_crs="cr";				
			}else{
				$c_rs=abs($p_rs+$t_amount);
				$p_rs=abs($p_rs);
				$status_crs="db";
			}
			$rough_purchase=['party_id'=>$party,
							'invoice_no'=>$invoice_no,
							'buyer_name'=>$query->name,
							'address'=>$query->address,
							'city'=>$query->city_name,
							'state'=>$query->state_name,
							'country'=>$query->country,
							'date'=>$date,
							'p_fine'=>$p_fine,
							'status_pfine'=>$status_pfine,
							'c_fine'=>$c_fine,
							'status_cfine'=>$status_cfine,
							'p_rs'=>$p_rs,
							'status_prs'=>$status_prs,
							'c_rs'=>$c_rs,
							'status_crs'=>$status_crs,
							'mobile'=>$query->mobile,							
							't_fine'=>$t_fine,
							't_amount'=>$t_amount,
							'remark'=>$remark,
							'status'=>'1',
							'created_at'=>date("Y-m-d h:i:s")
						];
			$this->db->insert("rough_purchase",$rough_purchase);
			
			$lastid= $this->db->insert_id();
			foreach ($this->input->post("item_id") as $pr) {
				$item_id=$this->input->post("item_id")[$j];
				$gr_wt=$this->input->post("mg_weight")[$j];
				$bag_wt=$this->input->post("mb_weight")[$j];
				$n_weight=$this->input->post("mn_weight")[$j];		
				$ghat=$this->input->post("mghat")[$j];
				$ttl_wt=$this->input->post("mt_weight")[$j];
				$mtouch=$this->input->post("mtouch")[$j];
				$wastage=$this->input->post("mwastage")[$j];
				$t_w=$this->input->post("mtouch_wastage")[$j];
				$fine=$this->input->post("mfine")[$j];
				$nos=$this->input->post("mnos")[$j];
				$rate=$this->input->post("mrate")[$j];
				$amount=$this->input->post("mamount")[$j];
				if(isset($item_id) && !empty($item_id) && isset($lastid) && !empty($lastid)) {						
						$item=['roughpurchase_id'=>$lastid,
								'item_id'=>$item_id,								
								'gr_weight'=>$gr_wt,
								'bag_weight'=>$bag_wt,
								'n_weight'=>$n_weight,								
								'ghat'=>$ghat,
								'ttl_weight'=>$ttl_wt,
								'touch'=>$mtouch,
								'wastage'=>$wastage,
								'touch_wastage'=>$t_w,	
								'fine'=>$fine,
								'nos'=>$nos,	
								'rate'=>$rate,	
								'amount'=>$amount,	
								'created_at'=>date("Y-m-d h:i:s")];
						$this->db->insert('roughpurchase_item',$item);						
				}		
				$j++;
			}	
				$rough_payment=['party_id'=>$party,
									'bill_type'=>'1',
									'roughpur_id'=>$lastid,
									'roughinvoice_id'=>NULL,
									'party_name'=>$query->name,
									'date'=>$date,
									'rs'=>$t_amount,
									'remark'=>'',
									'status'=>'0',
									'created_at'=>date("Y-m-d h:i:s")];
				$this->db->insert("rough_payment",$rough_payment);
				$this->session->set_userdata('Msg','Purchase Invoice Generated');
			}else{
				$this->session->set_userdata('Msg','Something Is Missing');			
		}					
		redirect('RoughPurchase');
	}
	public function getLists(){
			$this->General_model->auth_check();
			$table='rough_purchase';
			$order_column_array=array('id_rough','invoice_no','buyer_name','address','date','mobile','t_fine','t_amount');
			$search_order= array('invoice_no','buyer_name','address','mobile','date','t_amount','t_fine');
			$order_by_array= array('id_rough' => 'ASC');
	        $data = $row = array();
	        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
	        $i = $_POST['start'];
	        foreach($Master_Data as $m_data){
	            $i++;
	            $data[] = 	[$i,
	    					ucwords($m_data->buyer_name),
	    					date('d/m/Y',Strtotime($m_data->date)),
	    					"P/".$m_data->invoice_no,
	    					$m_data->t_fine,
	    					$m_data->t_amount,
	    					'<a href="'.base_url('RoughPurchase/get_editfrm/').$m_data->id_rough.'"><button type="button" class="btn btn-custom waves-effect waves-light"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
	    					<button type="button" class="btn btn-danger waves-effect waves-light" data-id="delete" data-value="'.$m_data->id_rough.'"><i class="fa fa-trash" aria-hidden="true"></i></button>
	    					<a href="'.base_url('RoughPurchase/invoice_view/').$m_data->id_rough.'"><button type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-eye"></i></button></a>
	    					'];
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
    	$data['page_title']="Purchase";
		$data['action']=base_url('RoughPurchase/invoice_update');  
    	$data["party"]=$this->General_model->get_all_where('party','status','1');
    	$data["item"]=$this->General_model->get_all_where('item','status','1');	  
    	$data['rough_purchase']=$this->General_model->get_row('rough_purchase','id_rough',$id);
    	$data['rough_item']=$this->General_model->get_data('roughpurchase_item','roughpurchase_id','*',$id);
    	$this->load->view('admin/controller/header');
    	$this->load->view('admin/controller/sidebar');
    	$this->load->view('admin/partial/rough_purchase',$data);
    	$this->load->view('admin/controller/footer');
    }
	public function invoice_update()
	{
    	$this->General_model->auth_check();
    	$id_rough=$this->input->post("id_rough");	    	
		$invoice_no=$this->input->post("invoice_no");
		$party=$this->input->post("party_id");	
		$date=$this->input->post("date");
		$date=explode("/", $date);
		$date=[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$t_fine=$this->input->post("t_fine");
		$t_amount=$this->input->post("t_amount");
		$remark=$this->input->post("remark");
		if(isset($party) && !empty($party) && isset($date) && !empty($date)) {
	    			$i=0;
					$j=0;
					$invoice_no=((isset($invoice_no) && !empty($invoice_no))?$invoice_no:NULL);
					$query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();	
					$purchase_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_purchase` WHERE `party_id`='".$party."' and id_rough != '".$id_rough."'")->row();
					$sell_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_invoice` WHERE `party_id`='".$party."'")->row();
					$purchase_fine=((isset($purchase_fines->t_fine) && !empty($purchase_fines->t_fine))?$purchase_fines->t_fine:0);
					$sell_fine=((isset($sell_fines->t_fine) && !empty($sell_fines->t_fine))?$sell_fines->t_fine:0);
					$p_fine=$purchase_fine-$sell_fine;
					if($purchase_fine>$sell_fine){
						$status_pfine="cr";
					}else{
						$status_pfine="db";
					}
					if($p_fine+$t_fine>0){
						$c_fine=abs($p_fine+$t_fine);
						$p_fine=abs($p_fine);
						$status_cfine="cr";				
					}else{
						$c_fine=abs($p_fine+$t_fine);
						$p_fine=abs($p_fine);
						$status_cfine="db";
					}
					$purchase_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='1' and party_id='".$party."' and roughpur_id != '".$id_rough."'")->row();
					$sell_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='2' and party_id='".$party."'")->row();
					$purchase_rs=((isset($purchase_rupees->p_rs) && !empty($purchase_rupees->p_rs))?$purchase_rupees->p_rs:0);
					$sell_rs=((isset($sell_rupees->p_rs) && !empty($sell_rupees->p_rs))?$sell_rupees->p_rs:0);
					$p_rs=$purchase_rs-$sell_rs;
					if($purchase_rs>$sell_rs){
							$status_prs="cr";
					}else{
							$status_prs="db";
					}
					if($p_rs+$t_amount>0){
							$c_rs=abs($p_rs+$t_amount);
							$p_rs=abs($p_rs);
							$status_crs="cr";				
					}else{
							$c_rs=abs($p_rs+$t_amount);
							$p_rs=abs($p_rs);
							$status_crs="db";
					}	
	    			$rough_purchase=['party_id'=>$party,
	    							'invoice_no'=>$invoice_no,
	    							'buyer_name'=>$query->name,
	    							'address'=>$query->address,
	    							'city'=>$query->city_name,
	    							'state'=>$query->state_name,
	    							'country'=>$query->country,
	    							'date'=>$date,
	    							'p_fine'=>$p_fine,
									'status_pfine'=>$status_pfine,
									'c_fine'=>$c_fine,
									'status_cfine'=>$status_cfine,
									'p_rs'=>$p_rs,
									'status_prs'=>$status_prs,
									'c_rs'=>$c_rs,
									'status_crs'=>$status_crs,
	    							'mobile'=>$query->mobile,
	    							'remark'=>$remark,							
	    							't_fine'=>$t_fine,
	    							't_amount'=>$t_amount,
	    						];
	    			$this->General_model->update('rough_purchase',$rough_purchase,'id_rough',$id_rough);  
	    			foreach ($this->input->post("item_id") as $pr) {
	    				$roughitem_id=$this->input->post("roughitem_id")[$j];
	    				$item_id=$this->input->post("item_id")[$j];
	    				$gr_wt=$this->input->post("mg_weight")[$j];
	    				$bag_wt=$this->input->post("mb_weight")[$j];
	    				$n_weight=$this->input->post("mn_weight")[$j];		
	    				$ghat=$this->input->post("mghat")[$j];
	    				$ttl_wt=$this->input->post("mt_weight")[$j];
	    				$mtouch=$this->input->post("mtouch")[$j];
	    				$wastage=$this->input->post("mwastage")[$j];
	    				$t_w=$this->input->post("mtouch_wastage")[$j];
	    				$fine=$this->input->post("mfine")[$j];
	    				$nos=$this->input->post("mnos")[$j];
	    				$rate=$this->input->post("mrate")[$j];
	    				$amount=$this->input->post("mamount")[$j];
	    				if(isset($roughitem_id) && !empty($roughitem_id) && isset($item_id) && !empty($item_id)) {
	    					$item=['roughpurchase_id'=>$id_rough,
	    							'item_id'=>$item_id,								
	    							'gr_weight'=>$gr_wt,
	    							'bag_weight'=>$bag_wt,
	    							'n_weight'=>$n_weight,								
	    							'ghat'=>$ghat,
	    							'ttl_weight'=>$ttl_wt,
	    							'touch'=>$mtouch,
	    							'wastage'=>$wastage,
	    							'touch_wastage'=>$t_w,	
	    							'fine'=>$fine,
	    							'nos'=>$nos,	
	    							'rate'=>$rate,	
	    							'amount'=>$amount,	
	    							];
	    					$this->General_model->update('roughpurchase_item',$item,'id',$roughitem_id);				
	    				}elseif (isset($item_id) && !empty($item_id)) {
	    					$item=['roughpurchase_id'=>$id_rough,
	    							'item_id'=>$item_id,								
	    							'gr_weight'=>$gr_wt,
	    							'bag_weight'=>$bag_wt,
	    							'n_weight'=>$n_weight,								
	    							'ghat'=>$ghat,
	    							'ttl_weight'=>$ttl_wt,
	    							'touch'=>$mtouch,
	    							'wastage'=>$wastage,
	    							'touch_wastage'=>$t_w,	
	    							'fine'=>$fine,
	    							'nos'=>$nos,	
	    							'rate'=>$rate,	
	    							'amount'=>$amount,	
	    							'created_at'=>date("Y-m-d h:i:s")];
	    					$this->db->insert('roughpurchase_item',$item);
	    				}else{
	    				}		
	    				$j++;
	    			}
	    			$rough_payment=['party_id'=>$party,
	    								'bill_type'=>'1',
	    								'party_name'=>$query->name,
	    								'date'=>$date,
	    								'status'=>'0',
	    								'rs'=>$t_amount ];
	    			$this->General_model->update('rough_payment',$rough_payment,'roughpur_id',$id_rough);
	    			$this->session->set_userdata('Msg','Rough Purchase Updated');
	    	}else{
	    		$this->session->set_userdata('Msg','Something Worng');
	    	}
	    	redirect('RoughPurchase');
	    }
	    public function invoice_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$this->General_model->delete('rough_purchase','id_rough',$id);  	 		
	    		$this->General_model->delete('roughpurchase_item','roughpurchase_id',$id);
	    		$this->General_model->delete('rough_payment','roughpur_id',$id); 
	    		$data['status']="success";
	    		$data['msg']="Rough Purchase Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
	    public function invoice_view($id)
	    {
	    	$this->General_model->auth_check();
	    	$data['p_invoice']=$this->General_model->get_row('rough_purchase','id_rough',$id);
	    	$data['party']=$this->db->query("SELECT t1.*,t2.name as city_name,t2.code as city_code,t3.name state_name,t3.code as state_code,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id =t2.id LEFT JOIN state as t3 ON t1.state_id=t3.id WHERE t1.id_party='".$data['p_invoice']->party_id."'")->row();
	    	$data['r_item']=$this->db->query("SELECT t1.*,t2.name as item_name FROM roughpurchase_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughpurchase_id='".$id."'")->result();
	    	$data['page_title']="Purchase Invoice";
	    	$this->load->view('admin/controller/header');
			$this->load->view('admin/controller/sidebar');
			$this->load->view('admin/rough/purchase/purchase_inv',$data);
			$this->load->view('admin/controller/footer');
	    }
	    public function purchseitem_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$detail=$this->General_model->delete('roughpurchase_item','id',$id);
	    		$data['status']="success";
	    		$data['msg']="Item Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
}