<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payments_model extends CI_Model{

	public $payment_table = 'payment_cfrb';
	public $file_table = 'file';
	public $client_table = 'clients';
	public function InsertPayment($data = array())
	{

		$this->db->insert($this->payment_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function UpdatePayment($data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($this->payment_table, $data);
	}
	public function DeletePayment($data_id)
	{
		$this->db->where('payment_id', $data_id);
		 $this->db->delete($this->payment_table);
		//$this->db->insert($this->payment_table, $data);
		//return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function getPaymentDetails($param=array(), $column='', $option=array())
	{		
		if ($column == ''){
			$this->db->select('*');		
		}else{
			
			$this->db->select($column);
		}
		$this->db->from($this->payment_table);	
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
    function getPaymentDetails_cf($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->payment_table.'.*, '.$this->file_table.'.file_number, '.$this->file_table.'.file_name, '.$this->client_table.'.firm_name');
		 $this->db->from($this->payment_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		if((isset($option['orderby']) && $option['orderby'] !='') && (isset($option['disporder']) && $option['disporder']!=''))
			$this->db->order_by($option['orderby'],$option['disporder']);
		else
			$this->db->order_by('status',"ASC");
		
		 $this->db->join($this->file_table,$this->file_table.'.file_id='.$this->payment_table.'.file_id', 'left');
		 $this->db->join($this->client_table,$this->client_table.'.client_id='.$this->payment_table.'.client_id', 'left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();exit();
    	 return $query->result();
    }
    function getPaymentDetails_file($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->payment_table.'.*, '.$this->file_table.'.file_number');
		 $this->db->from($this->payment_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		if((isset($option['orderby']) && $option['orderby'] !='') && (isset($option['disporder']) && $option['disporder']!=''))
			$this->db->order_by($option['orderby'],$option['disporder']);
		
		 $this->db->join($this->file_table,$this->file_table.'.file_id='.$this->payment_table.'.file_id', 'left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
	
}