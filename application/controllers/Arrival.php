<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

class Arrival extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_arrival'); 
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => 'Arrival Flight Schedule',
            'arrival' => $this->m_arrival->tampil($id_sts), 
            'aircraft' => $this->m_aircraft->tampil(),
            'total' => $this->m_arrival->tampiltotal($id_sts),
            'totalpair' => $this->m_arrival->tampiltotalpair($id_sts),
            'totalnotpair' => $this->m_arrival->tampiltotalnotpair($id_sts),
            'totalcancel' => $this->m_arrival->tampiltotalcancel($id_sts),
            'isi' => 'arrival/v_dataarrival'
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
            'title' => $da != $db ? 'Arrival Flight Schedule ':'Arrival Flight Schedule ',
            'arrival' => $this->m_arrival->tampilfilter($date_a, $date_b, $id_sts), 
            'aircraft' => $this->m_aircraft->tampil(),
            'total' => $this->m_arrival->tampiltotalfilter($date_a, $date_b, $id_sts),
            'totalpair' => $this->m_arrival->tampiltotalpairfilter($date_a, $date_b, $id_sts),
            'totalnotpair' => $this->m_arrival->tampiltotalnotpairfilter($date_a, $date_b, $id_sts),
            'totalcancel' => $this->m_arrival->tampiltotalcancelfilter($date_a, $date_b, $id_sts),
            'isi' => 'arrival/v_dataarrival'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // edit data 
    public function edit()
    {
        $this->form_validation->set_rules('arr_id', 'Arr ID', 'required', array(
            'required' => '%s Harus Diisi !!!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Arrival Flight Schedule',
                'arrival' => $this->m_arrival->tampil(), 
                'aircraft' => $this->m_aircraft->tampil(),
                'isi' => 'arrival/v_dataarrival'
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
            $this->m_arrival->editarr($dataarr);  
            $this->session->set_flashdata('pesan', 'Data updated successfully');
            redirect('arrival');
        }
    }

    // cancel flight selected data
    public function cancelflight()
    {
        if (isset($_POST['btnCancelFlight'])) {
            if (!empty($this->input->post('check_flight_arr'))) {
                $checkedFilghtArr = $this->input->post('check_flight_arr');
                $checkedIdArr = [];

                foreach ($checkedFilghtArr as $row) {
                    array_push($checkedIdArr, $row);
                }

                $this->m_arrival->cancelselectedarr($checkedIdArr);  
                $this->session->set_flashdata('pesan', 'Cancel flight successfully');
                redirect('arrival');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for cancel');
                redirect('arrival');
            }
        } 
    }

    // delete selected flight
    public function softdeleteflight()
    {
        if (isset($_POST['btnSoftDeleteFlight'])) {
            if (!empty($this->input->post('check_flight_arr'))) {
                $checkedFilghtArr = $this->input->post('check_flight_arr');
                $checkedIdArr = [];

                foreach ($checkedFilghtArr as $row) {
                    array_push($checkedIdArr, $row);
                }

                $this->m_arrival->softdeleteselectedarr($checkedIdArr);  
                $this->session->set_flashdata('pesan', 'Delete flight successfully');
                redirect('arrival');
            } else {  
                $this->session->set_flashdata('pesanerror', 'Select atleast any flight for delete');
                redirect('arrival');
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
