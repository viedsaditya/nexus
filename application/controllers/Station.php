<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Station extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_station'); 
        $this->user_login->cek_login(); // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Data Station',
            'station' => $this->m_station->tampil(), 
            'isi' => 'station/v_datastation'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // input data 
    public function input()
    {
        $this->form_validation->set_rules('code_station', 'Code Station', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('name_station', 'Name Station', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('country', 'Country', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Input Data Station',
                'isi' => 'station/v_inputstation'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            $is_active = '1'; // 1=created, 0=deleted

            // simpan data 
            $data = array(
                'code_station' => $this->input->post('code_station'),
                'name_station' => $this->input->post('name_station'),
                'country' => $this->input->post('country'),
                'is_active' => $is_active,
                'user_create_sts' => $this->session->userdata('id_usr'),
            );
            $this->m_station->simpan($data); 
            $this->session->set_flashdata('pesan', 'Data Berhasil Disimpan');
            redirect('station/input');
        }
    }
    
    // edit data
    public function edit($id_sts)
    {
        $this->form_validation->set_rules('code_station', 'Code Station', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('name_station', 'Name Station', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('country', 'Country', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Edit Data Station',
                'station' => $this->m_station->detail($id_sts), 
                'isi' => 'station/v_editstation'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            $is_active = '1'; // 1=created, 0=deleted
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');

            // edit data
            $data = array(
                'id_sts' => $id_sts,
                'code_station' => $this->input->post('code_station'),
                'name_station' => $this->input->post('name_station'),
                'country' => $this->input->post('country'),
                // 'is_active' => $is_active,
                'user_update_sts' => $this->session->userdata('id_usr'),
                'date_update_sts' => $date,
            );
            $this->m_station->edit($data);  
            $this->session->set_flashdata('pesan', 'Data Berhasil Diedit');
            redirect('station');
        }
    }

    // active/deactive data
    public function activate($id_sts)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'id_sts' => $id_sts,
            'is_active' => 1,
            'user_activate_sts' => $this->session->userdata('id_usr'),
            'date_activate_sts' => $date,
        );
        $this->m_station->activate($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Activate');
        redirect('station');
    }

    public function deactivate($id_sts)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $data = array(
            'id_sts' => $id_sts,
            'is_active' => 0,
            'user_deactivate_sts' => $this->session->userdata('id_usr'),
            'date_deactivate_sts' => $date,
        );
        $this->m_station->deactivate($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Deactivate');
        redirect('station');
    }
}
