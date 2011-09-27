<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Key_dates extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();		
		$this->load->library('instant_admin');
	}
	
	function view()
	{
		$this->instant_admin->page()->add_column('Date', 'date_date');
		$this->instant_admin->page()->add_column('Title', 'date_title');
		
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

/* End of file key-dates.php */
/* Location: ./application/controllers/key-dates.php */