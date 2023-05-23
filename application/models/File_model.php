<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class File_model extends CI_Model{

	public $file_table = 'file';
	public $file_opening_table = 'file_opening_balance';
	public $client_table = 'clients';
	public $receipt_table = 'receipt_drc';
	//public function InsertClient($firm_name,$directors,$registered_address,$physical_address,$postal_address,$bank_accounts)
	public function InsertFile($data = array())
	{

		$this->db->insert($this->file_table, $data);
		$insert_id = $this->db->insert_id();
		return ($this->db->affected_rows() != 1) ? false : $insert_id;
	}
	public function UpdateFile($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->file_table, $data);
	}
	
	public function getFileDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->file_table);	
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

    function getFileDetails_client($param=array(), $column='', $option=array())
    {
    	 $this->db->select('file.*, '.$this->client_table.'.firm_name');
		 $this->db->from($this->file_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		 $this->db->join($this->client_table,$this->file_table.'.client_id='.$this->client_table.'.client_id');
	     $query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    function getFileopenDetails_file($param=array(), $column='', $option=array())
    {
    	 $this->db->select('file.*, '.$this->file_opening_table.'.financial_start, '.$this->file_opening_table.'.financial_end, '.$this->file_opening_table.'.opening_balance');
		 $this->db->from($this->file_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		 $this->db->join($this->file_opening_table,$this->file_table.'.file_id='.$this->file_opening_table.'.file_id', 'left');
		 $this->db->order_by($this->file_opening_table.'.financial_end', "desc");
		 if((isset($option['limit']) && $option['limit'] !='') && (isset($option['offset']) && $option['offset'] !=''))
			$this->db->limit($option['limit'],$option['offset']);	
		 //$this->db->limit(1);
	     $query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function InsertFileOpen($data = array())
	{

		$this->db->insert($this->file_opening_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function UpdateFileOpen($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->file_opening_table, $data);
	}
    public function getFileOpeningDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->file_opening_table);	
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
