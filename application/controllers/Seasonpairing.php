<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

class Seasonpairing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_seasonpairing'); 
        $this->load->model('m_aircraft'); 
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => 'Pairing Flight Schedule',
            'seasonpairing' => $this->m_seasonpairing->tampil($id_sts), 
            'aircraft' => $this->m_aircraft->tampil(), 
            'total' => $this->m_seasonpairing->tampiltotal($id_sts),
            'isi' => 'seasonpairing/v_dataseasonpairing'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // filter
    public function filter()
    {
        $date_a = $this->input->post("date_a");
        $date_b = $this->input->post("date_b");
        $da = $date_a != "" ? date("d M Y", strtotime($date_a)):"";
        $db = $date_b != "" ? date("d M Y", strtotime($date_b)):"";
        $cdt = $date_a && $date_b != "" ? " to ":" ";

        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => $da != $db ? 'Pairing Flight Schedule':'Pairing Flight Schedule',
            'seasonpairing' => $this->m_seasonpairing->tampilfilter($date_a, $date_b, $id_sts), 
            'aircraft' => $this->m_aircraft->tampil(), 
            'total' => $this->m_seasonpairing->tampiltotalfilter($date_a, $date_b, $id_sts),
            'isi' => 'seasonpairing/v_dataseasonpairing'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // input data
    public function input()
    {
        $this->form_validation->set_rules('arr_flightno', 'Arr Flight No', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('dep_flightno', 'Dep Flight No', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Pairing Flight Schedule',
                'seasonpairing' => $this->m_seasonpairing->tampil(), 
                'aircraft' => $this->m_aircraft->tampil(), 
                'isi' => 'seasonpairing/v_dataseasonpairing'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // check if arr_id exists if so update the record
            $arr_id = trim(strtoupper($this->input->post('arr_flightno'))) . str_replace('-', '', substr($this->input->post('arr_sta'), 0, 10));
            $existing_arr = $this->m_seasonpairing->get_arr_by_id($arr_id);

            $dataarr = array(
                'arr_flightkey' => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('arr_flightno')))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('arr_destination')))),
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
                // 'arr_is_active' => $this->input->post('arr_is_active') == NULL ? NULL:$this->input->post('arr_is_active'),
                'arr_user_created' => $this->session->userdata('id_usr'),
                'arr_last_update' => $datenow,
            );

            if ($existing_arr) {
                // update arr data if exists
                $dataarr['arr_id'] = $arr_id;
                $this->m_seasonpairing->editarr($dataarr);
            } else {
                // insert new arr data if not found
                $dataarr['arr_id'] = $arr_id;
                $this->m_seasonpairing->simpanarr($dataarr);
            }

            // check if dep_id exists, if so, update the record
            $dep_id = trim(strtoupper($this->input->post('dep_flightno'))) . str_replace('-', '', substr($this->input->post('dep_std'), 0, 10));
            $existing_dep = $this->m_seasonpairing->get_dep_by_id($dep_id);

            $datadep = array(
                'dep_flightkey' => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('dep_flightno')))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('dep_origin')))),
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
                // 'dop_is_active' => $this->input->post('dop_is_active') == NULL ? NULL:$this->input->post('dop_is_active'),
                'dep_user_created' => $this->session->userdata('id_usr'),
                'dep_last_update' => $datenow,
            );

            if ($existing_dep) {
                // update dep data if exists
                $datadep['dep_id'] = $dep_id;
                $this->m_seasonpairing->editdep($datadep);
            } else {
                // insert new dep data if not found
                $datadep['dep_id'] = $dep_id;
                $this->m_seasonpairing->simpandep($datadep);
            }

            $this->session->set_flashdata('pesan', 'Data saved successfully');
            redirect('seasonpairing');
        }
    }

    // edit data 
    public function edit()
    {
        $this->form_validation->set_rules('arr_id', 'Arr ID', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));
        $this->form_validation->set_rules('dep_id', 'Dep ID', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Pairing Flight Schedule',
                'seasonpairing' => $this->m_seasonpairing->tampil(), 
                'aircraft' => $this->m_aircraft->tampil(), 
                'isi' => 'seasonpairing/v_dataseasonpairing'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // edit data arr
            $dataarr = array(
                'arr_id' => trim(strtoupper($this->input->post('arr_id'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_id'))),
                'arr_flightkey' => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('arr_flightno')))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('arr_destination')))),
                'arr_flightno' => trim(strtoupper($this->input->post('arr_flightno'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_flightno'))),
                'arr_actype' => trim(strtoupper($this->input->post('arr_actype'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_actype'))),
                'arr_acreg' => trim(strtoupper($this->input->post('arr_acreg'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_acreg'))),
                'arr_origin' => trim(strtoupper($this->input->post('arr_origin'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_origin'))),
                'arr_destination' => trim(strtoupper($this->input->post('arr_destination'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_destination'))),
                'arr_bay' => trim(strtoupper($this->input->post('arr_bay'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_bay'))),
                'arr_gate' => trim(strtoupper($this->input->post('arr_gate'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_gate'))),
                'arr_sta' => trim(strtoupper($this->input->post('arr_sta'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_sta'))),
                'arr_eta' => trim(strtoupper($this->input->post('arr_eta'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_eta'))),
                'arr_ata' => trim(strtoupper($this->input->post('arr_ata'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_ata'))),
                'arr_landing' => trim(strtoupper($this->input->post('arr_landing'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_landing'))),
                'arr_status' => trim(strtoupper($this->input->post('arr_status'))) == NULL ? NULL:trim(strtoupper($this->input->post('arr_status'))),
                // 'arr_season' => $this->input->post('arr_season') == NULL ? NULL:$this->input->post('arr_season'),
                // 'arr_dop' => $this->input->post('arr_dop') == NULL ? NULL:$this->input->post('arr_dop'),
                // 'arr_is_active' => $this->input->post('arr_is_active') == NULL ? NULL:$this->input->post('arr_is_active'),
                'arr_user_created' => $this->session->userdata('id_usr'),
                'arr_last_update' => $datenow,
            );
            $this->m_seasonpairing->editarr($dataarr); 

            // edit data dep
            $datadep = array(
                'dep_id' => trim(strtoupper($this->input->post('dep_id'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_id'))),
                'dep_flightkey' => substr(preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('dep_flightno')))), 0, 2) . preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim($this->input->post('dep_origin')))),
                'dep_flightno' => trim(strtoupper($this->input->post('dep_flightno'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_flightno'))),
                'dep_actype' => trim(strtoupper($this->input->post('dep_actype'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_actype'))),
                'dep_acreg' => trim(strtoupper($this->input->post('dep_acreg'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_acreg'))),
                'dep_origin' => trim(strtoupper($this->input->post('dep_origin'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_origin'))),
                'dep_destination' => trim(strtoupper($this->input->post('dep_destination'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_destination'))),
                'dep_bay' => trim(strtoupper($this->input->post('dep_bay'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_bay'))),
                'dep_gate' => trim(strtoupper($this->input->post('dep_gate'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_gate'))),
                'dep_std' => trim(strtoupper($this->input->post('dep_std'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_std'))),
                'dep_etd' => trim(strtoupper($this->input->post('dep_etd'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_etd'))),
                'dep_atd' => trim(strtoupper($this->input->post('dep_atd'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_atd'))),
                'dep_airborne' => trim(strtoupper($this->input->post('dep_airborne'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_airborne'))),
                'dep_status' => trim(strtoupper($this->input->post('dep_status'))) == NULL ? NULL:trim(strtoupper($this->input->post('dep_status'))),
                // 'dep_season' => $this->input->post('dep_season') == NULL ? NULL:$this->input->post('dep_season'),
                // 'dep_dop' => $this->input->post('dep_dop') == NULL ? NULL:$this->input->post('dep_dop'),
                // 'dep_is_active' => $this->input->post('dep_is_active') == NULL ? NULL:$this->input->post('dep_is_active'),
                'dep_user_created' => $this->session->userdata('id_usr'),
                'dep_last_update' => $datenow,
            );
            $this->m_seasonpairing->editdep($datadep);  
            $this->session->set_flashdata('pesan', 'Data updated successfully');
            redirect('seasonpairing');
        }
    }

    // cancel flight selected data
    public function cancelflight()
    {
        if (isset($_POST['btnCancelFlight'])) {
            if (!empty($this->input->post('check_flight_arr')) && !empty($this->input->post('check_flight_dep'))) {
                $checkedFilghtArr = $this->input->post('check_flight_arr');
                $checkedIdArr = [];
                $checkedFilghtDep = $this->input->post('check_flight_dep');
                $checkedIdDep = [];

                foreach ($checkedFilghtArr as $row) {
                    array_push($checkedIdArr, $row);
                }

                foreach ($checkedFilghtDep as $row) {
                    array_push($checkedIdDep, $row);
                }

                $this->m_seasonpairing->cancelselectedarr($checkedIdArr);  
                $this->m_seasonpairing->cancelselecteddep($checkedIdDep);
                $this->session->set_flashdata('pesan', 'Cancel flight successfully');
                redirect('seasonpairing');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for cancel');
                redirect('seasonpairing');
            }
        } 
    }

    // delete selected flight
    public function softdeleteflight()
    {
        if (isset($_POST['btnSoftDeleteFlight'])) {
            if (!empty($this->input->post('check_flight_arr')) && !empty($this->input->post('check_flight_dep'))) {
                $checkedFilghtArr = $this->input->post('check_flight_arr');
                $checkedIdArr = [];
                $checkedFilghtDep = $this->input->post('check_flight_dep');
                $checkedIdDep = [];

                foreach ($checkedFilghtArr as $row) {
                    array_push($checkedIdArr, $row);
                }

                foreach ($checkedFilghtDep as $row) {
                    array_push($checkedIdDep, $row);
                }

                $this->m_seasonpairing->softdeleteselectedarr($checkedIdArr);  
                $this->m_seasonpairing->softdeleteselecteddep($checkedIdDep);
                $this->session->set_flashdata('pesan', 'Delete flight successfully');
                redirect('seasonpairing');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for delete');
                redirect('seasonpairing');
            }
        } 
    }

    public function get_aircraft_autocomplete() {
        $term = $this->input->get('term');
        
        $this->db->select('acreg, actype')
                 ->from('tb_aircraft')
                 ->like('acreg', $term, 'both')
                 ->or_like('actype', $term, 'both')
                 ->order_by('acreg', 'ASC')
                 ->limit(10);
                 
        $query = $this->db->get();
        $result = $query->result();
        
        $response = array();
        foreach($result as $row) {
            $response[] = array(
                'label' => $row->acreg . ' - ' . $row->actype,
                'value' => $row->acreg,
                'actype' => $row->actype
            );
        }
        
        echo json_encode($response);
    }
}

