<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class  Dashbord extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('General_model');
        $this->load->model('Genral_datatable');
        $this->General_model->auth_check();
    }
	public function index()
	{
		$data['page_title']="Dashbord";
		$data['lot_count']=$this->countlot();
		$data['user_count']=$this->countuser();
		$data['user_party']=$this->countparty();
		$data['user_patla']=$this->countpatla();
		$data['user_item']=$this->countitem();
		$data['user_transport']=$this->counttransport();
		$data['user_emuser']=$this->countemuser();
		$this->load->view('admin/controller/header');
		$this->load->view('admin/controller/sidebar');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/controller/footer');
	}
	public function countlot(){
	$query = $this->db->query("SELECT count(id_cut) AS lot_count FROM cut")->row();
	  	return $query->lot_count;
	}
	public function countuser(){
	$query = $this->db->query("SELECT count(id_master) AS user_count FROM master_admin WHERE status='1'")->row();
	  	return $query->user_count;
	}
	public function countparty(){
	$query = $this->db->query("SELECT count(party_id) AS party_count FROM party")->row();
	  	return $query->party_count;
	}
	public function countpatla(){
	$query = $this->db->query("SELECT count(patla_id) AS patla_count FROM patla WHERE is_delete='1' ")->row();
	  	return $query->patla_count;
	}
	public function countitem(){
	$query = $this->db->query("SELECT count(item_id) AS item_count FROM item")->row();
	  	return $query->item_count;
	}
	public function counttransport(){
	$query = $this->db->query("SELECT count(transport_id) AS transport_count FROM transport")->row();
	  	return $query->transport_count;
	}
	public function countemuser(){
	$query = $this->db->query("SELECT count(emuser_id) AS emuser_count FROM em_user")->row();
	  	return $query->emuser_count;
	}
}