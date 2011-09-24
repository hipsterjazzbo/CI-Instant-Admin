<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	private $users;
	private $roles;


	function __construct() 
	{
		parent::__construct();
		$this->load->library('instant_admin');
		$this->users = $this->instant_admin->build_page_object('auth', array('single_name' => 'User', 'plural_name' => 'Users', 'table' => array('ia_users', 'ia_roles'), 'condition' => 'ia_users.role_id = ia_roles.id'));
		$this->output->enable_profiler(TRUE);
	}
	
	function login()
	{
		$this->load->view('admin/login');
	}
	
	function logout()
	{
		// Something
	}
	
	function view_users()
	{
		$this->instant_admin->page()->add_column('First Name', 'first_name');
		$this->instant_admin->page()->add_column('Last Name', 'last_name');
		$this->instant_admin->page()->add_column('Email', 'email');
		$this->instant_admin->page()->add_column('Role', 'name');
		
		$this->instant_admin->page()->load();
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */