<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Packing extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('PackingModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role7();
    }
    public function index()
    {
        $data['page_title']="Packing";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/packing/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function get_addfrm()
    {
        $this->General_model->auth_check();
        $data['page_title']="Packing";
        $data['lot_no'] =$this->db->query("SELECT lot_no FROM `cut` WHERE `process_status` = 1 ORDER BY `lot_no` DESC")->result();
        $data['sub_process'] = $this->General_model->get_row('sub_process','id_sub_process','5');
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/packing/create',$data);
        $this->load->view('admin/controller/footer');
    }
    public function create()
    {
        $this->General_model->auth_check();
        $name=trim($this->input->post('name'));
        $address=trim($this->input->post('address'));
        $date = explode('/',$this->input->post('date')); 
        $date =[$date[2],$date[1],$date[0]];
        $date=implode("-", $date);
        $lot_no=trim($this->input->post("lot_no"));
        $child_sb=$this->input->post('child_sb');
        $vahicle=trim($this->input->post('vahicle'));
        $vahicle_no=trim($this->input->post('vahicle_no'));
        $t_design=$this->input->post('t_design');
        $t_pcs=$this->input->post('t_pcs');
        $t_dmgpcs=$this->input->post('t_dmgpcs');
        $t_ghatsaree=$this->input->post('t_ghatsaree');
        $cloth_val=$this->input->post('cloth_val');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $g_total=$this->input->post('g_total');
        $packing_val=$this->input->post('packing_val');
        $remark=trim($this->input->post('remark'));
        if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($packing_val) && !empty($packing_val) && isset($child_sb) && !empty($child_sb)){
            $challan_no=$this->PackingModel->challan_no();
            $detail=['challan_no'=>$challan_no['challan_no'],
                        'name'=>$name,
                        'address'=>$address,
                        'date'=>$date,
                        'lot_no'=>$lot_no,
                        'vahicle'=>$vahicle,
                        'vahicle_no'=>$vahicle_no,
                        'sb_id'=>7,
                        'child_sb'=>$child_sb,
                        'tarsport_id'=>NULL,
                        't_design'=>$t_design,
                        't_pcs'=>$t_pcs,
                        't_missprint'=>$t_dmgpcs,
                        't_ghatsaree'=>$t_ghatsaree,
                        'cloth_value'=>$cloth_val,
                        'packing_value'=>$packing_val,
			'remark'=>$remark,
                        'sub_total'=>$sub_total,
                        'tax'=>$tax,
                        'g_total'=>$g_total,
                        'user_id'=>$_SESSION['auth_user_id'],
                        'status'=>'1',
                        'created_at'=>date("Y-m-d h:i:s")];
            $packing_id = $this->General_model->addid('packing',$detail);
            $msg="packing insert id ".$packing_id;
            $this->LogModel->simplelog($msg);
            $balance=$this->General_model->get_row('balance','lot_no',$lot_no);
            if($balance->packing_status==1){
                $upd_balance=['packing_cloth'=>$packing_val,'packing_status'=>0];
                $this->General_model->update('balance',$upd_balance,'lot_no',$lot_no);
            }
            $i=0;
            foreach ($this->input->post('design_no') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $patla_id=$this->input->post('patla')[$i];
                $patla_id=((empty($patla_id) || $patla_id==0)?NULL:$patla_id);
                $dmg_pcs=$this->input->post('dmg_pcs')[$i];
                $ghat_saree=$this->input->post('ghat_saree')[$i];
                $emuser_id=$this->input->post('emuser')[$i];
                if(isset($packing_id) && !empty($packing_id) && !empty($design_no) && !empty($color)  &&!empty($pcs)){
                        $where=(($child_sb=="B")?['el_id'=>$design_no]:['gl_id'=>$design_no]);
                        $table=(($child_sb=="B")?"embroidery_lot":"ghadi_lot");
                        $this->General_model->update_where($table,['status'=>0],$where);
                        $table_id=(($child_sb=="B")?"el_id":"gl_id");
                        $query=$this->General_model->get_row($table,$table_id,$design_no);
                        $design_no=(($child_sb=="B")?$query->design_no:$query->n_design);
                        $design_unique=$query->unique_design;
                    $packing_lot=['packing_id'=>$packing_id,
                                    'lot_no'=>$lot_no,
                                    'sb_id'=>5,
                                    'emuser_id'=>$emuser_id,
                                    'child_sb'=>$child_sb,
                                    'unique_design'=>$design_unique,
                                    'design_no'=>$design_no,
                                    'color'=>$color,
                                    'pcs'=>$pcs,
                                    'm_pcs'=>$dmg_pcs,
                                    'ghat_saree'=>$ghat_saree,
                                    'patla_id'=>$patla_id,
                                    'status'=>1,
                                    'created_at'=>date("Y-m-d h:i:s")];
                    $this->General_model->add('packing_lot',$packing_lot);
                    }
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Packing Added' ];
            $this->session->set_userdata($sess_data);       
            redirect('Packing/view_invoice/'.$packing_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Packing/get_addfrm/');
        }
    }
    public function getLists(){
        $columns = array( 
                    0 =>'packing_id ', 
                    1=> 'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4 =>'name',
                    5=> 'child_sb',
                    6=>'t_design',
                    7=>'t_pcs',
                    8=>'t_missprint',
                    9=> 'cloth_value',
                    10=> 'g_total',
                    11=> 'packing_value',
		    12=> 'remark',
                    13=> 'user_name',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->PackingModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->PackingModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->PackingModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->PackingModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            setlocale(LC_MONETARY, 'en_IN');
            $i=1;
            foreach ($posts as $post)
            {
                $child_sb=(($post->child_sb=="A")? "<span class='bg-success text-white px-2 py-1'>GHADI-KANJI</span>" :(($post->child_sb=="B")?"<span class='bg-dark text-white px-2 py-1'>EMBROIDERY</span>":(($post->child_sb=="C")?"<span class='bg-warning text-white px-2 py-1'>GHADI-EMBRO</span>":"<span class='bg-danger text-white px-2 py-1'>SELF-GHADI</span>")));
                if($_SESSION['auth_role_id']=="1"){
                $button='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                     <div class="btn-group" role="group">
                       <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-eye" aria-hidden="true"></i>
                       </button>
                       <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                       <a class="dropdown-item" href="'.base_url('Packing/view_invoice/').$post->packing_id .'">Invoice 1</a>
                         <a class="dropdown-item" href="'.base_url('Packing/view_invoice2/').$post->packing_id.'">Invoice 2</a>
                       </div>
                     </div>
                   </div>
                   <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->packing_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }else{
                   $button='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                     <div class="btn-group" role="group">
                       <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-eye" aria-hidden="true"></i>
                       </button>
                       <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                       <a class="dropdown-item" href="'.base_url('Packing/view_invoice/').$post->packing_id .'">Invoice 1</a>
                         <a class="dropdown-item" href="'.base_url('Packing/view_invoice2/').$post->packing_id.'">Invoice 2</a>
                       </div>
                     </div>
                   </div>';
                }
                $nestedData['sr_no'] =$i;
                $nestedData['name'] =$post->name;
                $nestedData['child_sb'] =$child_sb;
                $nestedData['challan_no'] =$post->challan_no;
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['date'] =date('d/m/Y',strtotime($post->date));
                $nestedData['t_design'] =$post->t_design;
                $nestedData['t_pcs'] =$post->t_pcs;
                $nestedData['t_missprint'] =$post->t_missprint;
                $nestedData['cloth_value'] = number_format($post->cloth_value,2);
                $nestedData['g_total'] =  number_format($post->g_total,2);
                $nestedData['packing_value'] = number_format($post->packing_value,2);
		$nestedData['remark'] = $post->remark;
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
    }
    public function update()
    {
    }
    public function view_invoice($id)
    {
        $data['page_title']="Packing";
        $data['packing']=$this->db->query("SELECT t1.*,t2.name as process_name FROM packing as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.packing_id ='".$id."'")->row();
        if($data['packing']->child_sb=="A" || $data['packing']->child_sb=="D"){
            $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['packing']->lot_no."")->row();
        }else{
            $data['balance']=$this->db->query("SELECT `embroidery_cloth` as process_val FROM `balance` WHERE lot_no=".$data['packing']->lot_no."")->row();
        }
        $data['packing_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM packing_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE packing_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['packing']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/packing/invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function view_invoice2($id)
    {
        $data['page_title']="Packing";
        $data['packing']=$this->db->query("SELECT t1.*,t2.name as process_name FROM packing as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.packing_id ='".$id."'")->row();
        if($data['packing']->child_sb=="A" || $data['packing']->child_sb=="D"){
            $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['packing']->lot_no."")->row();
        }else{
            $data['balance']=$this->db->query("SELECT `embroidery_cloth` as process_val FROM `balance` WHERE lot_no=".$data['packing']->lot_no."")->row();
        }
        $data['packing_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM packing_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE packing_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['packing']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/packing/invoice2',$data);
        $this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $msg="packing delete id ".$id;
            $this->LogModel->simplelog($msg);
            $packing_lot=$this->General_model->get_data('packing_lot','packing_id','*',$id);
            foreach ($packing_lot as $key => $value) {
                $lot_no=$value->lot_no; 
                $design_unique=$value->unique_design;
                if($value->child_sb=="A"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"A"];
                    $table='ghadi_lot';
                }elseif ($value->child_sb=="B"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"B"];
                    $table='ghadi_lot';
                }
                elseif ($value->child_sb=="C"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0];
                    $table='embroidery_lot';
                }
                elseif ($value->child_sb=="D"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"C"];
                    $table='ghadi_lot';
                }else{
                }
                $data=['status'=>1];
                $this->General_model->update_where($table,$data,$where);
            }
            $this->General_model->delete('packing_lot','packing_id',$id);
            $this->General_model->delete('packing','packing_id',$id);
            $data['status']="success";
            $data['msg']="Packing Deleted";
        }else{
            $data['status']="error";
            $data['msg']="Something is Worng";              
        }
        echo json_encode($data);
    }
    public function get_design()
    {
        $this->General_model->auth_check();
        $lot_no=$this->input->post('lot_no');
        $child_sb=$this->input->post('child_sb'); 
        if(isset($lot_no) && !empty($lot_no) && isset($child_sb) && !empty($child_sb) ){
            if($child_sb=="A"){
                $data['design']=$this->db->query("SELECT gl_id as design_id,`n_design` as design FROM `ghadi_lot` WHERE lot_no='".$lot_no."' and child_sb='A' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT ghadi_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }elseif($child_sb=="B"){
                $data['design']=$this->db->query("SELECT el_id as design_id,`design_no` as design FROM embroidery_lot WHERE lot_no='".$lot_no."' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT embroidery_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }elseif($child_sb=="C"){
                $data['design']=$this->db->query("SELECT gl_id as design_id,`n_design` as design FROM `ghadi_lot` WHERE lot_no='".$lot_no."' and child_sb='B' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT embroidery_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }elseif ($child_sb=="D") {
                $data['design']=$this->db->query("SELECT gl_id as design_id,`n_design` as design FROM `ghadi_lot` WHERE lot_no='".$lot_no."' and child_sb='C' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT ghadi_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }else{
            }
            $data['status']="success";
        }else{
            $data['status']="error";
        }
        echo json_encode($data);
    }
    public function design_row()
    {
        $this->General_model->auth_check();
        $child_sb=$this->input->post('child_sb');
        $design=$this->input->post('design');
        $this->General_model->auth_check();
        if(isset($child_sb) && !empty($child_sb) && isset($design) && !empty($design) ){
            if($child_sb=="B"){
                $data['datail']=$this->db->query("SELECT t1.color as color ,t1.f_pcs as pcs ,t1.m_pcs as missprint,t1.patla_id, t2.patla_name as p_name,t3.em_name,t1.emuser_id,t1.ghat_saree FROM `embroidery_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id  LEFT JOIN em_user as t3 on t1.`emuser_id` =t3.emuser_id  WHERE  t1.`el_id`='".$design."'" )->row();
            }else{
                $data['datail']=$this->db->query("SELECT t1.color as color ,t1.pcs as pcs ,t1.dmg_pcs as missprint,t1.patla_id, t2.patla_name as p_name,t3.em_name,t1.emuser_id,t1.ghat_saree FROM `ghadi_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id  LEFT JOIN em_user as t3 on t1.`emuser_id` =t3.emuser_id  WHERE  t1.`gl_id`='".$design."'" )->row();
            }
            $data['status']="success";
        }else{
            $data['status']="error"; 
        }
        echo json_encode($data);
    }
}