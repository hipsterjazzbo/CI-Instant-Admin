<?php

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Retrieves requested table data from DB
	 * 
	 * @param string $table The table to select from
	 * @param array $fields The fields to select
	 * @return array $data Arraay of table data
	 */
	function get_table_data($table, $fields)
	{
		$query = $this->db->select($fields)->get($table);
		return $query->result_array();
	}
}
