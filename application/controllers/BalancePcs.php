<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  BalancePcs extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('BalancePcsModel');
        $this->General_model->auth_check();
        $this->General_model->auth_superadmin();
    }
    public function index()
    {
        $this->General_model->auth_check();
        $data['page_title']="Balance";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/balance/pcs',$data);
        $this->load->view('admin/controller/footer');
    }
    public function getLists(){
        $columns = array( 
                    0 =>'lot_no',
                    1 =>'party_name',
                    2 =>'cut_pcs',
                );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->BalancePcsModel->allposts_count();
        $totalFiltered = $totalData; 
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->BalancePcsModel->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 
            $posts =  $this->BalancePcsModel->posts_search($limit,$start,$search,$order,$dir);
            $totalFiltered = $this->BalancePcsModel->posts_search_count($search);
        }
        $data = array();
        if(!empty($posts))
        {
            $i=1;
            foreach ($posts as $post)
            {   
                $custm_data=$this->db->query("SELECT SUM(CASE WHEN sb_id=2 THEN t_pcs ELSE 0 END) as silicate_pcs , SUM(CASE WHEN sb_id=3 THEN t_pcs ELSE 0 END) as dholia_pcs, SUM(CASE WHEN sb_id=4 THEN t_pcs ELSE 0 END) as kanji_pcs FROM process where lot_no='".$post->lot_no."'")->row();
                $devide_pcs=$this->db->query("SELECT SUM(devide_pcs) as devide_pcs FROM `devide` WHERE lot_no='".$post->lot_no."'")->row();
                $printing_pcs=$this->db->query("SELECT SUM(t_pcs) as t_pcs  FROM `printing` WHERE lot_no='".$post->lot_no."'")->row();
                $ghadi_pcs=$this->db->query("SELECT SUM(t_pcs) as t_pcs  FROM `ghadi` WHERE lot_no='".$post->lot_no."'")->row();
                $emdevide_pcs=$this->db->query("SELECT SUM(t_pcs) as t_pcs  FROM `emdevide` WHERE lot_no='".$post->lot_no."'")->row();
                $embroidery_pcs=$this->db->query("SELECT SUM(t_pcs) as t_pcs  FROM `embroidery` WHERE lot_no='".$post->lot_no."'")->row();
                $packing_pcs=$this->db->query("SELECT SUM(t_pcs) as t_pcs  FROM `packing` WHERE lot_no='".$post->lot_no."'")->row();
                $nestedData['process_pcs']='<button type="button" class="btn btn-purple waves-effect waves-light btn-xs"> S - '.(($custm_data->silicate_pcs)?$custm_data->silicate_pcs:0).'</button> <br /> <button type="button" class="btn btn-purple waves-effect waves-light btn-xs"> D - '.(($custm_data->dholia_pcs)?$custm_data->dholia_pcs:0).'</button> <br /> <button type="button" class="btn btn-purple waves-effect waves-light btn-xs">  K - '.(($custm_data->kanji_pcs)?$custm_data->kanji_pcs:0).'</button> <br />';; 
                $nestedData['lot_no'] =LOT.$post->lot_no;
                $nestedData['cut_pcs'] =$post->cut_pcs;
                $nestedData['devide_pcs'] =(($devide_pcs->devide_pcs)?$devide_pcs->devide_pcs:0);
                $nestedData['party_name'] =ucwords($post->party_name);
                $nestedData['print_pcs']=(($printing_pcs->t_pcs)?$printing_pcs->t_pcs:0);
                $nestedData['ghadi_pcs']=(($ghadi_pcs->t_pcs)?$ghadi_pcs->t_pcs:0);
                $nestedData['emdevide_pcs']=(($emdevide_pcs->t_pcs)?$emdevide_pcs->t_pcs:0);
                $nestedData['embroidery_pcs']=(($embroidery_pcs->t_pcs)?$embroidery_pcs->t_pcs:0);
                $nestedData['packing_pcs']=(($packing_pcs->t_pcs)?$packing_pcs->t_pcs:0);
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
}