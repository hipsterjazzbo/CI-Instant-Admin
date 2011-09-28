<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IA_Page {

	private $ci;
	public $single_name;
	public $plural_name;
	public $slug;
	private $db_tables;
	private $primary_key;
	private $primary_key_field;
	private $headings = array();
	private $db_fields = array();
	private $data = array();
	private $table_actions = array();
	public $page_actions = array();
	private $view;
	private $form_fields = array();
	private $action;

	public function __construct($single_name, $plural_name, $slug, $db_table, array $actions, $condition)
	{
		$this->ci = & get_instance();

		$this->single_name = $single_name;
		$this->plural_name = $plural_name;
		$this->slug = $slug;
		$this->db_tables = is_array($db_table) ? $db_table : array($db_table);
		$this->primary_key_field = $this->get_primary_key_field($this->db_tables[0]);
		$this->condition = $condition;
		$this->set_actions($actions);
		$this->action = $this->ci->router->fetch_method();

		$this->ci->load->library('table');
	}

	public function add_column($column_name, $db_field)
	{
		$this->headings[] = $column_name;
		$this->db_fields[] = $db_field;
	}

	public function add_field($label, $db_field, $type = 'text')
	{
		$this->form_fields[] = array(
			'label' => $label,
			'db_field' => $db_field,
			'type' => $type
		);
	}

	public function load()
	{
		$this->get_page_details();

		switch ($this->action)
		{
			case 'view':
				$this->build_table();
				$this->view = 'manage_table';
				break;

			case 'edit':
			case 'add':
				$this->build_form();
				$this->view = 'manage_form';
				break;
		}

		$this->ci->load->view('admin/' . $this->view, $this->data);
	}

	private function get_page_details()
	{
		$this->data['page']['name']   = $this->plural_name;
		$this->data['page']['action'] = $this->action;
		$this->get_menu_items();
	}

	private function get_menu_items()
	{
		$this->data['menu_items'] = $this->ci->instant_admin->get_menu_items();
	}

	private function build_table()
	{
		$this->headings[] = 'Actions';
		$tmpl = array('table_open' => '<table cellspacing="0" class="datatable">');
		$this->ci->table->set_template($tmpl);
		$this->ci->table->set_heading($this->headings);

		foreach ($this->get_rows() as $row)
		{
			$this->ci->table->add_row(array_values($row));
		}

		$this->data['table'] = $this->ci->table->generate();
	}

	private function build_form()
	{
		foreach ($this->form_fields as $form_field)
		{
			$this->db_fields[] = $form_field['db_field'];
		}
		
		$this->data['row']         = $this->get_row();
		$this->data['form_fields'] = $this->form_fields;
	}

	private function get_primary_key_field($table)
	{
		$query = $this->ci->db->query("SHOW INDEX FROM {$table} WHERE Key_name = 'PRIMARY'");
		$row = $query->row();

		return $table . '.' . $row->Column_name;
	}

	private function get_row()
	{
		$this->ci->db->select(implode(',', $this->db_fields), FALSE);
		$this->ci->db->from($this->db_tables[0]);
		$this->maybe_build_joins();

		if (!empty($this->primary_key))
		{
			$this->ci->db->where($this->primary_key_field, $this->primary_key);
			$query = $this->ci->db->get();
			return $query->row();
		}

		$query = $this->ci->db->get();
		return $query->result_array();
	}

	private function get_rows()
	{
		$this->db_fields[] = $this->primary_key_field . ' AS ia_primary_key';

		$rows = $this->get_row();

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
			$row_actions .= '<a href="/admin/' . $this->slug . '/' . $table_action->key . '/' . $key . '" class="action_' . $table_action->key . '">' . ucfirst($table_action->key) . '</a> ';
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
	
	public function set_message($level, $message)
	{
		$this->ci->session->set_flashdata('message', array('level' => $level, 'message' => $message));
	}
	
	public function update_record($id)
	{
		$this->ci->db->where($this->primary_key_field, $id);
		$this->ci->db->update($this->db_tables[0], $this->ci->input->post());
		
		$this->set_message('success', 'Record updated');
		redirect($this->ci->router->fetch_directory() . $this->ci->router->fetch_class() . '/view');
	}
	
	public function delete_record($id)
	{
		$this->ci->db->delete($this->db_tables[0], array($this->primary_key_field => $id));
		$this->set_message('success', 'Record successfully deleted');
	}
	
	public function add_record()
	{
		$this->ci->db->insert($this->db_tables[0], $this->ci->input->post());
		
		$this->set_message('success', 'Record successfully added');
		redirect($this->ci->router->fetch_directory() . $this->ci->router->fetch_class() . '/view');
	}

}