<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Processss extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('ProcessModel');
        $this->load->model('PrintingModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role4();
    }
    public function index()
    {
        $data['page_title']="Process";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/process/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function get_addfrm()
    {
        $this->General_model->auth_check();
        $data['page_title']="Process";
        $data['lot_no'] =$this->db->query("SELECT lot_no FROM `cut` WHERE `process_status` = 1 ORDER BY `lot_no` DESC")->result();
        $data['sub_process'] = $this->General_model->get_data('sub_process','status','*','1');
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/process/create',$data);
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
        $sb_id=$this->input->post('sb_id');
        $vahicle=trim($this->input->post('vahicle'));
        $vahicle_no=trim($this->input->post('vahicle_no'));
        $t_design=$this->input->post('t_design');
        $t_pcs=$this->input->post('t_pcs');
        $cloth_val=$this->input->post('cloth_val');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $g_total=$this->input->post('g_total');
        $process_val=$this->input->post('process_val');
        if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($process_val) && !empty($process_val) && isset($sb_id) && !empty($sb_id)){
            $challan_no=$this->ProcessModel->challan_no();
            $detail=['challan_no'=>$challan_no['challan_no'],
                        'name'=>$name,
                        'address'=>$address,
                        'date'=>$date,
                        'lot_no'=>$lot_no,
                        'vahicle'=>$vahicle,
                        'vahicle_no'=>$vahicle_no,
                        'sb_id'=>$sb_id,
                        'tarsport_id'=>NULL,
                        't_design'=>$t_design,
                        't_pcs'=>$t_pcs,
                        'cloth_value'=>$cloth_val,
                        'process_value'=>$process_val,
                        'sub_total'=>$sub_total,
                        'tax'=>$tax,
                        'g_total'=>$g_total,
                        'user_id'=>$_SESSION['auth_user_id'],
                        'status'=>'1',
                        'created_at'=>date("Y-m-d h:i:s")];
            $process_id = $this->General_model->addid('process',$detail);
            $sub_process=$this->General_model->get_row("sub_process",'id_sub_process',$sb_id);
            $process_name=trim(strtolower($sub_process->name))."_cloth";
            $process_status=trim(strtolower($sub_process->name))."_status";
            
            $balance=$this->General_model->get_row('balance','lot_no',$lot_no);
            $msg="process insert ".$process_name." lot no ".$lot_no;
            $this->LogModel->simplelog($msg);
            if($balance->$process_status==1){
                $upd_balance=[$process_name=>$process_val,$process_status=>0];
                $this->General_model->update('balance',$upd_balance,'lot_no',$lot_no);
            }
            $i=0;
            foreach ($this->input->post('design_no') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $patla_id=$this->input->post('patla')[$i];
                if(isset($process_id) && !empty($process_id) && !empty($design_no) && !empty($color)  &&!empty($pcs) && !empty($patla_id)){
                    if($design_no==="LTfJxVlLLcpF"){
                        $design_no="miss-print";
                        $design_unique=$this->PrintingModel->unique_design();
                    }else{
                        $where=['pl_id'=>$design_no];
                        $table=(($sb_id==2)?"priting_lot":"process_lot");
                        $this->General_model->update_where($table,['status'=>0],$where);
                        $query=$this->General_model->get_row($table,'pl_id',$design_no);
                        $design_no=$query->design_no;
                        $design_unique=$query->unique_design;
                    }
                    $process_lot=['process_id'=>$process_id,
                                    'lot_no'=>$lot_no,
                                    'sb_id'=>$sb_id,
                                    'unique_design'=>$design_unique,
                                    'design_no'=>$design_no,
                                    'color'=>$color,
                                    'pcs'=>$pcs,
                                    'patla_id'=>$patla_id,
                                    'status'=>1,
                                    'created_at'=>date("Y-m-d h:i:s")];
                    $this->General_model->add('process_lot',$process_lot);
                    }
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Process Added' ];
            $this->session->set_userdata($sess_data);       
            redirect('Process/view_invoice/'.$process_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Process/get_addfrm/');
        }
    }
    public function getLists(){
        $columns = array( 
                    0 =>'process_id', 
                    1=> 'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4=>'name',
                    5=> 'process_name',
                    6=>'t_design',
                    7=>'t_pcs',
                    8=> 'cloth_value',
                    9=> 'g_total',
                    10=> 'process_value',
                    11=>'user_name',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->ProcessModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->ProcessModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->ProcessModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->ProcessModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            setlocale(LC_MONETARY, 'en_IN');
            $i=1;
            foreach ($posts as $post)
            {
                if($_SESSION['auth_role_id']=="1"){
                   $button='<a href="'.base_url('Process/view_invoice/').$post->process_id .'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->process_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }else{
                   $button='<a href="'.base_url('Process/view_invoice/').$post->process_id .'"><button type="button" class="btn btn-custom btn-sm waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
                }
                $process_name=(($post->sb_id=="2")?"<span class='bg-primary text-white px-2 py-1'>SILICATE</span>":(($post->sb_id=="3")?"<span class='bg-secondary text-white px-2 py-1'>DHOLAI</span>":"<span class='bg-success text-white px-2 py-1'>KANJI</span>"));
                $nestedData['sr_no'] =$i;
                $nestedData['name'] =$post->name;
                $nestedData['challan_no'] =$post->challan_no;
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['process_name'] =$process_name;
                $nestedData['date'] =date('d/m/Y',strtotime($post->date));
                $nestedData['t_design'] =$post->t_design;
                $nestedData['t_pcs'] =$post->t_pcs;
                $nestedData['cloth_value'] = number_format($post->cloth_value,2);
                $nestedData['g_total'] =  number_format($post->g_total,2);
                $nestedData['process_value'] = number_format($post->process_value,2);
                $nestedData['user_name'] = strtoupper($post->user_name);
                $nestedData['button'] =$button;
                ;
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
        $data['page_title']="Process";
        $data['process']=$this->db->query("SELECT t1.*,t2.name as process_name FROM process as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where t1.process_id ='".$id."'")->row();
        $sub_process=$data['process']->sb_id-1;
        $process=$this->General_model->get_row('sub_process','by_seq',$sub_process);
        $process_name=trim(strtolower($process->name));
        $balance=$this->db->query("SELECT `".$process_name."_cloth` as process_val FROM `balance` WHERE lot_no=".$data['process']->lot_no."")->row(); 
        $data['process_lot']=$this->db->query("SELECT t1.*,t2.patla_name FROM process_lot as t1 LEFT JOIN patla as t2 ON t1.patla_Id = t2.patla_Id WHERE process_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['process']->lot_no."'")->row();
        $data['subtotal']=($balance->process_val*$data['process']->t_pcs);
        $data['sgst']=($data['subtotal']*2.5)/100;
        $data['cgst']=($data['subtotal']*2.5)/100;
        $data['g_total']=$data['subtotal']+$data['sgst']+$data['cgst'];
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/process/invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $process_lot=$this->General_model->get_data('process_lot','process_id','*',$id);
            $process_row=$this->General_model->get_row('process','process_id','*',$id);
            $msg="process delete id ".$id;
            $this->LogModel->simplelog($msg);
            foreach ($process_lot as $key => $value) {
                $design_no=$value->design_no;
                $lot_no=$value->lot_no;
                $design_unique=$value->unique_design;
                if($value->sb_id=="2"){
                    if($design_no != "miss-print"){
                        $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0];
                        $table='priting_lot';
                        $data=['status'=>1];
                        $this->General_model->update_where($table,$data,$where);
                    }
                }elseif($value->sb_id=="3"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'sb_id'=>2];
                    $table='process_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }else{
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'sb_id'=>3];
                    $table='process_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }
            }
            $this->General_model->delete('process_lot','process_id',$id);
            $this->General_model->delete('process','process_id',$id);
            $data['status']="success";
            $data['msg']="Process Deleted";
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
        $sub_process=$this->input->post('process');
        if(isset($lot_no) && !empty($lot_no) && isset($sub_process) && !empty($sub_process) ){
            if($sub_process==2){
                $data['design']=$this->db->query("SELECT pl_id as design_id, design_no as design FROM `priting_lot` WHERE lot_no=".$lot_no." and status='1' ORDER BY `priting_lot`.`design_no` ASC")->result();
            }else{
                $data['design']=$this->db->query("SELECT pl_id as design_id,design_no as design FROM `process_lot` WHERE lot_no=".$lot_no." and sb_id='".($sub_process-1)."' and status='1'")->result();
            }
            $sub_process=(int)$sub_process-1;
            $process=$this->General_model->get_row('sub_process','by_seq',$sub_process);
            $process_name=strtolower(trim($process->name))."_cloth";
            $data['balance']=$this->db->query("SELECT `".$process_name."` as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            $data['status']="success";
        }else{
            $data['status']="error";
        }
        echo json_encode($data);
    }
    public function design_row()
    {
        $this->General_model->auth_check();
        $sub_process=$this->input->post('s_process');
        $design=$this->input->post('design');
        $this->General_model->auth_check();
        if(isset($sub_process) && !empty($sub_process) && isset($design) && !empty($design) ){
            if($sub_process==2){
            $data['datail']=$this->db->query("SELECT t1.design_no as design ,t1.color,t1.pcs as pcs,t1.patla_id as patla_id, t2.patla_name as p_name FROM `priting_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id WHERE t1.`pl_id`='".$design."'")->row();
            }else{
                $data['datail']=$this->db->query("SELECT t1.design_no as design ,t1.color,t1.pcs as pcs ,t1.patla_id as patla_id, t2.patla_name as p_name FROM `process_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id WHERE t1.`pl_id`='".$design."'")->row();
            }
            $data['status']="success";
        }else{
            $data['status']="error"; 
        }
        echo json_encode($data);
    }
}