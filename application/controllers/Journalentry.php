<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Journalentry extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('reports_model');
		$this->load->model('costcentre_model');
		$this->load->model('client_model');
		$this->load->helper('url');
		$this->load->library('excel');
	}
	public function index(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{
			$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
			if($fclient_id !='')
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $fclient_id,'status' => 1,'report_type' => 3));
			}
			else
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id, 'status' => 1,'report_type' => 3));
			}
			$ClientDetails = $this->client_model->getClientDetails();	
		}
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 3));
		}
		
		$data = array(
					'view_file'=>'journalentry/show_journaldatas',
					'current_menu'=>'journal_datas',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'ReportDetails' => $ReportDetails,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'fclient_id' => $fclient_id,
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
									'css/styles.css',
									//'css/cashbookpdf.css',
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
									'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
									'//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
									'//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
									//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

	public function bulk_insert(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$filtered_client_id= $this->session->id;

		if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			else
			{
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			
		}
			
		else
		{
			$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id),'',array('orderby' => 'cost_name', 'disporder' => 'asc'));
		}
		
		$data = array(
					'view_file'=>'journalentry/bulk_insert',
					'current_menu'=>'bulk_insert',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'CostDetails' => $CostDetails,
					'usertype' => $usertype,
					'fclient_id' => $fclient_id,
					'user_id' => $filtered_client_id,
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
									'lib/jquery-validation/js/jquery.validate.js',
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
	/****************** sta arul code***************/
	public function check_jouralentry()
	{
		//print_R($_POST);
		$user_id = $_POST['user_id'];
		$journal_data = $_POST['journal_data'];
		$saleamt= $exposeamt =0;
		if(!empty($journal_data) && $journal_data !='')
		{
			foreach($journal_data as $journal)
			{
				$amount_type = $journal['amount_type'];
 				$amount = $journal['amt'];
 				if($amount_type=='sales')
 				{
                   $saleamt = $saleamt+$amount;
 				}else{
                   $exposeamt = $exposeamt+$amount;
 				}
			}
			if($saleamt == $exposeamt)
			{
			   echo '1';
			}else{
				echo '0';
				 
		       //redirect(BASE_URL.'journalentry/');
			}
		}
	}
	/****************** sta arul end***************/
	public function saveBulkData(){
		$user_id = $_POST['user_id'];
		$journal_data = $_POST['journal_data'];
		 // echo "<pre>";print_r($journal_data);echo "</pre>";
		  //exit;
		if(!empty($journal_data) && $journal_data !='')
		{
			foreach($journal_data as $journal)
			{

				$report_date = $journal['report_date'];
				if($report_date !='')
				{
					$report_date1 = explode('/',$report_date);
					$report_date = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
				}
				$report_date = date('Y-m-d',strtotime($report_date));
				// $inv_no = $_POST['inv_no'];
				// $ref_no = $_POST['ref_no'];
				$description = $journal['description'];

				$amount_type = $journal['amount_type'];
				$tax_type = '';
				$amount = $journal['amt'];
				$ledgertype = $journal['ledgertype'];
				//$cost_id = $_POST['cost_id'];
				$status = 1;

				$data_costid = $journal['cost_id'];
				$cost_arr = explode("-",$data_costid);
				if(!empty($cost_arr))
				{
					$category_id = (isset($cost_arr[0]))?$cost_arr[0]:'';
					$subcategory_id = (isset($cost_arr[1]))?$cost_arr[1]:'';
					$cost_id = (isset($cost_arr[2]))?$cost_arr[2]:'';
				}
				else
				{
					$category_id = $subcategory_id = $cost_id = '';
				}

				$report_array = array( 'user_id' => $user_id,'report_date' => $report_date,'description' => $description,'amount_type' => $amount_type,'tax_type' => $tax_type,'amount' => $amount, 'status' => $status,'cost_id'=> $cost_id,'category_id'=> $category_id,'subcategory_id' => $subcategory_id,'report_type' => 3,'ledger_type'=> $ledgertype);
				
				$report_array['created_on'] = date('Y-m-d H:i:s');
				$report_id = $this->reports_model->Insert('report',$report_array);
				

			}
		}

		// $this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Journal entry data Saved Successfully</span></div>');
		// redirect(BASE_URL.'journalentry/bulk_insert');
		
	}
	public function delete_report($report_id =''){
		if($report_id !='')
		{
			$this->reports_model->Delete('report',array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Selected Bank Transaction Deleted Successfully</span></div>');
		redirect(BASE_URL.'journalentry');
		
	}

	public function edit_journaldatas($report_id = ''){	
		$filtered_client_id= $this->session->id;
		$ReportDetail = '';
		if($report_id !='' )
		$ReportDetail = $this->reports_model->getDetails('report',array('report_id' => $report_id));	
		
		$ClientDetails = $this->client_model->getClientDetails();
		$usertype= $this->session->usertype;

		$data = array(
					'view_file'=>'journalentry/edit_journaldata',
					'current_menu'=>'add_report',
					'cusotm_field'=>'add_report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Edit',
					'form_action' => 'save_report',
					'user_id' => $filtered_client_id,
					'report_id' => $report_id,
					'ReportDetail' => $ReportDetail,
					//'cost_types' => $cost_types,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					//'ParentCost' => $ParentCost,
					//'parent_childcost' => $parent_childcost,
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
	public function save_journaldata(){
		$user_id = $_POST['user_id'];
		$report_id = $_POST['report_id'];
		$report_date = $_POST['report_date'];
		$ledger_type = $_POST['ledger_type'];
		if($report_date !='')
		{
			$report_date1 = explode('/',$report_date);
			$report_date = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}
		$report_date = date('Y-m-d',strtotime($report_date));
		// $inv_no = $_POST['inv_no'];
		// $ref_no = $_POST['ref_no'];
		$description = $_POST['description'];
		$amount_type = $_POST['amount_type'];
		$tax_type = '';
		$amount = $_POST['amount'];
		//$cost_id = $_POST['cost_id'];
		$status = $_POST['status'];

		$data_costid = $_POST['data_costid'];
		$cost_arr = explode("-",$data_costid);
		if(!empty($cost_arr))
		{
			$category_id = (isset($cost_arr[0]))?$cost_arr[0]:'';
			$subcategory_id = (isset($cost_arr[1]))?$cost_arr[1]:'';
			$cost_id = (isset($cost_arr[2]))?$cost_arr[2]:'';
		}
		else
		{
			$category_id = $subcategory_id = $cost_id = '';
		}

		$report_array = array( 'user_id' => $user_id,'report_date' => $report_date,'description' => $description,'amount_type' => $amount_type,'tax_type' => $tax_type,'amount' => $amount, 'status' => $status,'cost_id'=> $cost_id,'category_id'=> $category_id,'subcategory_id' => $subcategory_id,'report_type' => 3 ,'ledger_type'=>$ledger_type);
		if($report_id == '')
		{
			$report_array['created_on'] = date('Y-m-d H:i:s');
			$report_id = $this->reports_model->Insert('report',$report_array);
		}
		else
		{
			$where_array = array('report_id' => $report_id);
			$report_array['modified_on'] = date('Y-m-d H:i:s');
			$this->reports_model->Update('report',$report_array,$where_array);
		}

		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Journal data Saved Successfully</span></div>');
		redirect(BASE_URL.'journalentry/');
		
	}
}
