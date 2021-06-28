<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Home extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('General_datatable');
    }
	public function index()
	{
		$data['page_title']="Home";
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/controller/footer');
	}
}