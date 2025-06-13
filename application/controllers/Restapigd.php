<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');
header("Content-type: application/json");

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Restapigd extends REST_Controller
{
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // basic authentication for Rest API
    private function _authenticate() {
        $headers = $this->input->request_headers();
        if (!isset($headers['Authorization'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'Authorization header is missing',
                            'status' => 401]);
            exit;
        }

        // get the basic auth username and password
        list($username, $password) = explode(':', base64_decode(substr($headers['Authorization'], 6)));

        // here you can check the username and password from the database or hardcoded values
        if ($username !== 'sadaw' || $password !== 'S@daw808') {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'Invalid credentials',
                            'status' => 401]);
            exit;
        }
    }

    // get data
    function index_get() {
        $this->_authenticate();

        // SELECT *
        // FROM `fl_schedule`
        // WHERE `a_des_cod_iata` = 'CGK'
        // AND (`a_sch_in` BETWEEN '2025-04-25 00:00:00' AND '2025-04-25 23:59:59') order by a_sch_in ASC;

        $id = $this->get('id');
        $sts = $this->get('station');
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        if ($id == '') {
            $this->db->where('a_des_cod_iata', $sts);
            $this->db->where('a_sch_in BETWEEN "'. $start_date. '" and "'. $end_date.'"');
            $this->db->order_by('a_sch_in', 'ASC');
            $fs = $this->db->get('fl_schedule')->result();
        } else {
            $this->db->where('flight_id', $id);
            $this->db->where('a_des_cod_iata', $sts);
            $this->db->where('a_sch_in BETWEEN "'. $start_date. '" and "'. $end_date.'"');
            $this->db->order_by('a_sch_in', 'ASC');
            $fs = $this->db->get('fl_schedule')->result();
        }
        // die($this->db->last_query());
        $this->response(array('data' => $fs, 
                            'message' => 'Successfully get the data', 
                            'status' => 200));
    }
}
