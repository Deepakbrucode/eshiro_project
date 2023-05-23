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
		$this->load->helper('url');
		
	}
	public function index(){
		
		$data = array(
					'view_file'=>'login',
					'current_menu'=>'index',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
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

	public function submitlogin(){
		$uname = $this->input->post('username');
		$upass = $this->input->post('password');
		$auth = $this->user_model->auth($uname,$upass);
		if(($auth != FALSE)&&($auth != 'deactivated')){
			$this->session->set_userdata(array(
										'id' => $auth->id,
										'user_name'  => $auth->username,
										'email'      => $auth->email,
										'picture'    => $auth->picture,
										'userinfo'=>$auth
								));
			redirect(BASE_URL.'dashboard/');
		}else if(($auth != FALSE)&&($auth == 'deactivated')){
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User has been deactivated. Please contact superadmin</span></div>');
			redirect(BASE_URL.'login');
		}else{
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Username or password may be wrong.Please check username and password</span></div>');
			redirect(BASE_URL.'login');
		}
		exit;
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

}
