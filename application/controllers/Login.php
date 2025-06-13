<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    // login
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required', array(
            'required' => '%s must be filled !!!'
        ));

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = sha1($this->input->post('password'));
            $this->user_login->login($username, $password);
        }
        $data = array(
            'title' => '',
            'isi'   => 'login/v_login'
        );
        $this->load->view('admin-layout/v_wrapperlogin', $data, FALSE);
    }

    // logout
    public function logout(){
        $this->user_login->logout();
    }
}
