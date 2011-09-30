<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function _remap($method, $params = array())
	{
		if ($method == 'index')
		{
			$this->load->helper('url');
			redirect('page/home');
		}
		
		$data['page'] = $method;
		$this->load->view('public_main', $data);
	}
}

/* End of file members.php */
/* Location: ./application/controllers/members.php */