<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	public $user_table = 'usermaster';
	public function auth($nm,$pwd)
		{
		    $q1=$this->db->get_where('usermaster',array('username'=>$nm,'password'=>MD5($pwd)));
		    $newu = ($q1 != false && $q1->num_rows() > 0) ? $q1->row() : FALSE;
			if(($newu != FALSE)&&($newu->status == '1')){
				return $newu;
			}else if(($newu != FALSE)&&($newu->status == '0')){
				return 'deactivated';
			}else{
				return FALSE;
			}
		}
	
}