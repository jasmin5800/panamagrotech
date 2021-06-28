<?php
class StockModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t2.party_name,t3.item_name,t4.transport_name,t5.username as user_name'); 
        $this->db->join('party as t2', 't1.party_id = t2.party_id', 'left');
        $this->db->join('item as t3', 't1.item_id = t3.item_id', 'left');
        $this->db->join('transport as t4', 't1.transport_id = t4.transport_id', 'left');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left');
        $query = $this->db->get('stock as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t2.party_name,t3.item_name,t4.transport_name,t5.username as user_name'); 
        $this->db->join('party as t2', 't1.party_id = t2.party_id', 'left');
        $this->db->join('item as t3', 't1.item_id = t3.item_id', 'left');
        $this->db->join('transport as t4', 't1.transport_id = t4.transport_id', 'left');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left');

       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('stock as t1');
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
        $query=$this->db->select('t1.*,t2.party_name,t3.item_name,t4.transport_name,t5.username as user_name')->from('stock as t1')
                ->join('party as t2', 't1.party_id = t2.party_id', 'left')
                ->join('item as t3', 't1.item_id = t3.item_id', 'left')
                ->join('transport as t4', 't1.transport_id = t4.transport_id', 'left')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t2.party_name',$search)
                        ->or_like('t3.item_name',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t4.transport_name',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.marchant_no',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.total_meter',$search)
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
        $query=$this->db->select('t1.*,t2.party_name,t3.item_name,t4.transport_name,t5.username as user_name')->from('stock as t1')
                ->join('party as t2', 't1.party_id = t2.party_id', 'left')
                ->join('item as t3', 't1.item_id = t3.item_id', 'left')
                ->join('transport as t4', 't1.transport_id = t4.transport_id', 'left')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t2.party_name',$search)
                        ->or_like('t3.item_name',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t4.transport_name',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.marchant_no',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.total_meter',$search)
                        ->or_like('t1.g_total',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    } 
}