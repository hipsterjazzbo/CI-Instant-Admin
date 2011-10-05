<?php

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Dynamic AJAX access to models from views.
     *
     * Accepts arguments via $_POST only; only the first argument passed in the
     * URL (method) will be accepted, all others will be ignored.
     *
     * In jQuery, can be used by:
     *
     * $.post('ajax/MODEL/METHOD', { arg1: val, arg2: val }, function(data) {
     *     // Do something with returned data
     * }, 'json');
     *
     * */
    function _remap($model, $params = array())
    {
        // Method will be first array item; we'll ignore the rest (if any).
        $method = array_shift($params);

        // Load the model requested. CI will throw a nice error for us if it doesn't exist.
        $this->load->model($model);

        // Call the model and method requested, and pass in any $_POST data that was sent.
        $output = call_user_func_array(array($this->$model, $method), $this->input->post());

        // 'echo' rather than 'return', as this is an AJAX controller, and encode as JSON
        echo json_encode($output);
    }

}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */
