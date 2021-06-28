<?php
class UserModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t2.name as role_name');
        $this->db->join('role as t2', 't1.role_id = t2.role_id', 'left');
        $this->db->where('t1.status','1');  
        $query = $this->db->get('master_admin as t1');
        return $query->num_rows();  
    }
    function allposts($limit,$start,$col,$dir)
    {   
       $this->db->select('t1.*,t2.name as role_name');
       $this->db->join('role as t2', 't1.role_id = t2.role_id', 'left');
       $this->db->where('t1.status','1'); 
       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('master_admin as t1');
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
        $query=$this->db->select('t1.*,t2.name as role_name')->from('master_admin as t1')
                ->join('role as t2', 't1.role_id = t2.role_id', 'left')
                ->where('t1.status','1')
                ->group_start()
                        ->like('t1.username',$search)
                        ->or_like('t2.name',$search)
                        ->or_like('t1.phone',$search)
                        ->or_like('t1.email',$search)
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
        $query=$this->db->select('t1.*,t2.name as role_name')->from('master_admin as t1')
                ->join('role as t2', 't1.role_id = t2.role_id', 'left')
                ->where('t1.status','1')
                ->group_start()
                        ->like('t1.username',$search)
                        ->or_like('t2.name',$search)
                        ->or_like('t1.phone',$search)
                        ->or_like('t1.email',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    } 
}