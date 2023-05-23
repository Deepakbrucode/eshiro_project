<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		$this->load->model('reports_model');
		$this->load->model('client_model');
		$this->load->model('receipts_model');
		$this->load->model('payments_model');
		$this->load->model('file_model');
		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
		$this->load->helper('url');
		 $this->load->library('excel');
	}
	public function index(){




		




            //exit;











/*
		$this->load->library('Fpdf_gen');
		
		$this->fpdf->SetFont('Arial','B',16);
		$this->fpdf->Cell(40,10,'Hello World!');
		
		echo $this->fpdf->Output('hello_world.pdf','D');

		


				$pdf = new Pdf('P', 'mm', 'A1', true, 'UTF-8', false);
$pdf->SetTitle('Cashbook');
//$pdf->SetHeaderMargin(0);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Vijayasanthi');
$pdf->SetDisplayMode('real', 'default');



$pdf->AddPage();
$html=$this->load->view('client1', $data, true);

$html .= '<style>'.file_get_contents(FCPATH.'css/cashbookpdf.css').'</style>';


//$pdf->Write(5, $html);

 $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true); 


//$pdf->Output('http://stallioni.in/accounts/uploads/My-File-Name.pdf', 'F');
$pdf->Output(FCPATH.'uploads/My-File-Name.pdf', 'F');

*/
/*

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');

$pdf->AddPage();

$pdf->Write(5, 'Some sample text dsffffffdfs');
//$pdf->Output('http://stallioni.in/accounts/uploads/My-File-Name.pdf', 'F');
$pdf->Output(FCPATH.'uploads/My-File-Name.pdf', 'F');


*/


//$pdf->Output(dirname(__FILE__).'/pdf/test.pdf', 'F');

$filtered_client_id= $this->session->filtered_client_id;
$CashDetails = $this->reports_model->get_CashMonthYear($filtered_client_id);
		
		$data = array(
					'view_file'=>'cashbook',
					'current_menu'=>'cashbook',
					'cusotm_field'=>'Cashbook',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Cashbook',
					'CashDetails' => $CashDetails,
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


	public function ajax_cashbook(){
		$month=$_POST['month'];
		$year=$_POST['year'];
		$month_name=$_POST['month_name'];
		$filtered_client_id= $this->session->filtered_client_id;
		$ReceiptsDetails = $this->reports_model->getCashReceiptsDetails($month,$year,$filtered_client_id);
		$PaymentDetails = $this->reports_model->getCashPaymentDetails($month,$year,$filtered_client_id);
		$OpenBalDetails = $this->reports_model->getCashOpenbalDetails($month,$year,$filtered_client_id);






		//$ledgerarray=[];
		$csvarray=[];
		$kk=0;
		if(!empty($OpenBalDetails))
		{
			foreach ($OpenBalDetails as $OpenBalDetail) {
				/*$ledgerarray['open'][$kk]['id'] = $OpenBalDetail->file_id;
				$ledgerarray['open'][$kk]['date'] = '';
				$ledgerarray['open'][$kk]['str_date'] = 1;
				//$ledgerarray[$kk]['bank'] = $ReceiptsDetail->bank;
				$ledgerarray['open'][$kk]['amount'] = $OpenBalDetail->ledger_openbal;
				$ledgerarray['open'][$kk]['client_id'] = $OpenBalDetail->client_id;
				$ledgerarray['open'][$kk]['file_id'] = $OpenBalDetail->file_id;
				$ledgerarray['open'][$kk]['file_number'] = $OpenBalDetail->file_number;
				$ledgerarray['open'][$kk]['transaction_type'] = $OpenBalDetail->file_name;
				$ledgerarray['open'][$kk]['ledger_type'] = 'opening_balance';*/

				$openbal_date = $OpenBalDetail->openbal_date;
               $openbal_date = date('d-M-Y', strtotime($openbal_date));
				$csvarray[$kk]['date']=$openbal_date;
				$csvarray[$kk]['date_str']= 1;
				$csvarray[$kk]['description']='';
				$csvarray[$kk]['fileno']='';
				$csvarray[$kk]['filename']= 'Opening Balance';
				$csvarray[$kk]['dr']='';
				$csvarray[$kk]['cr']= $OpenBalDetail->amount;
				//$csvarray[$kk]['balance']= $OpenBalDetail->ledger_openbal;
				$kk++;
			}

		}
		if(!empty($ReceiptsDetails))
		{
			//$kk=0;
			foreach ($ReceiptsDetails as $ReceiptsDetail) {
				$rec_date = $ReceiptsDetail->receipt_date;
				$receipt_date = date('d-M-Y', strtotime($rec_date));
				/*$ledgerarray['other'][$kk]['id'] = $ReceiptsDetail->receipt_id;
				$ledgerarray['other'][$kk]['date'] = $receipt_date;
				$ledgerarray['other'][$kk]['str_date'] = strtotime($rec_date);
				//$ledgerarray[$kk]['bank'] = $ReceiptsDetail->bank;
				$ledgerarray['other'][$kk]['amount'] = $ReceiptsDetail->amount;
				$ledgerarray['other'][$kk]['client_id'] = $ReceiptsDetail->client_id;
				$ledgerarray['other'][$kk]['file_id'] = $ReceiptsDetail->file_id;
				$ledgerarray['other'][$kk]['file_number'] = $ReceiptsDetail->file_number;
				$ledgerarray['other'][$kk]['transaction_type'] = $ReceiptsDetail->transaction_type;
				$ledgerarray['other'][$kk]['ledger_type'] = 'receipt';*/

				$csvarray[$kk]['date']= $receipt_date;
				$csvarray[$kk]['date_str']= strtotime($rec_date);
				$csvarray[$kk]['description']= $ReceiptsDetail->transaction_type;
				$csvarray[$kk]['fileno']=$ReceiptsDetail->file_number;
				$csvarray[$kk]['filename']=$ReceiptsDetail->file_name;
				$csvarray[$kk]['dr']= '';
				$csvarray[$kk]['cr']=$ReceiptsDetail->amount;
				

				$kk++;
			}
		}
		if(!empty($PaymentDetails))
		{
			
			foreach ($PaymentDetails as $PaymentDetail) {
				$pay_date = $PaymentDetail->payment_date;
				$payment_date = date('d-M-Y', strtotime($pay_date));
				/*$ledgerarray['other'][$kk]['id'] = $PaymentDetail->payment_id;
				$ledgerarray['other'][$kk]['date'] = $payment_date;
				$ledgerarray['other'][$kk]['str_date'] = strtotime($pay_date);
				//$ledgerarray[$kk]['bank'] = $PaymentDetail->bank;
				$ledgerarray['other'][$kk]['amount'] = $PaymentDetail->amount;
				$ledgerarray['other'][$kk]['client_id'] = $PaymentDetail->client_id;
				$ledgerarray['other'][$kk]['file_id'] = $PaymentDetail->file_id;
				$ledgerarray['other'][$kk]['file_number'] = $PaymentDetail->file_number;
				$ledgerarray['other'][$kk]['transaction_type'] = $PaymentDetail->transaction_type;
				$ledgerarray['other'][$kk]['ledger_type'] = 'payment';*/

				$csvarray[$kk]['date']= $payment_date;
				$csvarray[$kk]['date_str']= strtotime($pay_date);
				$csvarray[$kk]['description']= $PaymentDetail->transaction_type;
				$csvarray[$kk]['fileno']=$PaymentDetail->file_number;
				$csvarray[$kk]['filename']=$PaymentDetail->file_name;
				$csvarray[$kk]['dr']= $PaymentDetail->amount;
				$csvarray[$kk]['cr']= '';
				


				$kk++;
			}
		}

		 /*usort($ledgerarray['other'], function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['str_date'] - $b['str_date'];
		    return $retval;
		});*/

		 usort($csvarray, function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['date_str'] - $b['date_str'];
		    return $retval;
		});






		 $filtered_client_name= $this->session->filtered_client_name;

		$balance_total = 0;

		$csv_handler = fopen (FCPATH.'uploads/cashbook.csv','w');


		setlocale(LC_MONETARY, 'en_IN');

		$cn = array($filtered_client_name, '', '', '', '');
		fputcsv($csv_handler, $cn);

		$fn = array('TRUST CASHBOOK ', '', '', '', '', '');
		fputcsv($csv_handler, $fn);

		$fnn = array($month_name.'-'.$year, '', '', '', '', '');
		fputcsv($csv_handler, $fnn);

		$dummy = array('', '', '', '', '', '');
		fputcsv($csv_handler, $dummy);

		$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');
		fputcsv($csv_handler, $header);

		$excel_array=[];
		$ajax_array = [];
		$array_count=7;


		foreach ($csvarray as $data) {

			$dr_val = $data['dr'];
			$cr_val = $data['cr'];
			$transaction_type = $data['description'];
			$trans_txt = '';

			if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; }
			else if($transaction_type == 'rtd'){$trans_txt = 'RTD';  }
			else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest';  }
			else if($transaction_type == 'refund'){$trans_txt = 'Refund'; }
			else if($transaction_type == 'cost'){$trans_txt = 'Cost';  }
			else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges';  }
			else if($transaction_type == 'fee'){$trans_txt = 'Fee';}
			else {$trans_txt=''; }

			$dr_val = (float) $dr_val;
			$cr_val = (float) $cr_val;

			$balance_total += $cr_val;
			$balance_total -= $dr_val;
			//$bal_val = $cr_val - $dr_val;

			if($cr_val !='' ) {$cr_amount = "R".money_format('%!i', $cr_val);$cr_amount_xl = money_format('%!i', $cr_val);} else {$cr_amount ="";$cr_amount_xl = '';}
			if($dr_val !='' ) {$dr_amount = "R".money_format('%!i', $dr_val);$dr_amount_xl = money_format('%!i', $dr_val);} else {$dr_amount ="";$dr_amount_xl='';}
			//$dr_amount = "R".money_format('%!i', $dr_val);
			$bal_amount = "R".money_format('%!i', $balance_total);
			$bal_amount_xl = money_format('%!i', $balance_total);

			$new_array = array( $data['date'], $data['filename'], $data['fileno'], $trans_txt, $dr_amount, $cr_amount, $bal_amount);
			$excel_array[] = array( $data['date'], $data['filename'] , $data['fileno'], $trans_txt, $dr_amount_xl, $cr_amount_xl, $bal_amount_xl);
			$ajax_array[] = array( $data['date'], $data['filename'] , $data['fileno'], $trans_txt, $dr_amount, $cr_amount, $bal_amount);
			$array_count++;
            fputcsv($csv_handler, $new_array);   // put array content into csv
        }


		$bal_amount = "R".money_format('%!i', $balance_total);
		$footer = array('', '', '', '', '','', $bal_amount);
		fputcsv($csv_handler, $footer);

		fclose ($csv_handler);



		/*********** EXCEL function start *************/

		$month_year = $month_name.'-'.$year;

		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'TRUST CASHBOOK');
        $this->excel->getActiveSheet()->setCellValue('A3', $month_year);
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'File Name');
        $this->excel->getActiveSheet()->setCellValue('C5', 'File No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Transaction Type');
        $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');
        $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('E'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

            $bal_amount = money_format('%!i', $balance_total);
            $final_xl = 'G'.$array_count;
            $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            //$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/cashbook.xls');


			 /*********** /EXCEL function end *************/




		$cashbook_array = [];
		$cashbook_array['receipt'] = $ReceiptsDetails; 
		$cashbook_array['payment'] = $PaymentDetails; 
		$cashbook_array['openbal'] = $OpenBalDetails; 
		 $bal_amount = "R".money_format('%!i', $balance_total);

		$ajax_array[] = array( '', '' , '', '', '', '', $bal_amount);






		$data = array(
			'view_file'=>'cashbook_pdf',
			'title'=>'Cashbook',
			'filtered_client_name' => $filtered_client_name,
			'ReceiptsDetails' => $ReceiptsDetails,
			'PaymentDetails' => $PaymentDetails,
			'OpenBalDetails' => $OpenBalDetails,
			'month' => $month,
			'year' => $year,
			'month_name' => $month_name,
			'ajax_array' => $ajax_array,
			);

			// Load all views as normal
			$this->load->view('cashbook_pdf',$data);
			// Get output html
			$html = $this->output->get_output();
		

			// Load library
			$this->load->library('dompdf_gen');
		
			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper(array(0, 0, 600, 600), "portrait");
			$this->dompdf->render();
			//$this->dompdf->stream("welcome.pdf");
			//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));


			$output = $this->dompdf->output();
			file_put_contents(FCPATH.'uploads/cashbook.pdf', $output);





		//echo json_encode($cashbook_array);
		echo json_encode($ajax_array);
		exit;
		//$ReceiptsDetails = $this->receipts_model->getReceiptsDetails('','',array('groupby' => 'MONTH(receipt_date),YEAR(receipt_date)','orderby'=> 'YEAR(receipt_date)','disporder'=> 'ASC'));
		//$PaymentDetails = $this->payments_model->getPaymentDetails('','MONTH(payment_date) as cash_month,YEAR(payment_date) as cash_year',array('groupby' => 'MONTH(payment_date),YEAR(payment_date)', 'orderby'=> 'YEAR(payment_date)','disporder'=> 'ASC'));
	}


		public function cashbook_list(){

//Select (CASE WHEN month(payment_date) > 2 THEN concat(YEAR(payment_date),'-', YEAR(payment_date)+1)  ELSE concat(YEAR(payment_date)-1,'-', YEAR(payment_date)) END) AS FiscalYear, sum(amount) as total_amount from payment_cfrb group by (CASE WHEN month(payment_date) > 2 THEN year(payment_date)+1 ELSE year(payment_date) END)

		//Select (CASE WHEN month(receipt_date) > 2 THEN concat(YEAR(receipt_date),'-', YEAR(receipt_date)+1)  ELSE concat(YEAR(receipt_date)-1,'-', YEAR(receipt_date)) END) AS FiscalYear, sum(amount) as total_amount from receipt_drc group by (CASE WHEN month(receipt_date) > 2 THEN year(receipt_date)+1 ELSE year(receipt_date) END)

//Select (CASE WHEN month(openbal_date) > 2 THEN concat(YEAR(openbal_date),'-', YEAR(openbal_date)+1) ELSE concat(YEAR(openbal_date)-1,'-', YEAR(openbal_date)) END) AS FiscalYear, sum(amount) as total_amount from cashbook_opening_balance group by (CASE WHEN month(openbal_date) > 2 THEN year(openbal_date)+1 ELSE year(openbal_date) END)

$financial_array = [];
$filtered_client_id= $this->session->filtered_client_id;
$CashDetails = $this->reports_model->get_CashMonthYear($filtered_client_id);
$ReceiptsDetails = $this->reports_model->cashbook_lreceipt($filtered_client_id);
$PaymentDetails = $this->reports_model->cashbook_lpayment($filtered_client_id);
$OpenbalancesDetails = $this->reports_model->cashbook_lopenbal($filtered_client_id);
if($ReceiptsDetails)
{
	foreach ($ReceiptsDetails as $ReceiptsDetail) {
		$financial_array[] = $ReceiptsDetail->FiscalYear;
	}
}
if($PaymentDetails)
{
	foreach ($PaymentDetails as $PaymentDetail) {
		$financial_array[] = $PaymentDetail->FiscalYear;
	}
}
if($OpenbalancesDetails)
{
	foreach ($OpenbalancesDetails as $OpenbalancesDetail) {
		$financial_array[] = $OpenbalancesDetail->FiscalYear;
	}
}
	$financial_array = array_unique($financial_array);
	sort($financial_array);	
		$data = array(
					'view_file'=>'cashbook_list',
					'current_menu'=>'cashbook_list',
					'cusotm_field'=>'Cashbook',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Cashbook',
					'CashDetails' => $CashDetails,
					'financial_array' => $financial_array,
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

	public function ajax_cashbookyear(){

		setlocale(LC_MONETARY, 'en_IN');
		$filtered_client_name= $this->session->filtered_client_name;

		//$month=$_POST['month'];

		//SELECT * FROM `payment_cfrb` as p where month(p.payment_date)='03' and year(p.payment_date)='2016' union all select * from `receipt_drc` as r where month(r.receipt_date)='03' and year(r.receipt_date)='2016' ORDER BY `payment_date` DESC

		//echo "ssssssssssssssss";
		//exit();
		 $year=$_GET['year'];
		//$month_name=$_POST['month_name'];


		 $filtered_client_id= $this->session->filtered_client_id;
		
$full_details = [];


		$years=explode("-",$year);
		//print_r($years);
		if($years[0] !='' && $years[1] !='')
		{
			$year_start = $years[0];
			$year_end = $years[1];
			for($month=3;$month <= 12;$month++)
				{
					//echo "jjj = ".$jjj." -- year".$year_start;
					//echo "<br>";
					//$full_details

					
					//$MonthDetails = $this->reports_model->cashbook_montdetails($month,$year_start,$filtered_client_id);
					//$full_details[] = $this->reports_model->getCashOpenbalDetails($month,$year_start,$filtered_client_id);
					$date= $year_start."-".$month."-01";
					$full_details[$date] = $this->cashbook_arrayfun($month,$year_start,$filtered_client_id);

				}
				for($month=1;$month <= 2;$month++)
				{
					$date= $year_end."-".$month."-01";

					$full_details[$date] = $this->cashbook_arrayfun($month,$year_end,$filtered_client_id);
					//echo "jjj = ".$jjj." -- year".$year_end;
					//echo "<br>";

					//$MonthDetails = $this->reports_model->cashbook_montdetails($month,$year_start,$filtered_client_id);
					//$OpenBalDetails = $this->reports_model->getCashOpenbalDetails($month,$year_start,$filtered_client_id);

				}

		}
		//echo "<pre>";print_r($full_details);echo "</pre>";

		$table_count = 2;
		//$table_count = 0;
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'TRUST CASHBOOK');

        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);



		$cbd_txt = '<p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;">'.$filtered_client_name.'</p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;">TRUST CASHBOOK </p>';
		
		if($full_details)
		{
			foreach ($full_details as $key => $value) {
				$balance_total = 0;
				$title_date = date('F-Y', strtotime($key));
				$open_bal = $value['open'];
        		$all_val = $value['all'];
				if(!empty($all_val))
		        {
		        	if($table_count == '2')
		        	 $table_count = $table_count+1;
		        	else
		        		 $table_count = $table_count+10;
		        	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $title_date);
		        	$this->excel->getActiveSheet()->mergeCells('A'.$table_count.':G'.$table_count);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        	 $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setSize(14);

		        	$table_count = $table_count+2;

		        	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, 'Date');
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, 'Details');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, 'File No');
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, 'File Nmae');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, 'DR');
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, 'CR');
			        $this->excel->getActiveSheet()->setCellValue('G'.$table_count, 'Balance');

			        $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F'.$table_count)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G'.$table_count)->getFont()->setBold(true);




				$cbd_txt .= "<p style='font-weight: bold;text-align: center;font-size:13px;margin: 10px 0px 15px;'>".$title_date."</p>";

				$cbd_txt .= "<table class='table table-striped table-hover stl_table  cbd_table'><thead><tr><td>Date</td><td>Details</td><td>File No</td><td>File Name</td><td>Dr</td><td>Cr</td><td>Balance</td></tr></thead>";

		        if(!empty($open_bal))
		        {
		            foreach($open_bal as $okey => $ovalue){

		            	$table_count++;
		                $odate = $ovalue->openbal_date;
		                $odate_new = date('d-M-Y', strtotime($odate));
		                $oamount = $ovalue->amount;
		                $oamount = (float) $oamount;
		               /* if($oamount !='')
                            $oformat_amount = "R".money_format('%!i', $oamount) ;
                        else
                        	$oformat_amount = 0;*/

                        $balance_total = $oamount;

                        $balance_total_amt = "R".money_format('%!i', $balance_total) ;

		                $cbd_txt .= "<tr><td>".$odate_new."</td><td>Opening Balance</td><td></td><td></td><td></td><td>".$balance_total_amt."</td><td>".$balance_total_amt."</td></tr>";

		                $this->excel->getActiveSheet()->setCellValue('A'.$table_count, $odate_new);
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, 'Opening Balance');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, '');
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, $balance_total_amt);
			        $this->excel->getActiveSheet()->setCellValue('G'.$table_count, $balance_total_amt);


		            }
		        }
		        if(!empty($all_val))
		        {
		            foreach($all_val as $akey => $avalue){

		            	$table_count++;

		                $adate = $avalue->selected_date;
		                $transaction_type = $avalue->transaction_type;
		                $aamount = $avalue->amount;
		                $file_name = $avalue->file_name;
		                $file_number = $avalue->file_number;
		                $cr_amount = '';
		                $dr_amount = '';
		                $aamount = (float) $aamount;
		                


		                $adate_new = date('d-M-Y', strtotime($adate));
		                
		                if($aamount !='')
                            $oformat_amount = "R".money_format('%!i', $aamount) ;
                        else
                        	$oformat_amount = 0;

                        
                        if($transaction_type == 'deposit'){$tran_txt = 'Deposit';$cr_amount = $oformat_amount; $balance_total += $aamount;}
                        else if($transaction_type == 'rtd'){$tran_txt = 'RTD';$cr_amount = $oformat_amount;$balance_total += $aamount; }
                        else if($transaction_type == 'credit_interest') {$tran_txt='Credit Interest';$cr_amount = $oformat_amount; $balance_total += $aamount;}
                        else if($transaction_type == 'cost'){$tran_txt = 'Cost';$dr_amount = $oformat_amount; $balance_total -= $aamount;}
                        else if($transaction_type == 'fee'){$tran_txt = 'Fee';$dr_amount = $oformat_amount; $balance_total -= $aamount;}
                        else if($transaction_type == 'refund'){$tran_txt = 'Refund';$dr_amount = $oformat_amount;$balance_total -= $aamount;}
                        else {$tran_txt='Bank Charges';$dr_amount = $oformat_amount;$balance_total -= $aamount;}

                        $balance_total_amt = "R".money_format('%!i', $balance_total) ;


		                $cbd_txt .= "<tr><td>".$adate_new."</td><td>".$tran_txt."</td><td>".$file_number."</td><td>".$file_name."</td><td>".$dr_amount."</td><td>".$cr_amount."</td><td>".$balance_total_amt."</td></tr>";


		                $this->excel->getActiveSheet()->setCellValue('A'.$table_count, $adate_new);
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, $tran_txt);
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, $file_number);
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, $file_name);
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $dr_amount);
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, $cr_amount);
			        $this->excel->getActiveSheet()->setCellValue('G'.$table_count, $balance_total_amt);


		            }



		        }



		            $cbd_txt .= "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>".$balance_total_amt."</td><tr>";
		        $table_count = $table_count++;

		         $this->excel->getActiveSheet()->setCellValue('A'.$table_count, $adate_new);
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, $tran_txt);
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, $file_number);
			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, $file_name);
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $dr_amount);
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, $cr_amount);
			        $this->excel->getActiveSheet()->setCellValue('G'.$table_count, $balance_total_amt);


		         $cbd_txt .= "</table>";


		        
		     }



		     //$start_count++;

		     for($col = ord('E'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}




						
			}
		}


