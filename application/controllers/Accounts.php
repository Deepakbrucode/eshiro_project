<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

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
		$this->load->model('accounts_model');
		$this->load->model('client_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
	}
	public function index(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$ReceiptDetails = $this->receipts_model->getReceiptDetails_client(array('file.file_type' => 'payment'));
			$page_url = 'payments';
			$data = array(
					'view_file'=>'show_file',
					'current_menu'=>'add_paymentfile',
					'cusotm_field'=>'File',
					'site_title' =>'Show File',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'ReceiptDetails' => $ReceiptDetails,
					'page_url' => $page_url,
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
									'css/custom.min.css'
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
	public function add_file(){

		if($this->input->get('file_id'))
		{
			$form_name = 'Update';
			$form_action = 'updatereceipt_submit';
			$file_id = $this->input->get('file_id');
			$ReceiptDetail = $this->receipts_model->getReceiptDetails_client(array('file.file_id' => $file_id));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addfile_submit';
			$ReceiptDetail = '';
		}

		//$form_action = 'addfile';
		$page_url = 'payments';
		
		$data = array(
					'view_file'=>'add_file',
					'current_menu'=>'add_paymentfile',
					'cusotm_field'=>'File',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'file_type1' => 'payment',
					'form_action' => $form_action,
					'ReceiptDetail' => $ReceiptDetail,
					'page_url' => $page_url,
					'form_name' => $form_name,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
									'lib/jquery-ui/jquery-ui.css',
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
									'lib/jquery-ui/jquery-ui.js',
									'lib/scripts/app.min.js',
									'lib/scripts/layout.min.js',
									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
	
}
