<?php
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer 
require 'vendor/autoload.php';
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Aircraft extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_aircraft'); 
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Data Aircraft',
            'aircraft' => $this->m_aircraft->tampil(), 
            'isi' => 'aircraft/v_dataaircraft'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // input data 
    public function input()
    {
        $data = array(
            'title' => 'Input Data Aircraft',
            'aircraft' => $this->m_aircraft->tampil(), 
            'isi' => 'aircraft/v_inputaircraft'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generate_aircraft()
    {
        $this->form_validation->set_rules('acreg', 'ACREG', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('actype', 'ACTYPE', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('acsize', 'ACSIZE', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Aircraft',
                'isi' => 'aircraft/v_dataaircraft'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // form validation success
            // check if acreg exists if so update the record
            $acreg = trim(strtoupper($this->input->post('acreg')));

            $data = array(
                // 'acreg' => trim(strtoupper($this->input->post('acreg'))) == NULL ? NULL : trim(strtoupper($this->input->post('acreg'))),
                'actype' => trim(strtoupper($this->input->post('actype'))) == NULL ? NULL : trim(strtoupper($this->input->post('actype'))),
                'acsize' => trim($this->input->post('acsize')) == NULL ? NULL : trim($this->input->post('acsize')),
            );

            // check if record exists
            $existing = $this->m_aircraft->check_acreg_exists($acreg);

            if ($existing) {
                // update existing record
                $this->session->set_flashdata('pesan', 'Data updated successfully');
                $this->m_aircraft->edit($acreg, $data);
            } else {
                // insert new record
                $data['acreg'] = $acreg;
                $this->session->set_flashdata('pesan', 'Data saved successfully');
                $this->m_aircraft->simpan($data);
            }

            redirect('aircraft');
        }
    }

    public function generate_aircraft_excel(){
        // path directory/folder untuk menyimpan file xls yang di upload
        $path = './assets/upload/excel-import-aircraft/';

        $config['upload_path']    = $path;
        $config['allowed_types']  = 'xlsx|xls';
        $config['max_filename']   = 255;
        $config['max_size']       = 4096;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            // upload failed, show error message
            $this->session->set_flashdata('pesan', $this->upload->display_errors());
            redirect('aircraft');
        } else {
            $file_data = $this->upload->data();
            $file_name = $path . $file_data['file_name'];

            // determine file extension
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);

            // use appropriate reader based on extension
            if (strtolower($extension) == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } elseif (strtolower($extension) == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $this->session->set_flashdata('pesan', array(
                    'class' => 'warning',
                    'message' => 'Only allowed file types .xlsx'
                ));
                redirect('aircraft');
            }

            // load spreadsheet and get sheet data
            $spreadsheet = $reader->load($file_name);
            $sheet_data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheet_data as $key => $val) {
                if ($key == 0) {
                    // skip header row
                    continue;
                }

                // validate minimum required columns exist to prevent undefined index errors
                if (!isset($val[0], $val[1], $val[2])) {
                    // skip this row if critical data is missing
                    continue;
                }

                // check if acreg exists if so update the record
                $acreg = trim(strtoupper($val[0]));

                // prepare data array
                $data = array(
                    // 'acreg'  => strtoupper(trim($val[0])),
                    'actype' => strtoupper(trim($val[1])),
                    'acsize' => trim($val[2]),
                );

                // check if record exists
                $existing = $this->m_aircraft->check_acreg_exists($acreg);

                if ($existing) {
                    // update existing record
                    $this->session->set_flashdata('pesan', 'Data updated successfully');
                    $this->m_aircraft->edit($acreg, $data);
                } else {
                    // insert new record
                    $data['acreg'] = $acreg;
                    $this->session->set_flashdata('pesan', 'Data saved successfully');
                    $this->m_aircraft->simpan($data);
                }
            }

            // optionally delete uploaded file to keep server clean
            // if (file_exists($file_name)) {
            //     unlink($file_name);
            // }

            // $this->session->set_flashdata('pesan', 'Data processed successfully');
            redirect('aircraft');
        }
    }

    // edit data
    public function edit($id_ac)
    {
        $this->form_validation->set_rules('acreg', 'ACREG', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('actype', 'ACTYPE', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('acsize', 'ACSIZE', 'required', array(
            'required' => '%s must be filled !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Edit Data Aircraft',
                'aircraft' => $this->m_aircraft->detailmanual($id_ac), 
                'isi' => 'aircraft/v_editaircraft'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            // edit data
            $data = array(
                'id_ac' => $id_ac,
                'acreg' => $this->input->post('acreg'),
                'actype' => $this->input->post('actype'),
                'acsize' => $this->input->post('acsize'),
            );
            $this->m_aircraft->editmanual($data);  
            $this->session->set_flashdata('pesan', 'Data updated successfully');
            redirect('aircraft');
        }
    }
}
