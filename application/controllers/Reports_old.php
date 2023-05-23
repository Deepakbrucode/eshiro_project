<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		$this->load->model('reports_model');
		$this->load->model('costcentre_model');
		$this->load->model('client_model');

		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
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
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $fclient_id,'status' => 1,'report_type' => 1));
			}
			else
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 1));
			}
			//$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1));
			$ClientDetails = $this->client_model->getClientDetails();	
		}
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 1));
		}
		
		$data = array(
					'view_file'=>'show_report',
					'current_menu'=>'report',
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

	public function investigation_data(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;

		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';

		//$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		

		/*$ParentCost = $this->costcentre_model->getDetails(array('parent_cost' => ''));	

		$parent_childcost = array();
		if($ParentCost)
		{
			foreach($ParentCost as $Parentct)
			{
				$cost_id = $Parentct->cost_id;
				$ChildCost = $this->costcentre_model->getDetails(array('parent_cost' => $cost_id));	
				$parent_childcost[$cost_id] = $ChildCost;
			}
		}*/

		if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 2,'user_id' => $client_id),'',array('custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			else
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('status' => 2,'user_id' => $fclient_id),'',array('custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
			}
			
		}
			
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 2),'',array('custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
			$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		}
		
		$data = array(
					'view_file'=>'investigation_data',
					'current_menu'=>'investigation_data',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
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
	public function analysis_data(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;

		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$month = (isset($_GET['month']))?$_GET['month']:date('m');
		$year = (isset($_GET['year']))?$_GET['year']:date('Y');

		//$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{
			$ClientDetails = $this->client_model->getClientDetails();	
		}


		// if($usertype == '5')
		// {
		// 	if($fclient_id == '')
		// 	{
		// 		$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $client_id,'report_type' => 1));
		// 		$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		// 	}
		// 	else
		// 	{
		// 		$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $fclient_id,'report_type' => 1));
		// 		$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $fclient_id));
		// 	}
			
		// }
			
		// else
		// {
		// 	$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 1));
		// 	$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		// }
		$final_client_id = $client_id;
		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				
				$final_client_id = $fclient_id;
				
			}
			
		}
//month(report_date)='".$month."' and year(report_date)='".$year."'
		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $final_client_id,'status' => 1,'month(report_date)' => $month,'year(report_date)' => $year,'amount_type' => 'expense'),'',array('custom_where' => '(report_type="1" or report_type = "7")'));



		// $sql=$this->db->query("
		//  	SELECT report_id,cost_id,report_date,inv_no,ref_no,description,amount,'manual',status,amount_type,tax_type,category_id,subcategory_id FROM `report` WHERE `user_id` = '".$final_client_id."' AND `status` = 1 AND `report_type` = 1 AND month(report_date) = '".$month."' AND year(report_date) = '".$year."' AND `amount_type` = 'expense' UNION all 
		//  	SELECT invoice_id,cost_id,invoice_date,inv_no,ref_no,'test',final_price,'invoice',status,amount_type,tax_type,category_id,subcategory_id FROM `invoicing_data` WHERE `user_id` = '".$final_client_id."' AND `status` = 1 AND `invoice_type` = 3 AND month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' AND `amount_type` = 'expense'");

		// $ReportDetails = $sql->result();
		// echo $this->db->last_query();
		$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $final_client_id));
		
		$data = array(
					'view_file'=>'analysis_data',
					'current_menu'=>'analysis_data',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
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
	
	public function analysis_data_month(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;

		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';

		//$fclient_id = '';
		$ClientDetails = array();
		$final_client_id = $client_id;
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				
				$final_client_id = $fclient_id;
				
			}
			
		}
			
