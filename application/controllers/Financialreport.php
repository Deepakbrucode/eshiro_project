<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(dirname(__FILE__) . "/Reports.php");

class Financialreport extends Reports
{

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
	public function __construct()
	{
		parent::__construct();
		$this->load->model('reports_model');
		$this->load->model('costcentre_model');
		$this->load->model('client_model');

		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
		$this->load->helper('url');
		$this->load->library('excel');
	}
	public function fixed_asset_setting()
	{

		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : $client_id;
		$assetDetails = $this->reports_model->get_asset_setting_details($fclient_id);
		// echo "<pre>"; print_r($assetDetails); die;
		$data = array(
			'view_file' => 'fixed_asset_setting',
			'current_menu' => 'fixed_asset_setting',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			'ledger_title' => 'fixed_asset_setting',
			'report_url' => 'financial_report',
			'assetDetails' => $assetDetails,
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			// 'financial_reports' => $financial_reports,
			// 'report_type' => $report_type,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
					'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
					'lib/trumbowyg/ui/trumbowyg.min.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
					'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
					'lib/scripts/app.min.js',
					'lib/scripts/layout.min.js',
					'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
					'lib/trumbowyg/trumbowyg.min.js',
					// '//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
					// '//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
					//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

				),
				"priority" => 'high'
			)
		);

		$this->template->load_admin_template($data);
	}
	public function edit_asset_dep()
	{

		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$cost_id = (isset($_GET['cost_id'])) ? $_GET['cost_id'] : '';
		$costDetail = '';
		if ($cost_id != '')
			$costDetail = $this->reports_model->getDetails('costcentre', array('cost_id' => $cost_id));
		$data = array(
			'view_file' => 'edit_asset_dep',
			'current_menu' => 'edit_asset_dep',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			'formname' => 'Add',
			'form_action' => 'save_bankaccount',
			'client_id' => $client_id,
			'costDetail' => $costDetail,
			'cost_id' => $cost_id,
			//'CostDetails' => $CostDetails,
			// 'Categories' => $Categories,
			// 'subcategories' => $subcategories,
			// 'cost_formact' => 'add_cost',
			'usertype' => $usertype,
			// 'Sets' => $Sets,
			'headerfiles' => array(
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
			'footerfiles' => array(
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
	public function saveCostDep()
	{

		$cost_id = $_POST['cost_id'];
		$client_id = $_POST['client_id'];
		$dep_per = $_POST['dep_per'];
		$residual_value = $_POST['residual_value'];


		if ($cost_id != '') {
			$this->reports_model->Update('costcentre', array('dep_per' => $dep_per, 'residual_value' => $residual_value, 'modified_on' => date('Y-m-d H:i:s')), array('user_id' => $client_id, 'cost_id' => $cost_id));
		}


		$this->session->set_flashdata('costcenter', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Dep value Saved Successfully</span></div>');
		redirect(BASE_URL . 'financialreport/fixed_asset_setting');
	}
	public function index($report_type = 1)
	{
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if ($usertype == '5') {

			$ClientDetails = $this->client_model->getClientDetails();
		}
		// $financial_reports = $this->reports_model->getDetails('financial_report',array('client_id' => $client_id,'report_type' => $report_type));

		if ($report_type == '1') {
			$ledger_title = 'Invoice';
			$current_menu = 'financial_report_invoice';
		} else {
			$ledger_title = 'Bank Statement';
			$current_menu = 'financial_report_bk';
		}

		$data = array(
			'view_file' => 'financial_report',
			'current_menu' => $current_menu,
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			'ledger_title' => $ledger_title,
			'report_url' => 'financial_report',
			'ClientDetails' => $ClientDetails,
			// 'financial_report_pdf' => $financial_report_pdf,
			'usertype' => $usertype,
			// 'financial_reports' => $financial_reports,
			'report_type' => $report_type,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
					'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
					'lib/trumbowyg/ui/trumbowyg.min.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
					'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
					'lib/scripts/app.min.js',
					'lib/scripts/layout.min.js',
					'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
					'lib/trumbowyg/trumbowyg.min.js',
					// '//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
					// '//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
					//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

				),
				"priority" => 'high'
			)
		);

		$this->template->load_admin_template($data);
	}
	public function fiancial_report_create()
	{
		$freport_id = $_GET['freport_id'];
		$financial_report_data = $this->reports_model->getDetailsRow('financial_report', array('freport_id' => $freport_id));
		$start_date = $financial_report_data->start_date;
		$end_date = $financial_report_data->end_date;
		$client_id = $financial_report_data->client_id;
		$report_type = $financial_report_data->report_type;

		$cover_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'cover'));
		// echo $this->db->last_query();
		$general_info_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'general_info'));
		$independent_review_report_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'independent_review_report'));
		$response_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'response'));
		$directors_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'directors'));
		$accpolicies_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'accpolicies'));
		$cash_flow_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'cash_flow'));
		$notes_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'notes'));
		// echo "<pre>";print_r($notes_data);echo "</pre>";

		$start_date_exp = explode("-", $start_date);
		$end_date_exp = explode("-", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month_cl = $cdetl->financial_month_start;
				$filtered_end_month_cl = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
				$issued_capital = $cdetl->issue_capital;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $start_year;
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $end_year;


		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));
		$previous_year = $start_year - 1;
		$previous_start_date = $previous_year . "-" . $filtered_start_month_cl . "-01";
		$previous_end_date = date('Y-m-d', strtotime("+11 months", strtotime($previous_start_date)));
		// $previous_end_date = $start_year."-".$filtered_end_month_cl."-01";
		$previous_end_date = date('Y-m-t', strtotime($previous_end_date));

		$start_day = date('d M Y', strtotime($start_date));
		$end_day = date('t M Y', strtotime($end_date));
		$start_month_name = date("F", strtotime($start_date));
		$previous_end_day = date('t M Y', strtotime($previous_end_date));
		// echo $report_type; die;
		if ($report_type == 1) {
			$balance_data = $this->getFinancialPositionReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
			$detailedis_data = $this->getDetailedIncomeReport_invoice(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year));
			$inequitydata = $this->getComprehensiveIncomeReport_invoice(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
		} else {
			$balance_data = $this->getFinancialPositionReport_Bk(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
			$detailedis_data = $this->getDetailedIncomeReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year));
			$inequitydata = $this->getComprehensiveIncomeReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
		}
		// echo "<pre>"; print_r($balance_data); die;

		// $inequitydata = $this->getComprehensiveIncomeReport(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year,'previous_year' => $previous_year));

		$income_data = $inequitydata['comprehensive'];
		$equity_data = $inequitydata['equity'];

		$asset_sch_data = $this->getAssetSchedule(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year));
		$cur_asset_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'current_asset'));
		$pr_asset_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'previous_asset'));


		// $filtered_client_id= $postdata['client_id'];
		// $report_type = $postdata['report_type'];
		// $start_date = $postdata['start_date'];
		// $end_date = $postdata['end_date'];



		// $equity_data = $this->getEquityReport(array('client_id' => $client_id,'report_type' => 1, 'start_date' => $start_date,'end_date' => $end_date));

		// $income_data = $this->ajax_comprehensive_income(array('client_id' => $client_id,'report_type' => 2, 'start_date' => $start_date,'end_date' => $end_date));
		// $equity_data = '';
		// $notes_data = '';
		// $cash_flow_data = '';
		// $detailedis_data = $this->ajax_detailed_income_fn(array('client_id' => $client_id,'report_type' => 2, 'start_date' => $start_date,'end_date' => $end_date));
		// $detailedis_data = '';

		// echo $this->db->last_query();
		// echo "<pre>";print_r($general_info_data);echo "</pre>";exit;
		if ($report_type == '1') {
			$current_menu = 'financial_report_invoice';
			$ledger_title = 'Invoice';
		} else {
			$current_menu = 'financial_report_bk';
			$ledger_title = 'Bank Transaction';
		}


		$data = array(
			'view_file' => 'financial_report_create',
			'current_menu' => $current_menu,
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			'ledger_title' => $ledger_title,
			'freport_id' => $freport_id,
			'cover_data' => $cover_data,
			'general_info_data' => $general_info_data,
			'independent_review_report_data' => $independent_review_report_data,
			'response_data' => $response_data,
			'directors_data' => $directors_data,
			'balance_data' => $balance_data,
			'income_data' => $income_data,
			'equity_data' => $equity_data,
			'accpolicies_data' => $accpolicies_data,
			'notes_data' => $notes_data,
			'cash_flow_data' => $cash_flow_data,
			'detailedis_data' => $detailedis_data,
			'end_day' => $end_day,
			'previous_end_day' => $previous_end_day,
			'asset_sch_data' => $asset_sch_data,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'cur_asset_data' => $cur_asset_data,
			'pr_asset_data' => $pr_asset_data,
			// 'report_url' => 'financial_report_create',
			// 'ClientDetails' => $ClientDetails,
			// 'financial_report_pdf' => $financial_report_pdf,
			// 'usertype' => $usertype,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
					'lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
					'lib/trumbowyg/ui/trumbowyg.min.css',
					'lib/trumbowyg/plugins/table/ui/trumbowyg.table.min.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
					'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
					'lib/scripts/app.min.js',
					'lib/scripts/layout.min.js',
					'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
					'lib/trumbowyg/trumbowyg.min.js',
					'lib/trumbowyg/plugins/table/trumbowyg.table.min.js',
					// '//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
					// '//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
					//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

				),
				"priority" => 'high'
			)
		);

		$this->template->load_admin_template($data);
	}
	function findMonthDifference($date1, $date2)
	{
		// $date1 = '2000-01-25';
		// $date2 = '2010-02-20';

		$start_date_exp = explode("-", $date1);
		$end_date_exp = explode("-", $date2);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));
		$end_day = date('t M Y', strtotime($end_date));


		// $ts1 = strtotime($start_date);
		// $ts2 = strtotime($end_date);

		// $year1 = date('Y', $ts1);
		// $year2 = date('Y', $ts2);

		// $month1 = date('m', $ts1);
		// $month2 = date('m', $ts2);

		$date_diff = abs(strtotime($end_date) - strtotime($start_date));
		$years = floor($date_diff / (365 * 60 * 60 * 24));

		$months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		// echo "months = ".$months;exit;

		// $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		return array('month_diff' => $months, 'end_date' => $end_day);
	}

	public function generate_financial_report_pdf()
	{
		$freport_id = $_POST['freport_id'];
		$client_id = $this->session->id;

		$cover_meta = $this->reports_model->getDetailsRow('financial_report', array('freport_id' => $freport_id));
		$start_date = $cover_meta->start_date;
		$end_date = $cover_meta->end_date;
		// $register_no = $cover_meta->register_no;


		$month_diff_arr = $this->findMonthDifference($start_date, $end_date);


		$financial_nos = $this->financial_report_pdf($freport_id);
		$no_header = $financial_nos['no_header'];
		$headers = $financial_nos['header'];

		// echo "<pre>";print_r($financial_nos);echo "</pre>";


		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_client_name = $cdetl->name;
				$register_no = $cdetl->register_no;
			}
		}

		$pdf_fname = 'financial_report.pdf';

		$header = '<div class="pdf_header" style=" vertical-align: bottom; font-family: serif; font-size: 9pt;">
		<h4>' . $filtered_client_name . '</h4>
		<p>(Registration Number ' . $register_no . ')</p>';

		if ($month_diff_arr['month_diff'] > 0 && $month_diff_arr['month_diff'] < 12)
			$header .= '<p>Financial Statements for the ' . $month_diff_arr['month_diff'] . ' month period ended ' . $month_diff_arr['end_date'] . '</p>';
		else
			$header .= '<p>Annual Financial Statements </p>';

		$header .= '</div>';

		/********************* PDF start ********/
		// $this->load->library('m_pdf');
		$mpdf = new \Mpdf\Mpdf();

		// $mpdf=new mPDF('c','A4','','',100,100,100,100,100,100);
		// $page_data['page_name']  	= 'Financial Report';
		// $page_data['table_div'] = $financial_report_pdf;
		// $this->load->view('financial_report_pdf', $page_data);
		// $html = $this->output->get_output();

		$stylesheet = '';
		$mpdf->setAutoTopMargin = 'stretch';
		// hema 
		$headerFirstpage = '';
		$footerFirstpage = '';

		// $this->m_pdf->pdf->WriteHTML('Introduction');
		// $this->m_pdf->pdf->WriteHTML('Introduction');

		// $this->m_pdf->pdf->WriteHTML('<tocpagebreak />');


		foreach ($no_header as $key => $html) {

			// echo '<pre>';print_r($html);echo '</prE>';

			// $this->m_pdf->pdf->TOCpagebreak();
			// $this->m_pdf->pdf->AddPage();
			//set your header firstpage
			$mpdf->SetHTMLHeader($headerFirstpage);
			//set your footer firstpage
			$mpdf->SetHTMLFooter($footerFirstpage);
			//write a space 

			//$html .=' <sethtmlpagefooter name="firstpage" value="off" resetpagenum="1" />';

			// 			echo "hhh".$h = $this->m_pdf->pdf->hPt;
			// echo "ww = ".$w = $this->m_pdf->pdf->wPt;

			// $html1 ='
			// <html>
			// <body style="margin: 0; padding: 0;">
			// <table style="width: {$w}pt; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
			//   <tr>
			//     <td style="height: {$h}pt; text-align: center; vertical-align: middle; padding: 0px 5px; margin: 0;">
			//       '.$html.'
			//     </td>
			//   </tr>
			// </table>
			// </body>
			// </html>';



			$mpdf->WriteHTML($html);
		}
		// echo '<pre>';print_r($html);echo '</prE>';


		// exit; 
		// $this->m_pdf->pdf->TOCpagebreak(1,1);

		//$this->m_pdf->pdf->mirrorMargins = 10;
		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLHeader($header, 'E');
		$mpdf->setFooter('|{PAGENO}|');

		//$this->m_pdf->pdf->SetHTMLFooter('<div style="text-align:center">{PAGENO}</div>');



		// $stylesheet = file_get_contents('pdf.css');
		// $stylesheet = file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');
		// $stylesheet = $this->curl_get_file_contents('https://eshiro.app/uploads/pdf.css');
		$stylesheet = $this->curl_get_file_contents('https://eshiro.app/css/custompdf.css');
		$mpdf->WriteHTML($stylesheet, 1);

		// $this->m_pdf->pdf->WriteHTML($stylesheet,1);
		// $this->m_pdf->pdf->WriteHTML($html);

		// echo "<pre>";print_r($headers);echo "</pre>";
		// $this->m_pdf->pdf->WriteHTML('<tocpagebreak />');
		// $this->m_pdf->pdf->TOCpagebreak();
		// $this->m_pdf->pdf->TOC_Entry("Chapter 1",0);

		// $toc_placeholder_page = $this->m_pdf->pdf->page + 1;
		//border-bottom: 1px solid #000000;

		// $this->m_pdf->pdf->TOCpagebreak();
		// $this->m_pdf->pdf->WriteHTML('<tocpagebreak toc-prehtml="&lt;h6&gt;INDEX&lt;/h6&gt;&lt;p&gt;The reports and statements set out below comprise the financial statements presented to the shareholder:&lt;/p&gt;">');
		$mpdf->WriteHTML('<tocpagebreak  toc-prehtml="&lt;h6&gt;INDEX&lt;/h6&gt;&lt;">');


		// $this->m_pdf->pdf->WriteHTML('<div style="font-size: 6pt;"><tocpagebreak toc-preHTML="&lt;H2&gt;Table of Contents&lt;/H2&gt;" toc-postHTML="" links="OFF" toc-sheet-size="Letter" toc-resetpagenum="0" resetpagenum="0" /></div>');
		// $page = $this->m_pdf->pdf->page;
		$kk = 0;
		foreach ($headers as $key => $html) {
			// if($kk > 0)

			if ($kk > 0) {
				$mpdf->AddPage();
			}

			// $this->m_pdf->pdf->TOCpagebreak();
			$mpdf->WriteHTML($html);
			$kk++;
		}



		// $this->m_pdf->pdf->DeletePages($page);
		// $this->m_pdf->pdf->DeletePages($toc_placeholder_page);
		// $this->m_pdf->pdf->DeletePages(2);
		// $this->m_pdf->pdf->DeletePages(4);
		// $mpdf->Output();
		$mpdf->Output(FCPATH . 'uploads/' . $pdf_fname, "F");

		/*
						include_once APPPATH.'/third_party/mpdf/mpdf.php';

						// $mpdf=new mPDF('c','A4','','',32,25,47,47,10,10); 
						$mpdf=new mPDF('c','A4','','',320,250,470,470,500,100);

								$mpdf->SetImportUse();
						$pagecount = $mpdf->setSourceFile(FCPATH.'uploads/prev_'.$pdf_fname);
						// $pagecount = $pagecount+1;
						for ($i=1; $i<=($pagecount); $i++) {
							
							echo "i=====".$i;
							if($i==2)
							{
								$mpdf->AddPage();
								$import_page = $mpdf->importPage($pagecount);
								$mpdf->useTemplate($import_page);
							}
							$mpdf->AddPage();
							
							$import_page = $mpdf->importPage($i);
							// echo $import_page;
							$mpdf->useTemplate($import_page);
							// $mpdf->SetPageTemplate($import_page);
							// $mpdf->AddPage();
						}
						$mpdf->Output(FCPATH.'uploads/p'.$pdf_fname, "F");
						*/
		ob_end_flush();
		ob_start();


		return true;
	}

	function curl_get_file_contents($URL)
	{
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $URL);
		$contents = curl_exec($c);
		curl_close($c);

		if ($contents)
			return $contents;
		else
			return FALSE;
	}
	public function getComprehensiveIncomeReport_invoice($postdata = array())
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$previous_year = $postdata['previous_year'];
		$start_day = $postdata['start_day'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];
		$start_month_name = $postdata['start_month_name'];
		$previous_arr_data = $this->getComprehensiveIncomeReport_invoiceprevious(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $previous_year, 'start_month' => $start_month, 'end_month' => $end_month));


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_ctb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';

		$total_asset = $total_liabilities = 0;


		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));


		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));



				// echo $this->db->last_query();
				// echo "<br>";

				// echo "<pre>ReportDetails_journal = ";print_r($ReportDetails_journal);echo "</pre>";


				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {


					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td class='previous_ctb'  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

							// // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							//    $excel_arrcount++;
						}
					}
					if ($ReportDetails) {
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}

					// echo "<pre>";print_r($ReportDetails_journal);echo "</pre>";

					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;

					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}





		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		$ototal_sale = "R" . number_format((float) $total_sale, 2);
		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);
		$ototal_costsale = "R" . number_format((float) $total_costsale, 2);
		$ototal_operating_cost = "R" . number_format((float) $total_operating_cost, 2);
		$ototal_operating_profit = "R" . number_format((float) $total_operating_profit, 2);
		$ototal_finance_cost = "R" . number_format((float) $total_finance_cost, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount_invoice($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);
		// echo $restotal;


		$pr_ototal_sale = isset($previous_arr_data['ototal_sale']) ? $previous_arr_data['ototal_sale'] : 'R0.00';
		$pr_ototal_costsale = isset($previous_arr_data['ototal_costsale']) ? $previous_arr_data['ototal_costsale'] : 'R0.00';
		$pr_ogrossprofit = isset($previous_arr_data['ogrossprofit']) ? $previous_arr_data['ogrossprofit'] : 'R0.00';
		$pr_ototal_operating_cost = isset($previous_arr_data['ototal_operating_cost']) ? $previous_arr_data['ototal_operating_cost'] : 'R0.00';
		$pr_ototal_operating_profit = isset($previous_arr_data['ototal_operating_profit']) ? $previous_arr_data['ototal_operating_profit'] : 'R0.00';

		$pr_ototal_finance_cost = isset($previous_arr_data['ototal_finance_cost']) ? $previous_arr_data['ototal_finance_cost'] : 'R0.00';
		$pr_oprofit = isset($previous_arr_data['oprofit']) ? $previous_arr_data['oprofit'] : 'R0.00';
		$pr_otax = isset($previous_arr_data['otax']) ? $previous_arr_data['otax'] : 'R0.00';
		$pr_oprofit_tax = isset($previous_arr_data['oprofit_tax']) ? $previous_arr_data['oprofit_tax'] : 'R0.00';
		$pr_orestotal = isset($previous_arr_data['orestotal']) ? $previous_arr_data['orestotal'] : 'R0.00';
		$pr_restotal = isset($previous_arr_data['restotal']) ? $previous_arr_data['restotal'] : '0.00';
		$pr_ofinal_retained_total = isset($previous_arr_data['ofinal_retained_total']) ? $previous_arr_data['ofinal_retained_total'] : 'R0.00';
		$pr_final_retained_total = isset($previous_arr_data['final_retained_total']) ? $previous_arr_data['final_retained_total'] : '0.00';



		$print_txt = "<tr><td>Revenue</td><td style='text-align:right;'>" . $ototal_sale . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_ototal_sale . "</td></tr><tr><td>Cost of sales</td><td style='text-align:right;'>" . $ototal_costsale . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_ototal_costsale . "</td></tr><tr><th>Gross profit</th><th style='text-align:right;'>" . $ogrossprofit . "</th><th class='previous_ctb' style='text-align:right;'>" . $pr_ogrossprofit . "</th></tr>";


		$print_txt .= "<tr><td>Operating costs</td><td style='text-align:right;'>" . $ototal_operating_cost . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_ototal_operating_cost . "</td></tr><tr><th>Operating profit</th><th style='text-align:right;'>" . $ototal_operating_profit . "</th><th class='previous_ctb' style='text-align:right;'>" . $pr_ototal_operating_profit . "</th></tr>";


		$print_txt .= "<tr><td>Finance costs</td><td style='text-align:right;'>" . $ototal_finance_cost . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_ototal_finance_cost . "</td></tr><tr><th>Profit before tax</th><th style='text-align:right;'>" . $oprofit . "</th><th class='previous_ctb' style='text-align:right;'>" . $pr_oprofit . "</th></tr>";


		$print_txt .= "<tr><td>Tax expense</td><td style='text-align:right;'>" . $otax . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_otax . "</td></tr><tr><th>Profit for the year</th><th style='text-align:right;'>" . $oprofit_tax . "</th><th class='previous_ctb' style='text-align:right;'>" . $pr_oprofit_tax . "</th></tr>";


		$print_txt .= "<tr><td>Retained income at " . $start_day . "</td><td style='text-align:right;'>" . $orestotal . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_orestotal . "</td></tr>
<tr><td>Profit for the year</td><td style='text-align:right;'>" . $oprofit_tax . "</td><td class='previous_ctb' style='text-align:right;'>" . $pr_oprofit_tax . "</td></tr>
<tr><th>Retained income at " . $end_day . "</th><th style='text-align:right;'>" . $ofinal_retained_total . "</th><th class='previous_ctb' style='text-align:right;'>" . $pr_ofinal_retained_total . "</th></tr>";





		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$previous_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$previous_styl = "<style>.previous_ctb{display:none;}</style>";
		}

		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

		$cost_txt = $previous_styl . $cost_txt_start . " " . $print_txt . "</tbody></table>";


		// $issue_capital = 0;
		$equity_restotal = ((int) $orestotal + (int) $issued_capital);
		$euity_ftotal = $final_retained_total + $issued_capital;
		$pr_total = $pr_restotal + $issued_capital;
		$pr_tfinal_retained_total = $pr_final_retained_total + $issued_capital;
		$opr_total = "R" . number_format((float) $pr_total, 2);
		$opr_tfinal_retained_total = "R" . number_format((float) $pr_tfinal_retained_total, 2);
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);
		$oequity_restotal = "R" . number_format((float) $equity_restotal, 2);
		$euity_ftotal = "R" . number_format((float) $euity_ftotal, 2);


		$equity_start = '<table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Figures in R</th><th style="text-align:right;">Share capital</th><th style="text-align:right;">Retained
