<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Instant_admin {

	private $ci;
	private $config;
	private $default_actions = array('add', 'edit', 'delete', 'import', 'export', 'print');
	public $pages;

	public function __construct()
	{
		$this->ci =& get_instance();
		include 'ia_page.php';
		include 'ia_action.php';
		
		if ($this->ci->router->fetch_method() == 'index')
		{
			$this->ci->load->helper('url');
			redirect($this->ci->router->fetch_directory() . $this->ci->router->fetch_class() . '/view');
		}
		
		$this->ci->config->load('admin');
		$this->config = $this->ci->config->item('admin_pages');
		
		if (empty($this->config))
		{
			// Show error
		}
		
		$this->build_page_objects();
	}
	
	public function page()
	{
		return $this->pages[$this->ci->router->fetch_class()];
	}

	public function new_page($name, $db_table, $actions)
	{
		return new IA_Page($name, $db_table, $actions);
	}

	protected function get_menu_config()
	{
		if ($this->ci->config->item('admin_menu_items'))
		{
			return $this->ci->config->item('admin_menu_items');
		}

		return FALSE;
	}
	
	public function get_menu_items()
	{
		$i = 0;
		
		foreach ($this->pages as $page) 
		{
			$things[$i]['heading'] = $page->plural_name;
			$things[$i]['items']   = $page->page_actions;
			$things[$i]['slug']    = $page->slug;
			
			$i++;
		}
		
		return $things;
	}

	private function build_page_objects()
	{
		foreach ($this->config as $key => $page)
		{
			if (empty($page['single_name']) || empty($page['plural_name']))
			{
				$this->ci->show_error('You must specify both a singular and plural name in config/admin.php');
			}
			
			if (empty($page['actions']))
			{
				$page['actions'] = $this->default_actions;
			}
			
			array_unshift($page['actions'], 'view');
			
			$page['actions'] = $this->build_action_objects($page['actions'], $page['plural_name']);
			
			$this->pages[$key] = new IA_Page($page['single_name'], $page['plural_name'], $key, $page['table'], $page['actions']);
		}
	}
	
	private function build_action_objects($actions, $plural_name)
	{
		$this->ci->load->helper('url');
		
		foreach ($actions as $action)
		{
			if (in_array($action, $this->default_actions) || $action == 'view')
			{
				$options = array(
					'key' => $action,
					'title' => ucfirst($action) . ' ' . $plural_name,
					'icon' => site_url() . 'ia_icons/' . $action . '.png'
				);
				
				$action_objects[] = new IA_Action($options);
			}
		}
		
		return $action_objects;
	}
}

/* End of file instant_admin.php */