//SELECT YEAR(report_date), MONTH(report_date) FROM `report` where user_id='27' and report_type='2' GROUP BY MONTH(report_date), YEAR(report_date) order by YEAR(report_date),MONTH(report_date) asc

		

		$ReportDetails_month = $this->reports_model->getDetails('report',array('user_id' => $final_client_id,'status' => 1,'amount_type'=>'expense'),'YEAR(report_date) as year_val, MONTH(report_date) as month_val',array('orderby' => 'YEAR(report_date),MONTH(report_date)','disporder' => 'asc', 'groupby' => 'MONTH(report_date), YEAR(report_date)','custom_where' => '(report_type="1" or report_type = "7")'));
		// echo $this->db->last_query();
		// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $final_client_id));

		$data = array(
					'view_file'=>'analysis_data_month',
					'current_menu'=>'analysis_data_month',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'ReportDetails_month' => $ReportDetails_month,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'final_client_id' => $final_client_id,
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
	public function add_report(){
		
		//$cost_types = $this->costcentre_model->getDetails(array('status' => 1));
		$ClientDetails = $this->client_model->getClientDetails();
		$usertype= $this->session->usertype;
		$ReportDetail ='';
		//echo "<pre>";print_r($this->session);echo "</pre>";
		$filtered_client_id= $this->session->id;
		//$CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $filtered_client_id));

		// $ParentCost = $this->costcentre_model->getDetails(array('parent_cost' => ''));	

		// $parent_childcost = array();
		// if($ParentCost)
		// {
		// 	foreach($ParentCost as $Parentct)
		// 	{
		// 		$cost_id = $Parentct->cost_id;
		// 		$ChildCost = $this->costcentre_model->getDetails(array('parent_cost' => $cost_id));	
		// 		$parent_childcost[$cost_id] = $ChildCost;
		// 	}
		// }


		$data = array(
					'view_file'=>'add_report',
					'current_menu'=>'add_report',
					'cusotm_field'=>'add_report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Add',
					'form_action' => 'save_report',
					'user_id' => $filtered_client_id,
					'ReportDetail' => $ReportDetail,
					//'cost_types' => $cost_types,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
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
	public function edit_report($report_id = ''){	
		//echo "<pre>";print_r($this->session);echo "</pre>";
		//$cost_types = $this->costcentre_model->getDetails(array('status' => 1));
		$filtered_client_id= $this->session->id;
		$ReportDetail = '';
		if($report_id !='' )
		$ReportDetail = $this->reports_model->getDetails('report',array('report_id' => $report_id));	
		
		$ClientDetails = $this->client_model->getClientDetails();
		$usertype= $this->session->usertype;


		// $ParentCost = $this->costcentre_model->getDetails(array('parent_cost' => ''));	

		// $parent_childcost = array();
		// if($ParentCost)
		// {
		// 	foreach($ParentCost as $Parentct)
		// 	{
		// 		$cost_id = $Parentct->cost_id;
		// 		$ChildCost = $this->costcentre_model->getDetails(array('parent_cost' => $cost_id));	
		// 		$parent_childcost[$cost_id] = $ChildCost;
		// 	}
		// }

		//echo $this->db->last_query();
		//echo "<pre>";print_r($ReportDetail);echo "</pre>";
		$data = array(
					'view_file'=>'add_report',
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
	public function save_report(){
		//echo "<pre>";print_r($_POST);echo "</pre>";
		$user_id = $_POST['user_id'];
		//exit;
		$report_id = $_POST['report_id'];
		//$report_name = $_POST['report_name'];
		$report_date = $_POST['report_date'];
		if($report_date !='')
		{
			$report_date1 = explode('/',$report_date);
			$report_date = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}
		// echo $report_date;exit;
		$report_date = date('Y-m-d',strtotime($report_date));
		$inv_no = $_POST['inv_no'];
		$ref_no = $_POST['ref_no'];
		$description = $_POST['description'];
		$amount_type = $_POST['amount_type'];
		$tax_type = $_POST['tax_type'];
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
		
		// $parent_costid = $_POST['parent_cost'];
		// $child_costid = $_POST['child_cost'];

		$report_array = array( 'user_id' => $user_id,'report_date' => $report_date,'inv_no' => $inv_no, 'ref_no' => $ref_no,'description' => $description,'amount_type' => $amount_type,'tax_type' => $tax_type,'amount' => $amount, 'status' => $status,'cost_id'=> $cost_id,'category_id'=> $category_id,'subcategory_id' => $subcategory_id,'report_type' => 1 );
		if($report_id == '')
		{
			$report_array['created_on'] = date('Y-m-d H:i:s');
			$check_inv_qur = $this->db->query("select * from report where inv_no = '".$inv_no."'");
			$check_inv = $check_inv_qur->row();
			$check_inv=count($check_inv);
			if($check_inv > 0)
			{
				$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Invoice Number Already Exists</span></div>');
				redirect(BASE_URL.'reports/add_report');
			}
			else
			{
				$check_ref_qur = $this->db->query("select * from report where ref_no = '".$ref_no."'");
				$check_ref = $check_ref_qur->row();
				$check_ref=count($check_ref);
				if($check_ref > 0)
				{
					$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Reference Number Already Exists</span></div>');
					redirect(BASE_URL.'reports/add_report');
				}
				else
				{
					$report_id = $this->reports_model->Insert('report',$report_array);
				}
			}
		}
		else
		{
			$where_array = array('report_id' => $report_id);
			$report_array['modified_on'] = date('Y-m-d H:i:s');
			
			$check_inv_qur = $this->db->query("select * from report where inv_no = '".$inv_no."' and report_id !='".$report_id."' ");
			$check_inv = $check_inv_qur->row();
			$check_inv=count($check_inv);
			if($check_inv > 0)
			{
				$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Invoice Number Already Exists</span></div>');
				redirect(BASE_URL.'reports/edit_report/'.$report_id);
			}
			else
			{
				$check_ref_qur = $this->db->query("select * from report where ref_no = '".$ref_no."' and report_id !='".$report_id."' ");
				$check_ref = $check_ref_qur->row();
				$check_ref=count($check_ref);
				if($check_ref > 0)
				{
					$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Reference Number Already Exists</span></div>');
					redirect(BASE_URL.'reports/edit_report/'.$report_id);
				}
				else
				{
					$this->reports_model->Update('report',$report_array,$where_array);

					//echo $this->db->last_query();
				}
			}
			
			
		}

		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Report Saved Successfully</span></div>');
		redirect(BASE_URL.'reports/add_report');
		
	}
	public function delete_report($report_id =''){
		if($report_id !='')
		{
			$this->reports_model->Delete('report',array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Selected Report Deleted Successfully</span></div>');
		redirect(BASE_URL.'reports');
		
	}
	
	public function investigate_report($report_id =''){
		if($report_id !='')
		{
			$this->reports_model->Update('report',array('status' => '2'),array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Moved selected data to investigation successfully</span></div>');
		redirect(BASE_URL.'reports');
	}

	public function saveinvcost(){
		//echo "<pre>";print_r($_POST);echo "</pre>";
		$cost_details = (isset($_POST['cost_details']))?$_POST['cost_details']:'';
		if($cost_details)
		{
			foreach($cost_details as $cost_detail)
			{
				$report_id = $cost_detail['report_id'];
				//$cost_name = $cost_detail['cost_name'];
				//$parent_costid = $cost_detail['parent_cost'];
				//$child_costid = $cost_detail['child_cost'];
				$category_id = $subcategory_id = $cost_id = '';
				$data_costid = $cost_detail['data_costid'];
				if($data_costid !='')
				{
					$cost_arr = explode("-",$data_costid);
					$category_id = $cost_arr[0];
					$subcategory_id = $cost_arr[1];
					$cost_id = $cost_arr[2];
				}
				

				if($report_id !='')
				{
					$this->reports_model->Update('report',array('cost_id' => $cost_id,'category_id' => $category_id,'subcategory_id' => $subcategory_id),array('report_id' => $report_id));
				}
			}
			$message = "<div class='alert alert-success'>Investigation Cost Saved Successfully</div>";
			$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Investigation Cost Saved Successfully</span></div>');
		}
		else
		{
			$message = "<div class='alert alert-danger'>Error in save details</div>";
			$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Error in save details</span></div>');
		}

		echo json_encode(array('message' => $message,'success' => true));
		exit;
	}
	public function report_invrestore($report_id =''){
		if($report_id !='')
		{
			$this->reports_model->Update('report',array('status' => '1'),array('report_id' => $report_id));
		}
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Data restored successfully</span></div>');
		redirect(BASE_URL.'reports/investigation_data');
	}
	
	public function vat201(){
		
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		$data = array(
					'view_file'=>'vat201',
					'current_menu'=>'vat201',
					'cusotm_field'=>'vat201',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Vat201',
					'ClientDetails' => $ClientDetails,
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
	public function iospreedsheet(){

		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}
		
		$data = array(
					'view_file'=>'iospreedsheet',
					'current_menu'=>'iospreedsheet',
					'cusotm_field'=>'iospreedsheet',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Input Output Spreedsheet',
					'ClientDetails' => $ClientDetails,
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
	public function control_account(){
		
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		$data = array(
					'view_file'=>'control_account',
					'current_menu'=>'control_account',
					'cusotm_field'=>'control_account',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Control Account',
					'ClientDetails' => $ClientDetails,
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
	
	public function ajax_ctrlaccount(){
		ini_set("allow_url_fopen", 1);
		$multiple_amt = '0.130434782608696';
		$balance = 0;
		$currentcy_symbol = 'R';
		$excel_array = array();
		//$excel_fname = 'control_account_'.mt_rand().'.xls';
		//$pdf_fname = 'control_account_'.mt_rand().'.pdf';
		
		
		$excel_fname = 'control_account.xls';
		$pdf_fname = 'control_account.pdf';
		
		
		//$report_type = $_REQUEST['report_type'];
		$opening_bal_from = $_REQUEST['opening_bal_from'];
		$opening_bal_to = $_REQUEST['opening_bal_to'];
		$user_id = $_REQUEST['client_id'];

		if($opening_bal_from !='')
		{
			$report_date1 = explode('/',$opening_bal_from);
			$opening_bal_from = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}

		if($opening_bal_to !='')
		{
			$report_date1 = explode('/',$opening_bal_to);
			$opening_bal_to = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}

		
		$where_data = array('status' => 1,'user_id' => $user_id);
		
		if($opening_bal_from !='' && $opening_bal_to !=''){
			$start_date = date('Y-m-d',strtotime($opening_bal_from));
			$end_date = date('Y-m-d',strtotime($opening_bal_to));

			$where_data = array('report_date >= ' => $start_date, 'report_date <=' => $end_date,'status' => 1,'user_id' => $user_id);
		}

		$report_results = $this->reports_model->getDetails('report',$where_data,'',array("orderby" => 'report_date', 'disporder' => 'asc','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
		
		//echo $this->db->last_query();
		
		//echo "<pre>";print_r($report_results);echo "</pre>";
		
		$table_div = "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><th>S.no</th><th>Date</th><th>Inv No</th><th>Ref No</th><th>Description</th><th style='text-align:right;'>Dr</th><th style='text-align:right;'>Cr</th ><th style='text-align:right;'>Balance</th></tr></thead><tbody>";

		$array_count=7;
		if($report_results)
		{
			$count = 0;
			foreach($report_results as $report_result)
			{
				$count++;
				$report_date = $report_result->report_date;
				$report_date = date('d-M-Y',strtotime($report_date));
				$inv_no = $report_result->inv_no;
				$ref_no = $report_result->ref_no;
				$description = $report_result->description;
				$amount_type = $report_result->amount_type;
				$amount = $report_result->amount;
				$tax_type = $report_result->tax_type;
				$tr_color = '';
				if($tax_type == 'tax') {
					if($amount_type == 'sales')
					{
						$dr_a = $dr = 0;
						$cr_a = (float)$amount * (float)$multiple_amt;
						$cr =  number_format($cr_a,2);
						$dr_amt = '';
						$cr_amt = $currentcy_symbol.$cr;
						$dr_amt_xl = '';
						$cr_amt_xl = $cr;
						
						
					}
					else
					{
						$dr_a = (float)$amount * (float)$multiple_amt;
						$cr_a = $cr = 0;
						$dr = number_format($dr_a,2);
						
						$dr_amt = $currentcy_symbol.$dr;
						$cr_amt = "";
						$dr_amt_xl = $dr;
						$cr_amt_xl = "";
						
						
						
					}
				}
				else
				{
					$tr_color = "background:#83c9d8;";
					
					if($amount_type == 'sales')
					{
						$dr_a = $dr = 0;
						$cr_a = 0;
						$cr =  0.00;
						$dr_amt = '';
						$cr_amt = $currentcy_symbol.$cr;
						$dr_amt_xl = '';
						$cr_amt_xl = $cr;
					}
					else
					{
						$dr_a = 0;
						$cr_a = $cr = 0;
						$dr = 0.00;
						
						$dr_amt = $currentcy_symbol.$dr;
						$cr_amt = "";
						$dr_amt_xl = $dr;
						$cr_amt_xl = "";
					}
						
				}
				
				//$balance += $dr_a - $cr_a;
				$balance += $cr_a - $dr_a;
				
				$balance_amt = number_format((float)$balance,2);
				$balance_amt = $currentcy_symbol.$balance_amt;
				
				$balance_amt_xl = $balance;

				$balance_amt_xl = number_format((float)$balance_amt_xl,2);
				
				$table_div .=  "<tr style='$tr_color'><td>".$count."</td><td>".$report_date."</td><td>".$inv_no."</td><td>".$ref_no."</td><td>".$description."</td><td style='text-align:right;'>".$dr_amt."</td><td style='text-align:right;'>".$cr_amt."</td><td style='text-align:right;'>".$balance_amt."</td></tr>";
				
				$excel_array[] = array( $report_date, $inv_no , $ref_no, $description, $dr_amt_xl, $cr_amt_xl, $balance_amt_xl);
				$array_count++;
				
			}
			
			$balance_amt = number_format((float)$balance,2);
			$balance_amt = $currentcy_symbol.$balance_amt;
			$table_div .= "<tr><td colspan='7'></td><td style='font-weight:bold;text-align:right;'>".$balance_amt."</td></tr>";
		}
		else
		{
			$table_div .= "<tr><td colspan='8'>No data found</td></tr>";
		}
		$table_div .= "</tbody></table>";
		
		
		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Control Account Report');
        //$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
        $this->excel->getActiveSheet()->setCellValue('A3', '2018');
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Inv No');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Ref No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Description');
        $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');
        $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('E'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
        for($col = ord('A'); $col <= ord('G'); $col++){
           $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        }

        $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

        //$bal_amount = money_format('%!i', $balance_total);
        $bal_amount = number_format((float)$balance, 2);
        $final_xl = 'G'.$array_count;
        $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
        $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

        //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
   
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH.'uploads/'.$excel_fname);
		/********************* EXCEL End ********/
			
		/********************* PDF start ********/
			
		$this->load->library('m_pdf'); 

		$page_data['page_name']  	= 'student_preview_invoice_pdf';
		$page_data['table_div'] = $table_div;
		$page_data['report_results'] 	= $report_results;
		$this->load->view('controlaccount_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();
     
		//echo $html;
		$stylesheet = '';
		//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');
   
		$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf->WriteHTML($html);
  
		$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
		$this->output->set_output('');
		ob_end_flush();
		ob_start();
			
		/********************* PDF END ********/
			
		$htmltd_content = "<div class='col-md-12' style='text-align:right;'>
		<a href='".BASE_URL."uploads/".$excel_fname."' class='btn purple-sharp  btn-outline1 cledger_xlsdownload' download=''><i class='fa fa-file-excel-o'></i> EXCEL</a>
		<a href='".BASE_URL."uploads/".$pdf_fname."' class='btn purple-sharp  btn-outline1 cledger_xlsdownload' download=''><i class='fa fa-file-excel-o'></i> PDF</a>
		</div>".$table_div;
		echo json_encode(array("status" => 1,'table_content' => $htmltd_content,'excel_fname' => $excel_fname));
	}
	
	
	public function ajax_ousheet(){
		
		//$multiple_amt = '0.130434782608696';
		$balance = 0;
		$currentcy_symbol = 'R';
		$excel_array = array();
		//$excel_fname = 'control_account_'.mt_rand().'.xls';
		//$pdf_fname = 'control_account_'.mt_rand().'.pdf';
		
		
		$excel_fname = 'input_output_sheet.xls';
		$pdf_fname = 'input_output_sheet.pdf';
		
		
		//$report_type = $_REQUEST['report_type'];
		$opening_bal_from = $_REQUEST['opening_bal_from'];
		$opening_bal_to = $_REQUEST['opening_bal_to'];
		$user_id = $_REQUEST['client_id'];

		if($opening_bal_from !='')
		{
			$report_date1 = explode('/',$opening_bal_from);
			$opening_bal_from = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}

		if($opening_bal_to !='')
		{
			$report_date1 = explode('/',$opening_bal_to);
			$opening_bal_to = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}

		
		$where_data = array('status' => 1,'user_id' => $user_id);
		
		if($opening_bal_from !='' && $opening_bal_to !=''){
			$start_date = date('Y-m-d',strtotime($opening_bal_from));
			$end_date = date('Y-m-d',strtotime($opening_bal_to));
			$where_data = array('report_date >= ' => $start_date, 'report_date <=' => $end_date,'status' => 1,'user_id' => $user_id);
		}

		$report_results = $this->reports_model->getDetails('report',$where_data,'',array("orderby" => 'report_date', 'disporder' => 'asc','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
		
		//echo $this->db->last_query();
		
		//echo "<pre>";print_r($report_results);echo "</pre>";
		
		$table_div = "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><th>S.no</th><th>Date</th><th>Inv No</th><th>Ref No</th><th>Description</th><th>Dr</th><th>Cr</th><th>Balance</th></tr></thead><tbody>";

		$array_count=7;
		if($report_results)
		{
			$count = 0;
			foreach($report_results as $report_result)
			{
				$count++;
				$report_date = $report_result->report_date;
				$report_date = date('d-M-Y',strtotime($report_date));
				$inv_no = $report_result->inv_no;
				$ref_no = $report_result->ref_no;
				$description = $report_result->description;
				$amount_type = $report_result->amount_type;
				$amount = $report_result->amount;
				$tax_type = $report_result->tax_type;
				
				$tr_color = '';
				if($amount_type == 'sales')
				{
					$dr_a = $dr = 0;
					$cr_a = (float)$amount;
					$cr =  number_format($cr_a,2);
					$dr_amt = '';
					$cr_amt = $currentcy_symbol.$cr;
					$dr_amt_xl = '';
					$cr_amt_xl = $cr;
					
					
				}
				else
				{
					$dr_a = (float)$amount;
					$cr_a = $cr = 0;
					$dr = number_format($dr_a,2);
					
					$dr_amt = $currentcy_symbol.$dr;
					$cr_amt = "";
					$dr_amt_xl = $dr;
					$cr_amt_xl = "";
					
					
					
				}
				
				
				if($tax_type != 'tax') {

					$tr_color = "background:#83c9d8;";
					

						
				}
				
				//echo "dr = ".$dr." = cr = ".$cr;
				$balance += $dr_a - $cr_a;
				$balance_amt = number_format((float)$balance,2);
				$balance_amt = $currentcy_symbol.$balance_amt;
				$balance_amt_xl = $balance;
				
				$table_div .=  "<tr style='".$tr_color."'><td>".$count."</td><td>".$report_date."</td><td>".$inv_no."</td><td>".$ref_no."</td><td>".$description."</td><td>".$dr_amt."</td><td>".$cr_amt."</td><td>".$balance_amt."</td></tr>";
				
				$excel_array[] = array( $report_date, $inv_no , $ref_no, $description, $dr_amt_xl, $cr_amt_xl, $balance_amt_xl);
				$array_count++;
				
			}
			$balance_amt = number_format((float)$balance,2);
			$balance_amt = $currentcy_symbol.$balance_amt;
			$table_div .= "<tr><td colspan='7'></td><td style='font-weight:bold;'>".$balance_amt."</td></tr>";
		}
		else
		{
			
			$table_div .= "<tr><td colspan='8'>No data found</td></tr>";
		}
		$table_div .= "</tbody></table>";
		
		
		/********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Control Account Report');
        //$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
        $this->excel->getActiveSheet()->setCellValue('A3', '2018');
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Inv No');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Ref No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Description');
        $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');
        $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('E'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

            //$bal_amount = money_format('%!i', $balance_total);
            $bal_amount = number_format((float)$balance, 2);
            $final_xl = 'G'.$array_count;
            $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            //$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);
			
			
			/********************* EXCEL End ********/
			
			/********************* PDF start ********/
			
			 $this->load->library('m_pdf'); 
			 
			 
			//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

			$page_data['page_name']  	= 'student_preview_invoice_pdf';
			$page_data['table_div'] = $table_div;
			$page_data['report_results'] 	= $report_results;
			$this->load->view('controlaccount_pdf', $page_data);
			// Get output html
			$html = $this->output->get_output();
     
			//echo $html;
			$stylesheet = '';
			//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/
			
			
			$htmltd_content = "<div class='col-md-12' style='text-align:right;'>
		<a href='".BASE_URL."uploads/".$excel_fname."' class='btn purple-sharp  btn-outline1 cledger_xlsdownload' download=''><i class='fa fa-file-excel-o'></i> EXCEL</a>
		
		<a href='".BASE_URL."uploads/".$pdf_fname."' class='btn purple-sharp  btn-outline1 cledger_xlsdownload' download=''><i class='fa fa-file-excel-o'></i> PDF</a>
		
		</div>".$table_div;
			
			

		echo json_encode(array("status" => 1,'table_content' => $htmltd_content,'excel_fname' => $excel_fname));
		
		
	}
	
	public function ajax_vat(){
		// ini_set("allow_url_fopen", 'On');
		// print_r(ini_get("allow_url_fopen"));
 	// 	if (ini_get("allow_url_fopen") == 'On') {
		// 	echo "allow_url_fopen is ON";
		// } else {
		// 	echo "allow_url_fopen is OFF";
		// }

		$multiple_amt = '0.130434782608696';
		$balance = 0;
		$currentcy_symbol = 'R';
		$excel_array = array();
		//$excel_fname = 'vat201_'.mt_rand().'.xls';
		//$pdf_fname = 'vat201_'.mt_rand().'.pdf';
		
		$userinfo = $this->session->userinfo;
		//$user_id =  $this->session->userinfo->id;
		
		
		
		
		//$excel_fname = 'vat201.xls';
		$pdf_fname = 'vat201.pdf';
		
		
		//$report_type = $_REQUEST['report_type'];
		$opening_bal_from = $_REQUEST['opening_bal_from'];
		$opening_bal_to = $_REQUEST['opening_bal_to'];
		$user_id = $_REQUEST['client_id'];

		if($opening_bal_from !='')
		{
			$report_date1 = explode('/',$opening_bal_from);
			$opening_bal_from = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}

		if($opening_bal_to !='')
		{
			$report_date1 = explode('/',$opening_bal_to);
			$opening_bal_to = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
		}
		
		$user_details = $this->reports_model->getDetails('usermaster',array('id' => $user_id));

		
		$where_data = array('status' => 1,'user_id' => $user_id);
		
		if($opening_bal_from !='' && $opening_bal_to !=''){
			$start_date = date('Y-m-d',strtotime($opening_bal_from));
			$end_date = date('Y-m-d',strtotime($opening_bal_to));

			$where_data = array('report_date >= ' => $start_date, 'report_date <=' => $end_date,'user_id' => $user_id,'status' => 1);
		}


$start_month = date("F", strtotime($start_date));
$end_month = date("F", strtotime($end_date));
$month_year = date("Y", strtotime($start_date));


		$report_results = $this->reports_model->getDetails('report',$where_data,'',array("orderby" => 'report_date', 'disporder' => 'asc','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
		
		//echo $this->db->last_query();
		
		//echo "<pre>";print_r($report_results);echo "</pre>";
		
		$total_sale = $zero_total_sale = $zero_total_cost =  0;
		$total_cost=0;
		$sales_zer_arr = $cost_zer_arr = array();
		
		if($report_results)
		{
			$count = 0;
			foreach($report_results as $report_result)
			{
				$report_date = $report_result->report_date;
				$report_date = date('d-M-Y',strtotime($report_date));
				$inv_no = $report_result->inv_no;
				$ref_no = $report_result->ref_no;
				$description = $report_result->description;
				$amount_type = $report_result->amount_type;
				$amount = (float)$report_result->amount;
				$tax_type = $report_result->tax_type;
				if($amount_type == 'sales')
				{
					if($tax_type != 'tax') {
						$sales_zer_arr[] = $amount;
						$zero_total_sale = $zero_total_sale+ $amount;
					}
					$total_sale = $total_sale+$amount;
				}
				else
				{
					if($tax_type != 'tax') {
						$cost_zer_arr[] = $amount;
						$zero_total_cost = $zero_total_cost+ $amount;
					}
					$total_cost = $total_cost+$amount;
				}
			}
		}
		
		//echo "total_cost = ".$total_cost;
		
		$sale_total_vatfornet = $total_sale - $zero_total_sale;
		$sale_total_vatfornet_ta = $sale_total_vatfornet*0.130434782608696;
		
		
		$cost_total_vatfornet = $total_cost - $zero_total_cost;
		$cost_total_vatfornet_ta = $cost_total_vatfornet*0.130434782608696;
		
		
		
		/*$table_div = "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><th>S.no</th><th>Date</th><th>Inv No</th><th>Ref No</th><th>Description</th><th style='text-align:right;'>Dr</th><th style='text-align:right;'>Cr</th ><th style='text-align:right;'>Balance</th></tr></thead><tbody>";

		$array_count=7;
		if($report_results)
		{
			$count = 0;
			foreach($report_results as $report_result)
			{
				$count++;
				$report_date = $report_result->report_date;
				$report_date = date('d-M-Y',strtotime($report_date));
				$inv_no = $report_result->inv_no;
				$ref_no = $report_result->ref_no;
				$description = $report_result->description;
				$amount_type = $report_result->amount_type;
				$amount = $report_result->amount;
				$tax_type = $report_result->tax_type;
				$tr_color = '';
				if($tax_type == 'tax') {
					if($amount_type == 'sales')
					{
						$dr_a = $dr = 0;
						$cr_a = (float)$amount * (float)$multiple_amt;
						$cr =  number_format($cr_a,2);
						$dr_amt = '';
						$cr_amt = $currentcy_symbol.$cr;
						$dr_amt_xl = '';
						$cr_amt_xl = $cr;
						
						
					}
					else
					{
						$dr_a = (float)$amount * (float)$multiple_amt;
						$cr_a = $cr = 0;
						$dr = number_format($dr_a,2);
						
						$dr_amt = $currentcy_symbol.$dr;
						$cr_amt = "";
						$dr_amt_xl = $dr;
						$cr_amt_xl = "";
						
						
						
					}
				}
				else
				{
					$tr_color = "background:#83c9d8;";
					
					if($amount_type == 'sales')
					{
						$dr_a = $dr = 0;
						$cr_a = 0;
						$cr =  0.00;
						$dr_amt = '';
						$cr_amt = $currentcy_symbol.$cr;
						$dr_amt_xl = '';
						$cr_amt_xl = $cr;
						
						
					}
					else
					{
						$dr_a = 0;
						$cr_a = $cr = 0;
						$dr = 0.00;
						
						$dr_amt = $currentcy_symbol.$dr;
						$cr_amt = "";
						$dr_amt_xl = $dr;
						$cr_amt_xl = "";
						
						
						
					}
						
				}
				
				$balance += $dr_a - $cr_a;
				
				$balance_amt = number_format((float)$balance,2);
				$balance_amt = $currentcy_symbol.$balance_amt;
				
				$balance_amt_xl = $balance;
				
				$table_div .=  "<tr style='$tr_color'><td>".$count."</td><td>".$report_date."</td><td>".$inv_no."</td><td>".$ref_no."</td><td>".$description."</td><td style='text-align:right;'>".$dr_amt."</td><td style='text-align:right;'>".$cr_amt."</td><td style='text-align:right;'>".$balance_amt."</td></tr>";
				
				$excel_array[] = array( $report_date, $inv_no , $ref_no, $description, $dr_amt_xl, $cr_amt_xl, $balance_amt_xl);
				$array_count++;
				
			}
			
			$balance_amt = number_format((float)$balance,2);
			$balance_amt = $currentcy_symbol.$balance_amt;
			$table_div .= "<tr><td colspan='7'></td><td style='font-weight:bold;text-align:right;'>".$balance_amt."</td></tr>";
		}
		else
		{
			
			$table_div .= "<tr><td colspan='8'>No data found</td></tr>";
		}
		$table_div .= "</tbody></table>";*/
		

			
			/********************* PDF start ********/
			
			 $this->load->library('m_pdf'); 
			 
			 
			//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';
			
			$final_vat = $sale_total_vatfornet_ta - $cost_total_vatfornet_ta;

			$page_data['page_name']  	= 'vatpdf';
			$page_data['user_details'] = $user_details;
			$page_data['total_sale'] 	= number_format($total_sale,2);
			$page_data['total_cost'] 	= number_format($total_cost,2);
			$page_data['sales_zer_arr'] = $sales_zer_arr;
			$page_data['zero_total_sale'] = number_format($zero_total_sale,2);
			$page_data['sale_total_vatfornet_ta'] = number_format($sale_total_vatfornet_ta,2);
			$page_data['zero_total_cost'] = number_format($zero_total_cost,2);
			$page_data['cost_total_vatfornet_ta'] = number_format($cost_total_vatfornet_ta,2);
			$page_data['final_vat'] = number_format($final_vat,2);
			$page_data['month_year'] = $month_year;
			$page_data['start_month'] = $start_month;
			$page_data['end_month'] = $end_month;
			$this->load->view('vatpdf', $page_data);
			// Get output html
			$html = $this->output->get_output();
     	
			//echo $html;
			$stylesheet = '';
			//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/
			
			
			$htmltd_content = "<br><br><div class='col-md-12' style='text-align:center;' >
		
		
		<a href='".BASE_URL."uploads/".$pdf_fname."' class='btn purple-sharp  btn-outline1 vat_pdfdownload' download=''><i class='fa fa-file-excel-o'></i> Download VAT PDF</a>
		
		</div>".$table_div;
			
			
			$pdfuurl = BASE_URL."uploads/".$pdf_fname;

		echo json_encode(array("status" => 1,'table_content' => $htmltd_content,'excel_fname' => $excel_fname,'pdfuurl' => $pdfuurl));
		
		
	}
	
	
	public function vatpdf_check(){
		
		$this->load->library('m_pdf'); 
			 
			 
			 $pdf_name = 'rrrrrrrrrrrrrrrrrr.pdf';

			$page_data['page_name']  	= 'vatpdf';
			$page_data['total_sale'] 	= $total_sale;
			$page_data['total_cost'] 	= $total_cost;
			$page_data['sales_zer_arr'] = $sales_zer_arr;
			$page_data['zero_total'] = $zero_total;
			$page_data['sale_total_vatfornet_ta'] = $sale_total_vatfornet_ta;
			$this->load->view('vatpdf', $page_data);
			// Get output html
			$html = $this->output->get_output();
     
			//echo $html;
			$stylesheet = '';
			//$stylesheet .= file_get_contents(BASE_URL.'/assets/css/std_invoice.css');
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_name, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			echo  $pdf_name ;
		}

	public function import_data(){
		$userdata= $this->session->userinfo;

		//echo "<pre>";print_r($this->session);echo "</pre>";
		if($userdata){
			$filtered_client_id= $this->session->id;
			//array('file.file_type' => 'receipt')
			//$ClientDetails = $this->client_model->getClientDetails();

				$usertype= $this->session->usertype;
				$fclient_id = '';
				$ClientDetails = array();
				if($usertype == '5')
				{

					$ClientDetails = $this->client_model->getClientDetails();	
				}

			$data = array(
					'view_file'=>'import_data',
					'current_menu'=>'import_data',
					'site_title' =>'Import Data',
					'logo'		=> 'logo',
					'title'=>'Import Datas',
					'ClientDetails' => $ClientDetails,
					'filtered_client_id' => $filtered_client_id,
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

	function import_datamaping(){
		$data_list = array();
	//	echo "<pre>";print_r($_POST);echo "</pre>";
		//$client_id= $this->session->id;

		$client_id = $_POST['client_id'];
		//$opening_bal_from = $_POST['opening_bal_from'];
		//$opening_bal_to = $_POST['opening_bal_to'];
		
		$this->load->library('excel'); 

		$this->reports_model->Delete('temp_data', array('client_id' => $client_id));


		//PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

		if(isset($_FILES['datafile']))
		{
			if ($_FILES['datafile']['size'] > 0) { 


				//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
		         $configUpload['upload_path'] = FCPATH.'uploads/excel/';
		         $configUpload['allowed_types'] = 'xls|xlsx|csv';
		         $configUpload['max_size'] = '5000';
		         $this->load->library('upload', $configUpload);
		         $this->upload->do_upload('datafile');	
		         $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		         $file_name = $upload_data['file_name']; //uploded file name
				 $extension=$upload_data['file_ext'];    // uploded file extension

				 if($extension == '.xls' || $extension == '.xlsx')
		 		{
		 			PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					if($extension == '.xlsx')
					{
						$objReader = PHPExcel_IOFactory::createReader('Excel2007'); 
					}
					else
					{
						$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
					}


					//$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
          			$objReader->setReadDataOnly(true); 	

		 			$objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);		 //Load excel file 
         			$totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows avalable in excel      	 
         			$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);             //loop from first data untill last data
          			for($i=2;$i<=$totalrows;$i++)
          			{
		            	$date= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();	
		            	if($date != 'Period' && $date != 'DATE' && $date != 'Date' )
		            	{
		            	$phpDateTimeObject = PHPExcel_Shared_Date::ExcelToPHPObject($date);
		            	//$date_value = PHPExcel_Shared_Date::ExcelToPHPObject($date);
		            	$date_value = $phpDateTimeObject->format('Y-m-d');
		            	}
		            	else
		            	{
		            		$date_value = '';
		            	}

		            	$ref= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
		            	if($ref != ''){$ref = $ref;}else {$ref = '';}		
		                $desc= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); 
		                if($desc != ''){$desc = $desc;}else {$desc = '';}
					    $cost= $objWorksheet->getCellByColumnAndRow(3,$i)->getCalculatedValue();
					    if($cost != ''){$cost = $cost;}else {$cost = '';}
					    $sales=$objWorksheet->getCellByColumnAndRow(4,$i)->getCalculatedValue();
					    if($sales != ''){$sales = $sales;}else {$sales = '';}
					    $tax_type=$objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
					    if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}
					    // $dr=$objWorksheet->getCellByColumnAndRow(5,$i)->getCalculatedValue();
					    // if($dr != ''){$dr = $dr;}else {$dr = '';}
					    // $cr=$objWorksheet->getCellByColumnAndRow(6,$i)->getCalculatedValue();
					    // if($cr != ''){$cr = $cr;}else {$cr = '';}
					    // $balance=$objWorksheet->getCellByColumnAndRow(7,$i)->getCalculatedValue();
					    // if($balance != ''){$balance = $balance;}else {$balance = '';}

					    // $tax_type=$objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
					    // if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}

			    		if($date !='' && ($cost !='' || $sales  !='' ))
		        	 	{
		        	 		$data_list[] = array($date_value,$ref,$desc,$cost,$sales,$tax_type); 
		        	 		
		        	 		$insert_data = array(
		        	 			'client_id' => $client_id,
							    'date' => $date_value,
							    'ref' => $ref,
							    'details' => $desc,
							    'cost' => $cost,
							    'sales' => $sales,
								'tax_type' => $tax_type
								);


		        	 		$insert_status = $this->reports_model->Insert('temp_data',$insert_data);
		        	 		//echo "<pre>";print_r($cashbook_list); echo "</pre>";
		        		}
		        		else{}	  
          			}
				}
				else{
			        $fp = fopen($_FILES['datafile']['tmp_name'],'r') or die("can't open file");
			        while($csv_line = fgetcsv($fp,1024))
			        {
			        	

			        	 if($csv_line[0] !='' && $csv_line[2] !='')
			        	 {
			        	 $data_list[] = $csv_line; 

			        	 $date_value= $csv_line[0];
		            	if($date_value != ''){$date_value = $date_value;}else {$date_value = '';}
		            	 $ref= $csv_line[1];
		            	if($ref != ''){$ref = $ref;}else {$ref = '';}			
		                $desc= $csv_line[2]; 
		                if($desc != ''){$desc = $desc;}else {$desc = '';}
					    $cost= $csv_line[3];
					    if($cost != ''){$cost = $cost;}else {$cost = '';}
					    $sales=$csv_line[4];
					    if($sales != ''){$sales = $sales;}else {$sales = '';}
					    $dr=$csv_line[5];

					    $tax_type=$csv_line[6];
					    if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}

					    // if($dr != ''){$dr = $dr;}else {$dr = '';}
					    // $cr=$csv_line[6];
					    // if($cr != ''){$cr = $cr;}else {$cr = '';}
					    // $balance=$csv_line[7];
					    // if($balance != ''){$balance = $balance;}else {$balance = '';}

					    // $tax_type=$csv_line[7];
					    // if($tax_type != ''){$tax_type = $tax_type;}else {$tax_type = 'Tax invoice';}


					    $insert_data = array(
		        	 			'client_id' => $client_id,
							    'date' => $date_value,
							    'ref' => $ref,
							    'details' => $transacion_type,
							    'cost' => $cost,
							    'sales' => $sales,
								'tax_type' => $tax_type,
								);




		        	 		$insert_status = $this->reports_model->InsertTempCash($insert_data);


			        	 //echo "<pre>";print_r($cashbook_list); echo "</pre>";
			        	}

			        }
			        fclose($fp) or die("can't close file");
			    }

			}
		}
//echo "<pre>";print_r($cashbook_list); echo "</pre>";
//exit();
		$userdata= $this->session->userinfo;
		if($userdata){
			//$filtered_client_id= $this->session->filtered_client_id;
			$data = array(
					'view_file'=>'import_datamaping',
					'current_menu'=>'import_datamaping',
					'site_title' =>'Import Datas',
					'logo'		=> 'logo',
					'title'=>'Import Datas',
					'data_list' => $data_list,
					'client_id' => $client_id,
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

	public function import_datafilesave(){
		


		if(isset($_POST['db_column']) && isset($_POST['csv_column']))
		{
			//$client_id= $this->session->id;
			$client_id = $_POST['client_id'];
			$temp_details = $this->reports_model->getDetails('temp_data',array('client_id' => $client_id));

			//echo $this->db->last_query();
			
			$date_index = -1;
			$desc_index = -1;
			$expense_index = -1;
			$sales_index = -1;
			// $dr_index = -1;
			// $cr_index = -1;
			$tax_type_index = -1;
			//$file_name = 0;
			$dr = 0;
			$cr = 0;

			//$start_month = '';
			//$next_month = '';
			//$start_year = '';
			//$next_year = '';
			//$open_bal_array = array();
			//$open_bal_value_array = array();
			//$file_id = '';
			//$opening_bal_from = $_POST['opening_bal_from'];
			//$opening_bal_to = $_POST['opening_bal_to'];
			
			$db_column = $_POST['db_column'];
			$csv_column = $_POST['csv_column'];
			//echo "<pre>";print_r($temp_details);echo "</pre>";
			$array_temp = json_decode(json_encode($temp_details),true);
			//echo "<pre>";print_r($array_temp);echo "</pre>";exit;
			$array_values = array_values($array_temp);
			//echo "<pre>";print_r($array_values);echo "</pre>";
			//echo "empty";
			//echo "<pre>";print_r($csv_column);echo "</pre>";
			foreach ($db_column as $key => $value) {
				if($value == 'date')
				{
					 $date_index = $key+2;
				}
				else if($value == 'desc')
				{
					$desc_index = $key+2;
				}
				else if($value == 'expense')
				{
					$expense_index = $key+2;
				}
				else if($value == 'sales')
				{
					$sales_index = $key+2;
				}
				// else if($value == 'dr')
				// {
				// 	$dr_index = $key+2;
				// }
				// else if($value == 'cr')
				// {
				// 	$cr_index = $key+2;
				// }
				else if($value == 'ref')
				{
					$ref_index = $key+2;
				}
				else if($value == 'tax_type')
				{
					$tax_type_index = $key+2;
				}
				else {}
			}
		//echo "<br>";
			if($date_index != '-1' && $desc_index != '-1' && $expense_index != '-1' && $sales_index != '-1')
			{
				foreach ($array_temp as $key => $values) {

					//echo "<pre>";print_r($values);echo "</pre>";
					$array_values22 = array_values($values);



					$date = $array_values22[$date_index];
					$ref_value = $array_values22[$ref_index];
					$desc = $array_values22[$desc_index];
					$expense = $array_values22[$expense_index];
					$sales = $array_values22[$sales_index];
					$tax_type = $array_values22[$tax_type_index];
					//$dr = $array_values22[$dr_index];
					//$cr = $array_values22[$cr_index];
					//$dr = preg_replace('/\s+/', '', $dr);
					//$cr = preg_replace('/\s+/', '', $cr);
					
					 if($tax_type== 'Zero rated'){$tax_type = 'expense';}
					else if($tax_type== 'Exempt'){$tax_type = 'exempt';}
					else {$tax_type = 'tax';}


					
					if($date != '' && $date != 'Date' && $date != 'DATE' && $expense != 'Costs/Exp' && $sales != 'Sales' && $desc != 'Description')
					{
				
				 		 $date_format = date('Y-m-d',strtotime($date));
				 		 

				 		 if($expense !=''){$amount_type = 'expense';$amount = $expense;}
				 		 else {$amount_type = 'sales';$amount = $sales;}
				 		
				 
					
							$insert_data = array(
							    'user_id' => $client_id,
							    'report_date' => $date_format,
							    'ref_no' => $ref_value,
							    'description' => $desc,
							    'amount_type' => $amount_type,
							    'amount' => $amount,
							    'tax_type' => $tax_type,
								'status' => 1,
								'cost_id' => SALES_COST_ID,
								'category_id' => SALES_COST_CAT_ID,
								'subcategory_id' => SALES_COST_SUBCAT_ID,
								'created_on' => date('Y-m-d H:i:s'),
								'report_type' => 1
								);
								//print_r($insert_data);

								$insert_status = $this->reports_model->Insert('report', $insert_data);
								$file_id = $this->db->insert_id();



					}
				}

				
				

				$this->reports_model->Delete('temp_data', array('client_id' => $client_id));
				//print_r(array_unique($a));
				//exit();
				//echo $start_date;
				//$this->calculate_openingbal($start_date);
				$this->session->set_flashdata('import_data', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Data Imported Successfully</span></div>');
				redirect(BASE_URL.'reports/import_data');
			}
			else
			{
				$this->session->set_flashdata('import_data', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Data import</span></div>');
				redirect(BASE_URL.'reports/import_data');
			}
		}

	}

	public function cost_group(){
		$unallocated_difference = $profit = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_tfoot= array();

		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		$fclient_id = isset($_GET['client_id'])?$_GET['client_id']:'';

		//SELECT sum(amount) as total_amount,category_id,subcategory_id,cost_id FROM `report` where user_id='1' and cost_id !='' group by cost_id order by subcategory_id asc
		$filtered_client_id = $client_id;
		$CostDetails = $this->costcentre_model->getDetails();
		if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
			}
			else
			{
				$filtered_client_id = $fclient_id;
				$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $fclient_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
			}
			$ClientDetails = $this->client_model->getClientDetails();
		}
		else
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
		}
		//echo $this->db->last_query();


		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_client_name = $cdetl->name;
			}
		}

		$CostDetails_arr = array();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Invoicing Financial Statement </p><br></div><div class="col-md-12">';

// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = '';
            $next_child = '';
            $loop_start = $array_count = 0;
            if($ReportDetails)
            {
                $total_amount = 0;

                foreach($ReportDetails as $ReportDetail)
                {
                   $cost_id = $ReportDetail->cost_id;
                   $subcategory_id = $ReportDetail->subcategory_id;
                   $amount = $ReportDetail->total_amount;
                   $amount = number_format((float)$amount, 2, '.', '');
                   $cost_name = $links = '';
                   if($cost_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $cost_name = $ctcost->cost_name;
                                    $links = $ctcost->links;
                                }
                            }
                        }

                   if($next_child != '' && $next_child != $subcategory_id)
                   {
                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                    $cost_txt .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
                    $excel_array[] = array( 'Total', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '');$excel_array[] = array( '', '' , '');
                    $excel_tfoot[] = $excel_arrcount;
                    $excel_arrcount += 3;

                   }

                   if($previous_child == '' || $previous_child != $subcategory_id)
                   {
                        $total_amount = 0;
                        $childcost = $CostDetails_arr[$subcategory_id];
                        $previous_child = $subcategory_id;
                        $next_child = $subcategory_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;

                        $excel_array[] = array( $child_costname, '' , '');
                        $excel_array[] = array( '', '' , '');
                        $excel_array[] = array( 'Cost Name', 'Links' , 'Amount');

                        $excel_titlearr[] = $excel_arrcount;
                        $excel_arrcount += 2;
                        $excele_tablearr[] = $excel_arrcount;
                        $excel_arrcount += 1;

                        $cost_txt .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
                   }
                   $total_amount += (float)$amount;

                   $oformat_amount = "R".number_format((float)$amount, 2);
	               $oformat_amount_xl = $amount;

	               if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses


                    $cost_txt .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";

                    $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
                    $excel_arrcount++;
                   $array_count++;

                   



                }

                 $oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                $cost_txt .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>R".$total_amount."</td></tr></tfoot></table>";
                $excel_tfoot[] = $excel_arrcount;
                 $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            $oprofit = "R".number_format((float)$profit, 2);
            $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";
               

	               $excel_array[] = array( 'Total', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '');$excel_array[] = array( '', '' , '');


                    $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
            $excel_array[] = array( 'Profit', '' , $profit);

            $excel_tfoot[] = $excel_arrcount;
            $excel_arrcount += 3;
            $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;
            $excel_tfoot[] = $excel_arrcount;$excel_arrcount++;


            }



             $excel_fname = 'cost_group_report.xls';
			$pdf_fname = 'cost_group_report.pdf';


            /********************* EXCEL start ********/
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
        //$this->excel->getActiveSheet()->setCellValue('A2', 'Control Account');
        $this->excel->getActiveSheet()->setCellValue('A2', 'Invoicing Financial Statement');
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        // $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        // $this->excel->getActiveSheet()->setCellValue('B5', 'Inv No');
        // $this->excel->getActiveSheet()->setCellValue('C5', 'Ref No');
        // $this->excel->getActiveSheet()->setCellValue('D5', 'Description');
        // $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        // $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        // $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:E1');
        $this->excel->getActiveSheet()->mergeCells('A2:E2');
        // $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         // $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
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
        $this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('C'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

        	foreach($excel_titlearr as $val)
        {
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setBold(true);
        	$this->excel->getActiveSheet()->getStyle('A'.$val)->getFont()->setSize(13);
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


            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            //$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);
			
			
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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/

		//SELECT * FROM `report` where child_costid !='' order by parent_costid,child_costid asc
		$data = array(
					'view_file'=>'cost_group',
					'current_menu'=>'cost_group',
					'cusotm_field'=>'cost_group',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Cost grouped data',
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
	public function bank_statement(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		$current_userid = $client_id;

		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				$current_userid = $fclient_id;
			}
		}
		// if($usertype == '5')
		// {
		// 	if($fclient_id == '')
		// 	{
				
				
		// 		$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $client_id,'report_type' => 2));
		// 		// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		// 	}
		// 	else
		// 	{
		// 		$current_userid = $fclient_id;
		// 		// $ClientDetails = $this->client_model->getClientDetails();
		// 		$ReportDetails = $this->reports_model->getDetails('report',array('status' => 1,'user_id' => $fclient_id,'report_type' => 2));
		// 		// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $fclient_id));
		// 	}
			
		// }
			
		// else
		// {
		// 	// $ClientDetails = $this->client_model->getClientDetails();
		// 	$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'status' => 1,'report_type' => 2));
		// 	// $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $client_id));
		// }
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$end_month = $cdetl->financial_month_end;
			}
		}
		$bank_stat_yr = $this->reports_model->get_bankstatmt_year($current_userid,$end_month);
		// echo $this->db->last_query();
		// echo "<pre>";print_r($bank_stat_yr);echo "</pre>";
		$data = array(
					'view_file'=>'bank_statement',
					'current_menu'=>'bank_statement',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					// 'ReportDetails' => $ReportDetails,
					// 'CostDetails' => $CostDetails,
					'bank_stat_yr' => $bank_stat_yr,
					//'ParentCost' => $ParentCost,
					//'parent_childcost' => $parent_childcost,
					//'showtopsave' => 'yeee',
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'current_userid' => $current_userid,
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
		

	public function bankstat_arrayfun($month,$year_start,$filtered_client_id){
		$array_merge = [];
		$MonthDetails = $this->reports_model->bankstat_montdetails($month,$year_start,$filtered_client_id);
		$start_date = $year_start."-".$month."-01";
		$CRDetails = $this->reports_model->total_cr($start_date,$filtered_client_id);
		$DRDetails = $this->reports_model->total_dr($start_date,$filtered_client_id);
		// echo "<pre>";print_r($full_details);echo "</pre>";exit;
		$total_cr = $total_dr = 0;
		if($CRDetails)
		{
			$total_cr = $CRDetails->total_cr;
		}
		if($DRDetails)
		{
			$total_dr = $DRDetails->total_dr;
		}
		$opening_balancee = $total_cr-$total_dr;


		// $array_merge['open'] = $opening_balancee;
		// $OpenBalDetails = $this->reports_model->getCashOpenbalDetails($month,$year_start,$filtered_client_id);
		$array_merge['open'] = $opening_balancee;
		$array_merge['all'] = $MonthDetails;

		return $array_merge;
		//echo "<pre>";print_r($MonthDetails);echo"</pre>";
	}

	public function ajax_bankstat(){

		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_GET['client_id'];

		 $year=$_GET['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$start_date = date('Y-m-d');
		
		//print_r($years);
		if($years[0] !='' && $years[1] !='')
		{
			$year_start = $years[0];
			$year_end = $years[1];
			for($month=$filtered_start_month;$month <= 12;$month++)
				{

					$date= $year_start."-".$month."-01";
					$full_details[$date] = $this->bankstat_arrayfun($month,$year_start,$filtered_client_id);

				}
				for($month=1;$month <= $filtered_end_month;$month++)
				{
					$date= $year_end."-".$month."-01";

					$full_details[$date] = $this->bankstat_arrayfun($month,$year_end,$filtered_client_id);


				}

				$start_date = $year_start."-".$filtered_start_month."-01";

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
        $this->excel->getActiveSheet()->setCellValue('A3', 'From '.$start_fulldate.' - '.$end_fulldate);
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



		$cbd_txt = '<input type="hidden" class="inputh_year" value="'.$inputh_year.'"><table style="width:100%"><thead><tr><td style="border:0px"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Bank Statement </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></td></tr></thead><tbody><tr><td style="border:0px;">';

		
		if($full_details)
		{
			
			foreach ($full_details as $key => $value) {
				$balance_total = 0;
				
				$title_date = date('F-Y', strtotime($key));
        		$all_val = $value['all'];
        		$open_val = $value['open'];
        		$balance_total = $open_val;
				if(!empty($all_val) )
		        {
		        	if($table_count == '7')
		        	 $table_count = $table_count+1;
		        	else
		        		 $table_count = $table_count+7;

		        	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $title_date);
		        	$this->excel->getActiveSheet()->mergeCells('A'.$table_count.':G'.$table_count);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        	 $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setSize(10);

		        	$table_count = $table_count+1;

		        	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, 'Report Date');
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, 'Description');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, 'DR');
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, 'CR');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, 'Balance');

			        $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
			        $this->excel->getActiveSheet()->getStyle('B'.$table_count)->getFont()->setBold(true);
			        $this->excel->getActiveSheet()->getStyle('C'.$table_count)->getFont()->setBold(true);
			        $this->excel->getActiveSheet()->getStyle('D'.$table_count)->getFont()->setBold(true);
			        $this->excel->getActiveSheet()->getStyle('E'.$table_count)->getFont()->setBold(true);


					$cbd_txt .= "<p style='font-weight: bold;text-align: center;font-size:13px;margin: 10px 0px 15px;'>".$title_date."</p>";
				
					$cbd_txt .= "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><td>Report Date</td><td>Description</td><td>DR</td><td>CR</td><td>Balance</td></tr></thead>";
				
					$opening_balancee_of = "R".number_format((float)$open_val, 2);
					//$opening_balancee_xl = $open_val;
					$cbd_txt .= "<tr><td></td><td>Opening Balance</td><td>".$opening_balancee_of."</td><td></td><td>".$opening_balancee_of."</td></tr>";

					$table_count++;
					$this->excel->getActiveSheet()->setCellValue('A'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, 'Opening Balance');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, $open_val);
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $open_val);


			        if(!empty($all_val))
			        {
		            	foreach($all_val as $akey => $avalue){

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
			                if($aamount !='')
			                {
	                            //$oformat_amount = "R".money_format('%!i', $aamount) ;
	                            $oformat_amount = "R".number_format((float)$aamount, 2);
	                            //$oformat_amount_xl = number_format((float)$aamount, 2);
	                             $oformat_amount_xl = $aamount;
			                }
	                        else
	                        	$oformat_amount = 0;

	                        
	                        if($amount_type == 'sales') {$cr_amount = $oformat_amount;$cr_amount_xl = $oformat_amount_xl;$balance_total += $aamount;}
			                else{$dr_amount = $oformat_amount;$dr_amount_xl = $oformat_amount_xl;$balance_total -= $aamount;}

	                        $balance_total_amt = number_format((float)$balance_total, 2);


		                	$cbd_txt .= "<tr><td>".$adate_new."</td><td>".$description."</td><td>".$cr_amount."</td><td>".$dr_amount."</td><td>R".$balance_total_amt."</td></tr>";



		                	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $adate_new);
			        		$this->excel->getActiveSheet()->setCellValue('B'.$table_count, $description);
			        		$this->excel->getActiveSheet()->setCellValue('C'.$table_count, $cr_amount_xl);
			        		$this->excel->getActiveSheet()->setCellValue('D'.$table_count, $dr_amount_xl);
			        		$this->excel->getActiveSheet()->setCellValue('E'.$table_count, $balance_total);
		            	}
		        	}


		            $cbd_txt .= "<tr><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>R".$balance_total_amt."</td><tr>";

		        	$table_count++;

		         	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $balance_total);
			        $this->excel->getActiveSheet()->getStyle('E'.$table_count)->getFont()->setBold(true);
		         	$cbd_txt .= "</table>";
		        
		     	}


			     for($col = ord('C'); $col <= ord('E'); $col++){ 
	             	$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	        	}
	        	for($col = ord('C'); $col <= ord('E'); $col++){
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

		$objWriter->save(FCPATH.'uploads/bankstat_list.xls');
		echo $cbd_txt;
		exit();
	}	

	public function bankstat_pdf(){


		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_GET['client_id'];

		 $year=$_GET['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		if($years[0] !='' && $years[1] !='')
		{
			$year_start = $years[0];
			$year_end = $years[1];
			for($month=$filtered_start_month;$month <= 12;$month++)
			{

				$date= $year_start."-".$month."-01";
				$full_details[$date] = $this->bankstat_arrayfun($month,$year_start,$filtered_client_id);

			}
			for($month=1;$month <= $filtered_end_month;$month++)
			{
				$date= $year_end."-".$month."-01";

				$full_details[$date] = $this->bankstat_arrayfun($month,$year_end,$filtered_client_id);


			}

		}
		// echo "<pre>";print_r($full_details);echo "</pre>";exit;

		$table_count = 7;


		$cbd_txt_pdf = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">Bank Statement </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

		
		if($full_details)
		{
			
			foreach ($full_details as $key => $value) {
				$balance_total = 0;
				$title_date = date('F-Y', strtotime($key));
				$open_val = $value['open'];
        		$all_val = $value['all'];
        		$balance_total = $open_val;
				if(!empty($all_val) )
		        {
					
		        	if($table_count == '7')
		        	 $table_count = $table_count+1;
		        	else
		        		 $table_count = $table_count+7;
		        	
			
					$cbd_txt_pdf .= "<p style='font-weight: bold;text-align: center;font-size:13px;margin: 10px 0px 15px;'>".$title_date."</p>";
					$cbd_txt_pdf .= "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><td>Report Date</td><td>Description</td><td>Dr</td><td>Cr</td><td>Balance</td></tr></thead>";
					$opening_balancee_of = "R".number_format((float)$open_val, 2);
					//$opening_balancee_xl = $open_val;
					$cbd_txt_pdf .= "<tr><td></td><td>Opening Balance</td><td>".$opening_balancee_of."</td><td></td><td>".$opening_balancee_of."</td></tr>";

			        if(!empty($all_val))
			        {
			            foreach($all_val as $akey => $avalue){

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
			                if($aamount !='')
			                {
	                            $oformat_amount = "R".number_format((float)$aamount, 2);
	                             $oformat_amount_xl = $aamount;
			                }

	                        else
	                        	$oformat_amount = 0;

	                        if($amount_type == 'sales') {$cr_amount = $oformat_amount;$cr_amount_xl = $oformat_amount_xl;$balance_total += $aamount;}
			                else{$dr_amount = $oformat_amount;$dr_amount_xl = $oformat_amount_xl;$balance_total -= $aamount;}

	                        $balance_total_amt = number_format((float)$balance_total, 2);

			                $cbd_txt_pdf .= "<tr><td>".$adate_new."</td><td>".$description."</td><td>".$cr_amount."</td><td>".$dr_amount."</td><td>R".$balance_total_amt."</td></tr>";
		            	}
		        	}

		            $cbd_txt_pdf .= "<tr><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>R".$balance_total_amt."</td><tr>";
		        	$table_count++;

		         	$cbd_txt_pdf .= "</table>";
		        
		     	}
						
			}
		}

  		$cbd_txt_pdf .= "</div>";


		$data = array(
			'view_file'=>'bankstat_list_pdf',
			'cbd_txt_pdf' => $cbd_txt_pdf,
			);

			// Load all views as normal
		$this->load->view('bankstat_list_pdf',$data);
			// Get output html
		$html = $this->output->get_output();

		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 600, 600), "portrait");
		$this->dompdf->render();

		$output = $this->dompdf->output();
		file_put_contents(FCPATH.'uploads/bankstat_list.pdf', $output);

		echo json_encode(array('message' => 'success'));
		exit();
	}


	public function invoice_pdf_view(){


		$data = array(
					'view_file'=>'invoicing/invoicepdfclick',
					'current_menu'=>'report',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',

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

	public function invoice_pdf(){

		
		
		
		//$excel_fname = 'vat201.xls';
		$pdf_fname = 'invoice.pdf';
		
		
		

		

			
			/********************* PDF start ********/
			
			 $this->load->library('m_pdf'); 
			 
			 
			//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';
			
			// $final_vat = $sale_total_vatfornet_ta - $cost_total_vatfornet_ta;

			$page_data['page_name']  	= 'vatpdf';

			$this->load->view('invoicing/invoicepdf', $page_data);
			// Get output html
			$html = $this->output->get_output();
     	
			//echo $html;
			$stylesheet = '';
			//$stylesheet .= file_get_contents(BASE_URL.'/lib/bootstrap/css/bootstrap.min.css');
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/
			
			
			$htmltd_content = "<br><br><div class='col-md-12' style='text-align:center;' >
		
		
		<a href='".BASE_URL."uploads/".$pdf_fname."' class='btn purple-sharp  btn-outline1 vat_pdfdownload' download=''><i class='fa fa-file-excel-o'></i> Download VAT PDF</a>
		
		</div>".$table_div;
			
			
			$pdfuurl = BASE_URL."uploads/".$pdf_fname;

		echo json_encode(array("status" => 1,'table_content' => $htmltd_content,'excel_fname' => $excel_fname,'pdfuurl' => $pdfuurl));
		
		
	}

	public function ledger_creation($report_type = 1){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$ClientDetails = array();
		if($usertype == '5')
		{
			$ClientDetails = $this->client_model->getClientDetails();	
		}
		$current_userid = $client_id;
		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_ledger_year($current_userid,$end_month,$report_type);


		if($report_type == '1'){$report_url = 'invoice_ledger';$ledger_title = 'Invoicing Ledger';$ledger_menu='invoice_ledger';}
		else{$report_url = 'banktrans_ledger';$ledger_title = "Bank Transaction Ledger";$ledger_menu='banktrans_ledger';}


		// echo $this->db->last_query();
		// echo "<pre>";print_r($bank_stat_yr);echo "</pre>";
		$data = array(
					'view_file'=>'ledger_statement',
					'current_menu'=>$ledger_menu,
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'end_month' => $end_month,
					'start_month' => $start_month,
					'bank_stat_yr' => $bank_stat_yr,
					'report_type' => $report_type,
					'ledger_title' => $ledger_title,
					'report_url' => $report_url,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'current_userid' => $current_userid,
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


	public function ajax_ledger(){

		setlocale(LC_MONETARY, 'en_IN');
		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 if($report_type == '1'){$report_url = 'invoice_ledger';$ledger_title = 'Invoicing Ledger';$ledger_menu='invoice_ledger';}
		else{$report_url = 'banktrans_ledger';$ledger_title = "Bank Transaction Ledger";$ledger_menu='banktrans_ledger';}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

	$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = '';
            $next_child = '';
            $loop_start = $array_count = 0;
            if($ReportDetails)
            {
                $total_amount = 0;

                foreach($ReportDetails as $ReportDetail)
                {
                	$report_id = $ReportDetail->report_id;
                   $cost_id = $ReportDetail->cost_id;
                   $subcategory_id = $ReportDetail->subcategory_id;
                   $cost_id = $ReportDetail->cost_id;
                   $amount = $ReportDetail->amount;
                   $description = $ReportDetail->description;
                   $amount_type = $ReportDetail->amount_type;
                   $report_date = $ReportDetail->report_date;
                   $report_date = date('d-M-Y',strtotime($report_date));
                   $ref_no = $ReportDetail->ref_no;
                   $amount = number_format((float)$amount, 2, '.', '');
                   $cost_name = $links = '';
                   if($cost_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $cost_name = $ctcost->cost_name;
                                    $links = $ctcost->links;
                                }
                            }
                        }

                   if($next_child != '' && $next_child != $cost_id)
                   {
                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                    $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
                    $excel_array[] = array( '', '' , '', '', '', '');
                    $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '', '', '', '');$excel_array[] = array( '', '' , '', '', '', '');
                   }

                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;

                        $excel_array[] = array( $child_costname, '' , '');
                        $excel_array[] = array( '', '' , '');
                        $excel_array[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

                        $cost_txt .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }
                   

                   
                  if($report_type == '1')
                  {

		               if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }
	               else  if($report_type == '2')
                  {

		               /*if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses
	                   */

	                   if($amount_type == 'sales') {$cr_amt = $amount;$dr_amount = '';}
			            else{$dr_amount = $amount;$cr_amt = '';}


	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }
	               else
	               {
	               		if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$dr_amount = $amount;$cr_amt='';} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$dr_amount = $amount;$cr_amt='';} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$dr_amount = $amount;$cr_amt='';} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$dr_amount = $amount;$cr_amt='';} //Expenses

	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }


                   
	               



                    $cost_txt .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount1."</td><td  style='text-align:right;'>".$cr_amt1."</td><td  style='text-align:right;'>".$balance."</td></tr>";

                    $excel_array[] = array( $report_date, $ref_no , $description,$dr_amount,$cr_amt,$oformat_amount_xl);
                   $array_count++;

                   



                }

                 $oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

               
                $excel_array[] = array( '', '' , '', '', '', '');
	               $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '', '' , '', '' );$excel_array[] = array( '', '' , '', '', '', '');

            }

            // $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            // $oprofit = "R".number_format((float)$profit, 2);
            // $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            // $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

            // $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
            // $excel_array[] = array( 'Profit', '' , $profit);


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
        $this->excel->getActiveSheet()->setCellValue('A3', 'From '.$start_fulldate.' - '.$end_fulldate);
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

       	for($col = ord('D'); $col <= ord('G'); $col++){ 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
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


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);



		echo $cost_txt;
		exit();
	}

	public function ajax_ledger_invoice(){

		setlocale(LC_MONETARY, 'en_IN');
		$unallocated_difference = 0;
		$profit = 0;
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


		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year=$_POST['year'];
		$inputh_year = $year;
		$years=explode("-",$year);

		$report_url = 'invoice_ledger';$ledger_title = 'Invoicing Ledger';$ledger_menu='invoice_ledger';



		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date,'cost_id' => $sales_cost_id),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5" or report_type = "3")'));
		// echo $this->db->last_query();



		$cost_txt = $cost_txt_sales = $cost_txt_expense = $cost_txt_actrev = '';
		$excel_array = array();
		$excel_arr_sales = array();
		$excel_arr_actrev = array();
		$excel_arr_expense = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

		// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		 $cost_txt_other = '';
        $loop_start = $array_count = 0;
        $sales_total = $expense_total = $actrev_total =  $balance = 0;
        if($ReportDetails)
        {
            $sales_cost_head = $sales_cost_name."(".$sales_cost_link.")";
            $excel_arr_sales[] = array( $sales_cost_head, '' , '');
            $excel_arr_sales[] = array( '', '' , '');
            $excel_arr_sales[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

            $actrev_cost_head = $actrev_cost_name."(".$actrev_cost_link.")";
            $excel_arr_actrev[] = array( $actrev_cost_head, '' , '');
            $excel_arr_actrev[] = array( '', '' , '');
            $excel_arr_actrev[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

            $expense_cost_head = $expense_cost_name."(".$expense_cost_link.")";
            $excel_arr_expense[] = array( $expense_cost_head, '' , '');
            $excel_arr_expense[] = array( '', '' , '');
            $excel_arr_expense[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

            $cost_txt_sales .= "<center><h3>".$sales_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
            $cost_txt_actrev .= "<center><h3>".$actrev_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>"; 
            $cost_txt_expense .= "<center><h3>".$expense_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";

            $previous_child = '';
            $next_child = '';
           
            $total_amount = 0;
            foreach($ReportDetails as $ReportDetail)
            {
                $report_id = $ReportDetail->report_id;
                $cost_id = $ReportDetail->cost_id;
                $subcategory_id = $ReportDetail->subcategory_id;
                $amount = $ReportDetail->amount;
                $description = $ReportDetail->description;
                $amount_type = $ReportDetail->amount_type;
                $report_date = $ReportDetail->report_date;
                $report_date = date('d-M-Y',strtotime($report_date));
                $ref_no = $ReportDetail->ref_no;
                $amount = number_format((float)$amount, 2, '.', '');
                $cost_name = $links = '';

                if($amount_type == 'sales')
                {
			        $sales_total -= (float)$amount;
			        $actrev_total += (float)$amount;

			        $sales_balance = "R".number_format((float)$sales_total, 2);
			        $actrev_balance = "R".number_format((float)$actrev_total, 2);

			        $sales_cr_amt = "R".number_format((float)$amount, 2);
			        $sales_dr_amt = '';

			        $actrev_dr_amt = "R".number_format((float)$amount, 2);
			        $actrev_cr_amt = '';

		            $cost_txt_sales .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$sales_dr_amt."</td><td  style='text-align:right;'>".$sales_cr_amt."</td><td  style='text-align:right;'>".$sales_balance."</td></tr>";

	                $cost_txt_actrev .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$actrev_dr_amt."</td><td  style='text-align:right;'>".$actrev_cr_amt."</td><td  style='text-align:right;'>".$actrev_balance."</td></tr>";

	                $excel_arr_sales[] = array( $report_date, $ref_no , $description,'',$amount,$sales_total);

	                $excel_arr_actrev[] = array( $report_date, $ref_no , $description,$amount,'',$actrev_total);
	             }
	             else if($amount_type == 'expense')
	             {
	             	$expense_total -= (float)$amount;
			        $expense_balance = "R".number_format((float)$expense_total, 2);
			        $expense_cr_amt = "R".number_format((float)$amount, 2);
			        $expense_dr_amt = '';

		            $cost_txt_expense .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$expense_dr_amt."</td><td  style='text-align:right;'>".$expense_cr_amt."</td><td  style='text-align:right;'>".$expense_balance."</td></tr>";

	                $excel_arr_expense[] = array( $report_date, $ref_no , $description,'',$amount,$expense_total);


	                if($cost_id !='' && $cost_id >0)
	                {
	                	$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                        if($catcost)
                        {
                            foreach($catcost as $ctcost)
                            {
                                $cost_name = $ctcost->cost_name;
                                $links = $ctcost->links;
                            }
                        }

                        if($next_child != '' && $next_child != $cost_id)
	                   {
	                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
		               $oformat_amount_xl = $total_amount;
	                    $cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
	                    $excel_array[] = array( '', '' , '', '', '', '');
	                    $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
	                    $excel_array[] = array( '', '' , '', '', '', '');
	                    $excel_array[] = array( '', '' , '', '', '', '');
	                   }

	                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;

                        $excel_array[] = array( $child_costname, '' , '');
                        $excel_array[] = array( '', '' , '');
                        $excel_array[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

                        $cost_txt_other .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }

                   $total_amount += (float)$amount;
			       $balance = "R".number_format((float)$total_amount, 2);
			       $dr_amount = "R".number_format((float)$amount, 2);
			       $cr_amount = '';


                   $cost_txt_other .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount."</td><td  style='text-align:right;'>".$cr_amount."</td><td  style='text-align:right;'>".$balance."</td></tr>";

                    $excel_array[] = array( $report_date, $ref_no , $description,$dr_amount,$cr_amount,$total_amount);



	                }

	             }

            }

            $actrev_oformat_amount = "R".number_format((float)$actrev_total, 2);
	        $oformat_amount_sales = "R".number_format((float)$sales_total, 2);

	        $oformat_amount_expense = "R".number_format((float)$expense_total, 2);

            $cost_txt_actrev .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$actrev_oformat_amount."</td></tr></tfoot></table>";
            $cost_txt_sales .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount_sales."</td></tr></tfoot></table>";

            $cost_txt_expense .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount_expense."</td></tr></tfoot></table>";

            

            $oformat_amount = "R".number_format((float)$total_amount, 2);
            if($cost_txt_other != ''){
            	$cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
            	$excel_array[] = array( '', '' , '', '', '', '');
		        $excel_array[] = array( '', '', '', '', '' , $total_amount);
		        $excel_array[] = array( '', '' , '', '', '', '');
		        $excel_array[] = array( '', '' , '', '', '', '');
            }
            

	        


               
            $excel_arr_sales[] = array( '', '' , '', '', '', '');
	        $excel_arr_sales[] = array( '', '', '', '', '' , $sales_total);
            $excel_arr_sales[] = array( '', '' , '', '' , '', '' );
            $excel_arr_sales[] = array( '', '' , '', '', '', '');

            $excel_arr_actrev[] = array( '', '' , '', '', '', '');
	        $excel_arr_actrev[] = array( '', '', '', '', '' , $actrev_total);
            $excel_arr_actrev[] = array( '', '' , '', '' , '', '' );
            $excel_arr_actrev[] = array( '', '' , '', '', '', '');

            $excel_arr_expense[] = array( '', '' , '', '', '', '');
	        $excel_arr_expense[] = array( '', '', '', '', '' , $expense_total);
            $excel_arr_expense[] = array( '', '' , '', '' , '', '' );
            $excel_arr_expense[] = array( '', '' , '', '', '', '');

        }

        $excel_array = array_merge($excel_arr_actrev,$excel_arr_sales,$excel_arr_expense,$excel_array);

        $cost_txt = $cost_txt.$cost_txt_actrev.$cost_txt_sales.$cost_txt_expense.$cost_txt_other;


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
        $this->excel->getActiveSheet()->setCellValue('A3', 'From '.$start_fulldate.' - '.$end_fulldate);
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

       	for($col = ord('D'); $col <= ord('G'); $col++){ 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
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


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);



		echo $cost_txt;
		exit();
	}	

	public function ledger_pdf(){


		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 if($report_type == '1'){$ledger_title = 'Invoicing Ledger';}
		else{$ledger_title = "Bank Transaction Ledger";}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

	$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = '';
            $next_child = '';
            $loop_start = $array_count = 0;
            if($ReportDetails)
            {
                $total_amount = 0;

                foreach($ReportDetails as $ReportDetail)
                {
                   $cost_id = $ReportDetail->cost_id;
                   $subcategory_id = $ReportDetail->subcategory_id;
                   $cost_id = $ReportDetail->cost_id;
                   $amount = $ReportDetail->amount;
                   $amount_type = $ReportDetail->amount_type;
                   $description = $ReportDetail->description;
                   $report_date = $ReportDetail->report_date;
                   $report_date = date('d-M-Y',strtotime($report_date));
                   $ref_no = $ReportDetail->ref_no;
                   $amount = number_format((float)$amount, 2, '.', '');
                   $cost_name = $links = '';
                   if($cost_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $cost_name = $ctcost->cost_name;
                                    $links = $ctcost->links;
                                }
                            }
                        }

                   if($next_child != '' && $next_child != $cost_id)
                   {
                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                    $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
                    $excel_array[] = array( '', '' , '', '', '', '');
                    $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '', '', '', '');$excel_array[] = array( '', '' , '', '', '', '');
                   }

                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;


                        $cost_txt .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }
                   

                   
                   if($report_type == '1')
                  {

		               if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }
	               else  if($report_type == '2')
                  {

		               /*if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses
	                   */

	                   if($amount_type == 'sales') {$cr_amt = $amount;$dr_amount = '';}
			            else{$dr_amount = $amount;$cr_amt = '';}


	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }
	               else
	               {
	               		if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$dr_amount = $amount;$cr_amt='';} //Current Asset
	                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Current Liabilities
	                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$dr_amount = $amount;$cr_amt='';} //Non-Curent Asset
	                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Non-Current Liabilities
	                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Equity
	                   else if($subcategory_id == '10'){$profit += (float)$amount;$dr_amount = '';$cr_amt=$amount;} //Sales
	                   else if($subcategory_id == '70'){$profit -= (float)$amount;$dr_amount = $amount;$cr_amt='';} //Cost of Sales
	                   else if($subcategory_id == '71'){$profit -= (float)$amount;$dr_amount = $amount;$cr_amt='';} //Expenses

	                   $cr_amt1 = $dr_amount1 = '';
	                   if($cr_amt == ''){
	                   	// $balance = $dr_amount;
	                   	$total_amount += (float)$dr_amount;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	                   else {
	                   	// $balance = $cr_amt;
	                   	$total_amount -= (float)$cr_amt;
	                   	$balance = "R".number_format((float)$total_amount, 2);
	                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
	                   	$oformat_amount_xl = $total_amount;
	                   }
	               }


	               /*if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

                   $cr_amt1 = $dr_amount1 = '';
                   if($cr_amt == ''){
                   	// $balance = $dr_amount;
                   	$total_amount += (float)$dr_amount;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);

                   }
                   else {
                   	// $balance = $cr_amt;
                   	$total_amount -= (float)$cr_amt;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
                   }*/


                   
	               



                    $cost_txt .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount1."</td><td  style='text-align:right;'>".$cr_amt1."</td><td  style='text-align:right;'>".$balance."</td></tr>";



                }

                 $oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

            }

            // $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            // $oprofit = "R".number_format((float)$profit, 2);
            // $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            // $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";


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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}

	public function ledger_pdf_invoice(){


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

		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 $ledger_title = 'Invoicing Ledger';

		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}


		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date,'cost_id' => $sales_cost_id),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
		// echo $this->db->last_query();


	

		$cost_txt = $cost_txt_sales = $cost_txt_expense = $cost_txt_actrev = $cost_txt_other = '';

		$cost_txt = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

		$loop_start = $array_count = 0;
        $sales_total = $actrev_total =  $balance = 0;

        if($ReportDetails)
        {
            $total_amount = 0;
            $sales_cost_head = $sales_cost_name."(".$sales_cost_link.")";
            $actrev_cost_head = $actrev_cost_name."(".$actrev_cost_link.")";
            $expense_cost_head = $expense_cost_name."(".$expense_cost_link.")";

            $cost_txt_sales .= "<center><h3>".$sales_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
           	$cost_txt_actrev .= "<center><h3>".$actrev_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>"; 
           	$cost_txt_expense .= "<center><h3>".$expense_cost_head."</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";

            foreach($ReportDetails as $ReportDetail)
            {
                $report_id = $ReportDetail->report_id;
                $cost_id = $ReportDetail->cost_id;
                $subcategory_id = $ReportDetail->subcategory_id;
                $amount = $ReportDetail->amount;
                $description = $ReportDetail->description;
                $amount_type = $ReportDetail->amount_type;
                $report_date = $ReportDetail->report_date;
                $report_date = date('d-M-Y',strtotime($report_date));
                $ref_no = $ReportDetail->ref_no;
                $amount = number_format((float)$amount, 2, '.', '');
                $cost_name = $links = '';


                if($amount_type == 'sales')
                {
			        $sales_total -= (float)$amount;
			        $actrev_total += (float)$amount;

			        $sales_balance = "R".number_format((float)$sales_total, 2);
			        $actrev_balance = "R".number_format((float)$actrev_total, 2);

			        $sales_cr_amt = "R".number_format((float)$amount, 2);
			        $sales_dr_amt = '';

			        $actrev_dr_amt = "R".number_format((float)$amount, 2);
			        $actrev_cr_amt = '';

		            $cost_txt_sales .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$sales_dr_amt."</td><td  style='text-align:right;'>".$sales_cr_amt."</td><td  style='text-align:right;'>".$sales_balance."</td></tr>";

	                $cost_txt_actrev .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$actrev_dr_amt."</td><td  style='text-align:right;'>".$actrev_cr_amt."</td><td  style='text-align:right;'>".$actrev_balance."</td></tr>";

	             }
	             else if($amount_type == 'expense')
	             {
	             	$expense_total -= (float)$amount;
			        $expense_balance = "R".number_format((float)$expense_total, 2);
			        $expense_cr_amt = "R".number_format((float)$amount, 2);
			        $expense_dr_amt = '';

		            $cost_txt_expense .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$expense_dr_amt."</td><td  style='text-align:right;'>".$expense_cr_amt."</td><td  style='text-align:right;'>".$expense_balance."</td></tr>";



	                if($cost_id !='' && $cost_id >0)
	                {
	                	$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                        if($catcost)
                        {
                            foreach($catcost as $ctcost)
                            {
                                $cost_name = $ctcost->cost_name;
                                $links = $ctcost->links;
                            }
                        }

                        if($next_child != '' && $next_child != $cost_id)
	                   {
	                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
		               $oformat_amount_xl = $total_amount;
	                    $cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

	                   }

	                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;



                        $cost_txt_other .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }

                   $total_amount += (float)$amount;
			       $balance = "R".number_format((float)$total_amount, 2);
			       $dr_amount = "R".number_format((float)$amount, 2);
			       $cr_amount = '';


                   $cost_txt_other .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount."</td><td  style='text-align:right;'>".$cr_amount."</td><td  style='text-align:right;'>".$balance."</td></tr>";




	                }

	             }




                }

                 $actrev_oformat_amount = "R".number_format((float)$actrev_total, 2);
	        $oformat_amount_sales = "R".number_format((float)$sales_total, 2);

	        $oformat_amount_expense = "R".number_format((float)$expense_total, 2);

            $cost_txt_actrev .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$actrev_oformat_amount."</td></tr></tfoot></table>";
            $cost_txt_sales .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount_sales."</td></tr></tfoot></table>";

            $cost_txt_expense .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount_expense."</td></tr></tfoot></table>";

            

            $oformat_amount = "R".number_format((float)$total_amount, 2);
            $cost_txt_other .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

            }

            $cost_txt = $cost_txt.$cost_txt_actrev.$cost_txt_sales.$cost_txt_expense.$cost_txt_other;
// echo "ttttttTT";
            // $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            // $oprofit = "R".number_format((float)$profit, 2);
            // $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            // $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";


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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}

	public function ledger_creation_old($report_type = 1){

		$unallocated_difference = 0;
		$profit = 0;
		// $final_client_id = $this->session->id;
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		$fclient_id = isset($_GET['client_id'])?$_GET['client_id']:'';

		//SELECT sum(amount) as total_amount,category_id,subcategory_id,cost_id FROM `report` where user_id='1' and cost_id !='' group by cost_id order by subcategory_id asc
		$filtered_client_id = $client_id;
		$CostDetails = $this->costcentre_model->getDetails();
		$ClientDetails = $this->client_model->getClientDetails();

		if($report_type == '1'){$report_url = 'invoice_ledger';$ledger_title = 'Invoicing Ledger';$ledger_menu='invoice_ledger';}
		else{$report_url = 'banktrans_ledger';$ledger_title = "Bank Transaction Ledger";$ledger_menu='banktrans_ledger';}

		if($usertype == '5')
		{
			if($fclient_id == '')
			{
				// $final_client_id = $client_id;
				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type),'',array('orderby' => 'subcategory_id,report_date','disporder' => 'asc'));
			}
			else
			{
				$filtered_client_id = $fclient_id;
				// $final_client_id = $fclient_id;
				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $fclient_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
				// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $fclient_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type),'',array('orderby' => 'subcategory_id,report_date','disporder' => 'asc'));
			}
			
		}
		else
		{
			// $final_client_id = $client_id;
			// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => 1),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
			// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type),'',array('orderby' => 'subcategory_id,report_date','disporder' => 'asc'));
		}

		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type),'',array('orderby' => 'cost_id','disporder' => 'asc'));

		// echo $this->db->last_query();


		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_client_name = $cdetl->name;
			}
		}

		$CostDetails_arr = array();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}
