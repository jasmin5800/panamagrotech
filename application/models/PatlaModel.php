<?php
class patlaModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->where('is_delete','1');
        $query = $this->db->get('patla');
        return $query->num_rows();  
    }
    function allposts($limit,$start,$col,$dir)
    {   
       $this->db->where('is_delete','1');
       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('patla');
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
        $query=$this->db->select('*')->from('patla')
                ->like('patla_name',$search)
                ->where('is_delete', '1')
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
        $query=$this->db->select('*')->from('patla')
                ->like('patla_name',$search)
                ->where('is_delete', '1')
                ->get();
        return $query->num_rows();
    } 
}