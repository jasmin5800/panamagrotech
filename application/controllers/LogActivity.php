<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  LogActivity extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('BalanceModel');
        $this->load->model('LogModel');
        $this->General_model->auth_check();
        $this->General_model->auth_superadmin();
    }
    public function index()
    {
        $this->General_model->auth_check();
        $data['page_title']="Log Acvity";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/log/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function getLists(){
        $columns = array( 
                    0 =>'log_id', 
                    1 =>'user_name', 
                    2=> 'is_login',
                    3 =>'is_logout',
                    4=> 'created_at',
                    5=> 'description',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->LogModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->LogModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->LogModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->LogModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            $i=1;
            foreach ($posts as $post)
            {  
                $nestedData['index_no'] =$i; 
                $nestedData['user_name'] =strtoupper($post->user_name);
                $nestedData['is_login'] =((isset($post->is_login) && !empty($post->is_login))?"Login":'-');
                $nestedData['is_logout'] =((isset($post->is_logout) && !empty($post->is_logout))?"Logout":'-');
                $nestedData['created_at'] =date('d/m/Y h:i:s',strtotime($post->created_at));
                $nestedData['description'] =ucwords($post->description);
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
    
    public function dbbackup()
    {
        $this->load->dbutil();
        $prefs = array(     
            'format'      => 'zip',             
            'filename'    => 'my_db_backup.sql'
            );
        $backup =& $this->dbutil->backup($prefs); 
        $db_name = 'rbtextile-'. date("Y-m-d-H-i-s") .'.zip';
        $msg="DB backup created ".$db_name;
        $this->LogModel->simplelog($msg);
        $save ='assets/db/'.$db_name;
        $this->load->helper('file');
        write_file($save, $backup); 
        $this->load->helper('download');
        force_download($db_name, $backup);
    }
    public function clear_log()
    {
        $msg="clear log =<".date('d/m/Y');
        $this->LogModel->simplelog($msg);
        $clear_date=date('Y-m-d',strtotime('-3days'));
        $this->db->delete('log_acvity', array('created_at' => $clear_date)); 
        $sess_data = ['status'  => 'success',
                        'msg'  => 'Only 3 Days Acvity Not Deleted' ];
        $this->session->set_userdata($sess_data);
        redirect('LogActivity');
    }
}