// echo "<pre>";print_r($CostDetails_arr);echo "</pre>";
		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><br></div><div class="col-md-12">';

// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = '';
            $next_child = '';
            $loop_start = $array_count = 0;
            if($ReportDetails)
            {
                $total_amount = 0;

                foreach($ReportDetails as $ReportDetail)
                {
                   $cost_id = $ReportDetail->cost_id;
                   $subcategory_id = $ReportDetail->subcategory_id;
                   $cost_id = $ReportDetail->cost_id;
                   $amount = $ReportDetail->amount;
                   $description = $ReportDetail->description;
                   $report_date = $ReportDetail->report_date;
                   $report_date = date('d-M-Y',strtotime($report_date));
                   $ref_no = $ReportDetail->ref_no;
                   $amount = number_format((float)$amount, 2, '.', '');
                   $cost_name = $links = '';
                   if($cost_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $cost_name = $ctcost->cost_name;
                                    $links = $ctcost->links;
                                }
                            }
                        }

                   if($next_child != '' && $next_child != $cost_id)
                   {
                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                    $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";
                    $excel_array[] = array( '', '' , '', '', '', '');
                    $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '', '', '', '');$excel_array[] = array( '', '' , '', '', '', '');
                   }

                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;

                        $excel_array[] = array( $child_costname, '' , '');
                        $excel_array[] = array( '', '' , '');
                        $excel_array[] = array( 'Date', 'RefNo' , 'Details','Dr','Cr','Balance');

                        $cost_txt .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }
                   

                   



	               if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

                   $cr_amt1 = $dr_amount1 = '';
                   if($cr_amt == ''){
                   	// $balance = $dr_amount;
                   	$total_amount += (float)$dr_amount;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
                   	$oformat_amount_xl = $total_amount;
                   }
                   else {
                   	// $balance = $cr_amt;
                   	$total_amount -= (float)$cr_amt;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
                   	$oformat_amount_xl = $total_amount;
                   }


                   
	               



                    $cost_txt .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount1."</td><td  style='text-align:right;'>".$cr_amt1."</td><td  style='text-align:right;'>".$balance."</td></tr>";

                    $excel_array[] = array( $report_date, $ref_no , $description,$dr_amount,$cr_amt,$oformat_amount_xl);
                   $array_count++;

                   



                }

                 $oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

               
                $excel_array[] = array( '', '' , '', '', '', '');
	               $excel_array[] = array( '', '', '', '', '' , $oformat_amount_xl);
                    $excel_array[] = array( '', '' , '', '' , '', '' );$excel_array[] = array( '', '' , '', '', '', '');

            }

            // $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            // $oprofit = "R".number_format((float)$profit, 2);
            // $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            // $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

            // $excel_array[] = array( 'Unallocated Difference', '' , $unallocated_difference);
            // $excel_array[] = array( 'Profit', '' , $profit);


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
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        // $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        // $this->excel->getActiveSheet()->setCellValue('B5', 'Inv No');
        // $this->excel->getActiveSheet()->setCellValue('C5', 'Ref No');
        // $this->excel->getActiveSheet()->setCellValue('D5', 'Description');
        // $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        // $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        // $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        $this->excel->getActiveSheet()->mergeCells('A2:F2');
        // $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         // $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(8);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
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
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('D'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A4');     // insert value to EXCEL

            //$bal_amount = money_format('%!i', $balance_total);
            // $bal_amount = number_format((float)$balance, 2);
            // $final_xl = 'G'.$array_count;
            // $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            // $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            //$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);
			
			
			/********************* EXCEL End ********/
			
			/********************* PDF start ********/
			
			 /*$this->load->library('m_pdf'); 
			 
			 
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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();*/
			
			/********************* PDF END ********/

		//SELECT * FROM `report` where child_costid !='' order by parent_costid,child_costid asc
		$data = array(
					'view_file'=>'invoice_ledger',
					'current_menu'=>$ledger_menu,
					'cusotm_field'=>'invoice_ledger',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Ledger',
					'CostDetails' => $CostDetails_arr,
					'ReportDetails' => $ReportDetails,
					'cost_txt' => $cost_txt,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'fclient_id' => $fclient_id,
					'excel_fname' => $excel_fname,
					'pdf_fname' => $pdf_fname,
					'report_url' => $report_url,
					'report_type' => $report_type,
					'filtered_client_id' => $filtered_client_id,
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

	public function ledger_pdfcreation(){

		$unallocated_difference = 0;
		$profit = 0;
		
		$report_type = $_POST['report_type'];
		$filtered_client_id = $_POST['filtered_client_id'];

	
		$CostDetails = $this->costcentre_model->getDetails();

		if($report_type == '1'){$report_url = 'invoice_ledger';$ledger_title = 'Invoicing Ledger';}
		else{$report_url = 'banktrans_ledger';$ledger_title = "Bank Transaction Ledger";}
		
		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type),'',array('orderby' => 'cost_id','disporder' => 'asc'));
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));


		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_client_name = $cdetl->name;
			}
		}

		$CostDetails_arr = array();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}
