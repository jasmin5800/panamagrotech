<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Garanu extends CI_Controller {
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
		$data['page_title']="Garanu";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/rough/purchase/garanu',$data);
		$this->load->view('admin/controller/footer');
	}
	public function get_addfrm()
	{
		$this->General_model->auth_check();
		$data["party"]=$this->General_model->get_all_where('party','status','1');
		$data["item"]=$this->General_model->get_all_where('item','status','1');
		$data["method"]="add";
        $data['page_title']="Garanu";
        $data['invoice']=$this->db->query("SELECT id FROM garanu ORDER BY id DESC LIMIT 1")->row(); 
        if(empty($data['invoice']))
        {
            $data['invoice']= array('no_invoice' => '1');
            }
            else
            {
            $no_invoice=(($data['invoice']->id)+1);
            $data['invoice']= array('no_invoice' =>$no_invoice);
        }
		$data['action']=base_url('Garanu/invoice_create');
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/partial/garanu',$data);
		$this->load->view('admin/controller/footer');
	}
	public function invoice_create(){
		$this->General_model->auth_check();
		$party=$this->input->post("party_id");	
		$date=$this->input->post("date");
		$date=explode("/", $date);
		$date=[$date[2],$date[1],$date[0]];
		$date=implode("-", $date);
		$i = 0;
		$j = 0;
		
		if(isset($party) && !empty($party) && isset($date) && !empty($date)) {		
			
			$query=$this->db->query("SELECT name FROM party WHERE `id_party`=".$party."")->row();
			
			$rough_purchase=['party_id'=>$party,
							'buyer_name'=>$query->name,
							'date'=>$date,
							'fine1'=>$this->input->post("fine1"), 
							'm_touch1'=>$this->input->post("m_touch1"),
							'r_garanu'=>$this->input->post("r_garanu"),
							 'f_baad1'=>$this->input->post("f_baad1"),
							  'r_copper'=>$this->input->post("r_copper"),
							   'copper_t'=>$this->input->post("copper_t"),
								'copper_f1'=>$this->input->post("copper_f1"),
								 'copper_f2'=>$this->input->post("copper_f2"),
								  'fine2'=>$this->input->post("fine2"),
								   'total_f'=>$this->input->post("total_f"),
									'm_touch2'=>$this->input->post("m_touch2"),
									 'garanu'=>$this->input->post("garanu"),
									  'f_baad2'=>$this->input->post("f_baad2"),
									   'final_copper'=>$this->input->post("final_copper"),
									   'status'=>'1',
							'date_created'=>date("Y-m-d h:i:s")
                        ];
                        

                        
            $this->db->insert("garanu",$rough_purchase);
            $lastid= $this->db->insert_id();
          
          
			foreach ($this->input->post("item_id") as $pr) {
				$item_id=$this->input->post("item_id")[$j];
				$weight=$this->input->post("weight")[$j];
				
				$touch=$this->input->post("touch")[$j];
				
				$fine=$this->input->post("fine")[$j];
				if(isset($item_id) && !empty($item_id) && isset($lastid) && !empty($lastid)) {						
						$item=['garanu_id'=>$lastid,
								'item_id'=>$item_id,								
								'weight'=>$weight,
								'touch'=>$touch,
								'fine'=>$fine,	
								'date_created'=>date("Y-m-d h:i:s")];
                        $this->db->insert('garanu_item',$item);		
                       			
				}		
				$j++;
			}	
				
                $this->session->set_userdata('Msg','GARANU Generated');
                
			}else{
				$this->session->set_userdata('Msg','Something Is Missing');			
		}					
		redirect('Garanu');
	}
	public function getLists(){
			$this->General_model->auth_check();
			$table='garanu';
			$order_column_array=array('id','buyer_name','date','final_copper');
			$search_order= array('id','buyer_name','date','final_copper');
			$order_by_array= array('id' => 'DESC');
	        $data = $row = array();
	        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
	        $i = $_POST['start'];
	        foreach($Master_Data as $m_data){
	            $i++;
	            $data[] = 	[$i,
	    					ucwords($m_data->buyer_name),
	    					date('d/m/Y',Strtotime($m_data->date)),
							$m_data->final_copper,
							'<button type="button" class="btn btn-danger waves-effect waves-light" data-id="delete" data-value="'.$m_data->id.'"><i class="fa fa-trash" aria-hidden="true"></i></button>
	    					<a href="'.base_url('garanu/invoice_view/').$m_data->id.'"><button type="button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-eye"></i></button></a>
	    					'
	    					];
	        }
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->Genral_datatable->countAll($table),
	            "recordsFiltered" => $this->Genral_datatable->countFiltered($_POST,$table,$order_column_array,$search_order,$order_by_array),
	            "data" => $data,
	        );
	        echo json_encode($output);
	}
   public function get_touch($id){
		
		$data = $this->db->query("select touch from item where id_item=$id")->row()->touch;
		echo $data;

	}
	public function invoice_view($id)
	    {
	    	$this->General_model->auth_check();
			$data['p_invoice']=$this->General_model->get_row('garanu','id',$id);
			$party = $data['p_invoice']->party_id;
	    	$data['party']=$this->db->query("SELECT name FROM party WHERE `id_party`=".$party."")->row();
	    	$data['r_item']=$this->db->query("SELECT t1.*,t2.name as item_name FROM garanu_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.garanu_id='".$id."'")->result();
	    	$data['r_item1']=$this->db->query("SELECT t1.*,t2.name as item_name FROM garanu_item as t1 LEFT JOIN item as t2 ON t1.item_id=t2.id_item WHERE t1.garanu_id='".$id."'")->result();
	    	$data['page_title']="GARANU";
	    	$this->load->view('admin/controller/header');
			$this->load->view('admin/controller/sidebar');
			$this->load->view('admin/rough/purchase/garanu_inv',$data);
			$this->load->view('admin/controller/footer');
	    }
	    public function invoice_delete($id)
	    {
	    	$this->General_model->auth_check();
	    	if(isset($id) && !empty($id)){
	    		$this->General_model->delete('garanu','id',$id);  	 		
	    		$this->General_model->delete('garanu_item','garanu_id',$id);
	    		$data['status']="success";
	    		$data['msg']="Garanu Deleted";
	    	}else{
	    		$data['status']="error";
	    		$data['msg']="Something is Worng";				
	    	}
	    	echo json_encode($data);
	    }
   
}