$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");


            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/cashbook_list.xls');



		$data = array(
			'view_file'=>'cashbook_list_pdf',
			'cashbook_details' => $cbd_txt,
			);

			// Load all views as normal
			$this->load->view('cashbook_list_pdf',$data);
			// Get output html
			$html = $this->output->get_output();
		

			// Load library
			$this->load->library('dompdf_gen');
		
			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper(array(0, 0, 600, 600), "portrait");
			$this->dompdf->render();
			//$this->dompdf->stream("welcome.pdf");
			//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));


			$output = $this->dompdf->output();
			file_put_contents(FCPATH.'uploads/cashbook_list.pdf', $output);


		echo $cbd_txt;
		//echo json_encode($full_details);
		exit();
		

		
		//$ledgerarray=[];
		$csvarray=[];
		$kk=0;
		if(!empty($OpenBalDetails))
		{
			foreach ($OpenBalDetails as $OpenBalDetail) {


				$openbal_date = $OpenBalDetail->openbal_date;
               $openbal_date = date('d-M-Y', strtotime($openbal_date));
				$csvarray[$kk]['date']=$openbal_date;
				$csvarray[$kk]['date_str']= 1;
				$csvarray[$kk]['description']='';
				$csvarray[$kk]['fileno']='';
				$csvarray[$kk]['filename']= 'Opening Balance';
				$csvarray[$kk]['dr']='';
				$csvarray[$kk]['cr']= $OpenBalDetail->amount;
				//$csvarray[$kk]['balance']= $OpenBalDetail->ledger_openbal;
				$kk++;
			}

		}
		if(!empty($ReceiptsDetails))
		{
			//$kk=0;
			foreach ($ReceiptsDetails as $ReceiptsDetail) {
				$rec_date = $ReceiptsDetail->receipt_date;
				$receipt_date = date('d-M-Y', strtotime($rec_date));


				$csvarray[$kk]['date']= $receipt_date;
				$csvarray[$kk]['date_str']= strtotime($rec_date);
				$csvarray[$kk]['description']= $ReceiptsDetail->transaction_type;
				$csvarray[$kk]['fileno']=$ReceiptsDetail->file_number;
				$csvarray[$kk]['filename']=$ReceiptsDetail->file_name;
				$csvarray[$kk]['dr']= '';
				$csvarray[$kk]['cr']=$ReceiptsDetail->amount;
				

				$kk++;
			}
		}
		if(!empty($PaymentDetails))
		{
			
			foreach ($PaymentDetails as $PaymentDetail) {
				$pay_date = $PaymentDetail->payment_date;
				$payment_date = date('d-M-Y', strtotime($pay_date));


				$csvarray[$kk]['date']= $payment_date;
				$csvarray[$kk]['date_str']= strtotime($pay_date);
				$csvarray[$kk]['description']= $PaymentDetail->transaction_type;
				$csvarray[$kk]['fileno']=$PaymentDetail->file_number;
				$csvarray[$kk]['filename']=$PaymentDetail->file_name;
				$csvarray[$kk]['dr']= $PaymentDetail->amount;
				$csvarray[$kk]['cr']= '';
				


				$kk++;
			}
		}

		 /*usort($ledgerarray['other'], function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['str_date'] - $b['str_date'];
		    return $retval;
		});*/

		 usort($csvarray, function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['date_str'] - $b['date_str'];
		    return $retval;
		});






		 $filtered_client_name= $this->session->filtered_client_name;

		$balance_total = 0;

		$csv_handler = fopen (FCPATH.'uploads/cashbook.csv','w');


		setlocale(LC_MONETARY, 'en_IN');

		$cn = array($filtered_client_name, '', '', '', '');
		fputcsv($csv_handler, $cn);

		$fn = array('TRUST CASHBOOK ', '', '', '', '', '');
		fputcsv($csv_handler, $fn);

		$fnn = array($month_name.'-'.$year, '', '', '', '', '');
		fputcsv($csv_handler, $fnn);

		$dummy = array('', '', '', '', '', '');
		fputcsv($csv_handler, $dummy);

		$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');
		fputcsv($csv_handler, $header);

		$excel_array=[];
		$ajax_array = [];
		$array_count=7;


		foreach ($csvarray as $data) {

			$dr_val = $data['dr'];
			$cr_val = $data['cr'];
			$transaction_type = $data['description'];
			$trans_txt = '';

			if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; }
			else if($transaction_type == 'rtd'){$trans_txt = 'RTD';  }
			else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest';  }
			else if($transaction_type == 'refund'){$trans_txt = 'Refund'; }
			else if($transaction_type == 'cost'){$trans_txt = 'Cost';  }
			else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges';  }
			else if($transaction_type == 'fee'){$trans_txt = 'Fee';}
			else {$trans_txt=''; }

			$dr_val = (float) $dr_val;
			$cr_val = (float) $cr_val;

			$balance_total += $cr_val;
			$balance_total -= $dr_val;
			//$bal_val = $cr_val - $dr_val;

			if($cr_val !='' ) {$cr_amount = "R".money_format('%!i', $cr_val);$cr_amount_xl = money_format('%!i', $cr_val);} else {$cr_amount ="";$cr_amount_xl = '';}
			if($dr_val !='' ) {$dr_amount = "R".money_format('%!i', $dr_val);$dr_amount_xl = money_format('%!i', $dr_val);} else {$dr_amount ="";$dr_amount_xl='';}
			//$dr_amount = "R".money_format('%!i', $dr_val);
			$bal_amount = "R".money_format('%!i', $balance_total);
			$bal_amount_xl = money_format('%!i', $balance_total);

			$new_array = array( $data['date'], $data['filename'], $data['fileno'], $trans_txt, $dr_amount, $cr_amount, $bal_amount);
			$excel_array[] = array( $data['date'], $data['filename'] , $data['fileno'], $trans_txt, $dr_amount_xl, $cr_amount_xl, $bal_amount_xl);
			$ajax_array[] = array( $data['date'], $data['filename'] , $data['fileno'], $trans_txt, $dr_amount, $cr_amount, $bal_amount);
			$array_count++;
            fputcsv($csv_handler, $new_array);   // put array content into csv
        }


		$bal_amount = "R".money_format('%!i', $balance_total);
		$footer = array('', '', '', '', '','', $bal_amount);
		fputcsv($csv_handler, $footer);

		fclose ($csv_handler);



		/*********** EXCEL function start *************/

		$month_year = $month_name.'-'.$year;

		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('TRUST CASHBOOK');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $filtered_client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'TRUST CASHBOOK');
        $this->excel->getActiveSheet()->setCellValue('A3', $month_year);
 		//$header = array('Date', 'File Name', 'File No', 'Transaction Type', 'DR', 'CR', 'Balance');

        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'File Name');
        $this->excel->getActiveSheet()->setCellValue('C5', 'File No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Transaction Type');
        $this->excel->getActiveSheet()->setCellValue('E5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');
        $this->excel->getActiveSheet()->mergeCells('A3:G3');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('E'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
        	for($col = ord('A'); $col <= ord('G'); $col++){
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                
             
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

            $bal_amount = money_format('%!i', $balance_total);
            $final_xl = 'G'.$array_count;
            $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            //$this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/cashbook.xls');


			 /*********** /EXCEL function end *************/




		$cashbook_array = [];
		$cashbook_array['receipt'] = $ReceiptsDetails; 
		$cashbook_array['payment'] = $PaymentDetails; 
		$cashbook_array['openbal'] = $OpenBalDetails; 
		 $bal_amount = "R".money_format('%!i', $balance_total);

		$ajax_array[] = array( '', '' , '', '', '', '', $bal_amount);






		$data = array(
			'view_file'=>'cashbook_pdf',
			'title'=>'Cashbook',
			'filtered_client_name' => $filtered_client_name,
			'ReceiptsDetails' => $ReceiptsDetails,
			'PaymentDetails' => $PaymentDetails,
			'OpenBalDetails' => $OpenBalDetails,
			'month' => $month,
			'year' => $year,
			'month_name' => $month_name,
			'ajax_array' => $ajax_array,
			);

			// Load all views as normal
			$this->load->view('cashbook_pdf',$data);
			// Get output html
			$html = $this->output->get_output();
		

			// Load library
			$this->load->library('dompdf_gen');
		
			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper(array(0, 0, 600, 600), "portrait");
			$this->dompdf->render();
			//$this->dompdf->stream("welcome.pdf");
			//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));


			$output = $this->dompdf->output();
			file_put_contents(FCPATH.'uploads/cashbook.pdf', $output);





		//echo json_encode($cashbook_array);
		echo json_encode($ajax_array);
		exit;
	}


	public function cashbook_arrayfun($month,$year_start,$filtered_client_id){
		$array_merge = [];
		$MonthDetails = $this->reports_model->cashbook_montdetails($month,$year_start,$filtered_client_id);
		$OpenBalDetails = $this->reports_model->getCashOpenbalDetails($month,$year_start,$filtered_client_id);
		$array_merge['open'] = $OpenBalDetails;
		$array_merge['all'] = $MonthDetails;

		return $array_merge;
		//echo "<pre>";print_r($MonthDetails);echo"</pre>";
	}

	public function cashbook_pdf(){





/*$month_name=3;
$month=3;
		$year=2015;

		*/
/*$month_name=$_POST['month_name'];
$month=$_POST['month'];
		$year=$_POST['year'];

		$ReceiptsDetails = $this->reports_model->getCashReceiptsDetails($month,$year);
		$PaymentDetails = $this->reports_model->getCashPaymentDetails($month,$year);
		//$cashbook_array = [];
		//$cashbook_array['receipt'] = $ReceiptsDetails; 
		//$cashbook_array['payment'] = $PaymentDetails; 


	//	echo "<pre>";print_r($ReceiptsDetails );echo "</pre>";
			//	echo "<pre>";print_r($PaymentDetails );echo "</pre>";





$data = array(
						'view_file'=>'cashbook_pdf',
						'title'=>'Cashbook',
						'ReceiptsDetails' => $ReceiptsDetails,
						'PaymentDetails' => $PaymentDetails,
						'month' => $month,
						'year' => $year,
						'month_name' => $month_name,

					);



		// Load all views as normal
		$this->load->view('client1',$data);
		// Get output html
		$html = $this->output->get_output();
		

		//$customPaper = array(0,0,360,360);
		//$this->dompdf->set_paper($customPaper);

		//$this->dompdf->set_paper(array(0,0,800,800));

		//$this->dompdf->set_paper(array(0, 0, 595, 841), 'portrait');



		// Load library
		$this->load->library('dompdf_gen');
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 800, 800), "portrait");
		$this->dompdf->render();
		//$this->dompdf->stream("welcome.pdf");
		//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));


		$output = $this->dompdf->output();
file_put_contents(FCPATH.'uploads/cashbook.pdf', $output);

*/


		//exit();



/*

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Vijayasanthi');
$pdf->SetDisplayMode('real', 'default');



$pdf->AddPage();

$data = array(
						'view_file'=>'client1',
						'current_menu'=>'client1',
						'cusotm_field'=>'Client1',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Client1',
						//'ClientlDetails' => $ClientlDetails,
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


$html=$this->load->view('client1', $data, true);


//$pdf->Write(5, $html);

 $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true); 


//$pdf->Output('http://stallioni.in/accounts/uploads/My-File-Name.pdf', 'F');
$pdf->Output(FCPATH.'uploads/My-File-Name.pdf', 'F');

*/

	}
	/*public function cashbook(){
		
		$data = array(
					'view_file'=>'cashbook',
					'current_menu'=>'cashbook',
					'cusotm_field'=>'Cashbook',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'accounting software',
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
	}*/
	public function client_ledger(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			$ClientlDetails = $this->reports_model->getClientDetails_file(array('clients.client_id' => $filtered_client_id));
			$data = array(
						'view_file'=>'client_ledger',
						'current_menu'=>'client_ledger',
						'cusotm_field'=>'Client Ledger',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Client Ledger',
						'ClientlDetails' => $ClientlDetails,
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
	
	public function clientledger_list(){
		$userdata= $this->session->userinfo;
		$client_ledger_list = '';
		$client_name= $this->session->filtered_client_name;


	$table_count = 0;
		//$table_count = 0;
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Client Ledger');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Client Ledger');

        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        $this->excel->getActiveSheet()->mergeCells('A2:F2');

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
         $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

         $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);



		$client_ledger_list .= '<p style="font-weight: bold;text-align: center;font-size:23px;margin: 0px;">'.$client_name.'</p><p style="font-weight: bold;text-align: center;font-size:15px;margin: 10px 0px;">Client Ledger </p>';

		//$client_ledger_list .= "<p>".$client_name."</p><p>Client Ledger</p>";
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			
		$FilelDetails = $this->reports_model->getClientDetails_file(array('clients.client_id' => $filtered_client_id));
			if($FilelDetails)
			{
				foreach($FilelDetails as $filedetail)
				{
					$file_id = $filedetail->file_id;
					$file_number=$filedetail->file_number;
					$file_name=$filedetail->file_name;
					$client_ledgerlist = $this->reports_model->client_ledger_list($filtered_client_id,$file_id);
					//echo "<pre>";print_r($client_ledgerlist);echo "</pre>";
					$client_ledger_list .= '<p style="text-align: center;font-size:15px;margin-top: 10px;">'.$file_name."-".$file_number.'</p>';
					if($client_ledgerlist)
					{

					if($table_count == '0')
		        	 $table_count = $table_count+1;
		        	else
		        		 $table_count = $table_count+10;
		        	//$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $title_date);
		        	$this->excel->getActiveSheet()->mergeCells('A'.$table_count.':F'.$table_count);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
		        	$this->excel->getActiveSheet()->getStyle('A'.$table_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        	 $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setSize(14);

		        	$table_count = $table_count+2;

		        	$this->excel->getActiveSheet()->setCellValue('A'.$table_count, 'Date');
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, 'Description');
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, 'File No');
 			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, 'DR');
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, 'CR');
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, 'Balance');

			        // $this->excel->getActiveSheet()->getStyle('A'.$table_count)->getFont()->setBold(true);
			        // $this->excel->getActiveSheet()->getStyle('B'.$table_count)->getFont()->setBold(true);
			        // $this->excel->getActiveSheet()->getStyle('C'.$table_count)->getFont()->setBold(true);
			        // $this->excel->getActiveSheet()->getStyle('D'.$table_count)->getFont()->setBold(true);
			        // $this->excel->getActiveSheet()->getStyle('E'.$table_count)->getFont()->setBold(true);
			        // $this->excel->getActiveSheet()->getStyle('F'.$table_count)->getFont()->setBold(true);
 
						$client_ledger_list .="<table class='table stl_table'><thead><tr><td>Date</td><td>DESCRPTION</td><td>File No</td><td>Dr</td><td>Cr</td><td>BALANCE</td></tr></thead>";

					
  
 	  
						foreach($client_ledgerlist as $client_ledgerl)
						{
							$balance_total = 0;
	 
						
							$selected_date = $client_ledgerl->selected_date;
							$amount = $client_ledgerl->amount;
							$transaction_type = $client_ledgerl->transaction_type;
							$details = $client_ledgerl->details;
						    $tran_txt= '';
							$cr_amount = '';
			                $dr_amount = '';
			                $amount = (float) $amount;

			                //$balance_total+=$amount;
 
	
 		                
		                
		                if($amount !=''){
                            $format_amount = "R".money_format('%!i', $amount) ;
		                }
                        else{
                        	$format_amount = 0;
                        }

		               
                        
                        if($transaction_type == 'deposit'){$tran_txt = 'Deposit';$cr_amount = $format_amount; $balance_total += $amount;}
                        else if($transaction_type == 'rtd'){$tran_txt = 'RTD';$cr_amount = $format_amount;$balance_total += $amount; }
                        else if($transaction_type == 'credit_interest') {$tran_txt='Credit Interest';$cr_amount = $format_amount; $balance_total += $amount;}
                        else if($transaction_type == 'cost'){$tran_txt = 'Cost';$dr_amount = $format_amount; $balance_total -= $amount;}
                        else if($transaction_type == 'fee'){$tran_txt = 'Fee';$dr_amount = $format_amount; $balance_total -= $amount;}
                        else if($transaction_type == 'refund'){$tran_txt = 'Refund';$dr_amount = $format_amount;$balance_total -= $amount;}
                        else {$tran_txt='Bank Charges';$dr_amount = $format_amount;$balance_total -= $amount;}

                        $balance_total_amt = "R".money_format('%!i', $balance_total) ;

						$client_ledger_list .="<tr><td>".$selected_date."</td><td>".$tran_txt."</td><td>".$file_number."</td><td>".$dr_amount."</td><td>".$cr_amount."</td><td>".$balance_total_amt."</td></tr>";


					$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $selected_date);
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, $tran_txt);
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, $file_number);
 			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, $dr_amount);
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $cr_amount);
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, $balance_total_amt);
 
							
						}
				 

					$client_ledger_list .= "<tr><td></td><td></td><td></td><td></td><td></td><td style='font-weight:bold;'>".$balance_total_amt."</td><tr>";

					$table_count = $table_count++;

					$this->excel->getActiveSheet()->setCellValue('A'.$table_count, $selected_date);
			        $this->excel->getActiveSheet()->setCellValue('B'.$table_count, $tran_txt);
			        $this->excel->getActiveSheet()->setCellValue('C'.$table_count, $file_number);
 			        $this->excel->getActiveSheet()->setCellValue('D'.$table_count, $dr_amount);
			        $this->excel->getActiveSheet()->setCellValue('E'.$table_count, $cr_amount);
			        $this->excel->getActiveSheet()->setCellValue('F'.$table_count, $balance_total_amt);
		   
						$client_ledger_list .= "</table>";

					}	
					
					 

			
				}
				          
			}


	  /*********** PDF function start *************/

		// $month = $start_date.' to '.$end_date;

		$data = array(
			'view_file'=>'clientledgerlist_pdf',
			'title'=>'Client Ledger List',
			'file_name' => $file_name,
			'ClientlDetails' => $FilelDetails,
			'client_ledger_list' => $client_ledger_list,

		);



		// Load all views as normal
		$this->load->view('clientledgerlist_pdf',$data);
		// Get output html
		$html = $this->output->get_output();



		// Load library
		$this->load->library('dompdf_gen');  // using DOMPDF
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 500, 500), "portrait");   // set paper size
		$this->dompdf->render();
		//$this->dompdf->stream("welcome.pdf");
		//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));   // download pdf directly


		$output = $this->dompdf->output();

		file_put_contents(FCPATH.'uploads/clientledger_list.pdf', $output);      // Upload data into pdf

		 /*********** /PDF function END *************/
 
	// /*********** CSV function start *************/


	 	 $balance_total = 0;

	// 	$csv_handler = fopen (FCPATH.'uploads/clientledger_list.csv','w');


	// 	setlocale(LC_MONETARY, 'en_IN');

	// 	$cn = array( $client_name,'', '', '', '', '');
	// 	fputcsv($csv_handler, $cn);

	// 	$fn = array('clientledger_list', '', '', '', '', '');
	// 	fputcsv($csv_handler, $fn);

	// 	//$fnn = array($date_txt, '', '', '', '', '');
	// 	//fputcsv($csv_handler, $fnn);

	// 	$dummy = array('', '', '', '', '', '');
	// 	fputcsv($csv_handler, $dummy);

	// 	 $header = array('Date', 'Description', 'File No', 'DR', 'CR','Balance');
	// 	fputcsv($csv_handler, $header);

	 	 $excel_array=[];
	 	 $array_count=7;


	// 	 foreach ($client_ledgerlist as $client_ledgerl) {
	// 	 	$selected_date = $client_ledgerl->selected_date;
	// 		$amount = $client_ledgerl->amount;
	// 		$file_number = $client_ledgerl->file_number;
	// 		$file_name = $client_ledgerl->file_name;
	// 		$transaction_type = $client_ledgerl->transaction_type;
	// 		$details = $client_ledgerl->details;
	// 	    $tran_txt= '';
	// 	    $cr_amount = '';
 //             $dr_amount = '';
 //             $amount = (float) $amount;
 //             $balance_total = $amount;

           


 // 			$balance_total_amt = "R".money_format('%!i', $balance_total) ;

           
 // 			$new_array = array( $selected_date, $transaction_type, $file_number,'', $format_amount, $balance_total_amt);
	// 		$excel_array[] = array( $selected_date, $transaction_type, $file_number,'', $format_amount, $balance_total_amt);
	// 		$array_count++;
 //            fputcsv($csv_handler, $new_array); 



             
 //        }       
 		
 		
	// 	$balance_total_amt = "R".money_format('%!i', $balance_total);
	// 	$footer = array('', '','', $balance_total_amt);
	// 	fputcsv($csv_handler, $footer);

	// 	fclose ($csv_handler);



	// 	 /*********** /CSV function end *************/


		 /*********** EXCEL function start *************/

       $file = $file_name.' - '.$file_number;

		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('client Ledger');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'client Ledger');
        $this->excel->getActiveSheet()->setCellValue('A3', $file);

        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Description');
        $this->excel->getActiveSheet()->setCellValue('C5', 'File No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('E5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Balance');

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        $this->excel->getActiveSheet()->mergeCells('A2:F2');
        $this->excel->getActiveSheet()->mergeCells('A3:F3');
        //set aligment to center for that merged cell (A1 to C1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);


        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('F'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

           // $balance_total_amt = "R".money_format('%!i', $balance_total);
           // $final_xl = 'F'.$array_count;
           // $this->excel->getActiveSheet()->setCellValue($final_xl,$balance_total_amt);
           // $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/clientledger_list.xls');


			 /*********** /EXCEL function end *************/

 


			$data = array(
						'view_file'=>'clientledger_list',
						'current_menu'=>'clientledger_list',
						'cusotm_field'=>'Client Ledger List',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Client Ledger List',
						'ClientlDetails' => $FilelDetails,
						'client_ledger_list' => $client_ledger_list,
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
	
	

	public function trial_balance(){
		$userdata= $this->session->userinfo;
		if($userdata){

			$filtered_client_id= $this->session->filtered_client_id;
			$client_name= $this->session->filtered_client_name;

			if(isset($_GET['opening_bal_from']) && $_GET['opening_bal_from'] !='' && isset($_GET['opening_bal_to']) && $_GET['opening_bal_to'] !='')
			{
				//echo "sssss";
				$startDate = $_GET['opening_bal_from'];
				 $startDate =  date('Y-m-d',strtotime($startDate));
				$endDate = $_GET['opening_bal_to'];
				 $endDate =  date('Y-m-d',strtotime($endDate));
				//$month_endDate = '2017-02-30';
			}
			else
			{
				 $current_month = date('m');
				if($current_month < '03')
				{
					
				 $startDate = date('Y-03-01',strtotime('-1 year'));
				 $endDate = date('Y-02-30');
				}	
				else
				{
					
					 $startDate = date('Y-03-01');
					 $endDate = date('Y-02-30' ,strtotime('+1 year'));
				}
				$startDate = '2016-03-01';
				$endDate = '2017-02-30';
				//$month_endDate = '2017-02-30';
			}
		 
			
			
			$trial_balance = array();
			$kk=0;
			$filtered_client_id= $this->session->filtered_client_id;
			$fileDetails = $this->file_model->getFileDetails(array('client_id' => $filtered_client_id));
			//echo $this->db->last_query();
			//print_r($fileDetails);
				//	exit();
			if($fileDetails)
			{
				//print_r($fileDetails);
				//	exit();
				foreach ($fileDetails as $fileDetail) {

					$file_id = $fileDetail->file_id;
					$file_name = $fileDetail->file_name;
					$file_number = $fileDetail->file_number;
					$ledger_openbal = $fileDetail->ledger_openbal;
					$trial_balance[$kk]['file_id'] = $file_id;
					$trial_balance[$kk]['file_name'] = $file_name;
					$trial_balance[$kk]['file_number'] = $file_number;
					$trial_balance[$kk]['receipt_total'] = 0;
					$trial_balance[$kk]['payment_total'] = 0;
					$ledger_openbal = (float) $ledger_openbal;
					$receipt_totals = $ledger_openbal;
					$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('receipt_date >=' => $startDate ,'receipt_date <=' => $endDate, 'file_id' => $file_id),'sum(amount) as receipt_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					$PaymentDetails = $this->payments_model->getPaymentDetails(array('payment_date >=' => $startDate ,'payment_date <=' => $endDate, 'file_id' => $file_id),'sum(amount) as payment_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					if($ReceiptsDetails)
					{
						foreach ($ReceiptsDetails as $ReceiptsDetail) {
							
							$receipt_total = $ReceiptsDetail->receipt_total;
							$receipt_total = (float) $receipt_total;
							$receipt_totals = $ledger_openbal + $receipt_total;
							//$trial_balance[$kk]['receipt_total'] = $receipt_totals;
						}

					}
					

					$trial_balance[$kk]['receipt_total'] = $receipt_totals;
					if($PaymentDetails)
					{
						foreach ($PaymentDetails as $PaymentDetail) {
							$trial_balance[$kk]['payment_total'] = $PaymentDetail->payment_total;
						}
					}
					//echo $this->db->last_query();
					//print_r($PaymentDetails);
					//exit();

					$kk++;
				}

				//echo "<pre>";print_r($trial_balance);echo "</pre>"; echo $startDate;
				//exit();

			}
			//$trial_balance = $this->reports_model->trial_balance('2016-03-01','2017-02-01');
			$endDate_str = strtotime($endDate);
			$openbal_date_str = strtotime( date('Y-m-01',$endDate_str).' +1 month');
			$openbal_date = date('Y-m-01',$openbal_date_str);

			$date = $startDate.' to '.$endDate;

			$open_balance = $this->reports_model->trial_openbalance($openbal_date);
			//$ClientlDetails = $this->reports_model->getClientDetails_file(array('clients.client_id' => $filtered_client_id));
			
			/*********** PDF function start *************/

			$data = array(
				'view_file'=>'trialbal_pdf',
				'title'=>'Trial Balance',
				'date'=> $date,
				'openbal_date'=>$openbal_date,
				'client_name' => $client_name,
				'trial_balance' => $trial_balance,
				'open_balance' => $open_balance
			);



			// Load all views as normal
			$this->load->view('trialbal_pdf',$data);
			// Get output html
			$html = $this->output->get_output();



			// Load library
			$this->load->library('dompdf_gen');  // using DOMPDF
			
			// Convert to PDF
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper(array(0, 0, 500, 500), "portrait");   // set paper size
			$this->dompdf->render();
			//$this->dompdf->stream("welcome.pdf");
			//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));   // download pdf directly


			$output = $this->dompdf->output();

			file_put_contents(FCPATH.'uploads/trialbal.pdf', $output);      // Upload data into pdf

			 /*********** /PDF function END *************/

  /*********** CSV function start *************/


		$balance_total = 0;
		 //$total_balance = 0;

		$csv_handler = fopen (FCPATH.'uploads/trialbal.csv','w');


		setlocale(LC_MONETARY, 'en_IN');

		$cn = array('Client Name', $client_name, '', '', '', '');
		fputcsv($csv_handler, $cn);

		$fn = array('File Name', $file_name, '', '', '', '');
		fputcsv($csv_handler, $fn);

		$fnn = array('File No', $file_number, '', '', '', '');
		fputcsv($csv_handler, $fnn);

		$dummy = array('', '', '', '', '', '');
		fputcsv($csv_handler, $dummy);

		$header = array('Name', 'File No', 'DR', 'CR');
		fputcsv($csv_handler, $header);

		$excel_array=[];
		$array_count=6;
         $start_date='';

		 foreach ($trial_balance as $key => $value) {
             $file_id = $value['file_id'];
            $file_name = $value['file_name'];
            $file_number = $value['file_number'];
            $payment_total = (float) $value['payment_total'];
            $receipt_total = (float)$value['receipt_total'];
            $payment_total_amt = "R".money_format('%!i', $payment_total);
            $receipt_total_amt = "R".money_format('%!i', $receipt_total);
            //$payment_total_amt = "R".number_format($payment_total,2);
            //$receipt_total_amt = "R".number_format($receipt_total,2);
            $balance =  $receipt_total - $payment_total ;
           // $total_balance += $balance;
            $balance_amt = "R".money_format('%!i', $balance);

            
            $new_array = array( $file_name, $file_number, '' ,$balance_amt, '');
			$excel_array[] = array( $file_name, $file_number, '' , $balance_amt, '');
			$array_count++;
            fputcsv($csv_handler, $new_array); 

			 
        }


         foreach ($open_balance as $key => $value) {
               $open_bal = $value->amount;
               $total_balance = $value->amount;
               $open_bal_amt = "R".money_format('%!i', $open_bal);
               $total_balance_amt = "R".money_format('%!i', $total_balance);
           


       	$footer1 = array('BALANCE PER BANK STATEMENT','', $open_bal_amt, $total_balance_amt);
       	fputcsv($csv_handler, $footer1);
         }


		$bal_amount = "R".money_format('%!i', $balance_total);
		$footer = array('', '','', $bal_amount);
		fputcsv($csv_handler, $footer);

		fclose ($csv_handler);


		 /*********** /CSV function end *************/


	 /*********** EXCEL function start *************/

         
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Trial Balance');
        //set cell A1 content with some text

        $this->excel->getActiveSheet()->setCellValue('A1', $client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Trial Balance');
        //$this->excel->getActiveSheet()->setCellValue('A3', 'File No')
         $this->excel->getActiveSheet()->setCellValue('A3',$date);
       $this->excel->getActiveSheet()->setCellValue('A4', 'Name');
        $this->excel->getActiveSheet()->setCellValue('B4', 'File No');
        $this->excel->getActiveSheet()->setCellValue('C4', 'DR');
        $this->excel->getActiveSheet()->setCellValue('D4', 'CR');
       
         //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        $this->excel->getActiveSheet()->mergeCells('A2:D2');
        $this->excel->getActiveSheet()->mergeCells('A3:D3');
       // $this->excel->getActiveSheet()->mergeCells('A4:D4');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         
        
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        

        $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A5');     // insert value to EXCEL



        for($col = ord('A'); $col <= ord('F'); $col++){ 

                 //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                        
        	}
       	
         $final_xl = 'A'.$array_count;
        $this->excel->getActiveSheet()->setCellValue($final_xl,'BALANCE PER BANK STATEMENT');
        $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

        $open_bal_amt = "R".money_format('%!i', $open_bal);
        $final_xl = 'C'.$array_count;
        $this->excel->getActiveSheet()->setCellValue($final_xl,$open_bal_amt);
        $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

        $total_balance_amt = "R".money_format('%!i', $total_balance);
        $final_xl = 'D'.$array_count;
        $this->excel->getActiveSheet()->setCellValue($final_xl,$total_balance_amt);
        $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);
 
        // $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        	for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
            // $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}
 
            $array_count++;
            $bal_amount = "R".money_format('%!i', $balance_total);
            $final_xl = 'D'.$array_count++;
            $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);
 
           //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("20");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");

                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/trialbal.xls');


			 /*********** /EXCEL function end *************/


		
			
			
			$data = array(
						'view_file'=>'trial_balance',
						'current_menu'=>'trial_balance',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Trial Balance',
						'trial_balance' => $trial_balance,
						'open_balance' => $open_balance,
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
										'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
										'lib/scripts/app.min.js',
										'lib/scripts/layout.min.js',

										),
									"priority" => 'high'
									)
					);

			$this->template->load_admin_template($data);
		}
	}
	public function fees_journal(){
		$userdata= $this->session->userinfo;
		if($userdata){
			$filtered_client_id= $this->session->filtered_client_id;
			$client_name= $this->session->filtered_client_name;
			
			if(isset($_GET['opening_bal_from']) && $_GET['opening_bal_from'] !='' && isset($_GET['opening_bal_to']) && $_GET['opening_bal_to'] !='')
			{
				//echo "sssss";
				$startDate = $_GET['opening_bal_from'];
				 $startDate =  date('Y-m-d',strtotime($startDate));
				$endDate = $_GET['opening_bal_to'];
				 $endDate =  date('Y-m-d',strtotime($endDate));
				 $endDate_start = date('Y-m-d',strtotime($endDate));
				//$month_endDate = '2017-02-30';
			}
			else
			{
				//echo date('m');
				 $current_month = date('m');
				if($current_month < '03')
				{
					
				 $startDate = date('Y-03-01',strtotime('-1 year'));
				 $endDate = date('Y-02-30');
				 $endDate = date('Y-02-01');
				}	
				else
				{
					
					 $startDate = date('Y-03-01');
					 $endDate = date('Y-02-30' ,strtotime('+1 year'));
					 $endDate_start = date('Y-02-01' ,strtotime('+1 year'));
				}
				$startDate = '2016-03-01';
				$endDate = '2017-02-30';
				$endDate_start = '2017-02-01';
				//$month_endDate = '2017-02-30';
			}

			$fees_journals = $this->payments_model->getPaymentDetails_file(array('payment_date >=' => $startDate ,'payment_date <=' => $endDate,'payment_cfrb.transaction_type' => 'fee','payment_cfrb.client_id' => $filtered_client_id, 'payment_cfrb.account_status'=> '1'),'',array('orderby' => 'payment_date', 'disporder' => 'asc'));










$startDate_out = date('F, 01 Y',strtotime($startDate));
$endDate_out = date('F, 01 Y',strtotime($endDate_start));
$date_txt = 'From '.$startDate_out.' to '.$endDate_out;

//$endDate = '2017-02-30';



 /*********** PDF function start *************/

		$data = array(
			'view_file'=>'feesjournal_pdf',
			'title'=>'Fees Journal',
			'date_txt' => $date_txt,
			'client_name' => $client_name,
			'fees_journals' => $fees_journals
		);



		// Load all views as normal
		$this->load->view('feesjournal_pdf',$data);
		// Get output html
		$html = $this->output->get_output();



		// Load library
		$this->load->library('dompdf_gen');  // using DOMPDF
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 500, 500), "portrait");   // set paper size
		$this->dompdf->render();
		//$this->dompdf->stream("welcome.pdf");
		//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));   // download pdf directly


		$output = $this->dompdf->output();

		file_put_contents(FCPATH.'uploads/feesjournal.pdf', $output);      // Upload data into pdf

		 /*********** /PDF function END *************/




			/*********** CSV function start *************/


		$balance_total = 0;

		$csv_handler = fopen (FCPATH.'uploads/feesjournal.csv','w');


		setlocale(LC_MONETARY, 'en_IN');

		$cn = array( $client_name,'', '', '', '', '');
		fputcsv($csv_handler, $cn);

		$fn = array('Fees Journals', '', '', '', '', '');
		fputcsv($csv_handler, $fn);

		$fnn = array($date_txt, '', '', '', '', '');
		fputcsv($csv_handler, $fnn);

		$dummy = array('', '', '', '', '', '');
		fputcsv($csv_handler, $dummy);

		

		$excel_array=[];
		$array_count=7;


		foreach ($fees_journals as $key => $value) {
			$payment_date = $value->payment_date;
			$payment_date = date('d-M-Y', strtotime($payment_date));
            $file_number = $value->file_number;
            $amount = $value->amount;
            $format_amount = money_format('%!i', $amount) ;

            $header = array('Date', 'Description', 'File No', 'DR', 'CR');
            $excel_array[] = array('Date', 'Description', 'File No', 'DR', 'CR');
            $array_count++;
			fputcsv($csv_handler, $header);

            $new_array = array( $payment_date, 'TRF TO BUSINESS', $file_number, "R".$format_amount, '');
			$excel_array[] = array( $payment_date, 'TRF TO BUSINESS', $file_number, $format_amount, '');
			$array_count++;
            fputcsv($csv_handler, $new_array); 

            $new_array = array( $payment_date, 'Bank', $file_number, '', "R".$format_amount);
			$excel_array[] = array( $payment_date, 'Bank', $file_number, '', $format_amount);
			$array_count++;
            fputcsv($csv_handler, $new_array); 

            $new_array = array( '', '', '', $format_amount, "R".$format_amount);
			$excel_array[] = array( '', '', '', $format_amount, $format_amount);
			$array_count++;
            fputcsv($csv_handler, $new_array); 



            $new_array = array( '', '', '' , '', '');
			$excel_array[] = array( '', '', '' , '', '');
			$array_count++;
            fputcsv($csv_handler, $new_array); 

             $new_array = array( '', '', '' , '', '');
			$excel_array[] = array( '', '', '' , '', '');
			$array_count++;
            fputcsv($csv_handler, $new_array); 





		/*	$dr_val = $data['dr'];
			$cr_val = $data['cr'];
			$transaction_type = $data['description'];
			$trans_txt = '';

			if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; }
			else if($transaction_type == 'rtd'){$trans_txt = 'RTD';  }
			else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest';  }
			else if($transaction_type == 'refund'){$trans_txt = 'Refund'; }
			else if($transaction_type == 'cost'){$trans_txt = 'Cost';  }
			else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges';  }
			else if($transaction_type == 'fee'){$trans_txt = 'Fee';}
			else {$trans_txt='Opening Balance'; }

			$dr_val = (float) $dr_val;
			$cr_val = (float) $cr_val;

			$balance_total += $cr_val;
			$balance_total -= $dr_val;
			//$bal_val = $cr_val - $dr_val;

			if($cr_val !='' ) {$cr_amount = "R".money_format('%!i', $cr_val);} else {$cr_amount ="";}
			if($dr_val !='' ) {$dr_amount = "R".money_format('%!i', $dr_val);} else {$dr_amount ="";}
			//$dr_amount = "R".money_format('%!i', $dr_val);
			$bal_amount = "R".money_format('%!i', $balance_total);

			$new_array = array( $data['date'], $trans_txt, $data['fileno'], $dr_amount, $cr_amount, $bal_amount);
			$excel_array[] = array( $data['date'], $trans_txt, $data['fileno'], $dr_amount, $cr_amount, $bal_amount);
			$array_count++;
            fputcsv($csv_handler, $new_array);   // put array content into csv
            */
        }


		//$bal_amount = "R".money_format('%!i', $balance_total);
		//$footer = array('', '', '', '', '', $bal_amount);
		//fputcsv($csv_handler, $footer);

		fclose ($csv_handler);


		 /*********** /CSV function end *************/


		 /*********** EXCEL function start *************/


		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Fees Journals');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', 'Fees Journals');
        $this->excel->getActiveSheet()->setCellValue('A3', $date_txt);

       /* $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Description');
        $this->excel->getActiveSheet()->setCellValue('C5', 'File No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('E5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Balance');*/

        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:E1');
        $this->excel->getActiveSheet()->mergeCells('A2:E2');
        $this->excel->getActiveSheet()->mergeCells('A3:E3');
        //set aligment to center for that merged cell (A1 to C1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
       // $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);


        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('E'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

          //  $bal_amount = "R".money_format('%!i', $balance_total);
          //  $final_xl = 'F'.$array_count;
          //  $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
          //  $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
            $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/feesjournal.xls');


			 /*********** /EXCEL function end *************/


			$fees_journal = array();
			$kk=0;
			$filtered_client_id= $this->session->filtered_client_id;
			$fileDetails = $this->file_model->getFileDetails(array('client_id' => $filtered_client_id));
			//echo $this->db->last_query();
			//print_r($fileDetails);
				//	exit();
			if($fileDetails)
			{
				//print_r($fileDetails);
				//	exit();
				foreach ($fileDetails as $fileDetail) {

					$file_id = $fileDetail->file_id;
					$file_name = $fileDetail->file_name;
					$file_number = $fileDetail->file_number;
					$ledger_openbal = $fileDetail->ledger_openbal;
					$fees_journal[$kk]['file_id'] = $file_id;
					$fees_journal[$kk]['file_name'] = $file_name;
					$fees_journal[$kk]['file_number'] = $file_number;
					$fees_journal[$kk]['receipt_total'] = 0;
					$fees_journal[$kk]['payment_total'] = 0;
					$ledger_openbal = (float) $ledger_openbal;
					$receipt_totals = $ledger_openbal;
					$ReceiptsDetails = $this->receipts_model->getReceiptsDetails(array('receipt_date >=' => $startDate ,'receipt_date <=' => $endDate, 'file_id' => $file_id),'sum(amount) as receipt_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					$PaymentDetails = $this->payments_model->getPaymentDetails(array('payment_date >=' => $startDate ,'payment_date <=' => $endDate, 'file_id' => $file_id),'sum(amount) as payment_total,count(file_id)',array('groupby' => 'file_id','orderby' => 'file_id','disporder' => 'asc'));
					if($ReceiptsDetails)
					{
						foreach ($ReceiptsDetails as $ReceiptsDetail) {
							
							$receipt_total = $ReceiptsDetail->receipt_total;
							$receipt_total = (float) $receipt_total;
							$receipt_totals = $ledger_openbal + $receipt_total;
							//$trial_balance[$kk]['receipt_total'] = $receipt_totals;
						}

					}
					

					$fees_journal[$kk]['receipt_total'] = $receipt_totals;
					if($PaymentDetails)
					{
						foreach ($PaymentDetails as $PaymentDetail) {
							$fees_journal[$kk]['payment_total'] = $PaymentDetail->payment_total;
						}
					}
					//echo $this->db->last_query();
					//print_r($PaymentDetails);
					//exit();

					$kk++;
				}

				//echo "<pre>";print_r($trial_balance);echo "</pre>"; echo $startDate;
				//exit();

			}
			//$trial_balance = $this->reports_model->trial_balance('2016-03-01','2017-02-01');
			$endDate_str = strtotime($endDate);
			$openbal_date_str = strtotime( date('Y-m-01',$endDate_str).' +1 month');
			$openbal_date = date('Y-m-01',$openbal_date_str);

			$open_balance = $this->reports_model->trial_openbalance($openbal_date);
			//$ClientlDetails = $this->reports_model->getClientDetails_file(array('clients.client_id' => $filtered_client_id));
			$data = array(
						'view_file'=>'fees_journal',
						'current_menu'=>'fees_journal',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Fees Journal',
						'fees_journal' => $fees_journal,
						'fees_journals' => $fees_journals,
						'open_balance' => $open_balance,
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
										'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
										'lib/scripts/app.min.js',
										'lib/scripts/layout.min.js',

										),
									"priority" => 'high'
									)
					);

			$this->template->load_admin_template($data);
		}
	}
	public function get_ClientLedger(){
		$client_id = $_GET['client_id'];
		$file_id = $_GET['file_id'];
		$file_number = $_GET['file_number'];
		$client_name = $_GET['client_name'];
		$file_name = $_GET['file_name'];
		$ReceiptsDetails = []; 
		$PaymentDetails = []; 
 		$ReceiptsDetails = $this->receipts_model->getReceiptsDetails_file(array('receipt_drc.client_id'=>$client_id,'receipt_drc.file_id'=>$file_id, 'receipt_drc.account_status'=> '1' ));
		$FileOpenbalancesDetails=$this->file_model->getFileDetails(array('file_id' => $file_id));
		//echo "<pre>";print_r($ReceiptsDetails);echo"</pre>";
		$PaymentDetails = $this->payments_model->getPaymentDetails_file(array('payment_cfrb.client_id'=>$client_id,'payment_cfrb.file_id'=>$file_id , 'payment_cfrb.account_status'=> '1'));
		//echo $this->db->last_query();exit();


		/************* Import value into array ********/
		

		$ledgerarray=[];
		$csvarray=[];
		$kk=0;
		if(!empty($FileOpenbalancesDetails))
		{
			foreach ($FileOpenbalancesDetails as $FileOpenbalancesDetail) {
				$ledgerarray['open'][$kk]['id'] = $FileOpenbalancesDetail->file_id;
				$ledgerarray['open'][$kk]['date'] = '';
				$ledgerarray['open'][$kk]['str_date'] = 1;
				//$ledgerarray[$kk]['bank'] = $ReceiptsDetail->bank;
				$ledgerarray['open'][$kk]['amount'] = $FileOpenbalancesDetail->ledger_openbal;
				$ledgerarray['open'][$kk]['client_id'] = $FileOpenbalancesDetail->client_id;
				$ledgerarray['open'][$kk]['file_id'] = $FileOpenbalancesDetail->file_id;
				$ledgerarray['open'][$kk]['file_number'] = $FileOpenbalancesDetail->file_number;
				$ledgerarray['open'][$kk]['transaction_type'] = $FileOpenbalancesDetail->file_name;
				$ledgerarray['open'][$kk]['ledger_type'] = 'opening_balance';

				$csvarray[$kk]['date']='';
				$csvarray[$kk]['date_str']= 1;
				$csvarray[$kk]['description']='Opening Balance';
				$csvarray[$kk]['fileno']=$FileOpenbalancesDetail->file_number;
				$csvarray[$kk]['dr']='';
				$csvarray[$kk]['cr']= $FileOpenbalancesDetail->ledger_openbal;
				//$csvarray[$kk]['balance']= $FileOpenbalancesDetail->ledger_openbal;
				$kk++;
			}

		}
		if(!empty($ReceiptsDetails))
		{
			//$kk=0;
			foreach ($ReceiptsDetails as $ReceiptsDetail) {
				$rec_date = $ReceiptsDetail->receipt_date;
				$receipt_date = date('d-M-Y', strtotime($rec_date));
				$ledgerarray['other'][$kk]['id'] = $ReceiptsDetail->receipt_id;
				$ledgerarray['other'][$kk]['date'] = $receipt_date;
				$ledgerarray['other'][$kk]['str_date'] = strtotime($rec_date);
				//$ledgerarray[$kk]['bank'] = $ReceiptsDetail->bank;
				$ledgerarray['other'][$kk]['amount'] = $ReceiptsDetail->amount;
				$ledgerarray['other'][$kk]['client_id'] = $ReceiptsDetail->client_id;
				$ledgerarray['other'][$kk]['file_id'] = $ReceiptsDetail->file_id;
				$ledgerarray['other'][$kk]['file_number'] = $ReceiptsDetail->file_number;
				$ledgerarray['other'][$kk]['transaction_type'] = $ReceiptsDetail->transaction_type;
				$ledgerarray['other'][$kk]['ledger_type'] = 'receipt';

				$csvarray[$kk]['date']= $receipt_date;
				$csvarray[$kk]['date_str']= strtotime($rec_date);
				$csvarray[$kk]['description']= $ReceiptsDetail->transaction_type;
				$csvarray[$kk]['fileno']=$ReceiptsDetail->file_number;
				$csvarray[$kk]['dr']= '';
				$csvarray[$kk]['cr']=$ReceiptsDetail->amount;
				

				$kk++;
			}
		}
		if(!empty($PaymentDetails))
		{
			
			foreach ($PaymentDetails as $PaymentDetail) {
				$pay_date = $PaymentDetail->payment_date;
				$payment_date = date('d-M-Y', strtotime($pay_date));
				$ledgerarray['other'][$kk]['id'] = $PaymentDetail->payment_id;
				$ledgerarray['other'][$kk]['date'] = $payment_date;
				$ledgerarray['other'][$kk]['str_date'] = strtotime($pay_date);
				//$ledgerarray[$kk]['bank'] = $PaymentDetail->bank;
				$ledgerarray['other'][$kk]['amount'] = $PaymentDetail->amount;
				$ledgerarray['other'][$kk]['client_id'] = $PaymentDetail->client_id;
				$ledgerarray['other'][$kk]['file_id'] = $PaymentDetail->file_id;
				$ledgerarray['other'][$kk]['file_number'] = $PaymentDetail->file_number;
				$ledgerarray['other'][$kk]['transaction_type'] = $PaymentDetail->transaction_type;
				$ledgerarray['other'][$kk]['ledger_type'] = 'payment';

				$csvarray[$kk]['date']= $payment_date;
				$csvarray[$kk]['date_str']= strtotime($pay_date);
				$csvarray[$kk]['description']= $PaymentDetail->transaction_type;
				$csvarray[$kk]['fileno']=$PaymentDetail->file_number;
				$csvarray[$kk]['dr']= $PaymentDetail->amount;
				$csvarray[$kk]['cr']= '';
				


				$kk++;
			}
		}
	//print_r($csvarray);
		if(!empty($ledgerarray) && sizeof($ledgerarray) > 1)
		{
		 usort($ledgerarray['other'], function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['str_date'] - $b['str_date'];
		    return $retval;
		});
		}

		if(!empty($csvarray) && sizeof($csvarray) > 1)
		{
		 usort($csvarray, function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['date_str'] - $b['date_str'];
		    return $retval;
		});
		}

		/* usort($csvarray, function($a, $b) {
		   // $retval = $a['str_date'] <=> $b['str_date'];
		    $retval = $a['date_str'] - $b['date_str'];
		    return $retval;
		});*/


		 /************* Import value into array ********/

		

		  /*********** CSV function start *************/


		$balance_total = 0;


		//$month = $start_date.' to '.$end_date;

		$csv_handler = fopen (FCPATH.'uploads/clientledger.csv','w');


		setlocale(LC_MONETARY, 'en_IN');

		$cn = array('Client Name', $client_name, '', '', '', '');
		fputcsv($csv_handler, $cn);

		$fn = array('File Name', $file_name, '', '', '', '');
		fputcsv($csv_handler, $fn);

		$fnn = array('File No', $file_number, '', '', '', '');
		fputcsv($csv_handler, $fnn);

		// $dummy1 = array('', $month, '', '', '', '');
		// fputcsv($csv_handler, $dummy1);

		$dummy = array('', '', '', '', '', '');
		fputcsv($csv_handler, $dummy);

		$header = array('Date', 'Description', 'File No', 'DR', 'CR', 'Balance');
		fputcsv($csv_handler, $header);

		$excel_array=[];
		$array_count=7;


		foreach ($csvarray as $data) {

			$dr_val = $data['dr'];
			$cr_val = $data['cr'];
			$transaction_type = $data['description'];
			$trans_txt = '';

			if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; }
			else if($transaction_type == 'rtd'){$trans_txt = 'RTD';  }
			else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest';  }
			else if($transaction_type == 'refund'){$trans_txt = 'Refund'; }
			else if($transaction_type == 'cost'){$trans_txt = 'Cost';  }
			else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges';  }
			else if($transaction_type == 'fee'){$trans_txt = 'Fee';}
			else {$trans_txt='Opening Balance'; }

			$dr_val = (float) $dr_val;
			$cr_val = (float) $cr_val;

			$balance_total += $cr_val;
			$balance_total -= $dr_val;
			//$bal_val = $cr_val - $dr_val;

			if($cr_val !='' ) {$cr_amount = "R".money_format('%!i', $cr_val);$cr_amount_xl = money_format('%!i', $cr_val);} else {$cr_amount ="";$cr_amount_xl = '';}
			if($dr_val !='' ) {$dr_amount = "R".money_format('%!i', $dr_val);$dr_amount_xl = money_format('%!i', $dr_val);} else {$dr_amount ="";$dr_amount_xl="";}
			//$dr_amount = "R".money_format('%!i', $dr_val);
			$bal_amount = "R".money_format('%!i', $balance_total);
			$bal_amount_xl = money_format('%!i', $balance_total);
			if($array_count == '8'){$start_date = $data['date'];}
			$end_date = $data['date'];

			$new_array = array( $data['date'], $trans_txt, $data['fileno'], $dr_amount, $cr_amount, $bal_amount);
			$excel_array[] = array( $data['date'], $trans_txt, $data['fileno'], $dr_amount_xl, $cr_amount_xl, $bal_amount_xl);
			$array_count++;
            fputcsv($csv_handler, $new_array);   // put array content into csv
        }


		$bal_amount = "R".money_format('%!i', $balance_total);
		$footer = array('', '', '', '', '', $bal_amount);
		fputcsv($csv_handler, $footer);

		fclose ($csv_handler);


		 /*********** /CSV function end *************/


		 /*********** EXCEL function start *************/

		  $file = $file_name.'-'.$file_number;

		   $month = $start_date.' to '.$end_date;


		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Client Ledger');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $client_name);
        $this->excel->getActiveSheet()->setCellValue('A2', $month);
        //$this->excel->getActiveSheet()->setCellValue('A2', $file_name);
        $this->excel->getActiveSheet()->setCellValue('A3', 'CLIENT LEDGER');
        //$this->excel->getActiveSheet()->setCellValue('A3', 'File No');
        $this->excel->getActiveSheet()->setCellValue('A4',$file);
        $this->excel->getActiveSheet()->setCellValue('A5', 'Date');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Description');
        $this->excel->getActiveSheet()->setCellValue('C5', 'File No');
        $this->excel->getActiveSheet()->setCellValue('D5', 'DR');
        $this->excel->getActiveSheet()->setCellValue('E5', 'CR');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Balance');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        $this->excel->getActiveSheet()->mergeCells('A2:F2');
        $this->excel->getActiveSheet()->mergeCells('A3:F3');
        $this->excel->getActiveSheet()->mergeCells('A4:F4');
        //set aligment to center for that merged cell (A1 to C1)
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //set aligment to center for that merged cell (A1 to C1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        // $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('D'); $col <= ord('F'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(10);
                 
             $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	}

            $this->excel->getActiveSheet()->fromArray($excel_array, null, 'A6');     // insert value to EXCEL

            $bal_amount = money_format('%!i', $balance_total);
            $final_xl = 'F'.$array_count;
            $this->excel->getActiveSheet()->setCellValue($final_xl,$bal_amount);
            $this->excel->getActiveSheet()->getStyle($final_xl)->getFont()->setBold(true);

            //$this->excel->getActiveSheet()->getColumnDimension('A')->setHeight("40");
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("12");
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("12");
            $this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight("16");
           // $this->excel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
            // $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			$objWriter->save(FCPATH.'uploads/clientledger.xls');


			 /*********** /EXCEL function end *************/


			  /*********** PDF function start *************/

		 $month = $start_date.' to '.$end_date;

		$data = array(
			'view_file'=>'client_ledger_pdf',
			'title'=>'Client Ledger',
			'file_number' => $file_number,
			'client_name' => $client_name,
			'file_name' => $file_name,
			'month' => $month,
			'OpenbalancesDetails' => $FileOpenbalancesDetails,
			'ReceiptsDetails' => $ReceiptsDetails,
			'PaymentDetails' => $PaymentDetails,
			'ledgerarray' => $ledgerarray,

		);



		// Load all views as normal
		$this->load->view('client_ledger_pdf',$data);
		// Get output html
		$html = $this->output->get_output();



		// Load library
		$this->load->library('dompdf_gen');  // using DOMPDF
		
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 500, 500), "portrait");   // set paper size
		$this->dompdf->render();
		//$this->dompdf->stream("welcome.pdf");
		//$this->dompdf->stream("dompdf_out.pdf", array("Attachment" => false));   // download pdf directly


		$output = $this->dompdf->output();

		file_put_contents(FCPATH.'uploads/clientledger.pdf', $output);      // Upload data into pdf

		 /*********** /PDF function END *************/










		/*if(empty($ReceiptsDetails))
		{
			$result = $PaymentDetails;
		}
		else if(empty($PaymentDetails))
		{
			$result = $ReceiptsDetails;
		}
		else
		{
		$result = array_merge_recursive($ReceiptsDetails, $PaymentDetails);
		}*/

		//echo "<pre>";print_r($ledgerarray);echo"</pre>";

