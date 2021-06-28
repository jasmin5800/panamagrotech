<?php
class PlateModel extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t5.username as user_name');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->get('plate as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t5.username as user_name'); 
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('plate as t1');
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
        $query=$this->db->select('t1.*,t5.username as user_name')->from('plate as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.design',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.remark',$search)
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
        $query=$this->db->select('t1.*,t5.username as user_name')->from('plate as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.design',$search)
                        ->or_like('t5.username',$search)
                        ->or_like('t1.date',$search)
                        ->or_like('t1.challan_no',$search)
                        ->or_like('t1.remark',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    }
    public function challan_no()
    {
        $query=$this->db->select('challan_no')->from('plate')
                ->order_by('id ',"DESC")
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
    private function random_design($length) 
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
    public function garmConvert($string)
    {
        $data=$string;
        if(strpos($data,"|||")){
            $custom=$this->customInt($data);
            $data=str_replace("|||"," ",$data);
            $data=(int)$data;
            $data=$data+$custom;
        }elseif(strpos($data,"||")){
            $custom=$this->customInt($data);
            $data=str_replace("||"," ",$data);
            $data=(int)$data;
            $data=$data+$custom;
        }elseif(strpos($data,"|")){
            $custom=$this->customInt($data);
            $data=str_replace("|"," ",$data);
            $data=(int)$data;
            $data=$data+$custom;
        }else{
            $data=$data;
        }
        return $data;
    }
    private function customInt($string)
    {
        $people=str_split($string);
        foreach ($people as $key => $value) {
            if ($value=="|")
              {
                 $ff[]=0.25;
              }
        }
        $total=array_sum($ff);
        return $total;
    }
    public function customOrsign($string)
    {
        $floatnumber=$string;
        $intnumber=(int)$floatnumber;
        $pera=$floatnumber-$intnumber;
        switch ($pera) {
            case 0.25:
                $data=str_replace(".25","|",$floatnumber);
                break;
            case 0.5:
                $data=str_replace(".5","||",$floatnumber);
                break;
            case 0.75:
                $data=str_replace(".75","|||",$floatnumber);
                break;
            default:
                $data=$floatnumber;
                break;
        }
        return $data;
    }
}