// echo "<pre>";print_r($CostDetails_arr);echo "</pre>";
		$cost_txt = '';
		$excel_array = array();
		$cost_txt = '<div id="header"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><br></div><div class="col-md-12">';

// echo "<pre>";print_r($ReportDetails);echo "</pre>";
		$previous_child = '';
            $next_child = '';
            $loop_start = $array_count = 0;
            if($ReportDetails)
            {
                $total_amount = 0;

                foreach($ReportDetails as $ReportDetail)
                {
                   $cost_id = $ReportDetail->cost_id;
                   $subcategory_id = $ReportDetail->subcategory_id;
                   $cost_id = $ReportDetail->cost_id;
                   $description = $ReportDetail->description;
                   $amount = $ReportDetail->amount;
                   $report_date = $ReportDetail->report_date;
                   $report_date = date('d-M-Y',strtotime($report_date));
                   $ref_no = $ReportDetail->ref_no;
                   $amount = number_format((float)$amount, 2, '.', '');
                   $cost_name = $links = '';
                   if($cost_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $cost_name = $ctcost->cost_name;
                                    $links = $ctcost->links;
                                }
                            }
                        }

                   if($next_child != '' && $next_child != $cost_id)
                   {
                   	$oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                    $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

                   }

                   if($previous_child == '' || $previous_child != $cost_id)
                   {
                        $total_amount = 0;
                        $balance = 0;
                        $childcost = $CostDetails_arr[$cost_id];
                        $previous_child = $cost_id;
                        $next_child = $cost_id;
                        $child_costname = $childcost->cost_name;
                        //$links = $childcost->links;


                        $cost_txt .= "<center><h3>".$child_costname."<small>(".$links.")</small></h3></center><table class='table table-striped table-hover stl_costtbl'><thead><tr><th>Date</th><th>RefNo</th><th>Details</th><th  style='text-align:right;'>Dr</th><th  style='text-align:right;'>Cr</th><th  style='text-align:right;'>Balance</th></tr></thead><tbody>";
                   }
                   

	               if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
                   else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
                   else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
                   else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
                   else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
                   else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
                   else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
                   else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

                   $cr_amt1 = $dr_amount1 = '';
                   if($cr_amt == ''){
                   	// $balance = $dr_amount;
                   	$total_amount += (float)$dr_amount;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$dr_amount1 = "R".number_format((float)$dr_amount, 2);
                   	$oformat_amount_xl = $total_amount;
                   }
                   else {
                   	// $balance = $cr_amt;
                   	$total_amount -= (float)$cr_amt;
                   	$balance = "R".number_format((float)$total_amount, 2);
                   	$cr_amt1 = "R".number_format((float)$cr_amt, 2);
                   	$oformat_amount_xl = $total_amount;
                   }


                    $cost_txt .= "<tr><td>".$report_date."</td><td>".$ref_no."</td><td>".$description."</td><td  style='text-align:right;'>".$dr_amount1."</td><td  style='text-align:right;'>".$cr_amt1."</td><td  style='text-align:right;'>".$balance."</td></tr>";



                }

                 $oformat_amount = "R".number_format((float)$total_amount, 2);
	               $oformat_amount_xl = $total_amount;
                $cost_txt .= "</tbody><tfoot><tr><td colspan='6' style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";


            }

            // $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
            // $oprofit = "R".number_format((float)$profit, 2);
            // $cost_txt .= "<p><b>Unallocated Difference: </b>".$ounallocated_difference."</p>";
            // $cost_txt .= "<p><b>Profit: </b>".$oprofit."</p>";

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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/

			echo json_encode(array('success'=>1));

	}



	/******************** financial statement creation *********************/
	public function financial_statement_creation($report_type = 1){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$ClientDetails = array();
		if($usertype == '5')
		{
			$ClientDetails = $this->client_model->getClientDetails();	
		}
		$current_userid = $client_id;
		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_finanlstat_year($current_userid,$end_month,$report_type);


		if($report_type == '1'){$report_url = 'invoice_financial';$ledger_title = 'Invoicing Financial';$ledger_menu='invoice_financial';}
		else{$report_url = 'banktrans_financial';$ledger_title = "Bank Transaction Financial";$ledger_menu='banktrans_financial';}


		// echo $this->db->last_query();
		// echo "<pre>";print_r($bank_stat_yr);echo "</pre>";
		$data = array(
					'view_file'=>'financial_statement',
					'current_menu'=>$ledger_menu,
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'end_month' => $end_month,
					'start_month' => $start_month,
					'bank_stat_yr' => $bank_stat_yr,
					'report_type' => $report_type,
					'ledger_title' => $ledger_title,
					'report_url' => $report_url,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'current_userid' => $current_userid,
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


	public function ajax_financial_statement(){

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();

		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;
		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0,'array_libt_ct' => 0,'array_eqt_ct' => $array_eqt_ct,'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 if($report_type == '1'){$report_url = 'invoice_financial';$ledger_title = 'Invoicing Financial';$ledger_menu='invoice_financial';}
		else{$report_url = 'banktrans_financial';$ledger_title = "Bank Transaction Financial";$ledger_menu='banktrans_financial';}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

	$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

		// $subcat_id_arr = array('5','7','6','8','9','10','70','71');
		// $subcat_id_arr = array('5','7','6','8','10','70','71');


		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot= array();


		$subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		

foreach($subcat_id_loop as $sup_key  => $subcat_id_arr){

// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

		foreach($subcat_id_arr as $subcat_id_ar)
		{
			
			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));
			
			

			// echo $this->db->last_query();

			$total_amount = 0;
            $childcost = $CostDetails_arr[$subcat_id_ar];
            $child_costname = $childcost->cost_name;

            if($ReportDetails){
				${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
				${"excel_array_" . $sup_key}[] = array( $child_costname, '' , '');
	            ${"excel_array_" . $sup_key}[] = array( '', '' , '');
	            ${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

	            $excel_titlearr[] = $excel_arrcount;
                        $excel_arrcount += 2;
                        $excele_tablearr[] = $excel_arrcount;
                        $excel_arrcount += 1;


				foreach ($ReportDetails as $ReportDetail) {
					$cost_id = $ReportDetail->cost_id;
	                $subcategory_id = $ReportDetail->subcategory_id;
	                $amount = $ReportDetail->total_amount;
	                $amount_cr = $ReportDetail->TotalCR;
	                $amount_dr = $ReportDetail->TotalDR;
	                $amount = (float)$amount_dr - (float)$amount_cr;
	                $amount = number_format((float)$amount, 2, '.', '');
	                $cost_name = $links = '';
	                if($cost_id !='')
	                {
	                    $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
	                    if($catcost)
	                    {
	                        foreach($catcost as $ctcost)
	                        {
	                            $cost_name = $ctcost->cost_name;
	                            $links = $ctcost->links;
	                        }
	                    }
	                }

	                $total_amount += (float)$amount;


	                $oformat_amount = "R".number_format((float)$amount, 2);
		            $oformat_amount_xl = $amount;

		            if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

	                ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
	                ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

	                // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
                    $excel_arrcount++;

				}

				$oformat_amount = "R".number_format((float)$total_amount, 2);
	            $oformat_amount_xl = $total_amount;
                ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

                $excel_tfoot[] = $excel_arrcount;

                ${"excel_array_" . $sup_key}[] = array( 'Total', '' , $oformat_amount_xl);
                ${"excel_array_" . $sup_key}[] = array( '', '' , '');${"excel_array_" . $sup_key}[] = array( '', '' , '');

                $excel_tfoot[] = $excel_arrcount;
            $excel_arrcount += 3;
            


           		if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
           		if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }
	           

	              


        	}


        	}

if($sup_key == 'asset')
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

}




		}


		

	            	


$unallocated_difference = 0;
		
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
        $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');





		$tax = (((float)$profit*28 )/100);
		$otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R".number_format((float)$profit_tax, 2);


		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";


		$excel_appd_arr['final_ct'] = $excel_arrcount; 
        $excel_array_final[] = array( 'Profit Before Taxation', '' , $profit);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
        $excel_array_final[] = array( 'Taxation', '' , $tax);
        $excel_arrcount++;
        $excel_array_final[] = array( 'Profit After Taxation', '' , $profit_tax);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
       
$subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

       $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;
           
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
        $this->excel->getActiveSheet()->setCellValue('A3', 'From '.$start_fulldate.' - '.$end_fulldate);
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

       	for($col = ord('C'); $col <= ord('G'); $col++){ 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

        	foreach($excel_titlearr as $val)
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
        }


// $excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0,'array_libt_ct' => 0,'array_eqt_ct' => $array_eqt_ct,'other_ct' => $other_ct, 'final_ct' => $final_ct);

            $this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4'); 
            $this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A'.$excel_appd_arr['total_ast_ct']);  
            $this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A'.$excel_appd_arr['array_libt_ct']); 
            $this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A'.$excel_appd_arr['array_eqt_ct']); 
            $this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A'.$excel_appd_arr['other_ct']);  
            $this->excel->getActiveSheet()->fromArray($excel_array_final, null, 'A'.$excel_appd_arr['final_ct']);
  




            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');


			$objWriter->save(FCPATH.'uploads/'.$excel_fname);



		echo $cost_txt;
		exit();
	}	

	public function financial_statement_pdf(){

		$unallocated_difference = $profit = 0;
		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 if($report_type == '1'){$ledger_title = 'Invoicing Ledger';}
		else{$ledger_title = "Bank Transaction Ledger";}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		// echo "<pre>";print_r($CurrentClientDetails);echo "</pre>";
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

	$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';


$subcat_id_arr = array('5','7','6','8','9','10','70','71');

		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_tfoot= array();




		$subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		

foreach($subcat_id_loop as $sup_key  => $subcat_id_arr){

// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

		foreach($subcat_id_arr as $subcat_id_ar)
		{
			// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));

			$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id, Sum(Case When amount_type = "sales" Then amount Else 0 End) TotalCR,Sum(Case When amount_type != "sales" Then amount Else 0 End) TotalDR',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id'));


			$total_amount = 0;
            $childcost = $CostDetails_arr[$subcat_id_ar];
            $child_costname = $childcost->cost_name;

            if($ReportDetails){
				${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";



				foreach ($ReportDetails as $ReportDetail) {
					$cost_id = $ReportDetail->cost_id;
	                $subcategory_id = $ReportDetail->subcategory_id;
	                $amount = $ReportDetail->total_amount;
	                $amount_cr = $ReportDetail->TotalCR;
	                $amount_dr = $ReportDetail->TotalDR;
	                $amount = (float)$amount_dr - (float)$amount_cr;
	                $amount = number_format((float)$amount, 2, '.', '');
	                $cost_name = $links = '';
	                if($cost_id !='')
	                {
	                    $catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
	                    if($catcost)
	                    {
	                        foreach($catcost as $ctcost)
	                        {
	                            $cost_name = $ctcost->cost_name;
	                            $links = $ctcost->links;
	                        }
	                    }
	                }

	                $total_amount += (float)$amount;
	                $oformat_amount = "R".number_format((float)$amount, 2);
		            $oformat_amount_xl = $amount;

		            if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
	                else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
	                else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
	                else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
	                else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
	                else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
	                else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
	                else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

	                ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";


				}

				$oformat_amount = "R".number_format((float)$total_amount, 2);
	            $oformat_amount_xl = $total_amount;
                ${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";



           		if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
           		if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }
	           

	              


        	}


        	}


		}



		$total_assets = "R".number_format((float)$total_asset, 2);
	            	$total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>".$total_assets."</th></tr></tbody></table>";


