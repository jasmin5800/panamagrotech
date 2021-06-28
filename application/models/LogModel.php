<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LogModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function loginlog()
    {   
        $user_id=$_SESSION['auth_user_id'];
        $data=['user_id'=>$user_id,
                'is_login'=>'1',
                'is_logout'=>NULL,
                'description'=>'Login successful',
                'created_at'=>date("Y-m-d h:i:s")];
        return $this->db->insert('log_acvity',$data);
    }
    function logoutlog()
    {   
        $user_id=$_SESSION['auth_user_id'];
        $data=['user_id'=>$user_id,
                'is_login'=>NULL,
                'is_logout'=>'1',
                'description'=>'Logout successful',
                'created_at'=>date("Y-m-d h:i:s")];
        return $this->db->insert('log_acvity',$data);
    }
    function simplelog($msg)
    {   
        $user_id=$_SESSION['auth_user_id'];
        $data=['user_id'=>$user_id,
                'is_login'=>NULL,
                'is_logout'=>NULL,
                'description'=>$msg,
                'created_at'=>date("Y-m-d h:i:s")];
        return $this->db->insert('log_acvity',$data);
    }
    function allposts_count()
    {   
        $this->db->select('t1.*,t5.username as user_name');
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->get('log_acvity as t1');
        return $query->num_rows();
    }
    function allposts($limit,$start,$col,$dir)
    {   
        $this->db->select('t1.*,t5.username as user_name'); 
        $this->db->join('master_admin as t5', 't1.user_id = t5.id_master', 'left'); 
        $query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('log_acvity as t1');
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
        $query=$this->db->select('t1.*,t5.username as user_name')->from('log_acvity as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.description',$search)
                        ->or_like('t5.username',$search)
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
        $query=$this->db->select('t1.*,t5.username as user_name')->from('log_acvity as t1')
                ->join('master_admin as t5', 't1.user_id = t5.id_master', 'left')
                ->group_start()
                        ->like('t1.description',$search)
                        ->or_like('t5.username',$search)
                ->group_end()
                ->get();
        return $query->num_rows();
    }
}