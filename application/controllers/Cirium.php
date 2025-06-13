<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

class Cirium extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_cirium'); 
        $this->load->model('m_dailyarrival');
        $this->load->model('m_dailydeparture');
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data = array(
            'title' => 'Cirium Data',
            'arrival' => $this->m_cirium->tampilarr($id_sts), 
            'departure' => $this->m_cirium->tampildep($id_sts), 
            // 'aircraft' => $this->m_aircraft->tampil(),
            'isi' => 'cirium/v_datacirium'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    // Convert UTC datetime to regular datetime
    private function convert_utc_to_datetime($utc_string) {
        if (empty($utc_string)) return null;
        
        // Parse the UTC datetime string
        $datetime = new DateTime($utc_string);
        
        // Format to MySQL datetime format
        return $datetime->format('Y-m-d H:i:s');
    }

    // cirium arrival
    public function fetch_cirium_arr()
    {
        try {
            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            $api_url = 'http://139.5.150.205:8077/fsstaging/apifs/arr/';
            curl_setopt_array($ch, [
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ]
            ]);

            // Execute cURL request
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new Exception("cURL Error: " . curl_error($ch));
            }

            // Close cURL session
            curl_close($ch);

            // Check HTTP response code
            if ($http_code !== 200) {
                throw new Exception("API returned HTTP code: " . $http_code);
            }

            // Decode JSON response
            $data = json_decode($response, true);

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";die();

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON response from API: " . json_last_error_msg());
            }

            $inserted_count = 0;
            $updated_count = 0;
            $error_count = 0;

            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // Process each flight record
            foreach ($data as $flight) {
                try {
                    // Convert UTC times to regular datetime
                    $arr_sta = $this->convert_utc_to_datetime($flight['scheduledGateArrivalLocal']);
                    $arr_eta = $this->convert_utc_to_datetime($flight['estimatedGateArrivalLocal']) ?? null;
                    $arr_ata = $this->convert_utc_to_datetime($flight['actualGateArrivalLocal']) ?? null;
                    
                    // check if arr_id exists if so update the record
                    $arr_id = preg_replace('/[^A-Za-z0-9]/', '', trim(strtoupper($flight['carrierFsCode'])) . trim(strtoupper($flight['flightNumber'])) . str_replace('-', '', substr($arr_sta, 0, 10)));

                    // Process arrival data
                    $arr_data = array(
                        'arr_flightkey' => preg_replace('/[^A-Za-z0-9]/', '', $flight['carrierFsCode'] . $flight['arrivalAirportFsCode']),
                        'arr_flightno' => preg_replace('/[^A-Za-z0-9]/', '', $flight['carrierFsCode'] . $flight['flightNumber']) ?? null,
                        // 'arr_actype' => preg_replace('/[^A-Za-z0-9]/', '', $flight['scheduledEquipmentIataCode']) ?? null,
                        'arr_acreg' => preg_replace('/[^A-Za-z0-9]/', '', $flight['tailNumber']) ?? null,
                        'arr_origin' => preg_replace('/[^A-Za-z0-9]/', '', $flight['departureAirportFsCode']) ?? null,
                        'arr_destination' => preg_replace('/[^A-Za-z0-9]/', '', $flight['arrivalAirportFsCode']) ?? null,
                        'arr_sta' => $arr_sta,
                        // 'arr_eta' => $arr_eta,
                        // 'arr_ata' => $arr_ata,
                        'arr_status' => 'OPERATED',
                        'arr_dop' => isset($arr_sta) ? date('l', strtotime($arr_sta)) : null,
                        'arr_is_active' => 1,
                        'arr_source' => 'API Cirium',
                        'arr_last_update' => $datenow
                    );

                    // Check if record exists
                    $existing = $this->m_dailyarrival->check_arr_id_exists($arr_id);
                    
                    if ($existing) {
                        // $this->m_dailyarrival->edit($arr_id, $arr_data);
                        $updated_count++;
                    } else {
                        $arr_data['arr_id'] = $arr_id;
                        $this->m_dailyarrival->simpan($arr_data);
                        $inserted_count++;
                    }

                } catch (Exception $e) {
                    $error_count++;
                    log_message('error', 'Error processing flight data: ' . $e->getMessage());
                    continue;
                }
            }

            $message = sprintf(
                'API data import completed. Inserted: %d, Updated: %d, Errors: %d',
                $inserted_count,
                $updated_count,
                $error_count
            );

            $this->session->set_flashdata('pesan', $message);

        } catch (Exception $e) {
            $this->session->set_flashdata('pesanerror', 'Failed to fetch or process API data: ' . $e->getMessage());
            log_message('error', 'API import error: ' . $e->getMessage());
        }

        redirect('cirium');
    }

    // cirium departure
    public function fetch_cirium_dep()
    {
        try {
            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            $api_url = 'http://139.5.150.205:8077/fsstaging/apifs/dep/';
            curl_setopt_array($ch, [
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json'
                ]
            ]);

            // Execute cURL request
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new Exception("cURL Error: " . curl_error($ch));
            }

            // Close cURL session
            curl_close($ch);

            // Check HTTP response code
            if ($http_code !== 200) {
                throw new Exception("API returned HTTP code: " . $http_code);
            }

            // Decode JSON response
            $data = json_decode($response, true);

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";die();

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON response from API: " . json_last_error_msg());
            }

            $inserted_count = 0;
            $updated_count = 0;
            $error_count = 0;

            date_default_timezone_set('Asia/Jakarta');
            $datenow = date('Y-m-d H:i:s');

            // Process each flight record
            foreach ($data as $flight) {
                try {
                    // Convert UTC times to regular datetime
                    $dep_std = $this->convert_utc_to_datetime($flight['scheduledGateDepartureLocal']);
                    $dep_etd = $this->convert_utc_to_datetime($flight['estimatedGateDepartureLocal']) ?? null;
                    $dep_atd = $this->convert_utc_to_datetime($flight['actualGateDepartureLocal']) ?? null;
                    
                    // check if arr_id exists if so update the record
                    $dep_id = preg_replace('/[^A-Za-z0-9]/', '', trim(strtoupper($flight['carrierFsCode'])) . trim(strtoupper($flight['flightNumber'])) . str_replace('-', '', substr($dep_std, 0, 10)));

                    // Process arrival data
                    $dep_data = array(
                        'dep_flightkey' => preg_replace('/[^A-Za-z0-9]/', '', $flight['carrierFsCode'] . $flight['arrivalAirportFsCode']),
                        'dep_flightno' => preg_replace('/[^A-Za-z0-9]/', '', $flight['carrierFsCode'] . $flight['flightNumber']) ?? null,
                        // 'dep_actype' => preg_replace('/[^A-Za-z0-9]/', '', $flight['scheduledEquipmentIataCode']) ?? null,
                        'dep_acreg' => preg_replace('/[^A-Za-z0-9]/', '', $flight['tailNumber']) ?? null,
                        'dep_origin' => preg_replace('/[^A-Za-z0-9]/', '', $flight['departureAirportFsCode']) ?? null,
                        'dep_destination' => preg_replace('/[^A-Za-z0-9]/', '', $flight['arrivalAirportFsCode']) ?? null,
                        'dep_std' => $dep_std,
                        // 'dep_etd' => $dep_etd,
                        // 'dep_atd' => $dep_atd,
                        'dep_status' => 'OPERATED',
                        'dep_dop' => isset($dep_std) ? date('l', strtotime($dep_std)) : null,
                        'dep_is_active' => 1,
                        'dep_source' => 'API Cirium',
                        'dep_last_update' => $datenow
                    );

                    // Check if record exists
                    $existing = $this->m_dailydeparture->check_dep_id_exists($dep_id);
                    
                    if ($existing) {
                        // $this->m_dailydeparture->edit($dep_id, $dep_data);
                        $updated_count++;
                    } else {
                        $dep_data['dep_id'] = $dep_id;
                        $this->m_dailydeparture->simpan($dep_data);
                        $inserted_count++;
                    }

                } catch (Exception $e) {
                    $error_count++;
                    log_message('error', 'Error processing flight data: ' . $e->getMessage());
                    continue;
                }
            }

            $message = sprintf(
                'API data import completed. Inserted: %d, Updated: %d, Errors: %d',
                $inserted_count,
                $updated_count,
                $error_count
            );

            $this->session->set_flashdata('pesan', $message);

        } catch (Exception $e) {
            $this->session->set_flashdata('pesanerror', 'Failed to fetch or process API data: ' . $e->getMessage());
            log_message('error', 'API import error: ' . $e->getMessage());
        }

        redirect('cirium');
    }
}
