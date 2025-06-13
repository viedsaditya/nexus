<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer
require 'vendor/autoload.php';
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dailydeparture extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dailydeparture'); 
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Daily Schedule Departure',
            'dailydeparture' => $this->m_dailydeparture->tampil(), 
            'aircraft' => $this->m_aircraft->tampil(),
            'isi' => 'dailydeparture/v_datadailydeparture'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generate_daily()
    {
        $this->form_validation->set_rules('dep_flightno', 'FLIGHT NO', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Daily Schedule Departure',
                'aircraft' => $this->m_aircraft->tampil(),
                'isi' => 'dailydeparture/v_datadailydeparture'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // form validation success
            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // check if dep_id exists if so update the record
            $dep_id = trim(strtoupper($this->input->post('dep_flightno'))) . str_replace('-', '', substr($this->input->post('dep_std'), 0, 10));

            $data = array(
                'dep_flightkey' => preg_replace('/[^A-Za-z0-9]/', '', strtoupper(substr(trim($this->input->post('dep_flightno')), 0, 2) . trim($this->input->post('dep_origin')))),
                'dep_flightno' => trim(strtoupper($this->input->post('dep_flightno'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_flightno'))),
                'dep_actype' => trim(strtoupper($this->input->post('dep_actype'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_actype'))),
                'dep_acreg' => trim(strtoupper($this->input->post('dep_acreg'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_acreg'))),
                'dep_origin' => trim(strtoupper($this->input->post('dep_origin'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_origin'))),
                'dep_destination' => trim(strtoupper($this->input->post('dep_destination'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_destination'))),
                'dep_bay' => trim(strtoupper($this->input->post('dep_bay'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_bay'))),
                'dep_gate' => trim(strtoupper($this->input->post('dep_gate'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_gate'))),
                'dep_std' => trim(strtoupper($this->input->post('dep_std'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_std'))),
                'dep_etd' => trim(strtoupper($this->input->post('dep_etd'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_etd'))),
                'dep_atd' => trim(strtoupper($this->input->post('dep_atd'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_atd'))),
                'dep_airborne' => trim(strtoupper($this->input->post('dep_airborne'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_airborne'))),
                'dep_status' => trim(strtoupper($this->input->post('dep_status'))) == NULL ? NULL : trim(strtoupper($this->input->post('dep_status'))),
                'dep_dop' => date('l', strtotime($this->input->post('dep_std'))),
                // 'dep_season' => $this->input->post('dep_season') == NULL ? NULL:$this->input->post('dep_season'),
                'dep_is_active' => 1,
                'dep_source' => 'Manual Season',
                'dep_user_created' => $this->session->userdata('id_usr'),
                'dep_last_update' => $datenow,
            );

            // check if record exists
            $existing = $this->m_dailydeparture->check_dep_id_exists($dep_id);

            if ($existing) {
                // update existing record
                $this->session->set_flashdata('pesan', 'Data updated successfully');
                $this->m_dailydeparture->edit($dep_id, $data);
            } else {
                // insert new record
                $data['dep_id'] = $dep_id;
                $this->session->set_flashdata('pesan', 'Data saved successfully');
                $this->m_dailydeparture->simpan($data);
            }

            redirect('dailydeparture');
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
            redirect('dailydeparture');
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
                redirect('dailydeparture');
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

                // generate dep_id uniquely: FlightNo + Date (yyyymmdd)
                $flight_no = strtoupper(trim($val[0]));
                $date_str = substr($val[7], 0, 10); // assuming $val[7] contains datetime string
                $dep_id = $flight_no . str_replace('-', '', $date_str);

                date_default_timezone_set('Asia/Jakarta');
                $datenow = date('Y-m-d H:i:s');

                // prepare data array
                $data = array(
                    'dep_dop'        => date('l', strtotime($val[7])),
                    'dep_flightkey'  => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($val[0]))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($val[1]))),
                    'dep_flightno'   => $flight_no,
                    'dep_origin'     => strtoupper(trim($val[1])),
                    'dep_destination'=> strtoupper(trim($val[2])),
                    'dep_acreg'      => strtoupper(trim($val[3])),
                    'dep_bay'        => strtoupper(trim($val[4])),
                    'dep_std'        => $val[7],
                    'dep_status'     => 'OPERATED',
                    // append new source file info or create new source info
                    'dep_source'     => $this->get_source($dep_id) !== NULL
                                        ? $this->get_source($dep_id)->dep_source . ', Excel Daily - ' . $file_data['file_name']
                                        : 'Excel Daily - ' . $file_data['file_name'],
                    'dep_user_created' => $this->session->userdata('id_usr'),
                    'dep_last_update' => $datenow,
                );

                // check if record exists
                $existing = $this->m_dailydeparture->check_dep_id_exists($dep_id);

                if ($existing) {
                    // update existing record
                    $this->session->set_flashdata('pesan', 'Data updated successfully');
                    $this->m_dailydeparture->edit($dep_id, $data);
                } else {
                    // insert new record
                    $data['dep_id'] = $dep_id;
                    $this->session->set_flashdata('pesan', 'Data saved successfully');
                    $this->m_dailydeparture->simpan($data);
                }
            }

            // optionally delete uploaded file to keep server clean
            // if (file_exists($file_name)) {
            //     unlink($file_name);
            // }

            // $this->session->set_flashdata('pesan', 'Data processed successfully');
            redirect('dailydeparture');
        }

    }

    // get dep_source increment data excel
    public function get_source($dep_id){
        $source = $this->db->query("SELECT dep_source FROM sch_dep WHERE dep_id = '$dep_id'")->row();

        return $source;
    }
}
