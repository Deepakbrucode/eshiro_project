<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

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
		$this->load->model('receipts_model');
		$this->load->model('client_model');
		$this->load->model('file_model');
		$this->load->helper('url');
	}
	public function index(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')
			$FileDetails = $this->file_model->getFileDetails_client(array('file.client_id' => $filtered_client_id,'file.account_status' => '1'));
			$page_url = 'file';
			$data = array(
					'view_file'=>'show_file',
					'current_menu'=>'show_file',
					'site_title' =>'Show File',
					'logo'		=> 'logo',
					'title'=>'accounting software',
					'FileDetails' => $FileDetails,
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
	public function add_file(){

		if($this->input->get('file_id'))
		{
			$form_name = 'Update';
			$form_action = 'updatefile_submit';
			$file_id = $this->input->get('file_id');
			$FileDetail = $this->file_model->getFileDetails_client(array('file.file_id' => $file_id));
		}
		else
		{
			$form_name = 'Add';
			$form_action = 'addfile_submit';
			$FileDetail = '';
		}
		$page_url = 'file';
		$ClientDetails = $this->client_model->getClientDetails();
		
		$data = array(
					'view_file'=>'add_file',
					'current_menu'=>'add_file',
					'cusotm_field'=>'File',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Add File',
					'file_type1' => 'all',
					'form_action' => $form_action,
					'FileDetail' => $FileDetail,
					'page_url' => $page_url,
					'form_name' => $form_name,
					'ClientDetails' => $ClientDetails,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/rs-plugin/css/pi.settings.css',
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
									'lib/select2/js/select2.full.min.js',
									),
								"priority" => 'high'
								)
				);

		$this->template->load_admin_template($data);
	}
	public function addfile_submit(){
		$file_type = $this->input->post('file_type');
		$file_name = $this->input->post('file_name');
		//$client = $this->input->post('client');
		$client_id = $this->input->post('client_id');
		$file_number = $this->input->post('file_number');
		$ledger_openbal = $this->input->post('ledger_openbal');
		$case_type = $this->input->post('case_type');
		$cell_phone = $this->input->post('cell_phone');
		$telephone = $this->input->post('telephone');
		$email = $this->input->post('email');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($ledger_openbal == ''){$ledger_openbal = 0;}


		$file_check = $this->file_model->getFileDetails(array('file_number' => $file_number, 'file_name' => $file_name));
		if(!$file_check || $file_check == '')
		{

		/*if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}*/
		$insert_data = array(
		    'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'ledger_openbal' => $ledger_openbal,
		    'file_name' => $file_name,
		    'case_type' => $case_type,
		    'cell_no' => $cell_phone,
		    'telephone_no' => $telephone,
		    'email' => $email,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'status' => 1
		);
		//print_r($insert_data);

		$insert_status = $this->file_model->InsertFile($insert_data);
		//echo $this->db->last_query();
		//exit;
		if($insert_status)
		{
		$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Added Successfully</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}
		else
		{
			$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Insert</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
		}

	}
	else{
		$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Name and File Number already exits</span></div>');
		redirect(BASE_URL.$page_url.'/add_file');
	}

		exit;
	}


	public function addfile_ajax(){
		$file_type = $this->input->post('file_type');
		$file_name = $this->input->post('file_name');
		//$client = $this->input->post('client');
		$client_id = $this->input->post('client_id1');
		$file_number = $this->input->post('file_number');
		$ledger_openbal = $this->input->post('ledger_openbal');
		$case_type = $this->input->post('case_type');
		$cell_phone = $this->input->post('cell_phone');
		$telephone = $this->input->post('telephone');
		$email = $this->input->post('email');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($ledger_openbal == ''){$ledger_openbal = 0;}

		$file_check = $this->file_model->getFileDetails(array('file_number' => $file_number, 'file_name' => $file_name));
		if(!$file_check || $file_check == '')
		{

		/*if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			$client_id = $this->db->insert_id();
		}*/
		$insert_data = array(
		    'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'ledger_openbal' => $ledger_openbal,
		    'file_name' => $file_name,
		    'case_type' => $case_type,
		    'cell_no' => $cell_phone,
		    'telephone_no' => $telephone,
		    'email' => $email,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'status' => 1
		);
		//print_r($insert_data);

		$insert_status = $this->file_model->InsertFile($insert_data);
		//echo $this->db->last_query();
		//exit;
		if($insert_status)
		{
		$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Added Successfully</span></div>');
		//redirect(BASE_URL.$page_url.'/add_file');
		}
		else
		{
			$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in File Insert</span></div>');
		//redirect(BASE_URL.$page_url.'/add_file');
		}
		$FileDetails = $this->file_model->getFileDetails();
	     echo json_encode($FileDetails);
	     }
	else{
		//$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Name and File Number already exits</span></div>');
		$FileDetails = array('error');
		echo json_encode($FileDetails);
		//echo "error";
		//redirect(BASE_URL.$page_url.'/add_file');
	}
		exit;
	}




	public function updatefile_submit(){
		$file_id = $this->input->post('file_id');
		$file_name = $this->input->post('file_name');
		$client = $this->input->post('client');
		$client_id = $this->input->post('client_id');
		$file_type = $this->input->post('file_type');
		$file_number = $this->input->post('file_number');
		$ledger_openbal = $this->input->post('ledger_openbal');
		$case_type = $this->input->post('case_type');
		 $cell_no = $this->input->post('cell_phone');
		$physical_addr = $this->input->post('physical_address');
		$postal_addr = $this->input->post('postal_address');
		$telephone_no = $this->input->post('telephone');
		$email = $this->input->post('email');
		//$status = $this->input->post('status');
		$page_url = $this->input->post('page_url');
		if($ledger_openbal == ''){$ledger_openbal = 0;}
		if($client_id == '')
		{
			$insert_data = array(
			    'firm_name' => $client,
			    'status' => 1
			);

			$insert_status = $this->client_model->InsertClient($insert_data);
			 $client_id = $this->db->insert_id();
			//exit();
		}
		$insert_data = array(
			'client_id' => $client_id,
		    'file_type' => $file_type,
		    'file_number' => $file_number,
		    'ledger_openbal' => $ledger_openbal,
		    'file_name' => $file_name,
		    'case_type' => $case_type,
		     'cell_no' => $cell_no,
		    'physical_address' => $physical_addr,
		    'postal_address' => $postal_addr,
		    'telephone_no' => $telephone_no,
		    'email' => $email,
		    'status' => 1
		);
		$where_date = array(
			'file_id' => $file_id
		);

		$insert_status = $this->file_model->UpdateFile($insert_data,$where_date);
		if($insert_status)
		{
		$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Updated successfully</span></div>');
		redirect(BASE_URL.$page_url.'/index');
		}
		else
		{
			$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Update</span></div>');
		redirect(BASE_URL.$page_url.'/index');
		}
		exit;
	}
	function clear_clientob()
	{
		 $file_id = $_GET['file_id'];
		//exit();
		$insert_data = array(

		    'ledger_openbal' => 0,

		);
		$where_date = array(
			'file_id' => $file_id
		);

		$insert_status = $this->file_model->UpdateFile($insert_data,$where_date);
		redirect(BASE_URL.'file/index');
	}

	 function delete_file($file_id,$page_url)
    {
    	//echo $page_url;
    	//exit();
    	//$page_url = $this->input->post('page_url');
        //delete employee record
        //$this->db->where('file_id', $id);
      // $this->db->delete('file');
       $insert_data = array(
		    'status' => 0
		);
		$where_date = array(
			'file_id' => $file_id
		);

		$insert_status = $this->file_model->UpdateFile($insert_data,$where_date);
        redirect(BASE_URL.$page_url.'/index');
    }
    function get_FileDetails(){
    	$client_id = $_POST['client_id'];
    	if($client_id !='')
    	$FileDetails = $this->file_model->getFileDetails(array('client_id' => $client_id));
    else
    	$FileDetails = $this->file_model->getFileDetails();
    	echo json_encode($FileDetails);
    	exit();
    }
    public function import_file(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')
			$FileDetails = $this->file_model->getFileDetails_client(array('file.client_id' => $filtered_client_id));
			$page_url = 'file';
			$data = array(
					'view_file'=>'import_file',
					'current_menu'=>'import_file',
					'site_title' =>'Import File',
					'logo'		=> 'logo',
					'title'=>'Import File',
					'FileDetails' => $FileDetails,
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
	function import_maping(){
		$client_lists = array();
		$this->load->library('excel'); 





//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
         $configUpload['upload_path'] = FCPATH.'uploads/excel/';
         $configUpload['allowed_types'] = 'xls|xlsx|csv';
         $configUpload['max_size'] = '5000';
         $this->load->library('upload', $configUpload);
         $this->upload->do_upload('userfile');	
         $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
         $file_name = $upload_data['file_name']; //uploded file name
		 echo $extension=$upload_data['file_ext'];    // uploded file extension


		 if($extension == '.xls' || $extension == '.xlsx')
		 {
		
$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
 //$objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
          //Set to read only
          $objReader->setReadDataOnly(true); 		  
        //Load excel file
		 $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);		 
         $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows avalable in excel      	 
         $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
          //loop from first data untill last data
          for($i=2;$i<=$totalrows;$i++)
          {
              $sno= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();	
              $file_name= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();		
              $file_no= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); 
			  $dr= $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
			  $cr=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue();



			  //if($sno !='' && $file_name !='' && $file_no !='')
			  	//if($sno !=''  && $file_no !='')
		        	// {
		        	 $client_lists[] = array($sno,$file_name,$file_no,$dr,$cr); 
		        	 //echo "<pre>";print_r($client_lists); echo "</pre>";
		        //	}
		        //	else{}



			
              
						  
          }




}
else if($extension == '.csv')
{

		if(isset($_FILES['userfile']))
		{
			if ($_FILES['userfile']['size'] > 0) { 
				$count=0;
		        $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
		        while($csv_line = fgetcsv($fp,1024))
		        {
		        	 if($csv_line[0] !='')
		        	 {
		        	 $client_lists[] = $csv_line; 
		        	// echo "<pre>";print_r($csv_line); echo "</pre>";
		        	}
		        }
		        fclose($fp) or die("can't close file");
			}
		}

		// echo "<pre>";print_r($client_lists);echo "</pre>";

	}
	else{

		$this->session->set_flashdata('import_file', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Not allowed to upload the file. Please check your file extensions</span></div>');
				redirect(BASE_URL.'file/import_file');

	}

//exit();

		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')
			//$FileDetails = $this->file_model->getFileDetails_client(array('file.client_id' => $filtered_client_id));
			$page_url = 'file';
			$data = array(
					'view_file'=>'import_maping',
					'current_menu'=>'import_maping',
					'site_title' =>'Import File',
					'logo'		=> 'logo',
					'title'=>'Import File',
					'client_lists' => $client_lists,
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

	public function import_filesave(){
		//echo "<pre>";print_r($_POST);echo "</pre>";
		if(isset($_POST['db_column']) && isset($_POST['csv_column']))
		{
			$filtered_client_id= $this->session->filtered_client_id;
			$filename_index = -1;
			$fileno_index = -1;
			$cr_amount_index = -1;
			$dr_amount_index = -1;
			$month_year_index = -1;
			$db_column = $_POST['db_column'];
			$csv_column = $_POST['csv_column'];
			//$omonth_name = '';
			$omonth_name =  $odate = $oyear = '';
			foreach ($db_column as $key => $value) {
				if($value == 'file_name')
				{
					$filename_index = $key;
				}
				else if($value == 'file_no')
				{
					$fileno_index = $key;
				}
				else if($value == 'cr_amount')
				{
					$cr_amount_index = $key;
				}
				else if($value == 'dr_amount')
				{
					$dr_amount_index = $key;
				}
				else if($value == 'month_year')
				{
					$month_year_index = $key;
				}
				else {}
			}
			if($filename_index != '-1' && $fileno_index != '-1' && $cr_amount_index != '-1')
			{
				foreach ($csv_column as $key => $value) {
					$file_name = $value[$filename_index];
					$file_no = $value[$fileno_index];
					$amount = $value[$cr_amount_index];
					$dr_amount = $value[$dr_amount_index];
					$month_year = $value[$month_year_index];
					if($dr_amount !='' && $month_year == 'Financial Year Start date')
					{
						//echo "i can find it";
						//echo $dr_amount;
						$omonth_name = $dr_amount;
						$odate = $file_no;
						$oyear = $amount;

					}
					if($file_name == 'BALANCE PER BANK STATEMENT')
					{
						//echo"gfdgdG";
						 $oamount = $dr_amount;
						if($omonth_name !='' && $odate !='' && $oyear !='')
						{
							$omonth_num = date("m", strtotime($omonth_name));
							 $date_value = $oyear.'-'.$omonth_num.'-'.$odate;

							$date_format_open = date('Y-m-d',strtotime($date_value));
							$final_amount = str_replace("R","",$oamount);
							$final_amount = str_replace(",","",$final_amount);
							$final_amount = str_replace(" ","",$final_amount);
							$OpenDetails = $this->receipts_model->getOpenbalanceDetails(array('openbal_date' => $date_format_open, 'client_id' => $filtered_client_id));
							if($OpenDetails)
						 	{

						 		foreach ($OpenDetails as $OpenDetail) {
						 			$open_id = $OpenDetail->id;
						 			$update_data = array('amount' => $final_amount);
						 			$where_data = array('id' => $open_id);
						 			$update_status = $this->receipts_model->UpdateOpeningBalance($update_data,$where_data);
						 		}
						 	}
						 	else
						 	{

						 		$insert_data = array(
								    'client_id' => $filtered_client_id,
								    'openbal_date' => $date_format_open,
								    'amount' => $final_amount,
								    'status' => 1
								);
								$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);
						 	}
						 	//echo $this->db->last_query();
						 	//exit();

						}
					}
					if($file_name != 'Names' && $file_no != 'File No' && $amount != 'Cr' && $file_name !='' && $file_no !='')
					{
						//echo "dddddddddddd";
						$amount = str_replace("R","",$amount);
						$amount = str_replace(",","",$amount);

						$file_check = $this->file_model->getFileDetails(array('file_number' => $file_no, 'file_name' => $file_name,'client_id' => $filtered_client_id ));
						if($file_check)
						{
							foreach ($file_check as $key => $value) {
								$file_id = $value->file_id;
								$update_data = array(
								    'ledger_openbal' => $amount,
								    'account_status' => 1
								);
								$where_date = array(
									'file_id' => $file_id,
									'client_id' => $filtered_client_id,
								);

								//print_r($update_data);

								$insert_status = $this->file_model->UpdateFile($update_data,$where_date);
							}
						//echo "<pre>";print_r($file_check);	echo "</pre>";
						}
						else
						{
							$insert_data = array(
						    'client_id' => $filtered_client_id,
						    'file_type' => 'all',
						    'file_number' => $file_no,
						    'ledger_openbal' => $amount,
						    'file_name' => $file_name,
							    'status' => 1
							);
							//print_r($insert_data);

							$insert_status = $this->file_model->InsertFile($insert_data);
							//echo "noo";
						}
						//echo $this->db->last_query();
					}
					
				}
				//exit();

				$this->session->set_flashdata('import_file', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File Imported Successfully</span></div>');
				redirect(BASE_URL.'file/import_file');


			}
			else
			{
				$this->session->set_flashdata('import_file', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in file import</span></div>');
				redirect(BASE_URL.'file/import_file');
			}
		}
	}



}
