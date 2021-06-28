<?php
class BalancePcsModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.lot_no,t1.total_pcs as cut_pcs,t3.srt_name as party_name');
        $this->db->join('party as t3', 't1.party_id=t3.party_id', 'left');   
        $query = $this->db->get('cut as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.lot_no,t1.total_pcs as cut_pcs,t3.srt_name as party_name'); 
        $this->db->join('party as t3', 't1.party_id=t3.party_id', 'left');   
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
        $query=$this->db->select('t1.lot_no,t1.total_pcs as cut_pcs,t3.srt_name as party_name')->from('cut as t1')
                ->join('party as t3', 't1.party_id=t3.party_id', 'left')
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t1.total_pcs',$search)
                        ->or_like('t3.srt_name',$search)
                        ->or_like('t3.party_name',$search)
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
        $query=$this->db->select('t1.lot_no,t1.total_pcs as cut_pcs,t3.srt_name as party_name')->from('cut as t1')
                ->join('party as t3', 't1.party_id=t3.party_id', 'left')  
                ->group_start()
                        ->like('t1.lot_no',$search)
                        ->or_like('t1.total_pcs',$search)
                        ->or_like('t3.srt_name',$search)
                        ->or_like('t3.party_name',$search)
                ->group_end() 
                ->get();
        return $query->num_rows();
    }
}