<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer
require 'vendor/autoload.php';
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Seasonarrival extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_seasonarrival'); 
        $this->load->model('m_aircraft');
        $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data 
    public function index()
    {
        $data = array(
            'title' => 'Season Schedule Arrival',
            // 'seasonarrival' => $this->m_seasonarrival->tampil(), 
            'aircraft' => $this->m_aircraft->tampil(),
            'isi' => 'seasonarrival/v_dataseasonarrival'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generate_season()
    {
        $this->form_validation->set_rules('arr_flightno', 'FLIGHT NO', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        // form validation for arr_date not empty
        $this->form_validation->set_rules('arr_date[]', 'DOP', 'required', array(
            'required' => '%s must be filled !!!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Season Schedule Arrival',
                'aircraft' => $this->m_aircraft->tampil(),
                'isi' => 'seasonarrival/v_dataseasonarrival'
            );
            $this->load->view('admin-layout/v_wrapper', $data, FALSE);
        } else { // form validation success

            $start_date = $this->input->post('arr_start_date');
            $end_date = $this->input->post('arr_end_date');

            $startDate = new DateTime($start_date);
            $endDate = new DateTime($end_date);
            $endDate->modify('+1 day'); 

            $period = new DatePeriod(
                $startDate,
                new DateInterval('P1D'),
                $endDate
            );

            $dates = [];
            // check in_array is array
            $arr_dates = $this->input->post('arr_date');
            if (!is_array($arr_dates)) {
                $arr_dates = []; 
            }
            // next for looping per airlines data from excel
            // foreach ($airlines) ...
            foreach ($period as $date) {
                if (in_array($date->format('l'), $arr_dates)) {
                    $dates[] = $date->format('Y-m-d').'-'.$date->format('l').'-insert';
                
                    // saved data 
                    $arr_id = trim(strtoupper($this->input->post('arr_flightno'))).str_replace('-', '', $date->format('Y-m-d'));

                    $arr_dop = $date->format('l');
                    
                    $arr_sta_format = new DateTime($date->format('Y-m-d').''.$this->input->post('arr_time'));
                    $arr_sta = $arr_sta_format->format('Y-m-d H:i:s');

                    date_default_timezone_set('Asia/Jakarta');
                    $datenow = date('Y-m-d H:i:s');

                    $data = array(
                        // 'arr_id' => $arr_id,
                        'arr_dop' => $arr_dop,
                        'arr_season' => $this->input->post('arr_season'),
                        'arr_flightkey' => preg_replace('/[^A-Za-z0-9]/', '', strtoupper(substr(trim($this->input->post('arr_flightno')), 0, 2) . trim($this->input->post('arr_destination')))),
                        'arr_flightno' => trim(strtoupper($this->input->post('arr_flightno'))),
                        'arr_actype' => trim(strtoupper($this->input->post('arr_actype'))),
                        'arr_acreg' => trim(strtoupper($this->input->post('arr_acreg'))),
                        'arr_origin' => trim(strtoupper($this->input->post('arr_origin'))),
                        'arr_destination' => trim(strtoupper($this->input->post('arr_destination'))),
                        'arr_sta' => $arr_sta, 
                        'arr_status' => 'OPERATED',
                        'arr_source' => 'Manual Season',
                        'arr_user_created' => $this->session->userdata('id_usr'),
                        'arr_last_update' => $datenow,
                    );

                    // check if arr_id exists
                    $existing = $this->m_seasonarrival->check_arr_id_exists($arr_id); 
                    if ($existing) {
                        // update existing record
                        $this->m_seasonarrival->edit($arr_id, $data);
                        $this->session->set_flashdata('pesan', 'Data updated successfully');
                    } else {
                        // insert new record
                        $data['arr_id'] = $arr_id;
                        $this->m_seasonarrival->simpan($data);
                        $this->session->set_flashdata('pesan', 'Data saved successfully');
                    }
                } else {
                    $dates[] = $date->format('Y-m-d').'-'.$date->format('l').'-no insert';
                }
                
            }

            // return $dates;
            
            // $data = array(
            //     'title' => 'Season Schedule Arrival',
            //     'isi' => 'seasonarrival/v_dataseasonarrival'
            // );
            // $this->load->view('admin-layout/v_wrapper', $data, FALSE);
            redirect('seasonarrival');

        }
    }

    public function generate_season_excel() {
		// path directory/folder untuk menyimpan file xls yang di upload
		$path = './assets/upload/excel-import/';

        $config['upload_path'] 		= $path;		
		$config['allowed_types'] 	= 'xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		// $config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		// $this->load->library('upload', $config);
        $this->upload->initialize($config);
 
		// memanggil fungsi upload_config() untuk inisialisasi fungsi upload
		// $this->upload_config($path);
        
		if (!$this->upload->do_upload('file')) {
			// jika proses upload gagal, set flash message error lalu redirect ke halaman form
			$this->session->set_flashdata('pesan', $this->upload->display_errors());
			redirect('/seasonarrival');
		} else {
			// get data file yang di upload
			$file_data 	= $this->upload->data();
			// get full path hingga ke filename
			$file_name 	= $path.$file_data['file_name'];
			// proses untuk get extension file
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			// cek dan validasi jika file yang di upload ber ekstensi xlsx
			if($extension == 'xlsx') {
				 // jika file xlsx, buat object reader xlsx.
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			} else {
				// jika salah, set flash message error lalu redirect ke halaman form
				$this->session->set_flashdata('pesan',array(
                        'class' => 'warning',
                        'message' => 'Only allowed file types .xlsx'
                    )
                );				
				redirect('/seasonarrival');
			}
			// proses extrac data yang ada pada file xlsx
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
			$list 			= [];
			foreach($sheet_data as $key => $val) {
                if($key != 0) {
                    // validate minimum required columns exist to prevent undefined index errors
                    if (!isset($val[0], $val[1], $val[2], $val[3], $val[4], $val[7]) || empty($val[0]) || empty($val[7])) {
                        // skip this row if critical data is missing
                        continue;
                    }

                    $dates = [];
                    for ($i = 6; $i <= 12; $i++) {
                        if ($val[$i] == 'Y' && $i == 6) {
                            array_push($dates, 'Monday');
                        } elseif ($val[$i] == 'Y' && $i == 7) {
                            array_push($dates, 'Tuesday');
                        } elseif ($val[$i] == 'Y' && $i == 8) {
                            array_push($dates, 'Wednesday');
                        } elseif ($val[$i] == 'Y' && $i == 9) {
                            array_push($dates, 'Thursday');
                        } elseif ($val[$i] == 'Y' && $i == 10) {
                            array_push($dates, 'Friday');
                        } elseif ($val[$i] == 'Y' && $i == 11) {
                            array_push($dates, 'Saturday');
                        } elseif ($val[$i] == 'Y' && $i == 12) {
                            array_push($dates, 'Sunday');
                        }
                    }

					// cek supaya tidak ada duplikasi data
					// $result = $this->manage_spreadsheet_model->get(array("isbn" => $val[5]));
					// if($result == FALSE || empty($result)) {
						// $list [] = [
						// 	'arr_flightno' => $val[0], 
						// 	'arr_actype' => $val[1], 
						// 	'arr_acreg' => $val[2], 
                        //     'arr_sta' => $val[3], 
                        //     'arr_origin' => $val[4], 
                        //     'arr_destination' => $val[5],
                        //     'dates' => $dates,
						// ];
					// } 

                    $start_date = $this->input->post('arr_start_date_excel');
                    $end_date = $this->input->post('arr_end_date_excel');

                    $startDate = new DateTime($start_date);
                    $endDate = new DateTime($end_date);
                    $endDate->modify('+1 day'); 

                    $period = new DatePeriod(
                        $startDate,
                        new DateInterval('P1D'),
                        $endDate
                    );

                    // $dates = [];
                    // check in_array is array
                    $arr_dates = $dates;
                    if (!is_array($arr_dates)) {
                        $arr_dates = []; 
                    }
                    // next for looping per airlines data from excel
                    // foreach ($airlines) ...
                    foreach ($period as $date) {
                        if (in_array($date->format('l'), $arr_dates)) {
                            $dates2[] = $val[0].'-'.$date->format('Y-m-d').'-'.$date->format('l').'-insert';
                            
                            // saved data 
                            $arr_id = trim(strtoupper($val[0])).str_replace('-', '', $date->format('Y-m-d'));

                            $arr_dop = $date->format('l');
                            
                            $arr_sta_format = new DateTime($date->format('Y-m-d').''.$val[3]);
                            $arr_sta = $arr_sta_format->format('Y-m-d H:i:s');

                            date_default_timezone_set('Asia/Jakarta');
                            $datenow = date('Y-m-d H:i:s');

                            $data = array(
                                // 'arr_id' => $arr_id,
                                'arr_dop' => $arr_dop,
                                'arr_season' => $this->input->post('arr_season_excel'),
                                'arr_flightkey'  => preg_replace('/[^A-Za-z0-9]/', '', strtoupper(substr(trim($val[0]), 0, 2) . trim($val[5]))),
                                'arr_flightno' => trim(strtoupper($val[0])),
                                'arr_actype' => trim(strtoupper($val[1])),
                                'arr_acreg' => trim(strtoupper($val[2])),
                                'arr_origin' => trim(strtoupper($val[4])),
                                'arr_destination' => trim(strtoupper($val[5])),
                                'arr_sta' => $arr_sta, 
                                'arr_status' => 'OPERATED',
                                'arr_source' => 'Excel Season - '.$file_data['file_name'],
                                'arr_user_created' => $this->session->userdata('id_usr'),
                                'arr_last_update' => $datenow,
                            );

                            // check if arr_id exists
                            $existing = $this->m_seasonarrival->check_arr_id_exists($arr_id); 
                            if ($existing) {
                                // update existing record
                                $this->m_seasonarrival->edit($arr_id, $data);
                                $this->session->set_flashdata('pesan', 'Data updated successfully');
                            } else {
                                // insert new record
                                $data['arr_id'] = $arr_id;
                                $this->m_seasonarrival->simpan($data);
                                $this->session->set_flashdata('pesan', 'Data saved successfully');
                            }
                        }else {
                            $dates2[] = $val[0].'-'.$date->format('Y-m-d').'-'.$date->format('l').'-no insert';
                        }
                    }
                            
				}
			}

            // echo "<pre>";
            // print_r($list);
            // print_r($dates2);
            // echo "</pre>";die();

			// if(file_exists($file_name))
			// 	// hapus kembali file, supaya tidak memenuhi server
			// 	unlink($file_name);
		}
		redirect('seasonarrival');
	}
}
