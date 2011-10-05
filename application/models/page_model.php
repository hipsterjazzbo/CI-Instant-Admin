<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Page_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_groups()
    {
        $query = $this->db->get('groups');
        $rows = $query->result();

        foreach ($rows as $row)
        {
            $groups[$row->group_id] = $row->group_name;
        }

        return $groups;
    }

    function get_stores($group_id, $format = false)
    {
        $query = $this->db->get_where('stores', array('group_id' => $group_id));
        $rows = $query->result();

        if ($format)
        {
            foreach ($rows as $row)
            {
                $stores[$row->store_id] = $row->store_name;
            }

            return $stores;
        }

        return $rows;
    }

    function add_member()
    {
        $data = array(
            'member_title' => $this->input->post('title'),
            'member_first_name' => $this->input->post('first_name'),
            'member_last_name' => $this->input->post('last_name'),
            'store_id' => $this->input->post('store'),
            'member_email' => $this->input->post('email'),
            'member_password' => $this->input->post('password'),
            'member_mobile' => $this->input->post('mobile'),
            'member_phone' => $this->input->post('work_phone'),
            'member_number' => $this->input->post('address_number'),
            'member_street' => $this->input->post('address_street'),
            'member_suburb' => $this->input->post('address_suburb'),
            'member_city' => $this->input->post('address_city'),
            'member_postcode' => $this->input->post('address_postcode'),
            'member_join_date' => time()
        );

        $this->db->insert('members', $data);
        
        return $this->db->insert_id();
    }

}

/* End of file page_model.php */
/* Location: ./application/models/page_model.php */
