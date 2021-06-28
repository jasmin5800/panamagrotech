<?php
class BalanceModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $query = $this->db->get('balance');
        return $query->num_rows();  
    }
    function allposts($limit,$start,$col,$dir)
    {   
       $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('balance');
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
        $query=$this->db->select('*')->from('balance')
                ->group_start()
                        ->like('lot_no',$search)
                        ->or_like('cut_meter',$search)
                        ->or_like('cut_pcs',$search)
                        ->or_like('print_cloth',$search)
                        ->or_like('silicate_cloth',$search)
                        ->or_like('dholai_cloth',$search)
                        ->or_like('kanji_cloth',$search)
                        ->or_like('ghadi_cloth',$search)
                        ->or_like('embroidery_cloth',$search)
                        ->or_like('packing_cloth',$search)
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
        $query=$this->db->select('*')->from('balance')
                ->group_start()
                        ->like('lot_no',$search)
                        ->or_like('cut_meter',$search)
                        ->or_like('cut_pcs',$search)
                        ->or_like('print_cloth',$search)
                        ->or_like('silicate_cloth',$search)
                        ->or_like('dholai_cloth',$search)
                        ->or_like('kanji_cloth',$search)
                        ->or_like('ghadi_cloth',$search)
                        ->or_like('embroidery_cloth',$search)
                        ->or_like('packing_cloth',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    } 
}