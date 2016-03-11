<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Helpdesk_model');
        $this->load->library('session');
    }
    
    // Check if session exists. Used by app at each page load.
    public function index_get()
    {
        // Does session ID passed in URL match session variable on server side?
        if($this->session->AuthID == $this->get('AuthID'))
        {
            $this->response('Access Granted', 200);
        }
        else
        {
            $this->response('Access Denied', 200);
        }
    }
    
    // Log in
    public function index_post()
    {
        if($this->post('email') && $this->post('password')){
            $credentials = base64_encode($this->post('email').':'.$this->post('password'));
        
            $allowed = $this->Helpdesk_model->authenticate($credentials);
            
            if($allowed)
            {

                $user = array('AuthID'=>$allowed->AuthID);
                $this->session->set_userdata($user);
                $this->response($allowed, 200);
            }
            else
            {
                $this->response('Access Denied', 200);
            }
        }
        else
        {
            $this->response('Access Denied', 200);
        }
        
        
        
    }
    
    // Destroy Session
    public function index_delete()
    {
        $this->session->sess_destroy();
    }

}
