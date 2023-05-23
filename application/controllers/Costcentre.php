<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Costcentre extends CI_Controller {

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
		$this->load->model('costcentre_model');
		$this->load->model('client_model');
		$this->load->model('reports_model');

		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
		$this->load->helper('url');
		 $this->load->library('excel');
	}
	public function index(){
		//$client_id= $this->session->id;
		//$usertype= $this->session->usertype;
		//if($usertype == '5')

		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}

		//$CostDetails = $this->costcentre_model->getDetails();	

		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		if($usertype == '5')
		{
			if($fclient_id == '')
			{
				$CostDetails = $this->costcentre_model->getDetails(array('status' => 1,'user_id' => $client_id, 'category_id !=' => '', 'subcategory_id !=' => ''));
			}
			else
			{
				$CostDetails = $this->costcentre_model->getDetails(array('status' => 1,'user_id' => $fclient_id, 'category_id !=' => '', 'subcategory_id !=' => ''));
			}
			
		}
			
		else
		{
			$CostDetails = $this->costcentre_model->getDetails(array('user_id' => $client_id,'status' => 1, 'category_id !=' => '', 'subcategory_id !=' => ''));
		}
		
		$Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));

		$activeuserdetails = $this->costcentre_model->getDetailsCommon('usermaster',array('id' => $client_id));

		$data = array(
					'view_file'=>'show_costcentre',
					'current_menu'=>'show_costcentre',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'CostDetails' => $CostDetails,
					'usertype' => $usertype,
					'ClientDetails' => $ClientDetails,
					'fclient_id' => $fclient_id,
					'activeuserdetails' => $activeuserdetails,
					'Sets' => $Sets,
					'page_slug' => 'index',
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
	public function show_ccsets(){
		//$client_id= $this->session->id;
		//$usertype= $this->session->usertype;
		//if($usertype == '5')
		$usertype= $this->session->usertype;
		$CostsetDetails = '';
		if($usertype == '5')
		{
			$CostsetDetails = $this->costcentre_model->getDetailsCommon('costcentre_set');
		}
		else
		{
			redirect(BASE_URL.'costcentre/');
		}
		
		$data = array(
					'view_file'=>'show_ccsets',
					'current_menu'=>'show_ccsets',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'CostsetDetails' => $CostsetDetails,
					'usertype' => '',
					'ClientDetails' => '',
					'fclient_id' => '',
					'page_slug' => 'show_ccsets',
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
	public function add_costset(){
		
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$CostSetDetail ='';

		$filtered_client_id= $this->session->id;
		$data = array(
					'view_file'=>'add_costset',
					'current_menu'=>'add_costset',
					'cusotm_field'=>'add_costset',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Add',
					'form_action' => 'save_costset',
					'CostSetDetail' => $CostSetDetail,
					'usertype' => $usertype,
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
	public function edit_costset($set_id = ''){	
		//echo "<pre>";print_r($this->session);echo "</pre>";
		$filtered_client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$CostSetDetail = '';
		if($set_id !='' )
		$CostSetDetail = $this->costcentre_model->getDetailsCommon('costcentre_set',array('set_id' => $set_id));	
		

		$data = array(
					'view_file'=>'add_costset',
					'current_menu'=>'add_costset',
					'cusotm_field'=>'add_costset',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Edit',
					'form_action' => 'save_costset',
					'CostSetDetail' => $CostSetDetail,
					'usertype' => $usertype,
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
	public function save_costset(){

		$set_id = $_POST['set_id'];
		$set_name = $_POST['set_name'];
		$status = $_POST['status'];

		$cost_array = array( 'set_name' => $set_name,'status' => $status);
		if($set_id == '')
		{
			$cost_array['created_on'] = date('Y-m-d H:i:s');
			$set_id = $this->costcentre_model->Insert_common('costcentre_set',$cost_array);			
		}
		else
		{
			$where_array = array('set_id' => $set_id);
			$cost_array['modified_on'] = date('Y-m-d H:i:s');			
			$this->costcentre_model->Update_common('costcentre_set',$cost_array,$where_array);
		}

		$this->session->set_flashdata('costcentre', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Cost Set Saved Successfully</span></div>');
		redirect(BASE_URL.'costcentre/add_costset');
		
	}
	public function delete_ccsets($set_id =''){
		if($set_id !='')
		{
			$this->costcentre_model->Delete_common('costcentre_set',array('set_id' => $set_id));
			//echo $this->db->last_query();
		}
		$this->session->set_flashdata('costcentre', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Selected Cost Centre Set Deleted Successfully</span></div>');
		redirect(BASE_URL.'costcentre/show_ccsets');
		
	}
	public function show_category(){
		//$client_id= $this->session->id;
		//$usertype= $this->session->usertype;
		//if($usertype == '5')
		$usertype= $this->session->usertype;
		$CostDetails = '';
		if($usertype == '5')
		{
			$CostDetails = $this->costcentre_model->getDetails(array('status' => 1, 'category_id' => ''));
		}
		else
		{
			redirect(BASE_URL.'costcentre/');
		}
		
		$data = array(
					'view_file'=>'show_category',
					'current_menu'=>'show_category',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'CostDetails' => $CostDetails,
					'usertype' => '',
					'ClientDetails' => '',
					'fclient_id' => '',
					'page_slug' => 'show_category',
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
	public function show_subcategory(){
		//$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$CostDetails = '';
		if($usertype == '5')
		{
		$CostDetails = $this->costcentre_model->getDetails(array('subcategory_id' => '','category_id !=' => ''));
		}
		else
		{
			redirect(BASE_URL.'costcentre/');
		}
		
		$data = array(
					'view_file'=>'show_subcategory',
					'current_menu'=>'show_subcategory',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'CostDetails' => $CostDetails,
					'usertype' => '',
					'ClientDetails' => '',
					'fclient_id' => '',
					'page_slug' => 'show_subcategory',
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
	
	
	public function add_costcentre(){
		
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;


		//$CostDetails = $this->costcentre_model->getDetails(array('user_id' => $client_id,'parent_cost' => ''));

		

		$Categories = $this->costcentre_model->getDetails(array('category_id' => ''));	

		$subcategories = array();
		if($Categories)
		{
			foreach($Categories as $category)
			{
				$cost_id = $category->cost_id;
				$SubCost = $this->costcentre_model->getDetails(array('category_id' => $cost_id,'subcategory_id' => ''));	
				$subcategories[$cost_id] = $SubCost;
			}
		}

		$Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		// else
		// {
		// 	$CostDetails = $this->costcentre_model->getDetails(array('user_id' => $client_id,'parent_cost' => ''));
		// }

		$CostDetail ='';
		//echo "<pre>";print_r($this->session);echo "</pre>";
		$filtered_client_id= $this->session->id;
		$data = array(
					'view_file'=>'add_costcentre',
					'current_menu'=>'add_costcentre',
					'cusotm_field'=>'add_costcentre',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Add',
					'form_action' => 'save_cost',
					'user_id' => $filtered_client_id,
					'CostDetail' => $CostDetail,
					//'CostDetails' => $CostDetails,
					'Categories' => $Categories,
					'subcategories' => $subcategories,
					'cost_formact' => 'add_cost',
					'usertype' => $usertype,
					'Sets' => $Sets,
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
	public function edit_costcentre($cost_id = ''){	
		//echo "<pre>";print_r($this->session);echo "</pre>";
		$filtered_client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$CostDetail = '';
		if($cost_id !='' )
		$CostDetail = $this->costcentre_model->getDetails(array('cost_id' => $cost_id));	
		
		//$client_id= $this->session->id;
		//$usertype= $this->session->usertype;
		//if($usertype == '5')
		//$CostDetails = $this->costcentre_model->getDetails(array('parent_cost' => ''));	

		$Categories = $this->costcentre_model->getDetails(array('category_id' => ''));	

		$subcategories = array();
		if($Categories)
		{
			foreach($Categories as $category)
			{
				$cost_id = $category->cost_id;
				$SubCost = $this->costcentre_model->getDetails(array('category_id' => $cost_id,'subcategory_id' => ''));	
				$subcategories[$cost_id] = $SubCost;
			}
		}

		$Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		// else
		// {
		// 	$CostDetails = $this->costcentre_model->getDetails(array('user_id' => $client_id,'parent_cost' => ''));
		// }

		//echo $this->db->last_query();
		//echo "<pre>";print_r($ReportDetail);echo "</pre>";
		$data = array(
					'view_file'=>'add_costcentre',
					'current_menu'=>'add_costcentre',
					'cusotm_field'=>'add_costcentre',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Edit',
					'form_action' => 'save_cost',
					'user_id' => $filtered_client_id,
					'cost_id' => $cost_id,
					'CostDetail' => $CostDetail,
					'Categories' => $Categories,
					'subcategories' => $subcategories,
					'cost_formact' => 'edit_cost',
					//'CostDetails' => $CostDetails,
					'usertype' => $usertype,
					'Sets' => $Sets,
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
	public function save_cost(){

		$user_id = $_POST['user_id'];
		$cost_id = $_POST['cost_id'];
		$set_id = $_POST['set_id'];
		$account_no = $_POST['account_no'];
		$links = $_POST['links'];
		$cost_name = $_POST['cost_name'];
		$category_id = $_POST['category_id'];
		$subcategory_id = (isset($_POST['subcategory_id']))?$_POST['subcategory_id']:'';
		$status = $_POST['status'];

		$cost_array = array( 'user_id' => $user_id,'cost_name' => $cost_name,'status' => $status,'category_id' => $category_id,'subcategory_id' => $subcategory_id,'links' => $links,'account_no' => $account_no,'set_id' => $set_id );
		if($cost_id == '')
		{
			$cost_array['created_on'] = date('Y-m-d H:i:s');
			$cost_id = $this->costcentre_model->Insert($cost_array);			
		}
		else
		{
			$where_array = array('cost_id' => $cost_id);
			$cost_array['modified_on'] = date('Y-m-d H:i:s');			
			$this->costcentre_model->Update($cost_array,$where_array);
		}

		$this->session->set_flashdata('costcentre', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Cost Saved Successfully</span></div>');
		redirect(BASE_URL.'costcentre');
		
	}
	public function delete_costc($cost_id =''){
		if($cost_id !='')
		{
			$this->costcentre_model->Delete(array('cost_id' => $cost_id));
			//echo $this->db->last_query();
		}
		$this->session->set_flashdata('costcentre', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Selected Cost Centre Deleted Successfully</span></div>');
		redirect(BASE_URL.'costcentre');
		
	}
	public function get_subcategory()
	{
		$category_id = (isset($_POST['category_id']))?$_POST['category_id']:'';
		$Subcategory_Details = array();
		if($category_id !='')
		{
			$Subcategory_Details = $this->costcentre_model->getDetails(array('category_id' => $category_id,'subcategory_id' => ''));
		}
		
		//echo $this->db->last_query();
		echo json_encode(array('Subcategory_Details' => $Subcategory_Details,'success' => TRUE));
	}
	
	public function active_costcentre(){
		$client_id= $this->session->id;	
		$Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		$activeuserdetails = $this->costcentre_model->getDetailsCommon('usermaster',array('id' => $client_id));
		
		$data = array(
					'view_file'=>'active_costcentre',
					'current_menu'=>'active_costcentre',
					'cusotm_field'=>'active_costcentre',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'Sets' => $Sets,
					'activeuserdetails' => $activeuserdetails,
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
	public function get_costsets(){
		$stl_txt = '';
		$set_id = (isset($_POST['set_id']))?$_POST['set_id']:'';
		$set_Details = array();
		if($set_id !='')
		{
			$CostDetails = $this->costcentre_model->getDetails(array('set_id' => $set_id,'user_id' => 1,'status' => 1));
		}

		//echo "<pre>";print_r($CostDetails);echo "</pre>";
        if($CostDetails) { 

            setlocale(LC_MONETARY, 'en_IN');
            foreach($CostDetails as $CostDetail) {
                //echo "<pre>";print_r($CostDetail);echo "</pre>";
                $account_no = $CostDetail->account_no;
                $links = $CostDetail->links;
                $cost_name	=$CostDetail->cost_name;
                $status = $CostDetail->status;
                $cost_id = $CostDetail->cost_id;
                $category_id = $CostDetail->category_id;
                $subcategory_id = $CostDetail->subcategory_id;
                $category_name = $subcategory_name = '';
                if($category_id !='')
                {
                    $catcost = $this->costcentre_model->getDetails(array('cost_id' => $category_id));
                    if($catcost)
                    {
                        foreach($catcost as $ctcost)
                        {
                            $category_name = $ctcost->cost_name;
                        }
                    }
                }
                if($subcategory_id !='')
                        {
                            $subcost = $this->costcentre_model->getDetails(array('cost_id' => $subcategory_id));
                            if($subcost)
                            {
                                foreach($subcost as $sbcost)
                                {
                                    $subcategory_name = $sbcost->cost_name;
                                }
                            }
                        }
                        

                        $status_txt = ($status == '1')?'Active':'In-Active';

                        $stl_txt .= '<tr>
                            <td>'.$account_no.'</td>
                            <td>'.$cost_name.'</td>
                            <td>'.$links.'</td>
                            <td>'.$category_name.'</td>
                            <td>'.$subcategory_name.'</td>


                        </tr>';
 
                        } 
                        }
                        else {
                        //echo "<tr><td colspan='5'>No records found </td></tr>";
                        } 
		
		//echo $this->db->last_query();
		echo json_encode(array('set_Details' => $CostDetails,'stl_txt' => $stl_txt,'success' => TRUE));
	}
	public function importcostset(){
		$set_id = $_POST['set_id'];
		//echo $set_id;
		$filtered_client_id= $this->session->id;
		if($set_id !='')
		{
			$CostDetails = $this->costcentre_model->getDetails(array('set_id' => $set_id,'user_id' => 1,'status' => 1));
			
			if($CostDetails)
			{
				$where_array = array('id' => $filtered_client_id);
				$ucost_array['set_id'] = $set_id;			
				$this->costcentre_model->Update_common('usermaster',$ucost_array,$where_array);
				foreach($CostDetails as $CostDetail)
				{
					$set_id = $CostDetail->set_id;
					$account_no = $CostDetail->account_no;
	                $links = $CostDetail->links;
	                $cost_name	=$CostDetail->cost_name;
	                $status = $CostDetail->status;
	                $cost_id = $CostDetail->cost_id;
	                $category_id = $CostDetail->category_id;
	                $subcategory_id = $CostDetail->subcategory_id;
	                $cost_array = array('account_no' => $account_no, 'links' => $links, 'cost_name' => $cost_name, 'status' => $status, 'category_id' => $category_id, 'subcategory_id' => $subcategory_id,'user_id' => $filtered_client_id);
	                $cost_id = $this->costcentre_model->Insert($cost_array);
				}
			}
			$this->session->set_flashdata('costcentre', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Cost Set Imported Successfully</span></div>');
			redirect(BASE_URL.'costcentre');
		}
		else
		{
			$this->session->set_flashdata('costcentre', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Please select atleast one cost set</span></div>');
			redirect(BASE_URL.'costcentre');
		}
	}
	
	

}