earnings</th><th style="text-align:right;">Total</th></tr></thead><tbody>
<tr><th>Balance at 1 ' . $start_month_name . ' ' . $previous_year . '</th><td style="text-align:right;"> ' . $oissued_capital . ' </td><td style="text-align:right;">' . $pr_orestotal . '</td><td style="text-align:right;">' . $opr_total . '</td></tr>
<tr><td>Profit for the year</td><td></td><td style="text-align:right;">' . $pr_oprofit_tax . '</td><td style="text-align:right;">' . $pr_oprofit_tax . '</td></tr>
<tr><th>Total comprehensive income for the year</th><td style="text-align:right;">-</td><td style="text-align:right;">' . $pr_oprofit_tax . '</td><td style="text-align:right;">' . $pr_oprofit_tax . '</td></tr>
<tr><th>Balance at ' . $previous_end_day . '</th><td style="text-align:right;">' . $oissued_capital . '</td><td style="text-align:right;">' . $pr_ofinal_retained_total . '</td><td style="text-align:right;">' . $opr_tfinal_retained_total . '</td></tr>
<tr><th>Balance at 1 ' . $start_month_name . ' ' . $start_year . '</th><td style="text-align:right;">' . $oissued_capital . '</td><td style="text-align:right;">' . $orestotal . '</td><td style="text-align:right;">' . $oequity_restotal . '</td></tr>
<tr><td>Profit for the year</td><td style="text-align:right;">' . $oprofit_tax . '</td><td style="text-align:right;">' . $oprofit_tax . '</td></tr>
<tr><th>Total comprehensive income for the year</th><td style="text-align:right;">-</td><td style="text-align:right;">' . $oprofit_tax . '</td><td style="text-align:right;">' . $oprofit_tax . '</td></tr>
<tr><th>Balance at ' . $end_day . '</th><td style="text-align:right;">' . $oissued_capital . '</td><td style="text-align:right;">' . $ofinal_retained_total . '</td><td style="text-align:right;">' . $euity_ftotal . '</td></tr>
</tbody></table>';



		return array('comprehensive' => $cost_txt, 'equity' => $equity_start);
		exit();
		exit();
	}

	public function getComprehensiveIncomeReport_invoiceprevious($postdata = array())
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = $check_previous_data = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_arr = array();

		$total_asset = $total_liabilities = 0;


		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));


		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));



				// echo $this->db->last_query();
				// echo "<br>";

				// echo "<pre>ReportDetails_journal = ";print_r($ReportDetails_journal);echo "</pre>";


				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {


					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

							// // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							//    $excel_arrcount++;
						}
					}
					if ($ReportDetails) {
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}

					// echo "<pre>";print_r($ReportDetails_journal);echo "</pre>";

					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;

					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}





		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		$ototal_sale = "R" . number_format((float) $total_sale, 2);
		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);
		$ototal_costsale = "R" . number_format((float) $total_costsale, 2);
		$ototal_operating_cost = "R" . number_format((float) $total_operating_cost, 2);
		$ototal_operating_profit = "R" . number_format((float) $total_operating_profit, 2);
		$ototal_finance_cost = "R" . number_format((float) $total_finance_cost, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount_invoice($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);

		if ($total_sale > 0 || $total_costsale > 0 || $grossprofit > 0 || $total_operating_cost > 0 || $total_finance_cost > 0 || $profit > 0 || $tax > 0 || $profit_tax > 0 || $restotal > 0 || $final_retained_total > 0) {
			$check_previous_data = 1;
		}
		// echo $restotal;


		$cost_arr['ototal_sale'] = $ototal_sale;
		$cost_arr['ototal_costsale'] = $ototal_costsale;
		$cost_arr['ogrossprofit'] = $ogrossprofit;
		$cost_arr['ototal_operating_cost'] = $ototal_operating_cost;
		$cost_arr['ototal_operating_profit'] = $ototal_operating_profit;
		$cost_arr['ototal_finance_cost'] = $ototal_finance_cost;
		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['otax'] = $otax;
		$cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['orestotal'] = $orestotal;
		$cost_arr['restotal'] = $restotal;
		// $cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['ofinal_retained_total'] = $ofinal_retained_total;
		$cost_arr['final_retained_total'] = $final_retained_total;
		$cost_arr['check_previous_data'] = $check_previous_data;







		return $cost_arr;
		exit();
	}
	public function calculate_previous_year_retained_amt_invoice($filtered_client_id, $report_type, $start_date, $end_date)
	{

		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;


		$start_date_exp = explode("/", $start_date);
		$end_date_exp = explode("/", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;




		$end_month = '2';

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		// $start_fulldate = $start_monthName.' 1, '.$start_year;
		// $end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

		// $full_details = [];

		$start_date = date('Y-m-d');




		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));




		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}


		$cost_arr = array();

		$total_asset = $total_liabilities = 0;


		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));


		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));



				// echo $this->db->last_query();
				// echo "<br>";

				// echo "<pre>ReportDetails_journal = ";print_r($ReportDetails_journal);echo "</pre>";


				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {


					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

							// // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							//    $excel_arrcount++;
						}
					}
					if ($ReportDetails) {
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}

					// echo "<pre>";print_r($ReportDetails_journal);echo "</pre>";

					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;

					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}



		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		// $ototal_sale  = "R".number_format((float)$total_sale, 2);
		// $ogrossprofit  = "R".number_format((float)$grossprofit, 2);
		// $ototal_costsale  = "R".number_format((float)$total_costsale, 2);
		// $ototal_operating_cost  = "R".number_format((float)$total_operating_cost, 2);
		// $ototal_operating_profit  = "R".number_format((float)$total_operating_profit, 2);
		// $ototal_finance_cost  = "R".number_format((float)$total_finance_cost, 2);
		// $oprofit  = "R".number_format((float)$profit, 2);

		$tax = (((float) $profit * 28) / 100);
		// $otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);





		return $profit_tax;

		exit();
	}
	public function calculate_total_retained_amount_invoice($filtered_client_id, $report_type, $end_year, $start_month, $end_month)
	{
		$start_reportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'report_type' => 1, 'status' => 1), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'limit' => '1', 'offset' => '0'));
		// echo $this->db->last_query();

		$total_retain_amt = 0;
		// echo "<pre>ddd = ";print_r($start_reportDetails);echo "</pre>";
		if (!empty($start_reportDetails)) {
			foreach ($start_reportDetails as $start_reportDetail) {
				$report_date = $start_reportDetail->report_date;
				$report_date_arr = explode('-', $report_date);
				// echo "<pre>";print_r($report_date_arr);echo "</pre>";
				$start_year = $report_date_arr[0];
				if ($end_year != $start_year) {

					// echo $start_year." = ".$end_year;exit;

					for ($current_year = $start_year; $current_year < $end_year; $current_year++) {
						$next_year = (int) $current_year + 1;
						$start_month_year = $start_month . '/' . $current_year;
						$end_month_year = $end_month . '/' . $next_year;
						$start_date = $current_year . "-" . $start_month . "-01";
						$end_date = date('Y-m-d', strtotime("+11 months", strtotime($start_date)));
						$end_month_year = date('m/Y', strtotime($end_date));
						$retotal = $this->calculate_previous_year_retained_amt_invoice($filtered_client_id, $report_type, $start_month_year, $end_month_year);
						$total_retain_amt += (float) $retotal;
						// exit;
					}
				}
			}
		}

		return $total_retain_amt;
	}

	public function getComprehensiveIncomeReport($postdata = array())
	{


		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$previous_year = $postdata['previous_year'];
		$start_day = $postdata['start_day'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];
		$start_month_name = $postdata['start_month_name'];
		$previous_arr_data = $this->previousComprehensiveIncomeReport(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $previous_year, 'start_month' => $start_month, 'end_month' => $end_month));

		// $year=$_POST['year'];
		// $inputh_year = $year;
		/*$start_date_exp=explode("-",$start_date);
								$end_date_exp=explode("-",$end_date);
								$filtered_start_month = $start_date_exp[0];
								$filtered_end_month = $end_date_exp[0];
								$start_year = $start_date_exp[1];
								$end_year = $end_date_exp[1];
								$inputh_year = $start_year.'-'.$end_year;*/

		$report_url = 'comprehensive_income';
		$ledger_title = 'STATEMENT OF COMPREHENSIVE INCOME';
		$ledger_menu = 'comprehensive_income';



		/*$end_month = '2';
								$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
										$issued_capital = $cdetl->issue_capital;
									}
								}

								$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

								$full_details = [];

								$start_date = date('Y-m-d');

								// $year_start = $years[0];
								// $year_end = $years[1];



								$start_date = $start_year."-".$filtered_start_month."-01";
								$end_date = $end_year."-".$filtered_end_month."-01";
								$end_date = date('Y-m-t',strtotime($end_date));
								$previous_year = $start_year-1;
								$previous_start_date = $previous_year."-".$filtered_start_month_cl."-01";
								$previous_end_date = $start_year."-".$filtered_end_month_cl."-01";
								$previous_end_date = date('Y-m-t',strtotime($previous_end_date));

								$end_day = date('t M Y',strtotime($end_date));
								$previous_end_day = date('t M Y',strtotime($previous_end_date));*/


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';


		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_cinbtb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';



		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));


		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70'), 'expense' => array('71'));




		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {


				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {


					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td   style='text-align:right;'>" . $oformat_amount . "</td></tr>";
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										// $links = $ctcost->links;
									}
								}
							}


							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;
				}
			}
		}






		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		$ototal_sale = "R" . number_format((float) $total_sale, 2);
		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);
		$ototal_costsale = "R" . number_format((float) $total_costsale, 2);
		$ototal_operating_cost = "R" . number_format((float) $total_operating_cost, 2);
		$ototal_operating_profit = "R" . number_format((float) $total_operating_profit, 2);
		$ototal_finance_cost = "R" . number_format((float) $total_finance_cost, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);
		// echo $restotal;


		$pr_ototal_sale = isset($previous_arr_data['ototal_sale']) ? $previous_arr_data['ototal_sale'] : 'R0.00';
		$pr_ototal_costsale = isset($previous_arr_data['ototal_costsale']) ? $previous_arr_data['ototal_costsale'] : 'R0.00';
		$pr_ogrossprofit = isset($previous_arr_data['ogrossprofit']) ? $previous_arr_data['ogrossprofit'] : 'R0.00';
		$pr_ototal_operating_cost = isset($previous_arr_data['ototal_operating_cost']) ? $previous_arr_data['ototal_operating_cost'] : 'R0.00';
		$pr_ototal_operating_profit = isset($previous_arr_data['ototal_operating_profit']) ? $previous_arr_data['ototal_operating_profit'] : 'R0.00';

		$pr_ototal_finance_cost = isset($previous_arr_data['ototal_finance_cost']) ? $previous_arr_data['ototal_finance_cost'] : 'R0.00';
		$pr_oprofit = isset($previous_arr_data['oprofit']) ? $previous_arr_data['oprofit'] : 'R0.00';
		$pr_otax = isset($previous_arr_data['otax']) ? $previous_arr_data['otax'] : 'R0.00';
		$pr_oprofit_tax = isset($previous_arr_data['oprofit_tax']) ? $previous_arr_data['oprofit_tax'] : 'R0.00';
		$pr_orestotal = isset($previous_arr_data['orestotal']) ? $previous_arr_data['orestotal'] : 'R0.00';
		$pr_restotal = isset($previous_arr_data['restotal']) ? $previous_arr_data['restotal'] : '0.00';
		$pr_ofinal_retained_total = isset($previous_arr_data['ofinal_retained_total']) ? $previous_arr_data['ofinal_retained_total'] : 'R0.00';
		$pr_final_retained_total = isset($previous_arr_data['final_retained_total']) ? $previous_arr_data['final_retained_total'] : '0.00';



		$print_txt = "<tr><td>Revenue</td><td style='text-align:right;'>" . $ototal_sale . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_ototal_sale . "</td></tr><tr><td>Cost of sales</td><td style='text-align:right;'>" . $ototal_costsale . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_ototal_costsale . "</td></tr><tr><th>Gross profit</th><th class='tb_bbtm1' style='text-align:right;'>" . $ogrossprofit . "</th><th class='previous_cinbtb tb_bbtm1' style='text-align:right;'>" . $pr_ogrossprofit . "</th></tr>";


		$print_txt .= "<tr><td>Operating costs</td><td style='text-align:right;'>" . $ototal_operating_cost . "</td><td  class='previous_cinbtb' style='text-align:right;'>" . $pr_ototal_operating_cost . "</td></tr><tr><th>Operating profit</th><th class='tb_bbtm1' style='text-align:right;'>" . $ototal_operating_profit . "</th><th class='previous_cinbtb tb_bbtm1' style='text-align:right;'>" . $pr_ototal_operating_profit . "</th></tr>";


		$print_txt .= "<tr><td>Finance costs</td><td style='text-align:right;'>" . $ototal_finance_cost . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_ototal_finance_cost . "</td></tr><tr><th>Profit before tax</th><th class='tb_bbtm1' style='text-align:right;'>" . $oprofit . "</th><th class='previous_cinbtb tb_bbtm1' style='text-align:right;'>" . $pr_oprofit . "</th></tr>";


		$print_txt .= "<tr><td>Tax expense</td><td style='text-align:right;'>" . $otax . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_otax . "</td></tr><tr><th>Profit for the year</th><th class='tb_bbtm' style='text-align:right;'>" . $oprofit_tax . "</th><th class='previous_cinbtb tb_bbtm' style='text-align:right;'>" . $pr_oprofit_tax . "</th></tr>";


		$print_txt .= "<tr><td>Retained income at " . $start_day . "</td><td style='text-align:right;'>" . $orestotal . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_orestotal . "</td></tr>
<tr><td>Profit for the year</td><td style='text-align:right;'>" . $oprofit_tax . "</td><td class='previous_cinbtb' style='text-align:right;'>" . $pr_oprofit_tax . "</td></tr>
<tr><th>Retained income at " . $end_day . "</th><th class='tb_bbtm' style='text-align:right;'>" . $ofinal_retained_total . "</th><th class='previous_cinbtb tb_bbtm' style='text-align:right;'>" . $pr_ofinal_retained_total . "</th></tr>";



		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$previous_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$previous_styl = "<style>.previous_cinbtb{display:none;}</style>";
		}


		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

		$cost_txt = $previous_styl . $cost_txt_start . " " . $print_txt . "</tbody></table>";


		// $issue_capital = 0;
		$equity_restotal = ((int) $orestotal + (int) $issued_capital);
		$euity_ftotal = $final_retained_total + $issued_capital;
		$pr_total = $pr_restotal + $issued_capital;
		$pr_tfinal_retained_total = $pr_final_retained_total + $issued_capital;
		$opr_total = "R" . number_format((float) $pr_total, 2);
		$opr_tfinal_retained_total = "R" . number_format((float) $pr_tfinal_retained_total, 2);
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);
		$oequity_restotal = "R" . number_format((float) $equity_restotal, 2);
		$euity_ftotal = "R" . number_format((float) $euity_ftotal, 2);


		$equity_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">Share capital</th><th style="text-align:right;">Retained
