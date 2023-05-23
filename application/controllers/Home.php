<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		//$this->load->library('Pdf');
		//$this->load->library('Fpdf_gen');
		//$this->load->library('M_pdf');
		$this->load->helper('url');
		 $this->load->library('excel');
	}
	
	
	public function index(){
	    	$data = array(
					'view_file'=>'home_page',
					'current_menu'=>'home_page',
					'cusotm_field'=>'Home_page',
					'site_title' =>'Accounting Software',
					'logo'		=> 'logo',
					'title'=>'Homepage',
					//'CashDetails' => $CashDetails,
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

		$this->template->load_index_template($data);
	}

	
}
?>