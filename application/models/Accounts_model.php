<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model{

	public $client_table = 'clients';
	//public function InsertClient($firm_name,$directors,$registered_address,$physical_address,$postal_address,$bank_accounts)
	public function InsertClient($data = array())
	{

		$this->db->insert($this->client_table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
}