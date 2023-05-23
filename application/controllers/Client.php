<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

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
		$this->load->model('user_model');
		$this->load->model('costcentre_model');
		$this->load->model('reports_model');
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
		 
		$ClientDetails = $this->user_model->getDetails(array('usertype' => 10));
			$data = array(
					'view_file'=>'show_client',
					'current_menu'=>'show_clients',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Show Clients',
					'ClientDetails' => $ClientDetails,
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
	 
	public function add_client(){
		
		if($this->input->get('id'))
		{
			$form_name = 'Update';
			$form_action = 'updateclient_submit';
			$id = $this->input->get('id');
			$ClientDetail = $this->user_model->getDetails(array('id' => $id));
			$Sets = $this->costcentre_model->getDetailsCommon('costcentre_set',array('status' => '1'));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addclient_submit';
			$ClientDetail = '';
			$Sets = '';
		}
		
		$data = array(
					'view_file'=>'add_client',
					'current_menu'=>'add_client',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Add Client',
					'formname' => $form_name,
					'ClientDetail' => $ClientDetail,
					'form_action' => $form_action,
					'Sets' => $Sets,
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
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, 8 );
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		
		$result = $this->user_model->checkEmail($email);
		$mail=count($result);
		
		$result1 = $this->user_model->checkVatNo($vat_no);
		$vatcheck=count($result1);
		
		
		if($mail > 0)
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>EmailId Already Exists</span></div>');
			redirect(BASE_URL.'client/add_client');
	    }
		else
		{
			if($vatcheck > 0 && $vat_no !='')
			{
			
				$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>VAT Number Already Exists</span></div>');
				redirect(BASE_URL.'client/add_client');
			}
				
			else
			{
				$insert_data = array(
					'name' => $name,
					'phone'=>$phone,
					'username'=>$email,
					'email'=>$email,
					'address1' => $address1,
					'address2' => $address2,
					'zip_code' => $zip_code,
					'trading_name' => $trading_name,
					'vat_no' => $vat_no,
					'status' => $status, 
					'password'=>$password,
					'financial_month_start'=>$start_month,
					'financial_month_end'=>$end_month,
					'usertype' => 10
				);

				$target_dir = FCPATH."images/pdflogo/";
				$imageFileType = strtolower(pathinfo($_FILES["pdf_logo"]["name"],PATHINFO_EXTENSION));
				$milliseconds = time().uniqid(rand());

				// echo "<pre>";print_r($_FILES);echo "</pre>";
				$img_name = $milliseconds.".".$imageFileType;
				$target_file = $target_dir . $img_name;


			    if (move_uploaded_file($_FILES["pdf_logo"]["tmp_name"], $target_file)) {
			        $insert_data['pdf_logo'] = $img_name;
			    }

			    
				$insert_status = $this->client_model->InsertClient($insert_data);
				if($insert_status)
				{

					$userinfo = $this->user_model->getAdmin();
				$adminname = $userinfo['username'];
				$adminemail = $userinfo['email'];

				//$this->user_model->sendEmail($adminname,$adminemail,$name,$emailid,$password); 
				//mail functions
				$to = $adminemail;
				$headers ='From:'.$email;
				$subject ='New user created from admin panel';
				$subject1 ='Your account has been created in eShiro';
				$txt='Client Name:              '.$name ."\r\n"; 
				$txt.='Client Contact No:        '.$phone ."\r\n"; 
				$txt.='Client Username:    '.$email ."\r\n"; 
				$txt.='Client Password:    '.$password ."\r\n"; 

				$txt1='Name:              '.$name ."\r\n"; 
				$txt1.='Contact No:        '.$phone ."\r\n"; 
				$txt1.='Username:    '.$email ."\r\n"; 
				$txt1.='Password:    '.$password ."\r\n"; 


				// $txt.='waiting for approval to get login '."\r\n";
				mail($to,$subject,$txt,$headers);
				mail($email,$subject1,$txt1,$headers);
				// mail('vijayasanthi@stallioni.com',$subject1,$txt1,$headers);


				$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User details inserted successfully</span></div>');
				redirect(BASE_URL.'client/add_client');
				}
				else
				{
					$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
				redirect(BASE_URL.'client/add_client');
				}
			}
			
		}
	}
	public function addclient_ajax(){
		//print_r($this->input->post());exit();
		
		$name = $this->input->post('firm_name');
		$phone = $this->input->post('phone');
		$email = $this->input->post('emailid');
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$zip_code = $this->input->post('zip_code');
		$trading_name = $this->input->post('trading_name');
		$vat_no = $this->input->post('vat_no');
		$status = $this->input->post('status');
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		
		//$status = $this->input->post('status');
		
		
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
		    'financial_month_start'=>$start_month,
			'financial_month_end'=>$end_month,
		    'usertype' => 10
		);
 
		$insert_status = $this->user_model->update($insert_data);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User details inserted successfully</span></div>');
		}
		else
		{
		$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in einsert</span></div>');
		}
		$ClientDetails = $this->client_model->getClientDetails();
	     //echo json_encode($ClientDetails);
		//exit;
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
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		$pdf_logo_old = $this->input->post('pdf_logo_old');
		$register_no = $this->input->post('register_no');
		$issue_capital = $this->input->post('issue_capital');
		
		$ccheck_email_qur = $this->db->query("select * from usermaster where email = '".$email."' and id !='".$client_id."'");
		$check_email = $ccheck_email_qur->row();
		$check_email=count($check_email);
		if($check_email > 0)
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>EmailId Already Exists</span></div>');
			redirect(BASE_URL.'client/edit?id='.$client_id);
		}
		else
		{
			$check_vat_qur = $this->db->query("select * from usermaster where vat_no = '".$vat_no."' and id !='".$client_id."'");
			$check_vat = $check_vat_qur->row();
			$check_vat=count($check_vat);
			if($check_vat > 0  && $vat_no !='')
			{
				$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>VAT Number Already Exists</span></div>');
				redirect(BASE_URL.'client/edit?id='.$client_id);
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
					'financial_month_start'=>$start_month,
					'financial_month_end'=>$end_month,
					'issue_capital' => $issue_capital,
					'register_no' => $register_no
						 
				);

				$target_dir = FCPATH."images/pdflogo/";
				$imageFileType = strtolower(pathinfo($_FILES["pdf_logo"]["name"],PATHINFO_EXTENSION));
				$milliseconds = time().uniqid(rand());

				// echo "<pre>";print_r($_FILES);echo "</pre>";
				$img_name = $milliseconds.".".$imageFileType;
				$target_file = $target_dir . $img_name;


			    if (move_uploaded_file($_FILES["pdf_logo"]["tmp_name"], $target_file)) {
			        $insert_data['pdf_logo'] = $img_name;
			    }



				
				$where_date = array(
					'id' => $client_id
				);

				$insert_status = $this->user_model->update($insert_data,$where_date);
					
			if(($_SESSION['filtered_client_name1'])!='admin')
			{
				

				
				//if(isset($insert_status)&&($_SESSION['usertype']== 5) )
				//{
				//$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details updated successfully</span></div>');
				//redirect(BASE_URL.'client/add_client');
				//}
				if(isset($insert_status))
				{
				$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Updated successfully</span></div>');
				redirect(BASE_URL.'client/edit?id='.$client_id);
				//~ $this->session->set_flashdata('profile', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Updated successfully</span></div>');
				//~ redirect(BASE_URL.'dashboard/profile');
				}
				else
				{
				$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
				redirect(BASE_URL.'client/edit?id='.$client_id);
				}
			}
			else
			{
			
				if($insert_status)
				{
					$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User details Updated successfully</span></div>');
					redirect(BASE_URL.'client/add_client');
				}
				else
				{
					$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
					redirect(BASE_URL.'client/edit?id='.$client_id);
				}
			}
		}
	}
		
		 
	}
	public function get_clientnames(){

	      $ClientDetails = $this->client_model->getClientDetails();
	      echo json_encode($ClientDetails);
	}
	public function get_clientname(){
		if (isset($_GET['term'])){
	      $q = strtolower($_GET['term']);
	      //$this->client_model->get_bird($q);
	      $option_arr = array('like'=> array('firm_name' => $q, 'directors' => $q));
	     // $option_arr = array('like' => $q);
	      $ClientDetail = $this->client_model->getClientDetails('','',$option_arr);
	      //echo $this->db->last_query();
	      if($ClientDetail)
		  {
			foreach ($ClientDetail as $value) {
				$client_id = $value->client_id;
				$firm_name = $value->firm_name;
	            $directors = $value->directors;
	            $registered_address = $value->registered_address;
	             $new_row['label']=htmlentities(stripslashes($firm_name));
        		$new_row['value']=htmlentities(stripslashes($client_id));
        		$row_set[] = $new_row; //build an array

	        }
	        echo json_encode($row_set);
	      }
	    }
	}
	public function delete_client()

	{
	$client_id = $this->input->get('id');
	$update_data = array(
	'status' => 3
	);
	$where_date = array(
	'id' => $client_id
	);
	$delete_status=$this->user_model->DeleteClient($client_id);
//$insert_status = $this->client_model->UpdateClient($insert_data,$where_date);
//$delete_status = $this->user_model->DeleteClient($update_data,$where_date);

//echo $this->db->last_query();exit;

	//print_r($insert_status);
if($delete_status)
	{
	$this->session->set_flashdata('showclients', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Deleted Successfully</span></div>');
	redirect(BASE_URL.'client/show_clients');
	}
	else
	{
	$this->session->set_flashdata('showclients', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Delete</span></div>');
	redirect(BASE_URL.'client/show_clients');
	}
	}
	
public function updateapprove_submit()
	{
		//echo "<meta http-equiv='refresh' content='0'>";
	$client_id = $this->input->post('client_id');
	$insert_data = array(

	'status'=> 1
	);
	$where_date = array(
	'id' => $client_id
	);
	$insert_status = $this->user_model->update($insert_data,$where_date);
	
	//~ if(isset($insert_status))
	//~ {
		//for mail functions
		$admininfo = $this->user_model->getAdmin();
		$adminname = $admininfo['username'];
		$adminemail = $admininfo['email'];
		$clientinfo = $this->user_model->getclient($client_id);
		//print_r($clientinfo);exit;
		$emailid=$clientinfo['email'];
		$password=$clientinfo['password'];
			$name=$clientinfo['name'];
		$to = $emailid;
		 $headers ='From:'.$adminemail;
				$subject = 'Your Account Approved';
	$txt ='Welcome' . $name ."\r\n"; 
		$txt.='Your Username:    '. $emailid ."\r\n"; 
		$txt.='Your Password:    '. $password ."\r\n";
		$txt.='Thank you for Registered.   '."\r\n";
		$txt.='Contact Us at:    '.BASE_URL."\r\n";
		mail($to,$subject,$txt,$headers);
	$this->session->set_flashdata('showclients', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client approval Updated successfully</span></div>');

	echo json_encode(array('success' => true));
	// redirect(BASE_URL.'client/show_clients');
	//~ }
	//~ else
	//~ {
	//~ $this->session->set_flashdata('showclients', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
	//~ redirect(BASE_URL.'client/show_clients');
	//~ }
	
	
		
	
	}
	public function showBankAccounts(){
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$fclient_id = '';
		$ClientDetails = array();
		if($usertype == '5')
		{

			$ClientDetails = $this->client_model->getClientDetails();	
		}
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:$client_id;
		$bank_accounts = $this->reports_model->getDetails('bank_accounts',array('client_id' => $fclient_id));

		$data = array(
					'view_file'=>'bank_accounts',
					'current_menu'=>'bank_accounts',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Bank Accounts',
					// 'ledger_title' => 'STATEMENT OF FINANCIAL REPORT',
					// 'report_url' => 'financial_report',
					'ClientDetails' => $ClientDetails,
					// 'financial_report_pdf' => $financial_report_pdf,
					'usertype' => $usertype,
					'bank_accounts' => $bank_accounts,
					// 'current_userid' => $current_userid,
					'headerfiles'   => array(
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
					'footerfiles'   => array(
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
	public function addBankAccount(){
		
		$client_id= $this->session->id;
		$usertype= $this->session->usertype;
		$bank_id = (isset($_GET['bank_id']))?$_GET['bank_id']:'';
		$bankDetail = '';
		if($bank_id !='' )
			$bankDetail = $this->reports_model->getDetails('bank_accounts',array('bank_id' => $bank_id));
		$data = array(
					'view_file'=>'add_bankaccount',
					'current_menu'=>'add_bankaccount',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					'formname' => 'Add',
					'form_action' => 'save_bankaccount',
					'client_id' => $client_id,
					'bankDetail' => $bankDetail,
					'bank_id' => $bank_id,
					//'CostDetails' => $CostDetails,
					// 'Categories' => $Categories,
					// 'subcategories' => $subcategories,
					// 'cost_formact' => 'add_cost',
					'usertype' => $usertype,
					// 'Sets' => $Sets,
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
	public function saveBankAccount(){

		$bank_id = $_POST['bank_id'];
		$client_id = $_POST['client_id'];
		$bank_name = $_POST['bank_name'];
		$bank_number = $_POST['bank_number'];
		$account_type = $_POST['account_type'];
		$currency_color = $_POST['currency_color'];
		
		$cost_array = array( 'bank_name' => $bank_name,'bank_number' => $bank_number,'account_type' => $account_type,'currency_color' => $currency_color,'client_id' => $client_id );
		if($bank_id == '')
		{
			$cost_array['created_on'] = date('Y-m-d H:i:s');
			$bank_id = $this->reports_model->Insert('bank_accounts',$cost_array);
			 // $client_id = '31';
			 $bank_accounts = $this->reports_model->getDetails('bank_accounts',array('client_id' => $client_id));
			 // echo "<pre>";print_r($bank_accounts);echo "</pre>";
			 $bank_accounts_count = sizeof($bank_accounts);
			 if(!empty($bank_accounts) && $bank_accounts_count == 1)
			 	$this->reports_model->Update('report', array('bank_id' => $bank_id),array('user_id' => $client_id,'report_type' => 2));

		}
		else
		{
			$where_array = array('bank_id' => $bank_id);
			$cost_array['updated_on'] = date('Y-m-d H:i:s');			
			$this->reports_model->Update('bank_accounts', $cost_array,$where_array);
		}

		$this->session->set_flashdata('bankaccount', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Bank account Saved Successfully</span></div>');
		redirect(BASE_URL.'client/showBankAccounts');
		
	}



}
