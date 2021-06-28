<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class General_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function get_all($table)
		{
			$q = $this->db->get($table);
			if($q->num_rows() > 0)
			{
				return $q->result();
			}
			return array();
		}
		public function get_row($table,$primaryfield,$id)
		{
			$this->db->where($primaryfield,$id);
			$q = $this->db->get($table);
			if($q->num_rows() > 0)
			{
				return $q->row();
			}
			return false;
		}
		public function get_data($table,$primaryfield,$fieldname,$id)
		{
			$this->db->select($fieldname);
			$this->db->where($primaryfield,$id);
			$q = $this->db->get($table);
			if($q->num_rows() > 0)
			{
				return $q->result();
			}
			return array();
		}
		public function add($table,$data)
		{
			return $this->db->insert($table,$data);
		}
		public function addid($table,$data)
		{
		    $this->db->insert($table, $data);
		    return $this->db->insert_id();
		}
		public function update($table,$data,$primaryfield,$id)
		{
			$this->db->where($primaryfield, $id);
			$q = $this->db->update($table,$data);
			return $q;
		}
		public function update_where($table,$data,$where)
		{
		    $this->db->where($where);
		    $q = $this->db->update($table, $data);
		    return $q;
		}
		public function delete($table,$primaryfield,$id)
		{
			$this->db->where($primaryfield,$id);
			$this->db->delete($table);
		}
		public function has_duplicate($value, $tabletocheck, $fieldtocheck)
		{
			$this->db->select($fieldtocheck);
			$this->db->where($fieldtocheck,$value);
			$result = $this->db->get($tabletocheck);
			if($result->num_rows() > 0) {
				return true;
			}
			else {
				return false;
			}
		}
        public function auth_check(){
		$CI =& get_instance();
		$user_id = $CI->session->userdata('auth_user_id');		
			if($user_id == '' && !isset($user_id)  && empty($user_id)){
				redirect(base_url('admin/login'));
			}
		}
		public function getIndianCurrency($number)
		{
			$decimal = round($number - ($no = floor($number)), 2) * 100;
			   $hundred = null;
			   $digits_length = strlen($no);
			   $i = 0;
			   $str = array();
			   $words = array(0 => '', 1 => 'one', 2 => 'two',
			       3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			       7 => 'seven', 8 => 'eight', 9 => 'nine',
			       10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			       13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			       16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			       19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			       40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			       70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
			   $digits = array('', 'hundred','thousand','lakh', 'crore');
			   while( $i < $digits_length ) {
			       $divider = ($i == 2) ? 10 : 100;
			       $number = floor($no % $divider);
			       $no = floor($no / $divider);
			       $i += $divider == 10 ? 1 : 2;
			       if ($number) {
			           $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			           $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			           $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			       } else $str[] = null;
			   }
			   $Rupees = implode('', array_reverse($str));
			   $paise = ($decimal > 0) ? " " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
			   return ucwords(($Rupees ? $Rupees : '') . $paise);
		}
	}	