<?php
class EmDevideModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t2.name as process_name,t5.username as user_name');
        $this->db->join('sub_process as t2', 't1.sb_id = t2.id_sub_process', 'left');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left');   
        $query = $this->db->get('emdevide as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t2.name as process_name,t5.username as user_name'); 
        $this->db->join('sub_process as t2', 't1.sb_id = t2.id_sub_process', 'left');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left');   
        $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('emdevide as t1');

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
        $query=$this->db->select('t1.*,t2.name as process_name,t5.username as user_name')->from('emdevide as t1')
                ->join('sub_process as t2', 't1.sb_id = t2.id_sub_process', 'left')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t1.name',$search)
                        ->or_like('t2.name',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.address',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.vahicle',$search)
                        ->or_like('t1.vahicle_no',$search)
                        ->or_like('t1.t_design',$search)
                        ->or_like('t1.t_pcs',$search)
                        ->or_like('t1.cloth_value',$search)
                        ->or_like('t1.emdevide_value',$search)
                        ->or_like('t1.g_total',$search)
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
        $query=$this->db->select('t1.*,t2.name as process_name,t5.username as user_name')->from('emdevide as t1')
                ->join('sub_process as t2', 't1.sb_id = t2.id_sub_process', 'left')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t1.name',$search)
                        ->or_like('t2.name',$search)
                        ->or_like('t1.address',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.vahicle',$search)
                        ->or_like('t1.vahicle_no',$search)
                        ->or_like('t1.t_design',$search)
                        ->or_like('t1.t_pcs',$search)
                        ->or_like('t1.cloth_value',$search)
                        ->or_like('t1.emdevide_value',$search)
                        ->or_like('t1.g_total',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    }
    public function challan_no()
    {
        $query=$this->db->select('challan_no')->from('emdevide')
                ->order_by('emdevide_id',"DESC")
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
}