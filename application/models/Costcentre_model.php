<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Costcentre_model extends CI_Model{

	public $costcentre_table = 'costcentre';
	//public $user_table = 'usermaster';
	public function Insert($data = array())
	{

		$this->db->insert($this->costcentre_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function Update($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->costcentre_table, $data);
	}
	public function Delete($where = array())
	{
			$this->db->where($where);
            $this->db->delete($this->costcentre_table); 
	}

	public function getDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->costcentre_table);	
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
    public function getDetailsCommon($table_name='',$param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($table_name);	
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
	public function Insert_common($table_name='',$data = array())
	{

		$this->db->insert($table_name, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function Update_common($table_name='',$data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($table_name, $data);
	}
	public function Delete_common($table_name='',$where = array())
	{
			$this->db->where($where);
            $this->db->delete($table_name); 
	}
}