$unallocated_difference = 0;
		
		 $ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
        $oprofit = "R".number_format((float)$profit, 2);

        $total_quity_xl = (float)$unallocated_difference+(float)$profit;
        $ototal_quity = "R".number_format((float)$total_quity_xl, 2);



        $total_unalloc_xl = (float)$total_asset-(float)$total_libeqt_xl;
        $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);


		// $qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Unallocated Difference</td><td>q.200.000</td><td  style='text-align:right;'>".$ounallocated_difference."</td></tr><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";
		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$total_libeqt_xl = (float)$total_quity_xl+(float)$total_liabilities;
		$ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' ><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";


		$tax = (((float)$profit*28 )/100);
		$otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R".number_format((float)$profit_tax, 2);

		// echo "profit = ".$profit." = tax = ".$tax." = profit_tax = ".$profit_tax;

		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";


       $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;
           






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
   
			$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			$this->m_pdf->pdf->WriteHTML($html);
  
   
			$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
			$this->output->set_output('');
			ob_end_flush();
			ob_start();
			
			/********************* PDF END ********/

		echo json_encode(array('message' => 'success'));
		exit();
	}


	public function ajax_financial_statement_invoice(){

		setlocale(LC_MONETARY, 'en_IN');
		$excel_array_final = $excel_array_asset = $excel_array_total_ast = $excel_array_libt = $excel_array_eqt = $excel_array_other = array();
		$final_ct = $asset_ct = $total_ast_ct = $array_libt_ct = $array_eqt_ct = $other_ct = 0;

		$excel_appd_arr = array('asset_ct' => 4, 'total_ast_ct' => 0,'array_libt_ct' => 0,'array_eqt_ct' => $array_eqt_ct,'other_ct' => $other_ct, 'final_ct' => $final_ct);

		$unallocated_difference = 0;
		$profit = 0;
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];
		// $start_month = $_POST['start_month'];
		// $end_month = $_POST['end_month'];

		$year=$_POST['year'];
		$inputh_year = $year;
		$years=explode("-",$year);

		if($report_type == '1'){$report_url = 'invoice_financial';$ledger_title = 'Invoicing Financial';$ledger_menu='invoice_financial';}
		else{$report_url = 'banktrans_financial';$ledger_title = "Bank Transaction Financial";$ledger_menu='banktrans_financial';}


		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$start_date = date('Y-m-d');

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		// $ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));
		// echo $this->db->last_query();


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();

		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_assetfoot = $excel_ttfoot = $excel_tfoot= array();


		$subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

		
		// echo "<pre>";print_r($subcat_id_loop);echo "</pre>";
		foreach($subcat_id_loop as $sup_key  => $subcat_id_arr){

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach($subcat_id_arr as $subcat_id_ar)
			{
				if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID)
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'amount_type','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				else if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID)
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'amount_type' => 'expense','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'amount_type','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				else
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				
				
				// echo $this->db->last_query();

				$total_amount = 0;
            	$childcost = $CostDetails_arr[$subcat_id_ar];
            	$child_costname = $childcost->cost_name;

            	if($ReportDetails){
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";
					${"excel_array_" . $sup_key}[] = array( $child_costname, '' , '');
	            	${"excel_array_" . $sup_key}[] = array( '', '' , '');
	            	${"excel_array_" . $sup_key}[] = array( 'Cost Name', 'Links' , 'Amount');

	            	$excel_titlearr[] = $excel_arrcount;
                    $excel_arrcount += 2;
                    $excele_tablearr[] = $excel_arrcount;
                    $excel_arrcount += 1;


					foreach ($ReportDetails as $ReportDetail) {
						if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID){$cost_id = ACT_RECEIVABLE_COST_ID;$subcategory_id = ACT_RECEIVABLE_COST_SUBCAT_ID;}
						else if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID){$cost_id = EXPENSE_COST_ID;$subcategory_id = EXPENSE_COST_SUBCAT_ID;}
						else
						{
							$cost_id = $ReportDetail->cost_id;
	                		$subcategory_id = $ReportDetail->subcategory_id;
						}
						
	                	$amount = $ReportDetail->total_amount;
	                	$amount = number_format((float)$amount, 2, '.', '');
	                	$cost_name = $links = '';
	                	if($cost_id !='')
	                	{
	                    	$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
	                    	if($catcost)
	                    	{
	                        	foreach($catcost as $ctcost)
	                        	{
	                            	$cost_name = $ctcost->cost_name;
	                            	$links = $ctcost->links;
	                        	}
	                    	}
	                	}
	                	
	                	$total_amount += (float)$amount;
	                	$oformat_amount = "R".number_format((float)$amount, 2);
		            	$oformat_amount_xl = $amount;

			            if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
		                else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
		                else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
		                else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
		                else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
		                else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
		                else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
		                else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

		                ${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
		                ${"excel_array_" . $sup_key}[] = array( $cost_name, $links , $oformat_amount_xl);

		                // $excel_array[] = array( $cost_name, $links , $oformat_amount_xl);
	                    $excel_arrcount++;

					}

					$oformat_amount = "R".number_format((float)$total_amount, 2);
	            	$oformat_amount_xl = $total_amount;
                	${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

                	$excel_tfoot[] = $excel_arrcount;

                	${"excel_array_" . $sup_key}[] = array( 'Total', '' , $oformat_amount_xl);
                	${"excel_array_" . $sup_key}[] = array( '', '' , '');${"excel_array_" . $sup_key}[] = array( '', '' , '');

                	$excel_tfoot[] = $excel_arrcount;
            		$excel_arrcount += 3;

           			if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
           			if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }
        		}
        	}

			if($sup_key == 'asset')
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

			}
		}

		$unallocated_difference = 0;
		
		$ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
        $oprofit = "R".number_format((float)$profit, 2);

        $total_quity_xl = (float)$unallocated_difference+(float)$profit;
        $ototal_quity = "R".number_format((float)$total_quity_xl, 2);

        $total_libeqt_xl = (float)$total_quity_xl+(float)$total_liabilities;
		$ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);

		$total_unalloc_xl = (float)$total_asset-(float)$total_libeqt_xl;
        $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' style=''><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";


		$excel_array_eqt[] = array( 'Equity', '' , '');
	    $excel_array_eqt[] = array( '', '' , '');
	    $excel_array_eqt[] = array( 'Cost Name', 'Links' , 'Amount');
		// $excel_array_eqt[] = array( 'Unallocated Difference', 'q.200.000' , $unallocated_difference);
		$excel_array_eqt[] = array( 'Profit', 'q.200.000' , $profit);
		$excel_array_eqt[] = array( 'Total', '' , $total_quity_xl);
        $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');
        $excel_array_eqt[] = array( 'Total Liabilities and Equity', '' , $total_libeqt_xl);
        $excel_array_eqt[] = array( 'Unallocated Difference', '' , $total_unalloc_xl);
        $excel_array_eqt[] = array( '', '' , '');$excel_array_eqt[] = array( '', '' , '');

		$tax = (((float)$profit*28 )/100);
		$otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R".number_format((float)$profit_tax, 2);

		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";

		$excel_appd_arr['final_ct'] = $excel_arrcount; 
        $excel_array_final[] = array( 'Profit Before Taxation', '' , $profit);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
        $excel_array_final[] = array( 'Taxation', '' , $tax);
        $excel_arrcount++;
        $excel_array_final[] = array( 'Profit After Taxation', '' , $profit_tax);
        $excel_ttfoot[] = $excel_arrcount;$excel_arrcount++;
       
		$subcat_id_loop = array(array('asset' => '5','7'),array('libt' => '6','8'),array('other'=>'10','70','71'));

       $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

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
        $this->excel->getActiveSheet()->setCellValue('A3', 'From '.$start_fulldate.' - '.$end_fulldate);
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

       	for($col = ord('C'); $col <= ord('G'); $col++){ 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
        for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
        }

        foreach($excel_titlearr as $val)
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
        }

        $this->excel->getActiveSheet()->fromArray($excel_array_asset, null, 'A4'); 
        $this->excel->getActiveSheet()->fromArray($excel_array_total_ast, null, 'A'.$excel_appd_arr['total_ast_ct']);  
        $this->excel->getActiveSheet()->fromArray($excel_array_libt, null, 'A'.$excel_appd_arr['array_libt_ct']); 
        $this->excel->getActiveSheet()->fromArray($excel_array_eqt, null, 'A'.$excel_appd_arr['array_eqt_ct']); 
        $this->excel->getActiveSheet()->fromArray($excel_array_other, null, 'A'.$excel_appd_arr['other_ct']);  
        $this->excel->getActiveSheet()->fromArray($excel_array_final, null, 'A'.$excel_appd_arr['final_ct']);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
        $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
   
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save(FCPATH.'uploads/'.$excel_fname);

		echo $cost_txt;
		exit();
	}

	public function financial_statement_pdf_invoice(){

		$unallocated_difference = $profit = 0;
		setlocale(LC_MONETARY, 'en_IN');
		$cbd_txt_pdf  = '';
		$cbd_txt = '';
		$filtered_client_id= $_POST['client_id'];
		$report_type = $_POST['report_type'];

		 $year=$_POST['year'];
		 $inputh_year = $year;
		 $years=explode("-",$year);

		 if($report_type == '1'){$ledger_title = 'Invoicing Ledger';}
		else{$ledger_title = "Bank Transaction Ledger";}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $filtered_client_id,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$filtered_start_month = $cdetl->financial_month_start;
				$filtered_end_month = $cdetl->financial_month_end;
				$filtered_client_name = $cdetl->name;
			}
		}

		$start_monthName = date('F', mktime(0, 0, 0, $filtered_start_month, 10)); 
		$end_monthName = date('F', mktime(0, 0, 0, $filtered_end_month, 10));

		$ts = strtotime($end_monthName.' '.$years[1]);
		$end_monthName_date = date('t', $ts);
		 
		$start_fulldate = $start_monthName.' 1, '.$years[0];
		$end_fulldate = $end_monthName.' '.$end_monthName_date.', '.$years[1];

		$full_details = [];

		$year_start = $years[0];
		$year_end = $years[1];


		$start_date = $year_start."-".$filtered_start_month."-01";
		$end_date = $year_end."-".$filtered_end_month."-01";
		$end_date = date('Y-m-t',strtotime($end_date));

		$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));


		$CostDetails_arr = array();
		$CostDetails = $this->costcentre_model->getDetails();
		if($CostDetails)
		{
			foreach($CostDetails as $CostDetail)
			{
				$cost_id = $CostDetail->cost_id;
				$CostDetails_arr[$cost_id] = $CostDetail;
			}
		}

		$cost_txt = '';
		$excel_array = array();
		$cost_txt_start = '<div id="header"><input type="hidden" class="inputh_year" value="'.$inputh_year.'"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;    text-transform: capitalize;">'.$filtered_client_name.'</p><p style="text-align: center;font-size:13px;    margin: 10px 0px;font-weight: bold;">'.$ledger_title.' </p><p style="text-align: center;font-size:13px;margin: 10px 0px;">From '.$start_fulldate.' - '.$end_fulldate.'</p><br></div><div class="col-md-12">';


		$subcat_id_arr = array('5','7','6','8','9','10','70','71');

		//$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'report_type' => $report_type,'report_date >=' => $start_date,'report_date <= ' => $end_date),'',array('orderby' => 'cost_id,report_date','disporder' => 'asc'));

		$total_asset = $total_liabilities = 0;
		$excel_arrcount = 4;
		$excel_titlearr = $excele_tablearr = $excel_tfoot= array();

		$subcat_id_loop = array('asset' => array('5','7'),'libt' => array('6','8'),'other'=>array('10','70','71'));

	
		foreach($subcat_id_loop as $sup_key  => $subcat_id_arr){

			// echo "subcat_id_arr = ".$subcat_id_arr;
			${"cost_txt_" . $sup_key} = '';

			foreach($subcat_id_arr as $subcat_id_ar)
			{
				if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID)
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'amount_type' => 'sales','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'amount_type','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				else if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID)
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'status' => 1,'amount_type' => 'expense','report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'amount_type','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}
				else
				{
					$ReportDetails = $this->reports_model->getDetails('report',array('user_id' => $filtered_client_id,'cost_id !=' => '','status' => 1,'subcategory_id' => $subcat_id_ar,'report_date >=' => $start_date,'report_date <= ' => $end_date),'sum(amount) as total_amount,category_id,subcategory_id,cost_id',array('orderby' => 'subcategory_id','disporder' => 'asc','groupby' => 'cost_id','custom_where' => '(report_type="1" or report_type = "7" or report_type = "5")'));
				}


				$total_amount = 0;
            	$childcost = $CostDetails_arr[$subcat_id_ar];
            	$child_costname = $childcost->cost_name;

            	if($ReportDetails){
					${"cost_txt_" . $sup_key} .= "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>".$child_costname."</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody>";

					foreach ($ReportDetails as $ReportDetail) {
						if($subcat_id_ar == ACT_RECEIVABLE_COST_SUBCAT_ID){$cost_id = ACT_RECEIVABLE_COST_ID;$subcategory_id = ACT_RECEIVABLE_COST_SUBCAT_ID;}
						else if($subcat_id_ar == EXPENSE_COST_SUBCAT_ID){$cost_id = EXPENSE_COST_ID;$subcategory_id = EXPENSE_COST_SUBCAT_ID;}
						else
						{
							$cost_id = $ReportDetail->cost_id;
	                		$subcategory_id = $ReportDetail->subcategory_id;
						}
	                	$amount = $ReportDetail->total_amount;
	                	$amount = number_format((float)$amount, 2, '.', '');
	                	$cost_name = $links = '';
	                	if($cost_id !='')
	                	{
	                    	$catcost = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));
	                    	if($catcost)
	                    	{
	                        	foreach($catcost as $ctcost)
	                        	{
	                            	$cost_name = $ctcost->cost_name;
	                            	$links = $ctcost->links;
	                        	}
	                    	}
	                	}

	                	$total_amount += (float)$amount;
	                	$oformat_amount = "R".number_format((float)$amount, 2);
		            	$oformat_amount_xl = $amount;

			            if($subcategory_id == '5'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Current Asset
		                else if($subcategory_id == '6'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Current Liabilities
		                else if($subcategory_id == '7'){$unallocated_difference += (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Non-Curent Asset
		                else if($subcategory_id == '8'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Non-Current Liabilities
		                else if($subcategory_id == '9'){$unallocated_difference -= (float)$amount;$cr_amt = $amount;$dr_amount='';} //Equity
		                else if($subcategory_id == '10'){$profit += (float)$amount;$cr_amt = $amount;$dr_amount='';} //Sales
		                else if($subcategory_id == '70'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Cost of Sales
		                else if($subcategory_id == '71'){$profit -= (float)$amount;$cr_amt = '';$dr_amount=$amount;} //Expenses

	                	${"cost_txt_" . $sup_key} .= "<tr><td>".$cost_name."</td><td>".$links."</td><td  style='text-align:right;'>".$oformat_amount."</td></tr>";
					}

					$oformat_amount = "R".number_format((float)$total_amount, 2);
	            	$oformat_amount_xl = $total_amount;
                	${"cost_txt_" . $sup_key} .= "</tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$oformat_amount."</td></tr></tfoot></table>";

           			if($subcat_id_ar == '5' || $subcat_id_ar == '7'){ $total_asset += $total_amount; }
           			if($subcat_id_ar == '6' || $subcat_id_ar == '8'){ $total_liabilities += $total_amount; }    
        		}
        	}
		}

		$total_assets = "R".number_format((float)$total_asset, 2);
	    $total_assets_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Asset</th><th style='text-align:right;font-size:18px;'>".$total_assets."</th></tr></tbody></table>";

		$unallocated_difference = 0;
		
		$ounallocated_difference = "R".number_format((float)$unallocated_difference, 2);
        $oprofit = "R".number_format((float)$profit, 2);

        $total_quity_xl = (float)$unallocated_difference+(float)$profit;
        $ototal_quity = "R".number_format((float)$total_quity_xl, 2);

        $total_unalloc_xl = (float)$total_asset-(float)$total_libeqt_xl;
        $ototal_unalloc = "R".number_format((float)$total_unalloc_xl, 2);

		$qut_txt = "<p style='margin-top: 0px;font-size: 17px;font-weight: bold;    margin-bottom: 2px;'>Equity</p><table class='table table-striped table-hover stl_costtbl'><thead><tr><th  style='width:60%;'>Cost Name</th><th  style='width:15%;'>Links</th><th  style='width:25%;text-align:right;'>Amount</th></tr></thead><tbody><tr><td>Profit</td><td>q.200.000</td><td  style='text-align:right;'>".$oprofit."</td></tr></tbody><tfoot><tr><td colspan='2'>Total</td><td  style='text-align:right;'>".$ototal_quity."</td></tr></tfoot></table>";

		$total_libeqt_xl = (float)$total_quity_xl+(float)$total_liabilities;
		$ototal_libeqt = "R".number_format((float)$total_libeqt_xl, 2);

		$totallibeqt_txt = "<table class='table table-striped table-hover stl_costtbl' ><tbody><tr><th  colspan='2' style='font-size:18px;'>Total Liabilities and Equity</th><th style='text-align:right;font-size:18px;'>".$ototal_libeqt."</th></tr></tbody></table>";

		$totallibeqt_txt .= "<p style='text-align:right;    font-size: 12px;font-style: italic;'>Unallocated Difference &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ototal_unalloc."</p>";

		$tax = (((float)$profit*28 )/100);
		$otax = "R".number_format((float)$tax, 2);
		$profit_tax = (float)$profit - (float)$tax;
		$oprofit_tax = "R".number_format((float)$profit_tax, 2);

		$final_txt = "<table class='table table-striped table-hover stl_costtbl'><tbody><tr><th  colspan='2'>Profit Before Taxation</th><th style='text-align:right;'>".$oprofit."</th></tr><tr><td  colspan='2'>Taxation</td><td style='text-align:right;'>".$otax."</td></tr><tr><th  colspan='2'>Profit After Taxation</th><th style='text-align:right;'>".$oprofit_tax."</th></tr></tbody></table>";

       $cost_txt =  $cost_txt_start." ".$cost_txt_asset." ".$total_assets_txt." ".$cost_txt_libt ." ".$qut_txt." ".$totallibeqt_txt." ".$cost_txt_other." ".$final_txt;

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
   
		$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf->WriteHTML($html);
   
		$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
		$this->output->set_output('');
		ob_end_flush();
		ob_start();
		
		/********************* PDF END ********/
		echo json_encode(array('message' => 'success'));
		exit();
	}
	/********************* financial statement creation end *************/

}
