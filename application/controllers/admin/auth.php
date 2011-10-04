<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $users;
    private $roles;

    function __construct()
    {
        parent::__construct();

        $this->load->library('instant_admin');
        $this->output->enable_profiler(TRUE);

        $auth_page_config = array(
            'single_name' => 'User',
            'plural_name' => 'Users',
            'table' => array(
                'ia_users',
                'ia_roles'
            ),
            'condition' => 'ia_users.role_id = ia_roles.id'
        );

        $this->instant_admin->build_page_object('auth', $auth_page_config);
        $this->users = $this->instant_admin->page();
    }

    function login()
    {
        $this->load->view('admin/login');
    }

    function do_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $this->load->library('ia_auth');

        if ($this->ia_auth->login($email, $password))
        {
            //var_dump($this->input->post('redirect'));
            redirect($this->input->post('redirect'));
        }
    }

    function logout()
    {
        $this->load->library('ia_auth');
        $this->ia_auth->logout();
        redirect('admin/auth/login');
    }

    function view_users()
    {
        $this->users->add_column('First Name', 'first_name');
        $this->users->add_column('Last Name', 'last_name');
        $this->users->add_column('Email', 'email');
        $this->users->add_column('Role', 'name');

        $this->users->load();
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */