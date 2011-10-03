<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Instant_admin {

	private $ci;
	private $auth;
	private $config;
	private $default_actions = array('add', 'edit', 'delete', 'import', 'export', 'print');
	public $pages;

	public function __construct()
	{
		$this->ci =& get_instance();
		include 'ia_auth.php';
		include 'ia_page.php';
		include 'ia_action.php';
		
		$this->ci->load->helper('url');
		$this->ci->load->library('session');
		
		$this->auth = new IA_Auth();
		
		if ( ! $this->auth->logged_in() || ! $this->auth->is_admin())
		{
                    if ($this->ci->router->fetch_class() != 'auth')
                    {
                        redirect('admin/auth/login', 'refresh');
                    }
		}
		
		if ($this->ci->router->fetch_method() == 'index')
		{
			redirect($this->ci->router->fetch_directory() . $this->ci->router->fetch_class() . '/view');
		}
		
		$this->ci->config->load('admin');
		$this->config = $this->ci->config->item('admin_pages');
		
		$this->build_page_objects();
		
		if ($this->ci->router->fetch_method() == 'delete')
		{
			$params = array_slice($this->ci->uri->rsegments, 2);
			$this->page()->delete_record($params[0]);
			redirect($this->ci->router->fetch_directory() . $this->ci->router->fetch_class() . '/view');
		}
	}
	
	public function page()
	{
		return $this->pages[$this->ci->router->fetch_class()];
	}

	public function new_page($single_name, $plural_name, $slug, $db_table, $actions, $condition)
	{
		return new IA_Page($single_name, $plural_name, $slug, $db_table, $actions, $condition);
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
			$this->build_page_object($key, $page);
		}
	}
	
	public function build_page_object($key, $page)
	{
		if (empty($page['single_name']) || empty($page['plural_name']))
		{
			$this->ci->show_error('You must specify both a singular and plural name in config/admin.php');
		}

		if ( ! isset($page['actions']) || empty($page['actions']))
		{
			$page['actions'] = $this->default_actions;
		}

		array_unshift($page['actions'], 'view');

		$page['actions'] = $this->build_action_objects($page);
		$page['condition'] = (! isset($page['condition'])) ? null : $page['condition'];

		$this->pages[$key] = $this->new_page($page['single_name'], $page['plural_name'], $key, $page['table'], $page['actions'], $page['condition']);
	}


	private function build_action_objects($page)
	{		
		extract($page);
		
		foreach ($actions as $action)
		{
			if (in_array($action, $this->default_actions) || $action == 'view')
			{
				$options = array(
					'key' => $action,
					'title' => ($action == 'add') ? ucfirst($action) . ' ' . $single_name : ucfirst($action) . ' ' . $plural_name,
					'icon' => site_url() . 'ia_icons/' . $action . '.png'
				);
				
				$action_objects[] = new IA_Action($options);
			}
		}
		
		return $action_objects;
	}
}

/* End of file instant_admin.php */