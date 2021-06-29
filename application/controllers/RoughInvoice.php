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
			$data['page_title']="JAVAK";
			$this->load->view('admin/controller/header');
			$this->load->view('admin/controller/sidebar');
			$this->load->view('admin/rough/invoice_detail',$data);
			$this->load->view('admin/controller/footer');
		}
		public function get_addfrm()
		{
			$this->General_model->auth_check();
			$data["party"]=$this->General_model->get_all_where('party','party_type','0');
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
		public function get_opening($party_id)
		{
            $party=$this->db->query("SELECT t1.*,t2.name as city_name FROM party as t1 LEFT JOIN city as t2 ON t1.city_id=t2.id WHERE t1.id_party='".$party_id."'")->row(); 
           
            $d_total=$this->db->query("SELECT SUM(t1.fine) as d_total,SUM(t1.labour) as d_labour FROM rough_item as t1 LEFT JOIN rough_invoice as t2 ON t1.roughinvoice_id=t2.id_rough LEFT JOIN item as t3 ON t1.`item_id` = t3.id_item WHERE  t2.bill_type='debit' AND t2.party_id='".$party_id."'")->row();
                
            $c_total=$this->db->query("SELECT sum(t2.t_fine2) as c_total,sum(t2.t_amount2) as c_amount FROM rough_purchase as t2  WHERE   t2.party_id='".$party_id."'")->row();
     
            $amount = $d_total->d_labour -   $c_total->c_amount + $party->camount;
            $fine = $d_total->d_total -   $c_total->c_total + $party->cfine;
    
            echo $amount.",".$fine;
		}
       
        
		public function get_addfrmghat()
		{
			$this->General_model->auth_check();
			$data["party"]=$this->General_model->get_all_where('party','party_type','0');
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
			$this->load->view('admin/partial/rough_invoice_ghat',$data);
			$this->load->view('admin/controller/footer');
		}
		public function invoice_create(){
			$this->General_model->auth_check();
			$bill_type=$this->input->post("bill_type");
			$bill_typo=$this->input->post("bill_typo");
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
			$tf=$this->input->post("tf");
			if(isset($bill_type) && !empty($bill_type) && isset($invoice_no) && !empty($invoice_no) && isset($party) && !empty($party) && isset($date) && !empty($date)) {		
				$i=0;
                $j=0;
                $query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();
		
				$p_fine=$this->input->post("pfine");
				$status_pfine=$this->input->post("pfines");
				
                    
                
					$c_fine=$this->input->post("cfine");
				
					$status_cfine=$this->input->post("cfines");			
					
                      $p_rs=$this->input->post("pamount");
				
					$status_prs=$this->input->post("pamounts");
				
			
					$c_rs=$this->input->post("camount");
                    
					$status_crs=$this->input->post("camounts");
					
				$rough_invoice=['bill_type'=>$bill_type,
				'party_id'=>$party,
				'invoice_no'=>$invoice_no,
				'bill_typo'=>$bill_typo,
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
				'tf'=>$tf,
				'status'=>'1',
				'created_at'=>date("Y-m-d h:i:s")
                ];
                
               
                $this->db->insert("rough_invoice",$rough_invoice);
                
                $lastid= $this->db->insert_id();			


                $closign = ['invoice_id'=>$lastid, 'party_id'=>$party, 'p_fine'=>$p_fine, 'pf_s'=>$status_pfine, 'p_amount'=>$p_rs, 'pa_s'=>$status_prs, 'c_fine'=>$c_fine, 'cf_s'=>$status_cfine, 'c_amount'=>$c_rs, 'ca_s'=>$status_crs, 's_p'=>'s', 'status'=>1, 'date'=>date('Y-m-d')];

                $this->db->insert("closing",$closign);

                $ctr=$this->input->post("ctr_no")[$i];
                $cbag=$this->input->post("cbag")[$i];
                $cweight=$this->input->post("cweight")[$i];
                $ctweight=$this->input->post("ctweight")[$i];
                $id_bag=$this->input->post("id_bag")[$i];	
                $bag=['roughinvoice_id'=>$lastid,
						'tr_no'=>$ctr,
						'bag'=>$cbag,
						'weight'=>$cweight,
						'total'=>$ctweight,												
						'created_at'=>date("Y-m-d h:i:s")];
						$this->db->insert('rough_bag',$bag);
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
					$ghat=$this->input->post("ghat")[$j];
					$ghatweight=$this->input->post("ghatweight")[$j];
					$rate=$this->input->post("mrate")[$j];
					$labour=$this->input->post("mlabour")[$j];
					if(!empty($item_id) && !empty($item_id) && !empty($mtr)&& !empty($mtr) && !empty($lastid) && !empty($lastid)) {						
						$item=['roughinvoice_id'=>$lastid,
						'item_id'=>$item_id,
						'tr_no'=>$mtr,
						'g_weight'=>$g_weight,
						'b_weight'=>$b_weight,
						'n_weight'=>$n_weight,
						'ghat'=>$ghat,
						'ghatweight'=>$ghatweight,
						'touch'=>$mtouch,
						'wastage'=>$wastage,
						'touch_wastage'=>$t_w,	
						'fine'=>$fine,
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
                'rs'=>'0',
                'rs1'=>$t_labour,
                'fine'=>$t_fine,
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
			$order_column_array=array('id_rough','bill_typo', 'bill_type','invoice_no','buyer_name','address','date','mobile','t_fine','t_labour');
			$search_order= array('bill_type','invoice_no','buyer_name','address','mobile','date','t_labour','t_fine');
			$order_by_array= array('id_rough' => 'DESC');
	        $data = $row = array();
	        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
	        $i = $_POST['start'];
	        foreach($Master_Data as $m_data){
	            $i++;
	            $data[] = 	[$i,
				$m_data->bill_typo,
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
			$rough_invoice=$this->General_model->get_row('rough_invoice','id_rough',$id);
			$data['rough_bag']=$this->General_model->get_data('rough_bag','roughinvoice_id','*',$id);
			$data['rough_item']=$this->General_model->get_data('rough_item','roughinvoice_id','*',$id);
			$this->load->view('admin/controller/header');
            $this->load->view('admin/controller/sidebar');    
            if($rough_invoice->bill_typo == "g")	{
            $this->load->view('admin/partial/rough_invoice_ghat',$data);
            }
            else{
                $this->load->view('admin/partial/rough_invoice',$data);
            }
        
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
            $tf=$this->input->post("tf");
			if(isset($bill_type) && !empty($bill_type) && isset($invoice_no) && !empty($invoice_no) && isset($party) && !empty($party) && isset($date) && !empty($date)) {
				$i=0;
				$j=0;
				$query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();	
                
                $p_fine=$this->input->post("pfine");
				$status_pfine=$this->input->post("pfines");
				
                    
                
					$c_fine=$this->input->post("cfine");
				
					$status_cfine=$this->input->post("cfines");			
					
                      $p_rs=$this->input->post("pamount");
				
					$status_prs=$this->input->post("pamounts");
				
			
					$c_rs=$this->input->post("camount");
                    
					$status_crs=$this->input->post("camounts");
					
				
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
				'tf'=>$tf,
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
					if(isset($this->input->post("roughitem_id")[$j])){
                        $roughitem_id=$this->input->post("roughitem_id")[$j];
                        }
                        else{
                            $roughitem_id=null;
                        }


					$mtr=$this->input->post("mtr_no")[$j];
					$g_weight=$this->input->post("mg_weight")[$j];
					$b_weight=$this->input->post("mb_weight")[$j];
					$n_weight=$this->input->post("mn_weight")[$j];		
					$mtouch=$this->input->post("mtouch")[$j];
					$wastage=$this->input->post("mwastage")[$j];
					$t_w=$this->input->post("mtouch_wastage")[$j];
					$fine=$this->input->post("mfine")[$j];
                    $rate=$this->input->post("mrate")[$j];
                    $ghat=$this->input->post("ghat")[$j];
					$ghatweight=$this->input->post("ghatweight")[$j];
                    $labour=$this->input->post("mlabour")[$j];
                    

                  


					if(isset($roughitem_id) && !empty($roughitem_id) && isset($item_id) && !empty($item_id) && isset($mtr)&& !empty($mtr)) {
						$item=['roughinvoice_id'=>$id_rough,
						'item_id'=>$item_id,
						'tr_no'=>$mtr,
						'g_weight'=>$g_weight,
						'b_weight'=>$b_weight,
						'n_weight'=>$n_weight,
						'ghat'=>$ghat,
						'ghatweight'=>$ghatweight,
						'touch'=>$mtouch,
						'wastage'=>$wastage,
						'touch_wastage'=>$t_w,	
						'fine'=>$fine,
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
						'ghat'=>$ghat,
						'ghatweight'=>$ghatweight,
						'touch'=>$mtouch,
						'wastage'=>$wastage,
						'touch_wastage'=>$t_w,	
						'fine'=>$fine,
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
                'rs'=>'0',
                'rs1'=>$t_labour,
                'fine'=>$t_fine];
				$this->General_model->update("rough_payment",$rough_payment,'roughinvoice_id',$id_rough);

                $closign = ['party_id'=>$party,
                  'p_fine'=>$p_fine,
                   'pf_s'=>$status_pfine,
                    'p_amount'=>$p_rs,
                     'pa_s'=>$status_prs,
                      'c_fine'=>$c_fine,
                       'cf_s'=>$status_cfine,
                        'c_amount'=>$c_rs,
                         'ca_s'=>$status_crs,
                          's_p'=>'s',
                           'status'=>1,
                            'date'=>date('Y-m-d')];

                            $this->General_model->update("closing",$closign,'invoice_id',$id_rough);


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
			if($r_invoice->bill_typo == "w")
			{
				$image=base_url('assets/admin/images/invoice3.png');
				$pdf->Image($image,0,0.2,210,0,'PNG');
			}
			else
			{
				$image=base_url('assets/admin/images/invoice2.png');
				$pdf->Image($image,0,3.5,210,0,'PNG');
			}
	    	
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(20,38);
	    	$pdf->Cell(82,5,$party->name,0,1,'L');
	    	$pdf->SetXY(150,38);
	    	$pdf->Cell(33,5,"S/".$r_invoice->invoice_no,0,1,'L');
	    	$pdf->SetXY(20,44);
	    	$pdf->Cell(82,5,$party->city_name,0,1,'L');    	
	    	$pdf->SetXY(150,44);
	    	$pdf->Cell(33,5,date('d/m/Y',strtotime($r_invoice->date)),0,1,'L');
	    	$i=0;
            $y=0;
            $r_purchase_invoice=$this->db->query("SELECT sum(`t_fine`) as fine,sum(`t_amount`) as amount FROM `rough_purchase` WHERE `party_id`=".$r_invoice->party_id."")->row();
             $r_sale_invoice=$this->db->query("SELECT sum(`t_fine`) as fine,sum(`t_labour`) as amount FROM `rough_invoice` WHERE `party_id`=".$r_invoice->party_id."")->row();
            $r_item=$this->db->query("SELECT t1.*,t2.name as item_name FROM rough_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughinvoice_id='".$id."' ORDER BY `t1`.`tr_no` ASC")->result();
          

	    	$pdf->SetFont('Arial','',10);
	    	foreach ($r_item as $r_item) {
	    		if($i<6){
	    			$pdf->SetXY(7,62+$y);
	    			$pdf->Cell(8,5,$r_item->tr_no,0,1,'C');
	    			$pdf->SetXY(11,62+$y);
	    			$pdf->MultiCell(33,5,$r_item->item_name,0,'C');
	    			$pdf->SetXY(64,62+$y);
					$g_weight[]=$r_item->g_weight;
	    			$pdf->Cell(16,5,$r_item->g_weight,0,1,'R');
	    			$pdf->SetXY(78,62+$y);
	    			$pdf->Cell(17,5,$r_item->b_weight,0,1,'R');
	    			$n_weight[]=$r_item->n_weight;
	    			$pdf->SetXY(95,62+$y);
	    			$pdf->Cell(18,5,$r_item->n_weight,0,1,'R');
	    			
					if($r_invoice->bill_typo=="w")
					{
						$pdf->SetXY(110,62+$y);
						$pdf->Cell(19,5,number_format($r_item->touch,2),0,1,'R');
						$pdf->SetXY(125,62+$y);
						$pdf->Cell(17,5,number_format($r_item->wastage,2),0,1,'R');
						$pdf->SetXY(142,62+$y);
						$pdf->Cell(17,5,number_format($r_item->touch_wastage,2),0,1,'R');
					}
					else{
						$pdf->SetXY(139,62+$y);
						$pdf->Cell(19,5,number_format($r_item->touch,0),0,1,'R');
						$pdf->SetXY(108,62+$y);
						$pdf->Cell(19,5,number_format($r_item->ghat,0),0,1,'R');
						$pdf->SetXY(124,62+$y);
						$gt_weight[]=$r_item->ghatweight;
						$pdf->Cell(19,5,str_replace(',', '',number_format($r_item->ghatweight,0)),0,1,'R');
					}
					
					
	    			$fine[]=$r_item->fine;
	    			$pdf->SetXY(159,62+$y);
	    			$pdf->Cell(13,5,$r_item->fine,0,1,'R');
	    			$pdf->SetXY(172,62+$y);
	    			$pdf->Cell(13,5,$r_item->rate,0,1,'R');
	    			$labour[]=$r_item->labour;
	    			$pdf->SetXY(188,62+$y);
	    			$pdf->Cell(19,5,$r_item->labour,0,1,'R');
	    			$y=7+$y;
					}else{
				}
	    		$i++;
			}
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(64,106);
	    	$pdf->Cell(17,5,array_sum($g_weight),0,1,'R');
	    	$pdf->SetXY(95,106);
	    	$pdf->Cell(17,5,array_sum($n_weight),0,1,'R');
			if($r_invoice->bill_typo=="g"){
				$pdf->SetXY(124,106);
				$pdf->Cell(19,5,str_replace(',', '',number_format(array_sum($gt_weight),0)),0,1,'R');
			}
	    	$pdf->SetXY(159,106);	    	
	    	$pdf->Cell(13,5,array_sum($fine),0,1,'R');
	    	$pdf->SetXY(188,106);
	    	$pdf->Cell(19,5,array_sum($labour),0,1,'R');
            if($r_invoice->remark != ""){
                $pdf->SetXY(5,114);
                $pdf->Cell(19,5,"Remark : ".$r_invoice->remark,0,1,'L');
               
                } 
                
	    	$pdf->SetFont('Arial','',10);
            if($r_invoice->bill_typo=="w")
			{  $d_total=$this->db->query("SELECT * FROM closing where c_id='".$id."'")->row();
             
                   
				$pdf->SetXY(142,114);
                $pdf->Cell(40,5,ABS($r_invoice->p_fine )." ".$r_invoice->status_pfine ,0,1,'R'); 
                $pdf->SetXY(142,120.5);
                $pdf->Cell(40,5,$r_invoice->c_fine ." ".$r_invoice->status_cfine ,0,1,'R'); 
                
                  
				$pdf->SetXY(167,114);
                $pdf->Cell(40,5,ABS($r_invoice->p_rs )." ".$r_invoice->status_prs ,0,1,'R'); 
                $pdf->SetXY(167,120.5);
                $pdf->Cell(40,5,$r_invoice->c_rs ." ".$r_invoice->status_crs ,0,1,'R'); 
                
                
            }
            else{
                $d_total=$this->db->query("SELECT * FROM closing where c_id='".$id."'")->row();
             
	    		$pdf->SetXY(142,112);
                $pdf->Cell(40,5,$r_invoice->p_fine." ".$r_invoice->status_pfine ,0,1,'R'); 
                $pdf->SetXY(142,118.5);
                $pdf->Cell(40,5,$r_invoice->c_fine." ".$r_invoice->status_cfine ,0,1,'R'); 
                
                  
				$pdf->SetXY(167,112);
                $pdf->Cell(40,5,$r_invoice->p_rs." ".$r_invoice->status_prs ,0,1,'R'); 
                $pdf->SetXY(167,118.5);
                $pdf->Cell(40,5,$r_invoice->c_rs." ".$r_invoice->status_crs ,0,1,'R'); 
             }
			//sssssklsnlksnlskmskl slksmslmslk	    	/*nmdkwnsjdnbsjnsjnssn*/
	    	$pdf->SetFont('Arial','',10);
	    	$pdf->SetXY(20,183.5);
	    	$pdf->Cell(82,5,$party->name,0,1,'L');
	    	$pdf->SetXY(150,183.5);
	    	$pdf->Cell(33,5,"S/".$r_invoice->invoice_no,0,1,'L');
	    	$pdf->SetXY(20,190);
	    	$pdf->Cell(82,5,$party->city_name,0,1,'L');    	
	    	$pdf->SetXY(150,190);
	    	$pdf->Cell(33,5,date('d/m/Y',strtotime($r_invoice->date)),0,1,'L');
	    	$i=0;
	    	$y=0;
	    	$r_item=$this->db->query("SELECT t1.*,t2.name as item_name FROM rough_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughinvoice_id='".$id."' ORDER BY `t1`.`tr_no` ASC")->result();
	    	$pdf->SetFont('Arial','',10);
	    	foreach ($r_item as $r_item) {
	    		if($i<6){
	    			$pdf->SetXY(7,209+$y);
	    			$pdf->Cell(8,5,$r_item->tr_no,0,1,'C');
	    			$pdf->SetXY(11,209+$y);
	    			$pdf->MultiCell(33,5,$r_item->item_name,0,'C');
	    			$pdf->SetXY(64,209+$y);
					$g_weight1[]=$r_item->g_weight;
	    			$pdf->Cell(16,5,$r_item->g_weight,0,1,'R');
	    			$pdf->SetXY(78,209+$y);
	    			$pdf->Cell(17,5,$r_item->b_weight,0,1,'R');
	    			$n_weight1[]=$r_item->n_weight;
	    			$pdf->SetXY(95,209+$y);
	    			$pdf->Cell(18,5,$r_item->n_weight,0,1,'R');
	    			
					if($r_invoice->bill_typo=="w")
					{
						$pdf->SetXY(140,209+$y);
						$pdf->Cell(19,5,number_format($r_item->touch_wastage,2),0,1,'R');
						$pdf->SetXY(110,209+$y);
						$pdf->Cell(19,5,number_format($r_item->touch,2),0,1,'R');
						$pdf->SetXY(124,209+$y);
						$pdf->Cell(19,5,number_format($r_item->wastage,2),0,1,'R');
					}
					else{
						$pdf->SetXY(139,209+$y);
						$pdf->Cell(19,5,number_format($r_item->touch,0),0,1,'R');
						$pdf->SetXY(108,209+$y);
						$pdf->Cell(19,5,number_format($r_item->ghat,0),0,1,'R');
						$pdf->SetXY(124,209+$y);
						$gt_weight1[]=$r_item->ghatweight;
						$pdf->Cell(19,5,str_replace(',', '',number_format($r_item->ghatweight,0)),0,1,'R');
					}
					
	    			$fine1[]=$r_item->fine;
	    			$pdf->SetXY(159,209+$y);
	    			$pdf->Cell(13,5,$r_item->fine,0,1,'R');
	    			$pdf->SetXY(172,209+$y);
	    			$pdf->Cell(13,5,$r_item->rate,0,1,'R');
	    			$labour1[]=$r_item->labour;
	    			$pdf->SetXY(188,209+$y);
	    			$pdf->Cell(19,5,$r_item->labour,0,1,'R');
	    			$y=7+$y;
					}else{
				}
	    		$i++;
			}
			
			
	    	$pdf->SetFont('Arial','',10);
			$pdf->SetXY(64,252);
	    	$pdf->Cell(17,5,array_sum($g_weight1),0,1,'R');
	    	$pdf->SetXY(94,252);
	    	$pdf->Cell(17,5,array_sum($n_weight1),0,1,'R');
			if($r_invoice->bill_typo=="g"){
				$pdf->SetXY(124,252);
				$pdf->Cell(19,5,str_replace(',', '',number_format(array_sum($gt_weight),0)),0,1,'R');
			}
	    	$pdf->SetXY(159,252);	    	
	    	$pdf->Cell(13,5,array_sum($fine1),0,1,'R');
	    	$pdf->SetXY(188,252);
            $pdf->Cell(19,5,array_sum($labour1),0,1,'R');

            if($r_invoice->remark != ""){
	    	$pdf->SetXY(5,259);
            $pdf->Cell(19,5,"Remark : ".$r_invoice->remark,0,1,'L');
        }  
	    	$pdf->SetFont('Arial','',10);
			if($r_invoice->bill_typo=="w")
			{
                
                $d_total=$this->db->query("SELECT * FROM closing where c_id='".$id."'")->row();
             
                 

				$pdf->SetXY(167,259);
				$pdf->Cell(40,5,$r_invoice->p_rs." ".$r_invoice->status_prs,0,1,'R');
				$pdf->SetXY(167,266);
				$pdf->Cell(40,5,$r_invoice->c_rs." ".$r_invoice->status_crs,0,1,'R');
				$pdf->SetXY(142,259);
				$pdf->Cell(40,5,$r_invoice->p_fine." ".$r_invoice->status_pfine,0,1,'R');
				$pdf->SetXY(142,266);
				$pdf->Cell(40,5,$r_invoice->c_fine." ".$r_invoice->status_cfine,0,1,'R');
			}
			else{
				$d_total=$this->db->query("SELECT * FROM closing where c_id='".$id."'")->row();
             
                 
				$pdf->SetXY(167,258);
				$pdf->Cell(40,5,$r_invoice->p_rs." ".$r_invoice->status_prs,0,1,'R');
				$pdf->SetXY(167,265.5);
				$pdf->Cell(40,5,$r_invoice->c_rs." ".$r_invoice->status_crs,0,1,'R');
				$pdf->SetXY(142,258);
				$pdf->Cell(40,5,$r_invoice->p_fine." ".$r_invoice->status_pfine,0,1,'R');
				$pdf->SetXY(142,265.5);
				$pdf->Cell(40,5,$r_invoice->c_fine." ".$r_invoice->status_cfine,0,1,'R');
			}
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