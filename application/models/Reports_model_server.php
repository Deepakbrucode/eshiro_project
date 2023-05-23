<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model{

	public $file_table = 'file';
	public $client_table = 'clients';
	public $receipt_table = 'receipt_drc';
	public $payment_table = 'payment_cfrb';
	public $openbal_table = 'cashbook_opening_balance';
	//public function InsertClient($firm_name,$directors,$registered_address,$physical_address,$postal_address,$bank_accounts)
	function getClientDetails_file($param=array(), $column='', $option=array())
    {
    	 $this->db->select($this->file_table.'.file_number, '.$this->file_table.'.file_id, '.$this->file_table.'.file_name, '.$this->client_table.'.firm_name, '.$this->client_table.'.client_id, ');
		 $this->db->from($this->client_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}
		 $this->db->join($this->file_table,$this->file_table.'.client_id='.$this->client_table.'.client_id','left');
	     $query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    function get_CashMonthYear($client_id)
    {
    	 /*$this->db->select($this->file_table.'.file_number, '.$this->file_table.'.file_id, '.$this->client_table.'.firm_name, '.$this->client_table.'.client_id, ');
		 $this->db->from($this->client_table);
		 if (is_array($param) && count($param)>0){
			$this->db->where($param);
		}*/
		 //$this->db->join($this->file_table,$this->file_table.'.client_id='.$this->client_table.'.client_id','left');
		 $SQL = "SELECT cash_month,cash_month_name, cash_year FROM (SELECT MONTH(payment_date) as cash_month,MONTHNAME(payment_date) as cash_month_name,YEAR(payment_date) as cash_year FROM ".$this->payment_table." as t1 where t1.client_id='".$client_id."' GROUP BY cash_month,cash_month_name, cash_year UNION ALL SELECT MONTH(receipt_date) as cash_month,MONTHNAME(receipt_date) as cash_month_name,YEAR(receipt_date) as cash_year FROM ".$this->receipt_table." as t2 where t2.client_id='".$client_id."' GROUP BY cash_month,cash_month_name,cash_year ) as t3 GROUP BY cash_month,cash_month_name, cash_year order by cash_month,cash_year desc";
		 $query = $this->db->query($SQL);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    function getCashReceiptsDetails($month,$year,$client_id)
    {

		 $SQL = "SELECT * FROM ".$this->receipt_table." as r left join clients as c on c.client_id=r.client_id left join file as f on f.file_id=r.file_id where r.client_id='".$client_id."' and month(r.receipt_date)='".$month."' and year(r.receipt_date)='".$year."'";
		 $query = $this->db->query($SQL);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();exit();
    	 return $query->result();
    }
    function getCashPaymentDetails($month,$year,$client_id)
    {

		 $SQL = "SELECT * FROM ".$this->payment_table." as p left join clients as c on c.client_id=p.client_id left join file as f on f.file_id=p.file_id where p.client_id='".$client_id."' and month(p.payment_date)='".$month."' and year(p.payment_date)='".$year."'";
		 $query = $this->db->query($SQL);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    function getCashOpenbalDetails($month,$year,$client_id)
    {

		 $SQL = "SELECT * FROM ".$this->openbal_table."  where client_id='".$client_id."' and month(openbal_date)='".$month."' and year(openbal_date)='".$year."'";
		 $query = $this->db->query($SQL);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function trial_balance($start_date,$end_date)
    {
    	$sql = "SELECT file.file_name,file.file_number,file.file_id,count(file.file_id),sum(pay.amount) as payment_total,sum(rec.amount) as receipt_total  FROM `file` left join payment_cfrb as pay on pay.file_id = file.file_id and (payment_date BETWEEN '".$start_date."' AND '".$end_date."') left join receipt_drc as rec on  rec.file_id = file.file_id and (receipt_date BETWEEN '".$start_date."' AND '".$end_date."') GROUP by file.file_id HAVING (payment_total > 0 or receipt_total > 0) ORDER BY `file`.`file_id` ASC";

    	//SELECT file.file_name,file.client_id,file.file_number,file.file_id,count(file.file_id),sum(pay.amount) as payment_total,sum(rec.amount) as receipt_total  FROM `file` left join payment_cfrb as pay on pay.file_id = file.file_id and (payment_date BETWEEN '2016-03-01' AND '2017-02-01') left join receipt_drc as rec on  rec.file_id = file.file_id and (receipt_date BETWEEN '2016-03-01' AND '2017-02-01') where file.client_id=35 GROUP by file.file_id HAVING (payment_total > 0 or receipt_total > 0) ORDER BY `file`.`file_id` ASC

    	
    	 $query = $this->db->query($sql);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function trial_openbalance($openbal_date){
    	$sql = "SELECT * FROM `cashbook_opening_balance` where openbal_date <= '".$openbal_date."' order by openbal_date desc limit 1";
    	$query = $this->db->query($sql);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function cashbook_lreceipt($client_id){
    	$sql = "Select (CASE WHEN month(receipt_date) > 2 THEN concat(YEAR(receipt_date),'-', YEAR(receipt_date)+1)  ELSE concat(YEAR(receipt_date)-1,'-', YEAR(receipt_date)) END) AS FiscalYear, sum(amount) as total_amount from receipt_drc where client_id='".$client_id."' group by (CASE WHEN month(receipt_date) > 2 THEN year(receipt_date)+1 ELSE year(receipt_date) END)";
    	$query = $this->db->query($sql);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function cashbook_lpayment($client_id){
    	$sql = "Select (CASE WHEN month(payment_date) > 2 THEN concat(YEAR(payment_date),'-', YEAR(payment_date)+1)  ELSE concat(YEAR(payment_date)-1,'-', YEAR(payment_date)) END) AS FiscalYear, sum(amount) as total_amount from payment_cfrb where client_id='".$client_id."' group by (CASE WHEN month(payment_date) > 2 THEN year(payment_date)+1 ELSE year(payment_date) END)";
    	$query = $this->db->query($sql);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function cashbook_lopenbal($client_id){
    	$sql = "Select (CASE WHEN month(openbal_date) > 2 THEN concat(YEAR(openbal_date),'-', YEAR(openbal_date)+1) ELSE concat(YEAR(openbal_date)-1,'-', YEAR(openbal_date)) END) AS FiscalYear, sum(amount) as total_amount from cashbook_opening_balance where client_id='".$client_id."' group by (CASE WHEN month(openbal_date) > 2 THEN year(openbal_date)+1 ELSE year(openbal_date) END)";
    	$query = $this->db->query($sql);
	     //$query = $this->db->get();
	     //echo $this->db->last_query();
    	 return $query->result();
    }
    public function cashbook_montdetails($month,$year,$client_id)
    {
        $sql="select a.*,file.file_name,file.file_number from (SELECT payment_date as selected_date, amount,transaction_type,file_id,details FROM `payment_cfrb` as p where month(p.payment_date)='".$month."' and year(p.payment_date)='".$year."' and client_id='".$client_id."' union all select receipt_date as selected_date,amount,transaction_type,file_id,details from `receipt_drc` as r where month(r.receipt_date)='".$month."' and year(r.receipt_date)='".$year."' and client_id='".$client_id."') as a left join file on file.file_id=a.file_id order by selected_date";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
	public function client_ledger_list($client_id,$file_id)
    {
        $sql="select a.*,file.file_name,file.file_number from (SELECT payment_date as selected_date, amount,transaction_type,file_id,details FROM `payment_cfrb` as p where p.file_id='".$file_id."' and client_id='".$client_id."' union all select receipt_date as selected_date,amount,transaction_type,file_id,details from `receipt_drc` as r where r.file_id='".$file_id."' and client_id='".$client_id."') as a left join file on file.file_id=a.file_id order by selected_date";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
	
}