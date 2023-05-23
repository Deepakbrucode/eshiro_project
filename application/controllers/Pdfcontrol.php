<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfcontrol extends CI_Controller {

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
		$this->load->model('costcentre_model');
		$this->load->model('client_model');

		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
		$this->load->helper('url');
		 $this->load->library('excel');
	}
	public function index(){}
	public function generate_pdf($report_type = 1){
		$client_id= $this->session->id; $start_month='';
		$usertype= $this->session->usertype;
		$fclient_id = (isset($_GET['client_id']))?$_GET['client_id']:'';
		$ClientDetails = array();
		if($usertype == '5')
		{
			$ClientDetails = $this->client_model->getClientDetails();	
		}
		$current_userid = $client_id;
		if($usertype == '5')
		{
			if($fclient_id != '')
			{
				$current_userid = $fclient_id;
			}
		}
		$end_month = '2';
		$CurrentClientDetails = $this->client_model->getClientDetails(array('id' => $current_userid,'status' => 1));
		if($CurrentClientDetails)
		{
			foreach($CurrentClientDetails as $cdetl)
			{
				$end_month = $cdetl->financial_month_end;
				$start_month = $cdetl->financial_month_start;
			}
		}
		$bank_stat_yr = $this->reports_model->get_finanlstat_year($current_userid,$end_month,$report_type);



		$genereate_report_pdf = $this->genereate_report_pdf();

			// $costtxt = $this->ajax_detailed_income_fn($_POST);
		
		$pdf_fname = 'financial_position.pdf';
		$header = '<div style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		<h4>TSHIQI ZEBEDIELA INCORPORATED</h4>
		<p>(Registration Number 2004/009424/21)</p>
		<p>Financial Statements for the 11 month period ended 30 November 2021</p>
		</div>';

		$footer ='<pagefooter name="footer" content-center="{PAGENO}"></pagefooter>
		</div>'; 
			
		/********************* PDF start ********/
		$this->load->library('m_pdf'); 
		 // include_once APPPATH.'/third_party/mpdf/mpdf.php';

// $mpdf=new mPDF('c','A4','','',32,25,47,47,10,10); 
$mpdf=new mPDF('c',
	'A4','','',
	320,250,470,470,500,100);
// new mPDF($mode, $format, $font_size, $font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);

		//$pdf_fname = 'rrrrrrrrrrrrrrrrrr.pdf';

		$page_data['page_name']  	= 'Financial Report';
		$page_data['table_div'] = $genereate_report_pdf;
		//$page_data['report_results'] 	= $report_results;
		$this->load->view('financial_report_pdf', $page_data);
		// Get output html
		$html = $this->output->get_output();
	   //$this->m_pdf->pdf->IndexEntry("Dromedary", "Camel:types");


		$this->m_pdf->pdf->setAutoTopMargin = 'stretch';



		// hema 

	$stylesheet = $this->curl_get_file_contents('https://eshiro.app/uploads/pdf.css');
	$this->m_pdf->pdf->WriteHTML($stylesheet,1);

	$html = $this->m_pdf->pdf->WriteHTML($html);
	$this->m_pdf->pdf->Output(FCPATH.'uploads/'.$pdf_fname, "F");     
	// $this->output->set_output('');




	ob_end_flush();
	ob_start();



		$data = array(
					'view_file'=>'generate_pdf',
					'current_menu'=>'generate_pdf',
					'cusotm_field'=>'report',
					'site_title' =>'eShiro',
					'logo'		=> 'logo',
					'title'=>'Report',
					// 'end_month' => $end_month,
					// 'start_month' => $start_month,
					// 'bank_stat_yr' => $bank_stat_yr,
					'report_type' => $report_type,
					'ledger_title' => 'STATEMENT OF FINANCIAL POSITION',
					
					'headerfiles'   => array(
								"css" => array(
									'lib/font-awesome/css/font-awesome.min.css',
									'lib/simple-line-icons/simple-line-icons.min.css',
									'lib/bootstrap/css/bootstrap.min.css',
									'lib/bootstrap-switch/css/bootstrap-switch.min.css',
									'lib/datatables/datatables.min.css',
									// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.css',
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
									// 'lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
									'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
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
	function genereate_report_pdf(){


		$pdf_txt_start = 
		'

		<htmlpageheader name="firstpage_header" style="display:none">
            <div style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
			<h4>TSHIQI ZEBEDIELA INCORPORATED</h4>
			<p>(Registration Number 2004/009424/21)</p>
			<p>Financial Statements for the 11 month period ended 30 November 2021</p>
			</div>	
        </htmlpageheader>
         <sethtmlpageheader name="firstpage_header" value="off"/>


		<htmlpageheader name="otherpages_header" style="display:none">
			<div style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
			<h4>TSHIQI ZEBEDIELA INCORPORATED</h4>
			<p>(Registration Number 2004/009424/21)</p>
			<p>Financial Statements for the 11 month period ended 30 November 2021</p>
			</div>		
		</htmlpageheader>
        <sethtmlpageheader name="otherpages_header" value="on" />


         <htmlpagefooter name="firstpage" class="" style="display:none">
	        	<div style="text-align:center">{PAGENO}</div>
        </htmlpagefooter>

          <htmlpagefooter name="otherpages"   class="" style="display:none">
           	  <div style="text-align:center;border-top: 1px solid #000000;">{PAGENO}</div>
        </htmlpagefooter>


       <div id="header">
			<p style="font-weight: bold;text-align: center;font-size:19px;margin: 12px 0px 0px;color:#000;    text-transform: capitalize;">TSHIQI ZEBEDIELA INCORPORATED</p>
			<p style="text-align: center;font-size:13px; margin: 10px 0px;font-weight: bold;color:#000;">Trading as </p>
			<p style="text-align: center;font-size:13px; margin: 10px 0px;font-weight: bold;color:#000;">TSHIQI ZEBEDIELA ATTORNEYS </p>
			<p style="text-align: center;font-size:13px; margin: 10px 0px;font-weight: bold;color:#000;">(Registration Number 2004/009424/21) </p>
			<p style="text-align: center;font-size:13px; margin: 10px 0px;font-weight: bold;color:#000;">Financial Statements </p>
			<p style="text-align: center;font-size:13px;margin: 10px 0px;color:#0000;">for the 11 month period ended 30 November 2021</p><br>
		</div>        
		 <sethtmlpagefooter name="firstpage" value="off" />';

		$pdf_txt_start .='<pagebreak resetpagenum="1">

		<div> 
			<p> The reports and statements set out below comprise the financial statements presented to the shareholder: </p>

<h2>Index</h2>
<indexinsert usedivletters="on" links="on" collation="en_US.utf8"
    collation-group="English_United_States"/>


		</div>

		<div class="col-md-12" id="">
		First page 
		<h1 class="test_style">Title</h1>
		<h2 class="test_style2">Title</h2>
		</div>

		<sethtmlpagefooter name="otherpages" value="on"  show-this-page="1"/>

		';

			$pdf_txt_start .='<pagebreak>

	    <a name="page2"></a>
		<div class="col-md-12">
		<indexentry content="General information" />

		General Information

		 <br> 
		</div>';


			$pdf_txt_start .='<pagebreak>

	 <a name="page3"></a>

	 Third page conetntss

		<div class="col-md-12">

			<p>
			<indexentry content="Independent Reviewers Report" /> To the Shareholder of Tshiqi Zebediela Incorporated
We have reviewed the financial statements of Tshiqi Zebediela Incorporated set out on pages 6 to 14, which comprise the
statement of financial position as at 30 November 2021, and the statement of comprehensive income, the statement of
changes in equity and the statement of cash flows for the 11 month period then ended, and notes to the financial statements,
including a summary of significant accounting policies.
Directors Responsibility for the Financial Statements

The director is responsible for the preparation and fair presentation of these financial statements in accordance with the
International Financial Reporting Standard for Small and Medium-sized Entities and the requirements of the Companies Act of
South Africa, and for such internal control as the director determines is necessary to enable the preparation of financial
statements that are free from material misstatement, whether due to fraud or error.
Independent Reviewer’s Responsibility

Our responsibility is to express a conclusion on these financial statements. We conducted our review in accordance with the
International Standard on Review Engagements (ISRE) 2400 (Revised), Engagements to Review Historical Financial Statements
(ISRE 2400 (Revised)). ISRE 2400 (Revised) requires us to conclude whether anything has come to our attention that causes us
to believe that the financial statements, taken as a whole, are not prepared in all material respects in accordance with the
applicable financial reporting framework. This Standard also requires us to comply with relevant ethical requirements.
A review of financial statements in accordance with ISRE 2400 (Revised) is a limited assurance engagement. The independent
reviewer performs procedures, primarily consisting of making inquiries of management and others within the entity, as
appropriate, and applying analytical procedures, and evaluates the evidence obtained.
The procedures performed in a review are substantially less than those performed in an audit conducted in accordance with
International Standards on Auditing. Accordingly, we do not express an audit opinion on these financial statements.
Conclusion
Based on our review, nothing has come to our attention that causes us to believe that these financial statements do not
present fairly, in all material respects, the financial position of Tshiqi Zebediela Incorporated as at 30 November 2021, and its
financial performance and cash flows for the 11 month period then ended in accordance with the International Financial
Reporting Standard for Small and Medium-sized Entities and the requirements of the Companies Act of South Africa
			</p>
	   </div>';




			$pdf_txt_start .='<pagebreak>

			<indexentry content="DIRECTORS RESPONSIBILITIES AND APPROVAL" />

			The director is required by the South African Companies Act to maintain adequate accounting records and is responsible for the
content and integrity of the financial statements and related financial information included in this report. It is his responsibility
to ensure that the financial statements satisfy the financial reporting standards as to form and content and present fairly the
statement of financial position, results of operations and business of the company, and explain the transactions and financial
position of the business of the company at the end of the 11 month period. The financial statements are based upon
appropriate accounting policies consistently applied throughout the company and supported by reasonable and prudent
judgements and estimates.
				 <a name="page4"></a>

		<div class="col-md-12">

		four page 
		</div>';




			$pdf_txt_start .='<pagebreak>

					 <indexentry content="Directors Report" />



				 <a name="page5"></a>

		<div class="col-md-12">
		Five page 
		</div>';




			$pdf_txt_start .='<pagebreak>

								 <indexentry content="Statement of Financial Position" />



				 <a name="page6"></a>

		<div class="col-md-12">
		six page 
		</div>';



			$pdf_txt_start .='<pagebreak> 


								 <indexentry content="Statement of Comprehensive Income" />
 

			
				 <a name="page7"></a>

		<div class="col-md-12">
		seventh page 
		</div>';


	 
$pdf_txt_start .='Text of document...

Your text which refers to a buffalo, which
you would like to see in the Index

...rest of document

<pagebreak />

<h2>Index</h2>

<indexinsert usedivletters="on" links="on" collation="en_US.utf8"
    collation-group="English_United_States"/>';


		return $pdf_txt_start;




	}



	function curl_get_file_contents($URL)
{

    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);

    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}



}