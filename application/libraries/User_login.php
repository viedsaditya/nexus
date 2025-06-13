<?php

class User_login   
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('m_login'); 
    }

    public function login($username, $password) 
    {
        $cek = $this->ci->m_login->login($username, $password);
        if ($cek) {
            $id_usr = $cek->id_usr;
            $id_sts = $cek->id_sts;
            $id_role = $cek->id_role;
            $fullname = $cek->fullname;
            $username = $cek->username;
            $password = $cek->password;
            $email = $cek->email;
            $foto = $cek->foto;
            $is_active = $cek->is_active;
            $date_pass_exp = $cek->date_pass_exp;
            // membuat session
            $this->ci->session->set_userdata('id_usr', $id_usr);
            $this->ci->session->set_userdata('id_sts', $id_sts);
            $this->ci->session->set_userdata('id_role', $id_role);
            $this->ci->session->set_userdata('fullname', $fullname);
            $this->ci->session->set_userdata('username', $username);
            $this->ci->session->set_userdata('password', $password);
            $this->ci->session->set_userdata('email', $email); 
            $this->ci->session->set_userdata('foto', $foto); 
            $this->ci->session->set_userdata('is_active', $is_active); 
            $this->ci->session->set_userdata('date_pass_exp', $date_pass_exp); 

            $max_password_age = 90; // maximum age of the password in 90 days=3 months
            $password_changed_date = new DateTime($this->ci->session->userdata('date_pass_exp'));
            $current_date = new DateTime();
            $interval = $current_date->diff($password_changed_date);
            $days = $interval->days;

            if ($days > $max_password_age) {
                    $this->ci->session->set_flashdata('pesan', 'Your password is too old. Please change your password');
                    redirect('exppasslogin');
            } else {
                if ($this->ci->session->userdata('is_active')==1) { // cek user is_active=1 boleh login
                    // redirect ke dashboard
                    // redirect('dashboard');
                    // redirect ke seasonpairing
                    redirect('seasonpairing');
                } else {
                    $this->ci->session->set_flashdata('pesan', 'Your account has been deactivated, please contact the administrator!');
                    redirect('login');
                }
            }
        } else { // jika user salah password
            $this->ci->session->set_flashdata('pesan', 'Incorrect username or password!');
            redirect('login');
        }
    }

    public function cek_login()
    {
        if ($this->ci->session->userdata('username')=="") {
            $this->ci->session->set_flashdata('pesan', 'If you are not logged in, please log in first!');
            redirect('login');
        } else if ($this->ci->session->userdata('id_role')=="") {
            redirect('pagenotfound');
        }
    }

    public function logout()
    {
        $this->ci->session->unset_userdata('id_usr');
        $this->ci->session->unset_userdata('id_sts');
        $this->ci->session->unset_userdata('id_role');
        $this->ci->session->unset_userdata('fullname');
        $this->ci->session->unset_userdata('username');
        $this->ci->session->unset_userdata('password');
        $this->ci->session->unset_userdata('email');
        $this->ci->session->unset_userdata('foto');
        $this->ci->session->unset_userdata('is_active');
        $this->ci->session->unset_userdata('date_pass_exp');
        $this->ci->session->set_flashdata('pesan', 'You have successfully logged out!');
        redirect('login');
    }

    public function logoutchangepassword()
    {
        $this->ci->session->unset_userdata('id_usr');
        $this->ci->session->unset_userdata('id_sts');
        $this->ci->session->unset_userdata('id_role');
        $this->ci->session->unset_userdata('fullname');
        $this->ci->session->unset_userdata('username');
        $this->ci->session->unset_userdata('password');
        $this->ci->session->unset_userdata('email');
        $this->ci->session->unset_userdata('foto');
        $this->ci->session->unset_userdata('is_active');
        $this->ci->session->unset_userdata('date_pass_exp');
        $this->ci->session->set_flashdata('pesan', 'You have successfully change password, please login again');
        redirect('login');
    }
}