// 		$result_sort =  usort($ledgerarray, function($a, $b) {
//    echo $a = strtotime($a['date']);
//     echo $b = strtotime($b['date']);
//     return (($a == $b) ? (0) : (($a > $b) ? (1) : (-1)));
// });


		//$result_sort = usort($ledgerarray, 'sortByOrder');
		//echo "<pre>";print_r($result_sort);echo"</pre>";
		//usort($result, 'sortByOrder');


/*

$my_html = '<p><span style="font-weight: bold;">Client Name: </span><span>test</span></p><p><span style="font-weight: bold;">FILE NO: </span><span>12313</span></p><table style="width:100%">';

                         $my_html .= '<tr><td style="font-weight: bold;">DATE</td><td style="font-weight: bold;">DESCRPTION</td><td style="font-weight: bold;">FILE NO</td><td style="font-weight: bold;text-align:right;">DR</td><td style="font-weight: bold;text-align:right;">CR</td><td style="font-weight: bold;text-align:right;">BALANCE</td></tr><tr><td colspan="6" style="text-align:right;font-weight:bold;">R123213</td></tr></table>';

 include($_SERVER['DOCUMENT_ROOT']."/accounts/MPDF56/mpdf.php");

 $mpdf=new mPDF('en-x','A4','','',0,0,0,10,10,10);

$mpdf->default_lineheight_correction = 3.2;
// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->SetColumns(1,'J');

$mpdf->WriteHTML($my_html);

$mpdf->pdf->Output(BASE_URL."/uploads/".$filename, "F");


*/

