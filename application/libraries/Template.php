<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template class
 *
 * Displays webpage i.e(view page)
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 */
class Template {
	
	private $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	// This will load front end template
	public function load_index_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => '','meta_content'=>''))
	{
		$this->CI->load->view('template/index/header', $data);
		$this->CI->load->view('template/index/topheader');
		//$this->CI->load->view('template/index/sidebar');
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/index/footer', $data);
	}
	public function load_admin_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => '','meta_content'=>''))
	{
		$this->CI->load->view('template/admin/header', $data);
		$this->CI->load->view('template/admin/topheader');
		$this->CI->load->view('template/admin/sidebar');
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/admin/footer', $data);
	}
	public function load_login_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => '','meta_content'=>''))
	{
		$this->CI->load->view('template/login/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/login/footer', $data);
	}


}
?>
