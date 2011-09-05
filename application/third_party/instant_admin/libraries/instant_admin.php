<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Instant_admin {

    protected $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function new_page($db_table) 
	{
		if ( ! $db_table)
		{
			$this->ci->show_error('You must specify a table to manage.');
		}
		
		return new IA_Page($db_table);
	}
	
	public function load_page(IA_Page $page)
	{
		var_dump($page);
	}
}

/* End of file instant_admin.php */

class IA_Page extends Instant_admin {
	
	public $db_table;
	public $primary_key;
	public $columns = array();
	public $actions = array();


	public function __construct($db_table)
	{
		parent::__construct();
		$this->db_table    = $db_table;
		$this->primary_key = $this->get_primary_key($this->db_table);
	}
	
	public function add_column($column_name, $db_field)
	{
		$this->columns[] = array(
			'name' => $column_name,
			'field' => $db_field
		);
	}
	
	public function add_action($action, $icon)
	{
		$this->actions[] = array(
			'action' => $action,
			'icon' => $icon
		);
	}
	
	private function get_primary_key($table)
	{
		$query = $this->ci->db->query("SHOW INDEX FROM {$table} WHERE Key_name = 'PRIMARY'");
		$row = $query->row();
		return $row->Column_name;
	}
	
	public function array_get_key_val($key, array $haystack, &$values = array())
	{
		foreach ($haystack as $k => $v)
		{
			if (is_array($v))
			{
				$this->array_get_key_val($key, $v, $values);
			} 

			else if ($k == $key)
			{
				$values[] = $v;
			}
		}
		
		return $values;
	}
	
	public function load()
	{
		$fields = $this->array_get_key_val('field', $this->columns);
		array_unshift($fields, $this->primary_key . ' AS ia_primary_key');
		$this->ci->db->select(implode(',', $fields), FALSE);
		$query = $this->ci->db->get($this->db_table);
		var_dump($query->result());
	}
}