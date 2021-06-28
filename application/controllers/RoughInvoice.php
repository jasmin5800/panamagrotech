<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  RoughInvoice extends CI_Controller {
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
		$data['page_title']="Invoice";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/rough/invoice_detail',$data);
		$this->load->view('admin/controller/footer');
	}
	public function get_addfrm()
	{
		$this->General_model->auth_check();
		$data["party"]=$this->General_model->get_all_where('party','status','1');
		$data["item"]=$this->General_model->get_all_where('item','status','1');
		$data["method"]="add";
		$data['invoice']=$this->db->query("SELECT invoice_no FROM rough_invoice ORDER BY invoice_no DESC LIMIT 1")->row(); 
		if(empty($data['invoice'])){
			$data['invoice']= array('no_invoice' => '1');
		}else{
			$no_invoice=(($data['invoice']->invoice_no)+1);
			$data['invoice']= array('no_invoice' =>$no_invoice);
		}
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/partial/rough_invoice',$data);
		$this->load->view('admin/controller/footer');
	}
	public function invoice_create(){
		$this->General_model->auth_check();
		$bill_type=$this->input->post("bill_type");
		$gst_type=$this->input->post("gst_type");
		$invoice_no=$this->input->post("invoice_no");
		$party=$this->input->post("party_id");	
		$date=$this->input->post("date");
		$date=explode("/", $date);
		$date=[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$t_fine=$this->input->post("t_fine");
		$t_labour=$this->input->post("t_labour");
		$remark=$this->input->post("remark");
		if(isset($bill_type) && !empty($bill_type) && isset($invoice_no) && !empty($invoice_no) && isset($party) && !empty($party) && isset($date) && !empty($date)) {		
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
			if($p_fine>$t_fine){
				$c_fine=abs($p_fine-$t_fine);
				$p_fine=abs($p_fine);
				$status_cfine="cr";				
			}else{
				$c_fine=abs($p_fine-$t_fine);
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
			if($p_rs>$t_labour){
				$c_rs=abs($p_rs-$t_labour);
				$p_rs=abs($p_rs);
				$status_crs="cr";				
			}else{
				$c_rs=abs($p_rs-$t_labour);
				$p_rs=abs($p_rs);
				$status_crs="db";
			}			
			$rough_invoice=['bill_type'=>$bill_type,
							'party_id'=>$party,
							'invoice_no'=>$invoice_no,
							'buyer_name'=>$query->name,
							'address'=>$query->address,
							'city'=>$query->city_name,
							'state'=>$query->state_name,
							'country'=>$query->country,
							'p_fine'=>$p_fine,
							'status_pfine'=>$status_pfine,
							'c_fine'=>$c_fine,
							'status_cfine'=>$status_cfine,
							'p_rs'=>$p_rs,
							'status_prs'=>$status_prs,
							'c_rs'=>$c_rs,
							'status_crs'=>$status_crs,
							'date'=>$date,
							'mobile'=>$query->mobile,							
							't_fine'=>$t_fine,
							't_labour'=>$t_labour,
							'remark'=>$remark,
							'status'=>'1',
							'created_at'=>date("Y-m-d h:i:s")
						];
			$this->db->insert("rough_invoice",$rough_invoice);
			$lastid= $this->db->insert_id();
			foreach ($this->input->post("ctr_no") as $pr) {
				$ctr=$this->input->post("ctr_no")[$i];
				$cbag=$this->input->post("cbag")[$i];
				$cweight=$this->input->post("cweight")[$i];
				$ctweight=$this->input->post("ctweight")[$i];		
				if(!empty($ctr) && !empty($ctr) && !empty($cbag)&& !empty($cbag)&& !empty($cweight)&& !empty($cweight) && !empty($ctweight) && !empty($ctweight)) {						
						$bag=['roughinvoice_id'=>$lastid,
								'tr_no'=>$ctr,
								'bag'=>$cbag,
								'weight'=>$cweight,
								'total'=>$ctweight,												
								'created_at'=>date("Y-m-d h:i:s")];
						$this->db->insert('rough_bag',$bag);						
					} 		
					$i++;
			}
			foreach ($this->input->post("item_id") as $pr) {
				$item_id=$this->input->post("item_id")[$j];
				$mtr=$this->input->post("mtr_no")[$j];
				$g_weight=$this->input->post("mg_weight")[$j];
				$b_weight=$this->input->post("mb_weight")[$j];
				$n_weight=$this->input->post("mn_weight")[$j];		
				$mtouch=$this->input->post("mtouch")[$j];
				$wastage=$this->input->post("mwastage")[$j];
				$t_w=$this->input->post("mtouch_wastage")[$j];
				$fine=$this->input->post("mfine")[$j];
				$rate=$this->input->post("mrate")[$j];
				$jodi=$this->input->post("mjodi")[$j];
				$labour=$this->input->post("mlabour")[$j];
				if(!empty($item_id) && !empty($item_id) && !empty($mtr)&& !empty($mtr) && !empty($lastid) && !empty($lastid)) {						
						$item=['roughinvoice_id'=>$lastid,
								'item_id'=>$item_id,
								'tr_no'=>$mtr,
								'g_weight'=>$g_weight,
								'b_weight'=>$b_weight,
								'n_weight'=>$n_weight,
								'touch'=>$mtouch,
								'wastage'=>$wastage,
								'touch_wastage'=>$t_w,	
								'fine'=>$fine,
								'jodi'=>$jodi,
								'rate'=>$rate,
								'labour'=>$labour,													
								'created_at'=>date("Y-m-d h:i:s")];
						$this->db->insert('rough_item',$item);						
				}		
				$j++;
			}
				$rough_payment=['party_id'=>$party,
									'bill_type'=>'2',
									'roughpur_id'=>NULL,
									'roughinvoice_id'=>$lastid,
									'party_name'=>$query->name,
									'date'=>$date,
									'rs'=>$t_labour,
									'remark'=>'',
									'status'=>'0',
									'created_at'=>date("Y-m-d h:i:s")];
				$this->db->insert("rough_payment",$rough_payment);
				$this->session->set_userdata('Msg','Invoice Generated');
			}else{
				$this->session->set_userdata('Msg','Something Is Missing');			
		}					
			redirect('RoughInvoice');
	}
	public function getLists(){
			$this->General_model->auth_check();
			$table='rough_invoice';
			$order_column_array=array('id_rough', 'bill_type','invoice_no','buyer_name','address','date','mobile','t_fine','t_labour');
			$search_order= array('bill_type','invoice_no','buyer_name','address','mobile','date','t_labour','t_fine');
			$order_by_array= array('id_rough' => 'ASC');
	        $data = $row = array();
	        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
	        $i = $_POST['start'];
	        foreach($Master_Data as $m_data){
	            $i++;
	            $data[] = 	[$i,
	    					date('d/m/Y',Strtotime($m_data->date)),
	    					"S/".$m_data->invoice_no,
	    					$m_data->buyer_name,
	    					$m_data->t_fine,
	    					$m_data->t_labour,
	    					'<a href="'.base_url('RoughInvoice/get_editfrm/').$m_data->id_rough.'"><button type="button" class="btn btn-custom waves-effect waves-light"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
	    					<button type="button" class="btn btn-danger waves-effect waves-light" data-id="delete" data-value="'.$m_data->id_rough.'"><i class="fa fa-trash" aria-hidden="true"></i></button>
	    					<a href="'.base_url('RoughInvoice/invoice/').$m_data->id_rough.'"><button type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-eye"></i></button></a>
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
    	$data["party"]=$this->General_model->get_all_where('party','status','1');
    	$data["item"]=$this->General_model->get_all_where('item','status','1');	  
    	$data['rough_invoice']=$this->General_model->get_row('rough_invoice','id_rough',$id);
    	$data['rough_bag']=$this->General_model->get_data('rough_bag','roughinvoice_id','*',$id);
    	$data['rough_item']=$this->General_model->get_data('rough_item','roughinvoice_id','*',$id);
    	$this->load->view('admin/controller/header');
    	$this->load->view('admin/controller/sidebar');    	
    	$this->load->view('admin/partial/rough_invoice',$data);
    	$this->load->view('admin/controller/footer');
    }
	public function invoice_update()
	{
    	$this->General_model->auth_check();
    	$id_rough=$this->input->post("id_rough");	    	
    	$bill_type=$this->input->post("bill_type");
		$invoice_no=$this->input->post("invoice_no");
		$party=$this->input->post("party_id");	
		$date=$this->input->post("date");
		$date=explode("/", $date);
		$date=[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$t_fine=$this->input->post("t_fine");
		$t_labour=$this->input->post("t_labour");
		$remark=$this->input->post("remark");
		if(isset($bill_type) && !empty($bill_type) && isset($invoice_no) && !empty($invoice_no) && isset($party) && !empty($party) && isset($date) && !empty($date)) {
	    			$i=0;
					$j=0;
					$query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();	
					$purchase_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_purchase` WHERE `party_id`='".$party."'")->row();
					$sell_fines=$this->db->query("SELECT SUM(t_fine)as t_fine FROM `rough_invoice` WHERE `party_id`='".$party."' AND id_rough != '".$id_rough."'")->row();
					$purchase_fine=((isset($purchase_fines->t_fine) && !empty($purchase_fines->t_fine))?$purchase_fines->t_fine:0);
					$sell_fine=((isset($sell_fines->t_fine) && !empty($sell_fines->t_fine))?$sell_fines->t_fine:0);
					$p_fine=$purchase_fine-$sell_fine;
					if($purchase_fine>$sell_fine){
						$status_pfine="cr";
					}else{
						$status_pfine="db";
					}
					if($p_fine>$t_fine){
						$c_fine=abs($p_fine-$t_fine);
						$p_fine=abs($p_fine);
						$status_cfine="cr";				
					}else{
						$c_fine=abs($p_fine-$t_fine);
						$p_fine=abs($p_fine);
						$status_cfine="db";
					}
					$purchase_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='1' and party_id='".$party."'")->row();
					$sell_rupees=$this->db->query("SELECT SUM(`rs`) as p_rs FROM `rough_payment` WHERE bill_type='2' and party_id='".$party."' AND roughinvoice_id != '".$id_rough."'")->row();
					$purchase_rs=((isset($purchase_rupees->p_rs) && !empty($purchase_rupees->p_rs))?$purchase_rupees->p_rs:0);
					$sell_rs=((isset($sell_rupees->p_rs) && !empty($sell_rupees->p_rs))?$sell_rupees->p_rs:0);
					$p_rs=$purchase_rs-$sell_rs;
					if($purchase_rs>$sell_rs){
						$status_prs="cr";
					}else{
						$status_prs="db";
					}
					if($p_rs>$t_labour){
						$c_rs=abs($p_rs-$t_labour);
						$p_rs=abs($p_rs);
						$status_crs="cr";				
					}else{
						$c_rs=abs($p_rs-$t_labour);
						$p_rs=abs($p_rs);
						$status_crs="db";
					}
	    			$rough_invoice=['bill_type'=>$bill_type,
	    							'party_id'=>$party,
	    							'invoice_no'=>$invoice_no,
	    							'buyer_name'=>$query->name,
	    							'address'=>$query->address,
	    							'city'=>$query->city_name,
	    							'state'=>$query->state_name,
	    							'country'=>$query->country,
	    							'p_fine'=>$p_fine,
									'status_pfine'=>$status_pfine,
									'c_fine'=>$c_fine,
									'status_cfine'=>$status_cfine,
									'p_rs'=>$p_rs,
									'status_prs'=>$status_prs,
									'c_rs'=>$c_rs,
									'status_crs'=>$status_crs,
	    							'date'=>$date,
	    							'mobile'=>$query->mobile,							
	    							't_fine'=>$t_fine,
	    							'remark'=>$remark,
	    							't_labour'=>$t_labour
	    						];
	    			$this->General_model->update('rough_invoice',$rough_invoice,'id_rough',$id_rough);   			
	    			foreach ($this->input->post("ctr_no") as $pr) {
	    				$ctr=$this->input->post("ctr_no")[$i];
	    				$cbag=$this->input->post("cbag")[$i];
	    				$cweight=$this->input->post("cweight")[$i];
	    				$ctweight=$this->input->post("ctweight")[$i];
	    				$id_bag=$this->input->post("id_bag")[$i];		
	    				if(isset($id_bag) && !empty($id_bag) && isset($ctr) && !empty($ctr) && isset($cbag)&& !empty($cbag)&& isset($cweight)&& isset($cweight) && isset($ctweight) && !empty($ctweight)) {						
	    						$bag=['roughinvoice_id'=>$id_rough,
	    								'tr_no'=>$ctr,
	    								'bag'=>$cbag,
	    								'weight'=>$cweight,
	    								'total'=>$ctweight,												
	    								];
	    						$this->General_model->update('rough_bag',$bag,'id',$id_bag); 					
	    					}elseif (isset($ctr) && !empty($ctr) && isset($cbag)&& !empty($cbag)&& isset($cweight)&& isset($cweight) && isset($ctweight) && !empty($ctweight)) {
	    							$bag=['roughinvoice_id'=>$id_rough,
	    									'tr_no'=>$ctr,
	    									'bag'=>$cbag,
	    									'weight'=>$cweight,
	    									'total'=>$ctweight,												
	    									'created_at'=>date("Y-m-d h:i:s")];
	    							$this->db->insert('rough_bag',$bag);
	    					}else{
	    					} 		
	    					$i++;
	    			}
	    			foreach ($this->input->post("item_id") as $pr) {
	    				$item_id=$this->input->post("item_id")[$j];
	    				$roughitem_id=$this->input->post("roughitem_id")[$j];
	    				$mtr=$this->input->post("mtr_no")[$j];
	    				$g_weight=$this->input->post("mg_weight")[$j];
	    				$b_weight=$this->input->post("mb_weight")[$j];
	    				$n_weight=$this->input->post("mn_weight")[$j];		
	    				$mtouch=$this->input->post("mtouch")[$j];
	    				$wastage=$this->input->post("mwastage")[$j];
	    				$t_w=$this->input->post("mtouch_wastage")[$j];
	    				$fine=$this->input->post("mfine")[$j];
	    				$rate=$this->input->post("mrate")[$j];
	    				$jodi=$this->input->post("mjodi")[$j];
	    				$labour=$this->input->post("mlabour")[$j];
	    				if(isset($roughitem_id) && !empty($roughitem_id) && isset($item_id) && !empty($item_id) && isset($mtr)&& !empty($mtr)) {
	    					$item=['roughinvoice_id'=>$id_rough,
	    							'item_id'=>$item_id,
	    							'tr_no'=>$mtr,
	    							'g_weight'=>$g_weight,
	    							'b_weight'=>$b_weight,
	    							'n_weight'=>$n_weight,
	    							'touch'=>$mtouch,
	    							'wastage'=>$wastage,
	    							'touch_wastage'=>$t_w,	
	    							'fine'=>$fine,
	    							'jodi'=>$jodi,
	    							'rate'=>$rate,
	    							'labour'=>$labour,													
	    							];
	    					$this->General_model->update('rough_item',$item,'id',$roughitem_id);				
	    				}elseif (isset($item_id) && !empty($item_id) && isset($mtr)&& !empty($mtr)) {
	    					$item=['roughinvoice_id'=>$id_rough,
	    							'item_id'=>$item_id,
	    							'tr_no'=>$mtr,
	    							'g_weight'=>$g_weight,
	    							'b_weight'=>$b_weight,
	    							'n_weight'=>$n_weight,
	    							'touch'=>$mtouch,
	    							'wastage'=>$wastage,
	    							'touch_wastage'=>$t_w,	
	    							'fine'=>$fine,
	    							'jodi'=>$jodi,
	    							'rate'=>$rate,
	    							'labour'=>$labour,													
	    							'created_at'=>date("Y-m-d h:i:s")];
	    					$this->db->insert('rough_item',$item);
	    				}else{
	    				}		
	    				$j++;
	    			}
	    			$rough_payment=['party_id'=>$party,
	    								'bill_type'=>'2',
	    								'party_name'=>$query->name,
	    								'date'=>$date,
	    								'status'=>'0',
	    								'rs'=>$t_labour
	    								 ];
	    			$this->General_model->update('rough_payment',$rough_payment,'roughinvoice_id',$id_rough);
	    			$this->session->set_userdata('Msg','RoughInvoice Updated');
	    	}else{
	    		$this->session->set_userdata('Msg','Something Worng');
	    	}
	    	redirect('RoughInvoice');
	    }
	    public function invoice_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$delete_invoice=$this->General_model->delete('rough_invoice','id_rough',$id);
	    		$delete_product=$this->General_model->delete('rough_bag','roughinvoice_id',$id); 
	    		$delete_product=$this->General_model->delete('rough_item','roughinvoice_id',$id); 
	    		$this->General_model->delete('rough_payment','roughinvoice_id',$id);  		
	    		$data['status']="success";
	    		$data['msg']="Rough Invoice Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
	    public function invoice($id)
	    {
	    	require_once(APPPATH.'third_party/fpdf/fpdf.php');
	    	$pdf = new FPDF();
	    	$pdf->AddPage();
	    	setlocale(LC_MONETARY, 'en_IN');
	    	$r_invoice=$this->General_model->get_row('rough_invoice','id_rough',$id);
	    	$party_id=$r_invoice->party_id;
	    	$party=$this->db->query("SELECT t1.*,t2.name as city_name FROM party as t1 LEFT JOIN city as t2 ON t1.city_id=t2.id WHERE t1.id_party='".$party_id."'")->row();
	    	$image=base_url('assets/admin/images/r_invoice.png');
	    	$pdf->Image($image,0,0,210,0,'PNG');
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(55,36.5);
	    	$pdf->Cell(82,5,$party->name,0,1,'L');
	    	$pdf->SetXY(170,36.5);
	    	$pdf->Cell(25,5,"S/".$r_invoice->invoice_no,0,1,'L');
	    	$pdf->SetXY(55,42.5);
	    	$pdf->Cell(82,5,$party->city_name,0,1,'L');    	
	    	$pdf->SetXY(170,42.5);
	    	$pdf->Cell(33,5,date('d/m/Y',strtotime($r_invoice->date)),0,1,'L');
	    	$i=0;
	    	$y=0;
	    	$r_item=$this->db->query("SELECT t1.*,t2.name as item_name FROM rough_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughinvoice_id='".$id."' ORDER BY `t1`.`tr_no` ASC")->result();
	    	$pdf->SetFont('Arial','',9);
	    	foreach ($r_item as $r_item) {
	    		if($i<6){
	    			$pdf->SetXY(7,57+$y);
	    			$pdf->Cell(8,5,$r_item->tr_no,0,1,'C');
	    			$pdf->SetXY(17,57+$y);
	    			$pdf->MultiCell(33,5,$r_item->item_name,0,'C');
	    			$pdf->SetXY(51,57+$y);
	    			$pdf->Cell(16,5,$r_item->g_weight,0,1,'C');
	    			$pdf->SetXY(68,57+$y);
	    			$pdf->Cell(17,5,$r_item->b_weight,0,1,'C');
	    			$n_weight[]=$r_item->n_weight;
	    			$pdf->SetXY(86,57+$y);
	    			$pdf->Cell(18,5,$r_item->n_weight,0,1,'C');
	    			$pdf->SetXY(105,57+$y);
	    			$pdf->Cell(19,5,number_format($r_item->touch,2),0,1,'C');
	    			$pdf->SetXY(125,57+$y);
	    			$pdf->Cell(17,5,number_format($r_item->wastage,2),0,1,'C');
	    			$fine[]=$r_item->fine;
	    			$pdf->SetXY(143,57+$y);
	    			$pdf->Cell(13,5,$r_item->fine,0,1,'C');
	    			$pdf->SetXY(157,57+$y);
	    			$pdf->Cell(13,5,$r_item->jodi,0,1,'C');
	    			$pdf->SetXY(169.5,57+$y);
	    			$pdf->Cell(13,5,$r_item->rate,0,1,'C');
	    			$labour[]=$r_item->labour;
	    			$pdf->SetXY(183,57+$y);
	    			$pdf->Cell(19,5,money_format('%!i',$r_item->labour),0,1,'C');
	    			$y=7+$y;
	    		}else{
	    		}
	    		$i++;
	    	}
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(86,92);
	    	$pdf->Cell(17,5,array_sum($n_weight),0,1,'C');
	    	$pdf->SetXY(143,92);	    	
	    	$pdf->Cell(13,5,array_sum($fine),0,1,'C');
	    	$pdf->SetXY(183,92);
	    	$pdf->Cell(19,5,money_format('%!i',(array_sum($labour))),0,1,'C');
	    	$j=0;
	    	$z=0;
	    	$s=0;
	    	$pdf->SetFont('Arial','',9);
	    	$r_bag=$this->db->query("SELECT * FROM `rough_bag` WHERE `roughinvoice_id`='".$id."' ORDER BY `rough_bag`.`tr_no` ASC")->result();
	    	foreach ($r_bag as $r_bag) {
	    		if($j<5){
	    			$pdf->SetXY(7,106+$z);
	    			$pdf->Cell(8,5,$r_bag->tr_no,0,1,'C');
	    			$pdf->SetXY(16,106+$z);
	    			$pdf->Cell(18,5,$r_bag->bag,0,1,'C');
	    			$pdf->SetXY(36,106+$z);
	    			$pdf->Cell(18,5,$r_bag->weight,0,1,'C');
	    			$z=6+$z;
	    		}elseif($j>=5 && $j <10){
	    			$pdf->SetXY(75,106+$s);
	    			$pdf->Cell(9,5,$r_bag->tr_no,0,1,'C');
	    			$pdf->SetXY(85,106+$s);
	    			$pdf->Cell(18,5,$r_bag->bag,0,1,'C');
	    			$pdf->SetXY(105,106+$s);
	    			$pdf->Cell(18,5,$r_bag->weight,0,1,'C');
	    			$s=6+$s;
	    		}else{	    			
	    		}
	    		$j++;
	    	}
	    	$pdf->SetFont('Arial','B',10);
	    	$pdf->SetXY(162,103.5);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->p_rs)." ".strtoupper($r_invoice->status_prs),0,1,'L');
	    	$pdf->SetXY(162,111);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->c_rs)." ".strtoupper($r_invoice->status_crs),0,1,'L');
	    	$pdf->SetXY(162,123.5);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->p_fine)." ".strtoupper($r_invoice->status_pfine),0,1,'L');
	    	$pdf->SetXY(162,130.5);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->c_fine)." ".strtoupper($r_invoice->status_cfine),0,1,'L');
//sssssklsnlksnlskmskl slksmslmslk	    	/*nmdkwnsjdnbsjnsjnssn*/
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(55,172);
	    	$pdf->Cell(82,5,$party->name,0,1,'L');
	    	$pdf->SetXY(170,172);
	    	$pdf->Cell(25,5,"S/".$r_invoice->invoice_no,0,1,'L');
	    	$pdf->SetXY(55,178);
	    	$pdf->Cell(82,5,$party->city_name,0,1,'L');    	
	    	$pdf->SetXY(170,178);
	    	$pdf->Cell(33,5,date('d/m/Y',strtotime($r_invoice->date)),0,1,'L');
	    	$i=0;
	    	$y=0;
	    	$r_item=$this->db->query("SELECT t1.*,t2.name as item_name FROM rough_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughinvoice_id='".$id."' ORDER BY `t1`.`tr_no` ASC")->result();
	    	$pdf->SetFont('Arial','',9);
	    	foreach ($r_item as $r_item) {
	    		if($i<6){
	    			$pdf->SetXY(7,192.5+$y);
	    			$pdf->Cell(8,5,$r_item->tr_no,0,1,'C');
	    			$pdf->SetXY(17,192.5+$y);
	    			$pdf->MultiCell(33,5,$r_item->item_name,0,'C');
	    			$pdf->SetXY(51,192.5+$y);
	    			$pdf->Cell(16,5,$r_item->g_weight,0,1,'C');
	    			$pdf->SetXY(68,192.5+$y);
	    			$pdf->Cell(17,5,$r_item->b_weight,0,1,'C');
	    			$n_weight2[]=$r_item->n_weight;
	    			$pdf->SetXY(86,192.5+$y);
	    			$pdf->Cell(18,5,$r_item->n_weight,0,1,'C');
	    			$pdf->SetXY(105,192.5+$y);
	    			$pdf->Cell(19,5,number_format($r_item->touch,2),0,1,'C');
	    			$pdf->SetXY(125,192.5+$y);
	    			$pdf->Cell(17,5,number_format($r_item->wastage,2),0,1,'C');
	    			$fine2[]=$r_item->fine;
	    			$pdf->SetXY(143,192.5+$y);
	    			$pdf->Cell(13,5,$r_item->fine,0,1,'C');
	    			$pdf->SetXY(157,192.5+$y);
	    			$pdf->Cell(13,5,$r_item->jodi,0,1,'C');
	    			$pdf->SetXY(169.5,192.5+$y);
	    			$pdf->Cell(13,5,$r_item->rate,0,1,'C');
	    			$labour2[]=$r_item->labour;
	    			$pdf->SetXY(183,192.5+$y);
	    			$pdf->Cell(19,5,$r_item->labour,0,1,'C');
	    			$y=7+$y;
	    		}else{
	    		}
	    		$i++;
	    	}
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(86,228);
	    	$pdf->Cell(17,5,array_sum($n_weight2),0,1,'C');
	    	$pdf->SetXY(143,228);	    	
	    	$pdf->Cell(13,5,array_sum($fine2),0,1,'C');
	    	$pdf->SetXY(183,228);
	    	$pdf->Cell(19,5,money_format('%!i',(array_sum($labour2))),0,1,'C');
	    	$j=0;
	    	$z=0;
	    	$s=0;
	    	$r_bag=$this->db->query("SELECT * FROM `rough_bag` WHERE `roughinvoice_id`='".$id."' ORDER BY `rough_bag`.`tr_no` ASC")->result();
	    	$pdf->SetFont('Arial','',9);
	    	foreach ($r_bag as $r_bag) {
	    		if($j<5){
	    			$pdf->SetXY(7,242+$z);
	    			$pdf->Cell(8,5,$r_bag->tr_no,0,1,'C');
	    			$pdf->SetXY(16,242+$z);
	    			$pdf->Cell(18,5,$r_bag->bag,0,1,'C');
	    			$pdf->SetXY(36,242+$z);
	    			$pdf->Cell(18,5,$r_bag->weight,0,1,'C');
	    			$z=6+$z;
	    		}elseif($j>=5 && $j <10){
	    			$pdf->SetXY(75,242+$s);
	    			$pdf->Cell(9,5,$r_bag->tr_no,0,1,'C');
	    			$pdf->SetXY(85,242+$s);
	    			$pdf->Cell(18,5,$r_bag->bag,0,1,'C');
	    			$pdf->SetXY(105,242+$s);
	    			$pdf->Cell(18,5,$r_bag->weight,0,1,'C');
	    			$s=6+$s;
	    		}else{	    			
	    		}
	    		$j++;
	    	}
	    	$pdf->SetFont('Arial','B',10);
	    	$pdf->SetXY(162,239);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->p_rs)." ".strtoupper($r_invoice->status_prs),0,1,'L');
	    	$pdf->SetXY(162,246.5);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->c_rs)." ".strtoupper($r_invoice->status_crs),0,1,'L');
	    	$pdf->SetXY(162,259);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->p_fine)." ".strtoupper($r_invoice->status_pfine),0,1,'L');
	    	$pdf->SetXY(162,266.5);
	    	$pdf->Cell(40,5,money_format('%!i',$r_invoice->c_fine)." ".strtoupper($r_invoice->status_cfine),0,1,'L');
	    	/*copt*/
	    	$pdf->Output();
	    }
	    public function invoicebag_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$detail=$this->General_model->delete('rough_bag','id',$id);
	    		$data['status']="success";
	    		$data['msg']="Item Sucessful Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
	    public function invoiceitem_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$detail=$this->General_model->delete('rough_item','id',$id);
	    		$data['status']="success";
	    		$data['msg']="Item Sucessful Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
}