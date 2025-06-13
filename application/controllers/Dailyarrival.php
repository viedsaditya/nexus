<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer
require 'vendor/autoload.php';
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dailyarrival extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dailyarrival'); 
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Daily Schedule Arrival',
            // 'dailyarrival' => $this->m_dailyarrival->tampil(), 
            'aircraft' => $this->m_aircraft->tampil(),
            'isi' => 'dailyarrival/v_datadailyarrival'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generate_daily()
    {
        $this->form_validation->set_rules('arr_flightno', 'FLIGHT NO', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Daily Schedule Arrival',
                'aircraft' => $this->m_aircraft->tampil(),
                'isi' => 'dailyarrival/v_datadailyarrival'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // form validation success
            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // check if arr_id exists if so update the record
            $arr_id = trim(strtoupper($this->input->post('arr_flightno'))) . str_replace('-', '', substr($this->input->post('arr_sta'), 0, 10));

            $data = array(
                'arr_flightkey' => preg_replace('/[^A-Za-z0-9]/', '', strtoupper(substr(trim($this->input->post('arr_flightno')), 0, 2) . trim($this->input->post('arr_destination')))),
                'arr_flightno' => trim(strtoupper($this->input->post('arr_flightno'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_flightno'))),
                'arr_actype' => trim(strtoupper($this->input->post('arr_actype'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_actype'))),
                'arr_acreg' => trim(strtoupper($this->input->post('arr_acreg'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_acreg'))),
                'arr_origin' => trim(strtoupper($this->input->post('arr_origin'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_origin'))),
                'arr_destination' => trim(strtoupper($this->input->post('arr_destination'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_destination'))),
                'arr_bay' => trim(strtoupper($this->input->post('arr_bay'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_bay'))),
                'arr_gate' => trim(strtoupper($this->input->post('arr_gate'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_gate'))),
                'arr_sta' => trim(strtoupper($this->input->post('arr_sta'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_sta'))),
                'arr_eta' => trim(strtoupper($this->input->post('arr_eta'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_eta'))),
                'arr_ata' => trim(strtoupper($this->input->post('arr_ata'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_ata'))),
                'arr_landing' => trim(strtoupper($this->input->post('arr_landing'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_landing'))),
                'arr_status' => trim(strtoupper($this->input->post('arr_status'))) == NULL ? NULL : trim(strtoupper($this->input->post('arr_status'))),
                'arr_dop' => date('l', strtotime($this->input->post('arr_sta'))),
                // 'arr_season' => $this->input->post('arr_season') == NULL ? NULL:$this->input->post('arr_season'),
                'arr_is_active' => 1,
                'arr_source' => 'Manual Season',
                'arr_user_created' => $this->session->userdata('id_usr'),
                'arr_last_update' => $datenow,
            );

            // check if record exists
            $existing = $this->m_dailyarrival->check_arr_id_exists($arr_id);

            if ($existing) {
                // update existing record
                $this->session->set_flashdata('pesan', 'Data updated successfully');
                $this->m_dailyarrival->edit($arr_id, $data);
            } else {
                // insert new record
                $data['arr_id'] = $arr_id;
                $this->session->set_flashdata('pesan', 'Data saved successfully');
                $this->m_dailyarrival->simpan($data);
            }

            redirect('dailyarrival');
        }
    }

    public function generate_daily_excel(){
        // path directory/folder untuk menyimpan file xls yang di upload
        $path = './assets/upload/excel-import/';

        $config['upload_path']    = $path;
        $config['allowed_types']  = 'xlsx|xls';
        $config['max_filename']   = 255;
        $config['max_size']       = 4096;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            // upload failed, show error message
            $this->session->set_flashdata('pesan', $this->upload->display_errors());
            redirect('dailyarrival');
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
                redirect('dailyarrival');
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
                if (!isset($val[0], $val[1], $val[2], $val[3], $val[4], $val[7]) || empty($val[0]) || empty($val[7])) {
                    // skip this row if critical data is missing
                    continue;
                }

                // generate arr_id uniquely: FlightNo + Date (yyyymmdd)
                $flight_no = strtoupper(trim($val[0]));
                $date_str = substr($val[7], 0, 10); // assuming $val[7] contains datetime string
                $arr_id = $flight_no . str_replace('-', '', $date_str);

                date_default_timezone_set('Asia/Jakarta');
                $datenow = date('Y-m-d H:i:s');

                // prepare data array
                $data = array(
                    'arr_dop'        => date('l', strtotime($val[7])),
                    'arr_flightkey'  => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($val[0]))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($val[2]))),
                    'arr_flightno'   => $flight_no,
                    'arr_origin'     => strtoupper(trim($val[1])),
                    'arr_destination'=> strtoupper(trim($val[2])),
                    'arr_acreg'      => strtoupper(trim($val[3])),
                    'arr_bay'        => strtoupper(trim($val[4])),
                    'arr_sta'        => $val[7],
                    'arr_status'     => 'OPERATED',
                    // append new source file info or create new source info
                    'arr_source'     => $this->get_source($arr_id) !== NULL
                                        ? $this->get_source($arr_id)->arr_source . ', Excel Daily - ' . $file_data['file_name']
                                        : 'Excel Daily - ' . $file_data['file_name'],
                    'arr_user_created' => $this->session->userdata('id_usr'),
                    'arr_last_update' => $datenow,
                );

                // check if record exists
                $existing = $this->m_dailyarrival->check_arr_id_exists($arr_id);

                if ($existing) {
                    // update existing record
                    $this->session->set_flashdata('pesan', 'Data updated successfully');
                    $this->m_dailyarrival->edit($arr_id, $data);
                } else {
                    // insert new record
                    $data['arr_id'] = $arr_id;
                    $this->session->set_flashdata('pesan', 'Data saved successfully');
                    $this->m_dailyarrival->simpan($data);
                }
            }

            // optionally delete uploaded file to keep server clean
            // if (file_exists($file_name)) {
            //     unlink($file_name);
            // }

            // $this->session->set_flashdata('pesan', 'Data processed successfully');
            redirect('dailyarrival');
        }

    }

    // get arr_source increment data excel
    public function get_source($arr_id){
        $source = $this->db->query("SELECT arr_source FROM sch_arr WHERE arr_id = '$arr_id'")->row();

        return $source;
    }
}
