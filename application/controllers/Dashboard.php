<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->load->model('dashboard_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
	}
	public function index(){



		$data = array(
					'view_file'=>'dashboard',
					'current_menu'=>'dashboard',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Dashboard',

					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'lib/select2/css/select2.min.css',
									'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js',
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/select2/js/select2.full.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
	public function profile()
	{
			$data = array(
		'view_file'=>'profile',
					'current_menu'=>'profile',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'profile',
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'lib/select2/css/select2.min.css',
									'lib/select2/css/select2-bootstrap.min.css',
									'css/components.min.css',
									'css/plugins.min.css',
									'css/layout.css',
									'css/themes/blue.css',
									'css/custom.min.css'
									),
								"js" => array(
									'lib/jquery-1.11.0.min.js',
								),
								"priority" => 'high'
								),
					'footerfiles'   => array(
								"js" => array(
									'lib/bootstrap/js/bootstrap.min.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									'lib/select2/js/select2.full.min.js',

									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
public function passwordsave(){
	
//
//echo $userid;
if($_SESSION['usertype']!=5)
{
	
	$userdata= $this->session->userinfo;
		
	$userclientid = $_SESSION['id'];
	$clientinfo = $this->user_model->getcli($userclientid);
	$pass=$clientinfo['password'];
		$oldpass=$this->input->post('password');
		$newpass=$this->input->post('newpassword');
		$newrepass=$this->input->post('newrepassword');
	if($pass==$oldpass)
	{
		if(($newpass==$newrepass)&&($oldpass!=$newpass))
		{
		$data = array('password'=>($newpass),'modified'=>date('Y-m-d H:i:s'));
		$updatedata = $this->user_model->Update($data, array('id'=>$userclientid));
		
		//~ $this->session->set_flashdata('profile', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User password has been saved successfully.</span></div>');
		//~ redirect(BASE_URL.'dashboard/profile');
		$this->session->set_flashdata('report', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Password Updated successfully</span></div>');
		redirect(BASE_URL.'client/edit?id='.$userclientid);
		}
		else
		{
			$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> check new password and confirm password must be equal...</span></div>');
		redirect(BASE_URL.'client/edit?id='.$userclientid);
		}
	}
	else
	{
		$this->session->set_flashdata('report', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Enter correct password</span></div>');
		redirect(BASE_URL.'client/edit?id='.$userclientid);
	}
}

	else 
	{
		$admininfo = $this->user_model->getAdmin();
		$pass=$admininfo['password'];
		$userdata= $this->session->userinfo;
		
		$userid= $_SESSION['id'];
			$oldpass=$this->input->post('password');
		$newpass=$this->input->post('newpassword');
		$newrepass=$this->input->post('newrepassword');
		
		if(($pass==$oldpass)&&($newpass==$newrepass))
		{
		$data = array('password'=>($newpass),'modified'=>date('Y-m-d H:i:s'));
		$updatedata = $this->user_model->update($data, array('id'=>$userid));
		
		$this->session->set_flashdata('profile', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> password updated successfully.</span></div>');
		redirect(BASE_URL.'dashboard/profile');
		}
		else
		{
		$this->session->set_flashdata('profile', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> check new password and confirm password must be equal...</span></div>');
		redirect(BASE_URL.'dashboard/profile');
		}
	}
		 
	}
	public function session_client(){
		$client_id = $this->input->post('client_id');
		$ClientDetails = $this->client_model->getClientDetails(array('client_id' => $client_id));
		if($ClientDetails){

                                                foreach ($ClientDetails as $client) {
                                                	$client_name = $client->firm_name;
                                                	$start_month = $client->financial_month_start;
                                                	$end_month = $client->financial_month_end;

                                                }
                                            }
		$this->session->set_userdata(array(
										'filtered_client_id' => $client_id,
										'filtered_client_name' => $client_name,
										'filtered_start_month' => $start_month,
										'filtered_end_month' => $end_month
								));

		redirect(BASE_URL.'dashboard/');

	}
}
