<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Genral_datatable');
        $this->load->model('General_model');
        $this->load->database();
        $this->load->library('session');
        $this->General_model->auth_master();
    }
    public function index()
    {
        $data['page_title']="Category";
        $data['method']="add";
        $data['frm_id']="Add_frm";
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/setting/category',$data);
        $this->load->view('admin/controller/footer');
    }
    function getLists(){
        $table='category';
        $order_column_array=array('id', 'name','status');
        $search_order= array('name');
        $order_by_array= array('id' => 'ASC');
        $data = $row = array();
        $Master_Data = $this->Genral_datatable->getRows($_POST,$table,$order_column_array,$search_order,$order_by_array);
        $i = $_POST['start'];
        foreach($Master_Data as $m_data){
            $i++;
            $status = ($m_data->status == 1)?'Active':'Inactive';
            $data[] =   [$i,
                        $m_data->name, 
                        $status,
                        '<a href="'.base_url('Category/get_editfrm/').$m_data->id.'"><button type="button" class="btn btn-custom waves-effect waves-light"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>'
                        ];
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Genral_datatable->countAll($table),
            "recordsFiltered" => $this->Genral_datatable->countFiltered($_POST,$table,$order_column_array,$search_order,$order_by_array),
            "data" => $data,
        );
        // Output to JSON format
        echo json_encode($output);
    }
    public function create()
    {
        $this->General_model->auth_check();
        $name=ucfirst($this->input->post("name"));
        if(isset($name) && !empty($name)){
            $count=$this->General_model-> has_duplicate($name,'category','name');
            if($count>0){
                $data['status']="error";
                $data['msg']="Category Already Exist" ;
            }else{
                $category=['name '=>$name,
                            'status'=>1,
                            'created_at'=>date("Y-m-d h:i:s")];
            $detail=$this->db->insert('category',$category);
            $data['status']="success";
            $data['msg']="Category Added" ;   
            }
        }else{
            $data['status']="error";
            $data['msg']="Something is Worng";              
        }
        echo json_encode($data);
    }
    public function get_editfrm($id)
    {
        $this->General_model->auth_check();
        $data['page_title']="Category";
        $data['method']="edit";
        $data['frm_id']="Edit_frm";
        $data['category']=$this->General_model->get_row('category','id',$id);        
        $this->load->view('admin/controller/header');
        $this->load->view('admin/controller/sidebar');
        $this->load->view('admin/setting/category',$data);
        $this->load->view('admin/controller/footer');
    }
    public function update()
    {
        $this->General_model->auth_check();
        $name=ucfirst($this->input->post("name"));
        $status=$this->input->post("status");
        $id=$this->input->post("id");
        if(isset($name) && !empty($name) &&  isset($id) && !empty($id)){
            $count=$this->General_model-> has_duplicate_query("select name  from category where name ='".$name."' and id  !='".$id."'");
                if($count>0){
                    $data['status']="error";
                    $data['msg']="Category Already Exist"; 
                }else{
                    $category=['name '=>$name,                    
                            'status'=>$status
                        ];
                    $this->General_model->update('category',$category,'id',$id);
                    $data['status']="success";
                    $data['msg']="Category Updated";
                }
            }else{
                $data['status']="error";
                $data['msg']="Something is Worng";              
            }
            echo json_encode($data);
    }
}