earnings</th><th style="text-align:right;">Total</th></tr></thead><tbody>
<tr><th>Balance at 1 ' . $start_month_name . ' ' . $previous_year . '</th><td style="text-align:right;"> ' . $oissued_capital . ' </td><td style="text-align:right;">' . $pr_orestotal . '</td><td style="text-align:right;">' . $opr_total . '</td></tr>
<tr><td>Profit for the year</td><td></td><td style="text-align:right;">' . $pr_oprofit_tax . '</td><td style="text-align:right;">' . $pr_oprofit_tax . '</td></tr>
<tr><th>Total comprehensive income for the year</th><td class="tb_bbtm" style="text-align:right;">-</td><td class="tb_bbtm" style="text-align:right;">' . $pr_oprofit_tax . '</td><td class="tb_bbtm" style="text-align:right;">' . $pr_oprofit_tax . '</td></tr>
<tr><th>Balance at ' . $previous_end_day . '</th><td class="tb_bbtm" style="text-align:right;">' . $oissued_capital . '</td><td class="tb_bbtm" style="text-align:right;">' . $pr_ofinal_retained_total . '</td><td class="tb_bbtm" style="text-align:right;">' . $opr_tfinal_retained_total . '</td></tr>
<tr><th>Balance at 1 ' . $start_month_name . ' ' . $start_year . '</th><td style="text-align:right;">' . $oissued_capital . '</td><td style="text-align:right;">' . $orestotal . '</td><td style="text-align:right;">' . $oequity_restotal . '</td></tr>
<tr><td>Profit for the year</td><td style="text-align:right;">' . $oprofit_tax . '</td><td style="text-align:right;">' . $oprofit_tax . '</td></tr>
<tr><th>Total comprehensive income for the year</th><td class="tb_bbtm" style="text-align:right;">-</td><td class="tb_bbtm" style="text-align:right;">' . $oprofit_tax . '</td><td class="tb_bbtm" style="text-align:right;">' . $oprofit_tax . '</td></tr>
<tr><th>Balance at ' . $end_day . '</th><td class="tb_bbtm" style="text-align:right;">' . $oissued_capital . '</td><td class="tb_bbtm" style="text-align:right;">' . $ofinal_retained_total . '</td><td class="tb_bbtm" style="text-align:right;">' . $euity_ftotal . '</td></tr>
</tbody></table>';



		return array('comprehensive' => $cost_txt, 'equity' => $equity_start);
		exit();
	}

	public function previousComprehensiveIncomeReport($postdata)
	{



		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = $check_previous_data = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		/*$start_date_exp=explode("-",$start_date);
								$end_date_exp=explode("-",$end_date);
								$filtered_start_month = $start_date_exp[0];
								$filtered_end_month = $end_date_exp[0];
								$start_year = $start_date_exp[1];
								$end_year = $end_date_exp[1];
								$inputh_year = $start_year.'-'.$end_year;

								 $report_url = 'comprehensive_income';$ledger_title = 'STATEMENT OF COMPREHENSIVE INCOME';$ledger_menu='comprehensive_income';
								


								$end_month = '2';
								$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
									}
								}

								$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

								$full_details = [];

								$start_date = date('Y-m-d');

								// $year_start = $years[0];
								// $year_end = $years[1];


								// $start_date = $start_year."-".$filtered_start_month."-01";
								// $end_date = $end_year."-".$filtered_end_month."-01";
								// $end_date = date('Y-m-t',strtotime($end_date));
								$previous_year = $start_year-1;
								$start_date = $previous_year."-".$filtered_start_month_cl."-01";
								$end_date = $start_year."-".$filtered_end_month_cl."-01";
								$end_date = date('Y-m-t',strtotime($end_date));*/

		// $end_day = date('t M Y',strtotime($end_date));
		// $previous_end_day = date('t M Y',strtotime($previous_end_date));


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$cost_arr = array();


		// $cost_txt_start = '<table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Figures in R</th><th style="text-align:right;"">'.$end_day.'</th><th style="text-align:right;">'.$previous_end_day.'</th></tr></thead><tbody>';



		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));


		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			// ${"cost_txt_" . $sup_key} = '';

			$cost_arr[$sup_key] = '';
			foreach ($subcat_id_arr as $subcat_id_ar) {


				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {


					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;
							// $cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
							// $cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
							// $cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										// $links = $ctcost->links;
									}
								}
							}


							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					// $oformat_amount_xl = $total_amount;



				}
			}
		}






		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		$ototal_sale = "R" . number_format((float) $total_sale, 2);
		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);
		$ototal_costsale = "R" . number_format((float) $total_costsale, 2);
		$ototal_operating_cost = "R" . number_format((float) $total_operating_cost, 2);
		$ototal_operating_profit = "R" . number_format((float) $total_operating_profit, 2);
		$ototal_finance_cost = "R" . number_format((float) $total_finance_cost, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);
		// echo $restotal;


		if ($total_sale > 0 || $total_costsale > 0 || $grossprofit > 0 || $total_operating_cost > 0 || $total_finance_cost > 0 || $profit > 0 || $tax > 0 || $profit_tax > 0 || $restotal > 0 || $final_retained_total > 0) {
			$check_previous_data = 1;
		}

		$cost_arr['ototal_sale'] = $ototal_sale;
		$cost_arr['ototal_costsale'] = $ototal_costsale;
		$cost_arr['ogrossprofit'] = $ogrossprofit;
		$cost_arr['ototal_operating_cost'] = $ototal_operating_cost;
		$cost_arr['ototal_operating_profit'] = $ototal_operating_profit;
		$cost_arr['ototal_finance_cost'] = $ototal_finance_cost;
		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['otax'] = $otax;
		$cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['orestotal'] = $orestotal;
		$cost_arr['restotal'] = $restotal;
		$cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['ofinal_retained_total'] = $ofinal_retained_total;
		$cost_arr['final_retained_total'] = $final_retained_total;
		$cost_arr['check_previous_data'] = $check_previous_data;







		return $cost_arr;
		exit();
	}


	public function financial_position($report_type = 1)
	{
		$client_id = $this->session->id;
		$start_month = '';
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$ClientDetails = array();
		if ($usertype == '5') {
			$ClientDetails = $this->client_model->getClientDetails();
		}
		$current_userid = $client_id;
		if ($usertype == '5') {
			if ($fclient_id != '') {
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_finanlstat_year($current_userid, $end_month, $report_type);



		$data = array(
			'view_file' => 'financial_position',
			'current_menu' => 'financial_position',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			// 'end_month' => $end_month,
			// 'start_month' => $start_month,
			// 'bank_stat_yr' => $bank_stat_yr,
			'report_type' => $report_type,
			'ledger_title' => 'STATEMENT OF FINANCIAL POSITION',
			'report_url' => 'financial_position',
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
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
	public function comprehensive_income($report_type = 2)
	{
		$client_id = $this->session->id;
		$start_month = '';
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$ClientDetails = array();
		if ($usertype == '5') {
			$ClientDetails = $this->client_model->getClientDetails();
		}
		$current_userid = $client_id;
		if ($usertype == '5') {
			if ($fclient_id != '') {
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_finanlstat_year($current_userid, $end_month, $report_type);



		$data = array(
			'view_file' => 'comprehensive_income',
			'current_menu' => 'comprehensive_income',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			// 'end_month' => $end_month,
			// 'start_month' => $start_month,
			// 'bank_stat_yr' => $bank_stat_yr,
			'report_type' => $report_type,
			'ledger_title' => 'STATEMENT OF COMPREHENSIVE INCOME',
			'report_url' => 'comprehensive_income',
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
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

	public function detailed_income($report_type = 2)
	{
		$client_id = $this->session->id;
		$start_month = '';
		$usertype = $this->session->usertype;
		$fclient_id = (isset($_GET['client_id'])) ? $_GET['client_id'] : '';
		$ClientDetails = array();
		if ($usertype == '5') {
			$ClientDetails = $this->client_model->getClientDetails();
		}
		$current_userid = $client_id;
		if ($usertype == '5') {
			if ($fclient_id != '') {
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_finanlstat_year($current_userid, $end_month, $report_type);



		$data = array(
			'view_file' => 'detailed_income',
			'current_menu' => 'detailed_income',
			'cusotm_field' => 'report',
			'site_title' => 'eShiro',
			'logo' => 'logo',
			'title' => 'Report',
			// 'end_month' => $end_month,
			// 'start_month' => $start_month,
			// 'bank_stat_yr' => $bank_stat_yr,
			'report_type' => $report_type,
			'ledger_title' => 'DETAILED INCOME STATEMENT',
			'report_url' => 'detailed_income',
			'ClientDetails' => $ClientDetails,
			'usertype' => $usertype,
			// 'current_userid' => $current_userid,
			'headerfiles' => array(
				"css" => array(
					'lib/font-awesome/css/font-awesome.min.css',
					'lib/simple-line-icons/simple-line-icons.min.css',
					'lib/bootstrap/css/bootstrap.min.css',
					'lib/bootstrap-switch/css/bootstrap-switch.min.css',
					'lib/datatables/datatables.min.css',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
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
			'footerfiles' => array(
				"js" => array(
					'lib/bootstrap/js/bootstrap.min.js',
					'lib/bootstrap-switch/js/bootstrap-switch.min.js',
					'lib/datatable.js',
					'lib/datatables/datatables.min.js',
					// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
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

	function getPreviousFinancialPositionReport($postdata = array())
	{
		// echo "test";
		setlocale(LC_MONETARY, 'en_IN');
		// $excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = $previous_unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		/*$start_date_exp=explode("-",$start_date);
								$end_date_exp=explode("-",$end_date);
								$filtered_start_month = $start_date_exp[0];
								$filtered_end_month = $end_date_exp[0];
								$start_year = $start_date_exp[1];
								$end_year = $end_date_exp[1];
								$inputh_year = $start_year.'-'.$end_year;*/

		$report_url = 'invoice_financial';
		$ledger_title = 'STATEMENT OF FINANCIAL POSITION';
		$ledger_menu = 'financial_position';



		/*$end_month = '2';
								$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
										$issued_capital = $cdetl->issue_capital;
									}
								}

								$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;*/

		$full_details = [];

		// $start_date = date('Y-m-d');

		// $year_start = $years[0];
		// $year_end = $years[1];


		// $start_date = $start_year."-".$filtered_start_month."-01";
		// $end_date = $end_year."-".$filtered_end_month."-01";
		// $end_date = date('Y-m-t',strtotime($end_date));
		// $previous_year = $start_year-1;
		// $start_date = $previous_year."-".$filtered_start_month_cl."-01";
		// $end_date = $start_year."-".$filtered_end_month_cl."-01";
		// $end_date = date('Y-m-t',strtotime($end_date));

		// $end_day = date('t M Y',strtotime($end_date));
		// $previous_end_day = date('t M Y',strtotime($previous_end_date));

		// echo "previous_start_date = ".$previous_start_date." = previous_end_date = ".$previous_end_date;




		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		// echo "<pre>";print_r($CostDetails);echo "</pre>";
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		// echo "<pre>";print_r($CostDetails_arr);echo "</pre>";

		$cost_txt = '';
		$excel_array = array();

		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div>';

		// $cost_txt_start = '<table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Figures in R</th><th style="text-align:right;"">'.$end_day.'</th><th style="text-align:right;">'.$previous_end_day.'</th></tr></thead><tbody>';

		$total_asset = $total_liabilities = 0;
		// $previous_total_asset = $previous_total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();




		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);
		// $previous_opening_balancee_data = $this->bankstat_openingbanlance_invoice($previous_start_date,$filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";


		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));

		$cost_arr = array();
		$check_previous_data = 0;

		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "sup_key = ".$sup_key. "<br>";
			// echo "subcat_id_arr = ".$subcat_id_arr;
			// ${"cost_txt_" . $sup_key} = '';
			// $cost_arr[$sup_key] = '';
			$cost_arr[] = ''; // updated

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					// echo "1";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					// echo "2";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
				} else {
					// echo "3";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));






				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;
				// echo "ReportDetails = ".$ReportDetails;
				// echo "<pre>ReportDetails = ".print_r($ReportDetails);echo "</pre>";
				// echo "<pre>ReportDetails_journal = ".print_r($ReportDetails_journal);echo "</pre>";


				if ($ReportDetails || $ReportDetails_journal) {

					// echo "ifffffffffffffffffffffff";

					// ${"cost_txt_" . $sup_key} .= "<tr><th colspan='3'>".$child_costname."</th></tr>";
					$cost_arr[$sup_key][$subcat_id_ar]['child_costname'] = $child_costname;


					$bank_balance = 0;
					// $previous_oformat_amount = 'R0.00';


					// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
					// echo "subcat_id_ar = ".$subcat_id_ar;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						// echo "ifffffffffff";exit;
						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							if ($amount > 0) {
								$check_previous_data = 1;
							}
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['child_costname'] = $child_costname;
							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>".$previous_oformat_amount."</td></tr>";

						}
					}
					// echo "<pre>";print_r($cost_arr);echo "</pre>";
					if ($ReportDetails) {
						$check_previous_data = 1;
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>0.00</td></tr>";
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['child_costname'] = $child_costname;
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						$check_previous_data = 1;
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit += (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>0.00</td></tr>";
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['child_costname'] = $child_costname;
						}
					}


					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;
					// ${"cost_txt_" . $sup_key} .= "<tr><th></th><th  style='text-align:right;'>".$oformat_amount."</th><th style='text-align:right;'>0.00</th></tr>";
					$cost_arr[$sup_key][$subcat_id_ar]['total_amount'] = $oformat_amount;



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}

			if ($sup_key == 'asset') {
				$total_assets = "R" . number_format((float) $total_asset, 2);
				$total_assets_txt = "<tr><th >Total Asset</th><th style='text-align:right;'>" . $total_assets . "</th><th style='text-align:right;'>0.00</th></tr>";
				$cost_arr['total_assets'] = $total_assets;
			}
		}

		$unallocated_difference = 0;

		// echo "issued_capital = ".$issued_capital;

		// $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);


		$tax = (((float) $profit * 28) / 100);
		// $otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount_invoice($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);


		// $total_quity_xl = (float)$unallocated_difference+(float)$profit+(float)$issued_capital;
		$total_quity_xl = (float) $final_retained_total + (float) $issued_capital;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);

		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);

		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);

		// $qut_txt = "<tr><th colspan='3'>Equity and Liabilities</th></tr><tr><th colspan='3'>Equity</th></tr><tr><td>Issued capital</td><td  style='text-align:right;'>".$oissued_capital."</td><td style='text-align:right;'>".$oissued_capital."</td></tr><tr><td>Retained earnings</td><td  style='text-align:right;'>".$oprofit."</td><td style='text-align:right;'>0.00</td></tr><tr><th></th><th  style='text-align:right;'>".$ototal_quity."</th><th style='text-align:right;'>0.00</th></tr>";

		// $totallibeqt_txt = "<tr><th style=''>Total Liabilities and Equity</th><th style='text-align:right;'>".$ototal_libeqt."</th><th style='text-align:right;'>0.00</th></tr>";

		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['ofinal_retained_total'] = $ofinal_retained_total;
		$cost_arr['ototal_quity'] = $ototal_quity;
		$cost_arr['ototal_libeqt'] = $ototal_libeqt;
		$cost_arr['check_previous_data'] = $check_previous_data;

		return $cost_arr;


		exit();
	}
	public function getFinancialPositionReport_previousBk($postdata = array())
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = $check_previous_data = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];


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
		$cost_arr = array();


		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

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


				// echo $this->db->last_query();
				// echo "<pre>";print_r($ReportDetails);echo "</pre>";

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					${"cost_txt_" . $sup_key} .= "<tr><th>" . $child_costname . "</th><th></th><th></th></tr>";


					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {
						$check_previous_data = 1;

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['child_costname'] = $child_costname;
						}
					}
					if ($ReportDetails) {
						$check_previous_data = 1;
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$report_type = $ReportDetail->report_type;
							$ledger_type = $ReportDetail->ledger_type;
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
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
							if ($subcategory_id == '8') {
								$amount = (abs($amount));
							}
							$total_amount += (float) $amount;


							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;



							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key][$subcat_id_ar]['links'][$links]['child_costname'] = $child_costname;
						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$cost_arr[$sup_key][$subcat_id_ar]['total_amount'] = $oformat_amount;



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


				$total_assets = "R" . number_format((float) $total_asset, 2);
				$cost_arr['total_assets'] = $total_assets;
			}
		}



		$unallocated_difference = 0;
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);
		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);


		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);

		$restotal = $this->calculate_total_retained_amount($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);



		// $total_quity_xl = (float)$unallocated_difference+(float)$profit;
		// $ototal_quity = "R".number_format((float)$total_quity_xl, 2);
		$total_quity_xl = (float) $final_retained_total + (float) $issued_capital;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);


		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);


		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);

		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['ofinal_retained_total'] = $ofinal_retained_total;
		$cost_arr['ototal_quity'] = $ototal_quity;
		$cost_arr['ototal_libeqt'] = $ototal_libeqt;
		$cost_arr['check_previous_data'] = $check_previous_data;
		return $cost_arr;
		exit();
	}
	public function getFinancialPositionReport_Bk($postdata = array()) //req
	{
		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];
		$previous_year = $postdata['previous_year'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];
		$previous_arr_data = $this->getFinancialPositionReport_previousBk(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $previous_year, 'start_month' => $start_month, 'end_month' => $end_month));
		// echo "<pre>";print_r($previous_arr_data);echo "</pre>"; 

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
		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_tb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		$subcat_id_loop = array('asset' => array('5','7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));

		$cost_txt_5_asset = $cost_txt_7_asset = $cost_txt_6_libt = $cost_txt_8_libt = $cost_txt_10_other = $cost_txt_70_other = $cost_txt_71_other = $cost_txt_total_5_asset = $cost_txt_total_7_asset = $cost_txt_total_6_libt = $cost_txt_total_8_libt = $cost_txt_total_10_other = $cost_txt_total_70_other = $cost_txt_total_71_other = '';
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {
	

			// echo "subcat_id_arr = ".$subcat_id_arr;
			// ${"cost_txt_" . $sup_key} = '';

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


				// echo $this->db->last_query();
				// echo "<pre>";print_r($ReportDetails);echo "</pre>";

				$total_amount = 0;
				
				$childcost = $CostDetails_arr[$subcat_id_ar];

				$child_costname = $childcost->cost_name;
				if ($ReportDetails || $ReportDetails_bank) {
					$show_total = 0;
					$bank_balance = 0;
					if (($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) || !empty($ReportDetails)) {
						${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><th>" . $child_costname . "</th><th></th><th class='previous_tb'></th></tr>";
					}
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank) && $subcat_id_ar != '7') {
						// ${"cost_txt_" . $sup_key} .= "<tr><th>".$child_costname."</th><th></th><th></th></tr>";
						$show_total = 1;
						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] : 'R0.00';
							${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";

							unset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]);
						}
					}
					if (!empty($ReportDetails)) {
						// echo "<pre>"; print_r($ReportDetails);
						$show_total = 1;
						// ${"cost_txt_" . $sup_key} .= "<tr><th>".$child_costname."</th><th></th><th></th></tr>";
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$report_type = $ReportDetail->report_type;
							$ledger_type = $ReportDetail->ledger_type;
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								// echo "<pre>"; print_r($catcost); 

								if ($catcost) {
									foreach ($catcost as $ctcost) {

										$cost_name = $ctcost->cost_name;
										$links = $ctcost->links;
									}
								}
								
							}
							if ($subcategory_id == '8') {
								$amount = (abs($amount));
							}

							$total_amount += (float) $amount;


							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;



							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] : 'R0.00';
							// echo "kkkk".$subcat_id_ar; die;
							if($subcat_id_ar != '7'){
								${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							}
							//change req
							unset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]);
						}
					}
					
					if ($show_total) {
						$oformat_amount = "R" . number_format((float) $total_amount, 2);
						$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['total_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['total_amount'] : 'R0.00';
						// $non_curent_asset = '';

						if($subcat_id_ar == '7'){
							// $non_curent_asset = 'Property, plant and equipment';
							${"cost_txt_total_" . $subcat_id_ar . "_" . $sup_key} = "<tr class='custom-non-asset'><th>Property, plant and equipment</th><th class='tb_bbtm1'  style='text-align:right;'>" . $oformat_amount . "</th><th class='tb_bbtm1 previous_tb' style='text-align:right;'>" . $pr_amt . "</th></tr>";
						}else{
							// echo $subcat_id_ar; 
							${"cost_txt_total_" . $subcat_id_ar . "_" . $sup_key} = "<tr><th></th><th class='tb_bbtm1'  style='text-align:right;'>" . $oformat_amount . "</th><th class='tb_bbtm1 previous_tb' style='text-align:right;'>" . $pr_amt . "</th></tr>";
						}

					}
					
					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
				
			}
			// echo "<pre>"; print_r($cost_txt_7_asset);die;
			// echo "<pre>"; print_r($cost_txt_7_asset);die;

			if ($sup_key == 'asset') {

				$excel_appd_arr['total_ast_ct'] = $excel_arrcount;


				$total_assets = "R" . number_format((float) $total_asset, 2);
				$pr_amt = isset($previous_arr_data['total_assets']) ? $previous_arr_data['total_assets'] : 'R0.00';
				$total_assets_txt = "<tr><th >Total Asset</th><th class='tb_bbtm' style='text-align:right;'>" . $total_assets . "</th><th class='previous_tb tb_bbtm' style='text-align:right;'>" . $pr_amt . "</th></tr>";
			}
		}


		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {
			// echo "sssss";
			// echo "subcat_id_arr = ".$subcat_id_arr;
			// ${"cost_txt_" . $sup_key} = '';
			foreach ($subcat_id_arr as $subcat_id_ar) {

				foreach ($previous_arr_data as $pdata_key => $pdata_val) {

					if (isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links']) && $subcat_id_ar !='7') {
						// echo "<pre>test  = ";print_r($pdata_val[$subcat_id_ar]['links']);echo "</pre>";
						foreach ($pdata_val[$subcat_id_ar]['links'] as $pkey => $pval) {
							$pr_amt = isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['oformat_amount']) ? $previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['oformat_amount'] : 'R0.00';
							$cname = isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['cost_name']) ? $previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['cost_name'] : '';
							// echo "<pre>"; print_r($cname);	
							// $child_cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname'])? $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname']:'';
							// if($child_cname !='')
							// ${"cost_txt_" . $pdata_key} .= "<tr><th colspan='3'>".$child_cname."</th></tr>";

							${"cost_txt_" . $subcat_id_ar . "_" . $pdata_key} .= "<tr><td>" . $cname . "</td><td class='tb_bbtm1'  style='text-align:right;'>R0.00</td><td class='tb_bbtm1 previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
						}
					}
				}
			}
		}

		$unallocated_difference = 0;
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);
		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);

		$restotal = $this->calculate_total_retained_amount($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);




		$total_quity_xl = (float) $final_retained_total + (float) $issued_capital;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);


		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);


		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);

		$pr_ofinal_retained_total = isset($previous_arr_data['ofinal_retained_total']) ? $previous_arr_data['ofinal_retained_total'] : 'R0.00';
		$pr_ototal_quity = isset($previous_arr_data['ototal_quity']) ? $previous_arr_data['ototal_quity'] : 'R0.00';
		$pr_ototal_libeqt = isset($previous_arr_data['ototal_libeqt']) ? $previous_arr_data['ototal_libeqt'] : 'R0.00';

		$qut_txt = "<tr><th>Equity and Liabilities</th><th></th><th class='previous_tb'></th></tr><tr><th>Equity</th><th></th><th class='previous_tb'></th></tr>
		<tr><td>Issued capital</td><td  style='text-align:right;'>" . $oissued_capital . "</td><td class='previous_tb' style='text-align:right;'>" . $oissued_capital . "</td></tr>
		<tr><td>Retained earnings</td><td  style='text-align:right;'>" . $ofinal_retained_total . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_ofinal_retained_total . "</td></tr>
		<tr><th></th><th class='tb_bbtm1'  style='text-align:right;'>" . $ototal_quity . "</th><th class='tb_bbtm1 previous_tb' style='text-align:right;'>" . $pr_ototal_quity . "</th></tr>";

		$totallibeqt_txt = "<tr><th style=''>Total Liabilities and Equity</th><th class='tb_bbtm' style='text-align:right;'>" . $ototal_libeqt . "</th><th class='previous_tb tb_bbtm' style='text-align:right;'>" . $pr_ototal_libeqt . "</th></tr>";

		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$previous_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$previous_styl = "<style>.previous_tb{display:none;}</style>";
		}
		// echo "<pre>";print_r($cost_txt_7_asset);echo "</pre>"; 

		// $cost_txt =  $cost_txt_start." <tr><th>Assets</th><th></th><th></th></tr>".$cost_txt_asset." ".$cost_txt_total_asset." ".$total_assets_txt." ".$qut_txt." ".$cost_txt_libt." ".$cost_txt_total_libt." ".$totallibeqt_txt."</tbody></table>";
		$cost_txt = $previous_styl . $cost_txt_start . " <tr><th>Assets</th><th></th><th class='previous_tb'></th></tr>" . $cost_txt_5_asset . " " . $cost_txt_total_5_asset . " " . $cost_txt_7_asset . " " . $cost_txt_total_7_asset . " " . $total_assets_txt . " " . $qut_txt . " " . $cost_txt_6_libt . " " . $cost_txt_total_6_libt . " " . $cost_txt_8_libt . " " . $cost_txt_total_8_libt . " " . $totallibeqt_txt . "</tbody></table>";
		// $cost_txt_5_asset = $cost_txt_7_asset = $cost_txt_6_libt = $cost_txt_8_libt = $cost_txt_10_other = $cost_txt_70_other = $cost_txt_71_other = $cost_txt_total_5_asset = $cost_txt_total_7_asset  = $cost_txt_total_6_libt = $cost_txt_total_8_libt = $cost_txt_total_10_other = $cost_txt_total_70_other = $cost_txt_total_71_other= '';

		// $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
		// $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

		// $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
		// $excel_array[] = array( 'Profit', '' , $profit);

		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;

