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
		$data['page_title']="AAVAK";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/rough/purchase/purchase_detail',$data);
		$this->load->view('admin/controller/footer');
	}
	public function get_addfrm()
	{
		$this->General_model->auth_check();
        $data["party"]=$this->General_model->get_all_where('party','party_type','0');
		$data["item"]=$this->General_model->get_all_where('item','status','1');
		$data["method"]="add";
        $data['page_title']="AAVAK";
        $invoice=$this->db->query("SELECT invoice_no FROM rough_purchase ORDER BY invoice_no DESC LIMIT 1")->row()->invoice_no; 
    
        if(!$invoice)
        {
            $data['invoice']= array('no_invoice' => '1');
            }
            else
            {
            $no_invoice=$invoice+1;
          
            $data['invoice']= array('no_invoice' =>$no_invoice);
        }
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

		$r_fine=$this->input->post("r_fine");
		$r_amount=$this->input->post("r_amount");
		$t_fine2=$this->input->post("t_fine2");
		$t_amount2=$this->input->post("t_amount2");

		$remark=$this->input->post("remark");
		$tf=$this->input->post("tf");
		if(isset($party) && !empty($party) && isset($date) && !empty($date)) {		
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
							'r_fine'=>$r_fine,
							'r_amount'=>$r_amount,			
							't_fine2'=>$t_fine2,
							't_amount2'=>$t_amount2,
							'remark'=>$remark,
							'tf'=>$tf,
							'status'=>'1',
							'created_at'=>date("Y-m-d h:i:s")
                        ];
                        

                        
            $this->db->insert("rough_purchase",$rough_purchase);
            $lastid= $this->db->insert_id();
            $closign = ['invoice_id'=>$lastid, 'party_id'=>$party, 'p_fine'=>$p_fine, 'pf_s'=>$status_pfine, 'p_amount'=>$p_rs, 'pa_s'=>$status_prs, 'c_fine'=>$c_fine, 'cf_s'=>$status_cfine, 'c_amount'=>$c_rs, 'ca_s'=>$status_crs, 's_p'=>'s', 'status'=>1, 'date'=>date('Y-m-d')];

            $this->db->insert("closing",$closign);
           
			foreach ($this->input->post("item_id") as $pr) {
				$item_id=$this->input->post("item_id")[$j];
				$gr_wt=$this->input->post("mg_weight")[$j];
				
				// $badlo=$this->input->post("mt_badlo")[$j];
				// $tf=$this->input->post("mtf")[$j];
				
				$fine=$this->input->post("mfine")[$j];
			
                $amount=$this->input->post("mamount")[$j];
               
				if(isset($item_id) && !empty($item_id) && isset($lastid) && !empty($lastid)) {						
						$item=['roughpurchase_id'=>$lastid,
								'item_id'=>$item_id,								
								'gr_weight'=>$gr_wt,
								'badlo'=>0,
								'tf'=>0,	
								'fine'=>$fine,
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
                                    'fine'=>$t_fine,
									'rs'=>$t_amount,
									'rs1'=>$t_amount,
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
			$order_by_array= array('id_rough' => 'DESC');
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
    	$data['page_title']="AAVAK";
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
		$r_fine=$this->input->post("r_fine");
		$r_amount=$this->input->post("r_amount");
		$t_fine2=$this->input->post("t_fine2");
		$t_amount2=$this->input->post("t_amount2");
		$remark=$this->input->post("remark");
		$tf=$this->input->post("tf");
       
		if(isset($party) && !empty($party) && isset($date) && !empty($date)) {
	    			$i=0;
					$j=0;
					$invoice_no=((isset($invoice_no) && !empty($invoice_no))?$invoice_no:NULL);
					$query=$this->db->query("SELECT t1.*,t2.name as city_name ,t3.name as state_name,t3.country FROM party as t1 LEFT JOIN city as t2 ON t1.city_id = t2.id LEFT JOIN state as t3 ON t1.state_id = t3.id WHERE t1.`id_party`='".$party."'")->row();	
                    $p_fine=$this->input->post("pfine");
                    $status_pfine=$this->input->post("pfines");
                    
                        
                    
                        $c_fine=$this->input->post("cfine");
                    
                        $status_cfine=$this->input->post("cfines");			
                        
                          $p_rs=$this->input->post("pamount");
                    
                        $status_prs=$this->input->post("pamounts");
                    
                
                        $c_rs=$this->input->post("camount");
                        
                        $status_crs=$this->input->post("camounts");
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
	    							'tf'=>$tf,							
	    							't_fine'=>$t_fine,
	    							't_amount'=>$t_amount,			
	    							'r_fine'=>$r_fine,
	    							'r_amount'=>$r_amount,			
	    							't_fine2'=>$t_fine2,
	    							't_amount2'=>$t_amount2
	    						];
	    			$this->General_model->update('rough_purchase',$rough_purchase,'id_rough',$id_rough);  
	    			foreach ($this->input->post("item_id") as $pr) {
                        if(isset($this->input->post("roughitem_id")[$j])){
                        $roughitem_id=$this->input->post("roughitem_id")[$j];
                        }
                        else{
                            $roughitem_id=null;
                        }
	    				$item_id=$this->input->post("item_id")[$j];
				$gr_wt=$this->input->post("mg_weight")[$j];
				
				
				$fine=$this->input->post("mfine")[$j];
			
                $amount=$this->input->post("mamount")[$j];
	    				if(isset($roughitem_id) && !empty($roughitem_id) && isset($item_id) && !empty($item_id)) {
                          
	    					$item=['roughpurchase_id'=>$id_rough,
                            'item_id'=>$item_id,								
                            'gr_weight'=>$gr_wt,
                            'badlo'=>0,
                            'tf'=>0,	
                            'fine'=>$fine,
                            'amount'=>$amount,	
                            'created_at'=>date("Y-m-d h:i:s")
                                    ];
                                    
	    					$this->General_model->update('roughpurchase_item',$item,'id',$roughitem_id);				
	    				}elseif (isset($item_id) && !empty($item_id)) {
                          
	    					$item=['roughpurchase_id'=>$id_rough,
                            'item_id'=>$item_id,								
                            'gr_weight'=>$gr_wt,
                            'badlo'=>0,
                            'tf'=>0,	
                            'fine'=>$fine,
                            'amount'=>$amount,	
                            'created_at'=>date("Y-m-d h:i:s")
                                    ];
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
	    								'rs'=>$t_amount,'fine'=>$t_fine ];
                    $this->General_model->update('rough_payment',$rough_payment,'roughpur_id',$id_rough);
                    
                 
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
    
                                $this->General_model->update("closing",$closign,'purchase_id',$id_rough);
    



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
	    	$data['r_item1']=$this->db->query("SELECT t1.*,t2.name as item_name FROM roughpurchase_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.roughpurchase_id='".$id."'")->result();
	    	$data['page_title']="Estimate Invoice";
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
        public function update_invoice()
	    {
            $data = $this->db->query("SELECT * FROM `rough_purchase`")->result();
            $no =1;
            foreach($data as $dt)
            {
                $dataupdate = array("invoice_no"=>$no);
                $this->General_model->update("rough_purchase",$dataupdate,"id_rough",$dt->id_rough);
                $no++;
            }
	    }
}