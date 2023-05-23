<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('payments_model');
		$this->load->model('receipts_model');
		$this->load->model('file_model');
		$this->load->model('client_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
	}
	public function index(){
		//$this->calculate_openbal('03/01/2017','04/01/2016');
		//exit;
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			$PaymentDetails = $this->payments_model->getPaymentDetails_cf(array('payment_cfrb.client_id'=> $filtered_client_id,'payment_cfrb.account_status' => '1'),'',array('orderby' => 'payment_cfrb.payment_date','disporder' =>'asc'));
			$data = array(
					'view_file'=>'show_payment',
					'current_menu'=>'show_payment',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Show Payment',
					'PaymentDetails' => $PaymentDetails,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/bootstrap-switch/css/bootstrap-switch.min.css',
									'lib/datatables/datatables.min.css',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js'
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/bootstrap-switch/js/bootstrap-switch.min.js',
									'lib/datatable.js',
									'lib/datatables/datatables.min.js',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/bootstrap-confirmation/bootstrap-confirmation.min.js'

									),
								"priority" => 'high'
								)
				);

			$this->template->load_admin_template($data);
		}
	}
	/*public function add_file(){

		if($this->input->get('file_id'))
		{
			$form_name = 'Update';
			$form_action = 'updatefile_submit';
			$file_id = $this->input->get('file_id');
			$FileDetail = $this->receipts_model->getFileDetails_client(array('file.file_id' => $file_id));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addfile_submit';
			$FileDetail = '';
		}

		//$form_action = 'addfile';
		$page_url = 'payments';
		
		$data = array(
					'view_file'=>'add_file',
					'current_menu'=>'add_paymentfile',
					'cusotm_field'=>'File',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'file_type1' => 'payment',
					'form_action' => $form_action,
					'FileDetail' => $FileDetail,
					'page_url' => $page_url,
					'form_name' => $form_name,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'lib/jquery-ui/jquery-ui.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js',
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/jquery-ui/jquery-ui.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}*/
	public function payment_cfrb(){
		if(isset($_GET['txn_type']))
		{
			$txn_type = $_GET['txn_type'];
			if($txn_type == 'cost')
			{
				$form_title = 'Cost';
				$menu_type = 'add_cost';
				$page_url = 'payments/cost?txn_type=cost';
			}
			else if($txn_type == 'fee')
			{
				$form_title = 'Fee';
				$menu_type = 'add_fee';
				$page_url = 'payments/fee?txn_type=fee';
			}
			else if($txn_type == 'refund')
			{
				$form_title = 'Refund';
				$menu_type = 'add_refund';
				$page_url = 'payments/refund?txn_type=refund';
			}
			else
			{
				$form_title = 'Bank Charges';
				$menu_type = 'add_bank_charges';
				$page_url = 'payments/bank_charges?txn_type=bank_charges';
			}
		}
		else
			{
				$txn_type = 'bank_charges';
				$form_title = 'Bank Charges';
				$menu_type = 'add_bank_charges';
				$page_url = 'payments/bank_charges?txn_type=bank_charges';
			}
		if(isset($_GET['payment_id']))
		{
			$payment_id = $this->input->get('payment_id');
			$PaymentDetail = $this->payments_model->getPaymentDetails_cf(array('payment_id' => $payment_id));
			$form_action = 'update_pdetails';
		}
		else{
			$PaymentDetail = '';
			$form_action = 'add_pdetails';
		}
		//$PaymentDetail = '';	
		$filtered_client_id= $this->session->filtered_client_id;
		$ClientDetails = $this->client_model->getClientDetails();	
		$FileDetails = $this->file_model->getFileDetails(array('client_id' => $filtered_client_id,'account_status' => 1));	
		$data = array(
					'view_file'=>'payment_cfrb',
					'current_menu'=> $menu_type,
					'cusotm_field'=> $form_title,
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title' => $form_title,
					'txn_type' => $txn_type,
					'page_url' => $page_url,
					'PaymentDetail' => $PaymentDetail,
					'ClientDetails' => $ClientDetails,
					'FileDetails' => $FileDetails,
					'form_action' => $form_action,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
									'lib/jquery-ui/jquery-ui.css',
									'lib/select2/css/select2.min.css',
									'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/jquery-ui/jquery-ui.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
									'lib/select2/js/select2.full.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
	public function add_pdetails(){
		 $this->load->library('form_validation');
		 if ($this->form_validation->run() == FALSE)
                {
		$payment_date = $this->input->post('payment_date');
		//$bank = $this->input->post('bank');
		$amount = $this->input->post('amount');
		//$file_name = $this->input->post('file_name');
		$file_id = $this->input->post('file_id');
		//$client_name = $this->input->post('client_name');
		$client_id = $this->input->post('client_id');
		$transaction_type = $this->input->post('transaction_type');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		$form_title = $this->input->post('form_title');
		$details = $this->input->post('details');
		$payment_date=date("Y-m-d",strtotime($payment_date));
		// if($file_id !='')
		// {
		/*if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client_name,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}
		if($file_id == '' && $file_name !='')
		{
			$insert_data = array(
			    'client_id' => $client_id,
			    'file_number' => $file_name,
			    'file_type' => 'payment',
			    'status' => 1
			);

			$insert_status = $this->receipts_model->InsertFile($insert_data);
			$file_id = $this->db->insert_id();
		}*/
		$insert_data = array(
		    'payment_date' => $payment_date,
		    //'bank' => $bank,
		    'amount' => $amount,
		    'file_id' => $file_id,
		    'client_id' => $client_id,
		    'transaction_type' => $transaction_type,
		    'details' => $details,
		    'status' => 1
		);

		$insert_status = $this->payments_model->InsertPayment($insert_data);
		if($insert_status)
		{
			$this->calculate_openbal($payment_date,$payment_date);
		$this->session->set_flashdata('payment', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> '.$form_title.' inserted successfully</span></div>');
		redirect(BASE_URL.$page_url);
		}
		else
		{
			$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
		redirect(BASE_URL.$page_url);
		}
	// }
	// else
	// {
	// 	$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Number</span></div>');
	// 	redirect(BASE_URL.$page_url);
	// }
	}
	else
	{
$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
redirect(BASE_URL.$page_url);
		
	}
	exit;
	}
	public function update_pdetails(){
		 $this->load->library('form_validation');
		 if ($this->form_validation->run() == FALSE)
                {
		$payment_date = $this->input->post('payment_date');
		$payment_olddate = $this->input->post('payment_olddate');
		$bank = $this->input->post('bank');
		$amount = $this->input->post('amount');
		$file_name = $this->input->post('file_name');
		$file_id = $this->input->post('file_id');
		$client_name = $this->input->post('client_name');
		$client_id = $this->input->post('client_id');
		$transaction_type = $this->input->post('transaction_type');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		$form_title = $this->input->post('form_title');
		$payment_id = $this->input->post('payment_id');
		$details = $this->input->post('details');
		$payment_date=date("Y-m-d",strtotime($payment_date));
		// if($file_id !='')
		// {
		/*if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client_name,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}
		if($file_id == '' && $file_name !='')
		{
			$insert_data = array(
			    'client_id' => $client_id,
			    'file_number' => $file_name,
			    'file_type' => 'payment',
			    'status' => 1
			);

			$insert_status = $this->receipts_model->InsertFile($insert_data);
			$file_id = $this->db->insert_id();
		}*/
		$insert_data = array(
		    'payment_date' => $payment_date,
		    //'bank' => $bank,
		    'amount' => $amount,
		    'file_id' => $file_id,
		    'client_id' => $client_id,
		    'transaction_type' => $transaction_type,
		    'details' => $details,
		    'status' => 1
		);
		$where_data = array('payment_id' => $payment_id);
		$insert_status = $this->payments_model->UpdatePayment($insert_data,$where_data);
		if($insert_status)
		{
			$this->calculate_openbal($payment_date,$payment_olddate);
		$this->session->set_flashdata('payment', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> '.$form_title.' Updated successfully</span></div>');
		redirect(BASE_URL.'payments/index');
		}
		else
		{
			$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
		redirect(BASE_URL.$page_url);
		}
	// }
	// else
	// {
	// 	$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Number Not Exit</span></div>');
	// 	redirect(BASE_URL.$page_url.'&payment_id='.$payment_id);
	// }
	}
	else
	{
$this->session->set_flashdata('payment', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
redirect(BASE_URL.$page_url);
		
	}
	exit;
	}
	/*public function show_payment(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$PaymentDetails = $this->payments_model->getPaymentDetails_cf();
			$data = array(
					'view_file'=>'show_payment',
					'current_menu'=>'show_payment',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Show Payment',
					'PaymentDetails' => $PaymentDetails,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/bootstrap-switch/css/bootstrap-switch.min.css',
									'lib/datatables/datatables.min.css',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js'
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/bootstrap-switch/js/bootstrap-switch.min.js',
									'lib/datatable.js',
									'lib/datatables/datatables.min.js',
									'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/bootstrap-confirmation/bootstrap-confirmation.min.js'

									),
								"priority" => 'high'
								)
				);

			$this->template->load_admin_template($data);
		}
	}*/
	function delete_payment($payment_id)
    {
        //delete employee record
        
        //$this->payments_model->DeletePayment($id);
        $insert_data = array(
		    'status' => 0
		);
		$where_data = array('payment_id' => $payment_id);
		$insert_status = $this->payments_model->UpdatePayment($insert_data,$where_data);
      
        redirect(BASE_URL.'payments/index');
    }
    public function get_filenumber(){
		if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	       $client_id = strtolower($_GET['client_id']);
	   $where_data = array('client_id' => $client_id);
	      $option_arr = array('like'=> array('file_number' => $q));
	      $FileDetails = $this->receipts_model->getFileDetails($where_data,'',$option_arr);

	      if($FileDetails)
		  {
			foreach ($FileDetails as $value) {
				$file_id = $value->file_id;
	            $file_number = $value->file_number;
	             $new_row['label']=htmlentities(htmlentities(stripslashes($file_number)));
        		$new_row['value']=htmlentities(stripslashes($file_id));
        		$row_set[] = $new_row; //build an array

	        }
	        echo json_encode($row_set);
	      }
	    }
	}


	public function calculate_openbal($current_date,$old_date){
		// $current_date = '2016-03-31';
		$bal_id = '';
		$filtered_client_id= $this->session->filtered_client_id;
		$current_month = date('m',strtotime($current_date));
		$current_year = date('Y',strtotime($current_date));

		$old_month = date('m',strtotime($old_date));
		$old_year = date('Y',strtotime($old_date));

		if($current_month > $old_month || $current_year >  $old_year)
		{


        	$startDate = strtotime($current_date);
			$endDate   = strtotime($old_date);
		 	$currentDate11 = $startDate;
			$date_array = array();

			while ($currentDate11 >= $endDate) {
				$date_array[] = $currentDate11;
 				$currentDate11 = strtotime( date('Y/m/01/',$currentDate11).' -1 month');
			}

			sort($date_array);

			foreach ($date_array as $key => $value) {
				//echo $value;
	    		$date_val = date('m/d/Y',$value);
			    $this->calculate_openbal($date_val,$date_val);
			}
		}
		$previous_Date_str = strtotime( date('Y-m-01',strtotime($current_date)).' +1 month');
		$previous_Date = date('Y-m-d',$previous_Date_str);

		$open_result = $this->receipts_model->getOpenbalanceDetails(array('openbal_date'=>$previous_Date,'client_id' => $filtered_client_id));

		if($open_result)
		{
			foreach ($open_result as $key => $value) {
				$client_id = $value->client_id;
				$bal_id = $value->id;
			}
		}
		
		$recept_amount = 0;
		$payment_amount = 0;
		$openbal_amount = 0;
		$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('month(receipt_date)' => $current_month , 'year(receipt_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(receipt_id) as ids');
		
		$PaymentDetails = $this->payments_model->getPaymentDetails(array('month(payment_date)' => $current_month , 'year(payment_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(payment_id) as ids');
		//echo $this->db->last_query();
		$OpenBalDetails = $this->receipts_model->getOpenbalanceDetails(array('month(openbal_date)' => $current_month , 'year(openbal_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(id) as ids');
		if($ReceiptsDetails)
		{
			foreach ($ReceiptsDetails as $key => $value) {
				 $recept_amount = $value->totalamount;
			}
		}
		if($PaymentDetails)
		{
			foreach ($PaymentDetails as $key => $value) {
				 $payment_amount = $value->totalamount;
			}
		}
		if($OpenBalDetails)
		{
			foreach ($OpenBalDetails as $key => $value) {
				 $openbal_amount = $value->totalamount;
			}
		}
		$balance_amount = ($openbal_amount+$recept_amount)-$payment_amount;
		if($bal_id != '')
		{
			//echo "function works";
			$insert_data = array('amount' => $balance_amount,);
			$where_data = array('id' => $bal_id);
			$insert_status = $this->receipts_model->UpdateOpeningBalance($insert_data,$where_data);
		}

		else
		{
			//$current_month = date('Y-m-01',$currentDate);;

     		$insert_data = array(
				    'client_id' => $filtered_client_id,
				    'openbal_date' => $previous_Date,
				    'amount' => $balance_amount,
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);

			//echo "function exit";
			//exit;
		}
//echo "-----------$previous_Date=================";

		 if($current_month < $old_month || $current_year <  $old_year)
		 {

        	$startDate = strtotime($current_date);
			$endDate   = strtotime($old_date);
		 	$currentDate1111 = $startDate;

			while ($currentDate1111 <= $endDate) {

				$date_val = date('m/d/Y',$currentDate1111);
    			$this->calculate_openbal($date_val,$date_val);
 				$currentDate1111 = strtotime( date('Y/m/01/',$currentDate1111).' +1 month');

			}


		 }

	}		

}