//  die;

		return $cost_txt;
		exit();
	}

	public function getFinancialPositionReport($postdata)
	{
		// echo "test";
		// die;
		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = $previous_unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		$start_year = $postdata['start_year'];
		$start_month = $postdata['start_month'];
		$end_month = $postdata['end_month'];
		$previous_year = $postdata['previous_year'];
		// echo "<pre>";print_r($postdata);echo "</pre>";

		// $previous_arr_data = $this->getPreviousFinancialPositionReport($postdata);
		$previous_arr_data = $this->getPreviousFinancialPositionReport(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $previous_year, 'start_month' => $start_month, 'end_month' => $end_month));


		// $year=$_POST['year'];
		// $inputh_year = $year;
		// $start_date_exp=explode("-",$start_date);
		// $end_date_exp=explode("-",$end_date);
		// $filtered_start_month = $start_date_exp[0];
		// $filtered_end_month = $end_date_exp[0];
		// $start_year = $start_date_exp[1];
		// $end_year = $end_date_exp[1];
		// $inputh_year = $start_year.'-'.$end_year;

		$report_url = 'invoice_financial';
		$ledger_title = 'STATEMENT OF FINANCIAL POSITION';
		$ledger_menu = 'financial_position';



		$end_month = '2';
		/*$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
										$issued_capital = $cdetl->issue_capital;
									}
								}*/

		/*$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

								$full_details = [];

								// $start_date = date('Y-m-d');

								// $year_start = $years[0];
								// $year_end = $years[1];


								$start_date = $start_year."-".$filtered_start_month."-01";
								$end_date = $end_year."-".$filtered_end_month."-01";
								$end_date = date('Y-m-t',strtotime($end_date));
								$previous_year = $start_year-1;
								$previous_start_date = $previous_year."-".$filtered_start_month_cl."-01";
								$previous_end_date = $start_year."-".$filtered_end_month_cl."-01";
								$previous_end_date = date('Y-m-t',strtotime($previous_end_date));

								$end_day = date('t M Y',strtotime($end_date));
								$previous_end_day = date('t M Y',strtotime($previous_end_date));*/

		// echo "previous_start_date = ".$previous_start_date." = previous_end_date = ".$previous_end_date;




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

		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div>';

		// echo "<pre>";print_r($previous_arr_data);echo "</pre>";

		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_tb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';

		$total_asset = $total_liabilities = 0;
		$previous_total_asset = $previous_total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();




		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);
		// $previous_opening_balancee_data = $this->bankstat_openingbanlance_invoice($previous_start_date,$filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));


		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));

		$cost_txt_5_asset = $cost_txt_7_asset = $cost_txt_6_libt = $cost_txt_8_libt = $cost_txt_10_other = $cost_txt_70_other = $cost_txt_71_other = $cost_txt_total_5_asset = $cost_txt_total_7_asset = $cost_txt_total_6_libt = $cost_txt_total_8_libt = $cost_txt_total_10_other = $cost_txt_total_70_other = $cost_txt_total_71_other = '';

		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {
			// echo "saaaaaaaaa";

			// echo "subcat_id_arr = ".$sup_key;
			// ${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					// echo "1";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					// echo "2";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
				} else {
					// echo "3";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));






				$total_amount = $previous_total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;


				if ($ReportDetails || $ReportDetails_journal) {
					// echo "ss = ".$child_costname;

					${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><th>" . $child_costname . "</th><th></th><th class='previous_tb'></th></tr>";


					$bank_balance = 0;




					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;

							$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] : 'R0.00';
							${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";

							if (isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]))
								unset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]);
						}
					}
					if ($ReportDetails) {
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] : 'R0.00';

							${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							if (isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]))
								unset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]);
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;


							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit += (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]['oformat_amount'] : 'R0.00';

							${"cost_txt_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							unset($previous_arr_data[$sup_key][$subcat_id_ar]['links'][$links]);
						}
					}


					// foreach($previous_arr_data as $pdata)
					// {

					// }

					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;

					$pr_amt = isset($previous_arr_data[$sup_key][$subcat_id_ar]['total_amount']) ? $previous_arr_data[$sup_key][$subcat_id_ar]['total_amount'] : 'R0.00';

					${"cost_txt_total_" . $subcat_id_ar . "_" . $sup_key} .= "<tr><th></th><th class='tb_bbtm1'   style='text-align:right;'>" . $oformat_amount . "</th><th class='tb_bbtm1 previous_tb' style='text-align:right;'>" . $pr_amt . "</th></tr>";



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
			// echo "sssssssss";
			// echo "<pre>";print_r($previous_arr_data);echo "</pre>";

			// echo "<pre>";print_r($pdata_val);echo "</pre>";exit;
			// $pr_amt = isset( $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'])? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount']:'R0.00';

			// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>".$pr_amt."</td></tr>";




			if ($sup_key == 'asset') {
				$total_assets = "R" . number_format((float) $total_asset, 2);
				$pr_amt = isset($previous_arr_data['total_assets']) ? $previous_arr_data['total_assets'] : 'R0.00';
				$total_assets_txt = "<tr><th >Total Asset</th><th class='tb_bbtm' style='text-align:right;'>" . $total_assets . "</th><th class='previous_tb tb_bbtm' style='text-align:right;'>" . $pr_amt . "</th></tr>";
			}
		}

		// echo "<pre>";print_r($previous_arr_data);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {
			foreach ($subcat_id_arr as $subcat_id_ar) {

				foreach ($previous_arr_data as $pdata_key => $pdata_val) {

					if (isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links'])) {
						// echo "<pre>test  = ";print_r($pdata_val[$subcat_id_ar]['links']);echo "</pre>";
						foreach ($pdata_val[$subcat_id_ar]['links'] as $pkey => $pval) {
							$pr_amt = isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['oformat_amount']) ? $previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['oformat_amount'] : 'R0.00';
							$cname = isset($previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['cost_name']) ? $previous_arr_data[$pdata_key][$subcat_id_ar]['links'][$pkey]['cost_name'] : '';
							// $child_cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname'])? $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname']:'';
							// if($child_cname !='')
							// ${"cost_txt_" . $pdata_key} .= "<tr><th colspan='3'>".$child_cname."</th></tr>";

							${"cost_txt_" . $subcat_id_ar . "_" . $pdata_key} .= "<tr class='previous_tb'><td>" . $cname . "</td><td  style='text-align:right;'>R0.00</td><td style='text-align:right;'>" . $pr_amt . "</td></tr>";
						}
					}
				}
			}
		}


		/*foreach($previous_arr_data as $pdata_key => $pdata_val)
									{
										
										if(isset($pdata_val['links'])){
											// echo "<pre>";print_r($pdata_val['links']);echo "</pre>";
											foreach($pdata_val['links'] as $pkey => $pval)
											{
												$pr_amt = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount'])? $previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount']:'R0.00';
												$cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['cost_name'])? $previous_arr_data[$pdata_key]['links'][$pkey]['cost_name']:'';
												// $child_cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname'])? $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname']:'';
												// if($child_cname !='')
													// ${"cost_txt_" . $pdata_key} .= "<tr><th colspan='3'>".$child_cname."</th></tr>";

												${"cost_txt_".$subcat_id_ar."_" . $pdata_key} .= "<tr><td>".$cname."</td><td  style='text-align:right;'>R0.00</td><td style='text-align:right;'>".$pr_amt."</td></tr>";
												
											}
										}
									}*/

		$unallocated_difference = 0;

		// echo "issued_capital = ".$issued_capital;

		// $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);


		$tax = (((float) $profit * 28) / 100);
		// $otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);



		$restotal = $this->calculate_total_retained_amount_invoice($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		// $orestotal = "R".number_format((float)$restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);






		// $total_quity_xl = (float)$unallocated_difference+(float)$profit+(float)$issued_capital;
		$total_quity_xl = (float) $final_retained_total + (float) $issued_capital;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);

		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);

		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);
		$pr_oprofit = isset($previous_arr_data['oprofit']) ? $previous_arr_data['oprofit'] : 'R0.00';
		$pr_ofinal_retained_total = isset($previous_arr_data['ofinal_retained_total']) ? $previous_arr_data['ofinal_retained_total'] : 'R0.00';
		$pr_ototal_quity = isset($previous_arr_data['ototal_quity']) ? $previous_arr_data['ototal_quity'] : 'R0.00';
		$pr_ototal_libeqt = isset($previous_arr_data['ototal_libeqt']) ? $previous_arr_data['ototal_libeqt'] : 'R0.00';

		$qut_txt = "<tr><th>Equity and Liabilities</th><th></th><th class='previous_tb'></th></tr><tr><th>Equity</th><th></th><th class='previous_tb'></th></tr>
		<tr><td>Issued capital</td><td  style='text-align:right;'>" . $oissued_capital . "</td><td  class='previous_tb' style='text-align:right;'>" . $oissued_capital . "</td></tr>
		<tr><td>Retained earnings</td><td  style='text-align:right;'>" . $ofinal_retained_total . "</td><td class='previous_tb' style='text-align:right;'>" . $pr_ofinal_retained_total . "</td></tr>
		<tr><th></th><th class='tb_bbtm1'  style='text-align:right;'>" . $ototal_quity . "</th><th class='previous_tb tb_bbtm1' style='text-align:right;'>" . $pr_ototal_quity . "</th></tr>";

		$totallibeqt_txt = "<tr><th style=''>Total Liabilities and Equity</th><th class='tb_bbtm' style='text-align:right;'>" . $ototal_libeqt . "</th><th class='previous_tb tb_bbtm' style='text-align:right;'>" . $pr_ototal_libeqt . "</th></tr>";


		// $subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;
		// $cost_txt =  $cost_txt_start." <tr><th>Assets</th><th></th><th></th></tr>".$cost_txt_asset." ".$total_assets_txt." ".$qut_txt." ".$cost_txt_libt ." ".$totallibeqt_txt."</tbody></table>";
		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$previous_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$previous_styl = "<style>.previous_tb{display:none;}</style>";
		}


		$cost_txt = $previous_styl . $cost_txt_start . " <tr><th>Assets</th><th></th><th class='previous_tb'></th></tr>" . $cost_txt_5_asset . " " . $cost_txt_total_5_asset . " " . $cost_txt_7_asset . " " . $cost_txt_total_7_asset . " " . $total_assets_txt . " " . $qut_txt . " " . $cost_txt_6_libt . " " . $cost_txt_total_6_libt . " " . $cost_txt_8_libt . " " . $cost_txt_total_8_libt . " " . $totallibeqt_txt . "</tbody></table>";



		return $cost_txt;
		exit();
	}
	public function ajax_financial_position()
	{
		$costtxt = $this->ajax_financial_position_fn($_POST);
		echo $costtxt;
	}
	public function ajax_financial_position_fn($postdata)
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		$start_date_exp = explode("-", $start_date);
		$end_date_exp = explode("-", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;

		$report_url = 'invoice_financial';
		$ledger_title = 'STATEMENT OF FINANCIAL POSITION';
		$ledger_menu = 'financial_position';



		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
			foreach ($CurrentClientDetails as $cdetl) {
				// $filtered_start_month = $cdetl->financial_month_start;
				// $filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
				$issued_capital = $cdetl->issue_capital;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $start_year;
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $end_year;

		$full_details = [];

		// $start_date = date('Y-m-d');

		// $year_start = $years[0];
		// $year_end = $years[1];


		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
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

		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div>';

		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Figures in R</th><th style="text-align:right;"">30 November 2022</th><th style="text-align:right;">18 February 2021</th></tr></thead><tbody>';

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();


		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));
		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70', '71'));


		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {
				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					// echo "1";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					// echo "2";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					// echo "3";
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));





				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {
					// ${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"cost_txt_" . $sup_key} .= "<tr><th colspan='3'>" . $child_costname . "</th></tr>";


					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td style='text-align:right;'>0.00</td></tr>";
						}
					}
					if ($ReportDetails) {
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
							if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
								$salesTotal = $ReportDetail->salesTotal;
								$expenseTotal = $ReportDetail->expenseTotal;
								$amount = $salesTotal - $expenseTotal;
							} else
								$amount = $ReportDetail->total_amount;


							if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
								$amount = -$amount;
							}

							if (!empty($ReportDetails_journal)) {
								foreach ($ReportDetails_journal as $jkey => $journal) {
									$journal_cost_id = $journal->cost_id;
									if ($cost_id == $journal_cost_id) {
										$salesTotal = $journal->salesTotal;
										$expenseTotal = $journal->expenseTotal;
										$journal_balance = $salesTotal - $expenseTotal;
										$amount = $amount + $journal_balance;
										unset($ReportDetails_journal[$jkey]);
									}
								}
							}

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td style='text-align:right;'>0.00</td></tr>";
						}
					}
					// echo "<pre>";print_r($ReportDetails_journal);echo "</prE>";
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit += (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td style='text-align:right;'>0.00</td></tr>";
						}
					}


					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;
					${"cost_txt_" . $sup_key} .= "<tr><th></th><th  style='text-align:right;'>" . $oformat_amount . "</th><th style='text-align:right;'>0.00</th></tr>";



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}

			if ($sup_key == 'asset') {
				$total_assets = "R" . number_format((float) $total_asset, 2);
				$total_assets_txt = "<tr><th >Total Asset</th><th style='text-align:right;'>" . $total_assets . "</th><th style='text-align:right;'>0.00</th></tr>";
			}
		}

		$unallocated_difference = 0;

		// echo "issued_capital = ".$issued_capital;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);
		$oissued_capital = "R" . number_format((float) $issued_capital, 2);





		$total_quity_xl = (float) $unallocated_difference + (float) $profit + (float) $issued_capital;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);

		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);

		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);

		$qut_txt = "<tr><th colspan='3'>Equity and Liabilities</th></tr><tr><th colspan='3'>Equity</th></tr>
		<tr><td>Issued capital</td><td  style='text-align:right;'>" . $oissued_capital . "</td><td style='text-align:right;'>" . $oissued_capital . "</td></tr>
		<tr><td>Retained earnings</td><td  style='text-align:right;'>" . $oprofit . "</td><td style='text-align:right;'>0.00</td></tr>
		<tr><th></th><th  style='text-align:right;'>" . $ototal_quity . "</th><th style='text-align:right;'>0.00</th></tr>";

		$totallibeqt_txt = "<tr><th style=''>Total Liabilities and Equity</th><th style='text-align:right;'>" . $ototal_libeqt . "</th><th style='text-align:right;'>0.00</th></tr>";


		// $subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;
		$cost_txt = $cost_txt_start . " " . $cost_txt_asset . " " . $total_assets_txt . " " . $qut_txt . " " . $cost_txt_libt . " " . $totallibeqt_txt . "</tbody></table>";



		return $cost_txt;
		exit();
	}

	public function pdf_financial_position()
	{
		$cost_txt = $this->ajax_financial_position_fn($_POST);

		$pdf_fname = 'financial_position.pdf';

		/********************* PDF start ********/
		$this->load->library('m_pdf');
		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name'] = 'Cost Group Report';
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
	public function getDetailedIncomeReport_invoice($postdata)
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = $total_sale = $total_costsale = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$previous_arr_data = $this->getDetailedIncomeReport_invoiceprevious(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital));



		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_invcometb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$stotal_asset = $stotal_liabilities = $stotal_expense = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));

				// echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {
					${"cost_txt_" . $sup_key} .= "<tr><th>" . $child_costname . "</th><th></th><th class='previous_invcometb'></th></tr>";
					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$pr_amt = isset($previous_arr_data[$sup_key]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'] : 'R0.00';

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_invcometb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							unset($previous_arr_data[$sup_key]['links'][$links]);
						}
					}

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
						if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;
						} else
							$amount = $ReportDetail->total_amount;


						if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
							$amount = -$amount;
						}

						if (!empty($ReportDetails_journal)) {
							foreach ($ReportDetails_journal as $jkey => $journal) {
								$journal_cost_id = $journal->cost_id;
								if ($cost_id == $journal_cost_id) {
									$salesTotal = $journal->salesTotal;
									$expenseTotal = $journal->expenseTotal;
									$journal_balance = $salesTotal - $expenseTotal;
									$amount = $amount + $journal_balance;
									unset($ReportDetails_journal[$jkey]);
								}
							}
						}

						$amount = number_format((float) $amount, 2, '.', '');
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

						$total_amount += (float) $amount;
						// $oformat_amount = "R".number_format((float)$amount, 2);
						// $oformat_amount_xl = $amount;
						if ($subcategory_id == '10') {
							$omt = abs($amount);
							$oformat_amount = "R" . number_format((float) $omt, 2);
						} else
							$oformat_amount = "R" . number_format((float) $amount, 2);

						if ($subcategory_id == '5') {
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Current Asset
						else if ($subcategory_id == '6') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Current Liabilities
						else if ($subcategory_id == '7') {
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Non-Curent Asset
						else if ($subcategory_id == '8') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Non-Current Liabilities
						else if ($subcategory_id == '9') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Equity
						else if ($subcategory_id == '10') {
							$profit -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
							$total_sale += (float) $amount;
						} //Sales
						else if ($subcategory_id == '70') {
							$profit -= (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$total_costsale += (float) $amount;
						} //Cost of Sales
						else if ($subcategory_id == '71') {
							$profit -= (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Expenses

						$pr_amt = isset($previous_arr_data[$sup_key]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'] : 'R0.00';
						${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_invcometb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
						unset($previous_arr_data[$sup_key]['links'][$links]);
					}
					if ($ReportDetails_journal) {
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							// $oformat_amount = "R".number_format((float)$amount, 2);
							// $oformat_amount_xl = $amount;
							if ($subcategory_id == '10') {
								$omt = abs($amount);
								$oformat_amount = "R" . number_format((float) $omt, 2);
							} else
								$oformat_amount = "R" . number_format((float) $amount, 2);

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit += (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$pr_amt = isset($previous_arr_data[$sup_key]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'] : 'R0.00';
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_invcometb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							unset($previous_arr_data[$sup_key]['links'][$links]);
						}
					}

					// echo "sup_key = ".$sup_key;
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					${"stotal_" . $sup_key} = $oformat_amount;



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}




		foreach ($previous_arr_data as $pdata_key => $pdata_val) {

			if (isset($pdata_val['links'])) {
				// echo "<pre>";print_r($pdata_val['links']);echo "</pre>";
				foreach ($pdata_val['links'] as $pkey => $pval) {
					$pr_amt = isset($previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount']) ? $previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount'] : 'R0.00';
					$cname = isset($previous_arr_data[$pdata_key]['links'][$pkey]['cost_name']) ? $previous_arr_data[$pdata_key]['links'][$pkey]['cost_name'] : '';
					// $child_cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname'])? $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname']:'';
					// if($child_cname !='')
					// ${"cost_txt_" . $pdata_key} .= "<tr><th colspan='3'>".$child_cname."</th></tr>";

					${"cost_txt_" . $pdata_key} .= "<tr class='previous_invcometb'><td>" . $cname . "</td><td  style='text-align:right;'>R0.00</td><td style='text-align:right;'>" . $pr_amt . "</td></tr>";
				}
			}
		}

		// $ototal_expense = "R".number_format((float)$total_expense, 2);
		$pr_amt = isset($previous_arr_data[$sup_key]['total_expense']) ? $previous_arr_data[$sup_key]['total_expense'] : 'R0.00';
		$cost_txt_texpense = "<tr><th></th><th  class='tb_bbtm1' style='text-align:right;'>" . $stotal_expense . "</th><th class='previous_invcometb tb_bbtm1' style='text-align:right;'>" . $pr_amt . "</th></tr>";






		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;

		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);

		// $ototal_quity = "R".number_format((float)$total_quity_xl, 2);


		// $ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);


		// $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);






		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);

		$pr_oprofit = isset($previous_arr_data['oprofit']) ? $previous_arr_data['oprofit'] : 'R0.00';
		$pr_otax = isset($previous_arr_data['otax']) ? $previous_arr_data['otax'] : 'R0.00';
		$pr_oprofit_tax = isset($previous_arr_data['oprofit_tax']) ? $previous_arr_data['oprofit_tax'] : 'R0.00';
		$pr_ogrossprofit = isset($previous_arr_data['ogrossprofit']) ? $previous_arr_data['ogrossprofit'] : 'R0.00';


		$final_txt = "<tr><th>Profit Before Taxation</th><th class='tb_bbtm' style='text-align:right;'>" . $oprofit . "</th><th class='previous_invcometb tb_bbtm' style='text-align:right;'>" . $pr_oprofit . "</th></tr>
		<tr><td>Taxation</td><td style='text-align:right;'>" . $otax . "</td><td class='previous_invcometb' style='text-align:right;'>" . $pr_otax . "</td></tr>
		<tr><th>Profit After Taxation</th><th class='tb_bbtm' style='text-align:right;'>" . $oprofit_tax . "</th><th class='previous_invcometb tb_bbtm' style='text-align:right;'>" . $pr_oprofit_tax . "</th></tr>
		";

		$gross_txt = "<tr><th>Gross Profit</th><th class='tb_bbtm1' style='text-align:right;'>" . $ogrossprofit . "</th><th class='previous_invcometb tb_bbtm1' style='text-align:right;'>" . $pr_ogrossprofit . "</th></tr>";




		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$iprevious_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$iprevious_styl = "<style>.previous_invcometb{display:none;}</style>";
		}


		$cost_txt = $iprevious_styl . $cost_txt_start . " " . $cost_txt_other . " " . $gross_txt . " " . $cost_txt_expense . " " . $cost_txt_texpense . " " . $final_txt . "</tbody></table>";






		return $cost_txt;

		exit();
	}
	public function getDetailedIncomeReport_invoiceprevious($postdata)
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = $cost_arr = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = $total_sale = $total_costsale = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];




		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}



		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$stotal_asset = $stotal_liabilities = $stotal_expense = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance_invoice($start_date, $filtered_client_id);

		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2"  or report_type="11" or report_type="12")'));

		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));

		$check_previous_data = 0;

		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'amount_type' => 'sales', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" AND report_type != "11", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" OR report_type = "11", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="11" )'));
					// echo $this->db->last_query();
					// echo "<pre>ReportDetails = ";print_r($ReportDetails);echo "</pre>";
				} else if ($subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'amount_type' => 'expense', 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales" OR report_type="12", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense" and report_type !="12", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'amount_type', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5"  or report_type="12" )'));
					// echo $this->db->last_query();
				} else {
					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				// echo $this->db->last_query();
				$ReportDetails_journal = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,category_id,subcategory_id,cost_id', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '( subcategory_id ="' . $subcat_id_ar . '" and report_type="3" and ledger_type="1" )'));

				// echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_journal) {
					${"cost_txt_" . $sup_key} .= "<tr><th colspan='3'>" . $child_costname . "</th></tr>";
					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							if ($amount > 0) {
								$check_previous_data = 1;
							}
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;
						}
					}
					// echo "bb check_previous_data = ".$check_previous_data;

					foreach ($ReportDetails as $ReportDetail) {
						$check_previous_data = 1;
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
						if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID || $subcat_id_ar == EXPENSE_COST_SUBCAT_ID) {
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;
						} else
							$amount = $ReportDetail->total_amount;


						if ($subcat_id_ar == SALES_COST_SUBCAT_ID) {
							$amount = -$amount;
						}

						if (!empty($ReportDetails_journal)) {
							foreach ($ReportDetails_journal as $jkey => $journal) {
								$journal_cost_id = $journal->cost_id;
								if ($cost_id == $journal_cost_id) {
									$salesTotal = $journal->salesTotal;
									$expenseTotal = $journal->expenseTotal;
									$journal_balance = $salesTotal - $expenseTotal;
									$amount = $amount + $journal_balance;
									unset($ReportDetails_journal[$jkey]);
								}
							}
						}

						$amount = number_format((float) $amount, 2, '.', '');
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

						$total_amount += (float) $amount;
						// $oformat_amount = "R".number_format((float)$amount, 2);
						// $oformat_amount_xl = $amount;
						if ($subcategory_id == '10') {
							$omt = abs($amount);
							$oformat_amount = "R" . number_format((float) $omt, 2);
						} else
							$oformat_amount = "R" . number_format((float) $amount, 2);

						if ($subcategory_id == '5') {
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Current Asset
						else if ($subcategory_id == '6') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Current Liabilities
						else if ($subcategory_id == '7') {
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Non-Curent Asset
						else if ($subcategory_id == '8') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Non-Current Liabilities
						else if ($subcategory_id == '9') {
							$unallocated_difference -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
						} //Equity
						else if ($subcategory_id == '10') {
							$profit -= (float) $amount;
							$cr_amt = $amount;
							$dr_amount = '';
							$total_sale += (float) $amount;
						} //Sales
						else if ($subcategory_id == '70') {
							$profit -= (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$total_costsale += (float) $amount;
						} //Cost of Sales
						else if ($subcategory_id == '71') {
							$profit -= (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
						} //Expenses

						$cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
						$cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
						$cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;
					}
					if (!empty($ReportDetails_journal)) {
						$check_previous_data = 1;
						foreach ($ReportDetails_journal as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$salesTotal = $ReportDetail->salesTotal;
							$expenseTotal = $ReportDetail->expenseTotal;
							$amount = $salesTotal - $expenseTotal;

							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;
							// $oformat_amount = "R".number_format((float)$amount, 2);
							// $oformat_amount_xl = $amount;
							if ($subcategory_id == '10') {
								$omt = abs($amount);
								$oformat_amount = "R" . number_format((float) $omt, 2);
							} else
								$oformat_amount = "R" . number_format((float) $amount, 2);

							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit += (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;
						}
					}

					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$cost_arr[$sup_key]['total_' . $sup_key] = $oformat_amount;



					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}




		// echo "check_previous_data = ".$check_previous_data;



		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;

		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);

		// $ototal_quity = "R".number_format((float)$total_quity_xl, 2);


		// $ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);


		// $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);






		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);

		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['otax'] = $otax;
		$cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['ogrossprofit'] = $ogrossprofit;
		$cost_arr['check_previous_data'] = $check_previous_data;












		return $cost_arr;

		exit();
	}
	public function getDetailedIncomeReport($postdata = array())
	{
		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_expens = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = $expense_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'expense_ct' => $expense_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$previous_start_date = $postdata['previous_start_date'];
		$previous_end_date = $postdata['previous_end_date'];
		$end_day = $postdata['end_day'];
		$previous_end_day = $postdata['previous_end_day'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$previous_arr_data = $this->getPreviousDetailedIncomeReport(array('client_id' => $filtered_client_id, 'report_type' => 1, 'start_date' => $previous_start_date, 'end_date' => $previous_end_date, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital));


		// $year=$_POST['year'];
		// $inputh_year = $year;
		// $years=explode("-",$year);

		// $start_date = $postdata['start_date'];
		// $end_date = $postdata['end_date'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		/*$start_date_exp=explode("-",$start_date);
								$end_date_exp=explode("-",$end_date);
								$filtered_start_month = $start_date_exp[0];
								$filtered_end_month = $end_date_exp[0];
								$start_year = $start_date_exp[1];
								$end_year = $end_date_exp[1];
								$inputh_year = $start_year.'-'.$end_year;*/

		$report_url = 'detailed_income';
		$ledger_title = 'DETAILED INCOME STATEMENT';
		$ledger_menu = 'detailed_income';



		/*$end_month = '2';
								$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
									}
								}

								$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

								$full_details = [];

								$start_date = date('Y-m-d');

								// $year_start = $years[0];
								// $year_end = $years[1];
								
								// echo "<pre>";print_r($previous_arr_data);echo "</pre>";


								$start_date = $start_year."-".$filtered_start_month."-01";
								$end_date = $end_year."-".$filtered_end_month."-01";
								$end_date = date('Y-m-t',strtotime($end_date));
								$previous_year = $start_year-1;
								$previous_start_date = $previous_year."-".$filtered_start_month_cl."-01";
								$previous_end_date = $start_year."-".$filtered_end_month_cl."-01";
								$previous_end_date = date('Y-m-t',strtotime($previous_end_date));

								$end_day = date('t M Y',strtotime($end_date));
								$previous_end_day = date('t M Y',strtotime($previous_end_date));*/

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
		$cost_txt_start = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th style="text-align:right;">' . $end_day . '</th><th class="previous_intb" style="text-align:right;">' . $previous_end_day . '</th></tr></thead><tbody>';



		$total_asset = $total_liabilities = $total_expense = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));


		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70'),'expense'=>array('71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {


				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					// ${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"cost_txt_" . $sup_key} .= "<tr><th>" . $child_costname . "</th><th></th><th class='previous_intb'></th></tr>";



					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							$pr_amt = isset($previous_arr_data[$sup_key]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'] : 'R0.00';
							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_intb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							unset($previous_arr_data[$sup_key]['links'][$links]);
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;

							if ($subcategory_id == '10') {
								$omt = abs($amount);
								$oformat_amount = "R" . number_format((float) $omt, 2);
							} else
								$oformat_amount = "R" . number_format((float) $amount, 2);



							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$pr_amt = isset($previous_arr_data[$sup_key]['links'][$links]['oformat_amount']) ? $previous_arr_data[$sup_key]['links'][$links]['oformat_amount'] : 'R0.00';

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td><td class='previous_intb' style='text-align:right;'>" . $pr_amt . "</td></tr>";
							unset($previous_arr_data[$sup_key]['links'][$links]);
						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					${"stotal_" . $sup_key} = $oformat_amount;
					// $pr_amt = isset( $previous_arr_data[$sup_key]['total_amount'])? $previous_arr_data[$sup_key]['total_amount']:'R0.00';
					// ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
					// ${"cost_txt_" . $sup_key} .= "<tr><th></th><th  style='text-align:right;'>".$oformat_amount."</th><th style='text-align:right;'>".$pr_amt."</th></tr>";






					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}


		foreach ($previous_arr_data as $pdata_key => $pdata_val) {

			if (isset($pdata_val['links'])) {
				// echo "<pre>";print_r($pdata_val['links']);echo "</pre>";
				foreach ($pdata_val['links'] as $pkey => $pval) {
					$pr_amt = isset($previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount']) ? $previous_arr_data[$pdata_key]['links'][$pkey]['oformat_amount'] : 'R0.00';
					$cname = isset($previous_arr_data[$pdata_key]['links'][$pkey]['cost_name']) ? $previous_arr_data[$pdata_key]['links'][$pkey]['cost_name'] : '';
					// $child_cname = isset( $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname'])? $previous_arr_data[$pdata_key]['links'][$pkey]['child_costname']:'';
					// if($child_cname !='')
					// ${"cost_txt_" . $pdata_key} .= "<tr><th colspan='3'>".$child_cname."</th></tr>";

					${"cost_txt_" . $pdata_key} .= "<tr class='previous_intb'><td>" . $cname . "</td><td  style='text-align:right;'>R0.00</td><td style='text-align:right;'>" . $pr_amt . "</td></tr>";
				}
			}
		}

		// echo "total_expense = ".$total_expense;       	

		// $ototal_sale = "R".number_format((float)$total_sale, 2);
		// $pr_amt = isset( $previous_arr_data[$sup_key]['total_sale'])? $previous_arr_data[$sup_key]['total_sale']:'R0.00';
		// $cost_txt_tsale = "<tr><th></th><th  style='text-align:right;'>".$stotal_sale."</th><th style='text-align:right;'>".$pr_amt."</th></tr>";
		// $ototal_costsale = "R".number_format((float)$total_sale, 2);
		// $pr_amt = isset( $previous_arr_data[$sup_key]['total_costsale'])? $previous_arr_data[$sup_key]['total_costsale']:'R0.00';
		// $cost_txt_tcostsale = "<tr><th></th><th  style='text-align:right;'>".$stotal_costsale."</th><th style='text-align:right;'>".$pr_amt."</th></tr>";

		$ototal_expense = "R" . number_format((float) $total_expense, 2);
		$pr_amt = isset($previous_arr_data[$sup_key]['total_expense']) ? $previous_arr_data[$sup_key]['total_expense'] : 'R0.00';
		$cost_txt_texpense = "<tr><th></th><th class='tb_bbtm1'  style='text-align:right;'>" . $ototal_expense . "</th><th class='previous_intb tb_bbtm1' style='text-align:right;'>" . $pr_amt . "</th></tr>";



		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;

		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);

		// $ototal_quity = "R".number_format((float)$total_quity_xl, 2);


		// $ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);


		// $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);






		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);

		$pr_oprofit = isset($previous_arr_data['oprofit']) ? $previous_arr_data['oprofit'] : 'R0.00';
		$pr_otax = isset($previous_arr_data['otax']) ? $previous_arr_data['otax'] : 'R0.00';
		$pr_oprofit_tax = isset($previous_arr_data['oprofit_tax']) ? $previous_arr_data['oprofit_tax'] : 'R0.00';
		$pr_ogrossprofit = isset($previous_arr_data['ogrossprofit']) ? $previous_arr_data['ogrossprofit'] : 'R0.00';



		$final_txt = "<tr><th>Profit Before Taxation</th><th class='tb_bbtm' style='text-align:right;'>" . $oprofit . "</th><th class='previous_intb tb_bbtm' style='text-align:right;'>" . $pr_oprofit . "</th></tr>
		<tr><td>Taxation</td><td style='text-align:right;'>" . $otax . "</td><td class='previous_intb' style='text-align:right;'>" . $pr_otax . "</td></tr>
		<tr><th>Profit After Taxation</th><th class='tb_bbtm' style='text-align:right;'>" . $oprofit_tax . "</th><th class='previous_intb tb_bbtm' style='text-align:right;'>" . $pr_oprofit_tax . "</th></tr>
		";

		$gross_txt = "<tr><th>Gross Profit</th><th class='tb_bbtm1' style='text-align:right;'>" . $ogrossprofit . "</th><th class='previous_intb tb_bbtm1' style='text-align:right;'>" . $pr_ogrossprofit . "</th></tr>";




		$check_previous_data = isset($previous_arr_data['check_previous_data']) ? $previous_arr_data['check_previous_data'] : '0';
		$previous_styl = '';
		// echo "check_previous_data = ".$check_previous_data;
		if ($check_previous_data == '0') {
			$previous_styl = "<style>.previous_intb{display:none;}</style>";
		}


		$cost_txt = $previous_styl . $cost_txt_start . " " . $cost_txt_other . " " . $gross_txt . " " . $cost_txt_expense . " " . $cost_txt_texpense . " " . $final_txt . "</tbody></table>";






		return $cost_txt;
		exit();
	}
	public function getPreviousDetailedIncomeReport($postdata = array())
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_expens = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = $expense_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'expense_ct' => $expense_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];
		$issued_capital = $postdata['issued_capital'];
		$filtered_client_name = $postdata['filtered_client_name'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		/*$start_date_exp=explode("-",$start_date);
								$end_date_exp=explode("-",$end_date);
								$filtered_start_month = $start_date_exp[0];
								$filtered_end_month = $end_date_exp[0];
								$start_year = $start_date_exp[1];
								$end_year = $end_date_exp[1];
								$inputh_year = $start_year.'-'.$end_year;

								 $report_url = 'detailed_income';$ledger_title = 'DETAILED INCOME STATEMENT';$ledger_menu='detailed_income';
								


								$end_month = '2';
								$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									foreach($CurrentClientDetails as $cdetl)
									{
										$filtered_start_month_cl = $cdetl->financial_month_start;
										$filtered_end_month_cl = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
									}
								}

								$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
								$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

								$ts = strtotime($end_monthName.' '.$end_year);
								$end_monthName_date = date('t', $ts);
								 
								$start_fulldate = $start_monthName.' 1, '.$start_year;
								$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

								$full_details = [];

								$start_date = date('Y-m-d');

								// $year_start = $years[0];
								// $year_end = $years[1];
								// $previous_arr_data = $this->getPreviousFinancialPositionReport($postdata);


								// $start_date = $start_year."-".$filtered_start_month."-01";
								// $end_date = $end_year."-".$filtered_end_month."-01";
								// $end_date = date('Y-m-t',strtotime($end_date));
								$previous_year = $start_year-1;
								$start_date = $previous_year."-".$filtered_start_month_cl."-01";
								$end_date = $start_year."-".$filtered_end_month_cl."-01";
								$end_date = date('Y-m-t',strtotime($end_date));*/

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
		// $cost_txt_start = '<table class="table table-striped table-hover stl_costtbl"><thead><tr><th>Figures in R</th><th style="text-align:right;"">'.$end_day.'</th><th style="text-align:right;">'.$previous_end_day.'</th></tr></thead><tbody>';

		$check_previous_data = 0;

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));


		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70'),'expense'=>array('71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));

		$cost_arr = array();


		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// ${"cost_txt_" . $sup_key} = '';
			$cost_arr[$sup_key] = array();

			foreach ($subcat_id_arr as $subcat_id_ar) {


				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {
					// ${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					// ${"cost_txt_" . $sup_key} .= "<tr><th colspan='3'>".$child_costname."</th></tr>";
					$cost_arr[$sup_key]['child_costname'] = $child_costname;



					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							if ($amount > 0) {
								$check_previous_data = 1;
							}
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							// $pr_amt = isset( $previous_arr_data[$sup_key][$links]['oformat_amount'])? $previous_arr_data[$sup_key][$links]['oformat_amount']:'R0.00';
							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>".$pr_amt."</td></tr>";
							$cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;
						}
					}
					if (!empty($ReportDetails)) {
						$check_previous_data = 1;
						foreach ($ReportDetails as $ReportDetail) {
							$cost_id = $ReportDetail->cost_id;
							$subcategory_id = $ReportDetail->subcategory_id;
							$amount = $ReportDetail->total_amount;
							$amount_cr = $ReportDetail->TotalCR;
							$amount_dr = $ReportDetail->TotalDR;
							$report_type = $ReportDetail->report_type;
							$ledger_type = $ReportDetail->ledger_type;
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;


							// $oformat_amount = "R".number_format((float)$amount, 2);
							if ($subcategory_id == '10') {
								$omt = abs($amount);
								$oformat_amount = "R" . number_format((float) $omt, 2);
							} else
								$oformat_amount = "R" . number_format((float) $amount, 2);



							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							$cost_arr[$sup_key]['links'][$links]['oformat_amount'] = $oformat_amount;
							$cost_arr[$sup_key]['links'][$links]['cost_name'] = $cost_name;
							$cost_arr[$sup_key]['links'][$links]['child_costname'] = $child_costname;

							// $pr_amt = isset( $previous_arr_data[$sup_key][$links]['oformat_amount'])? $previous_arr_data[$sup_key][$links]['oformat_amount']:'R0.00';

							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td  style='text-align:right;'>".$oformat_amount."</td><td style='text-align:right;'>".$pr_amt."</td></tr>";


						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$cost_arr[$sup_key]['total_' . $sup_key] = $oformat_amount;
					// $oformat_amount = "R".number_format((float)$total_amount, 2);
					// ${"stotal_" . $sup_key} = $oformat_amount;
					// $pr_amt = isset( $previous_arr_data[$sup_key]['total_amount'])? $previous_arr_data[$sup_key]['total_amount']:'R0.00';
					// ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
					// ${"cost_txt_" . $sup_key} .= "<tr><th></th><th  style='text-align:right;'>".$oformat_amount."</th><th style='text-align:right;'>".$pr_amt."</th></tr>";






					if ($subcat_id_ar == '5' || $subcat_id_ar == '7') {
						$total_asset += $total_amount;
					}
					if ($subcat_id_ar == '6' || $subcat_id_ar == '8') {
						$total_liabilities += $total_amount;
					}
				}
			}
		}







		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;

		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		$cost_arr['oprofit'] = $oprofit;
		$cost_arr['otax'] = $otax;
		$cost_arr['oprofit_tax'] = $oprofit_tax;
		$cost_arr['ogrossprofit'] = $ogrossprofit;
		$cost_arr['check_previous_data'] = $check_previous_data;

		// echo "<pre>";print_r($cost_arr);echo "</pre>";



		// $cost_txt =  $cost_txt_start." ".$cost_txt_other." ".$gross_txt." ".$cost_txt_expense." ".$final_txt;






		return $cost_arr;
		exit();
	}
	public function ajax_detailed_income()
	{
		$costtxt = $this->ajax_detailed_income_fn($_POST);
		echo $costtxt;
	}
	public function ajax_detailed_income_pdf()
	{
		$costtxt = $this->ajax_detailed_income_fn($_POST);

		$pdf_fname = 'deailed_income.pdf';

		/********************* PDF start ********/
		$this->load->library('m_pdf');
		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name'] = 'Detailed Income Report';
		$page_data['table_div'] = $costtxt;
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
	public function ajax_detailed_income_fn($postdata)
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_expens = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = $expense_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'expense_ct' => $expense_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		// $years=explode("-",$year);

		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		$start_date_exp = explode("-", $start_date);
		$end_date_exp = explode("-", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;

		$report_url = 'detailed_income';
		$ledger_title = 'DETAILED INCOME STATEMENT';
		$ledger_menu = 'detailed_income';



		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				// $filtered_start_month = $cdetl->financial_month_start;
				// $filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $start_year;
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $end_year;

		$full_details = [];

		$start_date = date('Y-m-d');

		// $year_start = $years[0];
		// $year_end = $years[1];


		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
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
		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div>';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70'),'expense'=>array('71'));
		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

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

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
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

							$total_amount += (float) $amount;


							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;



							if ($subcategory_id == '5') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Current Asset
							else if ($subcategory_id == '6') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Current Liabilities
							else if ($subcategory_id == '7') {
								$unallocated_difference += (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Non-Curent Asset
							else if ($subcategory_id == '8') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Non-Current Liabilities
							else if ($subcategory_id == '9') {
								$unallocated_difference -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
							} //Equity
							else if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses

							${"cost_txt_" . $sup_key} .= "<tr><td>" . $cost_name . "</td><td>" . $links . "</td><td  style='text-align:right;'>" . $oformat_amount . "</td></tr>";
							${"excel_array_" . $sup_key}[] = array($cost_name, $links, $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							$excel_arrcount++;
						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
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







		$unallocated_difference = 0;

		$ounallocated_difference = "R" . number_format((float) $unallocated_difference, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;

		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);

		$total_quity_xl = (float) $unallocated_difference + (float) $profit;
		$ototal_quity = "R" . number_format((float) $total_quity_xl, 2);


		$total_libeqt_xl = (float) $total_quity_xl + (float) $total_liabilities;
		$ototal_libeqt = "R" . number_format((float) $total_libeqt_xl, 2);


		$total_unalloc_xl = (float) $total_asset - (float) $total_libeqt_xl;
		$ototal_unalloc = "R" . number_format((float) $total_unalloc_xl, 2);

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ototal_unalloc."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";





		// $totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		//$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";
		// $totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";






		// $totallibeqt_txt .= "<table class='table table-striped table-hover stl_costtbl' style='margin-top:45px;margin-bottom:45px;'><tbody><tr><th  colspan='2' style='font-size:18px;'>Unallocated Difference</th><th style='text-align:right;font-size:18px;'>".$ototal_unalloc."</th></tr></tbody></table>";


		// $excel_array_eqt[] = array( 'Equity', '' , '');
		//    $excel_array_eqt[] = array( '', '' , '');
		//    $excel_array_eqt[] = array( 'Cost Name', 'Links' , 'Amount');
		// // $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		// $excel_array_eqt[] = array( 'Profit', 'q.200.000' , $profit);
		// $excel_array_eqt[] = array( 'Total', '' , $total_quity_xl);
		//       $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');
		//       $excel_array_eqt[] = array( 'Total Liabilities and Equity', '' , $total_libeqt_xl);
		//       $excel_array_eqt[] = array( 'Unallocated Difference', '' , $total_unalloc_xl);
		//       $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');





		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);


		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>" . $oprofit . "</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";

		$gross_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Gross Profit</th><th style='text-align:right;'>" . $ogrossprofit . "</th></tr></tbody></table>";




		$excel_appd_arr['final_ct'] = $excel_arrcount;
		$excel_array_final[] = array('Profit Before Taxation', '', $profit);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;
		$excel_array_final[] = array('Taxation', '', $tax);
		$excel_arrcount++;
		$excel_array_final[] = array('Profit After Taxation', '', $profit_tax);
		$excel_ttfoot[] = $excel_arrcount;
		$excel_arrcount++;

		$subcat_id_loop = array(array('asset' => '5', '7'), array('libt' => '6', '8'), array('other' => '10', '70'), 'expense' => array('71'));

		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

		$cost_txt = $cost_txt_other . " " . $gross_txt . " " . $cost_txt_expense . " " . $final_txt;

		// $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
		// $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

		// $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
		// $excel_array[] = array( 'Profit', '' , $profit);

		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;


		$excel_fname = 'deailed_income.xls';
		$pdf_fname = 'financial_report.pdf';


		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('DETAILED INCOME STATEMENT');
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

		// $this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4'); 
		// $this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A'.$excel_appd_arr['total_ast_ct']);  
		// $this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A'.$excel_appd_arr['array_libt_ct']); 
		// $this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A'.$excel_appd_arr['array_eqt_ct']); 

		// echo "<pre>";print_r($excel_array_other);echo "</pre>";
		$this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A4');
		// $this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A'.$excel_appd_arr['other_ct']);  
		$this->excel->getActiveSheet()->fromArray($excel_array_expense, null, 'A' . $excel_appd_arr['expense_ct']);
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



		return $cost_txt;
		exit();
	}

	public function ajax_comprehensive_income($postdata = array())
	{

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0, 'array_libt_ct' => 0, 'array_eqt_ct' => $array_eqt_ct, 'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;
		$cbd_txt_pdf = '';
		$cbd_txt = '';
		$filtered_client_id = $postdata['client_id'];
		$report_type = $postdata['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		// $years=explode("-",$year);

		$start_date = $postdata['start_date'];
		$end_date = $postdata['end_date'];

		// $year=$_POST['year'];
		// $inputh_year = $year;
		$start_date_exp = explode("-", $start_date);
		$end_date_exp = explode("-", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;

		$report_url = 'comprehensive_income';
		$ledger_title = 'STATEMENT OF COMPREHENSIVE INCOME';
		$ledger_menu = 'comprehensive_income';



		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			foreach ($CurrentClientDetails as $cdetl) {
				// $filtered_start_month = $cdetl->financial_month_start;
				// $filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $start_year;
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $end_year;

		$full_details = [];

		$start_date = date('Y-m-d');

		// $year_start = $years[0];
		// $year_end = $years[1];


		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
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
		// $cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div>';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot = array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		$subcat_id_loop = array('asset' => array('5', '7'), 'libt' => array('6', '8'), 'other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

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
					// ${"excel_array_" . $sup_key}[] = array( '', '' , '');
					// ${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

					$excel_titlearr[] = $excel_arrcount;
					$excel_arrcount += 2;
					$excele_tablearr[] = $excel_arrcount;
					$excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										// $links = $ctcost->links;
									}
								}
							}

							// $total_amount += (float)$amount;


							// $oformat_amount = "R".number_format((float)$amount, 2);
							// $oformat_amount_xl = $amount;



							/* if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
																												else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
																												else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
																												else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
																												else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity*/
							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}

							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;

						}
					}
					$oformat_amount = "R" . number_format((float) $total_amount, 2);
					$oformat_amount_xl = $total_amount;
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
		}







		// $unallocated_difference = 0;

		// $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
		// $oprofit = "R".number_format((float)$profit, 2);



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








		// $final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";


		// $gross_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Gross Profit</th><th style='text-align:right;'>".$ogrossprofit."</th></tr></tbody></table>";




		// $excel_appd_arr['final_ct'] = $excel_arrcount; 
		// $excel_array_final[] = array( 'Profit Before Taxation', '' , $profit);
		// $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
		// $excel_array_final[] = array( 'Taxation', '' , $tax);
		// $excel_arrcount++;
		// $excel_array_final[] = array( 'Profit After Taxation', '' , $profit_tax);
		// $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;

		// $subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70'),'expense'=>array('71'));

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		$ototal_sale = "R" . number_format((float) $total_sale, 2);
		$ogrossprofit = "R" . number_format((float) $grossprofit, 2);
		$ototal_costsale = "R" . number_format((float) $total_costsale, 2);
		$ototal_operating_cost = "R" . number_format((float) $total_operating_cost, 2);
		$ototal_operating_profit = "R" . number_format((float) $total_operating_profit, 2);
		$ototal_finance_cost = "R" . number_format((float) $total_finance_cost, 2);
		$oprofit = "R" . number_format((float) $profit, 2);

		$tax = (((float) $profit * 28) / 100);
		$otax = "R" . number_format((float) $tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		$oprofit_tax = "R" . number_format((float) $profit_tax, 2);



		// $start_reportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'report_type' => 2,'status' => 1),'',array('orderby' => 'report_date', 'disporder' => 'desc', 'limit' => '1', 'offset' => '0' ));
		// echo $this->db->last_query();

		// echo "<pre>ddd = ";print_r($start_reportDetails);echo "</pre>";

		$restotal = $this->calculate_total_retained_amount($filtered_client_id, $report_type, $start_year, $start_month, $end_month);
		$orestotal = "R" . number_format((float) $restotal, 2);

		$final_retained_total = (float) $restotal + $profit_tax;
		$ofinal_retained_total = "R" . number_format((float) $final_retained_total, 2);
		// echo $restotal;

		$print_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><td  colspan='2'>Revenue</td><td style='text-align:right;'>" . $ototal_sale . "</td></tr><tr><td  colspan='2'>Cost of sales</td><td style='text-align:right;'>" . $ototal_costsale . "</td></tr><tr><th  colspan='2'>Gross profit</th><th style='text-align:right;'>" . $ogrossprofit . "</th></tr></tbody></table>";


		$print_txt .= "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><td  colspan='2'>Operating costs</td><td style='text-align:right;'>" . $ototal_operating_cost . "</td></tr><tr><th  colspan='2'>Operating profit</th><th style='text-align:right;'>" . $ototal_operating_profit . "</th></tr></tbody></table>";


		$print_txt .= "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><td  colspan='2'>Finance costs</td><td style='text-align:right;'>" . $ototal_finance_cost . "</td></tr><tr><th  colspan='2'>Profit before tax</th><th style='text-align:right;'>" . $oprofit . "</th></tr></tbody></table>";


		$print_txt .= "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><td  colspan='2'>Tax expense</td><td style='text-align:right;'>" . $otax . "</td></tr><tr><th  colspan='2'>Profit for the year</th><th style='text-align:right;'>" . $oprofit_tax . "</th></tr></tbody></table>";


		$print_txt .= "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><td  colspan='2'>Retained income at 1 March " . $start_year . "</td><td style='text-align:right;'>" . $orestotal . "</td></tr>
<tr><td  colspan='2'>Profit for the year</td><td style='text-align:right;'>" . $oprofit_tax . "</td></tr>
<tr><th  colspan='2'>Retained income at 30 November 2021</th><th style='text-align:right;'>" . $ofinal_retained_total . "</th></tr></tbody></table>";






		// $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

		$cost_txt = $print_txt;

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



		return $cost_txt;
		exit();
	}


	public function calculate_total_retained_amount($filtered_client_id, $report_type, $end_year, $start_month, $end_month)
	{
		$start_reportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'report_type' => 2, 'status' => 1), '', array('orderby' => 'report_date', 'disporder' => 'asc', 'limit' => '1', 'offset' => '0'));
		// echo $this->db->last_query();

		$total_retain_amt = 0;
		// echo "<pre>ddd = ";print_r($start_reportDetails);echo "</pre>";
		if (!empty($start_reportDetails)) {
			foreach ($start_reportDetails as $start_reportDetail) {
				$report_date = $start_reportDetail->report_date;
				$report_date_arr = explode('-', $report_date);
				// echo "<pre>";print_r($report_date_arr);echo "</pre>";
				$start_year = $report_date_arr[0];
				if ($end_year != $start_year) {

					// echo $start_year." = ".$end_year;exit;

					for ($current_year = $start_year; $current_year < $end_year; $current_year++) {
						$next_year = (int) $current_year + 1;
						$start_month_year = "0" . $start_month . '/' . $current_year;
						$end_month_year = $end_month . '/' . $next_year;
						$start_date = $current_year . "-" . $start_month . "-01";
						$end_date = date('Y-m-d', strtotime("+11 months", strtotime($start_date)));
						$end_month_year = date('m/Y', strtotime($end_date));

						$retotal = $this->calculate_previous_year_retained_amt($filtered_client_id, $report_type, $start_month_year, $end_month_year);
						// echo "retotal = ".$retotal."start_month_year = ".$start_month_year." = end_month_year=".$end_month_year;
						$total_retain_amt += (float) $retotal;
						// exit;
					}
				}
			}
		}

		return $total_retain_amt;
	}








	public function calculate_previous_year_retained_amt($filtered_client_id, $report_type, $start_date, $end_date)
	{

		setlocale(LC_MONETARY, 'en_IN');

		$profit = $grossprofit = $total_sale = $total_costsale = $total_finance_cost = $total_operating_cost = 0;


		$start_date_exp = explode("/", $start_date);
		$end_date_exp = explode("/", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;




		$end_month = '2';
		/*$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
								if($CurrentClientDetails)
								{
									foreach($CurrentClientDetails as $cdetl)
									{
										// $filtered_start_month = $cdetl->financial_month_start;
										// $filtered_end_month = $cdetl->financial_month_end;
										$filtered_client_name = $cdetl->name;
									}
								}*/

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		// $start_fulldate = $start_monthName.' 1, '.$start_year;
		// $end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$end_year;

		// $full_details = [];

		$start_date = date('Y-m-d');




		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));




		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if ($CostDetails) {
			foreach ($CostDetails as $CostDetail) {
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}






		// $total_asset = $total_liabilities = 0;
		// $excel_arrcount = 4;
		// $excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot= array();

		$opening_balancee_data = $this->bankstat_openingbanlance($start_date, $filtered_client_id);
		$ReportDetails_bank = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'status' => 1, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'SUM(IF(amount_type = "sales", amount, 0)) AS salesTotal, SUM(IF(amount_type = "expense", amount, 0)) AS expenseTotal,sum(amount) as total_amount,' . BANKSTATEMENT_COST_CAT_ID . ' as category_id,' . BANKSTATEMENT_COST_SUBCAT_ID . ' as subcategory_id, ' . BANKSTATEMENT_COST_ID . ' as cost_id', array('orderby' => 'report_date', 'disporder' => 'asc', 'custom_where' => '(report_type = "2")'));
		// echo "<pre>";print_r($ReportDetails_bank);echo "</pre>";
		// $subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		$subcat_id_loop = array('other' => array('10', '70'), 'expense' => array('71'));



		foreach ($subcat_id_loop as $sup_key => $subcat_id_arr) {

			// echo "subcat_id_arr = ".$subcat_id_arr;
			// ${"cost_txt_" . $sup_key} = '';

			foreach ($subcat_id_arr as $subcat_id_ar) {

				if ($subcat_id_ar == BANKSTATEMENT_COST_SUBCAT_ID) {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
					//echo $this->db->last_query();
				} else {

					$ReportDetails = $this->reports_model->getDetails('report', array('user_id' => $filtered_client_id, 'cost_id !=' => '', 'status' => 1, 'subcategory_id' => $subcat_id_ar, 'report_date >=' => $start_date, 'report_date <= ' => $end_date), 'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type != "sales" and report_type="2" Then amount When amount_type = "sales" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalCR,Sum(Case When amount_type = "sales" and report_type="2" Then amount When amount_type = "expense" and report_type="3" and ledger_type="2" Then amount Else 0 End) TotalDR,report_type,ledger_type', array('orderby' => 'subcategory_id', 'disporder' => 'asc', 'groupby' => 'cost_id', 'custom_where' => '(report_type="2" OR(report_type="3" AND ledger_type="2"))'));
				}


				//  echo $this->db->last_query();

				$total_amount = 0;
				$childcost = $CostDetails_arr[$subcat_id_ar];
				$child_costname = $childcost->cost_name;

				if ($ReportDetails || $ReportDetails_bank) {


					// $excel_titlearr[] = $excel_arrcount;
					// $excel_arrcount += 2;
					// $excele_tablearr[] = $excel_arrcount;
					// $excel_arrcount += 1;

					$bank_balance = 0;
					if ($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID && !empty($ReportDetails_bank)) {

						$bank_balance += $opening_balancee_data;
						foreach ($ReportDetails_bank as $ReportDetails_b) {
							$salesTotal = $ReportDetails_b->salesTotal;
							$expenseTotal = $ReportDetails_b->expenseTotal;
							$bank_balance = $bank_balance + $salesTotal - $expenseTotal;
							$amount = $bank_balance;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = BANKSTATEMENT_COST_NAME;
							$links = BANKSTATEMENT_COST_LINK;
							$total_amount += (float) $amount;
							$oformat_amount = "R" . number_format((float) $amount, 2);
							$oformat_amount_xl = $amount;
							$unallocated_difference += (float) $amount;
							$cr_amt = '';
							$dr_amount = $amount;
							// ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
							// ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
							// $excel_arrcount++;
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
							$amount = (float) $amount_cr - (float) $amount_dr;
							$amount = number_format((float) $amount, 2, '.', '');
							$cost_name = $links = '';
							if ($cost_id != '') {
								$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
								if ($catcost) {
									foreach ($catcost as $ctcost) {
										$cost_name = $ctcost->cost_name;
										// $links = $ctcost->links;
									}
								}
							}

							if ($subcategory_id == '10') {
								$profit -= (float) $amount;
								$cr_amt = $amount;
								$dr_amount = '';
								$total_sale += (float) $amount;
							} //Sales
							else if ($subcategory_id == '70') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
								$total_costsale += (float) $amount;
							} //Cost of Sales
							else if ($subcategory_id == '71') {
								$profit -= (float) $amount;
								$cr_amt = '';
								$dr_amount = $amount;
							} //Expenses
							if ($subcategory_id == '71' && $cost_name == 'Finance costs') {
								$total_finance_cost += (float) $amount;
							} else if ($subcategory_id == '71') {
								$total_operating_cost += (float) $amount;
							}
						}
					}
				}
			}
		}

		// echo "total_sale = ".$total_sale." = total_costsale = ".$total_costsale;

		$grossprofit = abs((float) $total_sale) - (float) $total_costsale;
		$total_operating_profit = $grossprofit - $total_operating_cost;

		// $ototal_sale  = "R".number_format((float)$total_sale, 2);
		// $ogrossprofit  = "R".number_format((float)$grossprofit, 2);
		// $ototal_costsale  = "R".number_format((float)$total_costsale, 2);
		// $ototal_operating_cost  = "R".number_format((float)$total_operating_cost, 2);
		// $ototal_operating_profit  = "R".number_format((float)$total_operating_profit, 2);
		// $ototal_finance_cost  = "R".number_format((float)$total_finance_cost, 2);
		// $oprofit  = "R".number_format((float)$profit, 2);

		$tax = (((float) $profit * 28) / 100);
		// $otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float) $profit - (float) $tax;
		// $oprofit_tax = "R".number_format((float)$profit_tax, 2);





		return $profit_tax;


		// echo $oprofit_tax;
		exit();
	}

	function financial_report_pdf($freport_id)
	{
		$cover_meta = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'cover'));
		$cover_txt = $cover_meta->meta_value;
		$cover_txt = "<div class='conver_center' style='left: 0;
    line-height: 25px;
    margin-top: -100px;
    position: absolute;
    text-align: center;
    top: 40%;
    width: 100%;'>" . $cover_txt . "</div><div style='position:absolute;bottom:8%;text-align:center;font-weight:bold;left:40%;'><p style='font-size:12px;text-align:center;'>Reviewed Financial Statements</p>
							<p style='font-size:9px;text-align:center;'>in compliance with Companies Act 71 of 2008</p></div>";


		$general_meta = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'general_info'));
		$general_txt = $general_meta->meta_value;

		$general_txt = "<tocentry content='General Information'><div style='font-size: 6pt;'><h3 class='pdf_border_btm'>GENERAL INFORMATION</h3><div class='ginfo_content'>" . $general_txt . "</div></div>";



		$financial_report_data = $this->reports_model->getDetailsRow('financial_report', array('freport_id' => $freport_id));
		$start_date = $financial_report_data->start_date;
		$end_date = $financial_report_data->end_date;
		$client_id = $financial_report_data->client_id;
		$report_type = $financial_report_data->report_type;



		$independent_review_report_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'independent_review_report'));
		// echo "<pre>";print_r($independent_review_report_data);echo "</pre>";exit;
		$indep_txt = $independent_review_report_data->meta_value;
		$indep_txt = "<tocentry  content='Independent Reviewer Report' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm'>INDEPENDENT REVIEWER’S REPORT</h3>" . $indep_txt . "</div>";


		$response_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'response'));
		$response_txt = $response_data->meta_value;
		$response_txt = "<tocentry  content='Director Responsibilities and Approval' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm'>DIRECTOR'S RESPONSIBILITIES AND APPROVAL</h3>" . $response_txt . "</div>";

		$directors_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'directors'));
		$directors_txt = $directors_data->meta_value;
		$directors_txt = "<tocentry  content='Director Report' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm'>DIRECTOR'S REPORT</h3>" . $directors_txt . "</div>";

		$accpolicies_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'accpolicies'));
		$accpolicies_txt = $accpolicies_data->meta_value;
		$accpolicies_txt = "<tocentry  content='Accounting Policies' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm'>ACCOUNTING POLICIES</h3>" . $accpolicies_txt . "</div>";

		$start_date_exp = explode("-", $start_date);
		$end_date_exp = explode("-", $end_date);
		$filtered_start_month = $start_date_exp[0];
		$filtered_end_month = $end_date_exp[0];
		$start_year = $start_date_exp[1];
		$end_year = $end_date_exp[1];
		$inputh_year = $start_year . '-' . $end_year;
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $client_id, 'status' => 1));
		if ($CurrentClientDetails) {
			// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
			foreach ($CurrentClientDetails as $cdetl) {
				$filtered_start_month_cl = $cdetl->financial_month_start;
				$filtered_end_month_cl = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
				$issued_capital = $cdetl->issue_capital;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10));
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName . ' ' . $end_year);
		$end_monthName_date = date('t', $ts);

		$start_fulldate = $start_monthName . ' 1, ' . $start_year;
		$end_fulldate = $end_monthName . ' ' . $end_monthName_date . ', ' . $end_year;


		$start_date = $start_year . "-" . $filtered_start_month . "-01";
		$end_date = $end_year . "-" . $filtered_end_month . "-01";
		$end_date = date('Y-m-t', strtotime($end_date));
		$previous_year = $start_year - 1;
		$previous_start_date = $previous_year . "-" . $filtered_start_month_cl . "-01";
		$previous_end_date = date('Y-m-d', strtotime("+11 months", strtotime($previous_start_date)));
		// $previous_end_date = $start_year."-".$filtered_end_month_cl."-01";
		$previous_end_date = date('Y-m-t', strtotime($previous_end_date));
		$start_day = date('d M Y', strtotime($start_date));

		$end_day = date('t M Y', strtotime($end_date));
		$previous_end_day = date('t M Y', strtotime($previous_end_date));
		$start_month_name = date("F", strtotime($start_date));

		// if($report_type == 1)
		// {
		// 	$balance_data = $this->getFinancialPositionReport(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year));
		// 	$detailedis_data = $this->getDetailedIncomeReport_invoice(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year));
		// 	$inequitydata = $this->getComprehensiveIncomeReport_invoice(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year,'previous_year' => $previous_year,'start_day' => $start_day,'start_month' => $filtered_start_month_cl,'end_month' => $filtered_end_month_cl,'start_month_name' => $start_month_name));
		// }
		// else
		// {
		// 	$balance_data = $this->getFinancialPositionReport_Bk(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year));
		// 	$detailedis_data = $this->getDetailedIncomeReport(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year));
		// 	$inequitydata = $this->getComprehensiveIncomeReport(array('client_id' => $client_id,'report_type' => $report_type, 'start_date' => $start_date,'end_date' => $end_date,'previous_start_date' => $previous_start_date,'previous_end_date' => $previous_end_date,'end_day' => $end_day,'previous_end_day' => $previous_end_day,'filtered_client_name' => $filtered_client_name,'issued_capital' => $issued_capital,'start_year' => $start_year,'previous_year' => $previous_year,'start_day' => $start_day,'start_month' => $filtered_start_month_cl,'end_month' => $filtered_end_month_cl,'start_month_name' => $start_month_name));

		// }


		if ($report_type == 1) {
			$balance_data = $this->getFinancialPositionReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
			$detailedis_data = $this->getDetailedIncomeReport_invoice(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year));
			$inequitydata = $this->getComprehensiveIncomeReport_invoice(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
		} else {
			$balance_data = $this->getFinancialPositionReport_Bk(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
			$detailedis_data = $this->getDetailedIncomeReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year));
			$inequitydata = $this->getComprehensiveIncomeReport(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year, 'start_day' => $start_day, 'start_month' => $filtered_start_month_cl, 'end_month' => $filtered_end_month_cl, 'start_month_name' => $start_month_name));
		}

		// $balance_data = $this->getFinancialPositionReport(array('client_id' => $client_id,'report_type' => 1, 'start_date' => $start_date,'end_date' => $end_date));
		// $balance_data;
		$balance_txt = "<tocentry  content='Statement of Financial Position' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm_tb'>STATEMENT OF FINANCIAL POSITION</h3><div class='fees_pdf'>" . $balance_data . "</div></div>";
		// $balance_txt = 'ssssssssss';

		// $inequitydata = $this->getComprehensiveIncomeReport(array('client_id' => $client_id,'report_type' => 2, 'start_date' => $start_date,'end_date' => $end_date));

		$income_data = $inequitydata['comprehensive'];
		$equity_data = $inequitydata['equity'];

		// $income_data = $this->ajax_comprehensive_income(array('client_id' => $client_id,'report_type' => 2, 'start_date' => $start_date,'end_date' => $end_date));
		$income_txt = "<tocentry  content='Statement of Comprehensive Income' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm_tb'>STATEMENT OF COMPREHENSIVE INCOME</h3><div class='fees_pdf'>" . $income_data . "</div></div>";


		// $detailedis_data = $this->getDetailedIncomeReport(array('client_id' => $client_id,'report_type' => 2, 'start_date' => $start_date,'end_date' => $end_date));
		$detailedis_txt = "<tocentry  content='Supplementary information: Detailed Income Statement' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm_tb'>DETAILED INCOME STATEMENT</h3><div class='fees_pdf'>" . $detailedis_data . "</div></div>";

		$equity_data_txt = "<tocentry  content='Statement of Changes in Equity' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm_tb'>STATEMENT OF CHANGES IN EQUITY</h3><div class='fees_pdf'>" . $equity_data . "</div></div>";

		$cashflow_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'cash_flow'));
		$cashflow_txt = $cashflow_data->meta_value;
		$cmeta_value = unserialize($cashflow_txt);

		$cahsflow_t = '<div class="fees_pdf"><table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th>Figures in R</th><th>' . $end_day . '</th><th>' . $previous_end_day . '</th></tr></thead><tbody>';

		$ccount = 0;
		foreach ($cmeta_value as $key => $val) {
			$ccount++;

			$cahsflow_t .= '<tr><td>' . $val['desc'] . '</td><td>' . $val['ccost'] . '</td><td>' . $val['pcost'] . '</td>
                                                    </tr>';
		}
		$cahsflow_t .= '</tbody></table></div>';
		$cashflow_data_txt = "<tocentry  content='Statement of Cash Flows' /><div style='font-size: 6pt;'><h3 class='pdf_border_btm_tb'>STATEMENT OF CASH FLOWS</h3>" . $cahsflow_t . "</div>";

		$notes_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'notes'));

		$asset_sch_data = $this->getAssetSchedule(array('client_id' => $client_id, 'report_type' => $report_type, 'start_date' => $start_date, 'end_date' => $end_date, 'previous_start_date' => $previous_start_date, 'previous_end_date' => $previous_end_date, 'end_day' => $end_day, 'previous_end_day' => $previous_end_day, 'filtered_client_name' => $filtered_client_name, 'issued_capital' => $issued_capital, 'start_year' => $start_year, 'previous_year' => $previous_year));
		$cur_asset_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'current_asset'));
		$pr_asset_data = $this->reports_model->getDetailsRow('financial_report_meta', array('freport_id' => $freport_id, 'meta_key' => 'previous_asset'));


		// echo "asset_sch_data = ".$asset_sch_data;exit;
		// echo "<pre>";print_r($notes_data);echo "</pre>";
		$notes_txt = $notes_data->meta_value;
		$cur_asset_txt = $cur_asset_data->meta_value;
		$pr_asset_txt = $pr_asset_data->meta_value;

		$ca_value = unserialize($cur_asset_txt);

		$ca_t = '<div class="fees_pdf"><table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead> <tr><th></th><th>NBV</th><th>Additions</th><th>Disposals</th><th>Depreciation</th><th>' . $end_day . '<br> Carrying value at <br>beginning of year</th></tr></thead><tbody>';

		$ccount = 0;
		foreach ($ca_value as $key => $val) {
			$ccount++;

			$ca_t .= '<tr><td>' . $val['desc'] . '</td><td style="text-align:right;">' . $val['nbv'] . '</td><td style="text-align:right;">' . $val['addit'] . '</td><td style="text-align:right;">' . $val['disp'] . '</td><td style="text-align:right;">' . $val['depr'] . '</td><td style="text-align:right;">' . $val['cyear_nbv'] . '</td>
                                                    </tr>';
		}
		$ca_t .= '</tbody></table></div>';

		$pa_value = unserialize($pr_asset_txt);

		$pa_t = '<div class="fees_pdf"><table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th></th><th>NBV</th><th>Additions</th><th>Disposals</th><th>Depreciation</th><th>' . $previous_end_day . ' <br>Carrying value at <br>beginning of year</th></tr></thead><tbody>';

		$ccount = 0;
		foreach ($pa_value as $key => $val) {
			$ccount++;

			$pa_t .= '<tr><td>' . $val['desc'] . '</td><td style="text-align:right;">' . $val['nbv'] . '</td><td style="text-align:right;">' . $val['addit'] . '</td><td style="text-align:right;">' . $val['disp'] . '</td><td style="text-align:right;">' . $val['depr'] . '</td><td style="text-align:right;">' . $val['cyear_nbv'] . '</td>
                                                    </tr>';
		}
		$pa_t .= '</tbody></table></div>';
		$notes_data_txt = "<tocentry  content='Notes to the Financial Statements' /><div style='font-size: 6pt;'><h3>NOTES TO THE FINANCIAL STATEMENTS</h3><table class='table table-striped table-hover stl_costtbl stl_pdftb'><thead><tr><th>Figures in R</th><th> 30 November 2022</th></tr></thead></table><p><b>3. Property, plant and equipment</b></p>" . $asset_sch_data . "<p>The carrying amounts of property, plant and equipment can be reconciled as follows:</p>" . $ca_t . $pa_t . $notes_txt . "</div>";
		return array('no_header' => array($cover_txt), 'header' => array($general_txt, $indep_txt, $response_txt, $directors_txt, $balance_txt, $income_txt, $equity_data_txt, $cashflow_data_txt, $accpolicies_txt, $notes_data_txt, $detailedis_txt));


		// return array('no_header' => array($cover_txt),'header' => array($general_txt,$indep_txt));
		// return $pdf_txt_start;




	}
	function ajax_create_report()
	{
		$report_from = $_POST['report_from'];
		$report_to = $_POST['report_to'];
		$client_id = $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $register_no = $_POST['register_no'];
		$filtered_client_name = '';
		$financial_report_checked = $this->reports_model->getDetailsRow('financial_report', array('client_id' => $client_id, 'start_date' => $report_from, 'end_date' => $report_to, 'report_type' => $report_type));
		// echo "<pre>";print_r($financial_report_checked);echo "</pre>";

		if (!empty($financial_report_checked)) {
			$freport_id = $financial_report_checked->freport_id;
		} else {
			$freport_id = $this->reports_model->Insert('financial_report', array('client_id' => $client_id, 'start_date' => $report_from, 'end_date' => $report_to, 'status' => 1, 'report_type' => $report_type));

			$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $client_id, 'status' => 1));
			// echo "<pre>";print_r($getDetailsRow);echo "</pre>";exit;
			if ($CurrentClientDetails) {
				foreach ($CurrentClientDetails as $cdetl) {
					$filtered_client_name = $cdetl->name;
					$register_no = $cdetl->register_no;
					$trading_name = $cdetl->trading_name;
					$address1 = $cdetl->address1;
					$address2 = $cdetl->address2;
					$zip_code = $cdetl->zip_code;
				}
			}
			$address = $address1 . "<br>" . $address2 . "<br>" . $zip_code . "<br>";
			$month_diff_arr = $this->findMonthDifference($report_from, $report_to);

			// echo "<pre>";print_r($month_diff_arr);echo "</pre>";exit;

			if ($month_diff_arr['month_diff'] > 0 && $month_diff_arr['month_diff'] < 12)
				$cheader_txt = '<p style="text-align: center;">Financial Statements</p><p style="text-align: center;">for the ' . $month_diff_arr['month_diff'] . ' month period ended ' . $month_diff_arr['end_date'] . '</p>';
			else
				$cheader_txt = '<p style="text-align: center;">Annual Financial Statements </p>';

			$freport_id = $freport_id;
			$cover_txt = '<p style="text-align: center;"><span style="font-weight: 700;">' . $trading_name . '</span></p><p style="text-align: center;">Trading as</p><p style="text-align: center;">' . $filtered_client_name . '</p><p style="text-align: center;">(Registration Number ' . $register_no . ')</p>' . $cheader_txt;
			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $cover_txt, 'meta_key' => 'cover'));


			$general_info_txt = '<table class="table"><tbody><tr><td>COUNTRY OF INCORPORATION AND DOMICILE&nbsp;</td><td>South Africa</td></tr><tr><td>NATURE OF BUSINESS AND PRINCIPAL ACTIVITIES&nbsp;</td><td></td></tr><tr><td>DIRECTOR</td><td></td></tr><tr><td>REGISTERED OFFICE&nbsp;</td><td>' . $address . '</td></tr><tr><td>BUSINESS ADDRESS&nbsp;</td><td>' . $address . '<br></td></tr><tr><td>BANKERS</td><td></td></tr><tr><td>INDEPENDENT REVIEWERS</td><td></td></tr></tbody></table><br>';

			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $general_info_txt, 'meta_key' => 'general_info'));

			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => '', 'meta_key' => 'independent_review_report'));


			$response_txt = "<p>The director is required by the South African Companies Act to maintain adequate accounting records and is responsible for the content and integrity of the financial statements and related financial information included in this report. It is his responsibility to ensure that the financial statements satisfy the financial reporting standards as to form and content and present fairly the statement of financial position, results of operations and business of the company, and explain the transactions and financial position of the business of the company at the end of the 11 month period. The financial statements are based upon appropriate accounting policies consistently applied throughout the company and supported by reasonable and prudent judgements and estimates.</p><p>The director acknowledges that he is ultimately responsible for the system of internal financial control established by the company and places considerable importance on maintaining a strong control environment. To enable the director to meet these responsibilities, he sets standards for internal control aimed at reducing the risk of error or loss in a cost effective manner. The standards include the proper delegation of responsibilities within a clearly defined framework, effective accounting procedures and adequate segregation of duties to ensure an acceptable level of risk. These controls are monitored throughout the company and all employees are required to maintain the highest ethical standards in ensuring the company's business is conducted in a manner that in all reasonable circumstances is above reproach.</p><p>The focus of risk management in the company is on identifying, assessing, managing and monitoring all known forms of risk across the company. While operating risk cannot be fully eliminated, the company endeavours to minimise it by ensuring that appropriate infrastructure, controls, systems and ethical behaviour are applied and managed within predetermined procedures and constraints.</p><p>The director is of the opinion, based on the information and explanations given by management that the system of internal control provides reasonable assurance that the financial records may be relied on for the preparation of the financial statements. However, any system of internal financial control can provide only reasonable, and not absolute, assurance against material misstatement or loss. The going-concern basis has been adopted in preparing the financial statements. Based on forecasts and available cash resources the director has no reason to believe that the company will not be a going concern in the foreseeable future. The financial statements support the viability of the company.</p><p>The independent reviewers are responsible for independently reviewing and reporting on the company's financial statements. The independent reviewer's report is presented on page 3.</p><p>The financial statements as set out on pages 6 to 14 were approved by the director on 28 January 2022 and were signed by him.</p><p><br></p><p>-----------------------------------------------------------</p><p>Jack A Zebediela</p>";

			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $response_txt, 'meta_key' => 'response'));

			$directors_txt = '<p>The director presents his report for the ' . $month_diff_arr['month_diff'] . ' month period ended ' . $month_diff_arr['end_date'] . '.</p><p><strong>1. Review of activities</strong></p><p><strong>Main business and operations</strong></p><p>The principal activity of the company is legal Practice and there were no major changes herein during the year.</p><p>The operating results and statement of financial position of the company are fully set out in the attached financial statements</p><p>and do not in my opinion require any further comment.</p><p><strong>2. Borrowing limitations</strong></p><p>In terms of the Memorandum of Incorporation of the company, the director may exercise all the powers of the company to</p><p>borrow money, as he considers appropriate.</p><p><strong>3. Director</strong></p><p>The director of the company during the period and to the date of this report is as follows:</p><p>Name</p><p>Jack A Zebediela</p><p><strong>4. Shareholder</strong></p><p>There has been no changes in ownership and the shareholder remains:</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; %</p><p>Jack Zebediela&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 100.00</p><p><br></p>';

			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $directors_txt, 'meta_key' => 'directors'));

			$accpolicies_txt = "<p><strong>1. General information</strong></p><p>Tshiqi Zebediela Incorporated is a private company incorporated in South Africa.</p><p><strong>2. Summary of significant accounting policies</strong></p><p>These financial statements have been prepared in accordance with the International Financial Reporting Standards for Small</p><p>and Medium-sized Entities issued by the International Accounting Standards Board and the requirements of the Companies Act</p><p>of South Africa. The principal accounting policies applied in the preparation of these financial statements are set out below.</p><p>These policies have been consistently applied to all the years presented, unless otherwise stated.</p><p>These financial statements have been prepared under the historical cost convention and are presented in South African Rands.</p><p><strong>2.1 Revenue recognition</strong></p><p>Revenue comprises the fair value of the consideration received or receivable for the sale of goods and/or services in the</p><p>ordinary course of the company's activities. Revenue is shown net of value-added tax, returns, and discounts.</p><p>The company recognises revenue when: the amount of revenue can be reliably measured; it is probable that future economic</p><p>benefits will flow to the entity; and specific criteria have been met for each of the company's activities, as described below:</p><p>Services revenue</p><p>The service rendered is recognised as revenue by reference to the stage of completion of the transaction at the reporting date.</p><p><strong>2.2 Income tax</strong></p><p>The tax expense for the period comprises current and deferred tax. Tax is recognised in profit or loss, except that a change</p><p>attributable to an item of income or expense recognised as other comprehensive income is also recognised directly in other</p><p>comprehensive income.</p><p>The current income tax charge is calculated on the basis of tax rates and laws that have been enacted or substantively enacted</p><p>by the reporting date.</p><p>Deferred tax is recognised on differences between the carrying amounts of assets and liabilities in the financial statements and</p><p>their corresponding tax bases (known as temporary differences). Deferred tax liabilities are recognised for all temporary</p><p>differences that are expected to increase taxable profit in the future. Deferred tax assets are recognised for all temporary</p><p>differences that are expected to reduce taxable profit in the future, and any unused tax losses or unused tax credits. Deferred</p><p>tax assets are measured at the highest amount that, on the basis of current or estimated future taxable profit, is more likely</p><p>than not to be recovered.</p><p>The net carrying amount of deferred tax assets is reviewed at each reporting date and is adjusted to reflect the current</p><p>assessment of future taxable profits. Any adjustments are recognised in profit or loss.</p><p>Deferred taxation is calculated at the tax rates that are expected to apply to the taxable profit (tax loss) of the periods in which</p><p>it expects the deferred taxation asset to be realised or the deferred taxation liability to be settled, on the basis of tax rates that</p><p>have been enacted or substantively enacted by the end of the reporting period.</p><p><strong>2.3 Property, plant and equipment</strong></p><p>Items of property, plant and equipment are measured at cost less accumulated depreciation and any accumulated impairment</p><p>losses.</p><p>Costs include costs incurred initially to acquire or construct an item of property, plant and equipment and costs incurred</p><p>subsequently to add to, replace part of, or service it. If a replacement cost is recognised in the carrying amount of an item of</p><p>property, plant and equipment, the carrying amount of the replaced part is derecognised.</p><p>The residual value, depreciation method and useful life of each asset are reviewed at each annual reporting period if there are</p><p>indicators present that there has been significant change from the previous estimates.</p><p>Depreciation is charged so as to allocate the cost of assets less their residual values over their estimated useful lives, using the</p><p>straight-line method. The following rates are used for the depreciation of property, plant and equipment:</p><p>Motor vehicles 20.00%</p><p>Furniture and fittings 20.00%</p><p>Office equipment 20.00%</p><p>Library Assets 20.00%</p><p><strong>2.4 Trade and other receivables</strong></p><p>Trade receivables are recognised initially at the transaction price. They are subsequently measured at amortised cost using the</p><p>effective interest rate method, less provision for impairment. A provision for impairment of trade receivables is established</p><p>when there is objective evidence that the company will not be able to collect all amounts due according to the original terms of</p><p>the receivables.</p><p><strong>2.5 Cash and cash equivalents</strong></p><p>Cash and cash equivalents includes cash on hand, demand deposits and other short-term highly liquid investments with original</p><p>maturities of three months or less. Bank overdrafts are shown under current liabilities on the statement of financial position.</p><p><strong>2.6 Share capital</strong></p><p>Ordinary shares are classified as equity.</p><p>Equity instruments are measured at the fair value of the cash or other resources received or receivable, net of the direct costs</p><p>of issuing the equity instruments. If payment is deferred and the time value of money is material, the initial measurement is on</p><p>a present value basis.</p><p><strong>2.7 Borrowings</strong></p><p>Borrowings are recognised initially at the transaction price (that is, the present value of cash payable to the bank, including</p><p>transaction costs). Borrowings are subsequently stated at amortised cost. Interest expense is recognised on the basis of the</p><p>effective interest rate method and is included in finance costs.</p><p>Borrowings are classified as current liabilities unless the company has an unconditional right to defer settlement of the liability</p><p>for at least 12 months after the reporting date.</p><p><strong>2.8 Trade payables</strong></p><p>Trade payables are recognised initially at the transaction price and subsequently measured at amortised cost using the</p><p>effective interest rate method.</p><p><strong>2.9 Borrowing costs</strong></p><p>Borrowing costs are recognised on the basis of the effective interest rate method and is included in finance costs</p>";

			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $accpolicies_txt, 'meta_key' => 'accpolicies'));


			$cash_flow_arr = array(
				array('desc' => 'Cash flows from operating activities', 'ccost' => '', 'pcost' => ''),
				array('desc' => 'Profit for the period', 'ccost' => '', 'pcost' => ''),
				array('desc' => 'Adjustments for:', 'ccost' => '', 'pcost' => ''),
				array('desc' => 'Finance costs', 'ccost' => '', 'pcost' => ''),
				array('desc' => 'Income tax', 'ccost' => '', 'pcost' => '')
			);
			$cash_flow_txt = serialize($cash_flow_arr);
			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $cash_flow_txt, 'meta_key' => 'cash_flow'));

			$casset_arr = array(
				array('desc' => '', 'nbv' => '', 'addit' => '', 'disp' => '', 'depr' => '', 'cyear_nbv' => '')
			);
			$casset_txt = serialize($casset_arr);
			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $casset_txt, 'meta_key' => 'current_asset'));

			$passet_arr = array(
				array('desc' => '', 'nbv' => '', 'addit' => '', 'disp' => '', 'depr' => '', 'cyear_nbv' => '')
			);
			$passet_txt = serialize($passet_arr);
			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $passet_txt, 'meta_key' => 'previous_asset'));



			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => '', 'meta_key' => 'notes'));
		}
		// echo "insert_status = ".$insert_status;
		echo json_encode(array('insert_status' => $freport_id));
	}
	/*function ajax_save_cover(){
					$freport_id = $_POST['freport_id'];
					$cover_txt = $_POST['cover_txt'];
					$rid = $_POST['rid'];
					$insert_status = $this->financial_report_savefn($rid,$freport_id,$cover_txt,'cover');
					
					echo json_encode(array('insert_status' => $insert_status));
				}
				function ajax_save_general_info(){
					$freport_id = $_POST['freport_id'];
					$general_info_txt = $_POST['general_info_txt'];
					$rid = $_POST['rid'];
					$insert_status = $this->financial_report_savefn($rid,$freport_id,$general_info_txt,'general_info');
					echo json_encode(array('insert_status' => $insert_status));
				}*/
	function ajax_save_financial_report()
	{
		$freport_id = $_POST['freport_id'];
		$info_txt = $_POST['info_txt'];
		$rid = $_POST['rid'];

		$insert_status = $this->financial_report_savefn($rid, $freport_id, $info_txt, $_POST['meta_key']);
		echo json_encode(array('insert_status' => $insert_status));
	}

	public function financial_report_savefn($rid = '', $freport_id = '', $meta_value = '', $meta_key = '')
	{
		if ($rid != '')
			$insert_status = $this->reports_model->Update('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $meta_value, 'meta_key' => $meta_key), array('id' => $rid));
		else
			$insert_status = $this->reports_model->Insert('financial_report_meta', array('freport_id' => $freport_id, 'meta_value' => $meta_value, 'meta_key' => $meta_key));
		return $insert_status;
	}
	public function ajax_save_cash_flow()
	{
		$cash_flow_txt = serialize($_POST['cashflow']);

		$insert_status = $this->reports_model->Update('financial_report_meta', array('freport_id' => $_POST['cfreport_id'], 'meta_value' => $cash_flow_txt, 'meta_key' => 'cash_flow'), array('id' => $_POST['rid']));
		echo json_encode(array('insert_status' => $insert_status));
	}
	public function ajax_save_current_asset()
	{
		$cur_asset_txt = serialize($_POST['cur_asset']);

		$insert_status = $this->reports_model->Update('financial_report_meta', array('freport_id' => $_POST['cfreport_id'], 'meta_value' => $cur_asset_txt, 'meta_key' => 'current_asset'), array('id' => $_POST['rid']));
		echo json_encode(array('insert_status' => $insert_status));
	}
	public function ajax_save_previous_asset()
	{
		$pr_asset_txt = serialize($_POST['pr_asset']);

		$insert_status = $this->reports_model->Update('financial_report_meta', array('freport_id' => $_POST['cfreport_id'], 'meta_value' => $pr_asset_txt, 'meta_key' => 'previous_asset'), array('id' => $_POST['rid']));
		echo json_encode(array('insert_status' => $insert_status));
	}


	public function ajax_save_notes()
	{
		$notes_txt = serialize($_POST['notes']);

		$insert_status = $this->reports_model->Update('financial_report_meta', array('freport_id' => $_POST['cfreport_id'], 'meta_value' => $notes_txt, 'meta_key' => 'notes'), array('id' => $_POST['rid']));
		echo json_encode(array('insert_status' => $insert_status));
	}
	public function getAssetSchedule($post_data = array())
	{
		// echo "<pre>";print_r($post_data);echo "</pre>";
		$client_id = $post_data['client_id'];
		$start_date = $post_data['start_date'];
		$end_date = $post_data['end_date'];
		// $year = $post_data['year'];
		$report_type = $post_data['report_type'];
		$start_year = $post_data['start_year'];
		$previous_year = $post_data['previous_year'];
		$end_day = $post_data['end_day'];
		$previous_end_day = $post_data['previous_end_day'];

		$AssetDetails = $this->reports_model->get_asset_register_current_data($client_id, $start_date, $end_date, $report_type);
		// echo $this->db->last_query();
		// echo "<pre>";print_r($AssetDetails);echo "</pre>";

		$asset_arr = '<table class="table table-striped table-hover stl_costtbl stl_pdftb"><thead><tr><th></th><th style="text-align:right">Cost</th><th style="text-align:right">Accum Deprec</th><th style="text-align:right">' . $end_day . ' <br>NBV</th><th style="text-align:right">Cost</th><th style="text-align:right">Accum Deprec</th><th style="text-align:right">' . $previous_end_day . ' <br>NBV</th></tr></thead><tbody>';

		$i = $cumdep = $nbv = $item_total_cost = $item_total_dep = $item_total_nbv = $item_total_cumdep = 0;
		$overall_cost = $overall_dep = $overall_cumdep = $overall_nbv = 0;
		$old_cost_name = $cost_name = $old_cost_id = '';
		foreach ($AssetDetails as $AssetDetail) {

			$cost_id = $AssetDetail->cost_id;
			$cost_name = $AssetDetail->cost_name;
			$dep_per = $AssetDetail->dep_per;
			if ($old_cost_name == '') {
				$old_cost_name = $cost_name;
				$old_cost_id = $cost_id;
				$total_cost_name = $cost_name;
			}
			if ($old_cost_name != $cost_name) {
				$old_cost_name = $cost_name;
				// echo "old_cost_id = ".$old_cost_id;
				$previous_val = $this->getPreviousAssetCostValue($post_data, $old_cost_id);

				$item_total_cumdep += (float) $previous_val['item_total_cumdep'];
				// $item_total_nbv = (float)$item_total_cost - (float)$previous_val['item_total_cumdep'];
				$oitem_total_cost = number_format((float) $item_total_cost, 2);
				// $oitem_total_dep = number_format((float)$item_total_dep, 2);
				$oitem_total_cumdep = number_format((float) $item_total_cumdep, 2);


				// echo "<pre>";print_r($previous_val);echo "</pre>";exit;
				$opitem_total_cost = number_format((float) $previous_val['item_total_cost'], 2);
				$opitem_total_cumdep = number_format((float) $previous_val['item_total_cumdep'], 2);
				$opitem_total_nbv = number_format((float) $previous_val['item_total_nbv'], 2);
				$current_year_tcost = (float) $item_total_cost + (float) $previous_val['item_total_cost'];
				$ocurrent_year_tcost = number_format((float) $current_year_tcost, 2);
				$item_total_nbv = (float) $current_year_tcost - (float) $item_total_cumdep;
				$oitem_total_nbv = number_format((float) $item_total_nbv, 2);

				$asset_arr .= "<tr><td style='text-align:center;'>" . $total_cost_name . "</td><td style='text-align:right;'>R" . $ocurrent_year_tcost . "</td><td style='text-align:right;'>R" . $oitem_total_cumdep . "</td><td style='text-align:right;'>R" . $oitem_total_nbv . "</td><td style='text-align:right;'>R" . $opitem_total_cost . "</td><td style='text-align:right;'>R" . $opitem_total_cumdep . "</td><td style='text-align:right;'>R" . $opitem_total_nbv . "</td></tr>";
				$i = $cumdep = $nbv = $item_total_dep = $item_total_cost = $item_total_nbv = $item_total_cumdep = 0;

				$total_cost_name = $cost_name;
				$old_cost_id = $cost_id;


				// $asset_arr .= '</tbody></table><table class="table table-striped table-hover table-bordered1 stl_table "><thead><tr><td>S.no</td><td>Assets name</td><td>Report date</td><td>Cost</td><td>Dep</td><td>Cum Dep</td><td>NBV</td></tr></thead><tbody>';
			}
			$i++;
			$amt = $AssetDetail->amount;

			$amt = (float) $amt;
			$item_total_cost += $amt;
			if ($dep_per > 0)
				$dep_per_val = (int) $dep_per / 100;
			else
				$dep_per_val = 0.2;
			// $cost_name = $CostDetails_arr[$cost_id]->cost_name;
			// $depre= $amt*(0.2/365);
			$report_date = $AssetDetail->report_date;
			$report_date = date('Y-m-d', strtotime($report_date));
			$current_date = date('Y-m-d');
			// echo "current_date = ".$current_date;
			$diff = $this->dateDiffInDays($report_date, $current_date);


			// $cost_name = $CostDetails_arr[$cost_id]->cost_name;
			// $depre= $amt*(0.2/365);
			if ($cost_name != 'Land and Building') {
				$depre = $amt * ($dep_per_val / 365);
				$cumdep = $depre * $diff;
			} else {
				$depre = 0;
				$cumdep = 0;
			}
			// $cost_name = $CostDetails_arr[$cost_id]->cost_name;
			// if($cost_name !='Land and Building')
			// 	$depre= $amt*(0.2/365);
			// else
			// 	$depre = $amt;
			// $item_total_dep += $depre;
			// $cumdep += $depre;
			$nbv = $amt - $cumdep;
			$item_total_nbv += $nbv;
			$item_total_cumdep += $cumdep;
			// $overall_cost += $amt;
			// $overall_dep += $depre;
			// $overall_cumdep += $cumdep;
			// $overall_nbv += $nbv;

			$onbv = number_format((float) $nbv, 2);
			$ocumdep = number_format((float) $cumdep, 2);
			$odepre = number_format((float) $depre, 2);
			$oamt = number_format((float) $amt, 2);
		}
		$previous_val = $this->getPreviousAssetCostValue($post_data, $old_cost_id);

		$item_total_cumdep += (float) $previous_val['item_total_cumdep'];
		// $item_total_nbv = (float)$item_total_nbv - (float)$previous_val['item_total_cumdep'];

		$oitem_total_cost = number_format((float) $item_total_cost, 2);
		// $oitem_total_dep = number_format((float)$item_total_dep, 2);
		$oitem_total_cumdep = number_format((float) $item_total_cumdep, 2);
		// $oitem_total_nbv = number_format((float)$item_total_nbv, 2);

		// $previous_val = $this->getPreviousAssetCostValue($post_data,$cost_id);
		// echo "<pre>";print_r($previous_val);echo "</pre>";exit;
		$opitem_total_cost = number_format((float) $previous_val['item_total_cost'], 2);
		$opitem_total_cumdep = number_format((float) $previous_val['item_total_cumdep'], 2);
		$opitem_total_nbv = number_format((float) $previous_val['item_total_nbv'], 2);

		$current_year_tcost = (float) $item_total_cost + (float) $previous_val['item_total_cost'];
		$ocurrent_year_tcost = number_format((float) $current_year_tcost, 2);
		$item_total_nbv = (float) $current_year_tcost - (float) $item_total_cumdep;
		$oitem_total_nbv = number_format((float) $item_total_nbv, 2);

		$asset_arr .= "<tr><td style='text-align:center;'>" . $cost_name . "</td><td style='text-align:right;'>R" . $current_year_tcost . "</td><td style='text-align:right;'>R" . $oitem_total_cumdep . "</td><td style='text-align:right;'>R" . $oitem_total_nbv . "</td><td style='text-align:right;'>R" . $opitem_total_cost . "</td><td style='text-align:right;'>R" . $opitem_total_cumdep . "</td><td style='text-align:right;'>R" . $opitem_total_nbv . "</td></tr></tbody></table>";


		// $ooverall_cost = number_format((float)$overall_cost, 2);
		// $ooverall_dep = number_format((float)$overall_dep, 2);
		// $ooverall_cumdep = number_format((float)$overall_cumdep, 2);
		// $ooverall_nbv = number_format((float)$overall_nbv, 2);

		return $asset_arr;
	}
	public function getPreviousAssetCostValue($post_data = array(), $cost_id = '')
	{
		$client_id = $post_data['client_id'];
		$start_date = $post_data['previous_start_date'];
		$end_date = $post_data['previous_end_date'];
		// $year = $post_data['year'];
		$report_type = $post_data['report_type'];

		$AssetDetails = $this->reports_model->get_asset_register_previous_data($client_id, $start_date, $end_date, $report_type, $cost_id);
		// echo $this->db->last_query();	

		$i = $cumdep = $nbv = $item_total_cost = $item_total_dep = $item_total_nbv = $item_total_cumdep = 0;

		$old_cost_name = '';
		foreach ($AssetDetails as $AssetDetail) {

			$cost_id = $AssetDetail->cost_id;
			$cost_name = $AssetDetail->cost_name;

			$i++;
			$amt = $AssetDetail->amount;
			$dep_per = $AssetDetail->dep_per;
			$report_date = $AssetDetail->report_date;
			$current_date = date('Y-m-d');
			$report_date = date('Y-m-d', strtotime($report_date));
			// echo "current_date = ".$current_date;
			$diff = $this->dateDiffInDays($report_date, $current_date);

			$amt = (float) $amt;
			$item_total_cost += $amt;
			if ($dep_per > 0)
				$dep_per_val = (int) $dep_per / 100;
			else
				$dep_per_val = 0.2;
			// $cost_name = $CostDetails_arr[$cost_id]->cost_name;
			// $depre= $amt*(0.2/365);
			if ($cost_name != 'Land and Building') {
				$depre = $amt * ($dep_per_val / 365);
				$cumdep = $depre * $diff;
			} else {
				$depre = 0;
				$cumdep = 0;
			}
			// $cost_name = $CostDetails_arr[$cost_id]->cost_name;

			// $item_total_dep += $depre;
			// $cumdep += $depre;
			$nbv = $amt - $cumdep;
			$item_total_nbv += $nbv;
			$item_total_cumdep += $cumdep;


			// $onbv = number_format((float)$nbv, 2);
			// $ocumdep = number_format((float)$cumdep, 2);
			// $odepre = number_format((float)$depre, 2);
			// $oamt = number_format((float)$amt, 2);

		}
		// $oitem_total_cost = number_format((float)$item_total_cost, 2);
		// $oitem_total_dep = number_format((float)$item_total_dep, 2);
		// $oitem_total_cumdep = number_format((float)$item_total_cumdep, 2);
		// $oitem_total_nbv = number_format((float)$item_total_nbv, 2);

		// $asset_arr .= "<tr><th style='text-align:center;'>".$cost_name."</th><th>R".$oitem_total_cost."</th><th>R".$oitem_total_cumdep."</th><th>R".$oitem_total_nbv."</th></tr>";
		return array('item_total_cost' => $item_total_cost, 'item_total_cumdep' => $item_total_cumdep, 'item_total_nbv' => $item_total_nbv);

		// return $asset_arr;

	}
}