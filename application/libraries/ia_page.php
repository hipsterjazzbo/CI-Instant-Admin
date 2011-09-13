<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class IA_Page {

	private $ci;
	public $single_name;
	public $plural_name;
	public $slug;
	private $db_table;
	private $primary_key;
	private $headings      = array();
	private $fields        = array();
	private $data          = array();
	private $table_actions = array();
	public $page_actions   = array();

	public function __construct($single_name, $plural_name, $slug, $db_table, array $actions)
	{
		$this->ci =& get_instance();

		$this->single_name = $single_name;
		$this->plural_name = $plural_name;
		$this->slug        = $slug;
		$this->db_table    = $db_table;
		$this->set_actions($actions);
		
		$this->ci->load->library('table');
	}

	public function add_column($column_name, $db_field)
	{
		$this->headings[] = $column_name;
		$this->fields[]   = $db_field;
	}

	public function add_action($action, $icon)
	{
		$this->actions[] = array(
			'action' => $action,
			'icon'   => $icon
		);
	}

	public function load()
	{
		$this->get_page_details();
		$this->get_menu_items();
		$this->build_table();
		$this->ci->load->view('admin/manage_table', $this->data);
	}

	private function get_page_details()
	{
		$this->data['page']['name'] = $this->plural_name;
	}

	private function get_menu_items()
	{
		$this->data['menu_items'] = $this->ci->instant_admin->get_menu_items();
	}

	private function build_table()
	{
		$this->headings[] = 'stuff';
		$tmpl = array ( 'table_open'  => '<table cellspacing="0" class="tablesorter">' );
		$this->ci->table->set_template($tmpl);
		$this->ci->table->set_heading($this->headings);

		foreach ($this->get_rows() as $row)
		{
			$this->ci->table->add_row(array_values($row));
		}

		$this->data['table'] = $this->ci->table->generate();
	}

	private function get_primary_key($table)
	{
		$query = $this->ci->db->query("SHOW INDEX FROM {$table} WHERE Key_name = 'PRIMARY'");
		$row   = $query->row();
		
		return $row->Column_name;
	}

	private function get_rows()
	{
		$this->fields[] = $this->get_primary_key($this->db_table) . ' AS ia_primary_key';

		$this->ci->db->select(implode(',', $this->fields), FALSE);
		$query = $this->ci->db->get($this->db_table);

		return $query->result_array();
	}
	
	private function set_actions($actions)
	{
		foreach ($actions as $action)
		{
			switch ($action->key)
			{
				case 'view':
				case 'add':
				case 'import':
				case 'export':
				case 'print';
					$this->page_actions[] = $action;
					break;

				default:
					$this->table_actions[] = $action;
					break;
			}
		}
	}

}