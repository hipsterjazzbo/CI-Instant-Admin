<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class IA_Page {

	private $ci;
	public $single_name;
	public $plural_name;
	public $slug;
	private $db_tables;
	private $primary_key;
	private $headings      = array();
	private $fields        = array();
	private $data          = array();
	private $table_actions = array();
	public $page_actions   = array();

	public function __construct($single_name, $plural_name, $slug, $db_table, array $actions, $condition)
	{
		$this->ci =& get_instance();
		
		$this->single_name = $single_name;
		$this->plural_name = $plural_name;
		$this->slug        = $slug;
		$this->db_tables   = is_array($db_table) ? $db_table : array($db_table);
		$this->condition   = $condition;
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
		$this->headings[] = 'Actions';
		$tmpl = array ( 'table_open'  => '<table cellspacing="0" class="datatable">' );
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
		
		return $table . '.' . $row->Column_name;
	}

	private function get_rows()
	{
		$this->fields[] = $this->get_primary_key($this->db_tables[0]) . ' AS ia_primary_key';

		$this->ci->db->select(implode(',', $this->fields), FALSE);
		$this->ci->db->from($this->db_tables[0]);
		$this->maybe_build_joins();
		$query = $this->ci->db->get();
		$rows  = $query->result_array();
		
		foreach ($rows as $k => $row)
		{
			$rows[$k] = $this->get_row_actions($row);
		}
		
		return $rows;
	}
	
	private function maybe_build_joins()
	{
		if (count($this->db_tables) == 2)
		{
			$this->ci->db->join($this->db_tables[1], $this->condition);
		}
	}


	private function get_row_actions($row)
	{
		$key = array_pop($row);
		$row_actions = '';
		
		foreach ($this->table_actions as $table_action)
		{
			$row_actions .= '<a href="/admin/' . $this->slug . '/' . $table_action->key . '/' . $key . '">' . ucfirst($table_action->key) . '</a> ';
		}
		
		$row[] = $row_actions;
		
		return $row;
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