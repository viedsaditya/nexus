<?php
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer
require_once(APPPATH . '../vendor/autoload.php');
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Airline extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_airline'); 
        $this->load->model('m_station'); 
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Data Airline',
            'airline' => $this->m_airline->tampil(),
            'station' => $this->m_station->tampil(),  
            'isi' => 'airline/v_dataairline'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

     // input data 
     public function input()
     {
         $data = array(
             'title' => 'Input Data Airline',
             'airline' => $this->m_airline->tampil(), 
             'station' => $this->m_station->tampil(), 
             'isi' => 'airline/v_inputairline'
         );
         $this->load->view('admin-layout/v_wrapper', $data, FALSE);
     }

    public function generate_airline()
    {
        $this->form_validation->set_rules('airline_code', 'AIRLINE CODE', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_name', 'AIRLINE NAME', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_terminal', 'AIRLINE TERMINAL', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_station', 'AIRLINE STATION', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Airline',
                'airline' => $this->m_airline->tampil(),
                'station' => $this->m_station->tampil(), 
                'isi' => 'airline/v_dataairline'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // form validation success
            // check if flightkey exists if so update the record
            $flightkey = preg_replace('/[^A-Za-z0-9]/', '', trim(strtoupper($this->input->post('airline_code'))) . trim(strtoupper($this->input->post('airline_station'))));

            $data = array(
                // 'flightkey' => trim(strtoupper($this->input->post('flightkey'))) == NULL ? NULL : trim(strtoupper($this->input->post('flightkey'))),
                'airline_code' => trim(strtoupper($this->input->post('airline_code'))) == NULL ? NULL : trim(strtoupper($this->input->post('airline_code'))),
                'airline_name' => trim($this->input->post('airline_name')) == NULL ? NULL : trim($this->input->post('airline_name')),
                'airline_terminal' => trim($this->input->post('airline_terminal')) == NULL ? NULL : trim($this->input->post('airline_terminal')),
                'airline_station' => trim($this->input->post('airline_station')) == NULL ? NULL : trim($this->input->post('airline_station')),
            );

            // check if record exists
            $existing = $this->m_airline->check_flightkey_exists($flightkey);

            if ($existing) {
                // update existing record
                $this->session->set_flashdata('pesan', 'Data updated successfully');
                $this->m_airline->edit($flightkey, $data);
            } else {
                // insert new record
                $data['flightkey'] = $flightkey;
                $this->session->set_flashdata('pesan', 'Data saved successfully');
                $this->m_airline->simpan($data);
            }

            redirect('airline');
        }
    }

    public function generate_airline_excel(){
        // path directory/folder untuk menyimpan file xls yang di upload
        $path = './assets/upload/excel-import-airline/';

        $config['upload_path']    = $path;
        $config['allowed_types']  = 'xlsx|xls';
        $config['max_filename']   = 255;
        $config['max_size']       = 4096;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            // upload failed, show error message
            $this->session->set_flashdata('pesan', $this->upload->display_errors());
            redirect('airline');
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
                redirect('airline');
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
                if (!isset($val[0], $val[1], $val[2], $val[3], $val[4])) {
                    // skip this row if critical data is missing
                    continue;
                }

                // check if flightkey exists if so update the record
                $flightkey = preg_replace('/[^A-Za-z0-9]/', '', trim(strtoupper($val[1])) . trim(strtoupper($val[4])));

                // prepare data array
                $data = array(
                    'airline_code' => strtoupper(trim($val[1])),
                    'airline_name' => trim($val[2]),
                    'airline_terminal' => trim($val[3]),
                    'airline_station' => trim($val[4]),
                );

                // check if record exists
                $existing = $this->m_airline->check_flightkey_exists($flightkey);

                if ($existing) {
                    // update existing record
                    $this->session->set_flashdata('pesan', 'Data updated successfully');
                    $this->m_airline->edit($flightkey, $data);
                } else {
                    // insert new record
                    $data['flightkey'] = $flightkey;
                    $this->session->set_flashdata('pesan', 'Data saved successfully');
                    $this->m_airline->simpan($data);
                }
            }

            // optionally delete uploaded file to keep server clean
            // if (file_exists($file_name)) {
            //     unlink($file_name);
            // }

            // $this->session->set_flashdata('pesan', 'Data processed successfully');
            redirect('airline');
        }
    }

    // edit data
    public function edit($id_air)
    {
        $this->form_validation->set_rules('airline_code', 'AIRLINE CODE', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_name', 'AIRLINE NAME', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_terminal', 'AIRLINE TERMINAL', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        $this->form_validation->set_rules('airline_station', 'AIRLINE STATION', 'required', array(
            'required' => '%s must be filled !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Edit Data Airline',
                'airline' => $this->m_airline->detailmanual($id_air), 
                'station' => $this->m_station->tampil(), 
                'isi' => 'airline/v_editairline'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            // edit data
            $data = array(
                'id_air' => $id_air,
                'airline_code' => $this->input->post('airline_code'),
                'airline_name' => $this->input->post('airline_name'),
                'airline_terminal' => $this->input->post('airline_terminal'),
                'airline_station' => $this->input->post('airline_station'),
            );
            $this->m_airline->editmanual($data);  
            $this->session->set_flashdata('pesan', 'Data updated successfully');
            redirect('airline');
        }
    }
}
