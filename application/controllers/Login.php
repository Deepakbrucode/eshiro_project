<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->model('user_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
		
	}
	public function index(){
		$this->session->sess_destroy();
		$data = array(
					'view_file'=>'login',
					'current_menu'=>'index',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Login',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/select2/css/select2.min.css',
									'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'lib/pages/css/login.min.css',
									'css/themes/blue.css',
									'css/custom.min.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/jquery-validation/js/jquery.validate.min.js',
									'lib/jquery-validation/js/additional-methods.min.js',
									'lib/select2/js/select2.full.min.js',
									'lib/pages/scripts/login.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_login_template($data);
	}

		public function submitlogin()
		{
		$uname = $this->input->post('username');
		$upass = $this->input->post('password');
		$auth = $this->user_model->auth($uname,$upass);
		if(($auth != FALSE)&&($auth != 'deactivated'))
		{

			$this->session->set_userdata(array(
			'id' => $auth->id,
			'user_name'  => $auth->username,
			'filtered_client_name1' =>$auth->username,
			'filtered_client_id1' => $auth->id,
			'email'      => $auth->email,
			'picture'    => $auth->picture,
			 'usertype' => $auth->usertype,
			'userinfo'=>$auth
			));
			redirect(BASE_URL.'dashboard/');
		}
		else if(($auth == FALSE)&&($auth != 'deactivated'))
		{
			
			//echo "dddddDDD";exit;
			$auth1 = $this->user_model->clientauth($uname,$upass);
			//echo $this->db->last_query();exit;
			if(($auth1 != FALSE)&&($auth1 != 'deactivated'))
			{
				$this->session->set_userdata(array(
				'id' => $auth1->id,
				'userinfo'=>$auth1,
				'usertype' => 10,
				'email'      => $auth1->email,
				'filtered_client_id' => $auth1->id,
				'filtered_client_name' =>$auth1->name,
				'filtered_client_name1' =>$auth1->name,
				));
			redirect(BASE_URL.'dashboard/');
			}
			else
			{
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> check username and password or need approval from admin so wait for some time</span></div>');
			redirect(BASE_URL.'login');
			}
		}
		else if(($auth != FALSE)&&($auth == 'deactivated'))
		{
		$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User has been deactivated. Please contact superadmin</span></div>');
		redirect(BASE_URL.'login');
		}
		else
		{
		$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Username or password may be wrong.Please check username and password</span></div>');
		redirect(BASE_URL.'login');
		}
		
}
	public function logout(){
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('picture');
		$this->session->unset_userdata('userinfo');
		$this->session->sess_destroy();
		redirect(BASE_URL.'login');
	}
	public function register(){
		$data = array(
					'view_file'=>'register',
					'current_menu'=>'index',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Register',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/select2/css/select2.min.css',
									'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'lib/pages/css/login.min.css',
									'css/themes/blue.css',
									'css/custom.min.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/jquery-validation/js/jquery.validate.min.js',
									'lib/jquery-validation/js/additional-methods.min.js',
									'lib/select2/js/select2.full.min.js',
									'lib/pages/scripts/login.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_login_template($data);
	}
	public function insert()  
	{  
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, 8 );
		
		
		$data = array(
		'name'=>$this->input->post('name'),
		'username'=>$this->input->post('emailid'),
		'email'=> $this->input->post('emailid'),
		'phone'=> $this->input->post('mobile'),
		'trading_name'=> $this->input->post('trading_name'),
		'vat_no'=> $this->input->post('vat_no'),
		'address1'=> $this->input->post('address1'),
		'address2'=> $this->input->post('address2'),
		'zip_code'=> $this->input->post('zip_code'),
		'financial_month_start'=> $this->input->post('start_month'),
		'financial_month_end'=> $this->input->post('end_month'),
		'password'=>$password,
		'created_date'=>date('Y-m-d'),
		'usertype'=> 10,
		'status'=>0,
		);
		
		$email = $this->input->post('emailid');
		$name= $this->input->post('name');
		$mob=$this->input->post('mobile');
		$vat_no=$this->input->post('vat_no');
		$result = $this->user_model->checkEmail($email);
		$mail=count($result);
		if($mail > 0)
		{
		$this->session->set_flashdata('register', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>EmailId Already Exists</span></div>');
		redirect(BASE_URL.'login/register');
	    }
		else
		{
			// $check_vat_qur = $this->db->query("select * from usermaster where vat_no = '".$vat_no."'");
			// $check_vat = $check_vat_qur->row();
			// $check_vat=count($check_vat);
			// if($check_vat > 0)
			// {
			// 	$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>VAT Number Already Exists</span></div>');
			// 	redirect(BASE_URL.'login/register');
			// }
			// else
			// {
				
				$userid = $this->user_model->insert($data);//insert query
				$userinfo = $this->user_model->getAdmin();
				$adminname = $userinfo['username'];
				$adminemail = $userinfo['email'];

				//$this->user_model->sendEmail($adminname,$adminemail,$name,$emailid,$password); 
				//mail functions
				$to = $adminemail;
				$headers ='From:'.$email;
				$subject ='New User Registration';
				$subject1 ='Waiting for admin approval';
				$txt='Client Name:              '.$name ."\r\n"; 
				$txt.='Client Contact No:        '.$mob ."\r\n"; 
				$txt.='Client Username:    '.$email ."\r\n"; 
				$txt.='Client Password:    '.$password ."\r\n"; 

				$txt1='Name:              '.$name ."\r\n"; 
				$txt1.='Contact No:        '.$mob ."\r\n"; 
				$txt1.='Username:    '.$email ."\r\n"; 
				$txt1.='Password:    '.$password ."\r\n"; 


				$txt.='waiting for approval to get login '."\r\n";
				mail($to,$subject,$txt,$headers);
				mail($email,$subject1,$txt1,$headers);
				// mail('vijayasanthi@stallioni.com',$subject1,$txt1,$headers);
				

				$this->session->set_flashdata('login', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Registered successfully.</span></div>');
				redirect(BASE_URL.'login');
			// }
		} 
	}

	public function forgot_password(){
		$data = array(
					'view_file'=>'forgot_password',
					'current_menu'=>'index',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									// 'lib/select2/css/select2.min.css',
									// 'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'lib/pages/css/login.min.css',
									'css/themes/blue.css',
									'css/custom.min.css'
									),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/jquery-1.11.0.min.js',
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/jquery-validation/js/jquery.validate.min.js',
									'lib/jquery-validation/js/additional-methods.min.js',
									// 'lib/select2/js/select2.full.min.js',
									'lib/pages/scripts/login.min.js',
									'lib/pages/scripts/login-4.js',
									'lib/backstretch/jquery.backstretch.min.js'

									),
								"priority" => 'high'
								)
				);

		$this->template->load_login_template($data);
	} 
	public function forgot_passwordmail(){
		$emailid = $this->input->post('emailid');
		$checkEmail = $this->user_model->checkEmail($emailid);
		if($checkEmail)
		{
			$userinfo = $this->user_model->getAdmin();
			$adminname = $userinfo['username'];
			$adminemail = $userinfo['email'];
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
			$password = substr( str_shuffle( $chars ), 0, 8 );

			$to = $emailid;
			$headers ='From:'.$adminemail;
			$subject ='Forget Password';
			$txt ='Your password has been changed. Please login with new password.' ."\r\n"; 
			$txt .='New Password: '.$password ."\r\n"; 
			mail($to,$subject,$txt,$headers);

			$this->user_model->update(array('password'=>$password), array('email'=> $emailid));


			$this->session->set_flashdata('login', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Mail Send successfully.Please check your mail for new password</span></div>');
			redirect(BASE_URL.'login');
		}
		else
		{
			$this->session->set_flashdata('forgot_password', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> The provided mail id not valid. please enter valid mail id.</span></div>');
			redirect(BASE_URL.'login/forgot_password');
		}
		
	}
}
