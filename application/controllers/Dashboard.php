<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dashboard'); 
        $this->load->model('m_seasonpairing'); 
        $this->user_login->cek_login(); // validasi url agar cek login dulu
    }

    public function index()
    {
        $id_sts = $this->session->userdata('id_sts');
        $data['title'] = 'Dashboard';
        $data['isi'] = 'dashboard/v_dashboard';
        $data['seasonpairing'] = $this->m_seasonpairing->tampil($id_sts); 

        $data['totalflightdailypair'] = $this->m_dashboard->gettotalflightdailypair($id_sts);
        $data['totalflightdailyarr'] = $this->m_dashboard->gettotalflightdailyarr($id_sts);
        $data['totalflightdailydep'] = $this->m_dashboard->gettotalflightdailydep($id_sts);
        $data['totalflightdailycancel'] = $this->m_dashboard->gettotalflightdailycancel($id_sts);
        
        // flight donut
        // $data['SQ'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'SQ');
        // $data['MH'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'MH');
        // $data['NH'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'NH');
        // $data['SV'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'SV');
        // $data['CX'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'CX');
        // $data['QR'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'QR');
        // $data['BR'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'BR');
        // $data['MU'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'MU');
        // $data['3K'] = $this->m_dashboard->getflightdonutdaily($id_sts, '3K');
        // $data['EK'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'EK');
        // $data['EY'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'EY');
        // $data['PR'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'PR');
        // $data['TK'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'TK');
        // $data['QF'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'QF');
        // $data['OZ'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'OZ');
        // $data['QR'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'QR');
        // $data['5J'] = $this->m_dashboard->getflightdonutdaily($id_sts, '5J');
        // $data['WY'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'WY');
        // $data['8K'] = $this->m_dashboard->getflightdonutdaily($id_sts, '8K');
        // $data['JX'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'JX');
        // $data['AK'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'AK');
        // $data['QZ'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'QZ');
        // $data['QF'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'QF');
        // $data['8K'] = $this->m_dashboard->getflightdonutdaily($id_sts, '8K');
        // $data['8B'] = $this->m_dashboard->getflightdonutdaily($id_sts, '8B');
        // $data['IN'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'IN');
        // $data['FS'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'FS');
        // $data['JQ'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'JQ');
        // $data['NZ'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'NZ');
        // $data['FD'] = $this->m_dashboard->getflightdonutdaily($id_sts, 'FD');
        // $data['all_code'] = [$data['SQ'],$data['MH'],$data['NH'],$data['SV'],$data['CX']
        //                     ,$data['QR'],$data['BR'],$data['MU'],$data['3K'],$data['EK']
        //                     ,$data['EY'],$data['PR'],$data['TK'],$data['QF'],$data['OZ']
        //                     ,$data['QR'],$data['5J'],$data['WY'],$data['8K'],$data['JX']
        //                     ,$data['AK'],$data['QZ'],$data['QF'],$data['8K'],$data['8B']
        //                     ,$data['IN'],$data['FS'],$data['JQ'],$data['NZ'],$data['FD']];

        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }
}
