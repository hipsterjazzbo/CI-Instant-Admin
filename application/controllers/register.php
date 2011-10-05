<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->model('page_model');        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|matches[repeat_email]');
        $this->form_validation->set_rules('repeat_email', 'Repeat Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
        $this->form_validation->set_rules('work_phone', 'Work Phone', 'trim|required');
        $this->form_validation->set_rules('address_number', 'Number', 'trim|required');
        $this->form_validation->set_rules('address_street', 'Street', 'trim|required');
        $this->form_validation->set_rules('address_suburb', 'Suburb', 'trim|required');
        $this->form_validation->set_rules('address_city', 'City', 'trim|required');
        $this->form_validation->set_rules('address_postcode', 'Postcode', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_conf]');
        $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['groups'] = $this->page_model->get_groups();
            $data['stores'] = $this->page_model->get_stores(1, true);
            $data['page'] = 'register';
            
            $this->load->view('public_main', $data);
        }
        else
        {
            $this->page_model->add_member();
            redirect('page/home');
        }
    }

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */
