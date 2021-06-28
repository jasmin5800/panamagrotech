<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Manage extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('CutManageModel');
        $this->General_model->auth_check();
        $this->General_model->auth_superadmin();
    }
    public function index()
    {
        $data['page_title']="Manage";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/manage/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function lot()
    {
      $this->General_model->auth_check();
        $data['page_title']="Manage";
        $data['lot_no']=$this->db->query("SELECT `lot_no` FROM `cut` WHERE `status`='1' ORDER BY `cut`.`lot_no` DESC")->result();
        $data['display']=false;
        $lot_no=$this->input->get('lot_no');
        if(isset($lot_no) && !empty($lot_no)){
           $data['display']=true;
           $data['edit_lotno']=$lot_no;
           $data['balance'] = $this->General_model->get_row('balance','lot_no',$lot_no);
           $data['cut'] = $this->db->query("SELECT t1.*,t2.srt_name,t3.item_name FROM cut as t1 LEFT JOIN party as t2 ON t1.party_id = t2.party_id LEFT JOIN item as t3 ON t1.item_id = t3.item_id where t1.lot_no='".$lot_no."'")->row();
           $data['devide'] = $this->db->query("SELECT t1.*,t2.patla_name FROM devide as t1 LEFT JOIN patla as t2 ON t1.patla_id = t2.patla_id where  t1.lot_no='".$lot_no."' ORDER BY t1.id_devide DESC")->result();
           $data['printing'] = $this->General_model->get_row('printing','lot_no',$lot_no);
           $data['processing'] = $this->db->query("SELECT t1.*,t2.name as process_name FROM process as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where t1.lot_no='".$lot_no."' order by sb_id")->result();
           $data['ghadi']=$this->db->query("SELECT t1.*,t2.name as process_name FROM ghadi as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where t1.lot_no='".$lot_no."'")->result();
           $data['emdevide']=$this->db->query("SELECT t1.*,t2.name as process_name FROM emdevide as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.lot_no='".$lot_no."'")->result();
           $data['embroidery']=$this->db->query("SELECT t1.*,t2.name as process_name FROM embroidery as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process where  t1.lot_no='".$lot_no."'")->result();
           $data['packing']=$this->db->query("SELECT t1.*,t2.name as process_name FROM packing as t1 LEFT JOIN sub_process as t2 ON t1.sb_id = t2.id_sub_process  where  t1.lot_no='".$lot_no."'")->result();
        }
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/manage/lot',$data);
        $this->load->view('admin/controller/footer');
    }
    public function getLists(){
        $columns = array( 
                    0 =>'id_cut', 
                    1=> 'lot_no',
                    2=>'use_for',
                    3=> 'devide_status',
                    4=> 'print_status',
                    5=> 'process_status'
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->CutManageModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->CutManageModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->CutManageModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->CutManageModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            $i=1;
            foreach ($posts as $post)
            {   
                $use_for=(($post->use_for=="1")?"<span class='bg-primary text-white px-2 py-1'>DEVIDE</span>":(($post->use_for=="2")?"<span class='bg-secondary text-white px-2 py-1'>EM DEVIDE</span>":"<span class='bg-success text-white px-2 py-1'>GHADI</span>"));
                $devide_status=(($post->devide_status==1)?"<span class='bg-custom text-white px-2 py-1'>SHOW</span>":"<span class='bg-danger text-white px-2 py-1'>HIDE</span>");
                $print_status=(($post->print_status==1)?"<span class='bg-custom text-white px-2 py-1'>SHOW</span>":"<span class='bg-danger text-white px-2 py-1'>HIDE</span>");
                $process_status=(($post->process_status==1)?"<span class='bg-custom text-white px-2 py-1'>SHOW</span>":"<span class='bg-danger text-white px-2 py-1'>HIDE</span>");
                $nestedData['sr_no'] =$i;
                $nestedData['name'] =$post->name;
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['devide_status'] = $devide_status;
                $nestedData['print_status'] =$print_status;
                $nestedData['process_status'] = $process_status;
                $nestedData['use_for'] = $use_for;
                $nestedData['button'] ='
                <a href="'.base_url('Manage/get_editfrm/').$post->id_cut.'"><button type="button" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i></button></a>
                ';
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
      $data['page_title']="Manage";
      if(isset($id) && !empty($id)){
        $cut = $this->db->query("SELECT * FROM `cut` WHERE id_cut='".$id."'");
        if($cut->num_rows()>0 ){
          $data['cut']=$cut->row();
        }else{
          redirect('Dashbord');
        }
      }else{
        redirect('Dashbord');
      }
      $this->load->view('admin/controller/header');
      $this->load->view('admin/controller/sidebar');
      $this->load->view('admin/manage/manage',$data);
      $this->load->view('admin/controller/footer');
    }
    public function update()
    {
      $devide_status=trim($this->input->post('devide_status'));
      $print_status=trim($this->input->post('print_status'));
      $process_status=trim($this->input->post('process_status'));
      $cut_id=trim($this->input->post('cut_id'));
      if(isset($cut_id) && !empty($cut_id) && isset($print_status) && isset($process_status) ){
        $cut = $this->db->query("SELECT * FROM `cut` WHERE id_cut='".$cut_id."'");
        if($cut->num_rows()>0 ){
          $cut=$cut->row();
          if($cut->use_for=="1"){
              $detail=['devide_status'=>$devide_status,
                          'print_status'=>$print_status,
                          'process_status'=>$process_status ];
          }else{
              $detail=['print_status'=>$print_status,
                        'process_status'=>$process_status];
          }
          $this->General_model->update('cut',$detail,'id_cut',$cut_id);
          $sess_data = ['status'  => 'success',
                          'msg'  => 'Lot Status Updated' ];
          $this->session->set_userdata($sess_data);
          redirect('Manage');
        }else{
          $sess_data = ['status'  => 'error',
                        'msg'  => 'Something Is Worng' ];
          $this->session->set_userdata($sess_data); 
          redirect('Manage');
        }
      }else{
        $sess_data = ['status'  => 'error',
                        'msg'  => 'Something Is Worng' ];
        $this->session->set_userdata($sess_data); 
        redirect('Manage');
      }
    }
}