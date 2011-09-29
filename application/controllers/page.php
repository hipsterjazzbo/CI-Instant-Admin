<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function _remap($method, $params = array())
	{
		$data['page'] = $method;
		$this->load->view('public_main');
	}
}

/* End of file members.php */
/* Location: ./application/controllers/members.php */