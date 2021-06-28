<?php
class PrintingModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t5.username as user_name');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->get('printing as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t5.username as user_name'); 
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('printing as t1');
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
    function posts_search($limit,$start,$search,$col,$dir)
    {   
        $query=$this->db->select('t1.*,t5.username as user_name')->from('printing as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.t_missprint',$search)
                        ->or_like('t1.t_pcs',$search)
                        ->or_like('t1.cloth_value',$search)
                        ->or_like('t1.g_total',$search)
                        ->or_like('t1.print_val',$search)
                ->group_end()
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get();
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count($search)
    {
        $query=$this->db->select('t1.*,t5.username as user_name')->from('printing as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.t_missprint',$search)
                        ->or_like('t1.t_pcs',$search)
                        ->or_like('t1.cloth_value',$search)
                        ->or_like('t1.g_total',$search)
                        ->or_like('t1.print_val',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    }
    public function challan_no()
    {
        $query=$this->db->select('challan_no')->from('printing')
                ->order_by('printing_id ',"DESC")
                ->limit('1')
                ->get();
        $count=$query->num_rows();
        if ($count > 0)
        {
            $result=$query->row(); 
            $result=['challan_no'=>$result->challan_no+1]; 
            return $result;  
        }
        else
        {
            $result=['challan_no'=>1];
            return $result; 
        } 
    }
    public function unique_design()
    {
        $slug = $this->random_design(18);
        $query= $this->db->select('unique_design')
                    ->from('priting_lot')
                    ->where('unique_design',$slug)
                    ->get();
        $count=$query->num_rows();
        if ($count > 0 )
        {
            $this->unique_design();
        }
        else
        {
            return $slug;
        } 
    }
    protected function random_design($length) 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $string = []; 
        $alpha_length = strlen($alphabet) - 1; 
        for ($i = 0; $i < $length; $i++) 
        {
         $n = rand(0, $alpha_length);
         $string[] = $alphabet[$n];
        }
            return implode($string); 
    }
}