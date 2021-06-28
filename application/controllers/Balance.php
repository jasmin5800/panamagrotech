<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Balance extends CI_Controller {
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
        $data['page_title']="Balance";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/balance/index',$data);
        $this->load->view('admin/controller/footer');
    }
    public function getLists(){
        $columns = array( 
                    0 =>'lot_no', 
                    1=> 'cut_meter',
                    2 =>'cut_pcs',
                    3=> 'print_cloth',
                    4=> 'silicate_cloth',
                    5 =>'dholai_cloth',
                    6 =>'kanji_cloth',
                    7=> 'ghadi_cloth',
                    8=> 'embroidery_cloth',
                    9=> 'packing_cloth'
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->BalanceModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->BalanceModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->BalanceModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->BalanceModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            $i=1;
            foreach ($posts as $post)
            {   
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['cut_meter'] =number_format($post->cut_meter,2);
                $nestedData['cut_pcs'] =number_format($post->cut_pcs,2);
                $nestedData['print_cloth'] =number_format($post->print_cloth,2);
                $nestedData['silicate_cloth'] =number_format($post->silicate_cloth,2);
                $nestedData['dholai_cloth'] = number_format($post->dholai_cloth,2);
                $nestedData['kanji_cloth'] =number_format($post->kanji_cloth,2);
                $nestedData['ghadi_cloth'] = number_format($post->ghadi_cloth,2);
                $nestedData['embroidery_cloth'] =number_format($post->embroidery_cloth,2);
                $nestedData['packing_cloth'] = number_format($post->packing_cloth,2);
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
    public function delete($id)
    {
        $this->General_model->auth_check();
        if(isset($id) && !empty($id)){
            $this->General_model->delete('balance','lot_no',$id);
            $data['status']="success";
            $data['msg']="Balance Row Deleted";
        }else{
            $data['status']="error";
            $data['msg']="Something is Worng";              
        }
        echo json_encode($data);
    }
}