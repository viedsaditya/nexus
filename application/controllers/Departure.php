<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

class Departure extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_departure'); 
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => 'Departure Flight Schedule',
            'departure' => $this->m_departure->tampil($id_sts),
            'aircraft' => $this->m_aircraft->tampil(),
            'total' => $this->m_departure->tampiltotal($id_sts),
            'totalpair' => $this->m_departure->tampiltotalpair($id_sts),
            'totalnotpair' => $this->m_departure->tampiltotalnotpair($id_sts),
            'totalcancel' => $this->m_departure->tampiltotalcancel($id_sts),
            'isi' => 'departure/v_datadeparture'
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
            'title' => $da != $db ? 'Departure Flight Schedule ':'Departure Flight Schedule ',
            'departure' => $this->m_departure->tampilfilter($date_a, $date_b, $id_sts), 
            'aircraft' => $this->m_aircraft->tampil(),
            'total' => $this->m_departure->tampiltotalfilter($date_a, $date_b, $id_sts),
            'totalpair' => $this->m_departure->tampiltotalpairfilter($date_a, $date_b, $id_sts),
            'totalnotpair' => $this->m_departure->tampiltotalnotpairfilter($date_a, $date_b, $id_sts),
            'totalcancel' => $this->m_departure->tampiltotalcancelfilter($date_a, $date_b, $id_sts),
            'isi' => 'departure/v_datadeparture'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // edit data 
    public function edit()
    {
        $this->form_validation->set_rules('dep_id', 'Dep ID', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Departure Flight Schedule',
                'departure' => $this->m_departure->tampil(), 
                'aircraft' => $this->m_aircraft->tampil(),
                'isi' => 'departure/v_datadeparture'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

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
            $this->m_departure->editdep($datadep);  
            $this->session->set_flashdata('pesan', 'Data updated successfully');
            redirect('departure');
        }
    }

    // cancel flight selected data
    public function cancelflight()
    {
        if (isset($_POST['btnCancelFlight'])) {
            if (!empty($this->input->post('check_flight_dep'))) {
                $checkedFilghtDep = $this->input->post('check_flight_dep');
                $checkedIdDep = [];

                foreach ($checkedFilghtDep as $row) {
                    array_push($checkedIdDep, $row);
                }
  
                $this->m_departure->cancelselecteddep($checkedIdDep);
                $this->session->set_flashdata('pesan', 'Cancel flight successfully');
                redirect('departure');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for cancel');
                redirect('departure');
            }
        } 
    }

    // delete selected flight
    public function softdeleteflight()
    {
        if (isset($_POST['btnSoftDeleteFlight'])) {
            if (!empty($this->input->post('check_flight_dep'))) {
                $checkedFilghtDep = $this->input->post('check_flight_dep');
                $checkedIdDep = [];

                foreach ($checkedFilghtDep as $row) {
                    array_push($checkedIdDep, $row);
                }

                $this->m_departure->softdeleteselecteddep($checkedIdDep);
                $this->session->set_flashdata('pesan', 'Delete flight successfully');
                redirect('departure');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for delete');
                redirect('departure');
            }
        } 
    }

    public function get_aircraft_autocomplete() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $term = $this->input->get('term');
        $term = $term ? trim($term) : '';
        
        try {
            $this->db->select('acreg as value, actype');
            $this->db->from('tb_aircraft');
            if (!empty($term)) {
                $this->db->group_start();
                $this->db->like('acreg', $term, 'both');
                $this->db->or_like('actype', $term, 'both');
                $this->db->group_end();
            }
            $this->db->limit(10);
            $query = $this->db->get();
            
            $result = $query->result();
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (Exception $e) {
            log_message('error', 'Error in get_aircraft_autocomplete: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }
}
