<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		$this->load->library('instant_admin');
		
		$this->output->enable_profiler(TRUE);
	}
	
	function view()
	{
		$this->instant_admin->page()->add_column('First Name', 'first_name');
		$this->instant_admin->page()->add_column('Last Name', 'last_name');
		
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

/* End of file members.php */
/* Location: ./application/controllers/members.php */