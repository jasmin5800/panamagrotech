<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Ghadi extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('GhadiModel');
        $this->load->model('PrintingModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role5();
    }
    public function index()
    {
        $data['page_title']="Ghadi";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/ghadi/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function get_addfrm()
    {
        $this->General_model->auth_check();
        $data['page_title']="Ghadi";
        $data['lot_no'] =$this->db->query("SELECT lot_no FROM `cut` WHERE `process_status` = 1 ORDER BY `lot_no` DESC")->result();
        $data['sub_process'] = $this->General_model->get_row('sub_process','id_sub_process','5');
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/ghadi/create',$data);
        $this->load->view('admin/controller/footer');
    }
    public function create()
    {
        $this->General_model->auth_check();
        $name=trim($this->input->post('name'));
        $remark=trim($this->input->post('remark'));
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
        $ghadi_val=$this->input->post('ghadi_val');
        if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($ghadi_val) && !empty($ghadi_val) && isset($child_sb) && !empty($child_sb)){
            $challan_no=$this->GhadiModel->challan_no();
            $detail=['challan_no'=>$challan_no['challan_no'],
                        'name'=>$name,
                        'address'=>$address,
                        'remark'=>$remark,
                        'date'=>$date,
                        'lot_no'=>$lot_no,
                        'vahicle'=>$vahicle,
                        'vahicle_no'=>$vahicle_no,
                        'sb_id'=>5,
                        'child_sb'=>$child_sb,
                        'tarsport_id'=>NULL,
                        't_design'=>$t_design,
                        't_pcs'=>$t_pcs,
                        't_missprint'=>$t_dmgpcs,
                        't_ghatsaree'=>$t_ghatsaree,
                        'cloth_value'=>$cloth_val,
                        'ghadi_value'=>$ghadi_val,
                        'sub_total'=>$sub_total,
                        'tax'=>$tax,
                        'user_id'=>$_SESSION['auth_user_id'],
                        'g_total'=>$g_total,
                        'status'=>'1',
                        'created_at'=>date("Y-m-d h:i:s")];
            $ghadi_id = $this->General_model->addid('ghadi',$detail);
            $balance=$this->General_model->get_row('balance','lot_no',$lot_no);
            if($balance->ghadi_status==1){
                $upd_balance=['ghadi_cloth'=>$ghadi_val,'ghadi_status'=>0];
                $this->General_model->update('balance',$upd_balance,'lot_no',$lot_no);
            }
            $msg="ghadi insert id ".$ghadi_id;
            $this->LogModel->simplelog($msg);
            $i=0;
            foreach ($this->input->post('n_design') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $n_design=$this->input->post('n_design')[$i];
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $patla_id=$this->input->post('patla')[$i];
                $patla_id=((empty($patla_id) || $patla_id==0)?NULL:$patla_id);
                $dmg_pcs=$this->input->post('dmg_pcs')[$i];
                $ghat_saree=$this->input->post('ghat_saree')[$i];
                $emuser_id=$this->input->post('emuser')[$i];
                $emuser_id=((empty($emuser_id) || $emuser_id==0)?NULL:$emuser_id);
                if(isset($ghadi_id) && !empty($ghadi_id) && !empty($n_design) && !empty($color)  &&!empty($pcs)){
                        if($child_sb != "C"){
                            $where=(($child_sb=="A")?['pl_id'=>$design_no]:['el_id'=>$design_no]);
                            $table=(($child_sb=="A")?"priting_lot":"embroidery_lot");
                            $this->General_model->update_where($table,['status'=>0],$where);
                            $table_id=(($child_sb=="A")?"pl_id":"el_id");
                            $query=$this->General_model->get_row($table,$table_id,$design_no);
                            $design_no=$query->design_no;
                            $design_unique=$query->unique_design;
                        }else{
                            $design_no=$n_design;
                            $design_unique=$this->PrintingModel->unique_design();
                        }
                    $ghadi_lot=['ghadi_id'=>$ghadi_id,
                                    'lot_no'=>$lot_no,
                                    'sb_id'=>5,
                                    'emuser_id'=>$emuser_id,
                                    'child_sb'=>$child_sb,
                                    'unique_design'=>$design_unique,
                                    'design_no'=>$design_no,
                                    'n_design'=>$n_design,
                                    'color'=>$color,
                                    'pcs'=>$pcs,
                                    'dmg_pcs'=>$dmg_pcs,
                                    'ghat_saree'=>$ghat_saree,
                                    'patla_id'=>$patla_id,
                                    'status'=>1,
                                    'created_at'=>date("Y-m-d h:i:s")];
                    $this->General_model->add('ghadi_lot',$ghadi_lot);
                    }
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Ghadi Added' ];
            $this->session->set_userdata($sess_data);       
            redirect('Ghadi/view_invoice/'.$ghadi_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Ghadi/get_addfrm/');
        }
    }
    public function getLists(){
        $columns = array( 
                    0 =>'ghadi_id', 
                    1=> 'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4 =>'name',
                    5=> 'child_sb',
                    6=> 'remark',
                    7=>'t_design',
                    8=>'t_pcs',
                    9=> 'cloth_value',
                    10=> 'g_total',
                    11=> 'ghadi_value',
                    12=>'user_name',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->GhadiModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->GhadiModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->GhadiModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->GhadiModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            setlocale(LC_MONETARY, 'en_IN');
            $i=1;
            foreach ($posts as $post)
            {
                if($_SESSION['auth_role_id']=="1"){
                   $button='
                   <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                     <div class="btn-group" role="group">
                       <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-eye" aria-hidden="true"></i>
                       </button>
                       <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                         <a class="dropdown-item" href="'.base_url('Ghadi/view_invoice/').$post->ghadi_id.'">Invoice 1</a>
                         <a class="dropdown-item" href="'.base_url('Ghadi/invoice/').$post->ghadi_id.'">Invoice 2</a>
                       </div>
                     </div>
                   </div>
                   <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->ghadi_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }else{
                   $button='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                     <div class="btn-group" role="group">
                       <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-eye" aria-hidden="true"></i>
                       </button>
                       <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                         <a class="dropdown-item" href="'.base_url('Ghadi/view_invoice/').$post->ghadi_id.'">Invoice 1</a>
                         <a class="dropdown-item" href="'.base_url('Ghadi/invoice/').$post->ghadi_id.'">Invoice 2</a>
                       </div>
                     </div>
                   </div>';
                }
                $child_sb=(($post->child_sb=="A")?"<span class='bg-success text-white px-2 py-1'>KANJI</span>":"<span class='bg-dark text-white px-2 py-1'>EMROD</span>");
                $nestedData['sr_no'] =$i;
                $nestedData['name'] =$post->name;
                $nestedData['child_sb'] =$child_sb;
                $nestedData['challan_no'] =$post->challan_no;
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['remark'] =strtoupper($post->remark);
                $nestedData['date'] =date('d/m/Y',strtotime($post->date));
                $nestedData['t_design'] =$post->t_design;
                $nestedData['t_pcs'] =$post->t_pcs;
                $nestedData['cloth_value'] = number_format($post->cloth_value,2);
                $nestedData['g_total'] =  number_format($post->g_total,2);
                $nestedData['ghadi_value'] = number_format($post->ghadi_value,2);
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
    public function invoice($id)
    {
        $data['page_title']="Ghadi";
        $data['ghadi']=$this->db->query("SELECT t1.*,t2.name as process_name FROM ghadi as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.ghadi_id='".$id."'")->row();
        if($data['ghadi']->child_sb=="A"){
            $data['balance']=$this->db->query("SELECT `print_cloth` as process_val FROM `balance` WHERE lot_no=".$data['ghadi']->lot_no."")->row();
            $data['ghadi_lot']=$this->db->query("SELECT t1.*,t2.patla_name FROM ghadi_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id WHERE ghadi_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }else{
            $data['balance']=$this->db->query("SELECT `embroidery_cloth` as process_val FROM `balance` WHERE lot_no=".$data['ghadi']->lot_no."")->row();
            $data['ghadi_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM ghadi_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE ghadi_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['ghadi']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/ghadi/snd_invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function view_invoice($id)
    {
        $data['page_title']="Ghadi";
        $data['ghadi']=$this->db->query("SELECT t1.*,t2.name as process_name FROM ghadi as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.ghadi_id='".$id."'")->row();
        if($data['ghadi']->child_sb=="A"){
            $data['balance']=$this->db->query("SELECT `print_cloth` as process_val FROM `balance` WHERE lot_no=".$data['ghadi']->lot_no."")->row();
            $data['ghadi_lot']=$this->db->query("SELECT t1.*,t2.patla_name FROM ghadi_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id WHERE ghadi_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }else{
            $data['balance']=$this->db->query("SELECT `embroidery_cloth` as process_val FROM `balance` WHERE lot_no=".$data['ghadi']->lot_no."")->row();
            $data['ghadi_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM ghadi_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE ghadi_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['ghadi']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/ghadi/invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $msg="ghadi delete id ".$id;
            $this->LogModel->simplelog($msg);
            $ghadi_lot=$this->General_model->get_data('ghadi_lot','ghadi_id','*',$id);
            foreach ($ghadi_lot as $key => $value) {
                $design_no=$value->design_no;
                $lot_no=$value->lot_no; 
                $design_unique=$value->unique_design;
                if($value->child_sb=="A"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0];
                    $table='priting_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }elseif($value->child_sb=="B"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0];
                    $table='embroidery_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }else{
                }
            }
            $this->General_model->delete('ghadi_lot','ghadi_id',$id);
            $this->General_model->delete('ghadi','ghadi_id',$id);
            $data['status']="success";
            $data['msg']="Ghadi Deleted";
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
                /*for kanji */

                /*$data['design']=$this->db->query("SELECT pl_id as design_id,`design_no` as design FROM `process_lot` WHERE lot_no='".$lot_no."' and sb_id='4' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT kanji_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();*/

                /*for print */
                $data['design']=$this->db->query("SELECT pl_id as design_id,`design_no` as design FROM `priting_lot` WHERE lot_no='".$lot_no."' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT print_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }elseif($child_sb=="B"){
                $data['design']=$this->db->query("SELECT el_id as design_id,`design_no` as design FROM embroidery_lot WHERE lot_no='".$lot_no."' and sb_id='6' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT embroidery_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }else{
                $data['balance']=$this->db->query("SELECT cut_pcs as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
                $data['lot_pcs']=$this->lot_pcs($lot_no);
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
            if($child_sb=="A"){
                $data['datail']=$this->db->query("SELECT `design_no` as design,t1.color as color ,t1.pcs as pcs ,t1.patla_id, t2.patla_name as p_name FROM `priting_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id WHERE t1.`pl_id`='".$design."'" )->row();
            }else{
                $data['datail']=$this->db->query("SELECT `design_no` as design,t1.color as color ,t1.f_pcs as pcs ,t1.m_pcs as missprint,t1.patla_id, t2.patla_name as p_name,t3.em_name,t1.emuser_id FROM `embroidery_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id  LEFT JOIN em_user as t3 on t1.`emuser_id` =t3.emuser_id  WHERE  t1.`el_id`='".$design."'" )->row();
            }
            $data['status']="success";
        }else{
            $data['status']="error"; 
        }
        echo json_encode($data);
    }
    public function lot_pcs($lot_no)
    {
        $cut_lot=$this->db->query("SELECT `total_pcs` FROM `cut` WHERE `lot_no` ='".$lot_no."' and `use_for`='3 '");
        $result=$cut_lot->num_rows();
        if($result>0){
            $cut=$cut_lot->row();
            $cut_lot_pcs=$cut->total_pcs;
            $ghadi_lot=$this->db->query("SELECT SUM(`pcs`) as lot_pcs FROM `ghadi_lot` WHERE lot_no='".$lot_no."' and child_sb='C'")->row();
            $ghadi_lot_pcs=$ghadi_lot->lot_pcs;
            $ghadi_lot_pcs=((isset($ghadi_lot_pcs) && !empty($ghadi_lot_pcs))? $ghadi_lot_pcs:0);
            $data['lot_pcs']=$cut_lot_pcs-$ghadi_lot_pcs;
            if($data['lot_pcs']>0){
                return $data['lot_pcs'];
            }else{
                $data['lot_pcs']=0;
                return $data['lot_pcs'];
            }
        }else{
            $data['lot_pcs']=0;
            return $data['lot_pcs'];
        }
    }
}