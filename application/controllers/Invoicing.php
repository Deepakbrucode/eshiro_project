<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicing extends CI_Controller {

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
		$this->load->model('client_model');
		$this->load->model('reports_model');
		$this->load->model('user_model');
		$this->load->model('costcentre_model');
		$this->load->helper('url');
	}
	public function _remap($method, $params = array())
	{
        $method = $method;
        if (method_exists($this, $method))
        {
                return call_user_func_array(array($this, $method), $params);
        }
        else
        {
        	$this->index();
        }
      }
	public function index(){
		 $usertype= $this->session->usertype;
		 $client_id= $this->session->id;
		 $fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$final_client_id = $client_id;
		$ClientDetails = $this->client_model->getClientDetails();

		if($usertype == '5' && $fclient_id !=''){$final_client_id = $fclient_id;}
		
		$InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => 1,'user_id' => $final_client_id));

			$data = array(
					'view_file'=>'invoicing/show_client',
					'current_menu'=>'show_customers',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Show Clients',
					'edit_url' => 'edit_customer',
					'add_url' => 'add_customer',
					'title_txt' => 'Customer',
					'redirect_url' => 'index',
					'ClientDetails' => $ClientDetails,
					'InvClientDetails' => $InvClientDetails,
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
	 	public function show_suppliers(){
		 
		$usertype= $this->session->usertype;
		 $client_id= $this->session->id;
		 $fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$final_client_id = $client_id;
		$ClientDetails = $this->client_model->getClientDetails();

		if($usertype == '5' && $fclient_id !=''){$final_client_id = $fclient_id;}
		
		$InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => 2,'user_id' => $final_client_id));
			$data = array(
					'view_file'=>'invoicing/show_client',
					'current_menu'=>'show_suppliers',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Show Suppliers',
					'edit_url' => 'edit_supplier',
					'add_url' => 'add_supplier',
					'title_txt' => 'Suppliers',
					'redirect_url' => 'show_suppliers',
					'ClientDetails' => $ClientDetails,
					'InvClientDetails' => $InvClientDetails,
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
	 
	public function add_customer(){
		$usertype= $this->session->usertype;
		if($this->input->get('id'))
		{
			$form_name = 'Update';
			$form_action = 'updateclient_submit';
			$id = $this->input->get('id');
			$InvClientDetail = $this->reports_model->getDetails('invoicing_user',array('usertype' => 1,'id' => $id));
			$redirect_url = 'edit_customer';
			// $Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addclient_submit';
			$InvClientDetail = '';
			$redirect_url = 'add_customer';
			// $Sets = '';
		}
		$usertype_new = '1';
		$ClientDetails = $this->client_model->getClientDetails();
		
		$user_id= $this->session->id;
		 


		$data = array(
					'view_file'=>'invoicing/add_client',
					'current_menu'=>'inv_add_client',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Add Customer',
					'title_txt' => 'Customer',
					'formname' => $form_name,
					'cancel_url' => 'add_customer',
					'InvClientDetail' => $InvClientDetail,
					'form_action' => $form_action,
					'usertype_new' => $usertype_new,
					'redirect_url' => $redirect_url,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'user_id' => $user_id,
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
								"js" => array(
									'lib/jquery-1.11.0.min.js',
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
	public function add_supplier(){
		$usertype= $this->session->usertype;
		if($this->input->get('id'))
		{
			$form_name = 'Update';
			$form_action = 'updateclient_submit';
			$id = $this->input->get('id');
			// $ClientDetail = $this->user_model->getDetails(array('id' => $id));
			$InvClientDetail = $this->reports_model->getDetails('invoicing_user',array('usertype' => 2,'id' => $id));
			$redirect_url = 'edit_supplier';
			// $Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addclient_submit';
			$InvClientDetail = '';
			$redirect_url = 'add_supplier';
			// $Sets = '';
		}
		$usertype_new = '2';
		$user_id= $this->session->id;
		$ClientDetails = $this->client_model->getClientDetails();

		$data = array(
					'view_file'=>'invoicing/add_client',
					'current_menu'=>'inv_add_supplier',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Add Supplier',
					'title_txt' => 'Supplier',
					'formname' => $form_name,
					'cancel_url' => 'add_supplier',
					'InvClientDetail' => $InvClientDetail,
					'form_action' => $form_action,
					'usertype_new' => $usertype_new,
					'redirect_url' => $redirect_url,
					'user_id' => $user_id,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
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
								"js" => array(
									'lib/jquery-1.11.0.min.js',
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
	
	public function addclient_submit(){   //insert functionality for client
		//print_r($this->input->post());exit();
		// $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		// $password = substr( str_shuffle( $chars ), 0, 8 );
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		$usertype_new = $this->input->post('usertype_new');
		$redirect_url = $this->input->post('redirect_url');
		$user_id = $this->input->post('user_id');

				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
					'user_id' => $user_id,
					'usertype' => $usertype_new
				);


				$insert_status = $this->reports_model->Insert('invoicing_user',$insert_data);

				if($insert_status)
				{
				$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User details inserted successfully</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url);
				}
				else
				{
					$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url);
				}

	}

	public function updateclient_submit(){
		
		
		$client_id = $this->input->post('client_id');
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		$usertype_new = $this->input->post('usertype_new');
		$redirect_url = $this->input->post('redirect_url');
		$user_id = $this->input->post('user_id');
		

					
			if(($_SESSION['filtered_client_name1'])!='admin')
			{
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
					'user_id' => $user_id,
					// 'usertype_new'=>$usertype_new,
				);
				$where_date = array(
					'id' => $client_id
				);

				// $insert_status = $this->user_model->update($insert_data,$where_date);
				$insert_status = $this->reports_model->update('invoicing_user',$insert_data,$where_date);

				if(isset($insert_status))
				{
				$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Updated successfully</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url.'?id='.$client_id);

				}
				else
				{
				$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url.'?id='.$client_id);
				}
			}
			else
			{
			
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
					'user_id' => $user_id,
					// 'financial_month_start'=>$start_month,
					// 'financial_month_end'=>$end_month,
						 
				);
				$where_date = array(
					'id' => $client_id
				);

				//$insert_status = $this->user_model->Update($insert_data,$where_date);
				$insert_status = $this->reports_model->update('invoicing_user',$insert_data,$where_date);
				if($insert_status)
				{
					$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User details Updated successfully</span></div>');
					redirect(BASE_URL.'invoicing/'.$redirect_url);
				}
				else
				{
					$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
					redirect(BASE_URL.'invoicing/'.$redirect_url.'?id='.$client_id);
				}
			}
	// 	}
	// }
		
		 
	}
	// public function get_clientnames(){

	//       $ClientDetails = $this->client_model->getClientDetails();
	//       echo json_encode($ClientDetails);
	// }
	// public function get_clientname(){
	// 	if (isset($_GET['term'])){
	//       $q = strtolower($_GET['term']);
	//       //$this->client_model->get_bird($q);
	//       $option_arr = array('like'=> array('firm_name' => $q, 'directors' => $q));
	//      // $option_arr = array('like' => $q);
	//       $ClientDetail = $this->client_model->getClientDetails('','',$option_arr);
	//       //echo $this->db->last_query();
	//       if($ClientDetail)
	// 	  {
	// 		foreach ($ClientDetail as $value) {
	// 			$client_id = $value->client_id;
	// 			$firm_name = $value->firm_name;
	//             $directors = $value->directors;
	//             $registered_address = $value->registered_address;
	//              $new_row['label']=htmlentities(stripslashes($firm_name));
 //        		$new_row['value']=htmlentities(stripslashes($client_id));
 //        		$row_set[] = $new_row; //build an array

	//         }
	//         echo json_encode($row_set);
	//       }
	//     }
	// }
	public function delete_client()

	{
	$client_id = $this->input->get('id');
	$redirect_url = $this->input->get('redirect_url');
	$update_data = array(
	'status' => 3
	);
	$where_date = array(
	'id' => $client_id
	);
	// $delete_status=$this->user_model->DeleteClient($client_id);
	$delete_status = $this->reports_model->Delete('invoicing_user',$where_date);

//$insert_status = $this->client_model->UpdateClient($insert_data,$where_date);
//$delete_status = $this->user_model->DeleteClient($update_data,$where_date);

//echo $this->db->last_query();exit;

	//print_r($insert_status);
if($delete_status)
	{
	$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Deleted Successfully</span></div>');
	redirect(BASE_URL.'invoicing/'.$redirect_url);
	}
	else
	{
	$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Delete</span></div>');
	redirect(BASE_URL.'invoicing/'.$redirect_url);
	}
	}


	public function show_invoice($report_type = '5'){
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = $this->input->get('client_id');
	
		if($report_type == '5')
		{
			$invoice_txt = 'Cusotmer Invoice';
			$invoice_menu = 'show_customer_invoice';
			$add_url = 'add_customer_invoice';
			$edit_url = 'edit_customer_invoice';
			$invbtn_txt = 'Invoice';
		}
		else if($report_type == '6')
		{
			$invoice_txt = 'Cusotmer Quote';
			$invoice_menu = 'show_customer_quote';
			$add_url = 'add_customer_quote';
			$edit_url = 'edit_customer_quote';
			$invbtn_txt = 'Quote';
		}
		else
		{
			$invoice_txt = 'Supplier Invoice';
			$invoice_menu = 'show_supplier_invoice';
			$add_url = 'add_supplier_invoice';
			$edit_url = 'edit_supplier_invoice';
			$invbtn_txt = 'Invoice';
		}


		
		$final_clientid = $fclient_id;
		$ReportDetails = array();
		if($final_clientid !='')
		{
			$ReportDetails = $this->reports_model->getDetails('report',array('inv_user_id' => $final_clientid,'status' => 1,'report_type' => $report_type));
			// echo $this->db->last_query();
		}

		

		$inv_usertype = 1; $inv_usertype_txt = 'Customer';
		if($report_type == '7'){$inv_usertype = 2;$inv_usertype_txt = 'Supplier';}
		
		if($usertype =='5')
		{
			$InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype));
		}
		else
			$InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype,'user_id' => $client_id));


		$data = array(
					'view_file'=>'invoicing/show_invoice',
					'current_menu'=>$invoice_menu,
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'ReportDetails' => $ReportDetails,
					'InvClientDetails' => $InvClientDetails,
					'usertype' => $usertype,
					'final_clientid' => $final_clientid,
					'invoice_txt' => $invoice_txt,
					'report_type' => $report_type,
					'add_url' => $add_url,
					'edit_url' => $edit_url,
					'inv_usertype_txt' => $inv_usertype_txt,
					'invbtn_txt' => $invbtn_txt,
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

	public function add_invoice($report_type = '5'){
		

		$ClientDetails = $this->client_model->getClientDetails();
		$usertype= $this->session->usertype;
		$filtered_client_id= $this->session->id;
		$base_txt = 'Invoice';
		$cancel_url = 'show_customer_invoice';

		if($report_type == '5')
		{
			$invoice_txt = 'Cusotmer Invoice';
			$invoice_menu = 'add_cusomter_invoice';
		}
		else if($report_type == '6')
		{
			$invoice_txt = 'Cusotmer Quote';
			$invoice_menu = 'add_cusomter_quote';
			$base_txt = 'Quote';
			$cancel_url = 'show_customer_quote';
		}
		else
		{
			$invoice_txt = 'Supplier Invoice';
			$invoice_menu = 'add_supplier_invoice';
			$cancel_url = 'show_supplier_invoice';
		}
		

		$inv_usertype = 1; $inv_usertype_txt = 'Customer';
		if($report_type == '7'){$inv_usertype = 2;$inv_usertype_txt = 'Supplier';}
		if($usertype =='5')
		{
			// $InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype));
			$invsql = "SELECT usm.vat_no as user_vatno,inus.* FROM `invoicing_user` as inus left join usermaster as usm on usm.id=inus.user_id WHERE inus.`usertype` = ".$inv_usertype." ORDER BY `status` ASC";
		}
		else
		{
			$invsql = "SELECT usm.vat_no as user_vatno,inus.* FROM `invoicing_user` as inus left join usermaster as usm on usm.id=inus.user_id WHERE inus.`usertype` = ".$inv_usertype." AND inus.`user_id` = '".$filtered_client_id."' ORDER BY `status` ASC";
			// $InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype,'user_id' => $filtered_client_id));
		}
		
		$InvClientDetailsqy = $this->db->query($invsql);
         $InvClientDetails = $InvClientDetailsqy->result();
         // echo $this->db->last_query();

		$CurrentClientDetails = $this->reports_model->getDetails('usermaster',array('id' => $filtered_client_id));

		
		$data = array(
					'view_file'=>'invoicing/add_invoice',
					'current_menu'=>$invoice_menu,
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Add',
					'form_action' => 'save_report',
					'user_id' => $filtered_client_id,
					'ReportDetail' => '',
					'ClientDetails' => $ClientDetails,
					'report_type' => $report_type,
					'invoice_txt' => $invoice_txt,
					'usertype' => $usertype,
					'InvClientDetails' => $InvClientDetails,
					'inv_usertype_txt' => $inv_usertype_txt,
					'base_txt' => $base_txt,
					'cancel_url' => $cancel_url,
					'CurrentClientDetails' => $CurrentClientDetails,
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
	public function edit_invoice($report_type = '5'){	

		$filtered_client_id= $this->session->id;
		$ReportDetail = $InvoiceMetaDetails = '';
		$report_id = $this->input->get('id');
		if($report_id !='' )
		{
			$ReportDetail = $this->reports_model->getDetails('report',array('report_id' => $report_id));	
			$InvoiceMetaDetails = $this->reports_model->getDetails('invoicing_data_meta',array('report_id' => $report_id));	
		}
		
		$ClientDetails = $this->client_model->getClientDetails();
		$usertype= $this->session->usertype;
		$base_txt = 'Invoice';
		if($report_type == '5')
		{
			$invoice_txt = 'Cusotmer Invoice';
			$invoice_menu = 'edit_cusomter_invoice';
			$cancel_url = 'show_customer_invoice';
		}
		else if($report_type == '6')
		{
			$invoice_txt = 'Cusotmer Quote';
			$invoice_menu = 'edit_cusomter_quote';
			$cancel_url = 'show_customer_quote';
			$base_txt = 'Quote';
		}
		else
		{
			$invoice_txt = 'Supplier Invoice';
			$invoice_menu = 'edit_supplier_invoice';
			$cancel_url = 'show_supplier_invoice';
		}

		$inv_usertype = 1; $inv_usertype_txt = 'Customer';
		if($report_type == '7'){$inv_usertype = 2;$inv_usertype_txt = 'Supplier';}
		if($usertype =='5')
		{

			// $InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype));

			$InvClientDetails =$this->db->query("SELECT inv_usr.*,usm.vat_no as user_vat FROM `invoicing_user` as inv_usr left join usermaster as usm on usm.id=inv_usr.user_id where inv_usr.usertype='".$inv_usertype."'")->result();

		}
		else
		{
			// $InvClientDetails = $this->reports_model->getDetails('invoicing_user',array('usertype' => $inv_usertype,'user_id' => $filtered_client_id));
			$InvClientDetails =$this->db->query("SELECT inv_usr.*,usm.vat_no as user_vat FROM `invoicing_user` as inv_usr left join usermaster as usm on usm.id=inv_usr.user_id where inv_usr.usertype='".$inv_usertype."' and user_id='".$filtered_client_id."'")->result();
		}
		// SELECT inv_usr.*,usm.vat_no as user_vat FROM `invoicing_user` as inv_usr left join usermaster as usm on usm.id=inv_usr.user_id

// SELECT inv_usr.*,usm.vat_no as user_vat FROM `invoicing_user` as inv_usr left join usermaster as usm on usm.id=inv_usr.user_id where inv_usr.usertype='1' and user_id='40'

		$data = array(
					'view_file'=>'invoicing/add_invoice',
					'current_menu'=>$invoice_menu,
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Edit',
					'form_action' => 'save_report',
					'user_id' => $filtered_client_id,
					'report_id' => $report_id,
					'ReportDetail' => $ReportDetail,
					'InvoiceMetaDetails' => $InvoiceMetaDetails,
					'ClientDetails' => $ClientDetails,
					'usertype' => $usertype,
					'report_type' => $report_type,
					'invoice_txt' => $invoice_txt,
					'base_txt' => $base_txt,
					'cancel_url' => $cancel_url,
					'usertype' => $usertype,
					'InvClientDetails' => $InvClientDetails,
					'inv_usertype_txt' => $inv_usertype_txt,
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
	public function save_invoice(){
		//echo "<pre>";print_r($_POST);echo "</pre>";exit;
		$inv_user_id = $_POST['inv_user_id'];
		$report_type = $_POST['report_type'];
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

		$due_date = $_POST['due_date'];
		if($due_date !='')
		{
			$due_date1 = explode('/',$due_date);
			$due_date = $due_date1[2]."-".$due_date1['1']."-".$due_date1['0'];
		}
		// echo $report_date;exit;
		$due_date = date('Y-m-d',strtotime($due_date));


		$inv_no = $_POST['inv_no'];
		$ref_no = $_POST['ref_no'];
		$total_excl_price = $_POST['total_excl_price'];
		$total_vat = $_POST['total_vat'];
		$amount = $_POST['amount'];
		// $description = $_POST['description'];
		// $amount_type = $_POST['amount_type'];
		// $tax_type = $_POST['tax_type'];
		// $amount = $_POST['amount'];
		//$cost_id = $_POST['cost_id'];
		$status = $_POST['status'];
		$amount_type = '';
		$tax_type = 'exempt';
		$cost_id = $subcategory_id = $category_id = '';

		if($report_type == '5'){$redirect_url = 'add_customer_invoice';$amount_type = 'sales';$cost_id=SALES_COST_ID;$description = 'Cusotmer invoice';$subcategory_id=SALES_COST_SUBCAT_ID;$category_id=SALES_COST_CAT_ID;}
		else if($report_type == '6'){$redirect_url = 'add_customer_quote';$amount_type = 'sales';$cost_id=SALES_COST_ID;$description = 'Customer invoice';$subcategory_id=SALES_COST_SUBCAT_ID;$category_id=SALES_COST_CAT_ID;}
		else{$redirect_url = 'add_supplier_invoice';$amount_type = 'expense';$description = 'Supplier invoice';}
		
		
		$user_id = '';
		$clientDetails = $this->reports_model->getDetails('invoicing_user',array('id' => $inv_user_id));	
		if($clientDetails)
		{
			foreach($clientDetails as $clientDetail)
			{
				$user_id = $clientDetail->user_id;
			}
		}

		$report_array = array( 'user_id' => $user_id,'inv_user_id' => $inv_user_id,'report_date' => $report_date,'inv_no' => $inv_no, 'ref_no' => $ref_no, 'status' => $status,'report_type' => $report_type,'due_date' => $due_date,'total_excl_price' => $total_excl_price,'total_vat' => $total_vat,'amount' => $amount,'cost_id'=>$cost_id,'amount_type' => $amount_type,'tax_type' => $tax_type,'description' => $description,'subcategory_id' => $subcategory_id,'category_id' => $category_id  );

		
		if($report_id == '')
		{
			if($report_type == '7')
				$check_where = " and report_type='7'";
			else
				$check_where = " and (report_type='5' or report_type='6')";

			$report_array['created_on'] = date('Y-m-d H:i:s');
			$check_inv_qur = $this->db->query("select * from report where inv_no = '".$inv_no."'".$check_where);
			$check_inv = $check_inv_qur->row();
			$check_inv=count($check_inv);
			if($check_inv > 0)
			{
				$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Invoice Number Already Exists</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url);
			}
			else
			{
				$check_ref_qur = $this->db->query("select * from report where ref_no = '".$ref_no."'".$check_where);
				$check_ref = $check_ref_qur->row();
				$check_ref=count($check_ref);
				if($check_ref > 0)
				{
					$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Reference Number Already Exists</span></div>');
					redirect(BASE_URL.'invoicing/'.$redirect_url);
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
				$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Invoice Number Already Exists</span></div>');
				redirect(BASE_URL.'invoicing/'.$redirect_url);
			}
			else
			{
				$check_ref_qur = $this->db->query("select * from report where ref_no = '".$ref_no."' and report_id !='".$report_id."' ");
				$check_ref = $check_ref_qur->row();
				$check_ref=count($check_ref);
				if($check_ref > 0)
				{
					$this->session->set_flashdata('invoicing', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Reference Number Already Exists</span></div>');
					redirect(BASE_URL.'invoicing/'.$redirect_url);
				}
				else
				{
					$this->reports_model->Update('report',$report_array,$where_array);
					$insert_status = $this->reports_model->Delete('invoicing_data_meta',$where_array);
					//echo $this->db->last_query();
				}
			}
			
			
		}

		$invoice_items = $_POST['invoice_items'];

		foreach($invoice_items as $invoice_item)
		{
			$inv_desc = $invoice_item['desc'];
			$inv_qty = $invoice_item['qty'];
			$inv_eprice = $invoice_item['excel_price'];
			$inv_teprice = $invoice_item['excel_price_total'];
			$inv_vat = $invoice_item['vat'];
			$inv_total = $invoice_item['total_price'];
			$invoice_meta = array('report_id' => $report_id,'inv_desc' => $inv_desc,'inv_qty' => $inv_qty,'inv_eprice' => $inv_eprice,'inv_teprice' => $inv_teprice,'inv_vat' => $inv_vat,'inv_total' => $inv_total);
			$invoice_meta_id = $this->reports_model->Insert('invoicing_data_meta',$invoice_meta);
		}

		

		$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Data Saved Successfully</span></div>');
		redirect(BASE_URL.'invoicing/'.$redirect_url);
		
	}
	public function delete_invoice(){
		$report_id = $this->input->get('report_id');
		$redirect_url = $this->input->get('redirect_url');
		if($report_id !='')
		{
			$this->reports_model->Delete('report',array('report_id' => $report_id));
		}
		$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Data Deleted Successfully</span></div>');
		redirect(BASE_URL.'invoicing/'.$redirect_url);
		
	}
	
	public function invoice_pdf_ajax(){

		
		$report_id = $this->input->get('report_id');
		
		//$excel_fname = 'vat201.xls';
		
		
		
		$invoiceDetail = $this->reports_model->get_invoice_data($report_id);
		$InvoiceMetaDetails = $this->reports_model->getDetails('invoicing_data_meta',array('report_id' => $report_id));
		if($invoiceDetail)
		{
			$user_id = $invoiceDetail->user_id;
			$user_details = $this->user_model->getClient($user_id);
		}


		
		$pdf_fname = 'invoice_'.$report_id.'.pdf';
// echo "<pre>";print_r($user_details);echo "</pre>";
// exit;


			
			/********************* PDF start ********/
			
			 $this->load->library('m_pdf'); 
			 
			 
			//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';
			
			// $final_vat = $sale_total_vatfornet_ta - $cost_total_vatfornet_ta;

			$page_data['report_id']  	= $report_id;
			$page_data['invoiceDetail'] = $invoiceDetail;
			$page_data['InvoiceMetaDetails'] = $InvoiceMetaDetails;
			$page_data['user_details'] = $user_details;

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
			
			
			$htmltd_content = "
		
		
		<a href='".BASE_URL."uploads/".$pdf_fname."' class='invoice_pdfdownload' download='' style='display:none;'>Download invoice PDF</a>
		
		";
			
			
			$pdfuurl = BASE_URL."uploads/".$pdf_fname;

		echo json_encode(array("status" => 1,'table_content' => $htmltd_content,'pdfuurl' => $pdfuurl));
		
		
	}
	// public function convert_quote_ajax(){
	// 	$report_id = $this->input->get('report_id');
	// 	$where_array = array('report_id' => $report_id);
	// 	$this->reports_model->Update('report',array('invoice_type' => 1),$where_array);
	// 	echo json_encode(array("status" => 1));
	// }
	public function convert_quote_ajax(){
		$report_id = $this->input->get('report_id');
		$redirect_url = $this->input->get('redirect_url');
		if($report_id !='')
		{
			$where_array = array('report_id' => $report_id);
			$this->reports_model->Update('report',array('report_type' => 5),$where_array);
		}
		$this->session->set_flashdata('invoicing', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Quote moved to invoice successfully</span></div>');
		redirect(BASE_URL.'invoicing/'.$redirect_url);
		
	}

	public function ajax_customervatcheck(){
		// $customer_id = 
	}

	public function customer_receipts(){
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = $this->input->get('client_id');

		


		$ReportDetails = array();
		if($fclient_id !='')
			$ReportDetails = $this->reports_model->getReceiptdata($fclient_id);

		// if($fclient_id !='')
		// 	$ReportDetails = $this->reports_model->getDetails('report',array('inv_user_id' => $fclient_id,'status' => 1,'report_type' => 5));


		
		$where_arr = array('usertype' => 1);
		if($usertype !='5')
			$where_arr['user_id'] = $client_id;


		$InvClientDetails = $this->reports_model->getDetails('invoicing_user',$where_arr);


		$data = array(
					'view_file'=>'invoicing/customer_receipts',
					'current_menu'=> 'customer_receipts',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'ReportDetails' => $ReportDetails,
					'InvClientDetails' => $InvClientDetails,
					'final_clientid' => $fclient_id,
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
									'lib/scripts/app.min.js',
									'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
									'lib/scripts/layout.min.js',
									
									// 'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
									// '//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
									// '//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
									//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

	public function savereceipt(){
		// echo "<pre>";print_r($_POST);echo "</pre>";
		try{
			foreach($_POST['receipt_data'] as $receipt_data)
			{
				if($receipt_data['rdata'] == '' || $receipt_data['amount'] == '')
					continue;
				$report_date = $receipt_data['rdata'];
				
				// $report_date1 = explode('/',$report_date);
				// $report_date = $report_date1[2]."-".$report_date1['1']."-".$report_date1['0'];
				
				$report_date = date('Y-m-d',strtotime($report_date));

				$insert_arr = array('parent_invoice_id' => $receipt_data['report_id'],'user_id' => $receipt_data['user_id'],'inv_user_id' => $receipt_data['inv_user_id'],'inv_no' => $receipt_data['inv_no'], 'ref_no' => $receipt_data['ref_no'],'cost_id' => $receipt_data['cost_id'], 'amount_type' => $receipt_data['amount_type'], 'category_id' => $receipt_data['category_id'], 'subcategory_id' => $receipt_data['subcategory_id'], 'report_date' => $report_date, 'amount' => $receipt_data['amount'],'created_on' => date('Y-m-d H:i:s'),'report_type' => 11,'description' => 'Customer receipt' );
				// $report_array['created_on'] = date('Y-m-d H:i:s');
				$report_id = $this->reports_model->Insert('report',$insert_arr);
			}
			echo 'success';

		}
		catch (Exception $e)
		{
			return false;
		}
	}
	public function supplier_payments(){
		$client_id = $this->session->id;
		$usertype = $this->session->usertype;
		$fclient_id = $this->input->get('client_id');

		


		$ReportDetails = array();
		if($fclient_id !='')
			$ReportDetails = $this->reports_model->getPaymentdata($fclient_id);

		// if($fclient_id !='')
		// 	$ReportDetails = $this->reports_model->getDetails('report',array('inv_user_id' => $fclient_id,'status' => 1,'report_type' => 5));


		
		$where_arr = array('usertype' => 2);
		if($usertype !='5')
			$where_arr['user_id'] = $client_id;


		$InvClientDetails = $this->reports_model->getDetails('invoicing_user',$where_arr);


		$data = array(
					'view_file'=>'invoicing/supplier_payments',
					'current_menu'=> 'supplier_payments',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'ReportDetails' => $ReportDetails,
					'InvClientDetails' => $InvClientDetails,
					'final_clientid' => $fclient_id,
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
									'lib/scripts/app.min.js',
									'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
									'lib/scripts/layout.min.js',
									
									// 'lib/bootstrap-confirmation/bootstrap-confirmation.min.js',
									// '//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js',
									// '//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js'
									//'http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}

	public function savepayment(){
		// echo "<pre>";print_r($_POST);echo "</pre>";
		try{
			foreach($_POST['payment_data'] as $payment_data)
			{
				if($payment_data['rdata'] == '' || $payment_data['amount'] == '')
					continue;
				$report_date = $payment_data['rdata'];
				// echo "report_date = ".$report_date;
				
				// $report_date1 = explode('/',$report_date);
				// $report_date = $report_date1[2]."-".$report_date1[1]."-".$report_date1[0];
				// echo "report_date = ".$report_date;
				
				$report_date = date('Y-m-d',strtotime($report_date));
				// echo "report_date = ".$report_date;exit;

				$insert_arr = array('parent_invoice_id' => $payment_data['report_id'],'user_id' => $payment_data['user_id'],'inv_user_id' => $payment_data['inv_user_id'],'inv_no' => $payment_data['inv_no'], 'ref_no' => $payment_data['ref_no'],'cost_id' => $payment_data['cost_id'], 'amount_type' => $payment_data['amount_type'], 'category_id' => $payment_data['category_id'], 'subcategory_id' => $payment_data['subcategory_id'], 'report_date' => $report_date, 'amount' => $payment_data['amount'],'created_on' => date('Y-m-d H:i:s'),'report_type' => 12,'description' => 'Supplier Payment' );
				// $report_array['created_on'] = date('Y-m-d H:i:s');
				$report_id = $this->reports_model->Insert('report',$insert_arr);
			}
			echo 'success';

		}
		catch (Exception $e)
		{
			return false;
		}
	}
}
