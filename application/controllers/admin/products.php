<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('instant_admin');	
	}
	
	function view()
	{
		$this->instant_admin->page()->add_column('Product Title', 'pro_title');
		$this->instant_admin->page()->add_column('Points', 'pro_point');
		
		$this->instant_admin->page()->load();
	}

}

/* End of file products.php */
/* Location: ./application/controllers/products.php */
