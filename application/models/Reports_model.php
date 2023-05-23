<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model{

	public $file_table = 'report';

	//public function InsertClient($firm_name,$directors,$registered_address,$physical_address,$postal_address,$bank_accounts)
    
    public function Insert($table_name = 'report', $data = array())
    {

        $this->db->insert($table_name, $data);
        return ($this->db->affected_rows() != 1) ? false :  $this->db->insert_id();;
    }
    public function Delete($table_name = 'report',$data = array())
    {
        $this->db->where($data);
         $this->db->delete($table_name);
        //$this->db->insert($this->payment_table, $data);
        //return ($this->db->affected_rows() != 1) ? false : true;
    }
    public function Update($table_name = 'report',$data, $where = array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update($table_name, $data);
	}
    public function getDetails($table_name = 'report',$param=array(), $column='', $option=array(),$returntype='result')
    {  
    // echo "returntype = ".$returntype;     
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

        if(isset($option['custom_where'])){
            $this->db->where($option['custom_where']);
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
        if(isset($option['where_not_in']) && is_array($option['where_not_in'])){
            foreach($option['where_not_in'] as $key => $val){
                $this->db->where_not_in($key,$val);
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
                return $result = $result->result(); }       
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
    public function getDetailsRow($table_name = 'report',$param=array(), $column='', $option=array(),$returntype='result')
    {  
    // echo "returntype = ".$returntype;     
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

        if(isset($option['custom_where'])){
            $this->db->where($option['custom_where']);
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
        
        
        return $result->row();
        return FALSE;
    }
    public function get_bankstatmt_year($user_id,$end_month,$bank_id = ''){
        if($bank_id !='')
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+1) ELSE concat(YEAR(report_date)-1,'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."'  and bank_id='".$bank_id."' and status='1' and report_type='2' group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+1 ELSE year(report_date) END)";
        else
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+1) ELSE concat(YEAR(report_date)-1,'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and report_type='2' group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+1 ELSE year(report_date) END)";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }

    public function get_costcentre_data($client_id, $links){
        $remove_space_from_links = preg_replace('/\s+/', '', $links);
        $sql="SELECT * FROM costcentre WHERE user_id = '$client_id' AND links LIKE '$remove_space_from_links'";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
        //  echo $this->db->last_query();
         return $query->row();
    }


    public function get_ledger_year($user_id,$end_month,$report_type){
        if($report_type == '1')
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+1) ELSE concat(YEAR(report_date)-1,'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and (report_type='".$report_type."' or report_type='5' or report_type='7' or report_type='3') group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+1 ELSE year(report_date) END)";
        }
        else
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+1) ELSE concat(YEAR(report_date)-1,'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and report_type='".$report_type."' and  cost_id != '' group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+1 ELSE year(report_date) END)";
        }
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
    //Arul->alter the get_leger_array
    public function get_ledger_year_new($user_id,$end_month,$report_type){
        if($end_month == 12){$yearr = 0;}
        else{$yearr=1;}
        if($report_type == '1')
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+".$yearr.") ELSE concat(YEAR(report_date)-".$yearr.",'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and (report_type='".$report_type."' or report_type='5' or report_type='2' or report_type='7' or (report_type='3' and ledger_type='1')) group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+".$yearr." ELSE year(report_date) END)";
        }
        else
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+".$yearr.") ELSE concat(YEAR(report_date)-".$yearr.",'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and (report_type='".$report_type."' or (report_type='3' and ledger_type='2')) group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+".$yearr." ELSE year(report_date) END)";
        }
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }

    public function get_finanlstat_year($user_id,$end_month,$report_type){
        // $previous_end_date = date('Y-m-d', strtotime("+11 months", strtotime($previous_start_date)));
        if($end_month == 12){$yearr = 0;}
        else{$yearr=1;}

        if($report_type == '1')
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+".$yearr.") ELSE concat(YEAR(report_date)-".$yearr.",'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and (report_type='".$report_type."' or report_type='5' or report_type='7') and  cost_id != '' group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+".$yearr." ELSE year(report_date) END)";
        }
        else
        {
            $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+".$yearr.") ELSE concat(YEAR(report_date)-".$yearr.",'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and report_type='".$report_type."' and  cost_id != '' group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+".$yearr." ELSE year(report_date) END)";
        }
        
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         // echo $this->db->last_query();
         return $query->result();
    }
    public function getLegerBKPreviousCostid($cids,$client_id,$start_date){
        if($cids){

            $sql="SELECT distinct cost_id,category_id FROM `report` WHERE `user_id` = '".$client_id."' AND `cost_id` != '' AND `status` = 1 AND `report_date` < '".$start_date."' AND ((report_type = '3' and `ledger_type` = '2' ) or `report_type` = '2') and cost_id not in(".$cids.") and category_id='2' ORDER BY `cost_id` ASC, `report_date` ASC";
        }else{
        $sql="SELECT distinct cost_id,category_id FROM `report` WHERE `user_id` = '".$client_id."' AND `cost_id` != '' AND `status` = 1 AND `report_date` < '".$start_date."' AND ((report_type = '3' and `ledger_type` = '2' ) or `report_type` = '2') and category_id='2' ORDER BY `cost_id` ASC, `report_date` ASC";
        }
    //   echo $sql; die;
        $query = $this->db->query($sql);
         //$query = $this->db->get();
        //echo $this->db->last_query();echo "=";
         return $query->result();
    }

     public function bankstat_montdetails($month,$year,$client_id,$bank_id = '')
    {
        //$sql="select a.*,file.file_name,file.file_number from (SELECT payment_date as selected_date, amount,transaction_type,file_id,details,ref FROM `payment_cfrb` as p where month(p.payment_date)='".$month."' and year(p.payment_date)='".$year."' and client_id='".$client_id."' union all select receipt_date as selected_date,amount,transaction_type,file_id,details,ref from `receipt_drc` as r where month(r.receipt_date)='".$month."' and year(r.receipt_date)='".$year."' and client_id='".$client_id."') as a left join file on file.file_id=a.file_id order by selected_date";
        if($bank_id == '')
            $sql="SELECT * FROM `report` where month(report_date)='".$month."' and year(report_date)='".$year."' and user_id='".$client_id."'  and status='1' and report_type='2'  order by report_date";
        else
            $sql="SELECT * FROM `report` where bank_id = '".$bank_id."' and month(report_date)='".$month."' and year(report_date)='".$year."' and user_id='".$client_id."'  and status='1' and report_type='2'  order by report_date";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
        //echo $this->db->last_query();echo "=";
         return $query->result();
    }
    /******************* stal arul get all the statemanet*****************/
      public function bankstat_montdetails_new($month,$year,$client_id,$bank_id = '')
    {
          $sql="SELECT * FROM `report` where month(report_date)='".$month."' and year(report_date)='".$year."' and user_id='".$client_id."' and bank_id='".$bank_id."'  and status='1' and (report_type='2')  order by report_date";
        $query = $this->db->query($sql);
         //$query = $this->db->get();
        //echo $this->db->last_query();echo "=";
         return $query->result();
    }

    public function total_cr($report_date,$client_id,$bank_id = '')
    {
         $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` where amount_type !='sales' and user_id='".$client_id."' and bank_id='".$bank_id."' and report_date<'".$report_date."'  and status='1' and report_type='2'";
        $query = $this->db->query($sql);
         return $query->row();
    }
    public function total_dr($report_date,$client_id,$bank_id='')
    {
        $sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and bank_id='".$bank_id."' and report_date<'".$report_date."' and status='1' and report_type='2'";
        $query = $this->db->query($sql);
         return $query->row();
    }
    /************************** overwrite the total cr and dr for bank  statement ***************/
    public function total_cr_new($report_date,$client_id,$bank_id='')
    {
        // $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
         $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' and bank_id='".$bank_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2')";
        $query = $this->db->query($sql);
         return $query->row(); 
    }
    public function total_dr_new($report_date,$client_id,$bank_id ='')
    {
        //$sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
        $sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and bank_id='".$bank_id."' and status='1' AND (report_type='2' )";
            $query = $this->db->query($sql);
         return $query->row();
    }
    public function total_cr_new_costid($report_date,$client_id,$cost_id,$bank_id='')
    {
        // echo $report_date; die;
        // $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
         $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE  amount_type !='sales' AND user_id='".$client_id."' and report_date<'".$report_date."'  AND status='1' AND (cost_id='".$cost_id."' ) ";
        //  echo $sql; die;
         $query = $this->db->query($sql);
         return $query->row(); 
    }
    public function total_dr_new_costid($report_date,$client_id,$cost_id,$bank_id ='')
    {
        //$sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
        $sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (cost_id = '".$cost_id."')";
        $query = $this->db->query($sql);
         return $query->row();
    }
    
    public function total_cr_invoicefinalcial($report_date,$client_id)
    {
        // $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
         $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2' or report_type='12')";
        $query = $this->db->query($sql);
         return $query->row(); 
    }
    public function total_dr_invoicefinalcial($report_date,$client_id)
    {
        //$sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
        $sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2' or report_type='11')";
        $query = $this->db->query($sql);
         return $query->row();
    }
    public function total_cr_invoicefinalcial_single($report_date,$client_id,$expense_cost_id,$actrev_cost_id,$sales_cost_id)
    {
        // $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE amount_type !='sales' AND user_id='".$client_id."' AND report_date<'".$report_date."'  AND status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
        // $ReportDetails_expense = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(((report_type = "1" and amount_type="expense") or report_type = "7" or report_type="12") or (report_type="3" and ledger_type="1" and (cost_id = "'.$expense_cost_id.'" or (cost_id != "'.$sales_cost_id.'"  and cost_id != "'.$actrev_cost_id.'"))))'));
        

         $sql="SELECT COALESCE(sum(amount),0) as total_cr FROM `report` WHERE status='1' and user_id='".$client_id."' AND report_date<'".$report_date."'  and (((report_type = '1' and amount_type='expense') or report_type = '7' or report_type='12') or (report_type='3' and ledger_type='1' and (cost_id = '".$expense_cost_id."' or (cost_id != '".$sales_cost_id."'  and cost_id != '".$actrev_cost_id."'))))";
        $query = $this->db->query($sql);
         return $query->row(); 
    }
    public function total_dr_invoicefinalcial_single($report_date,$client_id)
    {
        //$sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2'  or (report_type = '3' AND ledger_type='2'))";
        $sql="SELECT COALESCE(sum(amount),0) as total_dr FROM `report` where amount_type ='sales' and user_id='".$client_id."' and report_date<'".$report_date."' and status='1' AND (report_type='2' or report_type='11')";
        $query = $this->db->query($sql);
         return $query->row();
    }
     /**************************end  overwrite the total cr and dr for bank  statement ***************/
    public function get_invoice_data($report_id)
    {
        $sql="SELECT * FROM `report` as invdata left join invoicing_user as inuser on inuser.id =invdata.inv_user_id  where invdata.report_id='".$report_id."'";
        $query = $this->db->query($sql);
         return $query->row();
    }

    public function getReceiptdata($inv_user_id){
        $sql="SELECT debit ,credit,report_id,user_id,inv_user_id,cost_id,report_date,due_date,inv_no,ref_no,amount_type,category_id,subcategory_id FROM ( (SELECT report_id,SUM(amount) as credit,user_id,inv_user_id,cost_id,report_date,due_date,inv_no,ref_no,amount_type,category_id,subcategory_id FROM report where `report_type` = 5 and  inv_user_id='".$inv_user_id."' GROUP BY report_id) as credit LEFT JOIN (SELECT parent_invoice_id,SUM(amount) as debit FROM report where `report_type` = 11 and inv_user_id='".$inv_user_id."' GROUP BY parent_invoice_id) as debit ON debit.parent_invoice_id = credit.report_id)";
        $query = $this->db->query($sql);
         return $query->result();

    }
    public function getPaymentdata($inv_user_id){
        $sql="SELECT debit ,credit,report_id,user_id,inv_user_id,cost_id,report_date,due_date,inv_no,ref_no,amount_type,category_id,subcategory_id FROM ( (SELECT report_id,SUM(amount) as credit,user_id,inv_user_id,cost_id,report_date,due_date,inv_no,ref_no,amount_type,category_id,subcategory_id FROM report where `report_type` = 7 and  inv_user_id='".$inv_user_id."' GROUP BY report_id) as credit LEFT JOIN (SELECT parent_invoice_id,SUM(amount) as debit FROM report where `report_type` = 12 and inv_user_id='".$inv_user_id."' GROUP BY parent_invoice_id) as debit ON debit.parent_invoice_id = credit.report_id)";
        $query = $this->db->query($sql);
         return $query->result();

    }

    public function get_asset_register_year($user_id,$end_month,$report_type){
        
        $sql="Select (CASE WHEN month(report_date) > ".$end_month." THEN concat(YEAR(report_date),'-', YEAR(report_date)+1) ELSE concat(YEAR(report_date)-1,'-', YEAR(report_date)) END) AS FiscalYear, sum(amount) as total_amount from report where user_id='".$user_id."' and status='1' and report_type = '".$report_type."' and cost_id !='' and subcategory_id=7 group by (CASE WHEN month(report_date) > ".$end_month." THEN year(report_date)+1 ELSE year(report_date) END)";
        
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
    public function get_asset_register_data($user_id,$report_type){
        
        // $sql="SELECT cc.cost_name,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id != '' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND rp.report_date >= '".$start_date."' AND rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
        $sql="SELECT cc.cost_name,cc.residual_value, cc.dep_per,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id != '' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";      
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
    public function get_asset_register_current_data($user_id,$start_date,$end_date,$report_type){
        
        $sql="SELECT cc.cost_name,cc.dep_per,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id != '' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND rp.report_date >= '".$start_date."' AND rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
        // $sql="SELECT cc.cost_name,cc.dep_per,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id != '' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
         // $sql="SELECT cc.cost_name,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id != '' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND  rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
        
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
    public function get_asset_register_previous_data($user_id,$start_date,$end_date,$report_type,$cost_id){
        
        // $sql="SELECT cc.cost_name,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id = '".$cost_id."' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND rp.report_date >= '".$start_date."' AND rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
         $sql="SELECT cc.cost_name,cc.dep_per,rp.* FROM report as rp,costcentre as cc WHERE rp.user_id = '".$user_id."' AND rp.status = 1 AND rp.cost_id = '".$cost_id."' AND rp.subcategory_id = 7 and rp.report_type = '".$report_type."' AND  rp.report_date <= '".$end_date."' and cc.cost_id=rp.cost_id  and cc.cost_name !='Acc Depr' ORDER BY cc.cost_name, rp.report_date ASC";
        
        
        $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
    public function get_asset_setting_details($user_id){
        $sql="SELECT * FROM costcentre WHERE user_id = '".$user_id."' AND status = 1 and subcategory_id = 7 and cost_name !='Acc Depr' ORDER BY cost_name";
         $query = $this->db->query($sql);
         //$query = $this->db->get();
         //echo $this->db->last_query();
         return $query->result();
    }
   

 //    public function getDetails_date($start_date,$end_date){
	// 	$sql = "SELECT * FROM `report` where report_date >= '".$start_date."' and report_date <= '".$end_date."'";
	// }
     
	
}