<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user'); 
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    //go desktop
    // data 
    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => 'Data User',
            'user' => $this->m_user->tampil($id_sts),
            'isi' => 'user/v_datauser'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // input data 
    public function input()
    {
        $this->form_validation->set_rules('fullname', 'Fullname', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tbl_gd_user.username]', array(
            'required' => '%s must be filled !!!', 'is_unique' => 'This %s already exists'
        ));
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_password_check', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('email', 'Email', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('id_sts', 'Station', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('id_role', 'Role Access', 'required', array(
            'required' => '%s must be filled !!!'
        ));

        // confiurasi file foto
        $config['upload_path']   = './assets/upload/foto-user/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
        $config['max_size']      = 2048;
        $this->upload->initialize($config);
        $field_name = 'foto';
        if ($this->form_validation->run() == FALSE) { // jika validasi form gagal atau tidak lolos validasi
            $data = array(
                'title' => 'Input Data User GO DESKTOP',
                'sts' => $this->m_user->tampilstation(), 
                'roleakses' => $this->m_user->tampilroleakses(), 
                'isi' => 'user/v_inputuser'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // jika lolos validasi
            if (!$this->upload->do_upload($field_name)) { // jika gagal upload foto
                $data = array(
                    'title' => 'Input Data User GO DESKTOP',
                    'error_upload' => $this->upload->display_errors(),
                    'sts' => $this->m_user->tampilstation(), 
                    'roleakses' => $this->m_user->tampilroleakses(),
                    'isi' => 'user/v_inputuser'
                );
                $this->load->view('admin-layout/v_wrapper', $data, FALSE);
            } else { // jika berhasil upload foto
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library']   = 'gd2';
                $config['allowed_types'] = './assets/upload/foto-user/'.$upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $is_active = '1'; // 1=created, 0=deleted
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
                // simpan data 
                $data = array(
                    'id_sts' => $this->input->post('id_sts'),
                    'id_role' => $this->input->post('id_role'),
                    'fullname' => $this->input->post('fullname'),
                    'username' => $this->input->post('username'),
                    'password' => sha1($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'foto' => $upload_data['uploads']['file_name'],
                    'is_active' => $is_active,
                    'user_create_usr' => $this->session->userdata('id_usr'),
                    'date_pass_exp' => $date,
                );
                $this->m_user->simpan($data); 
                $this->session->set_flashdata('pesan', 'Data saved successfully');
                redirect('user');
            }  
        }
    }

    // edit data 
    public function edit($id_usr)
    {
        $this->form_validation->set_rules('fullname', 'Fullname', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('username', 'Username', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        // $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_password_check', array(
        //     'required' => '%s must be filled !!!'
        // ));
        $this->form_validation->set_rules('email', 'Email', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('id_sts', 'Station', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('id_role', 'Role Access', 'required', array(
            'required' => '%s must be filled !!!'
        ));

        // confiurasi file
        $config['upload_path']   = './assets/upload/foto-user/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
        $config['max_size']      = 2048;
        $this->upload->initialize($config);
        $field_name = 'foto';
        if ($this->form_validation->run() == FALSE) { // jika validasi form gagal atau tidak lolos validasi
            $data = array(
                'title' => 'Edit Data User GO DESKTOP',
                'user' => $this->m_user->detail($id_usr), 
                'sts' => $this->m_user->tampilstation(),
                'roleakses' => $this->m_user->tampilroleakses(),
                'isi' => 'user/v_edituser'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // jika lolos validasi
            if (!$this->upload->do_upload($field_name)) { // jika gagal upload foto
                // jika tidak ganti foto
                $is_active = '1'; // 1=created, 0=deleted
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
                // simpan data 
                $data = array(
                    'id_usr' => $id_usr,
                    'id_sts' => $this->input->post('id_sts'),
                    'id_role' => $this->input->post('id_role'),
                    'fullname' => $this->input->post('fullname'),
                    'username' => $this->input->post('username'),
                    // 'password' => sha1($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    // 'foto' => $upload_data['uploads']['file_name'],
                    // 'is_active' => $is_active,
                    'user_update_usr' => $this->session->userdata('id_usr'),
                    'date_update_usr' => $date,
                );
                $this->m_user->edit($data); 
                $this->session->set_flashdata('pesan', 'Data edited successfully');
                redirect('user');
            } else { // jika berhasil upload foto
                // jika ganti foto
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library']   = 'gd2';
                $config['allowed_types'] = './assets/upload/foto-user/'.$upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $is_active = '1'; // 1=created, 0=deleted
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y-m-d H:i:s');
                // simpan data 
                $data = array(
                    'id_usr' => $id_usr,
                    'id_sts' => $this->input->post('id_sts'),
                    'id_role' => $this->input->post('id_role'),
                    'fullname' => $this->input->post('fullname'),
                    'username' => $this->input->post('username'),
                    // 'password' => sha1($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'foto' => $upload_data['uploads']['file_name'],
                    // 'is_active' => $is_active,
                    'user_update_usr' => $this->session->userdata('id_usr'),
                    'date_update_usr' => $date,
                );
                $this->m_user->edit($data); 
                $this->session->set_flashdata('pesan', 'Data edited successfully');
                redirect('user');
            }  
        }
    }

    // active/deactive data
    public function activate($id_usr)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'id_usr' => $id_usr,
            'is_active' => 1,
            'user_activate_usr' => $this->session->userdata('id_usr'),
            'date_activate_usr' => $date,
        );
        $this->m_user->activate($data);
        $this->session->set_flashdata('pesan', 'Data activated successfully');
        redirect('user');
    }

    public function deactivate($id_usr)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'id_usr' => $id_usr,
            'is_active' => 0,
            'user_deactivate_usr' => $this->session->userdata('id_usr'),
            'date_deactivate_usr' => $date,
        );
        $this->m_user->deactivate($data);
        $this->session->set_flashdata('pesan', 'Data deactivated successfully');
        redirect('user');
    }

    // reset password
    public function resetpassword($id_usr)
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_password_check', array(
            'required' => '%s must be filled !!!'
        ));

        $id_sts = $this->session->userdata('id_sts');
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Data User',
                'user' => $this->m_user->tampil($id_sts), 
                'isi' => 'user/v_datauser'
            );
            $this->session->set_flashdata('pesanerror', 'The password must contain at least one uppercase letter and one number');
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');

            $data = array(
                'id_usr' => $id_usr,
                'password' => sha1($this->input->post('password')),
                'user_update_usr' => $this->session->userdata('id_usr'),
                'date_update_usr' => $date,
                'date_pass_exp' => $date,
            );
            $this->m_user->edit($data);
            $this->session->set_flashdata('pesan', 'Reset password successfully');
            redirect('user');
        }
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
                'title' => 'Change Password',
                'user' => $this->m_user->detail($id_usr), 
                'isi' => 'user/v_changepassword'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
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
            redirect($this->user_login->logoutchangepassword());
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
