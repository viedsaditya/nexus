<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exppasslogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user'); 
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => '',
            'isi' => 'login/v_exppasslogin'
        );
        $this->load->view('admin-layout/v_wrapperlogin', $data, FALSE);
    }

    // change password
    public function changepassword()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_password_check', array(
            'required' => '%s must be filled !!!'
        ));

        $id_usr = $this->session->userdata('id_usr');
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => '',
                'isi' => 'login/v_exppasslogin'
            );
            $this->load->view('admin-layout/v_wrapperlogin', $data, FALSE);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');
        
            $data = array(
                'id_usr' => $id_usr,
                'password' => sha1($this->input->post('password')),
                'date_pass_exp' => $date,
            );
            $this->m_user->edit($data);  
            $this->session->set_flashdata('pesan', 'Change password successfully');
            redirect('login');
        }
    }

    // check if password contains at least one uppercase letter, one number and one symbol
    public function password_check($password)
    {
        // if (preg_match('/[A-Z]/', $password) && 
        //     preg_match('/[0-9]/', $password) && 
        //     preg_match('/[\W_]/', $password)) {
        if (preg_match('/[A-Z]/', $password) && 
            preg_match('/[0-9]/', $password)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', 'The password must contain at least one uppercase letter and one number');
            return FALSE;
        }
    }
}
