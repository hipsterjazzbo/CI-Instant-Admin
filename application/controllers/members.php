<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		// Add package path so that CI can find all of our bits and pieces
		$this->load->add_package_path(APPPATH . 'third_party/instant_admin/');
		
		// Load the config and a fwe helpers and such.
		$this->load->database();
		$this->load->library('instant_admin');
		
		$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		$members = $this->instant_admin->new_page('contacts');
		
		$members->add_column('First Name', 'first_name');
		$members->add_column('Last Name', 'last_name');
		
		$members->load();
	}
}

/* End of file members.php */
/* Location: ./application/controllers/members.php */