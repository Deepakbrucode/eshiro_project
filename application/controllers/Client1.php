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
        //show_404();
	}
	public function index(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$ClientDetails = $this->client_model->getClientDetails();
			$data = array(
					'view_file'=>'show_client',
					'current_menu'=>'show_client',
					'site_title' =>'Show Client',
					'logo'		=> 'logo',
					'title'=>'accounting software',
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
	}
	public function add_client(){
		
		if($this->input->get('client_id'))
		{
			$form_name = 'Update';
			$form_action = 'updateclient_submit';
			$client_id = $this->input->get('client_id');
			$ClientDetail = $this->client_model->getClientDetails(array('client_id' => $client_id));

		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addclient_submit';
			$ClientDetail = '';
		}
		
		$data = array(
					'view_file'=>'add_client',
					'current_menu'=>'add_client',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'formname' => $form_name,
					'ClientDetail' => $ClientDetail,
					'form_action' => $form_action,
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
	
	public function addclient_submit(){
		//print_r($this->input->post());exit();
		$firm_name = $this->input->post('firm_name');
		$directors = $this->input->post('directors');
		$registered_addr = $this->input->post('registered_address');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$bank_accounts = $this->input->post('bank_accounts');
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		//$status = $this->input->post('status');
		$insert_data = array(
		    'firm_name' => $firm_name,
		    'directors' => $directors,
		    'registered_address' => $registered_addr,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'bank_accounts' => $bank_accounts,
		    'financial_month_start' => $start_month,
		    'financial_month_end' => $end_month, 
		    'status' => 1
		);

		$insert_status = $this->client_model->InsertClient($insert_data);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details inserted successfully</span></div>');
		redirect(BASE_URL.'client/add_client');
		}
		else
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
		redirect(BASE_URL.'client/add_client');
		}
		exit;
	}
	public function addclient_ajax(){
		//print_r($this->input->post());exit();
		$firm_name = $this->input->post('firm_name');
		$directors = $this->input->post('directors');
		$registered_addr = $this->input->post('registered_address');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$bank_accounts = $this->input->post('bank_accounts');
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		//$status = $this->input->post('status');
		$insert_data = array(
		    'firm_name' => $firm_name,
		    'directors' => $directors,
		    'registered_address' => $registered_addr,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'bank_accounts' => $bank_accounts,
		    'financial_month_start' => $start_month,
		    'financial_month_end' => $end_month, 
		    'status' => 1
		);

		$insert_status = $this->client_model->InsertClient($insert_data);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details inserted successfully</span></div>');
			
		//redirect(BASE_URL.'client/add_client');
		}
		else
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in insert</span></div>');
			//echo "0";
		//redirect(BASE_URL.'client/add_client');
		}
		$ClientDetails = $this->client_model->getClientDetails();
	     echo json_encode($ClientDetails);
		exit;
	}

	public function updateclient_submit(){
		$client_id = $this->input->post('client_id');
		$firm_name = $this->input->post('firm_name');
		$directors = $this->input->post('directors');
		$registered_addr = $this->input->post('registered_address');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$bank_accounts = $this->input->post('bank_accounts');
		$start_month = $this->input->post('start_month');
		$end_month = $this->input->post('end_month');
		//$status = $this->input->post('status');
		$insert_data = array(
		    'firm_name' => $firm_name,
		    'directors' => $directors,
		    'registered_address' => $registered_addr,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'bank_accounts' => $bank_accounts,
		    'financial_month_start' => $start_month,
		    'financial_month_end' => $end_month, 
		    'status' => 1
		);
		$where_date = array(
			'client_id' => $client_id
		);

		$insert_status = $this->client_model->UpdateClient($insert_data,$where_date);
		if($insert_status)
		{
		$this->session->set_flashdata('client', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Client details Undated successfully</span></div>');
		redirect(BASE_URL.'client/add_client');
		}
		else
		{
			$this->session->set_flashdata('client', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
		redirect(BASE_URL.'client/add_client');
		}
		exit;
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
	function delete_client($client_id)
    {
        //delete employee record
      //  $this->db->where('client_id', $id);
      // $this->db->delete('clients');

       $insert_data = array(
		    'status' => 0
		);
		$where_date = array(
			'client_id' => $client_id
		);

		$insert_status = $this->client_model->UpdateClient($insert_data,$where_date);

        redirect(BASE_URL.'client/index');
    }
	

}
