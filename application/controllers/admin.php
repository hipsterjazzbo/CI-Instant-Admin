<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * @var array Page configuration loaded from config.admin.php
	 */
	private $page_configs = array();
	
	function __construct() 
	{
		parent::__construct();		
		$this->config->load('admin');
		$this->load->helper('url');
		$this->load->database();
		$this->page_configs = $this->config->item('admin');
	}
	
	/**
	 * Called by CodeIgniter automatically for every request to this controller.
	 * Allows us to customize page building and loading functionality.
	 * 
	 * @see http://codeigniter.com/user_guide/general/controllers.html#remapping
	 * 
	 * @param string $page The requested method name (page) as passed by CI
	 * @param array $params Any additional parameters passed in the URL
	 */
	function _remap($page, $params = array())
	{
		$this->check_for_errors($page);
		$this->detect_page_type($page, $params);
	}
	
	/**
	 * Checks for any errors in the config from config/admin.php
	 * 
	 * @param string $page The page name
	 */
	function check_for_errors($page) 
	{
		if($this->is_index_page($page) || $page == 'dashboard')
			return;			

		// Make sure whether page is configured at all
		if( ! $this->page_is_configured($page))
			show_error("You must configure at least \$config['admin']['{$page}']['name'] to enable this page. See config/admin.php.");
		
		// Make sure a name has been set for the page
		if( ! $this->name_is_set($page))
			show_error("You must set \$config['admin']['{$page}']['name'] in config/admin.php");
			
		// Make sure some kind of page type is available (view, table or custom)
		if( ! $this->is_custom_page($page) && 
			! $this->is_table_page($page) && 
			! $this->is_view_page($page))
			show_error("You must specify either \$config['admin']['{$page}']['view'] or \$config['admin']['{$page}']['table'] in config/admin.php, or define 'function {$page}() {}' in controllers/admin.php.");
	}
	
	/**
	 * Determines what type of page we are trying to load, and calls the 
	 * apprpriate loader function.
	 * 
	 * @param string $page The requested method name (page) as passed by CI
	 * @param array $params Any additional parameters passed in the URL
	 */
	function detect_page_type($page, $params)
	{
		if($this->is_custom_page($page))
			$this->load_custom_page($page, $params);
			
		else if($this->is_index_page($page))
			$this->load_index_page($page, $params);
			
		else if($this->is_view_page($page))
			$this->load_view_page($page);
			
		else if($this->is_table_page($page))
			$this->load_table_page($page);
	}
	
	/***************************************************************************
	 * Custom page handler functions
	 * 
	 * If you want to define a custom function to handle a particular page,
	 * put it here. 
	 * 
	 * If all you want to do is use a custom view file, you can either define it
	 * using $config['your_page_name']['view'] in config/admin.php, or stick a 
	 * file called your_page_name.php in views/admin.
	 **************************************************************************/
	
	// Example custom page handler
	function this_would_be_your_page_name()
	{
		// 1. Do something special, probably involving custom data handling and such
		// 2. Display using $this->load->view('your_thing'); or whatever
		// 3. ???
		// 4. Profit!
	}
	
	function custom()
	{
		echo 'Tada!';
	}
	
	/**
	 * Loads our default dashboard view.
	 */
	function dashboard()
	{
		$this->load->view('admin/dashboard.php');
	}
	
	/***************************************************************************
	 * Page type tesing functions
	 **************************************************************************/
	
	/**
	 * Checks whether the requested page should be handled by a custom function
	 * 
	 * @param string $page
	 * @return bool 
	 */
	function is_custom_page($page)
	{
		return method_exists($this, $page);
	}
	
	/**
	 * Checks whether the requested page is the index page
	 * 
	 * @param string $page
	 * @return bool 
	 */
	function is_index_page($page)
	{
		return ($page == 'index');
	}
	
	/**
	 * Checks whether the requested page is a plain 'ol view page
	 * 
	 * @param string $page
	 * @return bool 
	 */
	function is_view_page($page)
	{
		return isset($this->page_configs[$page]['view']);
	}
	
	/**
	 * Checks whether the requested page is a table management page.
	 * 
	 * @param string $page
	 * @return bool 
	 */
	function is_table_page($page)
	{
		return isset($this->page_configs[$page]['table']);
	}
	
	/***************************************************************************
	 * Page type loading functions
	 **************************************************************************/
	
	/**
	 * Calls the custom page handler function
	 * 
	 * @param string $page
	 * @param array $params
	 * @return null 
	 */
	function load_custom_page($page, $params)
	{
		call_user_func_array(array($this, $page), $params);
		return;
	}
	
	/**
	 * Loads either the defaul admin page if it is set in config/admin.php, or
	 * the generic dashboard view otherwise.
	 * 
	 * @param string $page
	 * @param array $params 
	 */
	function load_index_page($page, $params)
	{
		$default_page = $this->config->item('admin_default_page');
		
		if( ! empty($default_page))
			$this->_remap($this->config->item('admin_default_page'), $params);
		
		else
			$this->_remap('dashboard', $params);
	}
	
	/**
	 * Loads the view page as set in config/admin.php
	 * 
	 * @param string $page 
	 */
	function load_view_page($page)
	{
		$data = $this->get_page_data($page);
		$this->load->view($this->page_configs[$page]['view'], $data);
	}
	
	/**
	 * Loads the table management view with data for the table set in 
	 * config/admin.php
	 * 
	 * @param string $page 
	 */
	function load_table_page($page)
	{
		$data = $this->get_page_data($page);
		
		if($this->template_override_exists($page))
			$this->load->view("admin/{$page}", $data);
			
		else
			$this->load->view('admin/manage_table', $data);
	}
	
	/***************************************************************************
	 * Utility Functions
	 **************************************************************************/
	
	/**
	 * Checks whether page is configured at all in config/admin.php
	 * 
	 * @param string $page
	 * @return bool 
	 */
	function page_is_configured($page)
	{
		return array_key_exists($page, $this->page_configs);
	}
	
	/**
	 * Check wether name has been set in config/admin.php
	 * 
	 * @param string $page
	 * @return bool
	 */
	function name_is_set($page)
	{
		return isset($this->page_configs[$page]['name']);
	}
	
	/**
	 * Gets all the page data, including configuration and table data
	 * 
	 * @param string $page
	 * @return array $data All of the data. ALL OF THE DATA. EVERY. SINGLE. DATUM.
	 */
	function get_page_data($page)
	{
		$this->load->model('admin_model');
		
		$data['page_configs'] = $this->page_configs;
		$data['page'] = $page;
		
		if(isset($this->page_configs[$page]['table']))
		{
			$data['data'] = $this->admin_model->get_table_data(
					$this->page_configs[$page]['table'],
					$this->page_configs[$page]['fields']
			);
		}
		
		return $data;
	}
	
	/**
	 * Checks whether a template override file exists for the current request.
	 * 
	 * @param string $page
	 * @return bool
	 */
	function template_override_exists($page)
	{
		return @file_exists(APPPATH . "views/admin/{$page}.php");
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */