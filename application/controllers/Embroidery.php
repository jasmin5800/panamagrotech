<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Embroidery extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('EmbroideryModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_role6();
    }
    public function index()
    {
        $data['page_title']="Embroidery";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/embroidery/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function get_addfrm()
    {
        $this->General_model->auth_check();
        $data['page_title']="Embroidery";
        $data['lot_no'] =$this->db->query("SELECT lot_no FROM `cut` WHERE `process_status` = 1 ORDER BY `lot_no` DESC")->result();
        $data['sub_process'] = $this->General_model->get_row('sub_process','id_sub_process','5');
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/embroidery/create',$data);
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
        $t_machinedmg=$this->input->post('t_machinedmg');
        $t_missprint=$this->input->post('t_missprint');
        $t_ghatsaree=$this->input->post('t_ghatsaree');
        $cloth_val=$this->input->post('cloth_val');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $g_total=$this->input->post('g_total');
        $embroidery_val=$this->input->post('embroidery_val');
        if(isset($lot_no) && !empty($lot_no) &&  isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($embroidery_val) && !empty($embroidery_val) && isset($child_sb) && !empty($child_sb)){
            $challan_no=$this->EmbroideryModel->challan_no();
            $detail=['challan_no'=>$challan_no['challan_no'],
                        'name'=>$name,
                        'address'=>$address,
                        'date'=>$date,
                        'lot_no'=>$lot_no,
                        'vahicle'=>$vahicle,
                        'vahicle_no'=>$vahicle_no,
                        'sb_id'=>6,
                        'child_sb'=>$child_sb,
                        'tarsport_id'=>NULL,
                        't_design'=>$t_design,
                        't_pcs'=>$t_pcs,
                        't_machinedmg'=>$t_machinedmg,
                        't_ghatsaree'=>$t_ghatsaree,
                        't_missprint'=>$t_missprint,
                        'cloth_value'=>$cloth_val,
                        'embroidery_value'=>$embroidery_val,
                        'sub_total'=>$sub_total,
                        'tax'=>$tax,
                        'g_total'=>$g_total,
                        'user_id'=>$_SESSION['auth_user_id'],
                        'status'=>'1',
                        'created_at'=>date("Y-m-d h:i:s")];
            $embroidery_id = $this->General_model->addid('embroidery',$detail);
            $msg="embroidery insert ".$embroidery_id;
            $this->LogModel->simplelog($msg);
            $balance=$this->General_model->get_row('balance','lot_no',$lot_no);
            if($balance->embroidery_status==1){
                $upd_balance=['embroidery_cloth'=>$embroidery_val,'embroidery_status'=>0];
                $this->General_model->update('balance',$upd_balance,'lot_no',$lot_no);
            }
            $i=0;
            foreach ($this->input->post('design_no') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $patla_id=$this->input->post('patla')[$i];
                $patla_id=((empty($patla_id) || $patla_id==0)?NULL:$patla_id);
                $emuser_id=$this->input->post('emuser')[$i];
                $emuser_id=((empty($emuser_id) || $emuser_id==0)?NULL:$emuser_id);
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $machine_dmg=$this->input->post('machine_dmg')[$i];
                $dmg_pcs=$this->input->post('dmg_pcs')[$i];
                $ghat_saree=$this->input->post('ghat_saree')[$i];
                $fpcs=$this->input->post('fpcs')[$i];
                $rate=$this->input->post('rate')[$i];
                $amount=$this->input->post('amount')[$i];
                if(isset($embroidery_id) && !empty($embroidery_id) && !empty($design_no) && !empty($color)  &&!empty($pcs)){
                    $this->General_model->update_where('emdevide_lot',['status'=>0],['emd_id'=>$design_no]);
                        $query=$this->General_model->get_row('emdevide_lot','emd_id',$design_no);
                        $design_no=$query->n_design;
                        $design_unique=$query->unique_design;
                    $embroidery_lot=['embroidery_id'=>$embroidery_id,
                                    'emuser_id'=>$emuser_id,
                                    'lot_no'=>$lot_no,
                                    'sb_id'=>6,
                                    'child_sb'=>$child_sb,
                                    'unique_design'=>$design_unique,
                                    'design_no'=>$design_no,
                                    'color'=>$color,
                                    'pcs'=>$pcs,
                                    'color'=>$color,
                                    'm_pcs'=>$dmg_pcs,
                                    'machine_dmg'=>$machine_dmg,
                                    'patla_id'=>$patla_id,
                                    'ghat_saree'=>$ghat_saree,
                                    'f_pcs'=>$fpcs,
                                    'rate'=>$rate,
                                    'total'=>$amount,
                                    'status'=>1,
                                    'created_at'=>date("Y-m-d h:i:s")];
                    }
                $this->General_model->add('embroidery_lot',$embroidery_lot);
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Embroidery Added' ];
            $this->session->set_userdata($sess_data);       
            redirect('Embroidery/view_invoice/'.$embroidery_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Embroidery/get_addfrm/');
        }
    }
    public function getLists(){
        $columns = array( 
                    0=>'embroidery_id', 
                    1=> 'lot_no',
                    2=> 'challan_no',
                    3=> 'date',
                    4=> 'name',
                    5=> 'child_sb',
                    6=>'t_design',
                    7=>'t_pcs',
                    8=> 'cloth_value',
                    9=> 'g_total',
                    10=> 'embroidery_value',
                    11=>'user_name',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->EmbroideryModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->EmbroideryModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->EmbroideryModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->EmbroideryModel->posts_search_count($search);
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
                   <a href="'.base_url('Embroidery/get_editfrm/').$post->embroidery_id .'"><button type="button" class="btn btn-primary waves-effect btn-sm waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class="dropdown-item" href="'.base_url('Embroidery/view_invoice/').$post->embroidery_id.'">Invoice 1</a>
                          <a class="dropdown-item" href="'.base_url('Embroidery/invoice/').$post->embroidery_id.'">Invoice 2</a>
                        </div>
                      </div>
                    </div>
                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-id="delete" data-value="'.$post->embroidery_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }else{
                   $button='<a href="'.base_url('Embroidery/get_editfrm/').$post->embroidery_id .'"><button type="button" class="btn btn-primary waves-effect btn-sm waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-custom btn-sm waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class="dropdown-item" href="'.base_url('Embroidery/view_invoice/').$post->embroidery_id.'">Invoice 1</a>
                          <a class="dropdown-item" href="'.base_url('Embroidery/invoice/').$post->embroidery_id.'">Invoice 2</a>
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
                $nestedData['t_missprint'] =$post->t_missprint;
                $nestedData['t_ghatsaree'] =$post->t_ghatsaree;
                $nestedData['t_machinedmg'] =$post->t_machinedmg;
                $nestedData['date'] =date('d/m/Y',strtotime($post->date));
                $nestedData['t_design'] =$post->t_design;
                $nestedData['t_pcs'] =$post->t_pcs;
                $nestedData['cloth_value'] = number_format($post->cloth_value,2);
                $nestedData['g_total'] =  number_format($post->g_total,2);
                $nestedData['embroidery_value'] = number_format($post->embroidery_value,2);
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
        $data['page_title']="Embroidery";
        $data['embroidery']=$this->General_model->get_row('embroidery','embroidery_id',$id);
        $data['embroidery_lot']=$this->db->query("SELECT t1.*,t2.patla_name,t3.em_name FROM embroidery_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id=t2.patla_id LEFT JOIN em_user as t3 ON t1.emuser_id=t3.emuser_id WHERE `embroidery_id`='".$id."'")->result();
        if($data['embroidery']->child_sb=="A"){
            $data['design']=$this->db->query("SELECT emd_id  as design_id,`n_design` as design FROM `emdevide_lot` WHERE lot_no='".$data['embroidery']->lot_no."' and child_sb='A' and status='1'")->result();
            $data['balance']=$this->db->query("SELECT ghadi_cloth as process_val FROM `balance` WHERE lot_no=".$data['embroidery']->lot_no."")->row();
        }else{
            $data['design']=$this->db->query("SELECT emd_id  as design_id,`n_design` as design FROM emdevide_lot WHERE lot_no='".$data['embroidery']->lot_no."' and child_sb='B' and status='1'")->result();
            $data['balance']=$this->db->query("SELECT cut_pcs as process_val FROM `balance` WHERE lot_no=".$data['embroidery']->lot_no."")->row();
        }
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/embroidery/edit',$data);
        $this->load->view('admin/controller/footer');
    }
    public function update()
    {
        $this->General_model->auth_check();
        $name=trim($this->input->post('name'));
        $address=trim($this->input->post('address'));
        $date = explode('/',$this->input->post('date')); 
        $date =[$date[2],$date[1],$date[0]];
        $date=implode("-", $date);
        $vahicle=trim($this->input->post('vahicle'));
        $vahicle_no=trim($this->input->post('vahicle_no'));
        $t_design=$this->input->post('t_design');
        $t_pcs=$this->input->post('t_pcs');
        $t_machinedmg=$this->input->post('t_machinedmg');
        $t_missprint=$this->input->post('t_missprint');
        $t_ghatsaree=$this->input->post('t_ghatsaree');
        $cloth_val=$this->input->post('cloth_val');
        $sub_total=$this->input->post('sub_total');
        $tax=$this->input->post('tax');
        $g_total=$this->input->post('g_total');
        $embroidery_val=$this->input->post('embroidery_val');
        $embroidery_id=$this->input->post('embroidery_id');
        if(isset($date) && !empty($date) && isset($t_design) && !empty($t_design) && isset($t_pcs) && !empty($t_pcs)&& isset($cloth_val) && !empty($cloth_val) && isset($sub_total) && !empty($sub_total)&& isset($embroidery_val) && !empty($embroidery_val) && isset($embroidery_id) && !empty($embroidery_id) ){

            $msg="embroidery  update ".$embroidery_id;
            $this->LogModel->simplelog($msg);
            $detail=[ 'name'=>$name,
                        'address'=>$address,
                        'date'=>$date,
                        'vahicle'=>$vahicle,
                        'vahicle_no'=>$vahicle_no,
                        't_design'=>$t_design,
                        't_pcs'=>$t_pcs,
                        't_machinedmg'=>$t_machinedmg,
                        't_ghatsaree'=>$t_ghatsaree,
                        't_missprint'=>$t_missprint,
                        'cloth_value'=>$cloth_val,
                        'embroidery_value'=>$embroidery_val,
                        'sub_total'=>$sub_total,
                        'tax'=>$tax,
                        'user_id'=>$_SESSION['auth_user_id'],
                        'g_total'=>$g_total ];
            $this->General_model->update('embroidery',$detail,'embroidery_id',$embroidery_id);
            $embroidery=$this->General_model->get_row('embroidery','embroidery_id',$embroidery_id);
            $lot_no=$embroidery->lot_no;
            $child_sb=$embroidery->child_sb;
            $i=0;
            foreach ($this->input->post('design_no') as $key) {
                $design_no=$this->input->post('design_no')[$i];
                $patla_id=$this->input->post('patla')[$i];
                $patla_id=((empty($patla_id) || $patla_id==0)?NULL:$patla_id);
                $emuser_id=$this->input->post('emuser')[$i];
                $emuser_id=((empty($emuser_id) || $emuser_id==0)?NULL:$emuser_id);
                $color=$this->input->post('color')[$i];
                $pcs=$this->input->post('pcs')[$i];
                $machine_dmg=$this->input->post('machine_dmg')[$i];
                $dmg_pcs=$this->input->post('dmg_pcs')[$i];
                $ghat_saree=$this->input->post('ghat_saree')[$i];
                $fpcs=$this->input->post('fpcs')[$i];
                $rate=$this->input->post('rate')[$i];
                $amount=$this->input->post('amount')[$i];
                $el_id=$this->input->post('el_id')[$i];
                if(isset($el_id) && !empty($el_id) && isset($embroidery_id) && !empty($embroidery_id) && !empty($design_no) && !empty($color)  &&!empty($pcs)){
                    $embroidery_lot=['emuser_id'=>$emuser_id,
                                        'color'=>$color,
                                        'pcs'=>$pcs,
                                        'color'=>$color,
                                        'm_pcs'=>$dmg_pcs,
                                        'machine_dmg'=>$machine_dmg,
                                        'patla_id'=>$patla_id,
                                        'ghat_saree'=>$ghat_saree,
                                        'f_pcs'=>$fpcs,
                                        'rate'=>$rate,
                                        'total'=>$amount ]; 
                $this->General_model->update('embroidery_lot',$embroidery_lot,'el_id',$el_id); 
                }elseif(isset($embroidery_id) && !empty($embroidery_id) && !empty($design_no) && !empty($color)  &&!empty($pcs)) {
                    $this->General_model->update_where('emdevide_lot',['status'=>0],['emd_id'=>$design_no]);
                        $query=$this->General_model->get_row('emdevide_lot','emd_id',$design_no);
                        $design_no=$query->n_design;
                        $design_unique=$query->unique_design;
                        $embroidery_lot=['embroidery_id'=>$embroidery_id,
                                        'emuser_id'=>$emuser_id,
                                        'lot_no'=>$lot_no,
                                        'sb_id'=>6,
                                        'child_sb'=>$child_sb,
                                        'unique_design'=>$design_unique,
                                        'design_no'=>$design_no,
                                        'color'=>$color,
                                        'pcs'=>$pcs,
                                        'color'=>$color,
                                        'm_pcs'=>$dmg_pcs,
                                        'machine_dmg'=>$machine_dmg,
                                        'patla_id'=>$patla_id,
                                        'ghat_saree'=>$ghat_saree,
                                        'f_pcs'=>$fpcs,
                                        'rate'=>$rate,
                                        'total'=>$amount,
                                        'status'=>1,
                                        'created_at'=>date("Y-m-d h:i:s")];                    
                    $this->General_model->add('embroidery_lot',$embroidery_lot);
                }else{
                }
                $i++;
            }
            $sess_data = ['status'  => 'success',
                            'msg'  => 'Embroidery Update' ];
            $this->session->set_userdata($sess_data);       
            redirect('Embroidery/view_invoice/'.$embroidery_id);
        }else{
            $sess_data = ['status'  => 'error',
                            'msg'  => 'Something Is Worng' ];
            $this->session->set_userdata($sess_data);   
            redirect('Embroidery/');
        }
    }
    public function invoice($id)
    {
        $data['page_title']="Embroidery";
        $data['embroidery']=$this->db->query("SELECT t1.*,t2.name as process_name FROM embroidery as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.embroidery_id='".$id."'")->row();
        $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['embroidery']->lot_no."")->row();
        $data['embroidery_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM embroidery_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE embroidery_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['embroidery']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/embroidery/snd_invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function view_invoice($id)
    {
        $data['page_title']="Embroidery";
        $data['embroidery']=$this->db->query("SELECT t1.*,t2.name as process_name FROM embroidery as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.embroidery_id='".$id."'")->row();
        $data['balance']=$this->db->query("SELECT `ghadi_cloth` as process_val FROM `balance` WHERE lot_no=".$data['embroidery']->lot_no."")->row();
        $data['embroidery_lot']=$this->db->query("SELECT t1.*,t2.patla_name ,t3.em_name FROM embroidery_lot as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id  LEFT JOIN em_user as t3 ON t1.emuser_id = t3.emuser_id WHERE embroidery_id='".$id."' ORDER BY `t1`.`design_no` ASC")->result();
        $data['party']=$this->db->query("SELECT t1.party_id,t2.srt_name,t2.gst_number FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id =t2.party_id where t1.lot_no='".$data['embroidery']->lot_no."'")->row();
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/embroidery/invoice',$data);
        $this->load->view('admin/controller/footer');
    }
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $msg="embroidery  delete ".$id;
            $this->LogModel->simplelog($msg);
            $embroidery_lot=$this->General_model->get_data('embroidery_lot','embroidery_id','*',$id);
            foreach ($embroidery_lot as $key => $value) {
                $lot_no=$value->lot_no; 
                $design_unique=$value->unique_design;
                if($value->child_sb=="A"){
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"A"];
                    $table='emdevide_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }else{
                    $where=['lot_no'=>$lot_no,'unique_design'=>$design_unique,'status'=>0,'child_sb'=>"B"];
                    $table='emdevide_lot';
                    $data=['status'=>1];
                    $this->General_model->update_where($table,$data,$where);
                }
            }
            $this->General_model->delete('embroidery_lot','embroidery_id',$id);
            $this->General_model->delete('embroidery','embroidery_id',$id);
            $data['status']="success";
            $data['msg']="Embroidery Deleted";
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
                $data['design']=$this->db->query("SELECT emd_id  as design_id,`n_design` as design FROM `emdevide_lot` WHERE lot_no='".$lot_no."' and child_sb='A' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT ghadi_cloth as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
            }else{
                $data['design']=$this->db->query("SELECT emd_id  as design_id,`n_design` as design FROM emdevide_lot WHERE lot_no='".$lot_no."' and child_sb='B' and status='1'")->result();
                $data['balance']=$this->db->query("SELECT cut_pcs as process_val FROM `balance` WHERE lot_no=".$lot_no."")->row();
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
        if(isset($design) && !empty($design) ){
            $data['datail']=$this->db->query("SELECT t1.color as color ,t1.pcs as pcs, t1.patla_id, t2.patla_name as p_name,t3.em_name,t1.emuser_id FROM `emdevide_lot`as t1 LEFT JOIN patla as t2 on t1.`patla_id`=t2.patla_id  LEFT JOIN em_user as t3 on t1.`emuser_id` =t3.emuser_id  WHERE  t1.`emd_id`='".$design."'" )->row();
            $data['status']="success";
        }else{
            $data['status']="error"; 
        }
        echo json_encode($data);
    }
}