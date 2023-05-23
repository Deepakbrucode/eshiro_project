<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	public $user_table = 'usermaster';
	public $register = 'clients';
	public function auth($nm,$pwd)
		{
		    $q1=$this->db->get_where('usermaster',array('username'=>$nm,'password'=>$pwd));
		    $newu = ($q1 != false && $q1->num_rows() > 0) ? $q1->row() : FALSE;
			if(($newu != FALSE)&&($newu->status == '1')){
				return $newu;
			}else if(($newu != FALSE)&&($newu->status == '0')){
				return 'deactivated';
			}else{
				return FALSE;
			}
		}
	public function insert($data)
	{
	$this->db->insert($this->user_table, $data);
	$insert_id = $this->db->insert_id();
	return $insert_id;
	}
	public function update($data, $where = array())
	{
		if (count($where) > 0)
		$this->db->where($where);
		return $this->db->update($this->user_table , $data);
 
	}

	public function DeleteClient($client_id)
	{
		$this->db->where('id', $client_id);
		return $this->db->delete($this->user_table);
	}
	
	public function getAdmin()
	  {
		  $this->db->select('*');
		  $this->db->from('usermaster');
		  $this->db->where('id','1');
		  $this->db->where('status','1');
		  $query = $this->db->get();   
		   if($query->num_rows() >0)
		   {
				   $row = $query->row_array();
				   return $row;
		   }                               
	  } 
	  public function getcli($client_id)
	  {
		  $this->db->select('*');
		  $this->db->from('usermaster');
		   $this->db->where('id',$client_id);
		  $this->db->where('status','1');
		  $query = $this->db->get();   
		   if($query->num_rows() >0)
		   {
				   $row = $query->row_array();
				   return $row;
		   }                               
	  } 
	  public function getClient($client_id)
	  {
		  $this->db->select('*');
		  $this->db->from('usermaster');
		  $this->db->where('id',$client_id);
		  //$this->db->where('clientapproval','1');
		  $query = $this->db->get();   
		   if($query->num_rows() >0)
		   {
				   $row = $query->row_array();
				   return $row;
		   }                               
	  } 
		public function sendEmail($adminname,$adminemail,$name,$emailid,$password)
		{ 
		$this->load->library('email');
		$config = array(
		'mailtype' => 'html',
		'charset'  => 'utf-8',
		'priority' => '1'
		);
		$this->email->initialize($config);
		$this->email->from($adminemail, $adminname);
		$this->email->to($emailid);
		$message = 'Welcome to '.$name.',<br><br>'."\r\n \r\n";
		$message .= 'your credentials'."\r\n \r\n";
		$message .= 'Username:'.$name."\r\n \r\n";
		$message .= 'Password:'.$password."\r\n \r\n";
		$this->email->message($message);
		$this->email->send();
		}
		
		public function checkEmail($email)
        {
               
           $this -> db -> select('*');
           $this -> db -> from('usermaster');
           $this -> db -> where('email',$email);
          $query = $this->db->get();
          ///echo $this->db->last_query();
          $result = $query->result_array();
          return $result;
         //echo '<pre>';print_r($result);echo'</pre>';exit;
        }
        public function checkVatNo($vatno)
        {
               
           $this -> db -> select('*');
           $this -> db -> from('usermaster');
           $this -> db -> where('vat_no',$vatno);
          $query = $this->db->get();
          ///echo $this->db->last_query();
          $result = $query->result_array();
          return $result;
         //echo '<pre>';print_r($result);echo'</pre>';exit;
        }
        public function checkEmailname($email,$name)
        {
           $this -> db -> select('*');
           $this -> db -> from('clients');
           $this -> db -> where('emailid',$email);
          $this->db->or_where('firm_name',$name);
           $query = $this -> db -> get();
           return $query->result_array();
        }
		public function clientauth($nm,$pwd)
		{
		//echo $pwd;
		//echo $nm;
		$this->db->select('*');
		$this->db->from('usermaster');
		$this->db->where('email', $nm);
		$this->db->where('password', $pwd);
		$this->db->where('status','1');
		$query_result = $this->db->get();
		$newu = ($query_result != false && $query_result->num_rows() > 0) ? $query_result->row() : FALSE;
		if(($newu != FALSE)&&($newu->status == '1')){
		return $newu;
		}else if(($newu != FALSE)&&($newu->status == '0')){
		return 'deactivated';
		}else{
		return FALSE;
		}
		}
		
		public function getDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->user_table);	
		if (is_array($param) && count($param)>0){
			$this->db->where($param);
			
		}else{
			//$this->db->where(array('status'=>1));
		}
		if(isset($option['like']) && is_array($option['like'])){
			$i = 0;
			foreach($option['like'] as $key => $val){
				$i++;
				if($i == 1)
				$this->db->like($key, $val);
			    else
				$this->db->or_like($key, $val);
			}
		}
		if(isset($option['where_in']) && is_array($option['where_in'])){
			foreach($option['where_in'] as $key => $val){
				$this->db->where_in($key,$val);
			}
		}
		if((isset($option['orderby']) && $option['orderby'] !='') && (isset($option['disporder']) && $option['disporder']!=''))
			$this->db->order_by($option['orderby'],$option['disporder']);
		else
			$this->db->order_by('status',"ASC");

		if(isset($option['groupby']) && $option['groupby'] !='') {
			$this->db->group_by($option['groupby']);
		}
		
		if((isset($option['limit']) && $option['limit'] !='') && (isset($option['offset']) && $option['offset'] !=''))
			$this->db->limit($option['limit'],$option['offset']);	
		$result = $this->db->get();
		
		if ($result != FALSE && $result->num_rows()>0){
			if ($column == ''){
				if(isset($option['toArray']) && $option['toArray'] == TRUE){
					 return $result = $result->result_array();}
					 else {	
				return $result = $result->result();	}		
			}else{
				if (strpos($column, ',') === FALSE)
				{
					$column = $this->getEndData($column, ".");
					return $result->row()->$column;
				}
				else
				{
					return $result->result();
				}
			}
		}
		return FALSE;
    }
    
	 
}
