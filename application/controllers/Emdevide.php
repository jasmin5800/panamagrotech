<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Emdevide extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('EmDevideModel');
        $this->load->model('PrintingModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role6();
    }
    public function index()
    {
        $data['page_title']="Em Devide";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/emdevide/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function get_addfrm()
    {
        $this->General_model->auth_check();
        $data['page_title']="Em Devide";
        $data['lot_no'] =$this->db->query("SELECT lot_no FROM `cut` WHERE `process_status` = 1 ORDER BY `lot_no` DESC")->result();
        $data['emuser'] = $this->General_model->get_data('em_user','status','*','1');
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/emdevide/create',$data);
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
        $cloth_val=$this->input->post('cloth_val');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $g_total=$this->input->post('g_total');
        $emdevide_val=$this->input->post('emdevide_val');
        if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($emdevide_val) && !empty($emdevide_val) && isset($child_sb) && !empty($child_sb)){
            $challan_no=$this->EmDevideModel->challan_no();
            $detail=['challan_no'=>$challan_no['challan_no'],
                    'name'=>$name,
                    'address'=>$address,
                    'date'=>$date,
                    'lot_no'=>$lot_no,
                    'vahicle'=>$vahicle,
                    'vahicle_no'=>$vahicle_no,
                    'sb_id'=>8,
                    'child_sb'=>$child_sb,
                    'tarsport_id'=>NULL,
                    't_design'=>$t_design,
                    't_pcs'=>$t_pcs,
                    'cloth_value'=>$cloth_val,
                    'emdevide_value'=>$emdevide_val,
                    'sub_total'=>$sub_total,
                    'tax'=>$tax,
                    'user_id'=>$_SESSION['auth_user_id'],
                    'g_total'=>$g_total,
                    'status'=>'1',
                    'created_at'=>date("Y-m-d h:i:s")];
            $emdevide_id = $this->General_model->addid('emdevide',$detail);
            $msg="EmDevide insert ".$emdevide_id;
            $this->LogModel->simplelog($msg);
            $i=0;
            foreach ($this->input->post('color') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $n_design=$this->input->post('n_design')[$i];
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $patla_id=$this->input->post('patla')[$i];
                $patla_id=((empty($patla_id) || $patla_id==0)?NULL:$patla_id);
                $emuser_id=$this->input->post('emuser')[$i];
                $emuser_id=((empty($emuser_id) || $emuser_id==0)?NULL:$emuser_id);
                if(isset($emdevide_id) && !empty($emdevide_id) && !empty($color)  &&!empty($pcs)){
                        if($child_sb=="A"){
                            $where=['gl_id '=>$design_no];
                            $this->General_model->update_where('ghadi_lot',['status'=>0],$where);
                            $query=$this->General_model->get_row('ghadi_lot','gl_id',$design_no);
                            $design_no=$query->n_design;
                            $design_unique=$query->unique_design;
                        }else{
                            $design_no=NULL;
                            $design_unique=$this->PrintingModel->unique_design();
                        }
                    $emdevide_lot=['emdevide_id'=>$emdevide_id,
                                    'lot_no'=>$lot_no,
                                    'sb_id'=>8,
                                    'emuser_id'=>$emuser_id,
                                    'unique_design'=>$design_unique,
                                    'child_sb'=>$child_sb,
                                    'design_no'=>$design_no,
                                    'n_design'=>$n_design,
                                    'color'=>$color,
                                    'pcs'=>$pcs,
                                    'patla_id'=>$patla_id,
                                    'status'=>1,
                                    'created_at'=>date("Y-m-d h:i:s")];
                    $this->General_model->add('emdevide_lot',$emdevide_lot);
                    }
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Em Devide Added' ];
            $this->session->set_userdata($sess_data);       
            redirect('Emdevide/view_invoice/'.$emdevide_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Emdevide/get_addfrm/');
        }
    }
    public function getLists(){
        $columns = array( 
                    0 =>'emdevide_id', 
                    1=> 'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4 =>'name',
                    5=> 'child_sb',
                    6=>'t_design',
                    7=>'t_pcs',
                    8=> 'cloth_value',
                    9=> 'g_total',
                    11=> 'emdevide_value',
                    12=>'user_name'
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->EmDevideModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->EmDevideModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->EmDevideModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->EmDevideModel->posts_search_count($search);
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
                                  <a class="dropdown-item" href="'.base_url('Emdevide/view_invoice/').$post->emdevide_id.'">Invoice 1</a>
                                  <a class="dropdown-item" href="'.base_url('Emdevide/invoice/').$post->emdevide_id.'">Invoice 2</a>
                                </div>
                              </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->emdevide_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }else{
                    $button='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                              <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                  <a class="dropdown-item" href="'.base_url('Emdevide/view_invoice/').$post->emdevide_id.'">Invoice 1</a>
                                  <a class="dropdown-item" href="'.base_url('Emdevide/invoice/').$post->emdevide_id.'">Invoice 2</a>
                                </div>
                              </div>
                            </div>';

                }
                $child_sb=(($post->child_sb=="A")?"<span class='bg-success text-white px-2 py-1'>GHADI</span>":"<span class='bg-dark text-white px-2 py-1'>EM DEVIDE</span>");
                $nestedData['sr_no'] =$i;
                $nestedData['name'] =$post->name;
                $nestedData['child_sb'] =$child_sb;
                $nestedData['challan_no'] =$post->challan_no;
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['date'] =date('d/m/Y',strtotime($post->date));
                $nestedData['t_design'] =$post->t_design;
                $nestedData['t_pcs'] =$post->t_pcs;
                $nestedData['cloth_value'] = number_format($post->cloth_value,2);
                $nestedData['g_total'] =  number_format($post->g_total,2);
                $nestedData['emdevide_value'] = number_format($post->emdevide_value,2);
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
        $data['page_title']="Em Devide";
        $data['emdevide']=$this->db->query("SELECT t1.*,t2.name as process_name FROM emdevide as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.emdevide_id='".$id."'")->row();
        if($data['emdevide']->child_sb=="A"){
            $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['emdevide']->lot_no."")->row();
            $data['emdevide_lot']=$this->db->query("SELECT t1.*,t2.patla_name,t3.em_name FROM emdevide_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE emdevide_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }else{
            $data['balance']=$this->db->query("SELECT `cut_pcs` as process_val FROM `balance` WHERE lot_no=".$data['emdevide']->lot_no."")->row();
            $data['emdevide_lot']=$this->db->query("SELECT t1.*,t2.em_name FROM emdevide_lot as t1 LEFT JOIN em_user as t2 ON t1.emuser_id = t2.emuser_id  WHERE emdevide_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['emdevide']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/emdevide/invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function invoice($id)
    {
        $data['page_title']="Em Devide";
        $data['emdevide']=$this->db->query("SELECT t1.*,t2.name as process_name FROM emdevide as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.emdevide_id='".$id."'")->row();
        if($data['emdevide']->child_sb=="A"){
            $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['emdevide']->lot_no."")->row();
            $data['emdevide_lot']=$this->db->query("SELECT t1.*,t2.patla_name,t3.em_name FROM emdevide_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE emdevide_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }else{
            $data['balance']=$this->db->query("SELECT `cut_pcs` as process_val FROM `balance` WHERE lot_no=".$data['emdevide']->lot_no."")->row();
            $data['emdevide_lot']=$this->db->query("SELECT t1.*,t2.em_name FROM emdevide_lot as t1 LEFT JOIN em_user as t2 ON t1.emuser_id = t2.emuser_id  WHERE emdevide_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        }
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['emdevide']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/emdevide/snd_invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $msg="EmDevide delete ".$id;
            $this->LogModel->simplelog($msg);
            $emdevide_lot=$this->General_model->get_data('emdevide_lot','emdevide_id','*',$id);
            foreach ($emdevide_lot as $key => $value) {
                $design_no=$value->design_no;
                $lot_no=$value->lot_no; 
                $design_unique=$value->unique_design;
                if($value->child_sb=="A"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"A"];
                    $table='ghadi_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }else{
                }
            }
            $this->General_model->delete('emdevide_lot','emdevide_id',$id);
            $this->General_model->delete('emdevide','emdevide_id',$id);
            $data['status']="success";
            $data['msg']="EM Devide Deleted";
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
                $data['design']=$this->db->query("SELECT gl_id  as design_id,`n_design` as design FROM `ghadi_lot` WHERE lot_no='".$lot_no."' and child_sb='A' and status='1' ORDER BY `ghadi_lot`.`n_design` DESC")->result();
                $data['balance']=$this->db->query("SELECT ghadi_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
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
        $design=$this->input->post('design');
        if(isset($design) && !empty($design)){
            $data['datail']=$this->db->query("SELECT t1.design_no as design, t1.color as color ,t1.pcs as pcs ,t1.patla_id, t2.patla_name as p_name FROM `ghadi_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id WHERE t1.`gl_id`='".$design."'" )->row();
            $data['status']="success";
        }else{
            $data['status']="error"; 
        }
        echo json_encode($data);
    }
    public function lot_pcs($lot_no)
    {
        $cut_lot=$this->db->query("SELECT `total_pcs` FROM `cut` WHERE `lot_no` ='".$lot_no."' and `use_for`='2'");
        $result=$cut_lot->num_rows();
        if($result>0){
            $cut=$cut_lot->row();
            $cut_lot_pcs=$cut->total_pcs;
            $emdevide_lot=$this->db->query("SELECT SUM(`pcs`) as lot_pcs FROM emdevide_lot WHERE lot_no='".$lot_no."' and child_sb='B'")->row();
            $emdevide_lot_pcs=$emdevide_lot->lot_pcs;
            $emdevide_lot_pcs=((isset($emdevide_lot_pcs) && !empty($emdevide_lot_pcs))? $emdevide_lot_pcs:0);
            $data['lot_pcs']=$cut_lot_pcs-$emdevide_lot_pcs;
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