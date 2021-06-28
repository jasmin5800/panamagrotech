<?php
class CutManageModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t2.party_name,t3.item_name'); 
        $this->db->join('party as t2', 't1.party_id = t2.party_id', 'left');
        $this->db->join('item as t3', 't1.item_id = t3.item_id', 'left');
        $query = $this->db->get('cut as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t2.party_name,t3.item_name'); 
        $this->db->join('party as t2', 't1.party_id = t2.party_id', 'left');
        $this->db->join('item as t3', 't1.item_id = t3.item_id', 'left');
       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('cut as t1');
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
        $query=$this->db->select('t1.*,t2.party_name,t3.item_name')->from('cut as t1')
                ->join('party as t2', 't1.party_id = t2.party_id', 'left')
                ->join('item as t3', 't1.item_id = t3.item_id', 'left')
                ->group_start()
                        ->like('t1.challan_no',$search)
                        ->or_like('t1.name',$search)
                        ->or_like('t1.lot_no',$search)
                        ->or_like('t1.date',$search)
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
        $query=$this->db->select('t1.*,t2.party_name,t3.item_name')->from('cut as t1')
                ->join('party as t2', 't1.party_id = t2.party_id', 'left')
                ->join('item as t3', 't1.item_id = t3.item_id', 'left')
                ->group_start()
                        ->like('t1.challan_no',$search)
                        ->or_like('t1.name',$search)
                        ->or_like('t1.lot_no',$search)
                        ->or_like('t1.date',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    }
}