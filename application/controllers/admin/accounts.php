<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->library('instant_admin');
		$this->output->enable_profiler(TRUE);
	}
	
	function view()
	{
		$members = $this->instant_admin->new_page('Accounts', 'accounts');
		
		$members->add_column('First Name', 'first_name');
		$members->add_column('Last Name', 'last_name');
		
		$members->load();
	}
	
//	function accounts()
//	{
//		$accounts = $this->instant_admin->new_page('Accounts', 'accounts');
//		
//		$accounts->add_column('Account', 'name');
//		
//		$accounts->load();
//	}
}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */