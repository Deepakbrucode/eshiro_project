<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OpeningBalance extends CI_Controller {

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
		$this->load->model('payments_model');
		$this->load->model('receipts_model');
		$this->load->model('file_model');
		$this->load->model('client_model');
		$this->load->model('reports_model');
		$this->load->helper('url');
	}
	public function index(){
	$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')
			$FileDetails = $this->file_model->getFileDetails_client(array('file.client_id' => $filtered_client_id));
			$page_url = 'file';
			$data = array(
					'view_file'=>'import_cashbook',
					'current_menu'=>'import_cashbook',
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
	public function delete_receipt($receipt_id,$receipt_date){

		$userdata= $this->session->userinfo;
		if($userdata){
			$update_data = array(
				    'account_status' => 0
				);
				$where_data = array('receipt_id' => $receipt_id);
			$insert_status = $this->receipts_model->UpdateReceipt($update_data,$where_data);
			$this->calculate_openingbal($receipt_date);
			if($insert_status)
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Receipt deleted successfully</span></div>');
				redirect(BASE_URL.'receipts/index');
			}
			else
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in receipt delete</span></div>');
				redirect(BASE_URL.'receipts/index');
			}
		}
	}

	public function delete_payment($payment_id,$payment_date){

		$userdata= $this->session->userinfo;
		if($userdata){
			$update_data = array(
				    'account_status' => 0
				);
				$where_data = array('payment_id' => $payment_id);
			$insert_status = $this->payments_model->UpdatePayment($update_data,$where_data);
			$this->calculate_openingbal($payment_date);
			if($insert_status)
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Payment deleted successfully</span></div>');
				redirect(BASE_URL.'payments/index');
			}
			else
			{
				$this->session->set_flashdata('receipts', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in Payment delete</span></div>');
				redirect(BASE_URL.'payments/index');
			}
		}
	}

	public function delete_file($file_id){

		$userdata= $this->session->userinfo;
		if($userdata){
			$payment_date = date('Y-m-d');
			$receipt_date = date('Y-m-d');
			$start_date = date('Y-m-d');
			$filtered_client_id= $this->session->filtered_client_id;
			$update_data = array(
				    'account_status' => 0
				);
				$where_data = array('file_id' => $file_id,'client_id' => $filtered_client_id);
			$insert_status = $this->receipts_model->UpdateReceipt($update_data,$where_data);
			$insert_status = $this->payments_model->UpdatePayment($update_data,$where_data);

			$update_data = array(
				    'account_status' => 0
				);
				$where_data = array('file_id' => $file_id,'client_id' => $filtered_client_id);
			$insert_status = $this->file_model->UpdateFile($update_data,$where_data);


			$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('file_id' => $file_id),'',array('orderby' => 'receipt_date', 'disporder' =>'asc',  'limit' => '1', 'offset' => '0' ));
			if($ReceiptsDetails)
			{
				foreach ($ReceiptsDetails as $ReceiptsDetail) {
					$receipt_date = $ReceiptsDetail->receipt_date;
				}
			}
				
			$PaymentDetails = $this->payments_model->getPaymentDetails(array('file_id' => $file_id),'',array('orderby' => 'payment_date', 'disporder' =>'asc',  'limit' => '1', 'offset' => '0' ));
			if($PaymentDetails)
			{
				foreach ($PaymentDetails as $PaymentDetail) {
					$payment_date = $PaymentDetail->payment_date;
				}
			}
			if(strtotime($receipt_date) > strtotime($payment_date))
			{
				$start_date = $payment_date;
			}
			else
			{
				$start_date = $receipt_date;
			}


			$this->calculate_openingbal($start_date);

			if($insert_status)
			{
				$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File deleted successfully</span></div>');
				redirect(BASE_URL.'file/index');
			}
			else
			{
				$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in file delete</span></div>');
				redirect(BASE_URL.'file/index');
			}
		}
	}

	public function delete_cashbook($month,$year){

		$userdata= $this->session->userinfo;
		if($userdata){

			$filtered_client_id= $this->session->filtered_client_id;


			$update_data = array(
				    'account_status' => 0
				);
			$where_data1 = array('month(receipt_date)' => $month , 'year(receipt_date)' => $year, 'client_id' => $filtered_client_id);
			$insert_status = $this->receipts_model->UpdateReceipt($update_data,$where_data1);

			$where_data2 = array('month(payment_date)' => $month , 'year(payment_date)' => $year, 'client_id' => $filtered_client_id);
			$insert_status = $this->payments_model->UpdatePayment($update_data,$where_data2);

			$update_data = array(
				    'account_status' => 0
				);
				$where_data = array('file_id' => $file_id,'client_id' => $filtered_client_id);
			$insert_status = $this->file_model->UpdateFile($update_data,$where_data);


			$date = $year.'-'.$month.'-01';


			$this->calculate_openingbal($date);

			if($insert_status)
			{
				$this->session->set_flashdata('File', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> File deleted successfully</span></div>');
				redirect(BASE_URL.'reports/index');
			}
			else
			{
				$this->session->set_flashdata('File', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in file delete</span></div>');
				redirect(BASE_URL.'reports/index');
			}
		}
	}
	public function import_cashbook(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')

			$data = array(
					'view_file'=>'import_cashbook',
					'current_menu'=>'import_cashbook',
					'site_title' =>'Import Cashbook',
					'logo'		=> 'logo',
					'title'=>'Import File',
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

	function import_cashmaping(){
		$cashbook_list = array();
		$client_id= $this->session->filtered_client_id;
		$opening_bal_from = $_POST['opening_bal_from'];
		$opening_bal_to = $_POST['opening_bal_to'];
		
		$this->load->library('excel'); 

		if(isset($_FILES['cashbookfile']))
		{
			if ($_FILES['cashbookfile']['size'] > 0) { 


				//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
		         $configUpload['upload_path'] = FCPATH.'uploads/excel/';
		         $configUpload['allowed_types'] = 'xls|xlsx|csv';
		         $configUpload['max_size'] = '5000';
		         $this->load->library('upload', $configUpload);
		         $this->upload->do_upload('cashbookfile');	
		         $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		         $file_name = $upload_data['file_name']; //uploded file name
				 $extension=$upload_data['file_ext'];    // uploded file extension

				 if($extension == '.xls' || $extension == '.xlsx')
		 		{
			
					$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
          			$objReader->setReadDataOnly(true); 		  
		 			$objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);		 //Load excel file 
         			$totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows avalable in excel      	 
         			$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);             //loop from first data untill last data
          			for($i=2;$i<=$totalrows;$i++)
          			{
		            	$date= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();	
		            	if($date != 'Financial Year Start date' && $date != 'DATE' && $date != 'TRUST CASHBOOK' )
		            	{
		            	$phpDateTimeObject = PHPExcel_Shared_Date::ExcelToPHPObject($date);
		            	//$date_value = PHPExcel_Shared_Date::ExcelToPHPObject($date);
		            	$date_value = $phpDateTimeObject->format('Y-m-d');
		            	}
		            	else
		            	{
		            		$date_value = '';
		            	}
		            	//echo $date_value;
		            	//echo "<br>";
		            	$ref= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
		            	if($ref != ''){$ref = $ref;}else {$ref = '';}		
		                $transacion_type= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); 
		                if($transacion_type != ''){$transacion_type = $transacion_type;}else {$transacion_type = '';}
					    $file_no= $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
					    if($file_no != ''){$file_no = $file_no;}else {$file_no = '';}
					    $file_name=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
					    if($file_name != ''){$file_name = $file_name;}else {$file_name = '';}
					    $dr=$objWorksheet->getCellByColumnAndRow(5,$i)->getCalculatedValue();
					    if($dr != ''){$dr = $dr;}else {$dr = '';}
					    $cr=$objWorksheet->getCellByColumnAndRow(6,$i)->getCalculatedValue();
					    if($cr != ''){$cr = $cr;}else {$cr = '';}
					    $balance=$objWorksheet->getCellByColumnAndRow(7,$i)->getCalculatedValue();
					    if($balance != ''){$balance = $balance;}else {$balance = '';}

			    		if($date !='' && ($cr !='' || $dr  !='' ))
		        	 	{
		        	 		$cashbook_list[] = array($date_value,$ref,$transacion_type,$file_no,$file_name,$dr,$cr,$balance); 
		        	 		
		        	 		$insert_data = array(
		        	 			'client_id' => $client_id,
							    'date' => $date_value,
							    'ref' => $ref,
							    'details' => $transacion_type,
							    'file_no' => $file_no,
							    'file_name' => $file_name,
							    'cr' => $cr,
								'dr' => $dr,
								'balance' => $balance
								);


		        	 		$insert_status = $this->reports_model->InsertTempCash($insert_data);
		        	 		//echo "<pre>";print_r($cashbook_list); echo "</pre>";
		        		}
		        		else{}	  
          			}
				}
				else{
			        $fp = fopen($_FILES['cashbookfile']['tmp_name'],'r') or die("can't open file");
			        while($csv_line = fgetcsv($fp,1024))
			        {
			        	

			        	 if($csv_line[0] !='' && $csv_line[2] !='')
			        	 {
			        	 $cashbook_list[] = $csv_line; 

			        	 $date_value= $csv_line[0];
		            	if($date_value != ''){$date_value = $date_value;}else {$date_value = '';}
		            	 $ref= $csv_line[1];
		            	if($ref != ''){$ref = $ref;}else {$ref = '';}			
		                $transacion_type= $csv_line[2]; 
		                if($transacion_type != ''){$transacion_type = $transacion_type;}else {$transacion_type = '';}
					    $file_no= $csv_line[3];
					    if($file_no != ''){$file_no = $file_no;}else {$file_no = '';}
					    $file_name=$csv_line[4];
					    if($file_name != ''){$file_name = $file_name;}else {$file_name = '';}
					    $dr=$csv_line[5];
					    if($dr != ''){$dr = $dr;}else {$dr = '';}
					    $cr=$csv_line[6];
					    if($cr != ''){$cr = $cr;}else {$cr = '';}
					    $balance=$csv_line[7];
					    if($balance != ''){$balance = $balance;}else {$balance = '';}


					    $insert_data = array(
		        	 			'client_id' => $client_id,
							    'date' => $date_value,
							    'ref' => $ref,
							    'details' => $transacion_type,
							    'file_no' => $file_no,
							    'file_name' => $file_name,
							    'cr' => $cr,
								'dr' => $dr,
								'balance' => $balance
								);

			        	 /*$insert_data = array(
			        	 		'client_id' => $client_id,
							    'date' => $csv_line[0],
							    'ref' => $csv_line[1],
							    'details' => $csv_line[2],
							    'file_no' => $csv_line[3],
							    'file_name' => $csv_line[4],
							    'cr' => $csv_line[5],
								'dr' => $csv_line[6],
								'balance' => $csv_line[7],

								);*/


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
			$filtered_client_id= $this->session->filtered_client_id;
			$data = array(
					'view_file'=>'import_cashmaping',
					'current_menu'=>'import_cashmaping',
					'site_title' =>'Import File',
					'logo'		=> 'logo',
					'title'=>'Import File',
					'cashbook_list' => $cashbook_list,
					'opening_bal_from' => $opening_bal_from,
					'opening_bal_to' => $opening_bal_to,
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

	public function import_cashfilesave(){
		
		
		/*$open_bal_array_uniq = array
(
    '0' => '2016-10-01',
    '27' => '2016-11-01',
    '49' => '2016-12-01',
    '60' => '2017-01-01',
    '75' => '2016-04-01',
    '77' => '2016-03-01',
    '106' => '2017-02-01',
   '137' => '2016-05-01',
    '157' => '2016-06-01',
    '199' => '2016-07-01',
    '239' => '2016-08-01',
    '285' => '2016-09-01',
);*/
//$open_bal_value_array_uniq = array('2016-03-01');
		
		//$this->calculate_openbal_cashimport($open_bal_array_uniq,$open_bal_value_array_uniq);



//exit;
		//echo "<pre>";print_r($_POST);echo "</pre>";exit;

		if(isset($_POST['db_column']) && isset($_POST['csv_column']))
		{
			$client_id= $this->session->filtered_client_id;
			$temp_details = $this->reports_model->getTempCashDetails(array('client_id' => $client_id));
			
			$date_index = -1;
			$transacion_type_index = -1;
			$file_no_index = -1;
			$file_name_index = -1;
			$dr_index = -1;
			$cr_index = -1;
			$file_name = 0;
			$dr = 0;
			$cr = 0;
			$count = 0;
			$start_month = '';
			$next_month = '';
			$start_year = '';
			$next_year = '';
			$open_bal_array = array();
			$open_bal_value_array = array();
			//$file_id = '';
			$opening_bal_from = $_POST['opening_bal_from'];
			$opening_bal_to = $_POST['opening_bal_to'];
			
			$db_column = $_POST['db_column'];
			$csv_column = $_POST['csv_column'];
			//echo "<pre>";print_r($temp_details);echo "</pre>";
			$array_temp = json_decode(json_encode($temp_details),true);
			$array_values = array_values($array_temp);
			//echo "<pre>";print_r($array_temp);echo "</pre>";
			//echo "empty";
			//echo "<pre>";print_r($csv_column);echo "</pre>";
			foreach ($db_column as $key => $value) {
				if($value == 'date')
				{
					 $date_index = $key+2;
				}
				else if($value == 'transacion_type')
				{
					$transacion_type_index = $key+2;
				}
				else if($value == 'file_no')
				{
					$file_no_index = $key+2;
				}
				else if($value == 'file_name')
				{
					$file_name_index = $key+2;
				}
				else if($value == 'dr')
				{
					$dr_index = $key+2;
				}
				else if($value == 'cr')
				{
					$cr_index = $key+2;
				}
				else if($value == 'ref')
				{
					$ref_index = $key+2;
				}
				else {}
			}
		//echo "<br>";
			if($date_index != '-1' && $transacion_type_index != '-1' && $file_no_index != '-1' && $file_name_index != '-1' && $dr_index != '-1' && $cr_index != '-1')
			{
				foreach ($array_temp as $key => $values) {

					//echo "<pre>";print_r($values);echo "</pre>";
					$array_values22 = array_values($values);

					//echo "<pre>";print_r($array_values22);echo "</pre>";
					// foreach ($values as $key => $value) {
					// 	echo "key == ".$key." = value = ".$value;
					// 	echo "<br>";
					// }


					$date = $array_values22[$date_index];
					$ref_value = $array_values22[$ref_index];
					$transacion_type = $array_values22[$transacion_type_index];
					$file_no = $array_values22[$file_no_index];
					$file_name = $array_values22[$file_name_index];
					$dr = $array_values22[$dr_index];
					$cr = $array_values22[$cr_index];
					$dr = preg_replace('/\s+/', '', $dr);
					$cr = preg_replace('/\s+/', '', $cr);


				/*}
				foreach ($csv_column as $key => $value) {
					$date = $value[$date_index];
					$transacion_type = $value[$transacion_type_index];
					$file_no = $value[$file_no_index];
					$file_name = $value[$file_name_index];
					$dr = $value[$dr_index];
					$cr = $value[$cr_index];
					$dr = preg_replace('/\s+/', '', $dr);
					$cr = preg_replace('/\s+/', '', $cr);*/

					
					if($date != '' && $date != 'Financial Year Start date' && $date != 'DATE' && $file_no != 'FILE NO' && $transacion_type != 'DETAILS (Transaction Type)' && $dr != 'DEBIT' && $cr != 'CREDIT')
					{
				
				 		 $date_format = date('Y-m-d',strtotime($date));
				 		 $date_date = date('d',strtotime($date));
				 		 $date_month = date('m',strtotime($date));
				 		 $date_year = date('Y',strtotime($date));

				 		 if($date_year != '1999')
				 		 {
				 		  $monthyear = date('Y-m-01',strtotime($date));
				 		 $open_bal_array[] = $monthyear;
				 		}

				 		 
				 		
				 		if($count == 0)
						{
							$start_date = $date_format;
							$start_month = date('m',strtotime($date_format));
							$start_year = date('Y',strtotime($date_format));
						}
						$next_month = date('m',strtotime($date_format));
						$next_year = date('Y',strtotime($date_format));
						if($transacion_type == 'OPENING BALANCE')
						{
							if($dr == '') {$final_amount=$cr;}
							else if($cr == '') {$final_amount=$dr;}
							else{$final_amount=0;}

							$monthyear = date('Y-m-01',strtotime($date));
				 		 	$open_bal_value_array[] = $monthyear;

				 		 	$date_format_open = date('Y-m-01',strtotime($date));

				 		 	$final_amount = str_replace("R","",$final_amount);
						$final_amount = str_replace(",","",$final_amount);
						$final_amount = str_replace(" ","",$final_amount);
						

				 			$OpenDetails = $this->receipts_model->getOpenbalanceDetails(array('openbal_date' => $date_format_open, 'client_id' => $client_id));
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
								    'client_id' => $client_id,
								    'openbal_date' => $date_format_open,
								    'amount' => $final_amount,
								    'status' => 1
								);
								$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);
						 	}

						 	//echo "final amount = ".$final_amount."<br>";
						 }
						 else
						 {
				 			//$file_check = $this->file_model->getFileDetails(array('file_number' => $file_no, 'file_name' => $file_name,'client_id' => $client_id ));
				 			$file_check = $this->file_model->getFileDetails(array('file_number' => $file_no,'client_id' => $client_id ));
						 	if($file_check)
							{
								foreach ($file_check as $key => $value) {
									//$file_id = $value->file_id;
									
									$file_id = $value->file_id;
									if($file_name !='')
									{
										$update_data = array(
											'file_name' => $file_name,
											'account_status' => 1,
											'modified_date' => date('Y-m-d H:i:s')
										);
										$where_date = array(
											'file_id' => $file_id,
											'client_id' => $client_id,
										);

										//print_r($update_data);

										$insert_status = $this->file_model->UpdateFile($update_data,$where_date);
									}
								
								
								}
							}
							else
							{
								$insert_data = array(
							    'client_id' => $client_id,
							    'file_type' => 'all',
							    'file_number' => $file_no,
							    'ledger_openbal' => '0',
							    'file_name' => $file_name,
								'status' => 1
								);
								//print_r($insert_data);

								$insert_status = $this->file_model->InsertFile($insert_data);
								$file_id = $this->db->insert_id();
							}
							
							
							$file_opencheck = $this->file_model->getFileOpeningDetails(array('client_id' => $client_id, 'file_id' => $file_id,'financial_start' => $opening_bal_from, 'financial_end' =>  $opening_bal_to));
						if(!$file_opencheck)
						{
							$insert_data = array(
						    'client_id' => $client_id,
						    'file_id' => $file_id,
						    'financial_start' => $opening_bal_from,
						    'financial_end' => $opening_bal_to,
						    'opening_balance' => '0',
							'status' => 1,
							'created_on' => date('Y-m-d H:i:s'),
							);
							//print_r($insert_data);

							$insert_status = $this->file_model->InsertFileOpen($insert_data);
							//$file_id =  $this->db->insert_id();
							//echo "noo";
						}
						
						
							$lower_tt = strtolower($transacion_type);
							if($dr == '') {

								$final_amount=$cr;
								if($lower_tt == 'payment')
							 	{
							 		$transacion_txt = 'cost';
							 		$type = 'payment';
							 	}
							 	else if($lower_tt == 'bank charges')
							 	{
							 		$transacion_txt = 'bank_charges';
							 		$type = 'payment';
							 	}
							 	else if($lower_tt == 'refund')
							 	{
							 		$transacion_txt = 'refund';
							 		$type = 'payment';
							 	}
							 	else if($lower_tt == 'fee' || $lower_tt == 'fees' || $lower_tt == 'TRF TO BUSINESS')
							 	{
							 		$transacion_txt = 'fee';
							 		$type = 'payment';
							 	}
							 	else
							 	{
							 		$transacion_txt = 'cost';
							 		$type = 'payment';	
							 	}


							}
							else if($cr == '') {

								$final_amount=$dr;
								if($transacion_type == 'deposit')
							 	{
							 		$transacion_txt = 'deposit';
							 		$type = 'receipt';
							 	}
							 	if($transacion_type == 'rtd')
							 	{
							 		$transacion_txt = 'rtd';
							 		$type = 'receipt';
							 	}
							 	else if($transacion_type == 'credit interest')
							 	{
							 		$transacion_txt = 'credit_interest';
							 		$type = 'receipt';
							 	}
							 	else
							 	{
							 		$transacion_txt = 'deposit';
							 		$type = 'receipt';	
							 	}
							}
							else{

								$final_amount=0;
							}

							$final_amount = str_replace("R","",$final_amount);
						$final_amount = str_replace(",","",$final_amount);
						$final_amount = str_replace(" ","",$final_amount);

						 	
						 	
						 	//$date_format = date('Y-m-d',strtotime($date));
						 	if($type == 'receipt')
						 	{
						 		$insert_data = array(
								    'receipt_date' => $date_format,
								     'ref' => $ref_value,
								    //'bank' => $bank,
								    'amount' => $final_amount,
								    'file_id' => $file_id,
								    'client_id' => $client_id,
								    'details' => $transacion_type,
								    'transaction_type' => $transacion_txt,
								    'status' => 1
								);

								$insert_status = $this->receipts_model->InsertReceipts($insert_data);
						 	}
						 	else if($type == 'payment')
						 	{
						 		$insert_data = array(
								    'payment_date' => $date_format,
								     'ref' => $ref_value,
								    //'bank' => $bank,
								    'amount' => $final_amount,
								    'file_id' => $file_id,
								    'client_id' => $client_id,
								    'transaction_type' => $transacion_txt,
								    'details' => $transacion_type,
								    'status' => 1
								);

								$insert_status = $this->payments_model->InsertPayment($insert_data);
						 	}
						 	else
						 	{

						 	}
				 		}
				 		$count++;

				 		/*if($start_month != '' && $next_month !='' && $start_month != $next_month )
				 		{
				 			echo "next month start";
				 			echo "date = ".$start_month."-".$start_year;
				 			echo "<br>";
				 			echo $start_date;
				 			echo "<br>";
				 			echo $date_format;
				 			echo "<br>";

				 			$old_ssdate = $start_year.'-'.$start_month.'-01';
				 			$new_ssdate = $next_year.'-'.$next_month.'-01';
				 			//$old_ssdate_pre = strtotime( date('Y-m-01',strtotime($old_ssdate)).' -1 month');
				 			//$testss = $this->calculate_singleopenbal($old_ssdate,$new_ssdate );
				 			//$this->calculate_openingbal($old_ssdate);
				 			$start_month = $next_month;
				 			$start_year = $next_year;

				 			


				 		}
				 		*/

				 		/*{
				 			calculate_singleopenbal($current_date,$old_date)
				 		}
				 		*/
					}
				}
				//echo "<pre>";print_r($open_bal_array);echo "</pre>";
				//echo "<pre>";print_r($open_bal_value_array);echo "</pre>";
				//echo "<pre>";print_r(array_unique($open_bal_array));echo "</pre>";
				//echo "<pre>";print_r(array_unique($open_bal_value_array));echo "</pre>";
				$open_bal_array_uniq = array_unique($open_bal_array);
				$open_bal_value_array_uniq = array_unique($open_bal_value_array);
				$result_uniq=array_diff($open_bal_array_uniq,$open_bal_value_array_uniq);
				//echo "<pre>";print_r(array_unique($open_bal_array_uniq));echo "</pre>";
				//echo "<pre>";print_r(array_unique($open_bal_value_array_uniq));echo "</pre>";
				
				

				$this->calculate_openbal_cashimport($open_bal_array_uniq,$open_bal_value_array_uniq);

				$this->reports_model->DeletePayment($client_id);
				//print_r(array_unique($a));
				//exit();
				//echo $start_date;
				//$this->calculate_openingbal($start_date);
				$this->session->set_flashdata('import_cashbook', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Cashbook Imported Successfully</span></div>');
				redirect(BASE_URL.'OpeningBalance/import_cashbook');
			}
			else
			{
				$this->session->set_flashdata('import_cashbook', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Error in cashbook import</span></div>');
				//redirect(BASE_URL.'OpeningBalance/import_cashbook');
			}
		}

	}


	public function calculate_openingbal($current_date){
		$filtered_client_id= $this->session->filtered_client_id;
		$current_month = date('m',strtotime($current_date));
		$current_year = date('Y',strtotime($current_date));

		$end_month = date('m');
		$end_year = date('Y');

		$End_OpenBalDetails = $this->receipts_model->getOpenbalanceDetails(array('client_id' => $filtered_client_id),'',array('orderby' => 'openbal_date', 'disporder' => 'desc', 'limit' => '1', 'offset' => '0' ));
		 //echo $this->db->last_query();
		 //echo "<br>";
		 //echo $End_OpenBalDetails;

		if($End_OpenBalDetails)
		{
		 	//echo "dddddddddd";
		 	foreach ($End_OpenBalDetails as $End_OpenBalDetail) {
		 		$end_date = $End_OpenBalDetail->openbal_date;

		 		 $end_month = date('m',strtotime($end_date));
		 		$end_year = date('Y',strtotime($end_date));

		 	}
		 }

		 for($year = $current_year; $year <= $end_year; $year++ )
		 {
		 	if($year == $current_year)
		 	{
		 		$month_start = $current_month;
		 	}
		 	else
		 	{
		 		$month_start = 1;
		 	}
		 	if($year == $end_year)
		 	{
		 		$month_end = $end_month-1;
		 	}
		 	else
		 	{
		 		$month_end = 12;
		 	}
		 	//echo "month_end = ".$month_end;
		 	for($month = $month_start; $month <= $month_end; $month++ )
			 {
			 	//echo "month = ".$month." == year = ".$year;
			 	//echo "<br>";

			 	$update_date = '01-'.$month.'-'.$year;
			 	$bal_id = '';
			 	$recept_amount = 0;
				$payment_amount = 0;
				$openbal_amount = 0;

				$next_Date_str = strtotime( date('Y-m-01',strtotime($update_date)).' +1 month');
				$next_Date = date('Y-m-d',$next_Date_str);

				$open_result = $this->receipts_model->getOpenbalanceDetails(array('openbal_date'=>$next_Date,'client_id' => $filtered_client_id));
				//echo $this->db->last_query();

				if($open_result)
				{
					foreach ($open_result as $key => $value) {
						$client_id = $value->client_id;
						 $bal_id = $value->id;
						 $nxt_openbal_amount = $value->amount;
					}
				}

				

				$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('month(receipt_date)' => $month , 'year(receipt_date)' => $year, 'client_id' => $filtered_client_id,'account_status' => '1'),'sum(amount) as totalamount,count(receipt_id) as ids');
				
				$PaymentDetails = $this->payments_model->getPaymentDetails(array('month(payment_date)' => $month , 'year(payment_date)' => $year, 'client_id' => $filtered_client_id,'account_status' => '1'),'sum(amount) as totalamount,count(payment_id) as ids');

				$OpenBalDetails = $this->receipts_model->getOpenbalanceDetails(array('month(openbal_date)' => $month , 'year(openbal_date)' => $year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(id) as ids');
				//echo $this->db->last_query();

				if($ReceiptsDetails)
				{
					foreach ($ReceiptsDetails as $key => $value) {
						 $recept_amount = $value->totalamount;
					}
				}

				if($PaymentDetails)
				{
					foreach ($PaymentDetails as $key => $value) {
						 $payment_amount = $value->totalamount;
					}
				}

				if($OpenBalDetails)
				{
					foreach ($OpenBalDetails as $key => $value) {
						 $openbal_amount = $value->totalamount;
						//$client_id = $client_id;
					}
				}
				//echo "bal_id = ".$bal_id." = openbal_amount = ".$openbal_amount." = recept_amount = ".$recept_amount." = payment_amount = ".$payment_amount." == ";
				//echo "<br>";
				 $balance_amount = ($openbal_amount+$recept_amount)-$payment_amount;
				//echo "<br>";
				if($bal_id != '')
				{
					$now = date('Y-m-d H:i:s');
					$insert_data = array('amount' => $balance_amount,'modified_date'=> $now);
					$where_data = array('id' => $bal_id);
					$insert_status = $this->receipts_model->UpdateOpeningBalance($insert_data,$where_data);
					//echo $this->db->last_query(); 
				}
				else
				{
					//$current_month = date('Y-m-01',$currentDate);;

		     		$insert_data = array(
						    'client_id' => $filtered_client_id,
						    'openbal_date' => $next_Date,
						    'amount' => $balance_amount,
						    'status' => 1
						);

						$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);

					//echo "function exit";
					//exit;
				}

			 }
		 }
	}




	public function calculate_openbal_cashimport($open_array,$previous_open_array){
		// $current_date = '2016-03-31';
		$filtered_client_id= $this->session->filtered_client_id;

		if($open_array) {

		sort($open_array);

		$first_date = reset($open_array);
    $last_date = end($open_array);

    $first_month = date('m', strtotime($first_date));
    $first_year = date('Y',strtotime($first_date));
    $last_month = date('m',strtotime($last_date));
    $last_year = date('Y', strtotime($last_date));
    //$year_count = 0;
    
    $year_counttt = 0;
    $month_countt = 0;

    for($year_start = $first_year; $year_start <= $last_year; $year_start ++)
    {
    	//echo "year = ".$year_start;
    	/*if($year_count > 1)
    	{
    		$first_month = 1;
    	}*/
    	$year_counttt++;
if( $year_counttt == '1')
{
	$first_monthdd = $first_month;
}
else
{
	$first_monthdd = '01';
}


    	





    	//for($month_start = 01; $month_start <= 12; $month_start ++){
	
		for($month_start = $first_monthdd; $month_start <= 12; $month_start ++)
    	{
    		$month_countt++;
    		$monthNum = str_pad($month_start, 2, "0", STR_PAD_LEFT);

    		$current_date = $year_start.'-'.$monthNum.'-01';
    		$bal_id = '';

    	if (!in_array($current_date, $previous_open_array))
		{

			//echo "not in array =".$current_date."<br>";

	//echo "cur date = ".$current_date;
	//echo "<pre>";print_r($previous_open_array);echo "</pre>";		
//echo "month = ".$month_start;
			$previous_Date_str = strtotime( date('Y-m-01',strtotime($current_date)).' -1 month');
		 $previous_Date = date('Y-m-d',$previous_Date_str);

		 $previous_month = date('m',strtotime($previous_Date));
			 $previous_year = date('Y',strtotime($previous_Date));



		$open_result = $this->receipts_model->getOpenbalanceDetails(array('openbal_date'=>$current_date,'client_id' => $filtered_client_id));
		//echo $this->db->last_query();

		if($open_result)
		{
			foreach ($open_result as $key => $value) {
				//$openbal_amount = $value->totalamount;
				$client_id = $value->client_id;
				$bal_id = $value->id;
				$opem_amount = $value->amount;
			}
			//print_r($open_result);
			//echo "resulttttt";
		}
		$recept_amount = 0;
		$payment_amount = 0;
		$openbal_amount = 0;
		$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('month(receipt_date)' => $previous_month , 'year(receipt_date)' => $previous_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(receipt_id) as ids');
		//echo $this->db->last_query();
		$PaymentDetails = $this->payments_model->getPaymentDetails(array('month(payment_date)' => $previous_month , 'year(payment_date)' => $previous_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(payment_id) as ids');
		
		$OpenBalDetails = $this->receipts_model->getOpenbalanceDetails(array('month(openbal_date)' => $previous_month , 'year(openbal_date)' => $previous_year, 'client_id' => $filtered_client_id),'sum(amount) as totalamount,count(id) as ids');
		
		//echo "++++++++++<br>";
		if($ReceiptsDetails)
		{
			foreach ($ReceiptsDetails as $key => $value) {
				 $recept_amount = $value->totalamount;
			}
		}
		//echo "==re =========";
		if($PaymentDetails)
		{
			foreach ($PaymentDetails as $key => $value) {
				 $payment_amount = $value->totalamount;
			}
		}
		//echo "== pay =========";
		if($OpenBalDetails)
		{
			foreach ($OpenBalDetails as $key => $value) {
				 $openbal_amount = $value->totalamount;
				//$client_id = $client_id;
			}
		}
		//echo "== open =========";
		//$balance_amount = ($openbal_amount+$payment_amount)-$recept_amount;
		
		$balance_amount = ($openbal_amount+$recept_amount)-$payment_amount;
		//echo "current_date = ".$current_date." = balance_amount = ".$balance_amount."<br>";
		if($bal_id != '')
		{
			
			if($balance_amount <= 0 && $month_countt == '1')
			{
				$neew_blaamount = $opem_amount;
			}
			else
			{
				$neew_blaamount = $balance_amount;
			}
			$insert_data = array( 'amount' => $neew_blaamount);
			$where_data = array('id' => $bal_id);
			$insert_status = $this->receipts_model->UpdateOpeningBalance($insert_data,$where_data);
			//echo $this->db->last_query();
		}

		else
		{
     		$insert_data = array(
				    'client_id' => $filtered_client_id,
				    'openbal_date' => $current_date,
				    'amount' => $balance_amount,
				    'status' => 1
				);

				$insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);
				//echo $this->db->last_query();

		}

		}



    		if($month_start == $last_month && $year_start == $last_year)
    		{
    			break;
    		}
    	}
    	//echo "<br>";
    	//$year_count++;
    }






		/*foreach ($open_array as $open_array_val) {

			

			$current_date = $open_array_val."-01";
			$bal_id = '';

			// $current_month = date('m',strtotime($current_date));
			// $current_year = date('Y',strtotime($current_date));

		$previous_Date_str = strtotime( date('Y-m-01',strtotime($current_date)).' -1 month');
		 $previous_Date = date('Y-m-d',$previous_Date_str);

		 $previous_month = date('m',strtotime($previous_Date));
			 $previous_year = date('Y',strtotime($previous_Date));


		//$previous_monthyear = date('Y-m',$previous_Date_str);
		//echo "<br>";



	}*/

	}		
}

	public function financial_rollback(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			//array('file.file_type' => 'receipt')
			$FileDetails = $this->file_model->getFileDetails_client(array('file.client_id' => $filtered_client_id));
			$page_url = 'file';
			$data = array(
					'view_file'=>'financial_rollback',
					'current_menu'=>'financial_rollback',
					'site_title' =>'Trust Manager',
					'logo'		=> 'logo',
					'title'=>'Financial year roll forward',
					'FileDetails' => $FileDetails,
					'page_url' => $page_url,
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/bootstrap-switch/css/bootstrap-switch.min.css',
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
									'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
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
	public function ajax_rollforward(){
		 $roll_back_pfrom = $_POST['roll_back_pfrom'];
		 $roll_back_pto = $_POST['roll_back_pto'];
		 $roll_back_nfrom = $_POST['roll_back_nfrom'];
		 $roll_back_nto = $_POST['roll_back_nto'];
		 $filtered_client_id= $this->session->filtered_client_id;
		
		$previous_from = '01-'.$roll_back_pfrom;
		$previous_to = '01-'.$roll_back_pto;
		$next_from = '01-'.$roll_back_nfrom;
		$next_to = '01-'.$roll_back_nto;

		$previous_from = date('Y-m-01',strtotime($previous_from));
		$previous_to = date('Y-m-t',strtotime($previous_to));
		$next_from = date('Y-m-01',strtotime($next_from));
		$next_to = date('Y-m-t',strtotime($next_to));
			
			
		/*********** financial year end balance ******/
		$ReceiptsDetails_open = $this->receipts_model->getReceiptsDetails(array('receipt_date >=' => $previous_from ,'receipt_date <=' => $previous_to, 'client_id' => $filtered_client_id),'sum(amount) as receipt_total,count(file_id)');
			//echo $this->db->last_query();
			$PaymentDetails_open = $this->payments_model->getPaymentDetails(array('payment_date >=' => $previous_from ,'payment_date <=' => $previous_to, 'client_id' => $filtered_client_id),'sum(amount) as payment_total,count(file_id)');
					if($ReceiptsDetails_open)
					{
						foreach ($ReceiptsDetails_open as $ReceiptsDetail_open) {
							
							$receipt_total = $ReceiptsDetail_open->receipt_total;
							$receipt_total = (float) $receipt_total;
							//$trial_balance[$kk]['receipt_total'] = $receipt_totals;
						}

					}
					

					//$trial_balance[$kk]['receipt_total'] = $receipt_totals;
					if($PaymentDetails_open)
					{
						foreach ($PaymentDetails_open as $PaymentDetail_open) {
							//$trial_balance[$kk]['payment_total'] = $PaymentDetail->payment_total;
							$payment_total = $PaymentDetail_open->payment_total;
							$payment_total = (float) $payment_total;
						}
					}
					//$Open_total = $payment_total - $receipt_total;
					$Open_total = $receipt_total - $payment_total;
					//echo $receipt_total.' == '.$payment_total;
					
					$OpenbalDetails = $this->receipts_model->getOpenbalanceDetails(array('client_id' => $filtered_client_id, 'openbal_date ' => $previous_from));
					
					//echo $this->db->last_query();
					
			if($OpenbalDetails)
			{
				foreach($OpenbalDetails  as $OpenbalDetail)
				{
					$open_amount = $OpenbalDetail->amount;
					$openbal_total = (float) $open_amount;
					$Open_total = $Open_total + $openbal_total;
					//$Open_total = $Open_total - $openbal_total;
					//$Open_total = abs($Open_total);
				}
			}
			
			 $total_balance_new = $Open_total;
			//echo "<br>";
			$date1 = strtotime($next_from);
			//echo "<br>";
			//echo date('Y-m-d',$date1);
			//echo "<br>";
			$date2 = '01-'.$roll_back_nto;
			$date2 = strtotime($date2);
			//$date2 = strtotime('-2 MONTH', $date2);
			//echo date('Y-m-d',$date2);
			//echo "sssss<br>";
			do
			{
				$current_date = date('Y-m-d',$date1);
				
				$open_result = $this->receipts_model->getOpenbalanceDetails(array('openbal_date'=>$current_date,'client_id' => $filtered_client_id));
				
				if(!$open_result)
    {
		$insert_data = array(
            'client_id' => $filtered_client_id,
            'openbal_date' => $current_date,
            'amount' => $total_balance_new,
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s')
        );

        $insert_status = $this->receipts_model->InsertOpeningBalance($insert_data);
        
     
      //echo $this->db->last_query();
    }

    else
    {
        
        //echo $this->db->last_query();

 $insert_data = array( 'amount' => $total_balance_new,'modified_date' => date('Y-m-d H:i:s'));
      $where_data = array('openbal_date'=>$current_date,'client_id' => $filtered_client_id);
      $insert_status = $this->receipts_model->UpdateOpeningBalance($insert_data,$where_data);
      
    }
    
    
			}while (($date1 = strtotime('+1 MONTH', $date1)) <= $date2);
			//echo "<br>";
			
			/*********** /financial year end balance ******/
			
			/************ file opening balance *********/
			$fileDetails = $this->reports_model->get_filebyfileopen($filtered_client_id,$roll_back_pfrom,$roll_back_pto);
			
			
					
					
			
			//echo $this->db->last_query();
			//print_r($fileDetails);
				//	exit();
				$kk=0;
			if($fileDetails)
			{
				//print_r($fileDetails);
				//	exit();
				foreach ($fileDetails as $fileDetail) {
					$balancess = 0;
					$payment_total = 0;
					$receipt_total = 0;
					$file_id = $fileDetail->file_id;
					$file_name = $fileDetail->file_name;
					$file_number = $fileDetail->file_number;
					$ledger_openbal = $fileDetail->ledger_openbal;
					$ledger_openbal = $fileDetail->opening_balance;
					$trial_balance[$kk]['file_id'] = $file_id;
					$trial_balance[$kk]['file_name'] = $file_name;
					$trial_balance[$kk]['file_number'] = $file_number;
					$trial_balance[$kk]['receipt_total'] = 0;
					$trial_balance[$kk]['payment_total'] = 0;
					$ledger_openbal = (float) $ledger_openbal;
					$receipt_totals = $ledger_openbal;
					$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('client_id' => $filtered_client_id,'receipt_date >=' => $previous_from ,'receipt_date <=' => $previous_to, 'file_id' => $file_id),'sum(amount) as receipt_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					//echo $this->db->last_query();
					$PaymentDetails = $this->payments_model->getPaymentDetails(array('client_id' => $filtered_client_id,'payment_date >=' => $previous_from ,'payment_date <=' => $previous_to, 'file_id' => $file_id),'sum(amount) as payment_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					//echo $this->db->last_query();
					
					if($ReceiptsDetails)
					{
						foreach ($ReceiptsDetails as $ReceiptsDetail) {
							
							$receipt_total = $ReceiptsDetail->receipt_total;
							$receipt_total = (float) $receipt_total;
							//$receipt_totals = $ledger_openbal + $receipt_total;
							$trial_balance[$kk]['receipt_total'] = $receipt_total;
						}

					}
					

					//$trial_balance[$kk]['receipt_total'] = $receipt_totals;
					if($PaymentDetails)
					{
						foreach ($PaymentDetails as $PaymentDetail) {
							$payment_total = $PaymentDetail->payment_total;
							$trial_balance[$kk]['payment_total'] = $PaymentDetail->payment_total;
						}
					}
					// $ledger_balance =  $receipt_totals - $payment_total;
					//echo "<br>";
					
					//echo "payment_total = ".$payment_total." == receipt_total == ".$receipt_total;
					  //$balancess =  $payment_total - $receipt_total;
					   $balancess =  $receipt_total - $payment_total;
                       $ledger_balance =  $balancess + $ledger_openbal;
                                                               //echo "<br>";
                                                             
                                                               
                                                               
                                                               // echo "<br>";
                                                               // $ledger_balance += $balancess;
                                                                //$balance_amt = "R".money_format('%!i', $balance);
                                                              //  $balance_amt = "R".number_format($balancess,2);
                                                                
                                                                
					
					$file_opencheck = $this->file_model->getFileOpeningDetails(array('client_id' => $filtered_client_id, 'file_id' => $file_id,'financial_start' => $roll_back_nfrom, 'financial_end' =>  $roll_back_nto));
					$ledger_balance = number_format($ledger_balance, 2, '.', '');
            if(!$file_opencheck)
            {
              $insert_data = array(
                'client_id' => $filtered_client_id,
                'file_id' => $file_id,
                'financial_start' => $roll_back_nfrom,
                'financial_end' => $roll_back_nto,
                'opening_balance' => $ledger_balance,
              'status' => 1,
              'created_on' => date('Y-m-d H:i:s'),
              );
             // print_r($insert_data);

              $insert_status = $this->file_model->InsertFileOpen($insert_data);
              //$file_id =  $this->db->insert_id();
              //echo "noo";
            }
            else
            {

				//echo "<pre>";print_r($file_opencheck);echo "</pre>";
					$update_data = array(
                'client_id' => $filtered_client_id,
                'file_id' => $file_id,
                'financial_start' => $roll_back_nfrom,
                'financial_end' => $roll_back_nto,
                'opening_balance' => $ledger_balance,
              'status' => 1,
              'modified_on' => date('Y-m-d H:i:s'),
              );
              $where_date = array('client_id' => $filtered_client_id, 'file_id' => $file_id,'financial_start' => $roll_back_nfrom, 'financial_end' =>  $roll_back_nto);
             // print_r($update_data);
              $insert_status = $this->file_model->UpdateFileOpen($update_data,$where_date);
			}
            
            

					$kk++;
				}

				//echo "<pre>";print_r($trial_balance);echo "</pre>"; echo $startDate;
				//exit();

			}
		$this->session->set_flashdata('Rollback', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> FINANCIAL YEAR ROLL FORWARD</span></div>');
		redirect(BASE_URL.'/OpeningBalance/financial_rollback');
			//echo "<pre>";print_r($trial_balance);echo "</pre>";
			/************ /file opening balance *********/
		
		exit;
	}
	

}