/*
$filename = time()."_order.pdf";
 
//$html = $this->load->view('unpaid_voucher',$data,true);

 
// unpaid_voucher is unpaid_voucher.php file in view directory and $data variable has infor mation that you want to render on view.
 
$this->load->library('mpdf');
 
$this->mpdf->pdf->WriteHTML($html);
 
//download it D save F.
 
$this->mpdf->pdf->Output(BASE_URL."/uploads/".$filename, "F");

*/






		echo json_encode($ledgerarray);
		exit;

	}



/*	public function ledger_csv(){









$data = array(
         '0' => array( 'Parvez', 'complete', 'Low', '001'),
         '1' => array('Alam', 'inprogress','Low', '111'),
         '2' => array('Sunnay', 'hold', 'Low', '333'),
         '3' => array( 'Amir', 'pending', 'Low', '444'),
         '4' => array( 'Amir1', 'pending', 'Low', '777'),
         '5' => array( 'Amir2', 'pending', 'Low', '777')
        );
$csv_handler = fopen (FCPATH.'uploads/clientledger.csv','w');



$header = array('Name', 'Status', 'Priority', 'Salary');


 fputcsv($csv_handler, $header);


foreach ($data as $data) {
                fputcsv($csv_handler, $data);
            }


fclose ($csv_handler);

echo 'Data saved to csvfile.csv';




		$data_array = array (
            array ('1','2'),
            array ('2','2'),
            array ('3','6'),
            array ('4','2'),
            array ('6','5')
        );

$csv = "col1,col2 \n";//Column headers




foreach ($data_array as $record){
    $csv.= $record[0].','.$record[1]."\n"; //Append data to csv
}

$csv_handler = fopen (FCPATH.'uploads/csvfile.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);

echo 'Data saved to csvfile.csv';




$data = array(
         '0' => array('Name'=> 'Parvez', 'Status' =>'complete', 'Priority'=>'Low', 'Salary'=>'001'),
         '1' => array('Name'=> 'Alam', 'Status' =>'inprogress', 'Priority'=>'Low', 'Salary'=>'111'),
         '2' => array('Name'=> 'Sunnay', 'Status' =>'hold', 'Priority'=>'Low', 'Salary'=>'333'),
         '3' => array('Name'=> 'Amir', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'444'),
         '4' => array('Name'=> 'Amir1', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777'),
         '5' => array('Name'=> 'Amir2', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777')
        );


             header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"test".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($data as $data) {
                fputcsv($handle, $data);
            }
                fclose($handle);




		$this->load->dbutil();
$this->load->helper('file');
$this->load->helper('download');
$query = $this->db->query("SELECT * FROM `clients`");
$delimiter = ",";
$newline = "\r\n";
$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
force_download('CSV_Report.csv', $data);




                exit;
	}


	*/
	public function sortByOrder($a, $b) {

		 $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;

    //return $a['day'] - $b['day'];
	}




	public function client1(){
		$userdata= $this->session->userinfo;
		if($userdata){
			//$ClientlDetails = $this->reports_model->getClientDetails_file();
			$data = array(
						'view_file'=>'client1',
						'current_menu'=>'client1',
						'cusotm_field'=>'Client1',
						'site_title' =>'Accounting Software',
						'logo'		=> 'logo',
						'title'=>'Client1',
						//'ClientlDetails' => $ClientlDetails,
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

		/*$html=$this->load->view('client1', $data, true);

        //this the the PDF filename that user will get to download  generated.pdf
		$pdfFilePath = "output_pdf_name.pdf";

        //load mPDF library
		$this->load->library('m_pdf');

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

        //download it.
		$this->m_pdf->pdf->Output($html, "D");*/


	}

/*	function my_mPDF(){
 
$filename = time()."_order.pdf";
 
//$html = $this->load->view('unpaid_voucher',$data,true);

$response_value = '<p><span style="font-weight: bold;">Client Name: </span><span>test</span></p><p><span style="font-weight: bold;">FILE NO: </span><span>12313</span></p><table style="width:100%">';

                         $response_value .= '<tr><td style="font-weight: bold;">DATE</td><td style="font-weight: bold;">DESCRPTION</td><td style="font-weight: bold;">FILE NO</td><td style="font-weight: bold;text-align:right;">DR</td><td style="font-weight: bold;text-align:right;">CR</td><td style="font-weight: bold;text-align:right;">BALANCE</td></tr><tr><td colspan="6" style="text-align:right;font-weight:bold;">R123213</td></tr></table>';
 
// unpaid_voucher is unpaid_voucher.php file in view directory and $data variable has infor mation that you want to render on view.
 
$this->load->library('M_pdf');
 
$this->m_pdf->pdf->WriteHTML($html);
 
//download it D save F.
 
$this->m_pdf->pdf->Output(BASE_URL."/uploads/".$filename, "F");
}*/



}
