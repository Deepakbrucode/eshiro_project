<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipts extends CI_Controller {

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
		$this->load->model('receipts_model');
		$this->load->model('payments_model');
		$this->load->model('client_model');
		$this->load->model('file_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
	}
	public function index(){

		//$this->calculate_openbal('03/01/2016','07/01/2016');
		//exit();
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//$ReceiptDetails = $this->receipts_model->getReceiptsDetails_cf();
			$ReceiptDetails = $this->receipts_model->getReceiptsDetails_cf(array('receipt_drc.client_id'=> $filtered_client_id,'receipt_drc.account_status' => '1'),'',array('orderby' => 'receipt_drc.receipt_date','disporder' =>'asc'));
			$OpanBalDetails = $this->receipts_model->getOpenBalDetails_cf(array('cashbook_opening_balance.client_id'=> $filtered_client_id),'',array('orderby' => 'cashbook_opening_balance.openbal_date','disporder' =>'asc'));
			
			$data = array(
					'view_file'=>'show_receipt',
					'current_menu'=>'show_receipt',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Show Receipt',
					'ReceiptDetails' => $ReceiptDetails,
					'OpanBalDetails' => $OpanBalDetails,
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
		$page_url = 'receipts';
		
		$data = array(
					'view_file'=>'add_file',
					'current_menu'=>'add_receiptfile',
					'cusotm_field'=>'File',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'file_type1' => 'receipt',
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

	

	public function opening_balance(){

		if(isset($_GET['openbal_id']))
		{
			$openbal_id = $this->input->get('openbal_id');

			$BalDetail = $this->receipts_model->getOpenBalDetails_cf(array('id' => $openbal_id));
			$form_action = 'update_baldetails';
		}
		else{
			$BalDetail = '';
			$form_action = 'add_baldetails';
		}
		//$PaymentDetail = '';	

		$filtered_client_id= $this->session->filtered_client_id;

		$ClientDetails = $this->client_model->getClientDetails();	
		$FileDetails = $this->file_model->getFileDetails(array('client_id' => $filtered_client_id));
		$data = array(
					'view_file'=>'opening_balance',
					'current_menu'=> 'opening_balance',
					'cusotm_field'=> 'Opening Balance',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title' => 'Opening Balance',
					'BalDetail' => $BalDetail,
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

	public function receipt_drc(){
		if(isset($_GET['txn_type']))
		{
			$txn_type = $_GET['txn_type'];
			if($txn_type == 'deposit')
			{
				$form_title = 'Deposit';
				$menu_type = 'add_deposit';
				$page_url = 'receipts/deposit?txn_type=deposit';
			}
			else if($txn_type == 'rtd')
			{
				$form_title = 'RTD';
				$menu_type = 'add_rtd';
				$page_url = 'receipts/rtd?txn_type=rtd';
			}
			else
			{
				$form_title = 'Credit Interest';
				$menu_type = 'add_creditinterest';
				$page_url = 'receipts/credit_interest?txn_type=credit_interest';
			}
		}
		else
			{
				$txn_type = 'credit_interest';
				$form_title = 'Credit Interest';
				$menu_type = 'add_creditinterest';
				$page_url = 'receipts/credit_interest?txn_type=credit_interest';
			}
		if(isset($_GET['receipt_id']))
		{
			$receipt_id = $this->input->get('receipt_id');
			$ReceiptDetail = $this->receipts_model->getReceiptsDetails_cf(array('receipt_id' => $receipt_id));
			$form_action = 'update_rdetails';
		}
		else{
			$ReceiptDetail = '';
			$form_action = 'add_rdetails';
		}
		//$PaymentDetail = '';	

		$filtered_client_id= $this->session->filtered_client_id;

		$ClientDetails = $this->client_model->getClientDetails();	
		$FileDetails = $this->file_model->getFileDetails(array('client_id' => $filtered_client_id,'account_status' => 1));
		$data = array(
					'view_file'=>'receipt_drc',
					'current_menu'=> $menu_type,
					'cusotm_field'=> $form_title,
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title' => $form_title,
					'txn_type' => $txn_type,
					'page_url' => $page_url,
					'ReceiptDetail' => $ReceiptDetail,
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

	public function add_rdetails(){
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
        {
			$receipt_date = $this->input->post('receipt_date');
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
			$receipt_date=date("Y-m-d",strtotime($receipt_date));
			//if($file_id !='')
			//{
			/*if($client_id == '')
			{
				$insert_data = array(
				    'firm_name' => $client_name,
				    'status' => 1
				);

				$insert_status = $this->client_model->InsertClient($insert_data);
				$client_id = $this->db->insert_id();
			}*/
			/*if($file_id == '' && $file_name !='')
			{
				$insert_data = array(
				    'client_id' => $client_id,
				    'file_number' => $file_name,
				    'file_type' => 'receipt',
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertFile($insert_data);
				$file_id = $this->db->insert_id();
			}*/
				$insert_data = array(
				    'receipt_date' => $receipt_date,
				    //'bank' => $bank,
				    'amount' => $amount,
				    'file_id' => $file_id,
				    'client_id' => $client_id,
				    'details' => $details,
				    'transaction_type' => $transaction_type,
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertReceipts($insert_data);
				if($insert_status)
				{
					$this->calculate_openbal($receipt_date,$receipt_date);
				$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> '.$form_title.' inserted successfully</span></div>');
				redirect(BASE_URL.$page_url);
				}
				else
				{
					$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
				redirect(BASE_URL.$page_url);
				}
			// }
			// else
			// {
			// 	$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Number</span></div>');
			// 	redirect(BASE_URL.$page_url);
			// }
		}
		else
		{
			$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
			redirect(BASE_URL.$page_url);
			
		}

		exit;
	}
	public function update_rdetails(){
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
        {
			$receipt_date = $this->input->post('receipt_date');
			$receipt_olddate = $this->input->post('receipt_olddate');
			//$bank = $this->input->post('bank');
			$amount = $this->input->post('amount');
			$file_name = $this->input->post('file_name');
			$file_id = $this->input->post('file_id');
			//$client_name = $this->input->post('client_name');
			$client_id = $this->input->post('client_id');
			$transaction_type = $this->input->post('transaction_type');
			//$status = $this->input->post('status');
			$page_url = $this->input->post('page_url');
			$form_title = $this->input->post('form_title');
			$receipt_id = $this->input->post('receipt_id');
			$details = $this->input->post('details');
			$receipt_date=date("Y-m-d",strtotime($receipt_date));
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
				    'file_type' => 'receipt',
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertFile($insert_data);
				$file_id = $this->db->insert_id();
			}*/
				$insert_data = array(
				    'receipt_date' => $receipt_date,
				    //'bank' => $bank,
				    'amount' => $amount,
				    'file_id' => $file_id,
				    'client_id' => $client_id,
				    'details' => $details,
				    'transaction_type' => $transaction_type,
				    'status' => 1
				);
				$where_data = array('receipt_id' => $receipt_id);
				$insert_status = $this->receipts_model->UpdateReceipt($insert_data,$where_data);
				if($insert_status)
				{
					$this->calculate_openbal($receipt_date,$receipt_olddate);
					//exit;
				$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> '.$form_title.' Updated successfully</span></div>');
				redirect(BASE_URL.'receipts/index');
				}
				else
				{
					$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
				redirect(BASE_URL.$page_url);
				}
			// }
			// else
			// {
			// 	$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Number Not Exit</span></div>');
			// 	redirect(BASE_URL.$page_url.'&receipt_id='.$receipt_id);
			// }
		}
		else
		{
	$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
	redirect(BASE_URL.$page_url);
			
		}
		exit;
	}


	public function add_baldetails(){
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
        {
        	$client_id = $this->input->post('client_id');
        	$opening_bal_from = $this->input->post('opening_bal_from');
        	$opening_bal_to = $this->input->post('opening_bal_to');
        	$amount = $this->input->post('amount');
        	$file_id = $this->input->post('file_id');

        	$startDate = strtotime($opening_bal_from);
$endDate   = strtotime($opening_bal_to);

$currentDate = $endDate;

while ($currentDate >= $startDate) {
    //echo date('m/Y',$currentDate);
    //echo "====";

$current_month = date('Y-m-01',$currentDate);;

     $insert_data = array(
				    'client_id' => $client_id,
				    //'bank' => $bank,
				    'file_id' => $file_id,
				    'openbal_date' => $current_month,
				    'amount' => $amount,
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);



     $currentDate = strtotime( date('Y/m/01/',$currentDate).' -1 month');
   // echo "====";




     

}

if($insert_status)
{
	$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Opening Balance Inserted Successfully</span></div>');
}

redirect(BASE_URL.'receipts/opening_balance');


//exit;

        }

	}
	public function update_baldetails(){

		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
        {
        	$client_id = $this->input->post('client_id');
        	$opening_bal_date = $this->input->post('opening_bal_date');
        	$opening_bal_date = date('Y-m-01', strtotime($opening_bal_date));
        	$bal_id = $this->input->post('bal_id');
        	$opening_bal_from = $this->input->post('opening_bal_from');
        	$opening_bal_to = $this->input->post('opening_bal_to');
        	$amount = $this->input->post('amount');
        	$file_id = $this->input->post('file_id');
        	$insert_data = array(
				    'client_id' => $client_id,
				    //'bank' => $bank,
				    'file_id' => $file_id,
				    'openbal_date' => $opening_bal_date,
				    'amount' => $amount,
				    'status' => 1
				);
			$where_data = array('id' => $bal_id);
			$insert_status = $this->receipts_model->UpdateOpeningBalance($insert_data,$where_data);
			if($insert_status)
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Opening Balance Update Successfully</span></div>');
			}
			else
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
			}
        }
        else
        {
        	$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in update</span></div>');
        }
        redirect(BASE_URL.'receipts/index');

	}
	public function show_receipt(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$ReceiptDetails = $this->receipts_model->getReceiptsDetails_cf();

			$data = array(
					'view_file'=>'show_receipt',
					'current_menu'=>'show_receipt',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Show Receipt',
					'ReceiptDetails' => $ReceiptDetails,
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

	function delete_receipt($receipt_id)
    {
        //delete employee record
        
        //$this->receipts_model->DeleteReceipt($id);

        $insert_data = array(
				    'status' => 0
				);
				$where_data = array('receipt_id' => $receipt_id);
				$insert_status = $this->receipts_model->UpdateReceipt($insert_data,$where_data);
      
        redirect(BASE_URL.'receipts/show_receipt');
    }

	/*public function add_deposit(){
		
		$data = array(
					'view_file'=>'receipt_drc',
					'current_menu'=>'add_deposit',
					'cusotm_field'=>'Add Deposit',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

	public function rtd(){
		
		$data = array(
					'view_file'=>'receipt_drc',
					'current_menu'=>'add_rtd',
					'cusotm_field'=>'RTD',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

	public function credit_interest(){
		
		$data = array(
					'view_file'=>'receipt_drc',
					'current_menu'=>'add_clientinterest',
					'cusotm_field'=>'Credit Interest',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css',
									'css/styles.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

*/
	/*public function addfile_submit(){
		$file_type = $this->input->post('file_type');
		$client = $this->input->post('client');
		$client_id = $this->input->post('client_id');
		$file_number = $this->input->post('file_number');
		$case_type = $this->input->post('case_type');
		$cell_phone = $this->input->post('cell_phone');
		$telephone = $this->input->post('telephone');
		$email = $this->input->post('email');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}
		$insert_data = array(
		    'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'case_type' => $case_type,
		    'cell_no' => $cell_phone,
		    'telephone_no' => $telephone,
		    'email' => $email,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'status' => 1
		);
		//print_r($insert_data);

		$insert_status = $this->receipts_model->InsertFile($insert_data);
		//echo $this->db->last_query();
		//exit;
		if($insert_status)
		{
		$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Added Successfully</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}
		else
		{
			$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Insert</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}
		exit;
	}




	public function updatefile_submit(){
		$file_id = $this->input->post('file_id');
		$client = $this->input->post('client');
		$client_id = $this->input->post('client_id');
		$file_type = $this->input->post('file_type');
		$file_number = $this->input->post('file_number');
		$case_type = $this->input->post('case_type');
		 $cell_no = $this->input->post('cell_phone');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$telephone_no = $this->input->post('telephone');
		$email = $this->input->post('email');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			 $client_id = $this->db->insert_id();
			//exit();
		}
		$insert_data = array(
			'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'case_type' => $case_type,
		     'cell_no' => $cell_no,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'telephone_no' => $telephone_no,
		    'email' => $email,
		    'status' => 1
		);
		$where_date = array(
			'file_id' => $file_id
		);

		$insert_status = $this->receipts_model->UpdateFile($insert_data,$where_date);
		if($insert_status)
		{
		$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Receipt details Updated successfully</span></div>');
		redirect(BASE_URL.$page_url.'/index');
		}
		else
		{
			$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
		redirect(BASE_URL.$page_url.'/index');
		}
		exit;
	}

	 function delete_file($file_id,$page_url)
    {
    	//echo $page_url;
    	//exit();
    	//$page_url = $this->input->post('page_url');
        //delete employee record
        //$this->db->where('file_id', $id);
      // $this->db->delete('file');
       $insert_data = array(
		    'status' => 0
		);
		$where_date = array(
			'file_id' => $file_id
		);

		$insert_status = $this->receipts_model->UpdateFile($insert_data,$where_date);
        redirect(BASE_URL.$page_url.'/index');
    }

*/


	/*public function addfile(){
		$file_type = $this->input->post('file_type');
		$client = $this->input->post('client');
		$client_id = $this->input->post('client_id');
		$file_number = $this->input->post('file_number');
		$case_type = $this->input->post('case_type');
		$cell_phone = $this->input->post('cell_phone');
		$telephone = $this->input->post('telephone');
		$email = $this->input->post('email');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => $status
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}
		$insert_data = array(
		    'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'case_type' => $case_type,
		    'cell_no' => $cell_phone,
		    'telephone_no' => $telephone,
		    'email' => $email,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'status' => $status
		);

		$insert_status = $this->receipts_model->InsertFile($insert_data);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Added Successfully</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}
		else
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Insert</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}
		exit;
	}*/


	public function calculate_openbal($current_date,$old_date){
		// $current_date = '2016-03-31';
		$filtered_client_id= $this->session->filtered_client_id;
		 $current_month = date('m',strtotime($current_date));
		 $current_year = date('Y',strtotime($current_date));

		 $old_month = date('m',strtotime($old_date));
		 $old_year = date('Y',strtotime($old_date));














/*

echo "<br>";

        	$startDate = strtotime($current_date);
$endDate   = strtotime($old_date);

$currentDate11 = $endDate;



while ($currentDate11 >= $startDate) {
    echo date('m/Y',$currentDate11);
    echo "====";

 $currentDate11 = strtotime( date('Y/m/01/',$currentDate11).' -1 month');
     

}

echo "fssssssssssssssss = <br>";
$currentDate1111 = $startDate;

while ($currentDate1111 <= $endDate) {
    echo date('m/Y',$currentDate1111);
    echo "====";

 $currentDate1111 = strtotime( date('Y/m/01/',$currentDate1111).' +1 month');
     
//exit;
}

echo "sssssssssssssss = <br>";


*/









//7 > 3
		 if($current_month > $old_month || $current_year >  $old_year)
		 {


        	$startDate = strtotime($current_date);
$endDate   = strtotime($old_date);




//6
		 	$currentDate11 = $startDate;



$date_array = array();
//3 >= 7
while ($currentDate11 >= $endDate) {

	//echo "huytuyuyiuyi";
    //echo date('m/Y',$currentDate11);
    //echo "====";

    //$date_val = date('m/d/Y',$currentDate11);

$date_array[] = $currentDate11;

			   // $this->calculate_openbal($date_val,$date_val);


 $currentDate11 = strtotime( date('Y/m/01/',$currentDate11).' -1 month');
     

}


//print_r($date_array);

sort($date_array);

//print_r($date_array);

foreach ($date_array as $key => $value) {
	//echo $value;


	    $date_val = date('m/d/Y',$value);


			    $this->calculate_openbal($date_val,$date_val);


}


/*usort($date_array, function($a, $b) {
    $a = strtotime($a[2]);
    $b = strtotime($b[2]);
    return (($a == $b) ? (0) : (($a > $b) ? (1) : (-1)));
});*/


//exit;

		 	/*$currentDate1111 = $startDate;

			while ($currentDate1111 <= $endDate) {
			    echo date('m/Y',$currentDate1111);
			    echo "====";

			$date_val = date('m/d/Y',$currentDate1111);
			    $this->calculate_openbal($date_val,$date_val);


			 $currentDate1111 = strtotime( date('Y/m/01/',$currentDate1111).' +1 month');
			     
			//exit;
			}



		 	//$this->calculate_openbal($old_date,$old_date);
exit;
*/

		 }

//echo "===========";
		 $previous_Date_str = strtotime( date('Y-m-01',strtotime($current_date)).' +1 month');
		$previous_Date = date('Y-m-d',$previous_Date_str);

		$open_result = $this->receipts_model->getOpenbalanceDetails(array('openbal_date'=>$previous_Date,'client_id' => $filtered_client_id));
		//echo $this->db->last_query();

		if($open_result)
		{
			foreach ($open_result as $key => $value) {
				//$openbal_amount = $value->totalamount;
				$client_id = $value->client_id;
				 $bal_id = $value->id;
			}
			//print_r($open_result);
			//echo "resulttttt";
		}
		$recept_amount = 0;
		$payment_amount = 0;
		$openbal_amount = 0;
		$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('month(receipt_date)' => $current_month , 'year(receipt_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(receipt_id) as ids');
		
		$PaymentDetails = $this->payments_model->getPaymentDetails(array('month(payment_date)' => $current_month , 'year(payment_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(payment_id) as ids');
		//echo $this->db->last_query();
		$OpenBalDetails = $this->receipts_model->getOpenbalanceDetails(array('month(openbal_date)' => $current_month , 'year(openbal_date)' => $current_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(id) as ids');
		//echo "++++++++++";
		if($ReceiptsDetails)
		{
			foreach ($ReceiptsDetails as $key => $value) {
				 $recept_amount = $value->totalamount;
			}
		}
		//echo "==re =========";
		if($PaymentDetails)
		{
			foreach ($PaymentDetails as $key => $value) {
				 $payment_amount = $value->totalamount;
			}
		}
		//echo "== pay =========";
		if($OpenBalDetails)
		{
			foreach ($OpenBalDetails as $key => $value) {
				 $openbal_amount = $value->totalamount;
				//$client_id = $client_id;
			}
		}
		//echo "== open =========";
		   $balance_amount = ($openbal_amount+$recept_amount)-$payment_amount;
		   if($bal_id != '')
		{
		$insert_data = array(

				    'amount' => $balance_amount,

				);
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


		 if($current_month < $old_month || $current_year <  $old_year)
		 {

        	$startDate = strtotime($current_date);
$endDate   = strtotime($old_date);

		 	$currentDate1111 = $startDate;



while ($currentDate1111 <= $endDate) {
	// echo"sdfssfsdfsfdS";
 //    echo date('m/Y',$currentDate1111);
 //    echo "====";

$date_val = date('m/d/Y',$currentDate1111);
    $this->calculate_openbal($date_val,$date_val);


 $currentDate1111 = strtotime( date('Y/m/01/',$currentDate1111).' +1 month');
     
//exit;
}

//exit;


		/* 	$currentDate11 = $endDate;
while ($currentDate11 >= $startDate) {
    echo date('m/Y',$currentDate11);
    echo "====";
$date_val = date('m/d/Y',$currentDate1111);
    $this->calculate_openbal($date_val,$date_val);

 $currentDate11 = strtotime( date('Y/m/01/',$currentDate11).' -1 month');
     

}


exit;
*/

		 	//$this->calculate_openbal($old_date,$old_date);
		 }



		 

//print_r($OpenBalDetails);



	}		

}
