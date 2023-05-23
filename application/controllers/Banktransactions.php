<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banktransactions extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('reports_model');
		$this->load->model('costcentre_model');
		$this->load->model('client_model');
		$this->load->helper('url');
		$this->load->library('excel');
	}
	public function index()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';
		if ($usertype == '5') {
			$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
			if ($fclient_id != '') {
				if ($bank_id != '')
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $fclient_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id));
				else
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $fclient_id, 'status' => 1, 'report_type' => 2));
			} else {
				if ($bank_id != '')
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id));
				else
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'status' => 1, 'report_type' => 2));
			}
			$ClientDetails = $this->client_model->getClientDetails();
		} else {
			if ($bank_id != '')
				$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id));
			else
				$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'status' => 1, 'report_type' => 2));
		}
		// echo $this->db->last_query();

		$data = array(
			'view_file' => 'banktransactions/show_banktransactions',
			'current_menu' => 'bk_report',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails' => $ReportDetails,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'fclient_id' => $fclient_id,
			'bank_id' => $bank_id,
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

	public function investigation_data()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';

		$ClientDetails = array();
		if ($usertype == '5') {
			$ClientDetails = $this->client_model->getClientDetails();
		}

		if ($usertype == '5') {
			if ($fclient_id == '') {
				$ReportDetails = $this->reports_model->getDetails('report', array('status' => 2, 'user_id' => $client_id, 'report_type' => 2));
				// echo $this->db->last_query();
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '', 'user_id' => $client_id));
			} else {
				$ReportDetails = $this->reports_model->getDetails('report', array('status' => 2, 'user_id' => $fclient_id, 'report_type' => 2));
				// echo $this->db->last_query();
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '', 'user_id' => $client_id));
			}
		} else {
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'status' => 2, 'report_type' => 2));
			// echo $this->db->last_query();
			$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '', 'user_id' => $client_id));
		}

		$data = array(
			'view_file' => 'banktransactions/investigation_data',
			'current_menu' => 'bk_investigation_data',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails' => $ReportDetails,
			'CostDetails' => $CostDetails,
			//'ParentCost' => $ParentCost,
			//'parent_childcost' => $parent_childcost,
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
	public function analysis_data_month()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;

		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';

		//$fclient_id = '';
		$ClientDetails = array();
		$final_client_id = $client_id;
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}

		if ($usertype == '5') {
			if ($fclient_id != '') {

				$final_client_id = $fclient_id;
			}
		}

		$costcentre_receipts_deposits = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'cl.700.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));
		$costcentre_payments_sundry_creditors = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'ca.320.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));

		// $ReportDetails_month = $this->reports_model->getDetails('report',array('user_id' => $final_client_id,'status' => 1,'report_type' => 2,'bank_id' => $bank_id,'cost_id !=' => ''),'YEAR(report_date) as year_val, MONTH(report_date) as month_val',array('orderby' => 'YEAR(report_date),MONTH(report_date)','disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)'));
		if (isset($costcentre_receipts_deposits, $costcentre_payments_sundry_creditors) && $costcentre_receipts_deposits != "" && $costcentre_payments_sundry_creditors != "") {
			$ReportDetails_month = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id), 'YEAR(report_date) as year_val, MONTH(report_date) as month_val', array('orderby' => 'YEAR(report_date),MONTH(report_date)', 'disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)', 'where_not_in' => array('cost_id ' => array('', $costcentre_receipts_deposits[0]->cost_id, $costcentre_payments_sundry_creditors[0]->cost_id))));
		} else {
			$ReportDetails_month = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id), 'YEAR(report_date) as year_val, MONTH(report_date) as month_val', array('orderby' => 'YEAR(report_date),MONTH(report_date)', 'disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)', 'where_not_in' => array('cost_id ' => array(''))));
		}
		//echo $this->db->last_query();
		// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $final_client_id));

		$data = array(
			'view_file' => 'banktransactions/analysis_data_month',
			'current_menu' => 'bk_analysis_data_month',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails_month' => $ReportDetails_month,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'final_client_id' => $final_client_id,
			'bank_id' => $bank_id,
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
	public function unanalysis_data_month()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;

		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';

		//$fclient_id = '';
		$ClientDetails = array();
		$final_client_id = $client_id;
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}

		if ($usertype == '5') {
			if ($fclient_id != '') {

				$final_client_id = $fclient_id;
			}
		}

		// get dynamic cost centre ids
		$costcentre_receipts_deposits = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'cl.700.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));
		$costcentre_payments_sundry_creditors = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'ca.320.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));


		// $ReportDetails_month = $this->reports_model->getDetails('report',array('user_id' => $final_client_id,'status' => 1,'report_type' => 2,'bank_id' => $bank_id,'cost_id' => ''),'YEAR(report_date) as year_val, MONTH(report_date) as month_val',array('orderby' => 'YEAR(report_date),MONTH(report_date)','disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)'));

		if (isset($costcentre_receipts_deposits, $costcentre_payments_sundry_creditors) && $costcentre_receipts_deposits != "" && $costcentre_payments_sundry_creditors != "") {
			$ReportDetails_month = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id), 'YEAR(report_date) as year_val, MONTH(report_date) as month_val', array('orderby' => 'YEAR(report_date),MONTH(report_date)', 'disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)', 'where_in' => array('cost_id ' => array('', $costcentre_receipts_deposits[0]->cost_id, $costcentre_payments_sundry_creditors[0]->cost_id))));
		} else {
			$ReportDetails_month = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'bank_id' => $bank_id), 'YEAR(report_date) as year_val, MONTH(report_date) as month_val', array('orderby' => 'YEAR(report_date),MONTH(report_date)', 'disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)', 'where_in' => array('cost_id ' => array(''))));
		}
		//echo $this->db->last_query();
		// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $final_client_id));

		$data = array(
			'view_file' => 'banktransactions/unanalysis_data_month',
			'current_menu' => 'bk_unanalysis_data_month',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails_month' => $ReportDetails_month,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'final_client_id' => $final_client_id,
			'bank_id' => $bank_id,
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
	public function analysis_data()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';
		$month = (isset($_GET['month'])) ? $_GET['month'] : date('m');
		$year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
		$ClientDetails = array();
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}

		/*if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $client_id,'report_type' => 2));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			else
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $fclient_id,'report_type' => 2));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $fclient_id));
			}
			
		}
			
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 2));
			$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		}*/


		$final_client_id = $client_id;
		if ($usertype == '5') {
			if ($fclient_id != '') {

				$final_client_id = $fclient_id;
			}
		}

		$costcentre_receipts_deposits = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'cl.700.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));
		$costcentre_payments_sundry_creditors = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'ca.320.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));

		//month(report_date)='".$month."' and year(report_date)='".$year."'

		// if(isset($costcentre_receipts_deposits, $costcentre_payments_sundry_creditors)){
		// 	$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id, 'cost_id !=' => ''));
		// }else{
		// 	$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id, 'cost_id !=' => ''));
		// }

		if (isset($costcentre_receipts_deposits, $costcentre_payments_sundry_creditors) && $costcentre_receipts_deposits != "" && $costcentre_payments_sundry_creditors != "") {
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id), '', array('where_not_in' => array('cost_id ' => array('', $costcentre_receipts_deposits[0]->cost_id, $costcentre_payments_sundry_creditors[0]->cost_id))));
		} else {
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id), '', array('where_not_in' => array('cost_id ' => array(''))));
		}

		$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '', 'user_id' => $final_client_id));



		$data = array(
			'view_file' => 'banktransactions/analysis_data',
			'current_menu' => 'bk_analysis_data',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails' => $ReportDetails,
			'CostDetails' => $CostDetails,
			//'ParentCost' => $ParentCost,
			//'parent_childcost' => $parent_childcost,
			'showtopsave' => 'yeee',
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'final_client_id' => $final_client_id,
			'month_val' => $month,
			'year_val' => $year,
			'bank_id' => $bank_id,
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
	public function unanalysis_data()
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';
		$month = (isset($_GET['month'])) ? $_GET['month'] : date('m');
		$year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
		$ClientDetails = array();
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}

		/*if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $client_id,'report_type' => 2));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			else
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $fclient_id,'report_type' => 2));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $fclient_id));
			}
			
		}
			
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 2));
			$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		}*/


		$final_client_id = $client_id;
		if ($usertype == '5') {
			if ($fclient_id != '') {

				$final_client_id = $fclient_id;
			}
		}

		$costcentre_receipts_deposits = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'cl.700.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));
		$costcentre_payments_sundry_creditors = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'ca.320.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));

		//month(report_date)='".$month."' and year(report_date)='".$year."'
		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $final_client_id,'status' => 1,'report_type' => 2,'month(report_date)' => $month,'year(report_date)' => $year,'bank_id' => $bank_id,'cost_id' => ''));

		if (isset($costcentre_receipts_deposits, $costcentre_payments_sundry_creditors) && $costcentre_receipts_deposits != "" && $costcentre_payments_sundry_creditors != "") {
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id), '', array('where_in' => array('cost_id ' => array('', $costcentre_receipts_deposits[0]->cost_id, $costcentre_payments_sundry_creditors[0]->cost_id))));
		} else {
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $final_client_id, 'status' => 1, 'report_type' => 2, 'month(report_date)' => $month, 'year(report_date)' => $year, 'bank_id' => $bank_id), '', array('where_in' => array('cost_id ' => array(''))));
		}

		$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '', 'user_id' => $final_client_id));



		$data = array(
			'view_file' => 'banktransactions/unanalysis_data',
			'current_menu' => 'bk_unanalysis_data',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'ReportDetails' => $ReportDetails,
			'CostDetails' => $CostDetails,
			//'ParentCost' => $ParentCost,
			//'parent_childcost' => $parent_childcost,
			'showtopsave' => 'yeee',
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'final_client_id' => $final_client_id,
			'month_val' => $month,
			'year_val' => $year,
			'bank_id' => $bank_id,
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

	public function add_banktransactions()
	{

		$ClientDetails = $this->client_model->getClientDetails();
		$usertype = $this->session->usertype;
		$ReportDetail = '';
		$filtered_client_id = $this->session->id;
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';

		$data = array(
			'view_file' => 'banktransactions/add_banktransactions',
			'current_menu' => 'bk_add_report',
			'cusotm_field' => 'add_report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
			'formname' => 'Add',
			'form_action' => 'save_report',
			'user_id' => $filtered_client_id,
			'ReportDetail' => $ReportDetail,
			//'cost_types' => $cost_types,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'bank_id' => $bank_id,
			//'CostDetails' => $CostDetails,
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
	public function edit_banktransactions($report_id = '')
	{
		$filtered_client_id = $this->session->id;
		$ReportDetail = '';
		if ($report_id != '')
			$ReportDetail = $this->reports_model->getDetails('report', array('report_id' => $report_id));

		$ClientDetails = $this->client_model->getClientDetails();
		$usertype = $this->session->usertype;

		$data = array(
			'view_file' => 'banktransactions/add_banktransactions',
			'current_menu' => 'bk_add_report',
			'cusotm_field' => 'add_report',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Report',
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
	public function save_report()
	{
		$user_id = $_POST['user_id'];
		$report_id = $_POST['report_id'];
		$report_date = $_POST['report_date'];
		if ($report_date != '') {
			$report_date1 = explode('/', $report_date);
			$report_date = $report_date1[2] . "-" . $report_date1['1'] . "-" . $report_date1['0'];
		}
		$report_date = date('Y-m-d', strtotime($report_date));
		// $inv_no = $_POST['inv_no'];
		// $ref_no = $_POST['ref_no'];
		$description = $_POST['description'];
		$amount_type = $_POST['amount_type'];
		$tax_type = $_POST['tax_type'];
		$amount = $_POST['amount'];
		//$cost_id = $_POST['cost_id'];
		$status = $_POST['status'];
		$bank_id = $_POST['bank_id'];

		$data_costid = $_POST['data_costid'];
		$cost_arr = explode("-", $data_costid);
		if (!empty($cost_arr)) {
			$category_id = (isset($cost_arr[0])) ? $cost_arr[0] : '';
			$subcategory_id = (isset($cost_arr[1])) ? $cost_arr[1] : '';
			$cost_id = (isset($cost_arr[2])) ? $cost_arr[2] : '';
		} else {
			$category_id = $subcategory_id = $cost_id = '';
		}

		$report_array = array('user_id' => $user_id, 'report_date' => $report_date, 'description' => $description, 'amount_type' => $amount_type, 'tax_type' => $tax_type, 'amount' => $amount, 'status' => $status, 'cost_id' => $cost_id, 'category_id' => $category_id, 'subcategory_id' => $subcategory_id, 'report_type' => 2, 'bank_id' => $bank_id);
		if ($report_id == '') {
			$report_array['created_on'] = date('Y-m-d H:i:s');
			$report_id = $this->reports_model->Insert('report', $report_array);
		} else {
			$where_array = array('report_id' => $report_id);
			$report_array['modified_on'] = date('Y-m-d H:i:s');
			$this->reports_model->Update('report', $report_array, $where_array);
		}

		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Bank Transactions Saved Successfully</span></div>');
		redirect(BASE_URL . 'banktransactions/add_banktransactions?bank_id=' . $bank_id);
	}
	public function delete_report($report_id = '')
	{
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';
		if ($report_id != '') {
			$this->reports_model->Delete('report', array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Selected Bank Transaction Deleted Successfully</span></div>');
		redirect(BASE_URL . 'banktransactions?bank_id=' . $bank_id);
	}

	public function investigate_report($report_id = '')
	{
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';
		if ($report_id != '') {
			$this->reports_model->Update('report', array('status' => '2'), array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Moved selected data to investigation successfully</span></div>');
		redirect(BASE_URL . 'banktransactions?bank_id=' . $bank_id);
	}

	public function saveinvcost()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";
		$cost_details = (isset($_POST['cost_details'])) ? $_POST['cost_details'] : '';
		if ($cost_details) {
			foreach ($cost_details as $cost_detail) {
				$report_id = $cost_detail['report_id'];
				$category_id = $subcategory_id = $cost_id = '';
				$data_costid = $cost_detail['data_costid'];
				if ($data_costid != '') {
					$cost_arr = explode("-", $data_costid);
					$category_id = $cost_arr[0];
					$subcategory_id = $cost_arr[1];
					$cost_id = $cost_arr[2];
				}


				if ($report_id != '') {
					$this->reports_model->Update('report', array('cost_id' => $cost_id, 'category_id' => $category_id, 'subcategory_id' => $subcategory_id), array('report_id' => $report_id));
				}
			}
			$message = "<div class='alert alert-success'>Investigation Cost Saved Successfully</div>";
			$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Investigation Cost Saved Successfully</span></div>');
		} else {
			$message = "<div class='alert alert-danger'>Error in save details</div>";
			$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Error in save details</span></div>');
		}

		echo json_encode(array('message' => $message, 'success' => true));
		exit;
	}
	public function report_invrestore($report_id = '')
	{
		if ($report_id != '') {
			$this->reports_model->Update('report', array('status' => '1'), array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Data restored successfully</span></div>');
		redirect(BASE_URL . 'banktransactions/investigation_data');
	}



	public function import_data()
	{
		$userdata = $this->session->userinfo;
		$bank_id = (isset($_GET['bank_id'])) ? $_GET['bank_id'] : '';

		if ($userdata) {
			$filtered_client_id = $this->session->id;

			$usertype = $this->session->usertype;
			$fclient_id = '';
			$ClientDetails = array();
			if ($usertype == '5') {

				$ClientDetails = $this->client_model->getClientDetails();
			}

			$data = array(
				'view_file' => 'banktransactions/import_data',
				'current_menu' => 'bk_import_data',
				'site_title' => 'Import Data',
				'logo'		=> 'logo',
				'title' => 'Import Datas',
				'ClientDetails' => $ClientDetails,
				'filtered_client_id' => $filtered_client_id,
				'bank_id' => $bank_id,
				'usertype' => $usertype,
				'headerfiles'   => array(
					"css" => array(
						'lib/font-awesome/css/font-awesome.min.css',
						'lib/simple-line-icons/simple-line-icons.min.css',
						'lib/bootstrap/css/bootstrap.min.css',
						'lib/bootstrap-switch/css/bootstrap-switch.min.css',
						'lib/datatables/datatables.min.css',
						'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
						'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
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
						'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
						'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',

					),
					"priority" => 'high'
				)
			);

			$this->template->load_admin_template($data);
		}
	}

	function import_datamaping()
	{
		$data_list = array();
		$client_id = $_POST['client_id'];
		$bank_id = $_POST['bank_id'];
		$this->load->library('excel');
		$this->reports_model->Delete('temp_data', array('client_id' => $client_id));

		if (isset($_FILES['datafile'])) {
			if ($_FILES['datafile']['size'] > 0) {

				$configUpload['upload_path'] = FCPATH . 'uploads/excel/';
				$configUpload['allowed_types'] = 'xls|xlsx|csv';
				$configUpload['max_size'] = '5000';
				$this->load->library('upload', $configUpload);
				$this->upload->do_upload('datafile');
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
				$extension = $upload_data['file_ext'];

				if ($extension == '.xls' || $extension == '.xlsx') {
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					if ($extension == '.xlsx') {
						$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					} else {
						$objReader = PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
					}


					//$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
					$objReader->setReadDataOnly(true);

					$objPHPExcel = $objReader->load(FCPATH . 'uploads/excel/' . $file_name);		 //Load excel file 
					$totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows avalable in excel      	 
					$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);             //loop from first data untill last data
					for ($i = 2; $i <= $totalrows; $i++) {

						$date = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						if ($date != 'Period' && $date != 'DATE' && $date != 'Date') {
							$phpDateTimeObject = PHPExcel_Shared_Date::ExcelToPHPObject($date);
							//$date_value = PHPExcel_Shared_Date::ExcelToPHPObject($date);
							$date_value = $phpDateTimeObject->format('Y-m-d');
						} else {
							$date_value = '';
						}

						//$ref= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
						// if($ref != ''){$ref = $ref;}else {$ref = '';}		
						$desc = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						if ($desc != '') {
							$desc = $desc;
						} else {
							$desc = '';
						}

						$cost = $objWorksheet->getCellByColumnAndRow(2, $i)->getCalculatedValue();
						if ($cost != '') {
							$cost = $cost;
						} else {
							$cost = '';
						}

						$sales = $objWorksheet->getCellByColumnAndRow(3, $i)->getCalculatedValue();
						if ($sales != '') {
							$sales = $sales;
						} else {
							$sales = '';
						}

						$links = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
						if ($links != '') {
							$links = $links;
						} else {
							$links = '';
						}

						/* $tax_type=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
					    if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}*/
						$tax_type = 'tax';

						if ($date != '' && ($cost != '' || $sales  != '' || $links  != '')) {
							$data_list[] = array($date_value, $desc, $cost, $sales, $links);

							$insert_data = array(
								'client_id' => $client_id,
								'date' => $date_value,
								// 'ref' => $ref,
								'details' => $desc,
								'cost' => $cost,
								'sales' => $sales,
								'links' => $links,
								'tax_type' => $tax_type
							);


							$insert_status = $this->reports_model->Insert('temp_data', $insert_data);
						} else {
						}
					}
				} else {
					$fp = fopen($_FILES['datafile']['tmp_name'], 'r') or die("can't open file");
					while ($csv_line = fgetcsv($fp, 1024)) {


						if ($csv_line[0] != '' && $csv_line[1] != '') {
							$data_list[] = $csv_line;

							$date_value = $csv_line[0];
							if ($date_value != '') {
								$date_value = $date_value;
							} else {
								$date_value = '';
							}
							// $ref= $csv_line[1];
							// if($ref != ''){$ref = $ref;}else {$ref = '';}			
							$desc = $csv_line[1];
							if ($desc != '') {
								$desc = $desc;
							} else {
								$desc = '';
							}
							$cost = $csv_line[2];
							if ($cost != '') {
								$cost = $cost;
							} else {
								$cost = '';
							}
							$sales = $csv_line[3];
							if ($sales != '') {
								$sales = $sales;
							} else {
								$sales = '';
							}
							$links = $csv_line[4];
							if ($links != '') {
								$links = $links;
							} else {
								$links = '';
							}
							// $dr=$csv_line[5];

							/*$tax_type=$csv_line[6];
					    if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}*/
							$tax_type = 'Tax invoice';
							$insert_data = array(
								'client_id' => $client_id,
								'date' => $date_value,
								// 'ref' => $ref,
								'details' => $transacion_type,
								'cost' => $cost,
								'sales' => $sales,
								'links' => $links,
								'tax_type' => $tax_type,
							);

							$insert_status = $this->reports_model->InsertTempCash($insert_data);
						}
					}
					fclose($fp) or die("can't close file");
				}
			}
		}

		// echo "<pre>";
		// print_r($data_list);
		// exit;

		$userdata = $this->session->userinfo;
		if ($userdata) {
			$data = array(
				'view_file' => 'banktransactions/import_datamaping',
				'current_menu' => 'import_datamaping',
				'site_title' => 'Import Datas',
				'logo'		=> 'logo',
				'title' => 'Import Datas',
				'data_list' => $data_list,
				'client_id' => $client_id,
				'bank_id' => $bank_id,
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

	public function import_datafilesave()
	{

		if (isset($_POST['db_column']) && isset($_POST['csv_column'])) {
			//$client_id= $this->session->id;
			$client_id = $_POST['client_id'];
			$bank_id = $_POST['bank_id'];
			$temp_details = $this->reports_model->getDetails('temp_data', array('client_id' => $client_id));

			// echo "<pre>";
			// print_r($temp_details);
			// exit;

			// get dynamic cost centre and ids
			$costcentre_receipts_deposits = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'cl.700.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));
			$costcentre_payments_sundry_creditors = $this->reports_model->getDetails('costcentre', array('user_id' => $client_id, 'links' => 'ca.320.000'), '', array('orderby' => 'cost_id', 'disporder' => 'DESC'));

			// echo $this->db->last_query();
			// echo "<pre>";
			// print_r($costcentre_receipts_deposits);
			// print_r($costcentre_payments_sundry_creditors);
			// exit;

			//echo $this->db->last_query();

			$date_index = -1;
			$desc_index = -1;
			$expense_index = -1;
			$sales_index = -1;
			$links_index = -1;
			// $dr_index = -1;
			// $cr_index = -1;
			$tax_type_index = -1;
			//$file_name = 0;
			$dr = 0;
			$cr = 0;

			$db_column = $_POST['db_column'];
			$csv_column = $_POST['csv_column'];
			$array_temp = json_decode(json_encode($temp_details), true);
			$array_values = array_values($array_temp);
			// echo "<pre>";print_r($db_column);echo "</pre>";
			foreach ($db_column as $key => $value) {
				if ($value == 'date') {
					$date_index = $key + 2;
				} else if ($value == 'desc') {
					$desc_index = $key + 3;
				} else if ($value == 'expense') {
					$expense_index = $key + 3;
				} else if ($value == 'sales') {
					$sales_index = $key + 3;
				} else if ($value == 'links') {
					$links_index = $key + 3;
				}
				/*	else if($value == 'tax_type')
				{
					$tax_type_index = $key+6;
				}*/ else {
				}
			}
			if ($date_index != '-1' && $desc_index != '-1' && $expense_index != '-1' && $sales_index != '-1' && $links_index != '-1') {

				// echo "<pre>";print_r($array_temp);echo "</pre>";
				foreach ($array_temp as $key => $values) {

					$array_values22 = array_values($values);
					// echo "date_index = ".$date_index." = desc_index = ".$desc_index." = expense_index = ".$expense_index." = sales_index = ".$sales_index." = tax_type_index = ".$tax_type_index;
					// echo "<pre>";print_r($array_values22);echo "</pre>";
					// 	$tax_type_index = 'tax';
					$date = $array_values22[$date_index];
					// $ref_value = $array_values22[$ref_index];
					$desc = $array_values22[$desc_index];
					$expense = $array_values22[$expense_index];
					$sales = $array_values22[$sales_index];
					$links = $array_values22[$links_index];
					// 	$tax_type = $array_values22[$tax_type_index];

					/*if($tax_type== 'Zero rated'){$tax_type = 'expense';}
					else if($tax_type== 'Exempt'){$tax_type = 'exempt';}
					else {$tax_type = 'tax';}*/
					$tax_type = 'tax';

					if ($date != '' && $date != 'Date' && $date != 'DATE' && $expense != 'Costs/Exp' && $sales != 'Sales' && $desc != 'Description' && $links != 'Links') {

						$date_format = date('Y-m-d', strtotime($date));


						if ($expense != '') {
							$amount_type = 'expense';
							$amount = $expense;
						} else {
							$amount_type = 'sales';
							$amount = $sales;
						}



						// old query :- 
						// $insert_data = array(
						//     'user_id' => $client_id,
						//     'report_date' => $date_format,
						//     // 'ref_no' => $ref_value,
						//     'description' => $desc,
						//     'amount_type' => $amount_type,
						//     'amount' => $amount,
						//     'tax_type' => $tax_type,
						// 	'status' => 1,
						// 	'bank_id' => $bank_id,
						// 	'created_on' => date('Y-m-d H:i:s'),
						// 	'report_type' => 2
						// 	);

						$get_costcentre_data = $this->reports_model->get_costcentre_data($client_id, $links);
						// // echo $this->db->last_query();
						// echo "<pre>";
						// print_r($get_costcentre_data);
						// exit;

						if(isset($get_costcentre_data->cost_id) && $get_costcentre_data->cost_id != "") {
							$insert_data = array(
								'user_id' => $client_id,
								'report_date' => $date_format,
								// 'ref_no' => $ref_value,
								'description' => $desc,
								'amount_type' => $amount_type,
								'amount' => $amount,
								'tax_type' => $tax_type,
								'status' => 1,
								'bank_id' => $bank_id,
								'created_on' => date('Y-m-d H:i:s'),
								'report_type' => 2,
								'cost_id' => $get_costcentre_data->cost_id,
								'category_id' => $get_costcentre_data->category_id,
								'subcategory_id' => $get_costcentre_data->subcategory_id,
							);
						}else{
							// new query
							if (isset($costcentre_receipts_deposits) && is_array($costcentre_receipts_deposits)) {
								if ($amount_type == "sales") {
									$insert_data = array(
										'user_id' => $client_id,
										'report_date' => $date_format,
										// 'ref_no' => $ref_value,
										'description' => $desc,
										'amount_type' => $amount_type,
										'amount' => $amount,
										'tax_type' => $tax_type,
										'status' => 1,
										'bank_id' => $bank_id,
										'created_on' => date('Y-m-d H:i:s'),
										'report_type' => 2,
										'cost_id' => $costcentre_receipts_deposits[0]->cost_id,
										'category_id' => $costcentre_receipts_deposits[0]->category_id,
										'subcategory_id' => $costcentre_receipts_deposits[0]->subcategory_id,
									);
								} else {
									$insert_data = array(
										'user_id' => $client_id,
										'report_date' => $date_format,
										// 'ref_no' => $ref_value,
										'description' => $desc,
										'amount_type' => $amount_type,
										'amount' => $amount,
										'tax_type' => $tax_type,
										'status' => 1,
										'bank_id' => $bank_id,
										'created_on' => date('Y-m-d H:i:s'),
										'report_type' => 2,
										'cost_id' => $costcentre_payments_sundry_creditors[0]->cost_id,
										'category_id' => $costcentre_payments_sundry_creditors[0]->category_id,
										'subcategory_id' => $costcentre_payments_sundry_creditors[0]->subcategory_id,
									);
								}
							} else {
								$insert_data = array(
									'user_id' => $client_id,
									'report_date' => $date_format,
									// 'ref_no' => $ref_value,
									'description' => $desc,
									'amount_type' => $amount_type,
									'amount' => $amount,
									'tax_type' => $tax_type,
									'status' => 1,
									'bank_id' => $bank_id,
									'created_on' => date('Y-m-d H:i:s'),
									'report_type' => 2
								);
							}
						}

						// echo "<pre>";print_r($insert_data);echo "</pre>";

						$insert_status = $this->reports_model->Insert('report', $insert_data);
						// echo "fid".$file_id = $this->db->insert_id();



					}
				}
				// echo "sss";
				// exit;
				$this->reports_model->Delete('temp_data', array('client_id' => $client_id));

				$this->session->set_flashdata('import_data', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Data Imported Successfully</span></div>');
				redirect(BASE_URL . 'banktransactions/import_data?bank_id=' . $bank_id);
			} else {
				echo "noo";
				$this->session->set_flashdata('import_data', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Data import</span></div>');
				redirect(BASE_URL . 'banktransactions/import_data?bank_id' . $bank_id);
			}
		}
	}

	public function cost_group()
	{

		$unallocated_difference = $profit = 0;
		$excel_fname = 'cost_group_report.xls';
		$pdf_fname = 'cost_group_report.pdf';
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_tfoot = array();

		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		$excel_array = array();
		$fclient_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
		$array_count = 7;

		$cost_txt = '';

		$filtered_client_id = $client_id;
		$CostDetails = $this->costcentre_model->getDetails();
		if ($usertype == '5') {
			if ($fclient_id == '') {

				$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'cost_id !=' => '', 'status' => 1, 'report_type' => 2), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id'));
			} else {
				$filtered_client_id = $fclient_id;
				$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $fclient_id, 'cost_id !=' => '', 'status' => 1, 'report_type' => 2), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id'));
			}
			$ClientDetails = $this->client_model->getClientDetails();
		} else {
			// $filtered_client_id = $fclient_id;
			$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $client_id, 'cost_id !=' => '', 'status' => 1, 'report_type' => 2), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id'));
		}


		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_client_name = $cdetl->name;
			}
		}


		$cost_txt = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Bank Transaction Financial Statement </p><br></div><div class="col-md-12">';


		$CostDetails_arr = array();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$previous_child = '';
		$next_child = '';
		$loop_start = 0;
		if ($ReportDetails) {
			$total_amount = 0;

			foreach ($ReportDetails as $ReportDetail) {

				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$amount = $ReportDetail->total_amount;
				$amount = number_format((float)$amount, 2, '.', '');
				$cost_name = $links = '';
				if ($cost_id != '') {
					$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
					if ($catcost) {
						foreach ($catcost as $ctcost) {
							$cost_name = $ctcost->cost_name;
							$links = $ctcost->links;
						}
					}
				}

				if ($next_child != '' && $next_child != $subcategory_id) {

					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;

					$cost_txt .= "</tbody><tfoot><tr><td colspan='2'>Total Cost</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
					$excel_array[] = array('Total Cost', '', $oformat_amount_xl);
					$excel_array[] = array('', '', '');
					$excel_array[] = array('', '', '');


					$excel_tfoot[] = $excel_arrcount;
					$excel_arrcount += 3;
				}

				if ($previous_child == '' || $previous_child != $subcategory_id) {
					$total_amount = 0;
					$childcost = $CostDetails_arr[$subcategory_id];
					$previous_child = $subcategory_id;
					$next_child = $subcategory_id;
					$child_costname = $childcost->cost_name;

					$excel_array[] = array($child_costname, '', '');
					$excel_array[] = array('', '', '');
					$excel_array[] = array('Cost Name', 'Links', 'Amount');
					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;
					$cost_txt .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>" . $child_costname . "</p><table class='table table-striped table-hover stl_costtbl' style='width:100%;'><thead><tr><th style='width:60%;'>Cost Name</th><th style='width:15%;'>Links</th><th style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
				}
				$total_amount += (float)$amount;
				$oformat_amount = "R" . number_format((float)$amount, 2);
				$oformat_amount_xl = $amount;


				if ($subcategory_id == '5') {
					$unallocated_difference += (float)$amount;
					$cr_amt = '';
					$dr_amount = $amount;
				} //Current Asset
				else if ($subcategory_id == '6') {
					$unallocated_difference -= (float)$amount;
					$cr_amt = $amount;
					$dr_amount = '';
				} //Current Liabilities
				else if ($subcategory_id == '7') {
					$unallocated_difference += (float)$amount;
					$cr_amt = '';
					$dr_amount = $amount;
				} //Non-Curent Asset
				else if ($subcategory_id == '8') {
					$unallocated_difference -= (float)$amount;
					$cr_amt = $amount;
					$dr_amount = '';
				} //Non-Current Liabilities
				else if ($subcategory_id == '9') {
					$unallocated_difference -= (float)$amount;
					$cr_amt = $amount;
					$dr_amount = '';
				} //Equity
				else if ($subcategory_id == '10') {
					$profit += (float)$amount;
					$cr_amt = $amount;
					$dr_amount = '';
				} //Sales
				else if ($subcategory_id == '70') {
					$profit -= (float)$amount;
					$cr_amt = '';
					$dr_amount = $amount;
				} //Cost of Sales
				else if ($subcategory_id == '71') {
					$profit -= (float)$amount;
					$cr_amt = '';
					$dr_amount = $amount;
				} //Expenses



				$cost_txt .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td style='text-align:right;'>" . $oformat_amount . "</td></tr>";

				$excel_array[] = array($cost_name, $links, $oformat_amount_xl);
				$excel_arrcount++;
				$array_count++;
			}

			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt .= "</tbody><tfoot><tr><td colspan='2'>Total Cost</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_tfoot[] = $excel_arrcount;

			$ounallocated_difference = "R" . number_format((float)$unallocated_difference, 2);
			$oprofit = "R" . number_format((float)$profit, 2);
			$cost_txt .= "<p><b>Unallocated Difference: </b>" . $ounallocated_difference . "</p>";
			$cost_txt .= "<p><b>Profit: </b>" . $oprofit . "</p>";


			$excel_array[] = array('Total Cost', '', $oformat_amount_xl);
			$excel_array[] = array('', '', '');
			$excel_array[] = array('', '', '');
			$excel_array[] = array('Unallocated Difference', '', $unallocated_difference);
			$excel_array[] = array('Profit', '', $profit);

			$excel_tfoot[] = $excel_arrcount;
			$excel_arrcount += 3;
			$excel_tfoot[] = $excel_arrcount;
			$excel_arrcount++;
			$excel_tfoot[] = $excel_arrcount;
			$excel_arrcount++;
		}



		// echo "<pre>";print_r($excele_tablearr);echo "</pre>";
		// echo "<pre>";print_r($excel_array);echo "</pre>";

		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		$this->excel->getActiveSheet()->setCellValue('A2', 'Bank Transaction Financial Statement');
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->mergeCells('A2:E2');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);



		for ($col = ord('E'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		foreach ($excel_titlearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setSize(13);
		}

		foreach ($excele_tablearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('507682');
		}
		foreach ($excel_tfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}



		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);


		/********************* EXCEL End ********/

		/********************* PDF start ********/

		$this->load->library('m_pdf');


		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('costgroup_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/


		$data = array(
			'view_file' => 'banktransactions/cost_group',
			'current_menu' => 'bk_cost_group',
			'cusotm_field' => 'cost_group',
			'site_title' => 'eShiro',
			'logo'		=> 'logo',
			'title' => 'Cost grouped data',
			'CostDetails' => $CostDetails_arr,
			'ReportDetails' => $ReportDetails,
			'cost_txt' => $cost_txt,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			'fclient_id' => $fclient_id,
			'excel_fname' => $excel_fname,
			'pdf_fname' => $pdf_fname,
			'headerfiles'   => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
					'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
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
					'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
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
	/************************************* stal Arul *****************************/
	/***************** function coied from reports file*****************/
	public function ajax_bankstat()
	{

		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_GET['client_id'];
		$bank_id =  $_GET['bank_id'];

		$year = $_GET['year'];
		$inputh_year = $year;
		$years = explode("-", $year);


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		//print_r($years);
		if ($years[0] != '' && $years[1] != '') {
			$year_start = $years[0];
			$year_end = $years[1];
			for ($month = $filtered_start_month; $month <= 12; $month++) {

				$date = $year_start . "-" . $month . "-01";
				$full_details[$date] = $this->bankstat_arrayfun($month, $year_start, $filtered_client_id, $bank_id);
			}
			for ($month = 1; $month <= $filtered_end_month; $month++) {
				$date = $year_end . "-" . $month . "-01";

				$full_details[$date] = $this->bankstat_arrayfun($month, $year_end, $filtered_client_id, $bank_id);
			}

			$start_date = $year_start . "-" . $filtered_start_month . "-01";
		}

		// $CRDetails = $this->reports_model->total_cr($start_date,$filtered_client_id);
		// $DRDetails = $this->reports_model->total_dr($start_date,$filtered_client_id);
		// // echo "<pre>";print_r($full_details);echo "</pre>";exit;
		// $total_cr = $total_dr = 0;
		// if($CRDetails)
		// {
		// 	$total_cr = $CRDetails->total_cr;
		// }
		// if($DRDetails)
		// {
		// 	$total_dr = $DRDetails->total_dr;
		// }
		// $opening_balancee = $total_cr-$total_dr;

		$table_count = 7;
		//$table_count = 0;
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Bank Statement');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		$this->excel->getActiveSheet()->setCellValue('A2', 'Bank Statement');
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		$this->excel->getActiveSheet()->setCellValue('A5', '');
		$this->excel->getActiveSheet()->setCellValue('A6', '');
		$this->excel->getActiveSheet()->setCellValue('A7', 'Bank Statement');

		$this->excel->getActiveSheet()->mergeCells('A1:G1');
		$this->excel->getActiveSheet()->mergeCells('A2:G2');
		$this->excel->getActiveSheet()->mergeCells('A3:G3');
		$this->excel->getActiveSheet()->mergeCells('A7:G7');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(10);

		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);



		$cbd_txt = '<input type="hidden" class="inputh_year" value="' . $inputh_year . '"><table style="width:100%"><thead><tr><td style="border:0px"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Bank Statement </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></td></tr></thead><tbody><tr><td style="border:0px;">';

		//echo '<pre>';print_R($full_details); echo '</pre>';
		if ($full_details) {

			foreach ($full_details as $key => $value) {
				$balance_total = 0;

				$title_date = date('F-Y', strtotime($key));
				$all_val = $value['all'];
				$open_val = $value['open'];
				$balance_total = $open_val;
				if (!empty($all_val)) {
					if ($table_count == '7')
						$table_count = $table_count + 1;
					else
						$table_count = $table_count + 7;

					$this->excel->getActiveSheet()->setCellValue('A' . $table_count, $title_date);
					$this->excel->getActiveSheet()->mergeCells('A' . $table_count . ':G' . $table_count);
					$this->excel->getActiveSheet()->getStyle('A' . $table_count)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('A' . $table_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('A' . $table_count)->getFont()->setSize(10);

					$table_count = $table_count + 1;

					$this->excel->getActiveSheet()->setCellValue('A' . $table_count, 'Report Date');
					$this->excel->getActiveSheet()->setCellValue('B' . $table_count, 'Description');
					$this->excel->getActiveSheet()->setCellValue('C' . $table_count, 'DR');
					$this->excel->getActiveSheet()->setCellValue('D' . $table_count, 'CR');
					$this->excel->getActiveSheet()->setCellValue('E' . $table_count, 'Balance');

					$this->excel->getActiveSheet()->getStyle('A' . $table_count)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('B' . $table_count)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('C' . $table_count)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('D' . $table_count)->getFont()->setBold(true);
					$this->excel->getActiveSheet()->getStyle('E' . $table_count)->getFont()->setBold(true);


					$cbd_txt .= "<p style='font-weight: bold;text-align: center;font-size:13px;margin: 10px 0px 15px;'>" . $title_date . "</p>";

					$cbd_txt .= "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><td>Report Date</td><td>Description</td><td>DR</td><td>CR</td><td>Balance</td></tr></thead>";

					$opening_balancee_of = "R" . number_format((float)$open_val, 2);
					//$opening_balancee_xl = $open_val;
					$cbd_txt .= "<tr><td></td><td>Opening Balance</td><td>" . $opening_balancee_of . "</td><td></td><td>" . $opening_balancee_of . "</td></tr>";

					$table_count++;
					$this->excel->getActiveSheet()->setCellValue('A' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('B' . $table_count, 'Opening Balance');
					$this->excel->getActiveSheet()->setCellValue('C' . $table_count, $open_val);
					$this->excel->getActiveSheet()->setCellValue('D' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('E' . $table_count, $open_val);


					if (!empty($all_val)) {
						foreach ($all_val as $akey => $avalue) {

							$table_count++;

							$adate = $avalue->report_date;
							$description = $avalue->description;
							$amount_type = $avalue->amount_type;
							$aamount = $avalue->amount;
							$report_type = $avalue->report_type;
							$ledger_type = $avalue->ledger_type;

							$cr_amount = '';
							$dr_amount = '';
							$cr_amount_xl = '';
							$dr_amount_xl = '';
							$aamount = (float) $aamount;

							$adate_new = date('d-M-Y', strtotime($adate));

							$oformat_amount_xl = '0';
							if ($aamount != '') {
								//$oformat_amount = "R".money_format('%!i', $aamount) ;
								$oformat_amount = "R" . number_format((float)$aamount, 2);
								//$oformat_amount_xl = number_format((float)$aamount, 2);
								$oformat_amount_xl = $aamount;
							} else
								$oformat_amount = 0;


							if ($amount_type == 'expense') {
								$cr_amount = $oformat_amount;
								$cr_amount_xl = $oformat_amount_xl;
								$balance_total -= $aamount;
							} else {
								$dr_amount = $oformat_amount;
								$dr_amount_xl = $oformat_amount_xl;
								$balance_total += $aamount;
							}

							$balance_total_amt = number_format((float)$balance_total, 2);


							$cbd_txt .= "<tr><td>" . $adate_new . "</td><td>" . $description . "</td><td>" . $dr_amount . "</td><td>" . $cr_amount . "</td><td>R" . $balance_total_amt . "</td></tr>";



							$this->excel->getActiveSheet()->setCellValue('A' . $table_count, $adate_new);
							$this->excel->getActiveSheet()->setCellValue('B' . $table_count, $description);
							$this->excel->getActiveSheet()->setCellValue('C' . $table_count, $dr_amount_xl);
							$this->excel->getActiveSheet()->setCellValue('D' . $table_count, $cr_amount_xl);
							$this->excel->getActiveSheet()->setCellValue('E' . $table_count, $balance_total);
						}
					}


					$cbd_txt .= "<tr><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>R" . $balance_total_amt . "</td><tr>";

					$table_count++;

					$this->excel->getActiveSheet()->setCellValue('A' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('B' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('C' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('D' . $table_count, '');
					$this->excel->getActiveSheet()->setCellValue('E' . $table_count, $balance_total);
					$this->excel->getActiveSheet()->getStyle('E' . $table_count)->getFont()->setBold(true);
					$cbd_txt .= "</table>";
				}


				for ($col = ord('C'); $col <= ord('E'); $col++) {
					$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				for ($col = ord('C'); $col <= ord('E'); $col++) {
					$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
				}
			}
		}
		$cbd_txt .= "</td></tr></tbody></table>";

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

		$objWriter->save(FCPATH . 'uploads/bankstat_list.xls');
		echo $cbd_txt;
		exit();
	}
	public function bankstat_arrayfun($month, $year_start, $filtered_client_id, $bank_id)
	{
		$array_merge = [];
		$MonthDetails = $this->reports_model->bankstat_montdetails_new($month, $year_start, $filtered_client_id, $bank_id);
		// echo $this->db->last_query();
		$start_date = $year_start . "-" . $month . "-01";
		$CRDetails = $this->reports_model->total_cr_new($start_date, $filtered_client_id, $bank_id);
		$DRDetails = $this->reports_model->total_dr_new($start_date, $filtered_client_id, $bank_id);
		// echo "<pre>";print_r($CRDetails);echo "</pre>";exit;
		$total_cr = $total_dr = 0;
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		if ($DRDetails) {
			$total_dr = $DRDetails->total_dr;
		}
		// $opening_balancee = $total_cr-$total_dr;
		$opening_balancee = $total_dr - $total_cr;


		// $array_merge['open'] = $opening_balancee;
		// $OpenBalDetails = $this->reports_model->getCashOpenbalDetails($month,$year_start,$filtered_client_id);
		$array_merge['open'] = $opening_balancee;
		$array_merge['all'] = $MonthDetails;

		return $array_merge;
		//echo "<pre>";print_r($MonthDetails);echo"</pre>";
	}

	public function bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id)
	{
		$array_merge = [];
		// $start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr_new_costid($start_date, $filtered_client_id, $cost_id);
		// echo $this->db->last_query();
		$DRDetails = $this->reports_model->total_dr_new_costid($start_date, $filtered_client_id, $cost_id);
		$total_cr = $total_dr = 0;
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		if ($DRDetails) {
			$total_dr = $DRDetails->total_dr;
		}
		// echo "total_dr = ".$total_dr." = total_cr = ".$total_cr."<br>";
		// $opening_balancee = $total_dr+$total_cr;
		$opening_balancee = $total_cr - $total_dr;



		return $opening_balancee;
	}
	public function bankstat_openingbanlance($start_date, $filtered_client_id)
	{
		$array_merge = [];
		// $start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr_new($start_date, $filtered_client_id);
		$DRDetails = $this->reports_model->total_dr_new($start_date, $filtered_client_id);
		$total_cr = $total_dr = 0;
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		if ($DRDetails) {
			$total_dr = $DRDetails->total_dr;
		}
		// echo "total_cr = ".$total_cr." = total_dr = ".$total_dr."<br>";
		$opening_balancee = $total_dr - $total_cr;



		return $opening_balancee;
	}
	public function bankstat_openingbanlance_bank($start_date, $filtered_client_id, $bank_id)
	{
		$array_merge = [];
		// $start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr_new($start_date, $filtered_client_id, $bank_id);
		$DRDetails = $this->reports_model->total_dr_new($start_date, $filtered_client_id, $bank_id);
		$total_cr = $total_dr = 0;
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		if ($DRDetails) {
			$total_dr = $DRDetails->total_dr;
		}
		// echo "total_cr = ".$total_cr." = total_dr = ".$total_dr."<br>";
		$opening_balancee = $total_dr - $total_cr;



		return $opening_balancee;
	}


	public function bankstat_pdf()
	{


		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_GET['client_id'];

		$year = $_GET['year'];
		$inputh_year = $year;
		$years = explode("-", $year);


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		if ($years[0] != '' && $years[1] != '') {
			$year_start = $years[0];
			$year_end = $years[1];
			for ($month = $filtered_start_month; $month <= 12; $month++) {

				$date = $year_start . "-" . $month . "-01";
				$full_details[$date] = $this->bankstat_arrayfun($month, $year_start, $filtered_client_id);
			}
			for ($month = 1; $month <= $filtered_end_month; $month++) {
				$date = $year_end . "-" . $month . "-01";

				$full_details[$date] = $this->bankstat_arrayfun($month, $year_end, $filtered_client_id);
			}
		}
		// echo "<pre>";print_r($full_details);echo "</pre>";exit;

		$table_count = 7;


		$cbd_txt_pdf = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Bank Statement </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';


		if ($full_details) {

			foreach ($full_details as $key => $value) {
				$balance_total = 0;
				$title_date = date('F-Y', strtotime($key));
				$open_val = $value['open'];
				$all_val = $value['all'];
				$balance_total = $open_val;
				if (!empty($all_val)) {

					if ($table_count == '7')
						$table_count = $table_count + 1;
					else
						$table_count = $table_count + 7;


					$cbd_txt_pdf .= "<p style='font-weight: bold;text-align: center;font-size:13px;margin: 10px 0px 15px;'>" . $title_date . "</p>";
					$cbd_txt_pdf .= "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><td>Report Date</td><td>Description</td><td>Dr</td><td>Cr</td><td>Balance</td></tr></thead>";
					$opening_balancee_of = "R" . number_format((float)$open_val, 2);
					//$opening_balancee_xl = $open_val;
					$cbd_txt_pdf .= "<tr><td></td><td>Opening Balance</td><td>" . $opening_balancee_of . "</td><td></td><td>" . $opening_balancee_of . "</td></tr>";

					if (!empty($all_val)) {
						foreach ($all_val as $akey => $avalue) {

							$table_count++;

							$adate = $avalue->report_date;
							$description = $avalue->description;
							$amount_type = $avalue->amount_type;
							$aamount = $avalue->amount;
							$cr_amount = '';
							$dr_amount = '';
							$cr_amount_xl = '';
							$dr_amount_xl = '';
							$aamount = (float) $aamount;
							$adate_new = date('d-M-Y', strtotime($adate));

							$oformat_amount_xl = '0';
							if ($aamount != '') {
								$oformat_amount = "R" . number_format((float)$aamount, 2);
								$oformat_amount_xl = $aamount;
							} else
								$oformat_amount = 0;

							if ($amount_type == 'expense') {
								$cr_amount = $oformat_amount;
								$cr_amount_xl = $oformat_amount_xl;
								$balance_total -= $aamount;
							} else {
								$dr_amount = $oformat_amount;
								$dr_amount_xl = $oformat_amount_xl;
								$balance_total += $aamount;
							}

							$balance_total_amt = number_format((float)$balance_total, 2);

							$cbd_txt_pdf .= "<tr><td>" . $adate_new . "</td><td>" . $description . "</td><td>" . $dr_amount . "</td><td>" . $cr_amount . "</td><td>R" . $balance_total_amt . "</td></tr>";
						}
					}

					$cbd_txt_pdf .= "<tr><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>R" . $balance_total_amt . "</td><tr>";
					$table_count++;

					$cbd_txt_pdf .= "</table>";
				}
			}
		}

		$cbd_txt_pdf .= "</div>";


		$data = array(
			'view_file' => 'bankstat_list_pdf',
			'cbd_txt_pdf' => $cbd_txt_pdf,
		);

		// Load all views as normal
		$this->load->view('bankstat_list_pdf', $data);
		// Get output html
		$html = $this->output->get_output();

		// Load library
		$this->load->library('dompdf_gen');

		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 600, 600), "portrait");
		$this->dompdf->render();

		$output = $this->dompdf->output();
		file_put_contents(FCPATH . 'uploads/bankstat_list.pdf', $output);

		echo json_encode(array('message' => 'success'));
		exit();
	}
	/************************************* end stal Arul cpoied from reports files*****************************/
	public function ajax_ledger_new()
	{
		setlocale(LC_MONETARY, 'en_IN');
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;
		// $bankstatement_cost_link_arr = unserialize(BANKSTATEMENT_COST_LINK_ARRAY);
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		$current_year_cids = array();

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_ledger';
			$ledger_title = 'Invoicing Ledger';
			$ledger_menu = 'invoice_ledger';
		} else {
			$report_url = 'banktrans_ledger';
			$ledger_title = "Bank Transaction Ledger";
			$ledger_menu = 'banktrans_ledger';
		}
		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();
		if (is_array($bank_accounts)) :
			foreach ($bank_accounts as $bank_account) {
				$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
			}
		endif;

		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		// $end_date = date('Y-m-d', strtotime("+11 months", strtotime($start_date)));
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));


		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		// echo "<pre>"; print_r( $opening_balancee_data);

		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc', 'custom_where' => '((report_type="3" and ledger_type="2" ) or report_type = "2")'));

		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = $cost_txt_bankstatement  = $cost_txt_other = '';
		$next_child = '';
		$excel_arr_sales = array();
		$excel_arr_sales = array();
		$expense_arr_expose = array();
		$loop_start = $array_count = 0;
		$sales_balance = 0;
		$loop_start = $array_count = 0;
		$cost_txt_bankstatement = '';
		$sales_total = $actrev_total =  $balance = 0;
		$sales_total = $expense_total = $actrev_total = $bstatement_total = $balance = 0;
		$bank_kk = 0;

		if ($ReportDetails) {
			foreach ($ReportDetails as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$bank_id = $ReportDetail->bank_id;
				// $td_color = (isset($bank_arr[$bank_id]))?$bank_arr[$bank_id]:'#000';
				$td_color = '#000';
				$cost_name = $links = '';
				if ($cost_id != '' && $cost_id > 0 && $cost_id != $bankstatement_cost_id) {
					$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
					// echo "<pre>"; print_r($catcost); 
					if ($catcost) {
						foreach ($catcost as $ctcost) {
							$cost_name = $ctcost->cost_name;
							$links = $ctcost->links;
						}
					}
					if ($next_child != '' && $next_child != $cost_id) {
						$oformat_amount = "R" . number_format((float)$total_amount, 2);
						$oformat_amount_xl = $total_amount;
						$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
						$excel_array[] = array('', '', '', '', '', '');
						$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
						$excel_array[] = array('', '', '', '', '', '');
						$excel_array[] = array('', '', '', '', '', '');
					}
					if ($previous_child == '' || $previous_child != $cost_id) {
						$current_year_cids[] = $cost_id;
						$total_amount = 0;
						$balance = 0;
						$childcost = $CostDetails_arr[$cost_id];
						$previous_child = $cost_id;
						$next_child = $cost_id;
						$child_costname = $childcost->cost_name;
						$category_id = $ReportDetail->category_id;
						//$links = $childcost->links;
						// echo "<pre>"; print_r($child_costname) ;
						$excel_array[] = array($child_costname, '', '');
						$excel_array[] = array('', '', '');
						$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');
						$cost_txt_other .= "<center><h3>" . $child_costname ."<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
						if ($category_id == '2' || $category_id == '3') {


							$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
							$sales_total_ss = (float)$opening_balancee_ss;
							$total_amount = (float)$opening_balancee_ss;
							$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
							$sales_total_txt_ss = "R" . number_format((float)$sales_total_ss, 2);
							$cost_txt_other .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'></td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $sales_total_txt_ss . "</td></tr>";
							$excel_array[] = array('', '', 'Opening Balance', $open_amt_ss, '', $sales_total_txt_ss);
						}
					}

					if ($report_type == "3" && $ledger_type == "2") {
						if ($amount_type == 'expense') {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
							$excel_array[] = array($report_date, $ref_no, $description, '', $amount, $balance);
						} else {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
							$excel_array[] = array($report_date, $ref_no, $description, $amount, '', $balance);
						}
					} else {
						
						if ($amount_type == 'sales') {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
							$excel_array[] = array($report_date, $ref_no, $description, '', $amount, $balance);
						} else {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
							$excel_array[] = array($report_date, $ref_no, $description, $amount, '', $balance);

						}
					}
					$cost_txt_other .= "<tr  style='color:" . $td_color . "'><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";
				// print_r($cost_txt_other);
				}
				$array_count++;
			}

			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', '');
		}

		// echo "<pre>";print_r($current_year_cids);echo "</pre>";
		$current_ids = implode(',', $current_year_cids);
		$ReportDetails_previous = $this->reports_model->getLegerBKPreviousCostid($current_ids, $filtered_client_id, $start_date);
		// echo "<pre>"; print_r($ReportDetails_previous);   die;
		// echo  $this->db->last_query();
		if ($ReportDetails_previous) {
			foreach ($ReportDetails_previous as $ReportDetails_prev) {
				$cost_id = $ReportDetails_prev->cost_id;
				$childcost = $CostDetails_arr[$cost_id];
				$child_costname = $childcost->cost_name;
				$category_id = $ReportDetails_prev->category_id;
				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}

				$excel_array[] = array($child_costname, '', '');
				$excel_array[] = array('', '', '');
				$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');
				$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
				// if($category_id == '2')
				// {


				$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
							// echo "<pre>"; print_r($opening_balancee_ss); 

				$sales_total_ss = (float)$opening_balancee_ss;
				$total_amount = (float)$opening_balancee_ss;
				$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
				$open_amt_ss_xl = "R" . number_format((float)$opening_balancee_ss, 2);
				$cost_txt_other .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'></td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $open_amt_ss . "</td></tr>";
				$excel_array[] = array('', '', 'Opening Balance', $open_amt_ss_xl, '', $open_amt_ss_xl);
				// $oformat_amount = "R".number_format((float)$total_amount, 2);
				// $oformat_amount_xl = $total_amount;
				$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $open_amt_ss_xl . "</td></tr></tfoot></table>";
				$excel_array[] = array('', '', '', '', '', '');
				$excel_array[] = array('', '', '', '', '', $open_amt_ss_xl);
				$excel_array[] = array('', '', '', '', '', '');
				$excel_array[] = array('', '', '', '', '', '');

				// }
			}
		}

		$excel_array = array_merge($excel_arr_sales, $excel_array);
		// echo "<pre>";print_r($excel_array);echo "</pre>";

		$cost_txt = $cost_txt . $cost_txt_bankstatement . $cost_txt_other;
		
		$excel_fname = 'ledger_report.xls';
		$pdf_fname = 'ledger_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Ledger');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('D'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);
		// die;
		echo $cost_txt;
		exit();
	}
	public function ajax_ledger_new_pdf()
	{
		setlocale(LC_MONETARY, 'en_IN');
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$current_year_cids = array();
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_ledger';
			$ledger_title = 'Invoicing Ledger';
			$ledger_menu = 'invoice_ledger';
		} else {
			$report_url = 'banktrans_ledger';
			$ledger_title = "Bank Transaction Ledger";
			$ledger_menu = 'banktrans_ledger';
		}
		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();
		foreach ($bank_accounts as $bank_account) {
			$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));


		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '( report_type = "2")'));
		// echo $this->db->last_query();

		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc', 'custom_where' => '((report_type="3" and ledger_type="2" ) or report_type = "2")'));

		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = $cost_txt_bankstatement  = $cost_txt_other = '';
		$next_child = '';
		$excel_arr_sales = array();
		$excel_arr_sales = array();
		$expense_arr_expose = array();
		$loop_start = $array_count = 0;
		$sales_balance = 0;
		$loop_start = $array_count = 0;
		$cost_txt_bankstatement = '';
		$sales_total = $actrev_total =  $balance = 0;
		$sales_total = $expense_total = $actrev_total = $bstatement_total = $balance = 0;
		$bank_kk = 0;
		foreach ($bank_arr as $key => $bval) {
			$sales_total = 0;
			$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'bank_id' => $key, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
			if ($ReportDetails_bank) {
				$total_amount = 0;
				/**************** arul ->bank statement **************************/
				// $bankstatement_cost_head = $bankstatement_cost_name."(".$bankstatement_cost_link.")";
				$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link_arr[$bank_kk] . ")";
				$bank_kk++;


				/**************** arul ->bank statement **************************/
				$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";


				$sales_total += (float)$opening_balancee_data;
				$open_amt = "R" . number_format((float)$opening_balancee_data, 2);
				$sales_total_txt = "R" . number_format((float)$sales_total, 2);
				$cost_txt_bankstatement .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $sales_total_txt . "</td></tr>";


				foreach ($ReportDetails_bank as $ReportDetail) {
					$report_id = $ReportDetail->report_id;
					$cost_id = $ReportDetail->cost_id;
					$subcategory_id = $ReportDetail->subcategory_id;
					$cost_id = $ReportDetail->cost_id;
					$amount = $ReportDetail->amount;
					$description = $ReportDetail->description;
					$amount_type = $ReportDetail->amount_type;
					$report_date = $ReportDetail->report_date;
					$report_date = date('d-M-Y', strtotime($report_date));
					$ref_no = $ReportDetail->ref_no;
					$amount = number_format((float)$amount, 2, '.', '');
					$report_type = $ReportDetail->report_type;
					$ledger_type = $ReportDetail->ledger_type;
					$cost_name = $links = '';
					if ($amount_type == 'sales') {
						$sales_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$sales_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$totalfinalsales = $sales_total;
					}
					if ($amount_type == 'expense') {
						$sales_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$sales_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
					}
				}
				$oformat_amount = "R" . number_format((float)$sales_total, 2);
				$oformat_amount_xl = $sales_total;




				$oformat_sales_total = "R" . number_format((float)$sales_total, 2);
				$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_sales_total . "</td></tr></tfoot></table>";
			}
		}
		if ($ReportDetails) {
			foreach ($ReportDetails as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$bank_id = $ReportDetail->bank_id;
				$td_color = (isset($bank_arr[$bank_id])) ? $bank_arr[$bank_id] : '#000';
				$cost_name = $links = '';
				if ($cost_id != '' && $cost_id > 0 && $cost_id != $bankstatement_cost_id) {
					$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
					if ($catcost) {
						foreach ($catcost as $ctcost) {
							$cost_name = $ctcost->cost_name;
							$links = $ctcost->links;
						}
					}
					if ($next_child != '' && $next_child != $cost_id) {
						$oformat_amount = "R" . number_format((float)$total_amount, 2);
						$oformat_amount_xl = $total_amount;
						$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
					}
					if ($previous_child == '' || $previous_child != $cost_id) {
						$total_amount = 0;
						$balance = 0;
						$childcost = $CostDetails_arr[$cost_id];
						$previous_child = $cost_id;
						$next_child = $cost_id;
						$child_costname = $childcost->cost_name;
						$category_id = $ReportDetail->category_id;
						//$links = $childcost->links;
						$current_year_cids[] = $cost_id;

						$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
						if ($category_id == '2') {


							$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
							$sales_total_ss = (float)$opening_balancee_ss;
							$total_amount = (float)$opening_balancee_ss;
							$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
							$sales_total_txt_ss = "R" . number_format((float)$sales_total_ss, 2);
							$cost_txt_other .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt_ss . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $sales_total_txt_ss . "</td></tr>";
							$excel_array[] = array('', '', 'Opening Balance', $open_amt_ss, '', $sales_total_txt_ss);
						}
					}
					if ($report_type == "3" && $ledger_type == "2") {
						if ($amount_type == 'expense') {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
						} else {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
						}
					} else {
						if ($amount_type == 'sales') {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
						} else {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
						}
					}
					$cost_txt_other .= "<tr><td style='color:" . $td_color . "'>" . $report_date . "</td><td style='color:" . $td_color . "'>" . $ref_no . "</td><td style='color:" . $td_color . "'>" . $description . "</td><td  style='text-align:right;color:" . $td_color . "'>" . $dr_amount . "</td><td  style='text-align:right;color:" . $td_color . "'>" . $cr_amount . "</td><td  style='text-align:right;color:" . $td_color . "'>" . $balance . "</td></tr>";
				}
				$array_count++;
			}

			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
		}

		$current_ids = implode(',', $current_year_cids);
		$ReportDetails_previous = $this->reports_model->getLegerBKPreviousCostid($current_ids, $filtered_client_id, $start_date);
		// echo  $this->db->last_query();
		if ($ReportDetails_previous) {
			foreach ($ReportDetails_previous as $ReportDetails_prev) {
				$cost_id = $ReportDetails_prev->cost_id;
				$childcost = $CostDetails_arr[$cost_id];
				$child_costname = $childcost->cost_name;
				$category_id = $ReportDetails_prev->category_id;
				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}

				$excel_array[] = array($child_costname, '', '');
				$excel_array[] = array('', '', '');
				$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');
				$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
				// if($category_id == '2')
				// {


				$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
				$sales_total_ss = (float)$opening_balancee_ss;
				$total_amount = (float)$opening_balancee_ss;
				$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
				$open_amt_ss_xl = number_format((float)$opening_balancee_ss, 2);
				$cost_txt_other .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt_ss . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $open_amt_ss . "</td></tr>";
				// $excel_array[] = array( '', '' , 'Opening Balance',$open_amt_ss_xl,'',$open_amt_ss_xl);
				// $oformat_amount = "R".number_format((float)$total_amount, 2);
				// $oformat_amount_xl = $total_amount;
				$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $open_amt_ss . "</td></tr></tfoot></table>";


				// }
			}
		}

		$excel_array = array_merge($excel_arr_sales, $excel_array);
		$cost_txt = $cost_txt . $cost_txt_bankstatement . $cost_txt_other;
		$pdf_fname = 'ledger_report.pdf';


		/********************* PDF start ********/

		$this->load->library('m_pdf');


		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}
	/************************* arul edited bank transactionledger***************/
	public function ajax_ledger_new_viji()
	{
		setlocale(LC_MONETARY, 'en_IN');
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_ledger';
			$ledger_title = 'Invoicing Ledger';
			$ledger_menu = 'invoice_ledger';
		} else {
			$report_url = 'banktrans_ledger';
			$ledger_title = "Bank Transaction Ledger";
			$ledger_menu = 'banktrans_ledger';
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc', 'custom_where' => '(report_type="3" or report_type = "2")'));
		//   echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = $cost_txt_bankstatement  = $cost_txt_other = '';
		$next_child = '';
		$excel_arr_sales = array();
		$excel_arr_sales = array();
		$expense_arr_expose = array();
		$loop_start = $array_count = 0;
		$sales_balance = 0;
		$loop_start = $array_count = 0;
		$cost_txt_bankstatement = '';
		$sales_total = $actrev_total =  $balance = 0;
		$sales_total = $expense_total = $actrev_total = $bstatement_total = $balance = 0;
		if ($ReportDetails) {
			$total_amount = 0;
			/**************** arul ->bank statement **************************/
			$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link . ")";
			$excel_arr_sales[] = array($bankstatement_cost_head, '', '');
			$excel_arr_sales[] = array('', '', '');
			$excel_arr_sales[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

			/**************** arul ->bank statement **************************/
			$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";


			foreach ($ReportDetails as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$cost_name = $links = '';
				if ($amount_type == 'expense') {
					// $sales_total  
					if ($report_type != 3) {
						$sales_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$sales_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, $amount, '', $sales_total);
						$totalfinalsales = $sales_total;
					}
				}
				if ($amount_type == 'sales') {
					//$expense_total
					if ($report_type != 3) {
						$sales_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$sales_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					}
				}
				if ($cost_id != '' && $cost_id > 0) {
					/****   Arul ->If reporttype is journal and cost_id is bankstatement_cost_id ***/
					if ((($amount_type == 'sales' || $amount_type == 'expense') && ($report_type == 3 && $ledger_type == 2)) && ($cost_id == $bankstatement_cost_id)) {
						if ($amount_type == 'expense') {
							$sales_total -= (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_cr_amt = "R" . number_format((float)$amount, 2);
							$actrev_dr_amt = '';
						} else {
							$sales_total += (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_dr_amt = "R" . number_format((float)$amount, 2);
							$actrev_cr_amt = '';
						}
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					} //if
					else {

						$excludecost = array($bankstatement_cost_id);
						if ((!in_array($cost_id, $excludecost) && ($report_type != 3)) || ($report_type == 3 && $ledger_type == 2)) {
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
								if ($next_child != '' && $next_child != $cost_id) {
									$oformat_amount = "R" . number_format((float)$total_amount, 2);
									$oformat_amount_xl = $total_amount;
									$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
									$excel_array[] = array('', '', '', '', '', '');
									$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
									$excel_array[] = array('', '', '', '', '', '');
									$excel_array[] = array('', '', '', '', '', '');
								}

								if ($previous_child == '' || $previous_child != $cost_id) {
									$total_amount = 0;
									$balance = 0;
									$childcost = $CostDetails_arr[$cost_id];
									$previous_child = $cost_id;
									$next_child = $cost_id;
									$child_costname = $childcost->cost_name;
									//$links = $childcost->links;

									$excel_array[] = array($child_costname, '', '');
									$excel_array[] = array('', '', '');
									$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

									$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
								}
								if ($report_type == 3) {
									if ($amount_type == 'expense') {
										$total_amount -= (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$cr_amount = "R" . number_format((float)$amount, 2);
										$dr_amount = '';
									} else {
										$total_amount += (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$dr_amount = "R" . number_format((float)$amount, 2);
										$cr_amount = '';
									}
								} else {
									$total_amount += (float)$amount;
									$balance = "R" . number_format((float)$total_amount, 2);
									$dr_amount = "R" . number_format((float)$amount, 2);
									$cr_amount = '';
									// 	         if($amount_type == 'sales')
									//                  {
									//             $total_amount += (float)$amount;
									//             $balance = "R".number_format((float)$total_amount, 2);
									//             $dr_amount = "R".number_format((float)$amount, 2);
									//             $cr_amount = '';
									//            }else{

									//                $total_amount -= (float)$amount;
									//                 $balance = "R".number_format((float)$total_amount, 2);
									//                $cr_amount = "R".number_format((float)$amount, 2);
									//                $dr_amount = '';

									//            }
								}
								$cost_txt_other .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";

								$excel_array[] = array($report_date, $ref_no, $description, $dr_amount, $cr_amount, $balance);
							} //cost id

						}
					}
				}


				$array_count++;
			}

			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";



			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', '');
		}

		$oformat_amount = "R" . number_format((float)$sales_total, 2);
		$oformat_amount_xl = $sales_total;

		$excel_arr_sales[] = array('', '', '', '', '', '');
		$excel_arr_sales[] = array('', '', '', '', '', $oformat_amount_xl);
		$excel_arr_sales[] = array('', '', '', '', '', '');
		$excel_arr_sales[] = array('', '', '', '', '', '');

		$excel_array = array_merge($excel_arr_sales, $excel_array);
		$oformat_sales_total = "R" . number_format((float)$sales_total, 2);
		$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_sales_total . "</td></tr></tfoot></table>";

		$cost_txt = $cost_txt . $cost_txt_bankstatement . $cost_txt_other;
		$excel_fname = 'ledger_report.xls';
		$pdf_fname = 'ledger_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Ledger');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('D'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);



		echo $cost_txt;
		exit();
	}
	/************************* arul edited bank transactionledger***************/
	public function ajax_ledger_new_arul()
	{
		setlocale(LC_MONETARY, 'en_IN');
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_ledger';
			$ledger_title = 'Invoicing Ledger';
			$ledger_menu = 'invoice_ledger';
		} else {
			$report_url = 'banktrans_ledger';
			$ledger_title = "Bank Transaction Ledger";
			$ledger_menu = 'banktrans_ledger';
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc', 'custom_where' => '(report_type="3" or report_type = "2")'));
		//   echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = $cost_txt_bankstatement  = $cost_txt_other = '';
		$next_child = '';
		$excel_arr_sales = array();
		$excel_arr_sales = array();
		$expense_arr_expose = array();
		$loop_start = $array_count = 0;
		$sales_balance = 0;
		$loop_start = $array_count = 0;
		$cost_txt_bankstatement = '';
		$sales_total = $actrev_total =  $balance = 0;
		$sales_total = $expense_total = $actrev_total = $bstatement_total = $balance = 0;
		if ($ReportDetails) {
			$total_amount = 0;
			/**************** arul ->bank statement **************************/
			$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link . ")";
			$excel_arr_sales[] = array($bankstatement_cost_head, '', '');
			$excel_arr_sales[] = array('', '', '');
			$excel_arr_sales[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

			/**************** arul ->bank statement **************************/
			$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";


			foreach ($ReportDetails as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$cost_name = $links = '';
				if ($amount_type == 'sales') {
					// $sales_total  
					if ($report_type != 3) {
						$sales_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$sales_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, $amount, '', $sales_total);
						$totalfinalsales = $sales_total;
					}
				}
				if ($amount_type == 'expense') {
					//$expense_total
					if ($report_type != 3) {
						$sales_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$sales_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					}
				}
				if ($cost_id != '' && $cost_id > 0) {
					/****   Arul ->If reporttype is journal and cost_id is bankstatement_cost_id ***/
					if ((($amount_type == 'sales' || $amount_type == 'expense') && ($report_type == 3 && $ledger_type == 2)) && ($cost_id == $bankstatement_cost_id)) {
						if ($amount_type == 'expense') {
							$sales_total -= (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_cr_amt = "R" . number_format((float)$amount, 2);
							$actrev_dr_amt = '';
						} else {
							$sales_total += (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_dr_amt = "R" . number_format((float)$amount, 2);
							$actrev_cr_amt = '';
						}
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					} //if
					else {

						$excludecost = array($bankstatement_cost_id);
						if ((!in_array($cost_id, $excludecost) && ($report_type != 3)) || ($report_type == 3 && $ledger_type == 2)) {
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
								if ($next_child != '' && $next_child != $cost_id) {
									$oformat_amount = "R" . number_format((float)$total_amount, 2);
									$oformat_amount_xl = $total_amount;
									$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
									$excel_array[] = array('', '', '', '', '', '');
									$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
									$excel_array[] = array('', '', '', '', '', '');
									$excel_array[] = array('', '', '', '', '', '');
								}

								if ($previous_child == '' || $previous_child != $cost_id) {
									$total_amount = 0;
									$balance = 0;
									$childcost = $CostDetails_arr[$cost_id];
									$previous_child = $cost_id;
									$next_child = $cost_id;
									$child_costname = $childcost->cost_name;
									//$links = $childcost->links;

									$excel_array[] = array($child_costname, '', '');
									$excel_array[] = array('', '', '');
									$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

									$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
								}
								if ($report_type == 3) {
									if ($amount_type == 'expense') {
										$total_amount -= (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$cr_amount = "R" . number_format((float)$amount, 2);
										$dr_amount = '';
									} else {
										$total_amount += (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$dr_amount = "R" . number_format((float)$amount, 2);
										$cr_amount = '';
									}
								} else {
									$total_amount += (float)$amount;
									$balance = "R" . number_format((float)$total_amount, 2);
									$dr_amount = "R" . number_format((float)$amount, 2);
									$cr_amount = '';
									// 	         if($amount_type == 'sales')
									//                  {
									//             $total_amount += (float)$amount;
									//             $balance = "R".number_format((float)$total_amount, 2);
									//             $dr_amount = "R".number_format((float)$amount, 2);
									//             $cr_amount = '';
									//            }else{

									//                $total_amount -= (float)$amount;
									//                 $balance = "R".number_format((float)$total_amount, 2);
									//                $cr_amount = "R".number_format((float)$amount, 2);
									//                $dr_amount = '';

									//            }
								}
								$cost_txt_other .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";

								$excel_array[] = array($report_date, $ref_no, $description, $dr_amount, $cr_amount, $balance);
							} //cost id

						}
					}
				}


				$array_count++;
			}

			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";



			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', '');
		}

		$oformat_amount = "R" . number_format((float)$sales_total, 2);
		$oformat_amount_xl = $sales_total;

		$excel_arr_sales[] = array('', '', '', '', '', '');
		$excel_arr_sales[] = array('', '', '', '', '', $oformat_amount_xl);
		$excel_arr_sales[] = array('', '', '', '', '', '');
		$excel_arr_sales[] = array('', '', '', '', '', '');

		$excel_array = array_merge($excel_arr_sales, $excel_array);
		$oformat_sales_total = "R" . number_format((float)$sales_total, 2);
		$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_sales_total . "</td></tr></tfoot></table>";

		$cost_txt = $cost_txt . $cost_txt_bankstatement . $cost_txt_other;
		$excel_fname = 'ledger_report.xls';
		$pdf_fname = 'ledger_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Ledger');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('D'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);



		echo $cost_txt;
		exit();
	}
	/************************ pdf*****************/
	public function ledger_pdf_new()
	{


		setlocale(LC_MONETARY, 'en_IN');
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$ledger_title = 'Invoicing Ledger';
		} else {
			$ledger_title = "Bank Transaction Ledger";
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '((report_type="3" and ledger_type="bank" ) or report_type = "2")'));


		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc', 'custom_where' => '(report_type="3" or report_type = "2")'));


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = $cost_txt_bankstatement  = $cost_txt_other = '';
		$next_child = '';
		$excel_arr_sales = array();
		$excel_arr_sales = array();
		$expense_arr_expose = array();
		$loop_start = $array_count = 0;
		$sales_balance = 0;
		$loop_start = $array_count = 0;
		$cost_txt_bankstatement = '';
		$sales_total = $actrev_total =  $balance = 0;
		$sales_total = $expense_total = $actrev_total = $bstatement_total = $balance = 0;
		if ($ReportDetails) {
			$total_amount = 0;
			/**************** arul ->bank statement **************************/
			$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link . ")";
			$excel_arr_sales[] = array($bankstatement_cost_head, '', '');
			$excel_arr_sales[] = array('', '', '');
			$excel_arr_sales[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

			/**************** arul ->bank statement **************************/
			$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";


			foreach ($ReportDetails_bank as $ReportDetail) {
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$amount_type = $ReportDetail->amount_type;
				$description = $ReportDetail->description;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$amount = number_format((float)$amount, 2, '.', '');
				$cost_name = $links = '';

				if ($amount_type == 'expense') {
					// $sales_total  
					if ($report_type != 3) {
						$sales_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$sales_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, $amount, '', $sales_total);
						$totalfinalsales = $sales_total;
					}
				}
				if ($amount_type == 'sales') {
					//$expense_total
					if ($report_type != 3) {
						$sales_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$sales_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					}
				}
			}
			foreach ($ReportDetails as $ReportDetail) {
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$cost_id = $ReportDetail->cost_id;
				$amount = $ReportDetail->amount;
				$amount_type = $ReportDetail->amount_type;
				$description = $ReportDetail->description;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$report_type = $ReportDetail->report_type;
				$ledger_type = $ReportDetail->ledger_type;
				$amount = number_format((float)$amount, 2, '.', '');
				$cost_name = $links = '';
				if ($cost_id != '' && $cost_id > 0) {
					/****   Arul ->If reporttype is journal and cost_id is bankstatement_cost_id ***/
					if ((($amount_type == 'sales' || $amount_type == 'expense') && ($report_type == 3 && $ledger_type == 2)) && ($cost_id == $bankstatement_cost_id)) {
						if ($amount_type == 'expense') {
							$sales_total -= (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_cr_amt = "R" . number_format((float)$amount, 2);
							$actrev_dr_amt = '';
						} else {
							$sales_total += (float)$amount;
							$actrev_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = '';
							$actrev_dr_amt = "R" . number_format((float)$amount, 2);
							$actrev_cr_amt = '';
						}
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);
					} //if
					else {

						$excludecost = array($bankstatement_cost_id);
						if ((!in_array($cost_id, $excludecost) && ($report_type != 3)) || ($report_type == 3 && $ledger_type == 2)) {
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
								if ($next_child != '' && $next_child != $cost_id) {
									$oformat_amount = "R" . number_format((float)$total_amount, 2);
									$oformat_amount_xl = $total_amount;
									$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
								}

								if ($previous_child == '' || $previous_child != $cost_id) {
									$total_amount = 0;
									$balance = 0;
									$childcost = $CostDetails_arr[$cost_id];
									$previous_child = $cost_id;
									$next_child = $cost_id;
									$child_costname = $childcost->cost_name;
									//$links = $childcost->links;

									$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
								}
								if ($report_type == 3) {
									if ($amount_type == 'expense') {
										$total_amount -= (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$cr_amount = "R" . number_format((float)$amount, 2);
										$dr_amount = '';
									} else {
										$total_amount += (float)$amount;
										$balance = "R" . number_format((float)$total_amount, 2);
										$dr_amount = "R" . number_format((float)$amount, 2);
										$cr_amount = '';
									}
								} else {

									$total_amount += (float)$amount;
									$balance = "R" . number_format((float)$total_amount, 2);
									$dr_amount = "R" . number_format((float)$amount, 2);
									$cr_amount = '';
									// if($amount_type == 'sales')
									//        {
									//   $total_amount += (float)$amount;
									//   $balance = "R".number_format((float)$total_amount, 2);
									//   $dr_amount = "R".number_format((float)$amount, 2);
									//   $cr_amount = '';
									//  }else{

									//      $total_amount -= (float)$amount;
									//       $balance = "R".number_format((float)$total_amount, 2);
									//      $cr_amount = "R".number_format((float)$amount, 2);
									//      $dr_amount = '';

									//  }
								}
								$cost_txt_other .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";

								$excel_array[] = array($report_date, $ref_no, $description, $dr_amount, $cr_amount, $balance);
							} //cost id

						}
					}
				}


				$array_count++;
			}
			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$oformat_amount_xl = $total_amount;
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";



			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', '');
		}

		$oformat_amount = "R" . number_format((float)$sales_total, 2);
		$oformat_amount_xl = $sales_total;



		$oformat_sales_total = "R" . number_format((float)$sales_total, 2);
		$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_sales_total . "</td></tr></tfoot></table>";

		$cost_txt = $cost_txt . $cost_txt_bankstatement . $cost_txt_other;
		$excel_fname = 'ledger_report.xls';
		$pdf_fname = 'ledger_report.pdf';


		/********************* PDF start ********/

		$this->load->library('m_pdf');


		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}

	public function ajax_financial_statement()
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_financial';
			$ledger_title = 'Invoicing Financial';
			$ledger_menu = 'invoice_financial';
		} else {
			$report_url = 'banktrans_financial';
			$ledger_title = "Bank Transaction Financial";
			$ledger_menu = 'banktrans_financial';
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));



		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR,report_type,ledger_type',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>" . $child_costname . "</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"excel_array_" . $sup_key}[] = array($child_costname, '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('Cost Name', 'Links', 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance +=  $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance =  $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float)$amount;
							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);
							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							$excel_arrcount++;
						}
					}
					if ($ReportDetails) {
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$report_type = $ReportDetail->report_type;
							$ledger_type = $ReportDetail->ledger_type;
							$amount =  (float)$amount_cr - (float)$amount_dr;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
							}

							$total_amount += (float)$amount;


							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;



							if ($subcategory_id == '5') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							$excel_arrcount++;
						}
					}
					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";

					$excel_tfoot[] = $excel_arrcount;

					${"excel_array_" . $sup_key}[] = array('Total', '', $oformat_amount_xl);
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');

					$excel_tfoot[] = $excel_arrcount;
					$excel_arrcount += 3;



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}

			if ($sup_key == 'asset') {

				$excel_appd_arr['total_ast_ct'] = $excel_arrcount;


				$total_assets = "R" . number_format((float)$total_asset, 2);
				$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>" . $total_assets . "</th></tr></tbody></table>";

				$excel_array_total_ast[] = array('Total Asset', '', $total_asset);
				$excel_array_total_ast[] = array('', '', '');
				$excel_array_total_ast[] = array('', '', '');

				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;


				$excel_appd_arr['array_libt_ct'] = $excel_arrcount;
			}


			if ($sup_key == 'libt') {

				$excel_appd_arr['array_eqt_ct'] = $excel_arrcount;

				$excel_titlearr[] = $excel_arrcount;
				$excel_arrcount += 2;
				$excele_tablearr[] = $excel_arrcount;
				$excel_arrcount += 1;


				$excel_arrcount++;

				// $excel_arrcount++;


				$excel_tfoot[] = $excel_arrcount;

				$excel_tfoot[] = $excel_arrcount;
				$excel_arrcount += 3;



				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;

				$excel_arrcount++;

				$excel_appd_arr['other_ct'] = $excel_arrcount;
			}
		}







		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float)$profit, 2);

		$total_quity_xl = (float)$unallocated_difference + (float)$profit;
		$ototal_quity = "R" . number_format((float)$total_quity_xl, 2);


		$total_libeqt_xl = (float)$total_quity_xl + (float)$total_liabilities;
		$ototal_libeqt = "R" . number_format((float)$total_libeqt_xl, 2);


		$total_unalloc_xl = (float)$total_asset - (float)$total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float)$total_unalloc_xl, 2);

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ototal_unalloc."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>" . $oprofit . "</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $ototal_quity . "</td></tr></tfoot></table>";



		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>" . $ototal_libeqt . "</th></tr></tbody></table>";

		//$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";
		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ototal_unalloc . "</p>";



		// $totallibeqt_txt .= "<table class='table table-striped table-hover stl_costtbl' style='margin-top:45px;margin-bottom:45px;'><tbody><tr><th  colspan='2' style='font-size:18px;'>Unallocated Difference</th><th style='text-align:right;font-size:18px;'>".$ototal_unalloc."</th></tr></tbody></table>";


		$excel_array_eqt[] = array('Equity', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Cost Name', 'Links', 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		$excel_array_eqt[] = array('Profit', 'q.200.000', $profit);
		$excel_array_eqt[] = array('Total', '', $total_quity_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Total Liabilities and Equity', '', $total_libeqt_xl);
		$excel_array_eqt[] = array('Unallocated Difference', '', $total_unalloc_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');





		$tax = (((float)$profit * 28) / 100);
		$otax = "R" . number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R" . number_format((float)$profit_tax, 2);


		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>" . $oprofit . "</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";


		$excel_appd_arr['final_ct'] = $excel_arrcount;
		$excel_array_final[] = array('Profit Before Taxation', '', $profit);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;
		$excel_array_final[] = array('Taxation', '', $tax);
		$excel_arrcount++;
		$excel_array_final[] = array('Profit After Taxation', '', $profit_tax);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;

		$subcat_id_loop = array(array('asset' => '5', '7'), array('libt' => '6', '8'), array('other' => '10', '70', '71'));

		$cost_txt =  $cost_txt_start . " " . $cost_txt_asset . " " . $total_assets_txt . " " . $cost_txt_libt . " " . $qut_txt . " " . $totallibeqt_txt . " " . $cost_txt_other . " " . $final_txt;

		// $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
		// $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

		// $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
		// $excel_array[] = array( 'Profit', '' , $profit);

		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;


		$excel_fname = 'financial_report.xls';
		$pdf_fname = 'financial_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Financial Statement');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('C'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		foreach ($excel_titlearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setSize(13);
		}

		foreach ($excel_assetfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setSize(13);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setBold(true);
		}

		foreach ($excele_tablearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('507682');
		}
		foreach ($excel_tfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		foreach ($excel_ttfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setSize(10);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}


		// $excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0,'array_libt_ct' => 0,'array_eqt_ct' => $array_eqt_ct,'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4');
		$this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A' . $excel_appd_arr['total_ast_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A' . $excel_appd_arr['array_libt_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A' . $excel_appd_arr['array_eqt_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A' . $excel_appd_arr['other_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_final, null, 'A' . $excel_appd_arr['final_ct']);





		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);



		echo $cost_txt;
		exit();
	}

	public function ajax_financial_statement_pdf_bankstat()
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_financial';
			$ledger_title = 'Invoicing Financial';
			$ledger_menu = 'invoice_financial';
		} else {
			$report_url = 'banktrans_financial';
			$ledger_title = "Bank Transaction Financial";
			$ledger_menu = 'banktrans_financial';
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		// $ReportDetails_bank = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,'.BANKSTATEMENT_COST_CAT_ID.' as category_id,'.BANKSTATEMENT_COST_SUBCAT_ID.' as subcategory_id, '.BANKSTATEMENT_COST_ID.' as cost_id',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(report_type = "2" or (report_type="3" and ledger_type="2"))'));

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));



		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				// if($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID)
				// 	{
				// 		  $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				// 		  //echo $this->db->last_query();
				//  	}else{
				//       $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				//   }

				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR,report_type,ledger_type',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}

				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>" . $child_costname . "</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"excel_array_" . $sup_key}[] = array($child_costname, '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('Cost Name', 'Links', 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance +=  $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							// $bank_balance =  $bank_balance+$expenseTotal - $salesTotal;
							$bank_balance =  $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float)$amount;
							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);
							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							$excel_arrcount++;
						}
					}
					if ($ReportDetails) {
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$amount =  (float)$amount_cr - (float)$amount_dr;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
							}

							$total_amount += (float)$amount;


							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							$excel_arrcount++;
						}
					}
					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";

					$excel_tfoot[] = $excel_arrcount;

					${"excel_array_" . $sup_key}[] = array('Total', '', $oformat_amount_xl);
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');

					$excel_tfoot[] = $excel_arrcount;
					$excel_arrcount += 3;



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}

			if ($sup_key == 'asset') {

				$excel_appd_arr['total_ast_ct'] = $excel_arrcount;


				$total_assets = "R" . number_format((float)$total_asset, 2);
				$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>" . $total_assets . "</th></tr></tbody></table>";

				$excel_array_total_ast[] = array('Total Asset', '', $total_asset);
				$excel_array_total_ast[] = array('', '', '');
				$excel_array_total_ast[] = array('', '', '');

				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;


				$excel_appd_arr['array_libt_ct'] = $excel_arrcount;
			}


			if ($sup_key == 'libt') {

				$excel_appd_arr['array_eqt_ct'] = $excel_arrcount;

				$excel_titlearr[] = $excel_arrcount;
				$excel_arrcount += 2;
				$excele_tablearr[] = $excel_arrcount;
				$excel_arrcount += 1;


				$excel_arrcount++;

				// $excel_arrcount++;


				$excel_tfoot[] = $excel_arrcount;

				$excel_tfoot[] = $excel_arrcount;
				$excel_arrcount += 3;



				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;

				$excel_arrcount++;

				$excel_appd_arr['other_ct'] = $excel_arrcount;
			}
		}







		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float)$profit, 2);

		$total_quity_xl = (float)$unallocated_difference + (float)$profit;
		$ototal_quity = "R" . number_format((float)$total_quity_xl, 2);


		$total_libeqt_xl = (float)$total_quity_xl + (float)$total_liabilities;
		$ototal_libeqt = "R" . number_format((float)$total_libeqt_xl, 2);


		$total_unalloc_xl = (float)$total_asset - (float)$total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float)$total_unalloc_xl, 2);

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ototal_unalloc."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>" . $oprofit . "</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $ototal_quity . "</td></tr></tfoot></table>";



		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>" . $ototal_libeqt . "</th></tr></tbody></table>";

		//$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";
		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ototal_unalloc . "</p>";



		// $totallibeqt_txt .= "<table class='table table-striped table-hover stl_costtbl' style='margin-top:45px;margin-bottom:45px;'><tbody><tr><th  colspan='2' style='font-size:18px;'>Unallocated Difference</th><th style='text-align:right;font-size:18px;'>".$ototal_unalloc."</th></tr></tbody></table>";


		$excel_array_eqt[] = array('Equity', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Cost Name', 'Links', 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		$excel_array_eqt[] = array('Profit', 'q.200.000', $profit);
		$excel_array_eqt[] = array('Total', '', $total_quity_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Total Liabilities and Equity', '', $total_libeqt_xl);
		$excel_array_eqt[] = array('Unallocated Difference', '', $total_unalloc_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');





		$tax = (((float)$profit * 28) / 100);
		$otax = "R" . number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R" . number_format((float)$profit_tax, 2);


		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>" . $oprofit . "</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";


		$excel_appd_arr['final_ct'] = $excel_arrcount;
		$excel_array_final[] = array('Profit Before Taxation', '', $profit);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;
		$excel_array_final[] = array('Taxation', '', $tax);
		$excel_arrcount++;
		$excel_array_final[] = array('Profit After Taxation', '', $profit_tax);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;

		$subcat_id_loop = array(array('asset' => '5', '7'), array('libt' => '6', '8'), array('other' => '10', '70', '71'));

		$cost_txt =  $cost_txt_start . " " . $cost_txt_asset . " " . $total_assets_txt . " " . $cost_txt_libt . " " . $qut_txt . " " . $totallibeqt_txt . " " . $cost_txt_other . " " . $final_txt;



		$pdf_fname = 'financial_report.pdf';

		/********************* PDF start ********/

		$this->load->library('m_pdf');


		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}
	/************************** arul->altered the finaicial starement invoices
	 *************************************************************************************/
	public function ajax_financial_statement_invoice()
	{

		setlocale(LC_MONETARY, 'en_IN');
		$sales_cost_id = SALES_COST_ID;
		$sales_cost_name = SALES_COST_NAME;
		$sales_cost_link = SALES_COST_LINK;
		$actrev_cost_id = ACT_RECEIVABLE_COST_ID;
		$actrev_cost_name = ACT_RECEIVABLE_COST_NAME;
		$actrev_cost_link = ACT_RECEIVABLE_COST_LINK;
		$expense_cost_id = EXPENSE_COST_ID;
		$expense_cost_name = EXPENSE_COST_NAME;
		$expense_cost_link = EXPENSE_COST_LINK;
		/**************** arul ->bank statement **************************/
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;


		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_financial';
			$ledger_title = 'Invoicing Financial';
			$ledger_menu = 'invoice_financial';
		} else {
			$report_url = 'banktrans_financial';
			$ledger_title = "Bank Transaction Financial";
			$ledger_menu = 'banktrans_financial';
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();

		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();


		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));


		// foreach($subcat_id_loop as $sup_key  => $subcat_id_arr){
		// 	${"cost_txt_" . $sup_key} = '';
		// // echo $sup_key;
		// 	foreach($subcat_id_arr as $subcat_id_ar)
		// 	{
		//             //echo "ACT_RECEIVABLE_COST_SUBCAT_ID=".ACT_RECEIVABLE_COST_SUBCAT_ID.'------';
		//             //echo $subcat_id_ar;
		// 		if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID)
		// 		{
		// 			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','groupby' => 'amount_type','disporder' => 'asc','custom_where' => '((report_type="1" or report_type = "7" or report_type = "5") OR (report_type = "3" AND ledger_type="1" AND cost_id='.$actrev_cost_id.'))'));
		// 		//	echo  $this->db->last_query();
		// 			$total_asset_total =  $ReportDetails[0]->total_amount;

		// 			$ReportDetails_asset = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','groupby' => 'cost_id','disporder' => 'asc','custom_where' => '(  (report_type = "3" AND ledger_type="1" AND cost_id NOT LIKE '.$actrev_cost_id.'))'));
		// 		//	echo  $this->db->last_query();
		// 					// $asset_total_query = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','groupby' => 'amount_type','disporder' => 'asc','custom_where' => '((report_type="1" or report_type = "7" or report_type = "5") OR (report_type = "3" AND ledger_type="1"))'));
		// 			// $final_Asset_total =  $asset_total_query[0]->total_amount;
		// 			//echo $this->db->last_query();

		// 		}
		// 		if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID)
		// 		{
		// 			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','groupby' => 'amount_type','disporder' => 'asc','custom_where' => '((report_type="1" or report_type = "7" or report_type = "5") OR (report_type = "3" AND ledger_type="1" AND cost_id='.$expense_cost_id.'))'));
		// 			$total_expense_total =  $ReportDetails[0]->total_amount;

		// 			$ReportDetails_expanse = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','groupby' => 'cost_id','disporder' => 'asc','custom_where' => '( (report_type = "3" AND ledger_type="1" AND cost_id NOT LIKE '.$expense_cost_id.'))'));

		// 			}
		// 		else
		// 		{
		// 			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
		// 		}
		// 		$total_amount = 0;
		//           	$childcost = $CostDetails_arr[$subcat_id_ar];
		//           	$child_costname = $childcost->cost_name;

		//           	if($ReportDetails){
		// 			${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
		// 			${"excel_array_" . $sup_key}[] = array( $child_costname, '' , '');
		//            	${"excel_array_" . $sup_key}[] = array( '', '' , '');
		//            	${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

		//            	$excel_titlearr[] = $excel_arrcount;
		//                   $excel_arrcount += 2;
		//                   $excele_tablearr[] = $excel_arrcount;
		//                   $excel_arrcount += 1;


		// 			foreach ($ReportDetails as $ReportDetail) {
		// 				if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID){$cost_id = ACT_RECEIVABLE_COST_ID;$subcategory_id = ACT_RECEIVABLE_COST_SUBCAT_ID;}
		// 				else if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID){$cost_id = EXPENSE_COST_ID;$subcategory_id = EXPENSE_COST_SUBCAT_ID;}
		// 				else
		// 				{
		// 					$cost_id = $ReportDetail->cost_id;
		//                		$subcategory_id = $ReportDetail->subcategory_id;
		// 				}

		//                	$amount = $ReportDetail->total_amount;
		//                	$amount = number_format((float)$amount, 2, '.', '');
		//                	$cost_name = $links = '';
		//                	if($cost_id !='')
		//                	{
		//                    	$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
		//                    	if($catcost)
		//                    	{
		//                        	foreach($catcost as $ctcost)
		//                        	{
		//                            	$cost_name = $ctcost->cost_name;
		//                            	$links = $ctcost->links;
		//                        	}
		//                    	}
		//                	}

		//                	$total_amount += (float)$amount;
		//                	$oformat_amount = "R".number_format((float)$amount, 2);
		//             	$oformat_amount_xl = $amount;

		// 	            if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
		//                 else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
		//                 else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
		//                 else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
		//                 else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
		//                 else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
		//                 else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
		//                 else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

		//                 ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
		//                 ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

		//                 // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
		//                    $excel_arrcount++;

		// 			} //report_details foreach


		// 			$oformat_amount = "R".number_format((float)$total_amount, 2);
		//            	$oformat_amount_xl = $total_amount;
		//               	${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

		//               	$excel_tfoot[] = $excel_arrcount;

		//               	${"excel_array_" . $sup_key}[] = array( 'Total', '' , $oformat_amount_xl);
		//               	${"excel_array_" . $sup_key}[] = array( '', '' , '');${"excel_array_" . $sup_key}[] = array( '', '' , '');

		//               	$excel_tfoot[] = $excel_arrcount;
		//           		$excel_arrcount += 3;

		//          			if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
		//          			if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }
		//       		} //if report
		//       	} //foreeach su_cate_arr
		//                foreach ($ReportDetails_asset as $ReportDetailasset) {

		// 				if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID)
		// 				{

		//                         ${"cost_txt_asset"} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";

		// 				}
		// 			}
		// 	if($sup_key == 'asset')
		// 	{
		// 		$excel_appd_arr['total_ast_ct'] = $excel_arrcount;
		// 		$total_assets = "R".number_format((float)$total_asset, 2);
		// 		$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>".$total_assets."</th></tr></tbody></table>";

		// 		$excel_array_total_ast[] = array( 'Total Asset', '' , $total_asset);
		//               $excel_array_total_ast[] = array( '', '' , '');$excel_array_total_ast[] = array( '', '' , '');

		//               $excel_assetfoot[] = $excel_arrcount;
		//           	$excel_arrcount += 3;
		// 		$excel_appd_arr['array_libt_ct'] = $excel_arrcount;

		// 	}

		// 	if($sup_key == 'libt')
		// 	{

		// 			$excel_appd_arr['array_eqt_ct'] = $excel_arrcount;
		//    		$excel_titlearr[] = $excel_arrcount;
		//       		$excel_arrcount += 2;
		//       		$excele_tablearr[] = $excel_arrcount;
		//       		$excel_arrcount += 1;
		//       		$excel_arrcount++;
		//       		// $excel_arrcount++;
		//       		$excel_tfoot[] = $excel_arrcount;
		//       		$excel_tfoot[] = $excel_arrcount;
		//       		$excel_arrcount += 3;
		//       		$excel_assetfoot[] = $excel_arrcount;
		//       		$excel_arrcount += 3;
		//       		$excel_arrcount++;
		//     			$excel_appd_arr['other_ct'] = $excel_arrcount;  

		// 	}
		// } //main foreach
		/**********************************************************************/
		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '((report_type="1" or report_type = "7" or report_type = "5") OR (report_type = "3" AND ledger_type="1" AND cost_id="' . $actrev_cost_id . '"))'));
					//echo $this->db->last_query();
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '((report_type="1" or report_type = "7" or report_type = "5") OR (report_type = "3" AND ledger_type="1" AND cost_id="' . $expense_cost_id . '"))'));
					//echo '<br>'. $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}


				// echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails) {
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>" . $child_costname . "</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"excel_array_" . $sup_key}[] = array($child_costname, '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('Cost Name', 'Links', 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;


					foreach ($ReportDetails as $ReportDetail) {
						if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
							$cost_id = ACT_RECEIVABLE_COST_ID;
							$subcategory_id = ACT_RECEIVABLE_COST_SUBCAT_ID;
						} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
							$cost_id = EXPENSE_COST_ID;
							$subcategory_id = EXPENSE_COST_SUBCAT_ID;
						} else {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
						}

						$amount = $ReportDetail->total_amount;
						$amount = number_format((float)$amount, 2, '.', '');
						$cost_name = $links = '';
						if ($cost_id != '') {
							$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
							if ($catcost) {
								foreach ($catcost as $ctcost) {
									$cost_name = $ctcost->cost_name;
									$links = $ctcost->links;
								}
							}
						}

						$total_amount += (float)$amount;
						$oformat_amount = "R" . number_format((float)$amount, 2);
						$oformat_amount_xl = $amount;

						if ($subcategory_id == '5') {
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Current Asset
						else if ($subcategory_id == '6') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Current Liabilities
						else if ($subcategory_id == '7') {
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Non-Curent Asset
						else if ($subcategory_id == '8') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Non-Current Liabilities
						else if ($subcategory_id == '9') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Equity
						else if ($subcategory_id == '10') {
							$profit += (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Sales
						else if ($subcategory_id == '70') {
							$profit -= (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Cost of Sales
						else if ($subcategory_id == '71') {
							$profit -= (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Expenses

						${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
						${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);

						// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
						$excel_arrcount++;
					} //report_details foreach

					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";

					$excel_tfoot[] = $excel_arrcount;

					${"excel_array_" . $sup_key}[] = array('Total', '', $oformat_amount_xl);
					${"excel_array_" . $sup_key}[] = array('', '', '');
					${"excel_array_" . $sup_key}[] = array('', '', '');

					$excel_tfoot[] = $excel_arrcount;
					$excel_arrcount += 3;

					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				} //if report
			} //foreeach su_cate_arr

			if ($sup_key == 'asset') {
				$excel_appd_arr['total_ast_ct'] = $excel_arrcount;
				$total_assets = "R" . number_format((float)$total_asset, 2);
				$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>" . $total_assets . "</th></tr></tbody></table>";

				$excel_array_total_ast[] = array('Total Asset', '', $total_asset);
				$excel_array_total_ast[] = array('', '', '');
				$excel_array_total_ast[] = array('', '', '');

				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;
				$excel_appd_arr['array_libt_ct'] = $excel_arrcount;
			}

			if ($sup_key == 'libt') {

				$excel_appd_arr['array_eqt_ct'] = $excel_arrcount;
				$excel_titlearr[] = $excel_arrcount;
				$excel_arrcount += 2;
				$excele_tablearr[] = $excel_arrcount;
				$excel_arrcount += 1;
				$excel_arrcount++;
				// $excel_arrcount++;
				$excel_tfoot[] = $excel_arrcount;
				$excel_tfoot[] = $excel_arrcount;
				$excel_arrcount += 3;
				$excel_assetfoot[] = $excel_arrcount;
				$excel_arrcount += 3;
				$excel_arrcount++;
				$excel_appd_arr['other_ct'] = $excel_arrcount;
			}
		} //main foreach

		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float)$profit, 2);

		$total_quity_xl = (float)$unallocated_difference + (float)$profit;
		$ototal_quity = "R" . number_format((float)$total_quity_xl, 2);

		$total_libeqt_xl = (float)$total_quity_xl + (float)$total_liabilities;
		$ototal_libeqt = "R" . number_format((float)$total_libeqt_xl, 2);

		$total_unalloc_xl = (float)$total_asset - (float)$total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float)$total_unalloc_xl, 2);

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>" . $oprofit . "</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $ototal_quity . "</td></tr></tfoot></table>";

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>" . $ototal_libeqt . "</th></tr></tbody></table>";

		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ototal_unalloc . "</p>";


		$excel_array_eqt[] = array('Equity', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Cost Name', 'Links', 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		$excel_array_eqt[] = array('Profit', 'q.200.000', $profit);
		$excel_array_eqt[] = array('Total', '', $total_quity_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('Total Liabilities and Equity', '', $total_libeqt_xl);
		$excel_array_eqt[] = array('Unallocated Difference', '', $total_unalloc_xl);
		$excel_array_eqt[] = array('', '', '');
		$excel_array_eqt[] = array('', '', '');

		$tax = (((float)$profit * 28) / 100);
		$otax = "R" . number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R" . number_format((float)$profit_tax, 2);

		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>" . $oprofit . "</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";

		$excel_appd_arr['final_ct'] = $excel_arrcount;
		$excel_array_final[] = array('Profit Before Taxation', '', $profit);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;
		$excel_array_final[] = array('Taxation', '', $tax);
		$excel_arrcount++;
		$excel_array_final[] = array('Profit After Taxation', '', $profit_tax);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;

		$subcat_id_loop = array(array('asset' => '5', '7'), array('libt' => '6', '8'), array('other' => '10', '70', '71'));

		$cost_txt =  $cost_txt_start . " " . $cost_txt_asset . " " . $total_assets_txt . " " . $cost_txt_libt . " " . $qut_txt . " " . $totallibeqt_txt . " " . $cost_txt_other . " " . $final_txt;

		$excel_fname = 'financial_report.xls';
		$pdf_fname = 'financial_report.pdf';


		/********************* EXCEL start ********/

		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Financial Statement');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('C'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		foreach ($excel_titlearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setSize(13);
		}

		foreach ($excel_assetfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setSize(13);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setBold(true);
		}

		foreach ($excele_tablearr as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('507682');
		}
		foreach ($excel_tfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		foreach ($excel_ttfoot as $val) {
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A' . $val . ':C' . $val)->getFont()->setSize(10);
			$this->excel->getActiveSheet()->getStyle('C' . $val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}

		$this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4');
		$this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A' . $excel_appd_arr['total_ast_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A' . $excel_appd_arr['array_libt_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A' . $excel_appd_arr['array_eqt_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A' . $excel_appd_arr['other_ct']);
		$this->excel->getActiveSheet()->fromArray($excel_array_final, null, 'A' . $excel_appd_arr['final_ct']);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);

		echo $cost_txt;
		exit();
	}
	/**************** financial PDF ****************************/
	public function financial_statement_pdf_invoice()
	{

		$unallocated_difference = $profit = 0;
		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$ledger_title = 'Invoicing Ledger';
		} else {
			$ledger_title = "Bank Transaction Ledger";
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_type' => $report_type, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'cost_id,report_date', 'disporder' => 'asc'));


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';


		$subcat_id_arr = array('5', '7', '6', '8', '9', '10', '70', '71');

		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_tfoot = array();

		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));


		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}


				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails) {
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>" . $child_costname . "</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";

					foreach ($ReportDetails as $ReportDetail) {
						if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
							$cost_id = ACT_RECEIVABLE_COST_ID;
							$subcategory_id = ACT_RECEIVABLE_COST_SUBCAT_ID;
						} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
							$cost_id = EXPENSE_COST_ID;
							$subcategory_id = EXPENSE_COST_SUBCAT_ID;
						} else {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
						}
						$amount = $ReportDetail->total_amount;
						$amount = number_format((float)$amount, 2, '.', '');
						$cost_name = $links = '';
						if ($cost_id != '') {
							$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
							if ($catcost) {
								foreach ($catcost as $ctcost) {
									$cost_name = $ctcost->cost_name;
									$links = $ctcost->links;
								}
							}
						}

						$total_amount += (float)$amount;
						$oformat_amount = "R" . number_format((float)$amount, 2);
						$oformat_amount_xl = $amount;

						if ($subcategory_id == '5') {
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Current Asset
						else if ($subcategory_id == '6') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Current Liabilities
						else if ($subcategory_id == '7') {
							$unallocated_difference += (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Non-Curent Asset
						else if ($subcategory_id == '8') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Non-Current Liabilities
						else if ($subcategory_id == '9') {
							$unallocated_difference -= (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Equity
						else if ($subcategory_id == '10') {
							$profit += (float)$amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Sales
						else if ($subcategory_id == '70') {
							$profit -= (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Cost of Sales
						else if ($subcategory_id == '71') {
							$profit -= (float)$amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Expenses

						${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
					}

					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";

					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}

		$total_assets = "R" . number_format((float)$total_asset, 2);
		$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>" . $total_assets . "</th></tr></tbody></table>";

		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float)$profit, 2);

		$total_quity_xl = (float)$unallocated_difference + (float)$profit;
		$ototal_quity = "R" . number_format((float)$total_quity_xl, 2);

		$total_unalloc_xl = (float)$total_asset - (float)$total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float)$total_unalloc_xl, 2);

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>" . $oprofit . "</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>" . $ototal_quity . "</td></tr></tfoot></table>";

		$total_libeqt_xl = (float)$total_quity_xl + (float)$total_liabilities;
		$ototal_libeqt = "R" . number_format((float)$total_libeqt_xl, 2);

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' ><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>" . $ototal_libeqt . "</th></tr></tbody></table>";

		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $ototal_unalloc . "</p>";

		$tax = (((float)$profit * 28) / 100);
		$otax = "R" . number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R" . number_format((float)$profit_tax, 2);

		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>" . $oprofit . "</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";

		$cost_txt =  $cost_txt_start . " " . $cost_txt_asset . " " . $total_assets_txt . " " . $cost_txt_libt . " " . $qut_txt . " " . $totallibeqt_txt . " " . $cost_txt_other . " " . $final_txt;

		$pdf_fname = 'financial_report.pdf';

		/********************* PDF start ********/
		$this->load->library('m_pdf');
		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);

		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/
		echo json_encode(array('message' => 'success'));
		exit();
	}
	/********************* financial statement creation end *************/
	public function bankstat_openingbanlance_invoice_single($start_date, $filtered_client_id)
	{
		$array_merge = [];
		$expense_cost_id = EXPENSE_COST_ID;
		$actrev_cost_id = ACT_RECEIVABLE_COST_ID;
		$sales_cost_id = SALES_COST_ID;
		// $start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr_invoicefinalcial_single($start_date, $filtered_client_id, $expense_cost_id, $actrev_cost_id, $sales_cost_id);
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		/*$DRDetails = $this->reports_model->total_dr_invoicefinalcial_single($start_date,$filtered_client_id);

		$total_cr = $total_dr = 0;
		if($CRDetails)
		{
			$total_cr = $CRDetails->total_cr;
		}
		if($DRDetails)
		{
			$total_dr = $DRDetails->total_dr;
		}
		$opening_balancee = $total_dr-$total_cr;*/
		$opening_balancee = $total_cr;



		return $opening_balancee;
	}

	public function ajax_invoiceledger()
	{

		setlocale(LC_MONETARY, 'en_IN');


		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$sales_cost_id = SALES_COST_ID;
		$sales_cost_name = SALES_COST_NAME;
		$sales_cost_link = SALES_COST_LINK;
		$actrev_cost_id = ACT_RECEIVABLE_COST_ID;
		$actrev_cost_name = ACT_RECEIVABLE_COST_NAME;
		$actrev_cost_link = ACT_RECEIVABLE_COST_LINK;
		$expense_cost_id = EXPENSE_COST_ID;
		$expense_cost_name = EXPENSE_COST_NAME;
		$expense_cost_link = EXPENSE_COST_LINK;
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');


		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		$report_url = 'invoice_ledger';
		$ledger_title = 'Invoicing Ledger';
		$ledger_menu = 'invoice_ledger';
		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();

		if (is_array($bank_accounts)) :
			foreach ($bank_accounts as $bank_account) {
				$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
			}
		endif;


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}
		// echo "<pre>";print_r($CostDetails_arr);echo "</pre>";
		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);
		// echo "<pre>";print_r($opening_balancee_data);echo "</pre>";

		$ReportDetails_sales = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(((report_type = "1" and amount_type="sales") or report_type = "5" or report_type="11") or (report_type="3" and ledger_type="1" and (cost_id = "' . $sales_cost_id . '" or cost_id = "' . $actrev_cost_id . '")))'));
		// echo $this->db->last_query();
		$ReportDetails_expense = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(((report_type = "1" and amount_type="expense") or report_type = "7" or report_type="12") or (report_type="3" and ledger_type="1" and (cost_id = "' . $expense_cost_id . '" or (cost_id != "' . $sales_cost_id . '"  and cost_id != "' . $actrev_cost_id . '"))))'));
		// $ReportDetails_expense = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(((report_type = "1" and amount_type="expanse") or report_type = "7") or (report_type="3" and ledger_type="1"))'));
		// echo $this->db->last_query();
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2" or report_type="11" or report_type="12")'));


		$cost_txt = '';
		$cost_txt_other = '';
		$loop_start = $array_count = 0;
		$sales_total = $expense_total = $actrev_total =  $balance = 0;
		$cost_txt = $cost_txt_sales = $cost_txt_expense = $cost_txt_actrev = '';
		$excel_array = array();
		$excel_arr_sales = array();
		$excel_arr_actrev = array();
		$excel_arr_expense = array();
		$bank_kk = 0;

		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		/************** account receivanle and sales report ************/
		if ($ReportDetails_sales) {
			$sales_cost_head = $sales_cost_name . "(" . $sales_cost_link . ")";
			$excel_arr_sales[] = array($sales_cost_head, '', '');
			$excel_arr_sales[] = array('', '', '');
			$excel_arr_sales[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

			$actrev_cost_head = $actrev_cost_name . "(" . $actrev_cost_link . ")";
			$excel_arr_actrev[] = array($actrev_cost_head, '', '');
			$excel_arr_actrev[] = array('', '', '');
			$excel_arr_actrev[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');


			$cost_txt_sales .= "<center><h3>" . $sales_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
			$cost_txt_actrev .= "<center><h3>" . $actrev_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";

			$opening_balancee_ss = $this->bankstat_openingbanlance_invoice_single($start_date, $filtered_client_id);
			$actrev_total = (float)$opening_balancee_ss;
			$total_amount = (float)$opening_balancee_ss;
			$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
			$sales_total_txt_ss = "R" . number_format((float)$actrev_total, 2);
			$cost_txt_actrev .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt_ss . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $sales_total_txt_ss . "</td></tr>";
			$excel_arr_actrev[] = array('', '', 'Opening Balance', $open_amt_ss, '', $sales_total_txt_ss);


			foreach ($ReportDetails_sales as $ReportDetail) {
				$amount = $ReportDetail->amount;
				$cost_id = $ReportDetail->cost_id;
				$description = $ReportDetail->description;
				$report_date = $ReportDetail->report_date;
				$report_type = $ReportDetail->report_type;
				$amount_type = $ReportDetail->amount_type;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;



				if ($report_type == '11') //customer invoice allocatable receipt
				{

					$actrev_total -= (float)$amount;
					$actrev_balance = "R" . number_format((float)$actrev_total, 2);
					$actrev_cr_amt = "R" . number_format((float)$amount, 2);
					$actrev_dr_amt = '';

					$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
					$excel_arr_actrev[] = array($report_date, $ref_no, $description, $actrev_dr_amt, $actrev_cr_amt, $actrev_total);
				} else if ($report_type == '3') //journal bank datas 
				{
					// journal sales record
					if ($cost_id  == $sales_cost_id) {
						if ($amount_type == 'expense') {
							$sales_total -= (float)$amount;
							$sales_balance = "R" . number_format((float)$sales_total, 2);
							$sales_cr_amt = "R" . number_format((float)$amount, 2);
							$sales_dr_amt = '';
						} else {
							$sales_total += (float)$amount;
							$sales_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = "R" . number_format((float)$amount, 2);
							$sales_cr_amt = '';
						}

						$cost_txt_sales .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$excel_arr_sales[] = array($report_date, $ref_no, $description, $sales_dr_amt, $sales_cr_amt, $sales_total);
					} else  //journal account receivable
					{

						if ($amount_type == 'expense') {
							$actrev_total -= (float)$amount;
							$actrev_balance = "R" . number_format((float)$actrev_total, 2);
							$actrev_cr_amt = "R" . number_format((float)$amount, 2);
							$actrev_dr_amt = '';
						} else {
							$actrev_total += (float)$amount;
							$actrev_balance = "R" . number_format((float)$actrev_total, 2);
							$actrev_dr_amt = "R" . number_format((float)$amount, 2);
							$actrev_cr_amt = '';
						}

						$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
						$excel_arr_actrev[] = array($report_date, $ref_no, $description, $actrev_dr_amt, $actrev_cr_amt, $actrev_total);
					}
				} else // sales invoice datas
				{
					$sales_total -= (float)$amount;
					$actrev_total += (float)$amount;
					$sales_balance = "R" . number_format((float)$sales_total, 2);
					$actrev_balance = "R" . number_format((float)$actrev_total, 2);
					$sales_cr_amt = "R" . number_format((float)$amount, 2);
					$sales_dr_amt = '';
					$actrev_dr_amt = "R" . number_format((float)$amount, 2);
					$actrev_cr_amt = '';



					$cost_txt_sales .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";

					$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";


					$excel_arr_sales[] = array($report_date, $ref_no, $description, '', $amount, $sales_total);

					$excel_arr_actrev[] = array($report_date, $ref_no, $description, $amount, '', $actrev_total);
				}
			}


			$oformat_amount = "R" . number_format((float)$sales_total, 2);
			$oformat_amount_xl = $sales_total;
			$cost_txt_sales .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_arr_sales[] = array('', '', '', '', '', '');
			$excel_arr_sales[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_arr_sales[] = array('', '', '', '', '', '');
			$excel_arr_sales[] = array('', '', '', '', '', '');

			$oformat_amount = "R" . number_format((float)$actrev_total, 2);
			$oformat_amount_xl = $actrev_total;
			$cost_txt_actrev .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_arr_actrev[] = array('', '', '', '', '', '');
			$excel_arr_actrev[] = array('', '', '', '', '', $oformat_amount_xl);
			$excel_arr_actrev[] = array('', '', '', '', '', '');
			$excel_arr_actrev[] = array('', '', '', '', '', '');
		}

		/********** account payable and other cost report ********/
		$previous_child = '';
		$next_child = '';
		// $total_amount = 0;
		if ($ReportDetails_expense) {
			$expense_cost_head = $expense_cost_name . "(" . $expense_cost_link . ")";
			$excel_arr_expense[] = array($expense_cost_head, '', '');
			$excel_arr_expense[] = array('', '', '');
			$excel_arr_expense[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');

			$cost_txt_expense .= "<center><h3>" . $expense_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
			foreach ($ReportDetails_expense as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$cost_name = $links = '';
				$report_type = $ReportDetail->report_type;

				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}


				if ($next_child != '' && $next_child != $cost_id && $cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {
					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
					$excel_array[] = array('', '', '', '', '', '');
					$excel_array[] = array('', '', '', '', '', $oformat_amount_xl);
					$excel_array[] = array('', '', '', '', '', '');
					$excel_array[] = array('', '', '', '', '', '');
				}

				if (($previous_child == '' || $previous_child != $cost_id) && $cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {
					$total_amount = 0;
					$balance = 0;
					$childcost = $CostDetails_arr[$cost_id];
					$previous_child = $cost_id;
					$next_child = $cost_id;
					$child_costname = $childcost->cost_name;
					//$links = $childcost->links;
					$excel_array[] = array($child_costname, '', '');
					$excel_array[] = array('', '', '');
					$excel_array[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');
					$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
				}

				if ($report_type == '12') {
					$expense_total += (float)$amount;
					$expense_balance = "R" . number_format((float)$expense_total, 2);
					$expense_dr_amt = "R" . number_format((float)$amount, 2);
					$expense_cr_amt = '';
					$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
					$excel_arr_expense[] = array($report_date, $ref_no, $description, $expense_dr_amt, $expense_cr_amt, $expense_total);
				} else {

					// journal account payable datas
					if ($report_type == '3' && $cost_id  == $expense_cost_id) {
						if ($amount_type == 'expense') {
							$expense_total -= (float)$amount;
							$expense_balance = "R" . number_format((float)$expense_total, 2);
							$expense_cr_amt = "R" . number_format((float)$amount, 2);
							$expense_dr_amt = '';
						} else {
							$expense_total += (float)$amount;
							$expense_balance = "R" . number_format((float)$expense_total, 2);
							$expense_dr_amt = "R" . number_format((float)$amount, 2);
							$expense_cr_amt = '';
						}
						$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_expense[] = array($report_date, $ref_no, $description, $expense_dr_amt, $expense_cr_amt, $expense_total);
					}
					if ($report_type != '3') {
						$expense_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$expense_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_expense[] = array($report_date, $ref_no, $description, $expense_dr_amt, $expense_cr_amt, $expense_total);
					}



					// expense data with cost id
					if ($cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {

						if ($amount_type == 'sales') {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
						} else {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
						}

						$cost_txt_other .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";

						$excel_array[] = array($report_date, $ref_no, $description, $dr_amount, $cr_amount, $total_amount);
					}
				}
			}

			$oformat_amount = "R" . number_format((float)$expense_total, 2);
			$cost_txt_expense .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_arr_expense[] = array('', '', '', '', '', '');
			$excel_arr_expense[] = array('', '', '', '', '', $expense_total);
			$excel_arr_expense[] = array('', '', '', '', '', '');
			$excel_arr_expense[] = array('', '', '', '', '', '');
		}


		if ($cost_txt_other != '') {
			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', $total_amount);
			$excel_array[] = array('', '', '', '', '', '');
			$excel_array[] = array('', '', '', '', '', '');
		}

		$cost_txt_bankstatement = '';
		$excel_arr_bank = array();
		$bank_total = 0;

		foreach ($bank_arr as $key => $bval) {
			$bank_total = 0;
			$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'bank_id' => $key, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2" or report_type="11" or report_type="12")'));


			if ($ReportDetails_bank) {
				// $bankstatement_cost_head = $bankstatement_cost_name."(".$bankstatement_cost_link.")";
				$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link_arr[$bank_kk] . ")";
				$excel_arr_bank[] = array($bankstatement_cost_head, '', '');
				$excel_arr_bank[] = array('', '', '');
				$excel_arr_bank[] = array('Date', 'RefNo', 'Details', 'Dr', 'Cr', 'Balance');
				$bank_kk++;
				$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";



				$bank_total += (float)$opening_balancee_data;
				$open_amt = "R" . number_format((float)$opening_balancee_data, 2);
				$bank_total_txt = "R" . number_format((float)$bank_total, 2);
				$cost_txt_bankstatement .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $bank_total_txt . "</td></tr>";
				$excel_arr_bank[] = array('', '', 'Opening Balance', $opening_balancee_data, '', $bank_total);

				foreach ($ReportDetails_bank as $ReportDetail) {
					$report_id = $ReportDetail->report_id;
					$cost_id = $ReportDetail->cost_id;
					$subcategory_id = $ReportDetail->subcategory_id;
					$cost_id = $ReportDetail->cost_id;
					$amount = $ReportDetail->amount;
					$description = $ReportDetail->description;
					$amount_type = $ReportDetail->amount_type;
					$report_date = $ReportDetail->report_date;
					$report_date = date('d-M-Y', strtotime($report_date));
					$ref_no = $ReportDetail->ref_no;
					$amount = number_format((float)$amount, 2, '.', '');
					$report_type = $ReportDetail->report_type;
					$ledger_type = $ReportDetail->ledger_type;
					$cost_name = $links = '';

					if ($report_type == '11') {

						$bank_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$bank_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						$excel_arr_bank[] = array($report_date, $ref_no, $description, $amount, '', $bank_total);
					} else if ($report_type == '12') {

						$bank_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$bank_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						$excel_arr_bank[] = array($report_date, $ref_no, $description, '', $amount, $bank_total);
					} else {

						if ($amount_type == 'sales') {
							$bank_total += (float)$amount;
							$sales_balance = "R" . number_format((float)$bank_total, 2);
							$sales_dr_amt = "R" . number_format((float)$amount, 2);
							$sales_cr_amt = '';
							$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
							$excel_arr_bank[] = array($report_date, $ref_no, $description, $amount, '', $bank_total);
						}
						if ($amount_type == 'expense') {
							$bank_total -= (float)$amount;
							$expense_balance = "R" . number_format((float)$bank_total, 2);
							$expense_cr_amt = "R" . number_format((float)$amount, 2);
							$expense_dr_amt = '';
							$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
							$excel_arr_bank[] = array($report_date, $ref_no, $description, '', $amount, $bank_total);
						}
					}
				}
				$oformat_amount = "R" . number_format((float)$bank_total, 2);
				$oformat_amount_xl = $bank_total;

				$excel_arr_bank[] = array('', '', '', '', '', '');
				$excel_arr_bank[] = array('', '', '', '', '', $oformat_amount_xl);
				$excel_arr_bank[] = array('', '', '', '', '', '');
				$excel_arr_bank[] = array('', '', '', '', '', '');


				$oformat_bank_total = "R" . number_format((float)$bank_total, 2);
				$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_bank_total . "</td></tr></tfoot></table>";
			}
		}








		$excel_array = array_merge($excel_arr_actrev, $excel_arr_sales, $excel_arr_expense, $excel_array, $excel_arr_bank);
		$cost_txt = $cost_txt . $cost_txt_actrev . $cost_txt_sales . $cost_txt_expense . $cost_txt_other . $cost_txt_bankstatement;


		$excel_fname = 'ledger_report.xls';
		$pdf_fname = 'ledger_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Ledger');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('D'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);

		echo $cost_txt;
		exit();
	}
	public function bankstat_openingbanlance_invoice($start_date, $filtered_client_id)
	{
		$array_merge = [];
		// $start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr_invoicefinalcial($start_date, $filtered_client_id);
		$DRDetails = $this->reports_model->total_dr_invoicefinalcial($start_date, $filtered_client_id);
		$total_cr = $total_dr = 0;
		if ($CRDetails) {
			$total_cr = $CRDetails->total_cr;
		}
		if ($DRDetails) {
			$total_dr = $DRDetails->total_dr;
		}
		$opening_balancee = $total_dr - $total_cr;



		return $opening_balancee;
	}
	public function ajax_invoiceledger_pdf()
	{

		setlocale(LC_MONETARY, 'en_IN');


		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$sales_cost_id = SALES_COST_ID;
		$sales_cost_name = SALES_COST_NAME;
		$sales_cost_link = SALES_COST_LINK;
		$actrev_cost_id = ACT_RECEIVABLE_COST_ID;
		$actrev_cost_name = ACT_RECEIVABLE_COST_NAME;
		$actrev_cost_link = ACT_RECEIVABLE_COST_LINK;
		$expense_cost_id = EXPENSE_COST_ID;
		$expense_cost_name = EXPENSE_COST_NAME;
		$expense_cost_link = EXPENSE_COST_LINK;
		$bankstatement_cost_id = BANKSTATEMENT_COST_ID;
		$bankstatement_cost_name = BANKSTATEMENT_COST_NAME;
		$bankstatement_cost_link = BANKSTATEMENT_COST_LINK;
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');


		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		$report_url = 'invoice_ledger';
		$ledger_title = 'Invoicing Ledger';
		$ledger_menu = 'invoice_ledger';
		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();
		foreach ($bank_accounts as $bank_account) {
			$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}
		// echo "<pre>";print_r($CostDetails_arr);echo "</pre>";
		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);
		// echo "<pre>";print_r($opening_balancee_data);echo "</pre>";

		$ReportDetails_sales = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(((report_type = "1" and amount_type="sales") or report_type = "5" or report_type="11") or (report_type="3" and ledger_type="1" and (cost_id = "' . $sales_cost_id . '" or cost_id = "' . $actrev_cost_id . '")))'));
		// echo $this->db->last_query();
		$ReportDetails_expense = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(((report_type = "1" and amount_type="expense") or report_type = "7"  or report_type="12") or (report_type="3" and ledger_type="1" and (cost_id = "' . $expense_cost_id . '" or (cost_id != "' . $sales_cost_id . '"  and cost_id != "' . $actrev_cost_id . '"))))'));
		// $ReportDetails_expense = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(((report_type = "1" and amount_type="expanse") or report_type = "7") or (report_type="3" and ledger_type="1"))'));
		// echo $this->db->last_query();
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));


		$cost_txt = '';
		$cost_txt_other = '';
		$loop_start = $array_count = 0;
		$sales_total = $expense_total = $actrev_total =  $balance = 0;
		$cost_txt = $cost_txt_sales = $cost_txt_expense = $cost_txt_actrev = '';
		$excel_array = array();
		$excel_arr_sales = array();
		$excel_arr_actrev = array();
		$excel_arr_expense = array();

		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12">';

		/************** account receivanle and sales report ************/
		if ($ReportDetails_sales) {
			$sales_cost_head = $sales_cost_name . "(" . $sales_cost_link . ")";


			$actrev_cost_head = $actrev_cost_name . "(" . $actrev_cost_link . ")";



			$cost_txt_sales .= "<center><h3>" . $sales_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
			$cost_txt_actrev .= "<center><h3>" . $actrev_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";

			$opening_balancee_ss = $this->bankstat_openingbanlance_invoice_single($start_date, $filtered_client_id);
			$actrev_total = (float)$opening_balancee_ss;
			$total_amount = (float)$opening_balancee_ss;
			$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
			$sales_total_txt_ss = "R" . number_format((float)$actrev_total, 2);
			$cost_txt_actrev .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt_ss . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $sales_total_txt_ss . "</td></tr>";

			foreach ($ReportDetails_sales as $ReportDetail) {
				$amount = $ReportDetail->amount;
				$cost_id = $ReportDetail->cost_id;
				$description = $ReportDetail->description;
				$report_date = $ReportDetail->report_date;
				$report_type = $ReportDetail->report_type;
				$amount_type = $ReportDetail->amount_type;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$report_type = $ReportDetail->report_type;

				if ($report_type == '11') //customer invoice allocatable receipt
				{

					$actrev_total -= (float)$amount;
					$actrev_balance = "R" . number_format((float)$actrev_total, 2);
					$actrev_cr_amt = "R" . number_format((float)$amount, 2);
					$actrev_dr_amt = '';

					$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
				} else if ($report_type == '3') //journal bank datas 
				{
					// journal sales record
					if ($cost_id  == $sales_cost_id) {
						if ($amount_type == 'expense') {
							$sales_total -= (float)$amount;
							$sales_balance = "R" . number_format((float)$sales_total, 2);
							$sales_cr_amt = "R" . number_format((float)$amount, 2);
							$sales_dr_amt = '';
						} else {
							$sales_total += (float)$amount;
							$sales_balance = "R" . number_format((float)$sales_total, 2);
							$sales_dr_amt = "R" . number_format((float)$amount, 2);
							$sales_cr_amt = '';
						}

						$cost_txt_sales .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
					} else  //journal account receivable
					{

						if ($amount_type == 'expense') {
							$actrev_total -= (float)$amount;
							$actrev_balance = "R" . number_format((float)$actrev_total, 2);
							$actrev_cr_amt = "R" . number_format((float)$amount, 2);
							$actrev_dr_amt = '';
						} else {
							$actrev_total += (float)$amount;
							$actrev_balance = "R" . number_format((float)$actrev_total, 2);
							$actrev_dr_amt = "R" . number_format((float)$amount, 2);
							$actrev_cr_amt = '';
						}

						$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
					}
				} else // sales invoice datas
				{
					$sales_total -= (float)$amount;
					$actrev_total += (float)$amount;
					$sales_balance = "R" . number_format((float)$sales_total, 2);
					$actrev_balance = "R" . number_format((float)$actrev_total, 2);
					$sales_cr_amt = "R" . number_format((float)$amount, 2);
					$sales_dr_amt = '';
					$actrev_dr_amt = "R" . number_format((float)$amount, 2);
					$actrev_cr_amt = '';



					$cost_txt_sales .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";

					$cost_txt_actrev .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $actrev_dr_amt . "</td><td  style='text-align:right;'>" . $actrev_cr_amt . "</td><td  style='text-align:right;'>" . $actrev_balance . "</td></tr>";
				}
			}


			$oformat_amount = "R" . number_format((float)$sales_total, 2);
			$oformat_amount_xl = $sales_total;
			$cost_txt_sales .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";


			$oformat_amount = "R" . number_format((float)$actrev_total, 2);
			$oformat_amount_xl = $actrev_total;
			$cost_txt_actrev .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
		}

		/********** account payable and other cost report ********/
		$previous_child = '';
		$next_child = '';
		// $total_amount = 0;
		if ($ReportDetails_expense) {
			$expense_cost_head = $expense_cost_name . "(" . $expense_cost_link . ")";


			$cost_txt_expense .= "<center><h3>" . $expense_cost_head . "</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
			foreach ($ReportDetails_expense as $ReportDetail) {
				$report_id = $ReportDetail->report_id;
				$cost_id = $ReportDetail->cost_id;
				$subcategory_id = $ReportDetail->subcategory_id;
				$amount = $ReportDetail->amount;
				$description = $ReportDetail->description;
				$amount_type = $ReportDetail->amount_type;
				$report_date = $ReportDetail->report_date;
				$report_date = date('d-M-Y', strtotime($report_date));
				$ref_no = $ReportDetail->ref_no;
				$amount = number_format((float)$amount, 2, '.', '');
				$cost_name = $links = '';
				$report_type = $ReportDetail->report_type;

				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}


				if ($next_child != '' && $next_child != $cost_id && $cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {
					$oformat_amount = "R" . number_format((float)$total_amount, 2);
					$oformat_amount_xl = $total_amount;
					$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
				}

				if (($previous_child == '' || $previous_child != $cost_id) && $cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {
					$total_amount = 0;
					$balance = 0;
					$childcost = $CostDetails_arr[$cost_id];
					$previous_child = $cost_id;
					$next_child = $cost_id;
					$child_costname = $childcost->cost_name;
					//$links = $childcost->links;

					$cost_txt_other .= "<center><h3>" . $child_costname . "<small>(" . $links . ")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
				}

				if ($report_type == '12') {
					$expense_total += (float)$amount;
					$expense_balance = "R" . number_format((float)$expense_total, 2);
					$expense_dr_amt = "R" . number_format((float)$amount, 2);
					$expense_cr_amt = '';
					$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
				} else {
					// journal account payable datas
					if ($report_type == '3' && $cost_id  == $expense_cost_id) {
						if ($amount_type == 'expense') {
							$expense_total -= (float)$amount;
							$expense_balance = "R" . number_format((float)$expense_total, 2);
							$expense_cr_amt = "R" . number_format((float)$amount, 2);
							$expense_dr_amt = '';
						} else {
							$expense_total += (float)$amount;
							$expense_balance = "R" . number_format((float)$expense_total, 2);
							$expense_dr_amt = "R" . number_format((float)$amount, 2);
							$expense_cr_amt = '';
						}
						$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
					}
					if ($report_type != '3') {
						$expense_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$expense_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_expense .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
					}



					// expense data with cost id
					if ($cost_id != '' && $cost_id > 0 && $cost_id != $expense_cost_id) {

						if ($amount_type == 'expense') {
							$total_amount -= (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$cr_amount = "R" . number_format((float)$amount, 2);
							$dr_amount = '';
						} else {
							$total_amount += (float)$amount;
							$balance = "R" . number_format((float)$total_amount, 2);
							$dr_amount = "R" . number_format((float)$amount, 2);
							$cr_amount = '';
						}

						$cost_txt_other .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $dr_amount . "</td><td  style='text-align:right;'>" . $cr_amount . "</td><td  style='text-align:right;'>" . $balance . "</td></tr>";
					}
				}
			}

			$oformat_amount = "R" . number_format((float)$expense_total, 2);
			$cost_txt_expense .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
		}


		if ($cost_txt_other != '') {
			$oformat_amount = "R" . number_format((float)$total_amount, 2);
			$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_amount . "</td></tr></tfoot></table>";
		}

		$cost_txt_bankstatement = '';
		$excel_arr_bank = array();
		$bank_total = 0;
		$bank_kk = 0;

		foreach ($bank_arr as $key => $bval) {
			$bank_total = 0;

			// $ReportDetails_bank = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'bank_id' => $key, 'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(report_type = "2")'));
			$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'bank_id' => $key, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

			if ($ReportDetails_bank) {
				// $bankstatement_cost_head = $bankstatement_cost_name."(".$bankstatement_cost_link.")";
				$bankstatement_cost_head = $bankstatement_cost_name . "(" . $bankstatement_cost_link_arr[$bank_kk] . ")";
				$bank_kk++;

				$cost_txt_bankstatement .= "<center><h3>" . $bankstatement_cost_head . " </h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo </th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";



				$bank_total += (float)$opening_balancee_data;
				$open_amt = "R" . number_format((float)$opening_balancee_data, 2);
				$bank_total_txt = "R" . number_format((float)$bank_total, 2);
				$cost_txt_bankstatement .= "<tr><td></td><td></td><td>Opening Balance</td><td  style='text-align:right;'>" . $open_amt . "</td><td  style='text-align:right;'></td><td  style='text-align:right;'>" . $bank_total_txt . "</td></tr>";

				foreach ($ReportDetails_bank as $ReportDetail) {
					$report_id = $ReportDetail->report_id;
					$cost_id = $ReportDetail->cost_id;
					$subcategory_id = $ReportDetail->subcategory_id;
					$cost_id = $ReportDetail->cost_id;
					$amount = $ReportDetail->amount;
					$description = $ReportDetail->description;
					$amount_type = $ReportDetail->amount_type;
					$report_date = $ReportDetail->report_date;
					$report_date = date('d-M-Y', strtotime($report_date));
					$ref_no = $ReportDetail->ref_no;
					$amount = number_format((float)$amount, 2, '.', '');
					$report_type = $ReportDetail->report_type;
					$ledger_type = $ReportDetail->ledger_type;
					$cost_name = $links = '';

					if ($report_type == '11') {

						$bank_total += (float)$amount;
						$sales_balance = "R" . number_format((float)$bank_total, 2);
						$sales_dr_amt = "R" . number_format((float)$amount, 2);
						$sales_cr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
					} else if ($report_type == '12') {

						$bank_total -= (float)$amount;
						$expense_balance = "R" . number_format((float)$bank_total, 2);
						$expense_cr_amt = "R" . number_format((float)$amount, 2);
						$expense_dr_amt = '';
						$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
					} else {
						if ($amount_type == 'sales') {
							$bank_total += (float)$amount;
							$sales_balance = "R" . number_format((float)$bank_total, 2);
							$sales_dr_amt = "R" . number_format((float)$amount, 2);
							$sales_cr_amt = '';
							$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $sales_dr_amt . "</td><td  style='text-align:right;'>" . $sales_cr_amt . "</td><td  style='text-align:right;'>" . $sales_balance . "</td></tr>";
						}
						if ($amount_type == 'expense') {
							$bank_total -= (float)$amount;
							$expense_balance = "R" . number_format((float)$bank_total, 2);
							$expense_cr_amt = "R" . number_format((float)$amount, 2);
							$expense_dr_amt = '';
							$cost_txt_bankstatement .= "<tr><td>" . $report_date . "</td><td>" . $ref_no . "</td><td>" . $description . "</td><td  style='text-align:right;'>" . $expense_dr_amt . "</td><td  style='text-align:right;'>" . $expense_cr_amt . "</td><td  style='text-align:right;'>" . $expense_balance . "</td></tr>";
						}
					}
				}
				$oformat_amount = "R" . number_format((float)$bank_total, 2);
				$oformat_amount_xl = $bank_total;




				$oformat_bank_total = "R" . number_format((float)$bank_total, 2);
				$cost_txt_bankstatement .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>" . $oformat_bank_total . "</td></tr></tfoot></table>";
			}
		}








		$excel_array = array_merge($excel_arr_actrev, $excel_arr_sales, $excel_arr_expense, $excel_array, $excel_arr_bank);
		$cost_txt = $cost_txt . $cost_txt_actrev . $cost_txt_sales . $cost_txt_expense . $cost_txt_other . $cost_txt_bankstatement;


		$pdf_fname = 'ledger_report.pdf';
		/********************* PDF start ********/
		$this->load->library('m_pdf');
		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}

	/******************** trial balance start ****************/
	public function ajax_trialbalance_bankstat()
	{

		setlocale(LC_MONETARY, 'en_IN');
		// $excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$excel_array_head = $excel_array = array();
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		// if($report_type == '1'){$report_url = 'invoice_financial';$ledger_title = 'Invoicing Financial';$ledger_menu='invoice_financial';}
		// else{$report_url = 'banktrans_financial';$ledger_title = "Bank Transaction Financial";$ledger_menu='banktrans_financial';}
		$report_url = 'banktrans_financial';
		$ledger_title = "Bank Transaction Trial Balance";
		$ledger_menu = 'banktrans_financial';

		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();
		if (is_array($bank_accounts)) :
			foreach ($bank_accounts as $bank_account) {
				$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
			}
		endif;

		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$format_total = 0;
		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12"><table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Cost Name</th><th>Links</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';
		$excel_array_head[] = array('Cost Name', 'Links', 'Amount');

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo $this->db->last_query();
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));

		$current_year_cids = array();

		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR,report_type,ledger_type',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					// ${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					// ${"excel_array_" . $sup_key}[] = array( $child_costname, '' , '');
					// ${"excel_array_" . $sup/key}[] = array( '', '' , '');
					// ${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;


					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_kk = 0;
						foreach ($bank_arr as $key => $bval) {
							$bank_balance = 0;
							$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date, 'bank_id' => $key), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
							// echo $this->db->last_query();
							$opening_balancee_data = $this->bankstat_openingbanlance_bank($start_date, $filtered_client_id, $key);
							$bank_balance +=  $opening_balancee_data;
							foreach ($ReportDetails_bank as $ReportDetails_b) {
								$salesTotal = $ReportDetails_b->salesTotal;
								$expenseTotal = $ReportDetails_b->expenseTotal;
								$bank_balance =  $bank_balance + $salesTotal - $expenseTotal;
								$amount = $bank_balance;
								$amount = number_format((float)$amount, 2, '.', '');
								$cost_name = BANKSTATEMENT_COST_NAME;
								$links = BANKSTATEMENT_COST_LINK;
								$links = $bankstatement_cost_link_arr[$bank_kk];
								$total_amount += (float)$amount;
								$oformat_amount = "R" . number_format((float)$amount, 2);
								$oformat_amount_xl = $amount;
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
								// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
								// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);
								// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
								// $excel_arrcount++;
								$cost_txt .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
								$format_total += $amount;
								// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";

								$excel_array[] = array($cost_name, $links, $oformat_amount_xl);
								$bank_kk++;
							}
						}
					}
					if ($ReportDetails) {
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$report_type = $ReportDetail->report_type;
							$ledger_type = $ReportDetail->ledger_type;
							$category_id = $ReportDetail->category_id;
							$opening_balancee_ss = 0;
							$current_year_cids[] = $cost_id;

							if ($category_id == '2') {


								$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
								// $total_amount = (float)$opening_balancee_ss;

							}


							$amount =  (float)$amount_cr - (float)$amount_dr;
							$amount += $opening_balancee_ss;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
							}

							$total_amount += (float)$amount;


							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;



							if ($subcategory_id == '5') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$cost_txt   .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							$format_total += $amount;
							$excel_array[] = array($cost_name, $links, $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;

						}
					}
					// $oformat_amount = "R".number_format((float)$total_amount, 2);
					// $oformat_amount_xl = $total_amount;
					// ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

					// $excel_tfoot[] = $excel_arrcount;

					// ${"excel_array_" . $sup_key}[] = array( 'Total', '' , $oformat_amount_xl);
					// ${"excel_array_" . $sup_key}[] = array( '', '' , '');${"excel_array_" . $sup_key}[] = array( '', '' , '');

					// $excel_tfoot[] = $excel_arrcount;
					// $excel_arrcount += 3;



					// if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
					// if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }





				}
			}



			/*if($sup_key == 'asset')
{

$excel_appd_arr['total_ast_ct'] = $excel_arrcount;


	$total_assets = "R".number_format((float)$total_asset, 2);
	$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>".$total_assets."</th></tr></tbody></table>";

	$excel_array_total_ast[] = array( 'Total Asset', '' , $total_asset);
                	$excel_array_total_ast[] = array( '', '' , '');$excel_array_total_ast[] = array( '', '' , '');

                	$excel_assetfoot[] = $excel_arrcount;
            		$excel_arrcount += 3;

 
$excel_appd_arr['array_libt_ct'] = $excel_arrcount;

}*/


			/*if($sup_key == 'libt')
{

 $excel_appd_arr['array_eqt_ct'] = $excel_arrcount;

	    $excel_titlearr[] = $excel_arrcount;
        $excel_arrcount += 2;
        $excele_tablearr[] = $excel_arrcount;
        $excel_arrcount += 1;

        
        $excel_arrcount++;
        
        // $excel_arrcount++;


        $excel_tfoot[] = $excel_arrcount;
        
        $excel_tfoot[] = $excel_arrcount;
        $excel_arrcount += 3;


        
        $excel_assetfoot[] = $excel_arrcount;
        $excel_arrcount += 3;

        $excel_arrcount++;

      $excel_appd_arr['other_ct'] = $excel_arrcount;  

}*/
		}







		$current_ids = implode(',', $current_year_cids);
		$ReportDetails_previous = $this->reports_model->getLegerBKPreviousCostid($current_ids, $filtered_client_id, $start_date);
		// echo  $this->db->last_query();
		if ($ReportDetails_previous) {
			foreach ($ReportDetails_previous as $ReportDetails_prev) {
				$cost_id = $ReportDetails_prev->cost_id;
				$childcost = $CostDetails_arr[$cost_id];
				$child_costname = $childcost->cost_name;
				$category_id = $ReportDetails_prev->category_id;
				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}




				$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
				$sales_total_ss = (float)$opening_balancee_ss;
				// $total_amount = (float)$opening_balancee_ss;
				$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
				// $open_amt_ss_xl = "R".number_format((float)$opening_balancee_ss, 2);
				$cost_txt   .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $open_amt_ss . "</td></tr>";
				$format_total += $opening_balancee_ss;
				$excel_array[] = array($cost_name, $links, $opening_balancee_ss);
			}
		}


		// $unallocated_difference = 0;

		// $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float)$profit, 2);
		// $format_total += $profit;
		// $excel_array[] = array( 'Profit', 'q.200.000' , $profit);

		// $cost_txt .= "<tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr>";

		// $total_quity_xl = (float)$unallocated_difference+(float)$profit;
		// $ototal_quity = "R".number_format((float)$total_quity_xl, 2);


		// $total_libeqt_xl = (float)$total_quity_xl+(float)$total_liabilities;
		// $ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);


		// $total_unalloc_xl = (float)$total_asset-(float)$total_libeqt_xl;
		// $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ototal_unalloc."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";



		// $totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		//$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";
		// $totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";



		// $totallibeqt_txt .= "<table class='table table-striped table-hover stl_costtbl' style='margin-top:45px;margin-bottom:45px;'><tbody><tr><th  colspan='2' style='font-size:18px;'>Unallocated Difference</th><th style='text-align:right;font-size:18px;'>".$ototal_unalloc."</th></tr></tbody></table>";


		// $excel_array_eqt[] = array( 'Equity', '' , '');
		// $excel_array_eqt[] = array( '', '' , '');
		// $excel_array_eqt[] = array( 'Cost Name', 'Links' , 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		// $excel_array_eqt[] = array( 'Profit', 'q.200.000' , $profit);
		// $excel_array_eqt[] = array( 'Total', '' , $total_quity_xl);
		// $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');
		// $excel_array_eqt[] = array( 'Total Liabilities and Equity', '' , $total_libeqt_xl);
		// $excel_array_eqt[] = array( 'Unallocated Difference', '' , $total_unalloc_xl);
		// $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');





		// $tax = (((float)$profit*28 )/100);
		// $otax = "R".number_format((float)$tax, 2);
		// $profit_tax = (float)$profit - (float)$tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);


		// $final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";


		/*$excel_appd_arr['final_ct'] = $excel_arrcount; 
        $excel_array_final[] = array( 'Profit Before Taxation', '' , $profit);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
        $excel_array_final[] = array( 'Taxation', '' , $tax);
        $excel_arrcount++;
        $excel_array_final[] = array( 'Profit After Taxation', '' , $profit_tax);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
       
$subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

       $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;*/

		// $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
		// $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";
		$oformat_total = "R" . number_format((float)$format_total, 2);
		$excel_array[] = array('Total', '', $format_total);

		$cost_txt .= "</tbody><tfoot><tr><th colspan='2'>Total</th><th  style='text-align:right;'>" . $oformat_total . "</th></tr></tfoot></table>";

		// $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
		// $excel_array[] = array( 'Profit', '' , $profit);

		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;


		$excel_fname = 'trialbalance_report.xls';
		$pdf_fname = 'trialbalance_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Trial Balance');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
		//$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
		$this->excel->getActiveSheet()->setCellValue('A2', $ledger_title);
		$this->excel->getActiveSheet()->setCellValue('A3', 'From ' . $start_fulldate . ' - ' . $end_fulldate);
		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');


		//merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->mergeCells('A2:F2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		// $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		for ($col = ord('C'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		for ($col = ord('A'); $col <= ord('G'); $col++) {
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
		}

		/*foreach($excel_titlearr as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setSize(13);
        }

        	foreach($excel_assetfoot as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val.':C'.$val)->getFont()->setSize(13);
        	$this->excel->getActiveSheet()->getStyle('A'.$val.':C'.$val)->getFont()->setBold(true);
        }

        foreach($excele_tablearr as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('B'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('C'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('C'.$val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	$this->excel->getActiveSheet()->getStyle('A'.$val.':C'.$val)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('507682');
        }
        foreach($excel_tfoot as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('B'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('C'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('C'.$val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
        foreach($excel_ttfoot as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val.':C'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('A'.$val.':C'.$val)->getFont()->setSize(10);
        	$this->excel->getActiveSheet()->getStyle('C'.$val)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }*/


		// $excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0,'array_libt_ct' => 0,'array_eqt_ct' => $array_eqt_ct,'other_ct' => $other_ct, 'final_ct' => $final_ct);

		/*$this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4'); 
            $this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A'.$excel_appd_arr['total_ast_ct']);  
            $this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A'.$excel_appd_arr['array_libt_ct']); 
            $this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A'.$excel_appd_arr['array_eqt_ct']); 
            $this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A'.$excel_appd_arr['other_ct']);  
            $this->excel->getActiveSheet()->fromArray($excel_array_final, null, 'A'.$excel_appd_arr['final_ct']);*/


		$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C6')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle('A6:C6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('507682');
		$this->excel->getActiveSheet()->fromArray($excel_array_head, null, 'A6');
		$this->excel->getActiveSheet()->fromArray($excel_array, null, 'A7');


		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


		$objWriter->save(FCPATH . 'uploads/' . $excel_fname);



		echo $cost_txt;
		exit();
	}
	public function ajax_trialbalance_pdf_bankstat()
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$bankstatement_cost_link_arr = array('ca.810.001', 'ca.810.002', 'ca.810.003', 'ca.810.004', 'ca.810.005', 'ca.810.006', 'ca.810.007', 'ca.810.008', 'ca.810.009', 'ca.810.0010', 'ca.810.0011', 'ca.810.0012', 'ca.810.0013', 'ca.810.0014', 'ca.810.0015', 'ca.810.0016', 'ca.810.0017', 'ca.810.0018', 'ca.810.0019', 'ca.810.0020', 'ca.810.0021');

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year = $_POST['year'];
		$inputh_year = $year;
		$years = explode("-", $year);

		if ($report_type == '1') {
			$report_url = 'invoice_financial';
			$ledger_title = 'Invoicing Financial';
			$ledger_menu = 'invoice_financial';
		} else {
			$report_url = 'banktrans_financial';
			$ledger_title = "Bank Transaction Trial Balance";
			$ledger_menu = 'banktrans_financial';
		}
		$bank_accounts = $this->reports_model->getDetails('bank_accounts', array('client_id' => $filtered_client_id));
		$bank_arr = array();
		foreach ($bank_accounts as $bank_account) {
			$bank_arr[$bank_account->bank_id] = $bank_account->currency_color;
		}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $years[1]);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $years[0];
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start . "-" . $filtered_start_month . "-01";
		$end_date = $year_end . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$current_year_cids = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$format_total = 0;
		// $excel_array = array();
		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';
		// $excel_array = array();

		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="' . $inputh_year . '"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">' . $filtered_client_name . '</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">' . $ledger_title . ' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From ' . $start_fulldate . ' - ' . $end_fulldate . '</p><br></div><div class="col-md-12"><table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Cost Name</th><th>Links</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		// $ReportDetails_bank = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,'.BANKSTATEMENT_COST_CAT_ID.' as category_id,'.BANKSTATEMENT_COST_SUBCAT_ID.' as subcategory_id, '.BANKSTATEMENT_COST_ID.' as cost_id',array('orderby' => 'report_date','disporder' => 'asc','custom_where' => '(report_type = "2" or (report_type="3" and ledger_type="2"))'));

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));

		// $excel_array_head[] = array( 'Cost Name', 'Links' , 'Amount');

		foreach ($subcat_id_loop as $sup_key  => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				// if($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID)
				// 	{
				// 		  $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				// 		  //echo $this->db->last_query();
				//  	}else{
				//       $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				//   }

				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {
					// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1, 'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalDR,report_type,ledger_type',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}

				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					// ${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					// ${"excel_array_" . $sup_key}[] = array( $child_costname, '' , '');
					// ${"excel_array_" . $sup_key}[] = array( '', '' , '');
					// ${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						// $bank_balance +=  $opening_balancee_data;
						$bank_kk = 0;
						foreach ($bank_arr as $key => $bval) {
							$bank_balance = 0;
							$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date, 'bank_id' => $key), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
							// echo $this->db->last_query();
							$opening_balancee_data = $this->bankstat_openingbanlance_bank($start_date, $filtered_client_id, $key);
							$bank_balance +=  $opening_balancee_data;
							foreach ($ReportDetails_bank as $ReportDetails_b) {
								$salesTotal = $ReportDetails_b->salesTotal;
								$expenseTotal = $ReportDetails_b->expenseTotal;
								// $bank_balance =  $bank_balance+$expenseTotal - $salesTotal;
								$bank_balance =  $bank_balance + $salesTotal - $expenseTotal;
								$amount = $bank_balance;
								$amount = number_format((float)$amount, 2, '.', '');
								$cost_name = BANKSTATEMENT_COST_NAME;
								$links = BANKSTATEMENT_COST_LINK;
								$links = $bankstatement_cost_link_arr[$bank_kk];
								$total_amount += (float)$amount;
								$oformat_amount = "R" . number_format((float)$amount, 2);
								$oformat_amount_xl = $amount;
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$format_total += $amount;

								$cost_txt .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
								// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
								// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);
								// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
								// $excel_arrcount++;
								$bank_kk++;
							}
						}
					}
					if ($ReportDetails) {
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$category_id = $ReportDetail->category_id;
							$opening_balancee_ss = 0;
							$current_year_cids[] = $cost_id;

							if ($category_id == '2') {


								$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
								// $total_amount = (float)$opening_balancee_ss;

							}

							$amount =  (float)$amount_cr - (float)$amount_dr;
							$amount += $opening_balancee_ss;
							$amount = number_format((float)$amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
							}

							$total_amount += (float)$amount;


							$oformat_amount = "R" . number_format((float)$amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float)$amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float)$amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							$format_total += $amount;

							$cost_txt .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";

							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;

						}
					}
					/*$oformat_amount = "R".number_format((float)$total_amount, 2);
	            $oformat_amount_xl = $total_amount;
                ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

                $excel_tfoot[] = $excel_arrcount;

                ${"excel_array_" . $sup_key}[] = array( 'Total', '' , $oformat_amount_xl);
                ${"excel_array_" . $sup_key}[] = array( '', '' , '');${"excel_array_" . $sup_key}[] = array( '', '' , '');

                $excel_tfoot[] = $excel_arrcount;
            $excel_arrcount += 3;
            


           		if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
           		if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }*/
				}
			}

			/*if($sup_key == 'asset')
{

$excel_appd_arr['total_ast_ct'] = $excel_arrcount;


	$total_assets = "R".number_format((float)$total_asset, 2);
	$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>".$total_assets."</th></tr></tbody></table>";

	$excel_array_total_ast[] = array( 'Total Asset', '' , $total_asset);
                	$excel_array_total_ast[] = array( '', '' , '');$excel_array_total_ast[] = array( '', '' , '');

                	$excel_assetfoot[] = $excel_arrcount;
            		$excel_arrcount += 3;

 
$excel_appd_arr['array_libt_ct'] = $excel_arrcount;

}


if($sup_key == 'libt')
{

 $excel_appd_arr['array_eqt_ct'] = $excel_arrcount;

	    $excel_titlearr[] = $excel_arrcount;
        $excel_arrcount += 2;
        $excele_tablearr[] = $excel_arrcount;
        $excel_arrcount += 1;

        
        $excel_arrcount++;
        
        // $excel_arrcount++;


        $excel_tfoot[] = $excel_arrcount;
        
        $excel_tfoot[] = $excel_arrcount;
        $excel_arrcount += 3;


        
        $excel_assetfoot[] = $excel_arrcount;
        $excel_arrcount += 3;

        $excel_arrcount++;

      $excel_appd_arr['other_ct'] = $excel_arrcount;  

}*/
		}

		$current_ids = implode(',', $current_year_cids);
		$ReportDetails_previous = $this->reports_model->getLegerBKPreviousCostid($current_ids, $filtered_client_id, $start_date);
		// echo  $this->db->last_query();
		if ($ReportDetails_previous) {
			foreach ($ReportDetails_previous as $ReportDetails_prev) {
				$cost_id = $ReportDetails_prev->cost_id;
				$childcost = $CostDetails_arr[$cost_id];
				$child_costname = $childcost->cost_name;
				$category_id = $ReportDetails_prev->category_id;
				$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
				if ($catcost) {
					foreach ($catcost as $ctcost) {
						$cost_name = $ctcost->cost_name;
						$links = $ctcost->links;
					}
				}




				$opening_balancee_ss = $this->bankstat_openingbanlance_single($start_date, $filtered_client_id, $cost_id);
				$sales_total_ss = (float)$opening_balancee_ss;
				// $total_amount = (float)$opening_balancee_ss;
				$open_amt_ss = "R" . number_format((float)$opening_balancee_ss, 2);
				// $open_amt_ss_xl = "R".number_format((float)$opening_balancee_ss, 2);
				$cost_txt   .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $open_amt_ss . "</td></tr>";
				$format_total += $opening_balancee_ss;
				// $excel_array[] = array( $cost_name, $links , $opening_balancee_ss);

			}
		}


		$oprofit = "R" . number_format((float)$profit, 2);
		// $format_total += $profit;
		// $cost_txt .= "<tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr>";



		/*$unallocated_difference = 0;
		
		 $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
        $oprofit = "R".number_format((float)$profit, 2);

        $total_quity_xl = (float)$unallocated_difference+(float)$profit;
        $ototal_quity = "R".number_format((float)$total_quity_xl, 2);


        $total_libeqt_xl = (float)$total_quity_xl+(float)$total_liabilities;
		$ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);


		$total_unalloc_xl = (float)$total_asset-(float)$total_libeqt_xl;
        $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ototal_unalloc."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		//$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";
		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";



		// $totallibeqt_txt .= "<table class='table table-striped table-hover stl_costtbl' style='margin-top:45px;margin-bottom:45px;'><tbody><tr><th  colspan='2' style='font-size:18px;'>Unallocated Difference</th><th style='text-align:right;font-size:18px;'>".$ototal_unalloc."</th></tr></tbody></table>";


		$excel_array_eqt[] = array( 'Equity', '' , '');
	    $excel_array_eqt[] = array( '', '' , '');
	    $excel_array_eqt[] = array( 'Cost Name', 'Links' , 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		$excel_array_eqt[] = array( 'Profit', 'q.200.000' , $profit);
		$excel_array_eqt[] = array( 'Total', '' , $total_quity_xl);
        $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');
        $excel_array_eqt[] = array( 'Total Liabilities and Equity', '' , $total_libeqt_xl);
        $excel_array_eqt[] = array( 'Unallocated Difference', '' , $total_unalloc_xl);
        $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');*/





		// $tax = (((float)$profit*28 )/100);
		// $otax = "R".number_format((float)$tax, 2);
		// $profit_tax = (float)$profit - (float)$tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);


		// $final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";


		// $excel_appd_arr['final_ct'] = $excel_arrcount; 
		// $excel_array_final[] = array( 'Profit Before Taxation', '' , $profit);
		// $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_array_final[] = array( 'Taxation', '' , $tax);
		// $excel_arrcount++;
		// $excel_array_final[] = array( 'Profit After Taxation', '' , $profit_tax);
		// $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;

		// $subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;
		$oformat_total = "R" . number_format((float)$format_total, 2);
		$excel_array[] = array('Total', '', $format_total);

		$cost_txt .= "</tbody><tfoot><tr><th colspan='2'>Total</th><th  style='text-align:right;'>" . $oformat_total . "</th></tr></tfoot></table>";



		$pdf_fname = 'trialbalance_report.pdf';

		/********************* PDF start ********/

		$this->load->library('m_pdf');


		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Cost Group Report';
		$page_data['table_div'] = $cost_txt;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('invoice_ledger_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();

		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');

		$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		$this->m_pdf->pdf->WriteHTML($html);


		$this->m_pdf->pdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");
		$this->output->set_output('');
		ob_end_flush();
		ob_start();

		/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}
	/****************** trial balance end **************/
}