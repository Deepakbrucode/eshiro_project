<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Receipts_model extends CI_Model{

	public $file_table = 'file';
	public $client_table = 'clients';
	public $receipt_table = 'receipt_drc';
	public $openbal_table = 'cashbook_opening_balance';
	//public function InsertClient($firm_name,$directors,$registered_address,$physical_address,$postal_address,$bank_accounts)
	/*public function InsertFile($data = array())
	{

		$this->db->insert($this->file_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
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
    }*/


      function get_receipt_details()
    {
       
        $this->db->from('file');
        $query = $this->db->get();
        return $query->result();
    }

  /*  function getFileDetails_client($param=array(), $column='', $option=array())
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
    }*/
    public function InsertReceipts($data = array())
	{

		$this->db->insert($this->receipt_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function UpdateReceipt($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->receipt_table, $data);
	}
	public function DeleteReceipt($data_id)
	{
		$this->db->where('receipt_id', $data_id);
		 $this->db->delete($this->receipt_table);
		//$this->db->insert($this->payment_table, $data);
		//return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function getReceiptsDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->receipt_table);	
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
					$column = $this->getEndData($column);
					$column = trim($column);
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
	function getReceiptsDetails_cf($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->receipt_table.'.*, '.$this->file_table.'.file_number,'.$this->file_table.'.file_name, '.$this->client_table.'.firm_name');
		 $this->db->from($this->receipt_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		if((isset($option['orderby']) && $option['orderby'] !='') && (isset($option['disporder']) && $option['disporder']!=''))
			$this->db->order_by($option['orderby'],$option['disporder']);
		else
			$this->db->order_by('status',"ASC");
		 $this->db->join($this->file_table,$this->file_table.'.file_id='.$this->receipt_table.'.file_id', 'left');
		 $this->db->join($this->client_table,$this->client_table.'.client_id='.$this->receipt_table.'.client_id', 'left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();exit();
    	 return $query->result();
    }
    function getReceiptsDetails_file($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->receipt_table.'.*, '.$this->file_table.'.file_number');
		 $this->db->from($this->receipt_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		 $this->db->join($this->file_table,$this->file_table.'.file_id='.$this->receipt_table.'.file_id','left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function InsertOpeningBalance($data = array())
	{

		$this->db->insert($this->openbal_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function UpdateOpeningBalance($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->openbal_table, $data);
	}

	public function getOpenbalanceDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->openbal_table);	
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

	function getOpenBalDetails_cf($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->openbal_table.'.*, '.$this->file_table.'.file_number,'.$this->file_table.'.file_name, '.$this->client_table.'.firm_name');
		 $this->db->from($this->openbal_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		if((isset($option['orderby']) && $option['orderby'] !='') && (isset($option['disporder']) && $option['disporder']!=''))
			$this->db->order_by($option['orderby'],$option['disporder']);
		else
			$this->db->order_by('status',"ASC");

		 $this->db->join($this->file_table,$this->file_table.'.file_id='.$this->openbal_table.'.file_id', 'left');
		 $this->db->join($this->client_table,$this->client_table.'.client_id='.$this->openbal_table.'.client_id', 'left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();exit();
    	 return $query->result();
    }
    private function getEndData($data="", $identifier=""){
     $identifier = (strpos($data, '.') === TRUE) ? '.' : 'as';       
	 return ($data != "" && $identifier != "") ? trim(end((explode($identifier, $data)))) : FALSE;
    }

	
}