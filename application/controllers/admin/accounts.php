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
		$this->instant_admin->page()->add_column('Name', 'name');
		$this->instant_admin->page()->add_column('Industry', 'industry');
		
		$this->instant_admin->page()->load();
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